<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountsAdminModel;
use App\Models\RolesModel;
use CodeIgniter\API\ResponseTrait;
use stdClass;

class ReoprtsController extends BaseController
{
    use ResponseTrait;
    public function agent()
    {
        return view('pages/admin/report-agent', $this->viewData);
    }

    public function agentSum()
    {

        $sumUser = new stdClass();
        $sumUser->labels = [];
        $sumUser->series = [];


        $sumProfit = new stdClass();
        $sumProfit->labels = [];
        $sumProfit->series = [];


        $AccountsAdminModel = new AccountsAdminModel();
        $_rows = $AccountsAdminModel
            ->select("{$AccountsAdminModel->table}.ac_code")
            ->select("{$AccountsAdminModel->table}.ac_niname")
            ->select("{$AccountsAdminModel->table}.ac_referral")
            ->selectCount("members.user_id", 'uCount')
            ->join("members", "members.user_agent = {$AccountsAdminModel->table}.ac_code", "left")
            ->where("{$AccountsAdminModel->table}.ac_delete", 0)
            ->where("{$AccountsAdminModel->table}.RoleID !=", '4')
            ->where("{$AccountsAdminModel->table}.ac_code !=", SYS_CODE)
            ->groupBy("{$AccountsAdminModel->table}.ac_code")
            ->findAll();

        foreach ($_rows as $key => $value) {
            array_push($sumUser->labels, (string)$value->ac_niname . "($value->ac_referral)");
            array_push($sumUser->series, $value->uCount);
        }

        return $this->respond(["sumUser" => $sumUser], 200);
    }
}
