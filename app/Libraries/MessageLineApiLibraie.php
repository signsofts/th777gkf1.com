<?php

namespace App\Libraries;

use App\Models\GroupMemberListModel;
use App\Models\GroupModel;
use App\Models\MembersModel;
// use LINE\Webhook\Model\MessageContent;
// use \LINE\Clients\MessagingApi\Model\TextMessage;
// use \LINE\Clients\MessagingApi\Model\ReplyMessageRequest;
use \GuzzleHttp\Client;
use \LINE\Clients\MessagingApi\Configuration;
use \LINE\Clients\MessagingApi\Api;
// use \LINE\Constants\MessageType;
// use LINE\Webhook\Test\Model\ContentProviderTest;

class MessageLineApiLibraie
{

    private $accessToken;
    private $messagingApi;
    private $channelAccessToken;
    function __construct()
    {
        $this->channelAccessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');
        // $this->channelSecret      = getenv ( 'LINE_CHANNEL_SECRET' );

        $client = new Client();
        $config = new Configuration();
        $config->setAccessToken($this->channelAccessToken);
        $this->messagingApi = new Api\MessagingApiApi(
            client: $client,
            config: $config,
        );
    }

    public function MessageRequest($events)
    {
        $temp = [];
        foreach ($events->events as $evenk => $even):
            // $type = $even['type'];
            $sourceType = $even['source']['type'];
            switch ($sourceType) {
                case 'group':
                    #แชทภายในกลุ่ม
                    $return = $this->sourceTypeGroups($even);
                    array_push($temp, $return);
                    break;
                case 'user':
                    # แชทส่วนตัว
                    $return = $this->sourceTypeUsers($even);
                    array_push($temp, $return);
                    break;
                default:
                    return FALSE;
            }
        endforeach;

        return $temp;
    }

    private function groupsTypeMessage($events)
    {
        $MessageKeyLibrarie = new MessageKeyLibrarie();
        $type = $events['message']['type'];
        switch ($type) {
            case 'text':
                if (!isset($events['message']['text'])) {
                    return TRUE;
                }
                $text = $events['message']['text'];
                $ExText = explode("/", $text);

                if (count($ExText) == 1) {
                    return $MessageKeyLibrarie->groupTypeText($events);
                } else if (count($ExText) == 2) {
                    return $MessageKeyLibrarie->groupTypeTextGame($events);
                }
            case "sticker":
                return FALSE;
            default:
                return FALSE;
        }
    }
    private function groupsTypeJoin($events)
    {
        $GroupModel = new GroupModel();

        $LineMessagingApi = new LineMessagingApi();
        $type = $events['type'];
        $groupId = $events['source']['groupId'];

        $groupRow = $GroupModel->find($groupId);

        // log_message("info", "groupRow" . json_encode($groupRow));

        if (is_null($groupRow)) {
            $GroupSummary = $LineMessagingApi->getGroupSummary($groupId);

            // log_message("info", "getGroupSummary" . json_encode($GroupSummary));

            // $this->log('events.json', $groupRow);   

            // $this->log('acclog.json', $GroupSummary);
            $GroupModel->save([
                "groupId" => $GroupSummary['groupId'],
                "groupName" => $GroupSummary['groupName'],
                "pictureUrl" => $GroupSummary['pictureUrl'],
                "groupDelete" => "0"
            ]);

        }

        if (!empty($groupRow)) {
            $GroupModel->update($groupId, [
                "groupDelete" => 0
            ]);
        }
    }
    private function groupsTypeLeave($events)
    {
        $GroupModel = new GroupModel();
        $groupId = $events['source']['groupId'];

        $groupRow = $GroupModel->find($groupId);
        if (!empty($groupRow)) {
            $GroupModel->update($groupId, [
                "groupDelete" => 1
            ]);
        }
    }

