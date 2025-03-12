<?php

namespace App\Libraries;

// use App\Controllers\Resources\MemberStatementsResource;
use App\Models\AccountsAdminModel;
use App\Models\BanklistModel;
use App\Models\GamblingHistorieModel;
use App\Models\GameRuleModel;
use App\Models\GroupLiveCardOpenModel;
use App\Models\GroupLiveModel;
use App\Models\GroupMemberListModel;
use App\Models\GroupModel;
use App\Models\MembersModel;
use App\Models\MemberStatementModel;
use Exception;
// use GuzzleHttp\Handler\CurlHandler;
// use GuzzleHttp\HandlerStack;
// use GuzzleHttp\Middleware;
// use LINE\Clients\MessagingApi\Api\MessagingApiApi;
// use LINE\Webhook\Model\MessageContent;
// use \LINE\Clients\MessagingApi\Model\TextMessage;
// use \LINE\Clients\MessagingApi\Model\ReplyMessageRequest;
use \GuzzleHttp\Client;
use \LINE\Clients\MessagingApi\Configuration;
use \LINE\Clients\MessagingApi\Api;
// use LINE\Clients\MessagingApi\Model\PushMessageRequest;
use \LINE\Constants\MessageType;
// use LINE\Webhook\Test\Model\ContentProviderTest;

class MessageKeyLibrarie
{
    private $channelAccessToken;
    private $channelSecret;
    private $messagingApi;
    function __construct()
    {
        $this->channelAccessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');
        $this->channelSecret = getenv('LINE_CHANNEL_SECRET');


        $client = new Client();
        $config = new Configuration();
        $config->setAccessToken($this->channelAccessToken);
        $this->messagingApi = new Api\MessagingApiApi(
            client: $client,
            config: $config,
        );

    }

    public function userTypeText($events)
    {

        if (!isset($events['message']['text'])) {
            return FALSE;
        }

        $text = strtolower($events['message']['text']);

        $userId = $events['source']['userId'];
        $Profile = $this->messagingApi->getProfile(userId: $userId);

        $language = !is_null($Profile->getLanguage()) ? $Profile->getLanguage() : "en";
        \Config\Services::language()->setLocale($language);


        // return $text;
        if (str_contains($text, 'rf-')) {
            // ผูกเอเย่ต์
            // return $text;
            return $this->addAgent($events, $Profile);
        }

        switch ($text) {
            case 'บช':
                return $this->bank($events);
            // case 'ลงทะเบียน':
            //     return $this->resgister($events);
            // case 'help':
            //     return $this->help($events);
            default:
                return;
        }
    }
    public function groupTypeText($events)
    {
        if (!isset($events['message']['text'])) {
            return FALSE;
        }
        $text = strtolower($events['message']['text']);

        switch ($text) {
            case 'บช':
                return $this->bank($events);
            case 'help':
                return $this->help($events);
            case 'วิธีเล่น':
                return $this->help($events);
            case 'rule':
                return $this->rule($events);
            case 'กติกา':
                return $this->rule($events);
            // case 'เข้าร่วม':
            //     return $this->joinGroup($events);
            default:
                return FALSE;
        }
    }

