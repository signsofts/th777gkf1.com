<?php

namespace App\Libraries;

class LineMessagingApi
{
    private $channelAccessToken;
    private $channelSecret;
    private $apiEndpoint = 'https://api.line.me';
    private $authEndpoint = 'https://api.line.me';
    private $proxy; // เพิ่มตัวแปรสำหรับเก็บ proxy settings

    public function __construct()
    {
        $this->channelAccessToken = getenv ( 'LINE_CHANNEL_ACCESS_TOKEN' );
        $this->channelSecret      = getenv ( 'LINE_CHANNEL_SECRET' );

        if ( empty ( $this->channelAccessToken ) ) {
            log_message ( 'error', 'LINE_CHANNEL_ACCESS_TOKEN ไม่ได้กำหนดใน .env หรือว่างเปล่า' );
            throw new \Exception( 'Channel Access Token is missing or invalid' );
        }

        // ตั้งค่า proxy จาก environment หรือ config (ถ้ามี)
        $this->proxy = [ 
            'host'     => getenv ( 'PROXY_HOST' ),      // เช่น 'proxy.example.com'
            'port'     => getenv ( 'PROXY_PORT' ),      // เช่น 8080
            'username' => getenv ( 'PROXY_USERNAME' ), // ถ้ามี
            'password' => getenv ( 'PROXY_PASSWORD' )  // ถ้ามี
        ];
    }

    private function sendRequest( $method, $url, $data = [], $headers = [] )
    {
        // ตั้งค่า header พื้นฐาน
        $defaultHeaders = [ 
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->channelAccessToken
        ];

        log_message ( 'debug', 'Request Headers: ' . json_encode ( $headers ) );
        log_message ( 'debug', 'Request Data: ' . json_encode ( $data ) );

        $headers = array_merge ( $defaultHeaders, $headers );

        // ตั้งค่า User-Agent
        $userAgent = sprintf (
            'CWTH777k-GKF1/%s (PHP/%s; LINE-Bot-SDK/%s)',
            '1.0',
            PHP_VERSION,
            '8.3'
        );
        $headers   = array_merge ( [ 'User-Agent: ' . $userAgent ], $headers );

        // เริ่มต้น cURL
        $request = curl_init ( $url );



        // ตั้งค่า cURL
        curl_setopt ( $request, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $request, CURLOPT_RETURNTRANSFER, TRUE );
        curl_setopt ( $request, CURLOPT_FOLLOWLOCATION, FALSE );
        curl_setopt ( $request, CURLOPT_SSL_VERIFYPEER, TRUE );
        curl_setopt ( $request, CURLOPT_SSL_VERIFYHOST, 2 );
        curl_setopt ( $request, CURLOPT_CONNECTTIMEOUT, 120 );
        curl_setopt ( $request, CURLOPT_TIMEOUT, 60 );
        curl_setopt ( $request, CURLOPT_VERBOSE, TRUE );
        curl_setopt ( $request, CURLOPT_HEADER, TRUE );
        curl_setopt ( $request, CURLOPT_TCP_FASTOPEN, TRUE );
        curl_setopt ( $request, CURLOPT_FAILONERROR, TRUE );

        // ตั้งค่า Proxy ถ้ามี
        if ( !empty ( $this->proxy[ 'host' ] ) && !empty ( $this->proxy[ 'port' ] ) ) {
            curl_setopt ( $request, CURLOPT_PROXY, $this->proxy[ 'host' ] );
            curl_setopt ( $request, CURLOPT_PROXYPORT, $this->proxy[ 'port' ] );

            // ถ้ามี username และ password สำหรับ proxy authentication
            if ( !empty ( $this->proxy[ 'username' ] ) && !empty ( $this->proxy[ 'password' ] ) ) {
                // curl_setopt($request, CURLOPT_PROXYUSERPWD, "{$this->proxy['username']}:{$this->proxy['password']}");
            }

            // เปิดใช้งาน proxy type (เช่น HTTP หรือ SOCKS5)
            curl_setopt ( $request, CURLOPT_PROXYTYPE, CURLPROXY_HTTP ); // หรือ CURLPROXY_SOCKS5 ถ้าใช้ SOCKS
        }

        // ตั้งค่า method และข้อมูล
        if ( strtoupper ( $method ) === 'POST' ) {
            curl_setopt ( $request, CURLOPT_POST, TRUE );
            if ( !empty ( $data ) ) {
                curl_setopt ( $request, CURLOPT_POSTFIELDS, json_encode ( $data ) );
            }
        } elseif ( strtoupper ( $method ) === 'GET' ) {
            curl_setopt ( $request, CURLOPT_HTTPGET, TRUE );
        } elseif ( strtoupper ( $method ) === 'PUT' ) {
            curl_setopt ( $request, CURLOPT_CUSTOMREQUEST, 'PUT' );
            if ( !empty ( $data ) ) {
                curl_setopt ( $request, CURLOPT_POSTFIELDS, json_encode ( $data ) );
            }
        } elseif ( strtoupper ( $method ) === 'DELETE' ) {
            curl_setopt ( $request, CURLOPT_CUSTOMREQUEST, 'DELETE' );
        }

        // ส่งคำขอด้วย retry mechanism
        $maxRetries = 10;
        $retryCount = 0;
        $response   = FALSE;

        while ( $retryCount < $maxRetries && $response === FALSE ) {
            $response = curl_exec ( $request );
            if ( $response === FALSE ) {
                $retryCount++;
                $error = curl_error ( $request );
                $errno = curl_errno ( $request );
                log_message ( 'warning', "ลองครั้งที่ $retryCount ล้มเหลว: [$errno] $error" );
                sleep ( 1 );
            }
        }

        // ตรวจสอบข้อผิดพลาดหลัง retry
        if ( $response === FALSE ) {
            $info = curl_getinfo ( $request );
            curl_close ( $request );
            log_message ( 'error', "ข้อผิดพลาด cURL หลัง retry: [$errno] $error | SSL Verify Result: {$info[ 'ssl_verify_result' ]} | ข้อมูล: " . json_encode ( $info ) );
            return FALSE;
        }

        // แยก header และ body
        $headerSize = curl_getinfo ( $request, CURLINFO_HEADER_SIZE );
        $httpCode   = curl_getinfo ( $request, CURLINFO_HTTP_CODE );
        $header     = substr ( $response, 0, $headerSize );
        $body       = substr ( $response, $headerSize );
        $totalTime  = curl_getinfo ( $request, CURLINFO_TOTAL_TIME );
        curl_close ( $request );

        // บันทึก log
        log_message ( 'info', "รหัส HTTP: $httpCode | เวลาที่ใช้: {$totalTime} วินาที | Header: $header | Body: $body" );

        // ตรวจสอบสถานะ HTTP
        if ( $httpCode !== 200 ) {
            log_message ( 'error', "ข้อผิดพลาด API: HTTP $httpCode - $body" );
            return FALSE;
        }

        // คืนค่า body เป็น array ถ้าเป็น JSON หรือ string ตามเดิม
        $decodedBody = json_decode ( $body, TRUE );
        return $decodedBody !== NULL ? $decodedBody : $body;
    }

