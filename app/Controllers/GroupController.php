<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GameMasterModel;
use App\Models\GroupLiveModel;
use App\Models\GroupMemberListModel;
use App\Models\GroupModel;
use CodeIgniter\API\ResponseTrait;

class GroupController extends BaseController
{
    // use ResponseInterface;
    use ResponseTrait;

    public function index()
    {

        $resp = $this->requestApi(base_url("api/v1/resource/group"), "GET", [], false, ["lang" => get_cookie('lang') ?? "en"]);

        $data = json_decode($resp);

        $moneySum = 0; // ยอดเล่นทั้งหมด
        $moneyPay = 0; // ยอดจ่ายคืน
        $moneyTotle = 0; // ยอดจคงเหลือ
        $LiveCount = 0; // ยอดจคงเหลือ

        foreach ($data as $key => $value) {
            $moneySum += $value->GRO_Total_Quantity;
            $moneyPay += $value->GRO_Total_Payment;

            $LiveCount += $value->LiveCount;
        }
        $moneyTotle = $moneySum - $moneyPay;

        $this->setViewData("gRow", $data);
        $this->setViewData("moneySum", $moneySum);
        $this->setViewData("moneyPay", $moneyPay);
        $this->setViewData("moneyTotle", $moneyTotle);
        $this->setViewData("LiveCount", $LiveCount);




        // return $this->respond($this->viewData, 200);
        return view('pages/group/index', $this->viewData);
    }


    public function groupView($groupId)
    {
        if (empty($groupId)) {
            return redirect()->to(base_url());
        }

        $GameMasterModel = new GameMasterModel();
        $GroupModel = new GroupModel();

        $GroupMemberListModel = new GroupMemberListModel();
        // $GameRuleModel = new GameRuleModel();
        $GroupLiveModel = new GroupLiveModel();

        $gRow = $GroupModel
            ->where("groupId", $groupId)
            ->join("gamemasters", "gamemasters.msId ={$GroupModel->table}.msId", "left")
            ->first();
        $gRow->members = $GroupMemberListModel
            ->where("groupId", $groupId)
            ->join("members", 'members.user_id = groupmemberlists.user_id', 'inner')
            ->findAll();
        // $gRow->gamekey = $GameRuleModel
        //     ->where("msID", $gRow->msID)
        //     ->findAll();
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
        // return $this->respond($gRow) ;
        $this->viewData['group'] = $gRow;
        $this->viewData['gamemasters'] = $GameMasterModel->where("msDelete", 0)->findAll();
        return view('pages/group/show', $this->viewData);
    }
}