    public function groupTypeTextGame($events)
    {
        $text = $events['message']['text'];
        $TExplode = explode("/", $text);
        $grKeyLine = intval($TExplode[0]);
        $money_push = floatval($TExplode[1]);

        $groupId = $events['source']['groupId'];
        $userId = $events['source']['userId'];
        $timestamp = $events['timestamp'];
        $deliveryContext = $events['deliveryContext'];
        $isRedelivery = $deliveryContext['isRedelivery'];

        $LineMessagingApi = new LineMessagingApi();
        $GamblingHistorieModel = new GamblingHistorieModel();
        $MembersModel = new MembersModel();
        // $GroupMemberListModel  = new GroupMemberListModel();
        $GroupModel = new GroupModel();
        $GameRuleModel = new GameRuleModel();



        if (!isset($events['message']['text'])) {
            return TRUE;
        }


        $memberRow = $MembersModel
            ->select("userId,user_remain,displayName,user_id")
            ->where("userId", $userId)
            ->first();
        if (empty($memberRow) || is_null($memberRow)) {
            $Profile = $this->messagingApi->getGroupMemberProfile($groupId, $userId);
            $replyToken = $events['replyToken'];
            $message = [
                [
                    'type' => 'text',
                    'text' => 'TO : ' . $Profile->getDisplayName() . "\nยังไม่สมัครสมาชิกและผูกบัญชี\nคลิกลิงก์ :\n" . base_url()
                ]
            ];

            $LineMessagingApi->replyMessage($replyToken, $message);
        }

        $user_id = $memberRow->user_id;
        $countGamb = $GamblingHistorieModel
            ->select("gamb_ID,isRedelivery")
            ->where("user_id", $user_id)
            ->where("gamb_text", $text)
            ->where("timestamp", $timestamp)
            ->first();

        if (!empty($countGamb)) {
            return $GamblingHistorieModel->update($countGamb->gamb_ID, [
                "isRedelivery" => $isRedelivery,
            ]);
        }

        $groupRow = $GroupModel->find($groupId);

        $MemberDisplayName = $memberRow->displayName;

        $this->loadLanguage($groupRow->group_language ?? "th");

        $gameRuleRow = $GameRuleModel
            ->where("msID", $groupRow->msID)
            ->where("grKeyLine", $grKeyLine)
            ->first();

        if (empty($gameRuleRow)) {
            return $this->sendMessage($events, [
                [
                    "type" => "text",
                    "text" => lang('line.error.empty.keyWord', ["name" => $MemberDisplayName])
                ],
            ]);
        }

        if (!is_numeric($money_push)) {
            return $this->sendMessage($events, [
                [
                    "type" => "text",
                    "text" => lang('line.error.empty.is_numeric', ["name" => $MemberDisplayName])
                ],
            ]);
        }

        try {
            $money_push = floatval($money_push);
            if ($money_push <= 49) {
                return $this->sendMessage($events, [
                    [
                        "type" => "text",
                        "text" => lang('line.error.empty.money0', ["name" => $MemberDisplayName])
                    ],
                ]);
            }
        } catch (Exception $e) {
            return $this->sendMessage($events, [
                [
                    "type" => "text",
                    "text" => lang('line.error.empty.is_numeric', ["name" => $MemberDisplayName])
                ],
            ]);
        }


        $GroupLiveModel = new GroupLiveModel();
        $groupLiveRow = $GroupLiveModel
            ->where("groupId", $groupId)
            ->where("statusCloseLive", '0')
            ->first();

        if (empty($groupLiveRow)) {
            return $this->sendMessage($events, [
                [
                    "type" => "text",
                    "text" => lang('line.error.empty.liveClose', ["name" => $MemberDisplayName])
                ],
            ]);
        }

        $GroupLiveCardOpenModel = new GroupLiveCardOpenModel();
        $LiveOpenCard = $GroupLiveCardOpenModel
            ->where("groupLive_ID", $groupLiveRow->groupLive_ID)
            ->where("groupId", $groupId)
            ->where("status_id", '7')
            ->first();

        if (empty($LiveOpenCard)) {
            return $this->sendMessage($events, [
                [
                    "type" => "text",
                    "text" => lang('line.error.empty.liveOpenCard', ["name" => $MemberDisplayName])
                ],
            ]);
        }

        if ($LiveOpenCard->GLCO_STEP == 3) {
            return $this->sendMessage($events, [
                [
                    "type" => "text",
                    "text" => lang('line.error.stopOpenCard', ["name" => $MemberDisplayName, "count" => $LiveOpenCard->glco_count])
                ],
            ]);
        }

        $user_remain = floatval($memberRow->user_remain) - $money_push;
        if ($user_remain < 0) {
            return $this->sendMessage($events, [
                [
                    "type" => "text",
                    "text" => lang('line.error.empty.remain', ["name" => $MemberDisplayName, "money" => floatval($memberRow->user_remain)])
                ],
            ]);
        }


        $MemberStatementModel = new MemberStatementModel();
        $glco_multiply = $gameRuleRow->grMultiply;

        $GHistorieInsert = [
            "user_id" => $user_id,
            "glco_ID" => $LiveOpenCard->glco_ID,
            "groupLive_ID" => $groupLiveRow->groupLive_ID,
            "msID" => $groupLiveRow->msID,
            "groupId" => $groupId,
            "grId" => $gameRuleRow->grId,
            "glco_quantity" => $money_push,
            "timestamp" => $events['timestamp'],
            "gamb_text" => $text,
            "isRedelivery" => $isRedelivery,
            "glco_multiply" => $glco_multiply,
        ];


        $GamblingHistorieModel->save($GHistorieInsert);
        $gamb_ID = $GamblingHistorieModel->getInsertID();


        $TempLineMessage = new TempLineMessage("Admin");
        $getGambling = $TempLineMessage->getGambling(
            $user_id,
            $groupLiveRow->groupLive_ID,
            $LiveOpenCard->glco_ID,
            $gamb_ID,
            $MemberDisplayName,
            $user_remain,
            $LiveOpenCard->glco_count,
            $LiveOpenCard->created_at
        );

        $resp_sendMessage = $this->sendMessage($events, [$getGambling]);

        if ($resp_sendMessage === FALSE) {
            $GamblingHistorieModel->delete($gamb_ID);
            return FALSE;
        }

        $StatementInsert = [
            "user_id" => $user_id,
            "statement_IN" => 0,
            "statement_OUT" => 1,
            "status_id" => 9,
            "statement_note" => 'group line add',
            "statement_remain" => $user_remain,
            "money_out" => $money_push,
            "money_incoming" => NULL,
            'ac_code' => SYS_CODE ?? NULL,
            "statement_slip" => NULL,
            "blit_id" => SYS_BANK ?? NULL,
            "gamb_ID" => $gamb_ID,
        ];

        try {
            $MemberStatementModel->save($StatementInsert);
        } catch (Exception $e) {
            log_message('error', "StatementInsert :" . $e->getMessage());
            return FALSE;
        }

        $MembersModel->update($user_id, [
            "user_remain" => $user_remain,
        ]);
        return $resp_sendMessage;
    }



