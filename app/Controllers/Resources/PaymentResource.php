<?php

namespace App\Controllers\Resources;

use App\Models\BanklistModel;
use App\Models\BankStatementModel;
use App\Models\MembersModel;
use App\Models\MemberStatementModel;
use App\Models\PaymentModel;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use GuzzleHttp\Client;

class PaymentResource extends ResourceController
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

    protected $modelName = 'App\Models\PaymentModel';
    protected $format = 'json';

    public function index()
    {
        $PaymentModel = new PaymentModel();
        $BanklistModel = new BanklistModel();
        $language = \Config\Services::language()->getLocale();

        $row = $PaymentModel
            ->select("payments.*")
            ->select("banklists.*")
            ->select("banks.*")
            ->select("status.*")
            ->select("members.displayName")
            ->join("banklists", "banklists.blit_id = payments.blit_id", 'left')
            ->join("banks", "banks.bank_id = banklists.bank_id", "left")
            ->join("status", "status.status_id = payments.status_id", 'left')
            ->join("members", "members.user_id = payments.user_id", 'inner')
            ->orderBy("payments.PAY_APPROVE", "ASC")
            ->findAll();

        $q = $this->request->getGet("q");

        // return $q; 
        // return $this->respond([ $q]);
        foreach ($row as $key => $item):
            if (!is_null($item->PAY_APPROVE) && !empty($q) && $q == 'n') {
                unset($row[$key]);
                continue;
            }
            $item->status_name = $language == 'th' ? $item->status_name : $item->status_nameEN;
            $item->bank_name = $language == 'th' ? $item->bank_name : $item->bank_nameEN;
            $item->PAY_APPROVE_TEXT = '';

            if (is_null($item->PAY_APPROVE)) {
                $item->PAY_APPROVE_TEXT = lang('global.T4');
            } elseif ($item->PAY_APPROVE == '0') {
                $item->PAY_APPROVE_TEXT = lang('global.T5');
            } else {
                $item->PAY_APPROVE_TEXT = lang('global.T6');
            }
        endforeach;
        return $this->respond($row);
    }

    public function show($id = null)
    {
        $PaymentModel = new PaymentModel();
        $BanklistModel = new BanklistModel();
        $language = \Config\Services::language()->getLocale();



        $row = $PaymentModel
            ->select("payments.*")
            ->select("banklists.*")
            ->select("banks.*")
            ->select("status.*")
            ->select("members.displayName")
            ->select("members.user_bank")
            ->select("members.user_bankNumber")
            ->select("members.user_bankFName")
            ->select("members.user_bankLName")
            ->where("payments.PAY_ID", $id)
            ->join("banklists", "banklists.blit_id = payments.blit_id", 'left')
            ->join("banks", "banks.bank_id = banklists.bank_id", "left")
            ->join("status", "status.status_id = payments.status_id", 'left')
            ->join("members", "members.user_id = payments.user_id", 'inner')
            ->orderBy("payments.PAY_APPROVE", "ASC")
            ->first();

        $row->status_name = $language == 'th' ? $row->status_name : $row->status_nameEN;
        $row->bank_name = $language == 'th' ? $row->bank_name : $row->bank_nameEN;
        $row->PAY_APPROVE_TEXT = '';

        if (is_null($row->PAY_APPROVE)) {
            $row->PAY_APPROVE_TEXT = lang('global.T4');
        } elseif ($row->PAY_APPROVE == '0') {
            $row->PAY_APPROVE_TEXT = lang('global.T5');
        } else {
            $row->PAY_APPROVE_TEXT = lang('global.T6');
        }

        return $this->respond($row);
    }

    public function new()
    {
        //
    }

    public function create()
    {

        $BanklistModel = new BanklistModel();
        $MemberModel = new MembersModel();
        $PaymentModel = new PaymentModel();

        $statement_IN = $this->request->getVar('statement_IN');
        $statement_OUT = $this->request->getVar('statement_OUT');
        $blit_id = $this->request->getVar('blit_id');
        $money = $this->request->getVar('money');
        $user_id = $this->request->getVar('user_id');
        $status_id = $this->request->getVar('status_id');

        $memberRow = $MemberModel->find($user_id);
        if (empty($memberRow)) {
            return $this->respond(['error' => 'User ID ไม่มีอยู่ในตาราง members'], 401);
        }

        if (empty($memberRow)) {
            return $this->respond(['error' => 'empty data'], 401);
        }

        $blit_id = $this->request->getVar('blit_id');
        $bListRow = $BanklistModel->find($blit_id);
        if (empty($bListRow)) {
            return $this->respond(['error' => 'empty data'], 401);
        }

        $statement_slip = null;

        if (isset($_FILES['statement_slip']) && $_FILES['statement_slip']['error'] != 4) {
            $statement_slip = $this->request->getFile('statement_slip');
            $originalName = $statement_slip->getClientName();
            // Define a custom file name if needed
            $newName = $statement_slip->getRandomName(); // You can change this to $originalName if you want to keep the original

            // Move the file to the writable/uploads directory

            $path = WRITEPATH . 'uploads/' . date("Ymd");
            $statement_slip->move($path, $newName);

            $statement_slip = date("Ymd") . "/" . $newName;

        }



        if ($statement_IN == '1' && $statement_OUT == '0') {

            $PAY_DATE = $this->request->getVar('PAY_DATE');
            $PAY_TIME = $this->request->getVar('PAY_TIME');

            $rules = [
                'user_id' => ['rules' => 'required'], //|is_unique[banklists.blit_number]
                'money' => ['rules' => 'required'],
                'blit_id' => ['rules' => 'required'],
                'statement_IN' => ['rules' => 'required'],
                'statement_OUT' => ['rules' => 'required'],
                'status_id' => ['rules' => 'required'],
                'PAY_DATE' => ['rules' => 'required'],
                'PAY_TIME' => ['rules' => 'required'],
            ];



            if (!$this->validate($rules)) {
                return $this->respond(['error' => 'required 188'], 401);
            }

            if (is_null($statement_slip)) {
                return $this->respond(['error' => 'empty data'], 401);
            }

            $DATA = [
                "user_id" => $user_id,
                "PAY_IN" => $statement_IN,
                "PAY_OUT" => $statement_OUT,
                "status_id" => $status_id,
                "blit_id" => $blit_id,
                "PAY_SLIP" => $statement_slip,
                "PAY_MONEY" => $money,
                "PAY_DATE" => $PAY_DATE,
                "PAY_TIME" => $PAY_TIME,
            ];

            $PaymentModel->save($DATA);
            return $this->respond(['success' => 'Insert Data Success', "status" => true], 200);

        } else if ($statement_IN == '0' && $statement_OUT == '1') {

            $rules = [
                'user_id' => ['rules' => 'required'], //|is_unique[banklists.blit_number]
                'money' => ['rules' => 'required'],
                'statement_IN' => ['rules' => 'required'],
                'statement_OUT' => ['rules' => 'required'],
                'status_id' => ['rules' => 'required'],
            ];
            if (!$this->validate($rules)) {
                return $this->respond(['error' => 'required 220'], 401);
            }

            $DATA = [
                "user_id" => $user_id,
                "PAY_IN" => $statement_IN,
                "PAY_OUT" => $statement_OUT,
                "status_id" => $status_id,
                "PAY_MONEY" => $money,
            ];

            $PaymentModel->save($DATA);

            return $this->respond(['success' => 'Insert Data Success', "status" => false], 200);
        } else {
            return $this->respond(['error' => 'Unable to complete the transaction'], 401);
        }
    }

    public function edit($id = null)
    {
        //
    }

    public function update($id = null)
    {
        // return false;
        $data = $this->request->getJsonVar();

        $PAY_ID = $data->PAY_ID;
        $PAY_APPROVE = $data->PAY_APPROVE;

        $blit_id = isset($data->blit_id) ? $data->blit_id : null;

        // return $$blit_id
        $ac_code = session('ac_code') ?? null;

        $PaymentModel = new PaymentModel();
        $BanklistModel = new BanklistModel();

        $payment = $PaymentModel
            ->join("banklists", "banklists.blit_id = payments.blit_id", 'left')
            ->join("banks", "banks.bank_id = banklists.bank_id", "left")
            ->join("status", "status.status_id = payments.status_id", 'left')
            ->join("members", "members.user_id = payments.user_id", 'inner')
            ->find($PAY_ID);
        $return = [];

        if ($PAY_APPROVE == '1') {
            if ($payment->PAY_IN == 1 && $payment->PAY_OUT == 0) {
                $postResp = $this->postApi(
                    base_url('api/v1/resource/mstatements'),
                    session('token'),
                    [
                        "PAY_ID" => $PAY_ID,
                        "user_id" => $payment->user_id,
                        "statement_IN" => $payment->PAY_IN,
                        "statement_OUT" => $payment->PAY_OUT,
                        "_statement_slip" => $payment->PAY_SLIP,
                        "money_incoming" => $payment->PAY_MONEY,
                        "statement_note" => '',
                        "ac_code" => $ac_code,
                        "blit_id" => $payment->blit_id,
                        'status_id' => $payment->status_id,
                        "chk" => true,
                    ],
                    false
                );

                $respIn = json_decode($postResp);

                // print_r( $respIn);

                // if (!isset($respIn->status)) {
                //     echo "lskdfjsdf";
                //     exit;
                // }
                // print_r($respIn);
                // exit;

                if ($respIn->status != 200) {
                    return $this->respond(["message" => "Unable to complete the transaction 307", "status" => false], 200);
                }

                $postResp = $this->postApi(
                    site_url('api/v1/resource/statements'),
                    session('token'),
                    [
                        "blit_id" => $payment->blit_id,
                        "bank_id" => $payment->bank_id,
                        "bstate_IN" => $payment->PAY_IN,
                        "bstate_out" => $payment->PAY_OUT,
                        "type" => 'member',
                        "user_id" => $payment->user_id,
                        "money_incoming" => $payment->PAY_MONEY,
                        "_bstate_slip" => $payment->PAY_SLIP,
                        "bstate_note" => '',
                        "ac_code" => $ac_code,
                        "chk" => true
                    ],
                    false
                );

                $respIn = json_decode($postResp);
                if ($respIn->status !== 200) {
                    return $this->respond(["message" => "Unable to complete the transaction 331", "status" => false], 200);
                }

                $return = ["message" => "The transaction was completed successfully.", "status" => true];
            } else if ($payment->PAY_IN == 0 && $payment->PAY_OUT == 1) {
                $bankList = $BanklistModel->find($blit_id);

                if (empty($bankList)) {
                    return $this->respond(["message" => "Unable to complete the transaction", "status" => false], 200);
                }


                $postResp = $this->postApi(
                    site_url('api/v1/resource/mstatements'),
                    session('token'),
                    [
                        "PAY_ID" => $PAY_ID,
                        "user_id" => $payment->user_id,
                        "statement_IN" => $payment->PAY_IN,
                        "statement_OUT" => $payment->PAY_OUT,
                        "_statement_slip" => $payment->PAY_SLIP,
                        'status_id' => $payment->status_id,
                        "money_out" => $payment->PAY_MONEY,
                        "statement_note" => '',
                        "ac_code" => $ac_code,
                        "blit_id" => $payment->blit_id,
                        "chk" => true,
                    ],
                    false
                );

                $respOut = json_decode($postResp);
                if ($respOut->status !== 200) {
                    return $this->respond(["message" => $respOut->error ?? "Unable to complete the transaction", "status" => false], 200);
                }

                $postResp = $this->postApi(
                    site_url('api/v1/resource/statements'),
                    session('token'),
                    [
                        "user_id" => $payment->user_id,
                        "blit_id" => $bankList->blit_id,
                        "bank_id" => $bankList->bank_id,
                        "bstate_IN" => $payment->PAY_IN,
                        "bstate_out" => $payment->PAY_OUT,
                        "type" => 'member',
                        "money_out" => $payment->PAY_MONEY,
                        "_bstate_slip" => $payment->PAY_SLIP,
                        "bstate_note" => '',
                        'ac_code' => $ac_code,
                        "chk" => true
                    ],
                    false
                );

                $respOut = json_decode($postResp);
                if ($respOut->status !== 200) {
                    return $this->respond(["message" => $respOut->error ?? "Unable to complete the transaction", "status" => false], 200);
                }

                $return = ["message" => "The transaction was completed successfully.", "status" => true];
            } else {
                return $this->respond(["message" => "Unable to complete the transaction", "status" => false], 200);
            }
        } else {
            $return = ["message" => "The transaction was completed successfully.", "status" => true];
        }

        $PaymentModel->update($PAY_ID, [
            "PAY_APPROVE" => $PAY_APPROVE,
            "PAY_APPROVE_USER" => $ac_code,
            "PAY_APPROVE_TIME" => date("Y-m-d H:i:s"),
        ]);

        return $this->respond($return, 200);
    }

    public function delete($id = null)
    {
        //
    }

    public function postApi($url, $token, $data = array(), $returnThis = false)
    {
        if (!$token) {
            return false;
        }

        $client = new Client();
        $response = $client->request("POST", $url, [
            'timeout' => 10,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => $data
        ]);

        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        if ($statusCode == ResponseInterface::HTTP_OK && $returnThis) {
            return $response;
        } else if ($statusCode == ResponseInterface::HTTP_OK && !$returnThis) {
            return $body;
        } else {
            return $statusCode;
        }
    }
    public function postApif($url, $data = array(), $returnThis = false, $token)
    {

        if (!$token) {
            return false;
        }

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
