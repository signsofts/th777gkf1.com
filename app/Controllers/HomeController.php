<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BanklistModel;
use App\Models\GroupLiveModel;
use App\Models\GroupModel;
use App\Models\MembersModel;
use CodeIgniter\API\ResponseTrait;

class HomeController extends BaseController
{
    use ResponseTrait;
    public function index()
    {

        $BanklistModel = new BanklistModel();
        $MembersModel = new MembersModel();
        $GroupModel = new GroupModel();
        $BanklistModel = new BanklistModel();
        $GroupLiveModel = new GroupLiveModel();

        $subbamk = $BanklistModel->selectSum("blit_remain")->first();
        $memberCount = $MembersModel->selectCount('user_id')->first();
        $groupCount = $GroupModel->selectCount('groupId')->first();
        $bankCount = $BanklistModel->selectCount('blit_id')->whereNotIn("blit_id", [SYS_BANK])->first();
        $Remaining_Balance = $GroupLiveModel->selectSum("GLI_Remaining_Balance")->where("GLI_Confirm_Result", 1)->first();



        $year = date("Y");
        $MONTH = date("M");
        $ChartData = [];
        $db = db_connect();

        for ($i = 1; $i <= 12; $i++) {
            $sumMo = 0;
            $q_r = $db->query("SELECT YEAR
                            ( created_at ) AS YEAR,
                            MONTH ( created_at ) AS MONTH,
                            SUM( GLI_Remaining_Balance ) AS total_amount 
                        FROM
                            group_lives 
                        WHERE
                            YEAR ( created_at ) = '$year' 
                            AND MONTH ( created_at ) = '$i' 
                        GROUP BY
                            YEAR ( created_at ),
                            MONTH ( created_at ) 
                        ORDER BY
                            YEAR ( created_at ),
                            MONTH ( created_at );");
            $getRowObject = $q_r->getRowObject() === null ? 0.00 : floatval($q_r->getRowObject()->total_amount) + 0.00;
            array_push($ChartData, $getRowObject);
        }

        // dd($ChartData);
        $this->setViewData("blit_remain", $subbamk->blit_remain);
        $this->setViewData("memberCount", $memberCount->user_id);
        $this->setViewData("groupCount", $groupCount->groupId);
        $this->setViewData("bankCount", $bankCount->blit_id);
        $this->setViewData("remainingCount", $Remaining_Balance->GLI_Remaining_Balance);
        $this->setViewData("ChartData", $ChartData);
        // dd($subbamk->blit_remain);

        return view('dashboard', $this->viewData);
    }
}