    public function resgister($events)
    {
        // return;
        $MessageLineApiLibraie = new MessageLineApiLibraie();
        $MessageLineApiLibraie->usersTypeFollow($events);
    }
    public function help($events)
    {
        if (!isset($events['source']['groupId'])) {
            return FALSE;
        }

        // $replyToken = $events['replyToken'];
        $groupId = $events['source']['groupId'];

        $g = new GroupModel();
        $_row = $g->find($groupId);

        if (empty($_row)) {
            return FALSE;
        }

        $this->loadLanguage($_row->group_language ?? "th");
        $TempLineMessage = new TempLineMessage("Help");

        $MessHow = $TempLineMessage->getHowToPlay($_row->msID);
        return $this->sendMessage($events, [$MessHow]);
    }
    public function rule($events)
    {
        if (!isset($events['source']['groupId'])) {
            return FALSE;
        }
        $groupId = $events['source']['groupId'];

        $g = new GroupModel();
        $_row = $g->find($groupId);

        if (empty($_row)) {
            return FALSE;
        }
        $language = $this->loadLanguage($_row->group_language ?? "th");
        $TempLineMessage = new TempLineMessage("Help");
        $MessHow = $TempLineMessage->getRulesForPlay($_row->msID);
        return $this->sendMessage($events, [$MessHow]);
    }