    public function groupsTypeMemberJoined($events)
    {
        $MembersModel = new MembersModel();
        # member เข้าห้อง
        $joined = $events['joined'];
        $joinedMembers = $joined['members'];
        $groupId = $events['source']['groupId'];
        $replyToken = $events['replyToken'];

        foreach ($joinedMembers as $joMemberk => $joMember):

            $joMemberType = $joMember['type'];

            if ($joMemberType === 'user') {

                $userId = $joMember['userId'];
                // $rowMember = $MembersModel->find ( $userId );
                $rowMember = $MembersModel
                    ->where('userId', $userId)
                    ->first();
                // {"displayName":"\u0e27'\u0e19\u0e34\u0e14\u0e32\ud83d\ude0a","userId":"U5f129c8fd58d668c421981a05ac3c27b","pictureUrl":"https:\/\/sprofile.line-scdn.net\/0ha5xRf1o-PhpVKy6AKyhAZSV7PXB2WmcILUQhL2gtMC5hEikYcEsmKGUsYi06TnEcfUUkKWh-Yn1ZOEl8S33CLlIbYytpHXhNe0ly9A"}


                // เพิ่ม user in server
                $Profile = $this->messagingApi->getGroupMemberProfile($groupId, $userId);

                // log_message("info", json_encode($rowMember));

                if (empty($rowMember) || is_null($rowMember)) {
                    $message = [
                        [
                            'type' => 'text',
                            'text' => 'TO : ' . $Profile->getDisplayName() . "\nยังไม่สมัครสมาชิกและผูกบัญชี\nคลิกลิงก์ :\n" . base_url()
                        ]
                    ];

                    // (new MembersModel())->save([
                    //     "userId" => $userId,
                    //     "displayName" => $Profile->getDisplayName(),
                    //     "pictureUrl" => $Profile->getPictureUrl(),
                    // ]);

                    return (new LineMessagingApi())->replyMessage($replyToken, $message);
                }



                // return true;
                // เพิ่มรายชื่อที่อยู่ ในห้อง
                $GroupMemberListModel = new GroupMemberListModel();
                $groupMemberListModelRow = $GroupMemberListModel
                    ->where("user_id", $rowMember->user_id)
                    ->where("groupId", $groupId)
                    ->first();

                if (empty($groupMemberListModelRow)) {
                    $GroupMemberListModel->save([
                        "user_id" => $rowMember->user_id,
                        "groupId" => $groupId,
                        "listDelete" => 0,
                    ]);
                } else {
                    $GroupMemberListModel->update($groupMemberListModelRow->listId, [
                        "user_id" => $rowMember->user_id,
                        "groupId" => $groupId,
                        "listDelete" => 0,
                    ]);
                }
            }
        endforeach;

        return TRUE;
    }
    private function groupsTypeMemberLeft($events)
    {
        $groupId = $events['source']['groupId'];
        $left = $events['left'];
        $leftMembers = $left['members'];

        foreach ($leftMembers as $lefMemberk => $lefMember):
            $lefMemberType = $lefMember['type'];
            if ($lefMemberType === 'user') {
                $lefMembersId = $lefMember['userId'];
                $GroupMemberListModel = new GroupMemberListModel();
                $groupMemberListModelRow = $GroupMemberListModel
                    ->where("userId", $lefMembersId)
                    ->where("groupId", $groupId)
                    ->first();
                if (!empty($groupMemberListModelRow)) {
                    $GroupMemberListModel->update($groupMemberListModelRow->listId, [
                        "listDelete" => 1
                    ]);
                }
            }
        endforeach;
    }
    public function sourceTypeGroups($events)
    {
        // $GroupModel = new GroupModel();
        $type = $events['type'];
        // $groupId = $events['source']['groupId'];

        switch ($type) {
            case 'message':
                // ส่งข้อความ
                return $this->groupsTypeMessage($events);
            case 'join':
                // เข้ากลุ่ม
                return $this->groupsTypeJoin($events);
            case 'leave':
                # ออกจากกลุ่ม
                return $this->groupsTypeLeave($events);
            case 'memberJoined':
                #  member เข้าจากห้อง
                return $this->groupsTypeMemberJoined($events);
            case 'memberLeft':
                # member ออกจากห้อง
                return $this->groupsTypeMemberLeft($events);
            default:
                return FALSE;
        }
        // return true ;
    }
    public function sourceTypeUsers($events)
    {
        $type = $events['type'];
        // $this->usersTypeFollow($events);
        switch ($type) {
            case 'message':
                // message
                return $this->usersTypeMessage($events);
            case 'unfollow':
                // unfollow
                return $this->usersTypeUnfollow($events);
            case 'follow':
                // unfollow
                return $this->usersTypeFollow($events);
            default:
                return FALSE;
        }
    }

