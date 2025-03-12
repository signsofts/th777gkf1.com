<?php

namespace App\Controllers;

use App\Controllers\BaseUserController;
use App\Libraries\LineLoginLibrarie;
use App\Models\BanklistModel;
use App\Models\GameRuleModel;
use App\Models\GroupLiveModel;
use App\Models\GroupMemberListModel;
use App\Models\GroupModel;
use App\Models\MembersModel;
use App\Models\MemberStatementModel;
use App\Models\PaymentModel;
use CodeIgniter\API\ResponseTrait;
use Exception;

class UsersController extends BaseUserController
{
    use ResponseTrait;

    public function index()
    {
        $user_id = session('user_id');

        if (is_null($user_id)) {
            return $this->signout();
        }
        $MembersModel = new MembersModel();
        $GroupMemberListModel = new GroupMemberListModel();
        $MemberStatementModel = new MemberStatementModel();
        $item = $MembersModel
            ->select("$MembersModel->table.*")
            ->select("accounts_admin.ac_fname AS AGENT_FNAME")
            ->select("accounts_admin.ac_lname AS AGENT_LNAME")
            ->select("accounts_admin.ac_niname AS AGENT_NINAME")
            ->join("accounts_admin", "accounts_admin.ac_code = $MembersModel->table.user_agent", "left")
            ->find($user_id);

        $groupMemberRow = $GroupMemberListModel
            ->where("user_id", $item->user_id)
            ->where("$GroupMemberListModel->table.listDelete", "0")
            ->join("groups", "groups.groupId = $GroupMemberListModel->table.groupId", "inner")
            ->join("gamemasters", "gamemasters.msId =groups.msId", "left")

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


        $GroupModel = new GroupModel();
        $GroupMemberListModel = new GroupMemberListModel();
        $GameRuleModel = new GameRuleModel();
        $GroupLiveModel = new GroupLiveModel();


        // $lag = \Config\Services\language();
        $language = \Config\Services::language()->getLocale();

        $RowRG = $GroupModel
            // ->where("groupId", $groupId)
            ->join("gamemasters", "gamemasters.msId ={$GroupModel->table}.msId", "left")
            ->findAll();

        // $moneySum = 0; // ยอดเล่นทั้งหมด
        // $moneyPay = 0; // ยอดจ่ายคืน
        // $moneyTotle = 0; // ยอดจคงเหลือ
        foreach ($RowRG as $key => $value) {
            $value->langShow = $value->group_language == "th" ? "ไทย" : "English";
            $value->membersCount = $GroupMemberListModel
                ->selectCount("user_id")->first()->user_id;
            $value->LiveCount = $GroupLiveModel

                ->where("groupId", $value->groupId)
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
        }

        $aler = [
            "line" => [
                "status" => is_null($item->userId),
                "getLink" => (new LineLoginLibrarie())->getLink()
            ],
        ];



        $this->setViewData('_row', $item);
        $this->setViewData('_rowR', $RowRG);
        $this->setViewData('aler', $aler);

        // return $this->respond($item, 200);
        return view("pages/users/index", $this->getViewData());
    }


    public function statements()
    {
        $user_id = session('user_id');

        if (is_null($user_id)) {
            return $this->signout();
        }

        $MemberStatementModel = new MemberStatementModel();

        $MemberStatementRow = $MemberStatementModel
            ->select("*")
            ->select("{$MemberStatementModel->table}.created_at as mscreated_at")
            ->where("user_id", $user_id)
            ->join("status", "status.status_id = {$MemberStatementModel->table}.status_id", 'left')
            ->join("accounts_admin", "accounts_admin.ac_code = {$MemberStatementModel->table}.ac_code", 'left')
            ->join("banklists", "banklists.blit_id = {$MemberStatementModel->table}.blit_id", 'left')
            ->join("banks", "banks.bank_id = banklists.bank_id", 'left')
            ->orderBy("mscreated_at", 'DESC')
            ->findAll();

        $statements = $MemberStatementRow;

        $BanklistModel = new BanklistModel();
        $BankAll = $BanklistModel
            ->where("banklists.blit_id !=", SYS_BANK)
            ->join("banks", "banks.bank_id = banklists.bank_id", "inner")
            ->findAll();

        if (empty($BankAll)) {
            return "Empty Banks";
        }

        $index = rand(0, count($BankAll) - 1);
        $banks = $BankAll[$index];

        $PaymentModel = new PaymentModel();
        $payment = $PaymentModel
            ->where("user_id", $user_id)
            // ->whereNotIn("PAY_APPROVE", null)
            ->join("banklists", "banklists.blit_id = {$PaymentModel->table}.blit_id", 'left')
            ->join("banks", "banks.bank_id = banklists.bank_id", "left")
            ->join("status", "status.status_id = {$PaymentModel->table}.status_id", 'left')
            ->findAll();


        $this->setViewData('statements', $statements);
        $this->setViewData('payment', $payment);
        $this->setViewData('banks', $banks);

        // return $this->respond($this->getViewData());
        return view("pages/users/statements", $this->getViewData());
    }

    public function account()
    {
        $user_id = session('user_id');

        if (is_null($user_id)) {
            return $this->signout();
        }
        $MembersModel = new MembersModel();
        $GroupMemberListModel = new GroupMemberListModel();
        $MemberStatementModel = new MemberStatementModel();
        $item = $MembersModel
            ->select("$MembersModel->table.*")
            ->select("accounts_admin.ac_fname AS AGENT_FNAME")
            ->select("accounts_admin.ac_lname AS AGENT_LNAME")
            ->select(select: "accounts_admin.ac_niname AS AGENT_NINAME")
            ->join("accounts_admin", "accounts_admin.ac_code = $MembersModel->table.user_agent", "left")
            ->find($user_id);

        $this->setViewData('_row', $item);
        return view("pages/users/account", $this->getViewData());
    }
    public function signout($type = 1)
    {
        $session = session();
        $session->remove('token');

        $session->remove('pictureUrl');
        $session->remove('user_id');
        $session->remove('user');

        $session->set('type', "users");

        switch ($type) {
            case '2':
                return $this->respond(['msg' => "logout Succesful", "status" => TRUE], 200);
            case '3':
                return ['msg' => "logout Succesful", "status" => TRUE];
            default:

                return redirect()->to(base_url('users/signin'))->with("success", "signout success.");
        }
    }
}