    public function joinGroup($events)
    {

        $MembersModel = new MembersModel();
        $groupId = $events['source']['groupId'];
        $userId = $events['source']['userId'];

        $rowMember = $MembersModel->find($userId);
        // เพิ่ม user in server
        $Profile = $this->messagingApi->getGroupMemberProfile($groupId, $userId);
        if (empty($rowMember)) {
            $MembersModel->save([
                "userId" => $userId,
                "displayName" => $Profile->getDisplayName(),
                "pictureUrl" => $Profile->getPictureUrl(),
            ]);
        } else {
            $MembersModel->update($rowMember->userId, [
                "userId" => $userId,
                "displayName" => $Profile->getDisplayName(),
                "pictureUrl" => $Profile->getPictureUrl(),
            ]);
        }
        // เพิ่มรายชื่อที่อยู่ ในห้อง
        $GroupMemberListModel = new GroupMemberListModel();
        $groupMemberListModelRow = $GroupMemberListModel
            ->where("userId", $userId)
            ->where("groupId", $groupId)->first();

        if (empty($groupMemberListModelRow)) {
            $GroupMemberListModel->save([
                "userId" => $userId,
                "groupId" => $groupId,
                "listDelete" => 0,
            ]);
        } else {
            $GroupMemberListModel->update($groupMemberListModelRow->listId, [
                "userId" => $userId,
                "groupId" => $groupId,
                "listDelete" => 0,
            ]);
        }

        return TRUE;
    }

    public function addAgent($events, $Profile)
    {
        $text = $events['message']['text'];
        $userId = $events['source']['userId'];

        $ac_code = str_replace("rf-", '', $text);



        $AccountsAdminModel = new AccountsAdminModel();
        $acc_row = $AccountsAdminModel
            ->select("ac_id")
            ->where("ac_code", $ac_code)
            ->first();

        if (empty($acc_row)) {
            $this->sendMessageFormWeb($userId, [
                [
                    'type' => MessageType::TEXT,
                    'text' => lang("line.error.empty.bindagent"),
                ]
            ]);
        }

        $MembersModel = new MembersModel();
        $member_row = $MembersModel->find($userId);

        // return $member_row;

        if (empty($member_row)) {
            $this->sendMessageFormWeb($userId, [
                [
                    'type' => MessageType::TEXT,
                    'text' => lang("line.error.empty.member", ["name" => $Profile->getDisplayName()]),
                ]
            ]);
        }
        if (!is_null($member_row->user_agent)) {
            $this->sendMessageFormWeb($userId, [
                [
                    'type' => MessageType::TEXT,
                    'text' => lang("line.error.empty.bindagentNotEmpty", ["name" => $Profile->getDisplayName()]),
                ]
            ]);
        }

        // return [55];

        // try {
        $MembersModel->update($userId, [
            "user_agent" => $ac_code,
        ]);

        return $this->sendMessageFormWeb($userId, [
            [
                'type' => MessageType::TEXT,
                'text' => lang("line.text.bindagent"),
            ]
        ]);
        // } catch (Exception $e) {
        //     return $e->getMessage();
        // }
    }
    public function bank($events)
    {

        $TempLineMessage = new TempLineMessage("Account");
        $BanklistModel = new BanklistModel();
        $BankAll = $BanklistModel
            ->where("banklists.blit_id !=", SYS_BANK)
            ->join("banks", "banks.bank_id = banklists.bank_id", "inner")
            ->findAll();

        if (empty($BankAll)) {
            return "Empty Banks";
        }

        $index = rand(0, count($BankAll) - 1);
        $Row = $BankAll[$index];

        $TempBank = $TempLineMessage->getTempBank($Row->blit_number, $Row->bank_name, $Row->blit_name, base_url("image?img=") . $Row->blit_image);
        return $this->sendMessage($events, [$TempBank]);
    }

