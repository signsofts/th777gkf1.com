<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\AccountsAdminModel;
use App\Models\RolesModel;
use App\Models\SigningLogModel;
use \Firebase\JWT\JWT;

class Login extends BaseController
{
    use ResponseTrait;

    public function Signout($type = 1)
    {
        $session = session();
        $session->remove('token');
        // $session->destroy();
        // $session->set('lang', 'en');



        switch ($type) {
            case '2':
                return $this->respond(['msg' => "logout Succesful", "status" => TRUE], 200);
            case '3':
                return ['msg' => "logout Succesful", "status" => TRUE];
            default:
                return redirect()->to(base_url('auth/signin'));
        }
    }
    public function Login()
    {

        // helper('cookie');

        $model = new AccountsAdminModel();
        $RolesModel = new RolesModel();
        $logModel = new SigningLogModel();
        $session = session();
        // $logModel = new SigningLogModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $model
            ->select("ac_email,ac_code,ac_password,ac_fname,ac_lname,ac_niname,RoleID")
            // ->join("")
            ->where('ac_email', $email)->first();

        if (is_null($user)) {
            $logModel->saveLog('error,login', $email, 'emty email');
            return $this->respond(['error' => 'Invalid email or password.'], 401);
        }

        $pwd_verify = password_verify($password, $user->ac_password);

        if (!$pwd_verify) {
            $logModel->saveLog('error,login', $email, 'error password');
            return $this->respond(['error' => 'Invalid email or password.'], 401);
        }

        // $key = getenv('JWT_SECRET');
        $key = JWT_SECRET;

        $iat = time(); // current timestamp value
        $exp = $iat + 86400;
        $Language = \Config\Services::language();

        $payload = array(
            "alg" => "HS512",
            "iss" => "JWT",
            "typ" => "JWT",
            "aud" => json_encode(['email' => $user->ac_email]),
            "sub" => "Login JWT",
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "email" => $user->ac_email,
            "lang" => $Language->getLocale(),
        );

        $token = JWT::encode($payload, $key, 'HS512');
        $response = [
            'message' => 'Login Succesful',
            'token' => $token,
            "lang" => $Language->getLocale(),
        ];

        unset($user->ac_password);

        $user->role = $RolesModel->find($user->RoleID);

        $session->set('type', 'admin');
        $session->set('token', $token);
        $session->set('ac_code', $user->ac_code);
        $session->set('user', $user);
        $session->set('lang', $Language->getLocale());

        $name = 'lang';
        $value = $Language->getLocale();
        $expire = time() + 86400;
        $path = '/';
        setcookie($name, $value, $expire, $path);




        $logModel->saveLog('success,login', $email, 'Login Succesful');
        return $this->respond($response, 200);
    }


    public function index()
    {
        $signout = (object) $this->Signout(3);
        if ($signout->status) {
            return view('pages/login', $this->viewData);
        }
    }



    public function checkLogin()
    {
        return $this->respond(['msg' => 'success', 'status' => TRUE], 200);
    }
}
