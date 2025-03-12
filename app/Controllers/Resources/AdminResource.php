<?php

namespace App\Controllers\Resources;

use App\Models\GroupMemberListModel;
use App\Models\AccountsAdminModel;
use App\Models\MemberStatementModel;
use CodeIgniter\RESTful\ResourceController;
use stdClass;

class AdminResource extends ResourceController
{

    protected $modelName = 'App\Models\AccountsAdminModel';
    protected $format = 'json';
    protected $helpers = [
        'url',
        'array',
        'cookie',
        'date',
        'filesystem',
        'form',
        'html',
        'inflector',
        'number',
        'security',
        'text',
        'xml',
        'session',
        'function'
    ];

    public function index()
    {
        $AccountsAdminModel = new AccountsAdminModel();
        $list = $AccountsAdminModel
            ->where("{$AccountsAdminModel->table}.ac_delete", '0')
            ->where("{$AccountsAdminModel->table}.RoleID !=", '4')
            ->where("{$AccountsAdminModel->table}.ac_code !=", SYS_CODE)
            ->join('roles', "roles.RoleID = {$AccountsAdminModel->table}.RoleID ", "inner")
            ->findAll();

        // log_message("info", json_encode($list));
        return $this->respond($list, 200);
    }

    public function show($id = null)
    {
        $AccountsAdminModel = new AccountsAdminModel();
        $list = $AccountsAdminModel->where("{$AccountsAdminModel->table}.ac_delete", '0')
            // ->where("{$AccountsAdminModel->table}.RoleID !=", '4')
            ->join('roles', "roles.RoleID = {$AccountsAdminModel->table}.RoleID ", "inner")
            ->find($id);
        return $this->respond($list, 200);
    }

    public function new()
    {
        $AccountsAdminModel = new AccountsAdminModel();
    }


    public function create()
    {
        // $AccountsAdminModel = new AccountsAdminModel();


        // return $this->respond();
        $rules = [
            'ac_email' => ['rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[accounts_admin.ac_email]'],
            'ac_password' => ['rules' => 'required|min_length[8]|max_length[50]'],
            'confirm_password'  => ['label' => 'confirm password', 'rules' => 'matches[ac_password]'],
            'ac_fname' => ['rules' => 'required|min_length[3]|max_length[50]'],
            'ac_lname' => ['rules' => 'required|min_length[3]|max_length[50]'],
            // 'ac_niname' => ['rules' => 'required|min_length[3]|max_length[50]'],
            'RoleID' => ['rules' => 'required'],
        ];
        if ($this->validate($rules)) {
            $model = new AccountsAdminModel();
            // random_string('alnum', 16)


            $ac_code = random_string("alnum", 3) . "" . random_string("nozero", 8);
            $che_AcCode = true;

            while ($che_AcCode) {
                $che_AcCodeRow = $model->where("ac_code", $ac_code)
                    ->find();
                if (empty($che_AcCodeRow)) {
                    $che_AcCode = false;
                }
            }

            $data = [
                'ac_email'    => $this->request->getVar('ac_email'),
                'ac_code'    => $ac_code,
                'ac_password' => password_hash($this->request->getVar('ac_password'), PASSWORD_DEFAULT),
                'ac_fname'    => $this->request->getVar('ac_fname'),
                'ac_lname'    => $this->request->getVar('ac_lname'),
                'ac_niname'    => $this->request->getVar('ac_niname'),
                'RoleID'    => $this->request->getVar('RoleID'),
                "ac_referral" => "rf-" . $ac_code,
            ];

            if ($model->save($data)) {
                return $this->respond(['message' => 'Registered Successfully', "status" => true], 200);
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

    public function edit($id = null)
    {
        $AccountsAdminModel = new AccountsAdminModel();
    }

    public function update($id = null)
    {
        $data = json_decode(file_get_contents('php://input'));

        if (!empty($data)) {
            $model = new AccountsAdminModel();
            $row = $model->find($id);
            $ac_password = $data->ac_password;

            if ($ac_password === "*******************") {
                $ac_password = $row->ac_password;
            } else {
                if ($ac_password !== $data->confirm_password) {
                    $response = [
                        'errors' => "confirm password",
                        'message' => 'Invalid Inputs'
                    ];
                    return $this->fail($response, 409);
                }
            }

            // return $this->respond(['message' => $ac_password, "status" => true], 200);
            $data = [
                'ac_email'    => $row->ac_email,
                // 'ac_code'    => $row->ac_code,
                'ac_password' => $ac_password,
                'ac_fname'    => $data->ac_fname,
                'ac_lname'    => $data->ac_lname,
                'ac_niname'    => $data->ac_niname,
                'RoleID'    => $data->RoleID,
            ];

            if ($model->update($id, $data)) {
                return $this->respond(['message' => 'update Successfully', "status" => true], 200);
            } else {
                $db = \Config\Database::connect();
                $error = $db->error();
                log_message('error', 'Database error: ' . json_encode($error));
                return $this->fail(['message' => 'Failed to save data', 'error' => $error], 500);
            }
        } else {
            $response = [
                'errors' => "Empty Data",
                'message' => 'Invalid Inputs'
            ];
            return $this->fail($response, 409);
        }

        // return $this->respond([], 200);
    }

    public function delete($id = null)
    {
        $AccountsAdminModel = new AccountsAdminModel();
        // $AccountsAdminModel->delete($id);

        $AccountsAdminModel->update($id, [
            "ac_delete" => "1",
            "deleted_at" => date("Y-m-d H:i:s"),
        ]);

        return $this->respond(['message' => 'delete Successfully', "status" => true], 200);
    }
}