    // OAuth Endpoints
    public function getOAuthToken( $code, $redirectUri, $clientId, $clientSecret )
    {
        $url  = $this->authEndpoint . '/oauth2/v2.1/token';
        $data = [ 
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'redirect_uri'  => $redirectUri,
            'client_id'     => $clientId,
            'client_secret' => $clientSecret
        ];
        return $this->sendRequest ( 'POST', $url, $data );
    }

    public function verifyOAuthToken( $accessToken )
    {
        $url = $this->authEndpoint . '/oauth2/v2.1/verify?access_token=' . urlencode ( $accessToken );
        return $this->sendRequest ( 'GET', $url );
    }

    // Message Endpoints
    public function replyMessage( $replyToken, $messages )
    {
        $url  = $this->apiEndpoint . '/v2/bot/message/reply';
        $data = [ 
            'replyToken' => $replyToken,
            'messages'   => $messages
        ];
        return $this->sendRequest ( 'POST', $url, $data );
    }

    public function pushMessage( $to, $messages )
    {
        $url  = $this->apiEndpoint . '/v2/bot/message/push';
        $data = [ 
            'to'       => $to,
            'messages' => $messages
        ];
        return $this->sendRequest ( 'POST', $url, $data );
    }

    public function multicast( $to, $messages )
    {
        $url  = $this->apiEndpoint . '/v2/bot/message/multicast';
        $data = [ 
            'to'       => $to,
            'messages' => $messages
        ];
        return $this->sendRequest ( 'POST', $url, $data );
    }

    // Audience Group Endpoints
    public function createAudienceGroup( $description, $isIfNot = FALSE, $uploadDescription = NULL )
    {
        $url  = $this->apiEndpoint . '/v2/bot/audienceGroup/upload';
        $data = [ 
            'description' => $description,
            'isIfNot'     => $isIfNot
        ];
        if ( $uploadDescription ) {
            $data[ 'uploadDescription' ] = $uploadDescription;
        }
        return $this->sendRequest ( 'POST', $url, $data );
    }

    public function getAudienceGroup( $audienceGroupId )
    {
        $url = $this->apiEndpoint . '/v2/bot/audienceGroup/' . $audienceGroupId;
        return $this->sendRequest ( 'GET', $url );
    }

    // Profile Endpoints
    public function getProfile( $userId )
    {
        $url = $this->apiEndpoint . '/v2/bot/profile/' . $userId;
        return $this->sendRequest ( 'GET', $url );
    }

    // Group Endpoints
    public function getGroupSummary( $groupId )
    {
        $url = $this->apiEndpoint . '/v2/bot/group/' . $groupId . '/summary';
        return $this->sendRequest ( 'GET', $url );
    }

    public function leaveGroup( $groupId )
    {
        $url = $this->apiEndpoint . '/v2/bot/group/' . $groupId . '/leave';
        return $this->sendRequest ( 'POST', $url );
    }

    // Room Endpoints
    public function getRoomMembersCount( $roomId )
    {
        $url = $this->apiEndpoint . '/v2/bot/room/' . $roomId . '/members/count';
        return $this->sendRequest ( 'GET', $url );
    }

    public function leaveRoom( $roomId )
    {
        $url = $this->apiEndpoint . '/v2/bot/room/' . $roomId . '/leave';
        return $this->sendRequest ( 'POST', $url );
    }

    // User Link Token
    public function getUserLinkToken( $userId )
    {
        $url = $this->apiEndpoint . '/v2/bot/user/' . $userId . '/linkToken';
        return $this->sendRequest ( 'POST', $url );
    }

    // Bot Info
    public function getBotInfo()
    {
        $url = $this->apiEndpoint . '/v2/bot/info';
        return $this->sendRequest ( 'GET', $url );
    }
}