    public function usersTypeMessage($events)
    {

        $MessageKeyLibrarie = new MessageKeyLibrarie();
        $type = $events['message']['type'];

        switch ($type) {
            case 'text':
                return $MessageKeyLibrarie->userTypeText($events);
            case "sticker":
                return FALSE;
            default:
                return FALSE;
        }



        // $replyToken = $events['replyToken'];
        // $userId = $events['source']['userId'];
        // $messageID = $events['message']['id'];
        // ส่งข้อความ

        // $Profile = $this->messagingApi->getProfile($userId);


        // $message = new TextMessage([
        //     'type' => MessageType::TEXT,
        //     'text' => "สวัดดี : " . $Profile->getDisplayName()
        // ]);

        // $request = new ReplyMessageRequest([
        //     // ฟังก์ชั่นส่งข้อความ
        //     'replyToken' => $replyToken,
        //     'messages' => [
        //         $message
        //     ],
        // ]);

        // log_message("LineAPI", $text);


        // return $this->messagingApi->replyMessage($request);

        // $keyLine = [
        //     "บช" => $MessageKeyLibrarie->getBank($events),
        // ];

        // switch ($text) {
        //     case  'บช':
        //         # code...
        //         break;
        //     case 'label':
        //         # code...
        //         break;
        //     default:
        //         # code...
        //         break;
        // }

        // $this->log("log.json",  $keyLine[$text]);
    }

    public function usersTypeFollow($events)
    {

        $MembersModel = new MembersModel();
        $userId = $events['source']['userId'];

        // $rowMember = $MembersModel->find($userId);
        // $Profile = $this->messagingApi->getProfile($userId);

        // เพิ่ม user in server
        // if (empty($rowMember)) {
        //     (new MembersModel())->save([
        //         "userId" => $userId,
        //         "displayName" => $Profile->getDisplayName(),
        //         "pictureUrl" => $Profile->getPictureUrl(),
        //         "language" => $Profile->getLanguage(),
        //         "statusMessage" => $Profile->getStatusMessage(),
        //         "follow" => "1"
        //     ]);
        // } else {
        //     (new MembersModel())->update($userId, [
        //         "userId" => $userId,
        //         "displayName" => $Profile->getDisplayName(),
        //         "pictureUrl" => $Profile->getPictureUrl(),
        //         "language" => $Profile->getLanguage(),
        //         "statusMessage" => $Profile->getStatusMessage(),
        //         "follow" => "1"
        //     ]);
        // }
    }

    public function usersTypeUnfollow($events)
    {
        $MembersModel = new MembersModel();
        $userId = $events['source']['userId'];

        $rowMember = $MembersModel->find($userId);
        $Profile = $this->messagingApi->getProfile($userId);

        // เพิ่ม user in server
        if (!empty($rowMember)) {
            (new MembersModel())->update($userId, [
                "userId" => $userId,
                "displayName" => $Profile->getDisplayName(),
                "pictureUrl" => $Profile->getPictureUrl(),
                "language" => $Profile->getLanguage(),
                "statusMessage" => $Profile->getStatusMessage(),
                "follow" => "0"
            ]);
        }
    }

    /**
     * Get the value of accessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set the value of accessToken
     *
     * @return  self
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function log($fileName = 'events.json', $text = '')
    {
        $events = json_decode(file_get_contents(WRITEPATH . $fileName), TRUE);
        array_push($events, $text);
        file_put_contents(WRITEPATH . $fileName, json_encode($events));
        return $events;
    }
}