    // public function sendMessage( $events, $message = [] )
    // {
    //     if ( !isset ( $events[ 'replyToken' ] ) ) {
    //         // return $this->log("log.json", "Not is replyToken");
    //         log_message ( "error", "empty replyToken" );
    //     }

    //     $replyToken = $events[ 'replyToken' ];
    //     $request    = new ReplyMessageRequest( [ 
    //         // ฟังก์ชั่นส่งข้อความ
    //         'replyToken' => $replyToken,
    //         'messages'   => $message,
    //         // "loadingSeconds" => 5,
    //     ] );
    //     try {
    //         return $this->messagingApi->replyMessage ( $request );
    //     } catch ( Exception $e ) {
    //         // $this->log("log.json", $e->getMessage());
    //         log_message ( "error", $e->getMessage () );
    //         return FALSE;
    //     }
    // }


    // public function sendMessage( $events, $message = [] )
    // {
    //     if ( !$this->messagingApi ) {
    //         log_message ( "error", "MessagingApiApi is not initialized" );
    //         return FALSE;
    //     }
    //     if ( !is_array ( $events ) || !isset ( $events[ 'replyToken' ] ) ) {
    //         log_message ( "error", "Invalid or missing replyToken in events: " . json_encode ( $events ) );
    //         return FALSE;
    //     }

    //     $replyToken = $events[ 'replyToken' ];
    //     if ( empty ( $message ) || !is_array ( $message ) || !isset ( $message[ 0 ][ 'type' ] ) ) {
    //         log_message ( "warning", "Invalid or empty message, using default: " . json_encode ( $message ) );
    //         $message = [ [ 'type' => 'text', 'text' => 'Hello! How can I assist you?' ] ];
    //     }

    //     try {
    //         $request  = new ReplyMessageRequest( [ 
    //             'replyToken' => $replyToken,
    //             'messages'   => $message,
    //         ] );
    //         $response = $this->messagingApi->replyMessage ( $request );
    //         log_message ( "debug", "Message sent successfully with replyToken: $replyToken" );
    //         return $response;
    //     } catch ( \LINE\Clients\MessagingApi\ApiException $e ) {
    //         log_message ( "error", "Failed to send message with replyToken $replyToken: " . $e->getMessage () );
    //         return FALSE;
    //     }
    // }

    private function replyMessage($channel_access_token, $reply_token, $messages)
    {
        // URL สำหรับ reply message
        $url = 'https://api.line.me/v2/bot/message/reply';

        // ตั้งค่า header
        $header = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $channel_access_token
        ];

        // ข้อมูลที่จะส่ง (payload)
        $data = [
            'replyToken' => $reply_token,
            'messages' => $messages
        ];

        // เริ่มต้น cURL
        $request = curl_init($url);

        // ตั้งค่า User-Agent
        $user_agent = sprintf(
            'CWTH777k-GKF1/%s (PHP/%s; LINE-Bot-SDK/%s)',
            '1.0',          // App version
            PHP_VERSION,    // PHP version (เช่น 8.1.2)
            '8.3'           // LINE Bot SDK version
        );
        $header = array_merge(['User-Agent: ' . $user_agent], $header);
        curl_setopt($request, CURLOPT_HTTPHEADER, $header);

