<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\AccountsAdminModel;
use Exception;

class Register extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $rules = [
            'email' => ['rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[accounts.ac_email]'],
            'password' => ['rules' => 'required|min_length[8]|max_length[50]'],
            'confirm_password'  => ['label' => 'confirm password', 'rules' => 'matches[password]']
        ];
        if ($this->validate($rules)) {
            $model = new AccountsAdminModel();
            $data = [
                'ac_email'    => $this->request->getVar('email'),
                'ac_password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            ];

            if ($model->save($data)) {
                return $this->respond(['message' => 'Registered Successfully'], 200);
            } else {
                $db = \Config\Database::connect();
                $error = $db->error();
                log_message('error', 'Database error: ' . json_encode($error));
                return $this->fail(['message' => 'Failed to save data', 'error' => $error], 500);
            }

            
        } else {
            $response = [
                'errors' => $this->validator->getErrors(),
                'message' => 'Invalid Inputs'
            ];
            return $this->fail($response, 409);
        }
    }
}
