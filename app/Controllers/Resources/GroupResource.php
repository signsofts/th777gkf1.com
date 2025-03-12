<?php

namespace App\Controllers\Resources;

use App\Models\GameRuleModel;
use App\Models\GroupLiveModel;
use App\Models\GroupMemberListModel;
use App\Models\GroupModel;
use CodeIgniter\RESTful\ResourceController;

class GroupResource extends ResourceController
{

    protected $modelName = 'App\Models\GroupModel';
    protected $format = 'json';

    public function index()
    {
        $GroupModel = new GroupModel();
        $GroupMemberListModel = new GroupMemberListModel();
        $GameRuleModel = new GameRuleModel();
        $GroupLiveModel = new GroupLiveModel();


        // $lag = \Config\Services\language();
        $language = \Config\Services::language()->getLocale();

        $Row = $GroupModel
            // ->where("groupId", $groupId)
            ->join("gamemasters", "gamemasters.msId ={$GroupModel->table}.msId", "left")
            ->findAll();

        // $moneySum = 0; // ยอดเล่นทั้งหมด
        // $moneyPay = 0; // ยอดจ่ายคืน
        // $moneyTotle = 0; // ยอดจคงเหลือ
        foreach ($Row as $key => $value) {
            $value->langShow = $value->group_language == "th" ? "ไทย" : "English";
            $value->membersCount = $GroupMemberListModel
                ->selectCount("user_id")->first()->user_id;
            // ->where("groupId", $value->groupId)
            // ->join("members", 'members.user_id = groupmemberlists.user_id', 'inner')
            // ->findAll();
            // $value->gamekey = $GameRuleModel
            //     ->where("msID", $value->msID)
            //     ->findAll();
            $value->LiveCount = $GroupLiveModel
                // ->select("*")
                // ->select("{$GroupLiveModel->table}.created_at as liveCreated_at")
                ->where("groupId", $value->groupId)
                // ->join("gamemasters", "gamemasters.msId ={$GroupLiveModel->table}.msId", "inner")
                // ->orderBy("liveCreated_at", "DESC")
                ->selectCount("groupLive_ID")->first()->groupLive_ID;
            switch ($language) {
                case 'th':
                    $value->status = $value->groupDelete == 0 ? lang("global.page.g-index.text.statusIN") : lang("global.page.g-index.text.statusOut");
                    break;
                default:
                    $value->status = $value->groupDelete == 0 ? lang("global.page.g-index.text.statusIN") : lang("global.page.g-index.text.statusOut");
                    break;
            }
            $value->status = $value->groupDelete == 0 ? lang("global.page.g-index.text.statusIN") : lang("global.page.g-index.text.statusOut");

            // foreach ($value->lives as $k => $item) {
            // $moneySum += $value->GRO_Total_Quantity;
            // $moneyPay += $value->GRO_Total_Payment;
            // }

            // $moneyTotle = $moneySum - $moneyPay;

            // $gRow[] =  $value ;
        }


        return $this->respond($Row, 200);
    }

    public function show($groupId = null)
    {
        $GroupModel = new GroupModel();

        $GroupMemberListModel = new GroupMemberListModel();
        $GameRuleModel = new GameRuleModel();
        $GroupLiveModel = new GroupLiveModel();

        $gRow = $GroupModel
            ->where("groupId", $groupId)
            ->join("gamemasters", "gamemasters.msId ={$GroupModel->table}.msId", "left")
            ->first();
        $gRow->members = $GroupMemberListModel
            ->where("groupId", $groupId)
            ->join("members", 'members.user_id = groupmemberlists.user_id', 'inner')
            ->findAll();
        $gRow->gamekey = $GameRuleModel
            ->where("msID", $gRow->msID)
            ->findAll();
        $gRow->lives = $GroupLiveModel
            ->select("*")
            ->select("{$GroupLiveModel->table}.created_at as liveCreated_at")
            ->where("groupId", $groupId)
            ->join("gamemasters", "gamemasters.msId ={$GroupLiveModel->table}.msId", "inner")
            ->orderBy("liveCreated_at", "DESC")
            ->findAll();

        $gRow->moneySum = 0; // ยอดเล่นทั้งหมด
        $gRow->moneyPay = 0; // ยอดจ่ายคืน
        $gRow->moneyTotle = 0; // ยอดจคงเหลือ

        foreach ($gRow->lives as $key => $value) {
            $gRow->moneySum += $value->GLI_Total_Quantity;
            $gRow->moneyPay += $value->GLI_Total_Payment;
        }

        $gRow->moneyTotle = $gRow->moneySum - $gRow->moneyPay;


        return $this->respond($gRow, 200);
    }

    public function new()
    {
        //
    }

    public function create()
    {
        //
    }

    public function edit($id = null)
    {
        //
    }

    public function update($id = null)
    {
        //
        $request = \Config\Services::request();

        // Check if the request method is PATCH

        if ($request->getMethod() !== 'PATCH') {
            return $this->fail('Invalid request method', 405);
        }

        // Get the input data from the request body
        $data = $request->getJSON();

        if (!$data) {
            // return $this->fail('No data provided', 400);
            return $this->respond(["error" => 'Failed to update data', "status" => false], 401);
        }


        $GroupModel = new GroupModel();
        $GroupModel->update($data->groupId, [
            "group_language" => $data->group_language,
            "msID" => $data->msID,
            "GRO_InviteLink" => $data->GRO_InviteLink,
        ]);

        return $this->respond(["success" => "update Data Success", "status" => true], 200);
    }

    public function delete($id = null)
    {
        //
    }
}
