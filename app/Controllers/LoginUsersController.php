<?php

namespace App\Controllers;

use App\Controllers\BaseUserController;
use App\Libraries\LineLoginLibrarie;
use App\Models\AccountsAdminModel;
use App\Models\BankModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\MembersModel;
use App\Models\UserSigningLogModel;
use Exception;
use \Firebase\JWT\JWT;
use stdClass;

// use GuzzleHttp\Client;

// use LineLoginController;

class LoginUsersController extends BaseUserController
{
    use ResponseTrait;

    private $messagingApi = NULL;
    public function Signout($type = 1)
    {
        // $session = session();
        // $session->remove('token');
        // // $session->destroy();
        // // $session->set('lang', 'en');
        // switch ($type) {
        //     case '2':
        //         return $this->respond(['msg' => "logout Succesful", "status" => true], 200);
        //     case '3':
        //         return ['msg' => "logout Succesful", "status" => true];
        //     default:
        //         return redirect()->to(base_url('auth/signin'));
        // }
    }
    private function Login($access_token)
    {

        $LineLoginLibrarie = new LineLoginLibrarie();
        $profile = $LineLoginLibrarie->profile($access_token);

        if (gettype($profile) == 'object') {
            $userId = $profile->userId;
            $displayName = $profile->displayName;
            $statusMessage = isset($profile->statusMessage) ? $profile->statusMessage : '';
            $pictureUrl = $profile->pictureUrl;
        } else {
            $userId = $profile['userId'];
            $displayName = $profile['displayName'];
            $statusMessage = isset($profile['statusMessage']) ? $profile['statusMessage'] : '';
            $pictureUrl = $profile['pictureUrl'];
        }

        $MembersModel = new MembersModel();
        // $UserSigningLogModel = new UserSigningLogModel();

        $session = session();

        $user = $MembersModel
            ->select("userId,displayName")
            ->where('userId', $userId)
            ->first();

        if (empty($user)) {
            $MembersModel->save([
                "userId" => $userId,
                "displayName" => $displayName,
                "pictureUrl" => $pictureUrl,
                "language" => 'th',
                "statusMessage" => $statusMessage,
                "follow" => "0"
            ]);

            $user = new stdClass();
            $user->userId = $userId;
            $user->displayName = $displayName;
            $user->pictureUrl = $pictureUrl;
            $user->language = 'th';
            $user->statusMessage = $statusMessage;
        }

        $user->statusMessage = $statusMessage;
        // $user->displayName = $statusMessage;

        $key = JWT_SECRET;

        $iat = time(); // current timestamp value
        $exp = $iat + 86400;
        $Language = \Config\Services::language();

        $payload = array(
            "alg" => "HS512",
            "iss" => "JWT",
            "typ" => "JWT",
            "aud" => json_encode(['userId' => $userId]),
            "sub" => "Login JWT",
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "userId" => $userId,
            "lang" => $Language->getLocale(),
        );

        $token = JWT::encode($payload, $key, 'HS512');
        $response = [
            'message' => 'Login Succesful',
            'token' => $token,
            "lang" => $Language->getLocale(),
        ];

        $session->set('token', $token);
        $session->set('pictureUrl', $pictureUrl);
        $session->set('userId', $userId);
        $session->set('type', "users");
        $session->set('user', $user);
        $session->set('lang', $Language->getLocale());

        $name = 'lang';
        $value = $Language->getLocale();
        $expire = time() + 86400;
        $path = '/';

        setcookie($name, $value, $expire, $path);
        return $this->respond($response, 200);
    }


    public function index()
    {

        $this->setViewData("link", (new LineLoginLibrarie())->getLink());
        return view('pages/users/login', $this->getViewData());
    }

    public function signin($user_phone = null, $user_password = null)
    {
        $MembersModel = new MembersModel();
        $session = session();


        if (!is_null($user_phone) && !is_null($user_password)) {
            $username = $user_phone;
            $password = $user_password;
        } else {
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
        }



        $user = $MembersModel
            ->select("user_id ,user_phone,user_password ,userId,displayName,pictureUrl")
            ->where('user_phone', $username)
            ->first();






        if (empty($user)) {
            return redirect()->back()->with('error', 'เบอร์มือถือหรือรหัสผ่านไม่ถูกต้อง');
        }

        if (!$user || !($user && password_verify($password, $user->user_password)) || ($user && !password_verify($password, $user->user_password))) {
            return redirect()->back()->with('error', 'เบอร์มือถือหรือรหัสผ่านไม่ถูกต้อง');
        }



        $user_id = $user->user_id;
        $pictureUrl = empty($user->pictureUrl) ? base_url('icons/icon-512x512.png') : $user->pictureUrl;
        $key = JWT_SECRET;

        $iat = time(); // current timestamp value
        $exp = $iat + 86400;
        $Language = \Config\Services::language();

        $payload = array(
            "alg" => "HS512",
            "iss" => "JWT",
            "typ" => "JWT",
            "aud" => json_encode(['user_id' => $user_id]),
            "sub" => "Login JWT",
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "user_id" => $user_id,
            "lang" => $Language->getLocale(),
        );

        $token = JWT::encode($payload, $key, 'HS512');

        $session->set('token', $token);
        $session->set('pictureUrl', $pictureUrl);
        $session->set('user_id', $user_id);
        $session->set('type', "users");
        $session->set('user', $user);
        $session->set('lang', $Language->getLocale());

        $name = 'lang';
        $value = $Language->getLocale();
        $expire = time() + 86400;
        $path = '/';

        setcookie($name, $value, $expire, $path);

        if (!is_null($user_phone) && !is_null($user_password)) {
            return true;
        } else {
            return redirect()->to(base_url('users'))->with('success', 'เข้าสู่ระบบสำเร็จ');
        }

    }

