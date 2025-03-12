<?php

namespace App\Models;

use CodeIgniter\Model;

class GamblingHistorieModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'gambling_histories';
    protected $primaryKey = 'gamb_ID';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        "gamb_ID",
        "user_id",
        "glco_ID",
        "groupLive_ID",
        "msID",
        "groupId",
        "grId",
        "glco_quantity",
        "glco_lose",
        "glco_win",
        "glco_multiply",
        "glco_refund",
        "glco_delete",
        "glco_cancel",
        "timestamp",
        "gamb_text",
        "isRedelivery",
        "glco_success"
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function predicted($glco_ID, $grId, $msID, $grIdWin = 1)
    {

        try {

            $gamblingAll = $this->where("glco_ID", $glco_ID)->findAll();
            $GroupLiveCardOpenModel = new GroupLiveCardOpenModel();

            $GL_Total_Quantity = 0;
            $GL_Total_Payment = 0;
            $GL_Remaining_Balance = 0;
            $GL_Games_Played = count($gamblingAll);

            $GL_Win_Total = 0;
            $GL_Loss_Total = 0;

            foreach ($gamblingAll as $k => $item) {

                $user_id = $item->user_id;
                $glco_quantity = $item->glco_quantity;

                // 
                $glco_multiply = $item->msID != 3 ? $item->glco_multiply : $grIdWin;

                $glco_lose = 0;
                $glco_win = 0;
                $glco_refund = 0;

                $GL_Total_Quantity += $glco_quantity;

                $gamb_ID = $item->gamb_ID;
                if ($grId == $item->grId) {
                    $GL_Win_Total++;
                    //  ทายถูก
                    $glco_win = 1;
                    $glco_refund = (floatval($glco_quantity) * $glco_multiply) + floatval($glco_quantity);

                    $GL_Total_Payment += $glco_refund;

                    $MembersModel = new MembersModel();
                    $MemberStatementModel = new MemberStatementModel();

                    $memberRow = $MembersModel
                        ->select("user_id,user_remain")
                        ->find($user_id);

                    $user_remain = floatval($memberRow->user_remain) + $glco_refund;

                    $StatementInsert = [
                        "user_id" => $user_id,
                        "statement_IN" => 1,
                        "statement_OUT" => 0,
                        "status_id" => 10,
                        "statement_note" => '-',
                        "statement_remain" => $user_remain,
                        "money_out" => null,
                        "money_incoming" => $glco_refund,
                        'ac_code' => SYS_CODE ?? null,
                        "statement_slip" => null,
                        "blit_id" => SYS_BANK ?? null,
                        "gamb_ID" => $gamb_ID,
                    ];

                    try {

                        $MemberStatementModel->save($StatementInsert);
                        $MembersModel->update($user_id, [
                            "user_remain" => $user_remain
                        ]);

                    } catch (\Throwable $e) {
                        log_message(1, $e->getMessage());
                        return false;
                    }
                } else {
                    // ทายผิด
                    $glco_lose = 1;
                    $GL_Loss_Total++;
                }

                $this->update($gamb_ID, [
                    "glco_lose" => $glco_lose,
                    "glco_win" => $glco_win,
                    "glco_refund" => $glco_refund,
                    "glco_success" => 1
                ]);

            }

            $GL_Remaining_Balance = $GL_Total_Quantity - $GL_Total_Payment;
            $GroupLiveCardOpenModel->update($glco_ID, [
                "datetime" => date("Y-m-d H:i:s"),
                "GL_Total_Quantity" => $GL_Total_Quantity,
                "GL_Total_Payment" => $GL_Total_Payment,
                "GL_Remaining_Balance" => $GL_Remaining_Balance,
                "GL_Confirm_Result" => 1,
                "GL_Confirm_User" => session('ac_code') ?? null,
                "GL_Win_Total" => $GL_Win_Total,
                "GL_Loss_Total" => $GL_Loss_Total,
                "GL_Games_Played" => $GL_Games_Played,
            ]);

            if (!empty($gamblingAll)) {
                return $gamblingAll;
            } else {
                return null;
            }
        } catch (\Throwable $e) {
            return false;
        }
    }
}
