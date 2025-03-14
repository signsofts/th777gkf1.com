<?php

namespace App\Controllers\Resources;

use App\Models\GroupMemberListModel;
use App\Models\MembersModel;
use App\Models\MemberStatementModel;
use CodeIgniter\RESTful\ResourceController;
use stdClass;

class MemberResource extends ResourceController
{

    protected $modelName = 'App\Models\MembersModel';
    protected $format = 'json';

    public function index()
    {

        $MembersModel = new MembersModel();
        $GroupMemberListModel = new GroupMemberListModel();
        $MemberStatementModel = new MemberStatementModel();
        $list = $MembersModel->where("userDelete", '0')
            ->select("$MembersModel->table.*")
            ->select("accounts_admin.ac_fname AS AGENT_FNAME")
            ->select("accounts_admin.ac_lname AS AGENT_LNAME")
            ->select("accounts_admin.ac_niname AS AGENT_NINAME")
            ->join("accounts_admin", "accounts_admin.ac_code = $MembersModel->table.user_agent", "left")
            ->findAll();
        // $momneySum =  0;
        foreach ($list as $key => $item) {

            // $momneySum += floatval($item->user_remain);
            $groupMemberRow = $GroupMemberListModel
                ->where("user_id", $item->user_id)
                ->where("$GroupMemberListModel->table.listDelete", "0")
                ->join("groups", "groups.groupId = $GroupMemberListModel->table.groupId", "inner")
                ->findAll();
            $item->group = $groupMemberRow;

            $MemberStatementRow = $MemberStatementModel
                ->where("user_id", $item->user_id)
                ->join("status", "status.status_id = {$MemberStatementModel->table}.status_id", 'left')
                ->join("accounts_admin", "accounts_admin.ac_code = {$MemberStatementModel->table}.ac_code", 'inner')
                ->join("banklists", "banklists.blit_id = {$MemberStatementModel->table}.blit_id", 'inner')
                ->join("banks", "banks.bank_id = banklists.bank_id", 'inner')
                ->orderBy("{$MemberStatementModel->table}.created_at", 'DESC')
                ->findAll();

            $item->statements = $MemberStatementRow;
        }



        return $this->respond($list, 200);
    }

    public function show($id = null)
    {
        $MembersModel = new MembersModel();
        $GroupMemberListModel = new GroupMemberListModel();
        $MemberStatementModel = new MemberStatementModel();
        $item = $MembersModel
            ->select("$MembersModel->table.*")
            ->select("accounts_admin.ac_fname AS AGENT_FNAME")
            ->select("accounts_admin.ac_lname AS AGENT_LNAME")
            ->select("accounts_admin.ac_niname AS AGENT_NINAME")
            ->join("accounts_admin", "accounts_admin.ac_code = $MembersModel->table.user_agent", "left")
            ->find($id);

        $groupMemberRow = $GroupMemberListModel
            ->where("user_id", $item->user_id)
            ->where("$GroupMemberListModel->table.listDelete", "0")
            ->join("groups", "groups.groupId = $GroupMemberListModel->table.groupId", "inner")
            ->findAll();
        $item->group = $groupMemberRow;

        $MemberStatementRow = $MemberStatementModel
            ->select("*")
            ->select("{$MemberStatementModel->table}.created_at as mscreated_at")
            ->where("user_id", $item->user_id)
            ->join("status", "status.status_id = {$MemberStatementModel->table}.status_id", 'left')
            ->join("accounts_admin", "accounts_admin.ac_code = {$MemberStatementModel->table}.ac_code", 'left')
            ->join("banklists", "banklists.blit_id = {$MemberStatementModel->table}.blit_id", 'left')
            ->join("banks", "banks.bank_id = banklists.bank_id", 'left')
            ->orderBy("mscreated_at", 'DESC')
            ->findAll();
        $item->statements = $MemberStatementRow;

        return $this->respond($item);
    }

    public function new()
    {
        $MembersModel = new MembersModel();
    }

    public function create()
    {
        $MembersModel = new MembersModel();
    }

    public function edit($id = null)
    {
        $MembersModel = new MembersModel();
    }

    public function update($id = null)
    {
        $request = \Config\Services::request();

        $MembersModel = new MembersModel();

        if ($request->getMethod() !== 'PATCH') {
            return $this->fail('Invalid request method', 405);
        }

        // Get the input data from the request body
        $data = $request->getJSON();

        if (!$data) {
            // return $this->fail('No data provided', 400);
            return $this->respond(["error" => 'Failed to update data', "status" => false], 401);
        }

        $MembersModel->update($data->user_id, [
            "user_address" => $data->user_address,
            "user_bank" => $data->user_bank,
            "user_bankFName" => $data->user_bankFName,
            "user_bankLName" => $data->user_bankLName,
            "user_bankNumber" => $data->user_bankNumber,
            "user_email" => $data->user_email,
            "user_fname" => $data->user_fname,
            "user_lname" => $data->user_lname,
            "user_phone" => $data->user_phone,
            "user_zipCode" => $data->user_zipCode,
            "user_country" => $data->user_country,
            "language" => $data->language,

        ]);

        return $this->respond(["message" => 'save data Success!', "status" => true], 200);
    }

    public function delete($id = null)
    {

        $request = \Config\Services::request();

        $MembersModel = new MembersModel();
        // $MembersModel->delete($id);

        $data = $request->getJSON();
        
        $MembersModel->update($data->user_id, [
            "userDelete" => '1',
            "deleted_at" => date("Y-m-d H:i:s")
        ]);



        return $this->respond(['message' => "", "data" => $data, "status" => true], 200);
    }
}