    public function register()
    {
        $this->setViewData(
            "banks",
            (new BankModel())
                ->where("bank_delete", "0")
                ->whereNotIn("bank_id", ["25"])
                ->findAll()
        );

        return view('pages/users/register', $this->getViewData());
    }

    public function signup()
    {
        $fname = $this->request->getVar('fname');
        $lname = $this->request->getVar('lname');
        $tel_phone = $this->request->getVar('tel_phone');
        $email = $this->request->getVar('email');
        $line = $this->request->getVar('line');
        $bank = $this->request->getVar('bank');
        $bank_number = $this->request->getVar('bank_number');
        $agent = $this->request->getVar('agent');
        $password = $this->request->getVar('password');

        if (
            empty($fname)
            || empty($lname)
            || empty($tel_phone)
            || empty($email)
            || empty($line)
            || empty($bank)
            || empty($bank_number)
            || empty($password)
        ) {
            return redirect()->back()->with('error', "INPUT VALUE EMPTY.....");
        }

        // กำหนด rules การตรวจสอบข้อมูล
        $rules = [
            'fname' => [
                'rules' => 'required|min_length[2]|max_length[50]',
                'errors' => [
                    'required' => 'กรุณากรอกชื่อ',
                    'min_length' => 'ชื่อต้องมีความยาวอย่างน้อย 2 ตัวอักษร',
                    'max_length' => 'ชื่อต้องไม่เกิน 50 ตัวอักษร',
                ]
            ],
            'lname' => [
                'rules' => 'required|min_length[2]|max_length[50]',
                'errors' => [
                    'required' => 'กรุณากรอกนามสกุล',
                    'min_length' => 'นามสกุลต้องมีความยาวอย่างน้อย 2 ตัวอักษร',
                    'max_length' => 'นามสกุลต้องไม่เกิน 50 ตัวอักษร',
                ]
            ],
            'tel_phone' => [
                'rules' => 'required|min_length[9]|max_length[15]|numeric|is_unique[members.user_phone]',
                'errors' => [
                    'required' => 'กรุณากรอกเบอร์โทรศัพท์',
                    'min_length' => 'เบอร์โทรศัพท์ต้องมีความยาวอย่างน้อย 9 ตัวเลข',
                    'max_length' => 'เบอร์โทรศัพท์ต้องไม่เกิน 15 ตัวเลข',
                    'numeric' => 'เบอร์โทรศัพท์ต้องเป็นตัวเลขเท่านั้น',
                    'is_unique' => 'เบอร์นี้ถูกใช้งานแล้ว'
                ]
            ],
            'email' => [
                'rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[members.user_email]',
                'errors' => [
                    'required' => 'กรุณากรอกอีเมล',
                    'valid_email' => 'รูปแบบอีเมลไม่ถูกต้อง',
                    'is_unique' => 'อีเมลนี้ถูกใช้งานแล้ว'
                ]
            ],
            'line' => [
                'rules' => 'required|min_length[2]|max_length[50]',
                'errors' => [
                    'required' => 'กรุณากรอก LINE ID',
                    'min_length' => 'LINE ID ต้องมีความยาวอย่างน้อย 2 ตัวอักษร',
                    'max_length' => 'LINE ID ต้องไม่เกิน 50 ตัวอักษร'
                ]
            ],
            'bank' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'กรุณากรอกชื่อธนาคาร',
                    'max_length' => 'ชื่อธนาคารต้องไม่เกิน 100 ตัวอักษร'
                ]
            ],
            'bank_number' => [
                'rules' => 'required|min_length[2]|max_length[20]|numeric',
                'errors' => [
                    'required' => 'กรุณากรอกเลขที่บัญชี',
                    'min_length' => 'เลขที่บัญชีต้องมีความยาวอย่างน้อย 10 ตัวเลข',
                    'max_length' => 'เลขที่บัญชีต้องไม่เกิน 20 ตัวเลข',
                    'numeric' => 'เลขที่บัญชีต้องเป็นตัวเลขเท่านั้น'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]|max_length[255]',
                'errors' => [
                    'required' => 'กรุณากรอกรหัสผ่าน',
                    'min_length' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร',
                    'max_length' => 'รหัสผ่านต้องไม่เกิน 255 ตัวอักษร'
                ]
            ]
        ];

        $agent_check = false;
        if (!empty($agent)) {
            $agentModel = new AccountsAdminModel();
            $agent_resp = $agentModel
                ->select("ac_referral,ac_fname,ac_lname,ac_niname")
                ->where("ac_referral", $agent)->find();

            if ($agent_resp) {
                $agent_check = true;
            } else {
                return redirect()->back()->with('error', 'รหัสตัวแทนไม่ถูกต้อง');
            }
        }

        if ($this->validate($rules)) {
            $model = new MembersModel();

            // เตรียมข้อมูลสำหรับบันทึก
            $data = [
                'user_register_status' => 1, // TINYINT, 1 = active
                'user_fname' => $fname,
                'user_lname' => $lname,
                'user_phone' => $tel_phone,
                'user_email' => $email,
                'user_line_id' => $line,
                'user_bank' => $bank,
                'user_bankNumber' => $bank_number,
                'user_bankFName' => $fname, // ใช้ชื่อเดียวกับ user_fname
                'user_bankLName' => $lname, // ใช้ชื่อเดียวกับ user_lname
                'user_password' => password_hash($password, PASSWORD_DEFAULT),
                'user_agent' => $agent_check ? $agent : NULL, // Foreign key จาก accounts_admin
                'user_agent_date' => $agent_check ? date('Y-m-d H:i:s') : null, // TIMESTAMP
                'created_at' => date('Y-m-d H:i:s'), // TIMESTAMP การสร้าง
                'user_remain' => '0.00', // DECIMAL ค่าเริ่มต้น
                'user_TotalAmount' => '0.00', // DECIMAL ค่าเริ่มต้น
                'user_TotalWithdrawal' => '0.00', // DECIMAL ค่าเริ่มต้น
                'userDelete' => 0, // TINYINT ค่าเริ่มต้น = ใช้งาน
                'follow' => 0, // TINYINT ค่าเริ่มต้น = ติดตาม
                'user_currency' => 'THB', // VARCHAR ค่าเริ่มต้น
                'language' => 'th', // VARCHAR ค่าเริ่มต้น
                'pictureUrl' => base_url("icons/icon-512x512.png")
            ];

            try {
                $model->insert($data);
                return redirect()->to(base_url('users/signin'))->with('success', "Register Success");

            } catch (Exception $e) {
                return redirect()->back()->with('error', "Insert Register No.");
            }
        } else {
            $errors = $this->validator->getErrors();
            return redirect()->back()->with('error', json_encode($errors));
        }
    }

    private function getLineUserProfile($accessToken)
    {
        $client = \Config\Services::curlrequest();
        $response = $client->request('GET', 'https://api.line.me/v2/profile', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ]
        ]);
        return json_decode($response->getBody(), TRUE);
    }

    public function callback()
    {
        $code = $this->request->getVar('code');
        $state = $this->request->getVar('state');

        if (!$code || !$state) {
            log_message('error', 'ไม่ได้รับ code หรือ state จาก LINE Callback');
            die('เกิดข้อผิดพลาดในการล็อกอิน');
        }


        $LineLoginLibrarie = new LineLoginLibrarie();
        $resp = $LineLoginLibrarie->token($code, $state);
        if ($resp === FALSE) {
            return redirect()->to(base_url("users"))->with("error", "ผูกบัญชี LINE ไม่สำเร็จกรุณาลองใหม่อีกครั้ง");
        }


        $access_token = NULL;
        if (isset($resp['access_token'])) {
            $access_token = $resp['access_token'];
        } else {
            $access_token = $resp->access_token;
        }

        $profile = $LineLoginLibrarie->profile($access_token);

        $_SESSION["pictureUrl"] = $profile['pictureUrl'];// , '');
        // Array ( [userId] => Ue503c9024eeb4a7149d8f7ec2c579fcf [displayName] => S W [statusMessage] => NEW LINE [pictureUrl] => https://profile.line-scdn.net/0huzfn4kVEKlVLFz5OBRtUKjtHKT9oZnNHZHBjZn5DdWUhIjoLY3djN3xFfWZxJj5XMCRlZ3wQc2VHBF0zVUHWYUwnd2R3IWwCZXVlsw ) 1
        $user_id = session('user_id');
        $profile['user_line_status'] = 1;

        $MembersModel = new MembersModel();
        $MembersModel->update($user_id, $profile);
        return redirect()->to(base_url('users'))->with('success', "ผูกบัญชี LINE สำเร็จ");



        // print_r($profile);
        // die(session('user_id'));
        // return;



        // if (!is_null($access_token) && $this->Login($access_token)) {
        //     return redirect()->to(base_url('users'))->with('success', "Login Success");
        // }

        // return redirect()->to(base_url(relativePath: "users/signin"))->with('error', "Login Not Success");
    }
}
