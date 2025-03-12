<?php
namespace App\Libraries;
class LineLoginLibrarie
{

    private $AUTH_URL = 'https://access.line.me/oauth2/v2.1/authorize';
    private $PROFILE_URL = 'https://api.line.me/v2/profile';
    private $TOKEN_URL = 'https://api.line.me/oauth2/v2.1/token';
    private $REVOKE_URL = 'https://api.line.me/oauth2/v2.1/revoke';
    private $VERIFYTOKEN_URL = 'https://api.line.me/oauth2/v2.1/verify';

    private $channelAccessToken;
    private $channelSecret;
    private $redirectUri;
    private $client_id;
    private $client_secret;

    public function __construct()
    {
        $this->channelAccessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');
        $this->channelSecret = getenv('LINE_CHANNEL_SECRET');

        $this->redirectUri = getenv('LINE_LOGIN_CLIENT_REDIRECT_URL');
        $this->client_id = getenv('LINE_LOGIN_CLIENT_ID');
        $this->client_secret = getenv('LINE_LOGIN_CLIENT_SECRET');





    }
    public function getLink()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['state'] = hash('sha256', microtime(TRUE) . rand() . $_SERVER['REMOTE_ADDR']);
        $url = $this->AUTH_URL . '?response_type=code&client_id=' . $this->client_id . '&redirect_uri=' . $this->redirectUri . '&scope=profile%20openid%20email&state=' . $_SESSION['state'];