        // การตั้งค่า cURL
        curl_setopt($request, CURLOPT_RETURNTRANSFER, TRUE); // คืนค่าเป็น string
        curl_setopt($request, CURLOPT_FOLLOWLOCATION, FALSE); // ปิดการตาม redirect
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, TRUE); // ตรวจสอบ SSL
        curl_setopt($request, CURLOPT_SSL_VERIFYHOST, 2); // ตรวจสอบ hostname
        curl_setopt($request, CURLOPT_CAINFO, '/etc/ssl/certs/ca-certificates.crt'); // CA bundle
        curl_setopt($request, CURLOPT_CONNECTTIMEOUT, 120); // Timeout การเชื่อมต่อ
        curl_setopt($request, CURLOPT_TIMEOUT, 60); // Timeout รวม
        curl_setopt($request, CURLOPT_VERBOSE, TRUE); // สำหรับ debug (-v)
        curl_setopt($request, CURLOPT_HEADER, TRUE); // รวม header ในผลลัพธ์
        curl_setopt($request, CURLOPT_TCP_FASTOPEN, TRUE); // เพิ่มความเร็ว
        curl_setopt($request, CURLOPT_FAILONERROR, TRUE); // หยุดถ้า HTTP error


        // curl_setopt($request, CURLOPT_PROXY, "119.59.103.159:8083");  // PROXY details with port // Use if proxy have username and password
        // curl_setopt($request, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5); // If expected to call with specific PROXY type


        // ตั้งค่า POST และข้อมูล JSON
        curl_setopt($request, CURLOPT_POST, TRUE);
        curl_setopt($request, CURLOPT_POSTFIELDS, json_encode($data));

        // ส่งคำขอด้วย retry mechanism
        $max_retries = 10;
        $retry_count = 0;
        $response = FALSE;

        while ($retry_count < $max_retries && $response === FALSE) {
            $response = curl_exec($request);
            if ($response === FALSE) {
                $retry_count++;
                $error = curl_error($request);
                $errno = curl_errno($request);
                log_message('warning', "ลองครั้งที่ $retry_count ล้มเหลว: [$errno] $error");
                sleep(1);
            }
        }

        // ตรวจสอบข้อผิดพลาดหลัง retry
        if ($response === FALSE) {
            $info = curl_getinfo($request);
            curl_close($request);
            log_message('error', "ข้อผิดพลาด cURL หลัง retry: [$errno] $error | SSL Verify Result: {$info['ssl_verify_result']} | ข้อมูล: " . json_encode($info));
            return FALSE;
        }

        // แยก header และ body
        $header_size = curl_getinfo($request, CURLINFO_HEADER_SIZE);
        $http_code = curl_getinfo($request, CURLINFO_HTTP_CODE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        $total_time = curl_getinfo($request, CURLINFO_TOTAL_TIME);
        curl_close($request);

        // บันทึก log
        log_message('info', "รหัส HTTP: $http_code | เวลาที่ใช้: {$total_time} วินาที | Header: $header | Body: $body");

        // ตรวจสอบสถานะ HTTP
        if ($http_code !== 200) {
            log_message('error', "ข้อผิดพลาด API: HTTP $http_code - $body");
            return FALSE;
        }

        // คืนค่า body (สำหรับ reply API ปกติจะเป็น empty string ถ้าสำเร็จ)
        return $body;
    }



    private function pushMessageWithRetryKey($channel_access_token, $to, $messages, $retry_key = NULL)
    {
        // URL สำหรับ push message
        $url = 'https://api.line.me/v2/bot/message/push';

        // สร้าง X-Line-Retry-Key ถ้าไม่ระบุมา
        if ($retry_key === NULL) {
            $data = random_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // version 4
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // variant
            $retry_key = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        }

        // ตั้งค่า header
        $header = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $channel_access_token,
            'X-Line-Retry-Key: ' . $retry_key
        ];

        // ข้อมูลที่จะส่ง (payload)
        $data = [
            'to' => $to,
            'messages' => $messages
        ];

        // เริ่มต้น cURL
        $request = curl_init($url);

        // ตั้งค่า User-Agent
        $user_agent = sprintf(
            'CWTH777k-GKF1/%s (PHP/%s; LINE-Bot-SDK/%s)',
            '1.0',
            PHP_VERSION,
            '8.3'
        );
        $header = array_merge(['User-Agent: ' . $user_agent], $header);
        curl_setopt($request, CURLOPT_HTTPHEADER, $header);

        // การตั้งค่า cURL
        curl_setopt($request, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($request, CURLOPT_FOLLOWLOCATION, FALSE);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($request, CURLOPT_SSL_VERIFYHOST, 2);
        // curl_setopt ( $request, CURLOPT_CAINFO, '/etc/ssl/certs/ca-certificates.crt' );
        curl_setopt($request, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($request, CURLOPT_TIMEOUT, 60);
        curl_setopt($request, CURLOPT_VERBOSE, TRUE);
        curl_setopt($request, CURLOPT_HEADER, TRUE);
        curl_setopt($request, CURLOPT_TCP_FASTOPEN, TRUE);
        curl_setopt($request, CURLOPT_FAILONERROR, TRUE);

        // ตั้งค่า POST และข้อมูล JSON
        curl_setopt($request, CURLOPT_POST, TRUE);
        curl_setopt($request, CURLOPT_POSTFIELDS, json_encode($data));

        // ส่งคำขอด้วย retry mechanism
        $max_retries = 3;
        $retry_count = 0;
        $response = FALSE;

        while ($retry_count < $max_retries && $response === FALSE) {
            $response = curl_exec($request);
            if ($response === FALSE) {
                $retry_count++;
                $error = curl_error($request);
                $errno = curl_errno($request);
                log_message('warning', "ลองครั้งที่ $retry_count ล้มเหลว: [$errno] $error");
                sleep(1);
            }
        }

        // ตรวจสอบข้อผิดพลาดหลัง retry
        if ($response === FALSE) {
            $info = curl_getinfo($request);
            curl_close($request);
            log_message('error', "ข้อผิดพลาด cURL หลัง retry: [$errno] $error | SSL Verify Result: {$info['ssl_verify_result']} | ข้อมูล: " . json_encode($info));
            return FALSE;
        }

        // แยก header และ body
        $header_size = curl_getinfo($request, CURLINFO_HEADER_SIZE);
        $http_code = curl_getinfo($request, CURLINFO_HTTP_CODE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        $total_time = curl_getinfo($request, CURLINFO_TOTAL_TIME);
        curl_close($request);

        // บันทึก log
        log_message('info', "รหัส HTTP: $http_code | เวลาที่ใช้: {$total_time} วินาที | Header: $header | Body: $body");

        // ตรวจสอบสถานะ HTTP
        if ($http_code !== 200) {
            log_message('error', "ข้อผิดพลาด API: HTTP $http_code - $body");
            return FALSE;
        }

        return $body;
    }

    public function sendMessage($events, $message = [])
    {
        if (!is_array($events) || !isset($events['replyToken'])) {
            log_message("error", "Invalid or missing replyToken in events: " . json_encode($events));
            return FALSE;
        }

        $replyToken = $events['replyToken'];
        // ถ้า $message ว่าง ให้ใช้ข้อความเริ่มต้น
        if (empty($message)) {
            log_message("warning", "No message provided, using default message");
            $message = [['type' => 'text', 'text' => 'Hello! How can I assist you?']];
        }
        return (new LineMessagingApi())->replyMessage($replyToken, $message);
    }


    public function sendMessageFormWeb($eventsTo, $message = [])
    {

        return (new LineMessagingApi())->pushMessage($eventsTo, $message);
        // return $this->pushMessageWithRetryKey(ACCESS_TOKEN, $eventsTo, $message);

        // $replyToken = $events['replyToken'];
        // $request = new PushMessageRequest( [ 
        //     'to'       => $eventsTo,
        //     'messages' => $message
        // ] );
        // try {
        //     return $this->messagingApi->pushMessage ( $request );
        // } catch ( Exception $e ) {
        //     log_message ( "error", $e->getMessage () );
        //     return FALSE;
        // }
    }

    public function loadLanguage($Locale = "en")
    {
        $language = \Config\Services::language($Locale);
        $language->setLocale($Locale);
        return $language->getLocale();
    }
}
