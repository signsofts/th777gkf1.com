<?php

namespace App\Controllers\Resources;

use App\Models\BanklistModel;
use App\Models\BankStatementModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use GuzzleHttp\Client;

class BankStatementsResource extends ResourceController
{
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


    protected $modelName = 'App\Models\BankStatementModel';
    protected $format = 'json';

    public function index()
    {
        $BankStatementModel = new BankStatementModel();
        $list = $BankStatementModel->where("blit_delete", '0')
            ->findAll();
        return $this->respond($list);
    }

    public function show($id = NULL)
    {
        $BankStatementModel = new BankStatementModel();
        $list = $BankStatementModel->find($id);
        return $this->respond($list);
    }

    public function new()
    {
        $BankStatementModel = new BankStatementModel();
    }

    public function create()
    {

        $BankStatementModel = new BankStatementModel();
        $BanklistModel = new BanklistModel();
        $bstate_IN = $this->request->getVar('bstate_IN');
        $bstate_out = $this->request->getVar('bstate_out');
        $chk = $this->request->getVar('chk');

        $blit_id = $this->request->getVar('blit_id');
        $bListRow = $BanklistModel->find($blit_id);
        if (empty($bListRow)) {
            return $this->respond(['error' => 'empty data', "status" => 401], 200);
        }

        $blit_remain = $bListRow->blit_remain;
        // return $this->respond($this->request->getVar('_bstate_slip') ?? false);
        $bstate_slip = NULL;



        if (isset($_POST['_bstate_slip']) && !empty($_POST['_bstate_slip'])) {
            // if (!empty($_POST['_bstate_slip'])) {
            $bstate_slip = $_POST['_bstate_slip'];
        } else {
            if (isset($_FILES['bstate_slip']) && $_FILES['bstate_slip']['error'] != 4) {
                // if ($_FILES['bstate_slip'] ?? false) {
                $bstate_slipf = $this->request->getFile('bstate_slip');
                // $filepath = WRITEPATH . 'uploads/' . $bstate_slipf->store();
                // $writable = explode("writable", $filepath);
                // $path = explode("/", $writable[1]);

                // $file = $path[2];
                // $path = $path[1];
                // $filepath = $path . "/" . $file;
                // $bstate_slip = $filepath;

                // Get the original file name
                $originalName = $bstate_slipf->getClientName();

                // Define a custom file name if needed
                $newName = $bstate_slipf->getRandomName(); // You can change this to $originalName if you want to keep the original

                // Move the file to the writable/uploads directory


                $path = WRITEPATH . 'uploads/' . date("Ymd");
                $bstate_slipf->move($path, $newName);

                // Store the relative path
                // $filepath        = 'uploads/' . $newName;
                $bstate_slip = date("Ymd") . "/" . $newName;




            } else {
                $bstate_slip = NULL;
            }
        }


        // return $this->respond('---', 200);
        if ($bstate_IN == '1' && $bstate_out == '0') {
            // เงินเข้า

            $type = $this->request->getVar('type');
            switch ($type) {
                case 'member':

                    $rules = [
                        'user_id' => ['rules' => 'required'], //|is_unique[banklists.blit_number]
                        'money_incoming' => ['rules' => 'required'],
                        // 'bstate_note' => ['rules' => 'required'],
                        // 'blit_image' => ['rules' => 'required'],
                    ];
                    break;

                case 'other':
                    $rules = [
                        // 'user_id' => ['rules' => 'required'], //|is_unique[banklists.blit_number]
                        'money_incoming' => ['rules' => 'required'],
                        // 'bstate_note' => ['rules' => 'required'],
                        // 'blit_image' => ['rules' => 'required'],
                    ];
                    break;
            }

            if (!$this->validate($rules)) {
                return $this->respond(['error' => 'required', "status" => 401], 200);
            }

            $blit_remain += floatval($this->request->getVar('money_incoming'));
            $BanklistModel->update($this->request->getVar('blit_id'), [
                "blit_remain" => $blit_remain,
            ]);




            $data = [
                // 'bstate_id' => null,
                'bank_id' => $this->request->getVar('bank_id'),
                'blit_id' => $this->request->getVar('blit_id'),
                'user_id' => $type == 'member' ? $this->request->getVar('user_id') : NULL,
                'status_id' => $this->request->getVar('status_id') ?? 1,
                'bstate_IN' => $this->request->getVar('bstate_IN'),
                'bstate_out' => $this->request->getVar('bstate_out'),
                'bstate_note' => $this->request->getVar('bstate_note'),
                'bstate_remain' => $blit_remain,
                'money_incoming' => $this->request->getVar('money_incoming'),
                // 'money_out' => null,
                // 'bstate_delete' => null,
                'ac_code' => $this->request->getVar('ac_code') ?? session("ac_code"),
                "bstate_slip" => $bstate_slip,
            ];

            $chk = $this->request->getVar("chk") ?? FALSE;
            // return $this->respond(!$chk && $type = "member");
            if (!$chk && $type == "member") {
                $postResp = $this->postApi(site_url('api/v1/resource/mstatements'), [
                    "user_id" => $this->request->getVar('user_id'),
                    "statement_IN" => $this->request->getVar('bstate_IN'),
                    "statement_OUT" => $this->request->getVar('bstate_out'),
                    "_statement_slip" => $bstate_slip,
                    "money_incoming" => $this->request->getVar('money_incoming'),
                    "statement_note" => $this->request->getVar('bstate_note'),
                    "ac_code" => $this->request->getVar('ac_code') ?? session("ac_code"),
                    "blit_id" => $this->request->getVar('blit_id'),
                    "chk" => TRUE,
                ], FALSE, session('token'));
            }
            //    return $postResp ;
            $BankStatementModel->save($data);

            return $this->respond(['success' => 'Insert Data Success', "status" => 200], 200);
        }

        if ($bstate_IN == '0' && $bstate_out == '1') {
            // เงินออก

            $type = $this->request->getVar('type');


            switch ($type) {
                case 'member':
                    $rules = [
                        'user_id' => ['rules' => 'required'], //|is_unique[banklists.blit_number]
                        'money_out' => ['rules' => 'required'],
                        // 'bstate_note' => ['rules' => 'required'],
                        // 'blit_image' => ['rules' => 'required'],
                    ];
                    break;

                case 'other':
                    $rules = [
                        // 'user_id' => ['rules' => 'required'], //|is_unique[banklists.blit_number]
                        'money_out' => ['rules' => 'required'],
                        // 'bstate_note' => ['rules' => 'required'],
                        // 'blit_image' => ['rules' => 'required'],
                    ];
                    break;
            }


            if (!$this->validate($rules)) {
                return $this->respond(['error' => 'required', "status" => 401], 200);
            }


            $blit_remain -= floatval($this->request->getVar('money_out'));
            if ($blit_remain < 0) {
                return $this->respond(['error' => 'money 0', "status" => 401], 200);
            }


            $BanklistModel->update($this->request->getVar('blit_id'), [
                "blit_remain" => $blit_remain,
            ]);

            $data = [
                // 'bstate_id' => null,
                'bank_id' => $this->request->getVar('bank_id'),
                'blit_id' => $this->request->getVar('blit_id'),
                'user_id' => $type == 'member' ? $this->request->getVar('user_id') : NULL,
                'status_id' => $this->request->getVar('status_id') ?? 2,
                'bstate_IN' => $this->request->getVar('bstate_IN'),
                'bstate_out' => $this->request->getVar('bstate_out'),
                'bstate_note' => $this->request->getVar('bstate_note'),
                'bstate_remain' => $blit_remain,
                'money_out' => $this->request->getVar('money_out'),
                'ac_code' => $this->request->getVar('ac_code') ?? session("ac_code"),
                "bstate_slip" => $bstate_slip,
            ];

            $chk = $this->request->getVar("chk") ?? FALSE;
            if (!$chk && $type == "member") {
                $postResp = $this->postApi(site_url('api/v1/resource/mstatements'), [
                    "user_id" => $this->request->getVar('user_id'),
                    "statement_IN" => $this->request->getVar('bstate_IN'),
                    "statement_OUT" => $this->request->getVar('bstate_out'),
                    "_statement_slip" => $bstate_slip,
                    'status_id' => $this->request->getVar('status_id') ?? 2,
                    "money_out" => $this->request->getVar('money_out'),
                    "statement_note" => $this->request->getVar('bstate_note'),
                    "ac_code" => $this->request->getVar('ac_code') ?? session("ac_code"),
                    "blit_id" => $this->request->getVar('blit_id'),
                    "chk" => TRUE,
                ], FALSE, session('token'));
                // return $postResp;
            }
            $BankStatementModel->save($data);
            return $this->respond(['success' => 'Insert Data Success', "status" => 200], 200);
        }
    }

    public function edit($id = NULL)
    {
        $BankStatementModel = new BankStatementModel();
    }

    public function update($id = NULL)
    {
        $BankStatementModel = new BankStatementModel();
    }

    public function delete($id = NULL)
    {
        $BankStatementModel = new BankStatementModel();
        $BankStatementModel->update($id, [
            "deleted_at" => "1",
            "ac_code" => session('ac_code'),
        ]);

        return $this->respond(['success' => TRUE, "msg" => "delete success"], 200);
    }
    public function postApi($url, $data = array(), $returnThis = FALSE, $token)
    {
        // $client = \Config\Services::curlrequest();
        $client = new Client();
        $response = $client->request("POST", $url, [
            'timeout' => 10,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                // 'Accept' => 'application/json',
            ],
            'form_params' => $data
        ]);

        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        if ($statusCode == ResponseInterface::HTTP_OK && $returnThis) {
            // Success
            return $response;
        } else if ($statusCode == ResponseInterface::HTTP_OK && !$returnThis) {
            return $body;
        } else {
            return $statusCode;
        }
    }
}