        return $url;

    }

    public function refresh($token)
    {
        $header = ['Content-Type: application/x-www-form-urlencoded'];
        $data = [
            "grant_type" => "refresh_token",
            "refresh_token" => $token,
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret
        ];

        $response = $this->sendCURL($this->TOKEN_URL, $header, 'POST', $data);
        return $response;
    }

    public function token($code, $state)
    {
        session_status() === PHP_SESSION_NONE && session_start();

        $session_state = $_SESSION['state'] ?? 'ไม่กำหนด';
        log_message('info', "State ที่ส่งมา: $state | State ในเซสชัน: $session_state");

        if (!isset($_SESSION['state']) || $_SESSION['state'] !== $state) {
            log_message('error', 'การตรวจสอบ state ล้มเหลว: CSRF ที่เป็นไปได้');
            return FALSE;
        }

        $data = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->redirectUri,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret
        ];

        log_message('info', 'ข้อมูลคำขอ: ' . http_build_query($data));

        $ch = curl_init('https://api.line.me/oauth2/v2.1/token');

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'User-Agent:' . sprintf(
                'CWTH777k-GKF1/%s (PHP/%s; LINE-Bot-SDK/%s)',
                '1.0',              // App version
                PHP_VERSION,        // PHP version (เช่น 8.1.2)
                '8.3'               // LINE Bot SDK version (แทนด้วยเวอร์ชันจริงที่คุณใช้)
            ) // เพิ่ม User-Agent เพื่อระบุแอป
        ]); // กำหนด header สำหรับคำขอ


        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        // curl_setopt ( $ch, CURLOPT_CAINFO, '/etc/ssl/certs/ca-certificates.crt' );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_TCP_FASTOPEN, TRUE);
        curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);

        $max_retries = 10;
        $retry_count = 0;
        $response = FALSE;

        while ($retry_count < $max_retries && $response === FALSE) {
            $response = curl_exec($ch);
            if ($response === FALSE) {
                $retry_count++;
                $error = curl_error($ch);
                $errno = curl_errno($ch);
                log_message('warning', "ลองครั้งที่ $retry_count ล้มเหลว: [$errno] $error");
                sleep(1);
            }
        }

        if ($response === FALSE) {
            $info = curl_getinfo($ch);
            curl_close($ch);
            log_message('error', "ข้อผิดพลาด cURL หลัง retry: [$errno] $error | SSL Verify Result: {$info['ssl_verify_result']} | ข้อมูล: " . json_encode($info));
            return FALSE;
        }

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        $total_time = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
        curl_close($ch);

        log_message('info', "รหัส HTTP: $http_code | เวลาที่ใช้: {$total_time} วินาที | Header: $header | Body: $body");

        if ($http_code !== 200) {
            log_message('error', "ข้อผิดพลาด API: HTTP $http_code - $body");
            return FALSE;
        }

        $result = json_decode($body, TRUE);
        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', "ข้อผิดพลาด JSON: " . json_last_error_msg() . " - ข้อมูลดิบ: $body");
            return FALSE;
        }

        log_message('info', "ผลลัพธ์: " . json_encode($result));
        return $result;
    }

    public function profileFormIdToken($token = NULL)
    {
        $payload = explode('.', $token->id_token);
        $ret = array(
            'access_token' => $token->access_token,
            'refresh_token' => $token->refresh_token,
            'name' => '',
            'picture' => '',
            'email' => ''
        );

        if (count($payload) == 3) {
            $data = json_decode(base64_decode($payload[1]));
            if (isset($data->name))
                $ret['name'] = $data->name;

            if (isset($data->picture))
                $ret['picture'] = $data->picture;

            if (isset($data->email))
                $ret['email'] = $data->email;
        }
        return (object) $ret;
    }

    public function profile($token)
    {
        $header = ['Authorization: Bearer ' . $token];
        $response = $this->sendCURL($this->PROFILE_URL, $header, 'GET');
        return $response;
    }

    public function verify($token)
    {
        $url = $this->VERIFYTOKEN_URL . '?access_token=' . $token;
        $response = $this->sendCURL($url, NULL, 'GET');
        return $response;
    }

    public function revoke($token)
    {
        $header = ['Content-Type: application/x-www-form-urlencoded'];
        $data = [
            "access_token" => $token,
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret
        ];
        $response = $this->sendCURL($this->REVOKE_URL, $header, 'POST', $data);
        return $response;
    }

    private function sendCURL($url, $header = NULL, $type = 'GET', $data = NULL)
    {
        // เริ่มต้น cURL
        $request = curl_init($url);

        // ตั้งค่า User-Agent
        $user_agent = sprintf(
            'CWTH777k-GKF1/%s (PHP/%s; LINE-Bot-SDK/%s)',
            '1.0',          // App version
            PHP_VERSION,    // PHP version (เช่น 8.1.2)
            '8.3'           // LINE Bot SDK version
        );

        // รวม User-Agent กับ header ที่ส่งมา (ถ้ามี)
        $default_header = ['User-Agent: ' . $user_agent];
        if ($header !== NULL) {
            $header = array_merge($default_header, $header);
        } else {
            $header = $default_header;
        }
        curl_setopt($request, CURLOPT_HTTPHEADER, $header);

        // การตั้งค่า cURL ให้เหมือนฟังก์ชัน token
        curl_setopt($request, CURLOPT_RETURNTRANSFER, TRUE); // คืนค่าเป็น string
        curl_setopt($request, CURLOPT_FOLLOWLOCATION, FALSE); // ปิดการตาม redirect เพื่อความปลอดภัย
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, TRUE); // ตรวจสอบใบรับรอง SSL
        curl_setopt($request, CURLOPT_SSL_VERIFYHOST, 2); // ตรวจสอบ hostname
        // curl_setopt ( $request, CURLOPT_CAINFO, '/etc/ssl/certs/ca-certificates.crt' ); // CA bundle
        curl_setopt($request, CURLOPT_CONNECTTIMEOUT, 120); // Timeout การเชื่อมต่อ
        curl_setopt($request, CURLOPT_TIMEOUT, 60); // Timeout รวม
        curl_setopt($request, CURLOPT_VERBOSE, TRUE); // สำหรับ debug
        curl_setopt($request, CURLOPT_HEADER, TRUE); // รวม header ในผลลัพธ์
        curl_setopt($request, CURLOPT_TCP_FASTOPEN, TRUE); // เพิ่มความเร็ว (ถ้ารองรับ)
        curl_setopt($request, CURLOPT_FAILONERROR, TRUE); // หยุดถ้า HTTP error

        // ตั้งค่า POST ถ้าเป็น POST request
        if (strtoupper($type) === 'POST') {
            curl_setopt($request, CURLOPT_POST, TRUE);
            if ($data !== NULL) {
                curl_setopt($request, CURLOPT_POSTFIELDS, http_build_query($data));
            }
        }

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
                sleep(1); // รอ 1 วินาทีก่อนลองใหม่
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

        // แปลง JSON และตรวจสอบ
        $result = json_decode($body, TRUE);
        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', "ข้อผิดพลาด JSON: " . json_last_error_msg() . " - ข้อมูลดิบ: $body");
            return FALSE;
        }

        log_message('info', "ผลลัพธ์: " . json_encode($result));
        return $result; // คืนค่า array ที่แปลงจาก JSON
    }


    // private function sendCURL( $url, $header, $type, $data = NULL )
    // {
    //     $request = curl_init ();

    //     if ( $header != NULL ) {
    //         curl_setopt ( $request, CURLOPT_HTTPHEADER, $header );
    //     }

    //     curl_setopt ( $request, CURLOPT_URL, $url );
    //     curl_setopt ( $request, CURLOPT_SSL_VERIFYHOST, FALSE );
    //     curl_setopt ( $request, CURLOPT_SSL_VERIFYPEER, FALSE );

    //     if ( strtoupper ( $type ) === 'POST' ) {
    //         curl_setopt ( $request, CURLOPT_POST, TRUE );
    //         curl_setopt ( $request, CURLOPT_POSTFIELDS, http_build_query ( $data ) );
    //     }

    //     curl_setopt ( $request, CURLOPT_FOLLOWLOCATION, 1 );
    //     curl_setopt ( $request, CURLOPT_RETURNTRANSFER, 1 );

    //     $response = curl_exec ( $request );
    //     return $response;
    // }
}
