<?php

namespace App\Controllers\Resources;

use App\Libraries\MessageKeyLibrarie;
use App\Models\GameRuleModel;
use App\Models\GroupLiveCardOpenModel;
use App\Models\GroupLiveModel;
use App\Models\GroupModel;
use CodeIgniter\RESTful\ResourceController;

class GroupLiveResource extends ResourceController
{

    protected $modelName = 'App\Models\GroupLiveModel';
    protected $format = 'json';

    public function index()
    {
    }

    public function show($id = null)
    {
        $GroupLiveModel = new GroupLiveModel();
        $GameRuleModel = new GameRuleModel();
        $GroupLiveCardOpenModel = new GroupLiveCardOpenModel();
        $list = $GroupLiveModel
            ->where("{$GroupLiveModel->table}.glDelete", '0')
            // ->where("{$GroupLiveModel->table}.RoleID !=", '4')
            ->join('groups', "groups.groupId = {$GroupLiveModel->table}.groupId ", "inner")
            ->join('gamemasters', "gamemasters.msID = {$GroupLiveModel->table}.msID ", "inner")
            ->find($id);

        $list->rule = $GameRuleModel->where("msID", $list->msID)->findAll();

        $list->cardOpen = $GroupLiveCardOpenModel->where("groupLive_ID", $list->groupLive_ID)
            ->join("status", "status.status_id = group_live_card_opens.status_id", 'inner')
            ->findAll();


        $list->moneySum = 0;
        $list->moneyPay = 0;


        foreach ($list->cardOpen as $key => $item) {

            $list->moneySum += $item->GL_Total_Quantity;
            $list->moneyPay += $item->GL_Total_Payment;


            $item->count_play = 0;
            $item->count_money = 0;
            $item->resule_win = 0;
            $item->resule_los = 0;
            $item->noney_pay = 0;
            $item->noney_sum = 0;
        }

        $list->moneyTotle = $list->moneySum - $list->moneyPay;

        return $this->respond($list, 200);
    }

    public function new()
    {
        //
    }

    public function create()
    {

        $rules = [
            'groupId' => ['rules' => 'required'], //|is_unique[banklists.blit_number]
            'openCardSum' => ['rules' => 'required'],
        ];


        if (!$this->validate($rules)) {
            return $this->respond(["error" => "Validate Error"], 401);
        }

        $GroupLiveModel = new GroupLiveModel();
        $GroupModel = new GroupModel();
        $GroupLiveCardOpenModel = new GroupLiveCardOpenModel();

        $chkstatusCloseLive =  $GroupLiveModel
            ->where("statusCloseLive", "0")
            ->where("glDelete", "0")
            ->where("groupId",  $this->request->getVar("groupId"))
            ->findAll();

        if (count($chkstatusCloseLive) > 0) {
            return $this->respond(["error" => "Close Live"], 401);
        }

        // $save
        $groupRow = $GroupModel->find($this->request->getVar("groupId"));
        // $g_row = $GroupModel->find($_row->groupId);
        // $g_row = $GroupModel->find($_row->groupId);
        $langing  = \Config\Services::language()->setLocale($groupRow->group_language ?? "en");

        $save = $GroupLiveModel->save([
            "groupId" => $this->request->getVar("groupId"),
            "openCardSum" => $this->request->getVar("openCardSum"),
            "msID" =>  $groupRow->msID
        ]);

        $groupLive_ID = $GroupLiveModel->getInsertID();

        for ($i = 1; $i <= $this->request->getVar("openCardSum"); $i++) {
            $status_id = 5;
            $GroupLiveCardOpenModel->save([
                // "glco_ID",
                "groupLive_ID" =>  $groupLive_ID,
                "glco_count" => $i, // รอบที่
                "grId" => null, // ผลแพ้ชนะ
                "msID" => $groupRow->msID,
                "groupId" => $this->request->getVar("groupId"),
                "status_id" =>  $status_id,
            ]);
        }


        $MessageKeyLibrarie =  new MessageKeyLibrarie();
        $MessageKeyLibrarie->sendMessageFormWeb($this->request->getVar("groupId"), [
            [
                "type" => "flex",
                "altText" => lang("line.text.liveBroadcast", ['date' => date("d/m/Y")]),
                "contents" => [
                    "type" => "bubble",
                    "body" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => lang("line.text.liveBroadcast", ['date' => date("d/m/Y")]),
                                "weight" => "bold",
                                "color" => "#1DB446",
                                "size" => "sm"
                            ],
                        ]
                    ],
                    "styles" => [
                        "footer" => [
                            "separator" => true
                        ]
                    ]
                ]
            ]
        ]);

        return $this->respond(["success" => "Open Live Success", "status" => true, "id" => $groupLive_ID], 200);
    }

    public function edit($id = null)
    {
        //
    }

    public function update($id = null)
    {
        //
    }

    public function delete($id = null)
    {
        $GroupLiveModel = new GroupLiveModel();
        $GroupModel = new GroupModel();


        $GroupLiveCardOpenModel = new GroupLiveCardOpenModel();
        $cardRowStatus7 = $GroupLiveCardOpenModel
            ->where("groupLive_ID", $id)
            ->where("status_id", "7")
            ->first();

        if (!empty($cardRowStatus7)) {
            return $this->respond(["error" => "Close Live error", "status" => false], 200);
            // $resp =  $GroupLiveCardOpenModel->predicted($cardRowStatus7->glco_ID, $grId);
        }


        $_row = $GroupLiveModel->find($id);
        $g_row = $GroupModel->find($_row->groupId);
        // $g_row = $GroupModel->find($_row->groupId); 
        $langing  = \Config\Services::language()->setLocale($g_row->group_language ?? "en");

        $cardRow = $GroupLiveCardOpenModel
            ->where("groupLive_ID", $id)
            // ->where("status_id", "5")
            ->findAll();


        $GLI_Total_Quantity = 0;
        $GLI_Total_Payment = 0;
        $GLI_Remaining_Balance = 0;

        foreach ($cardRow as $key => $value) {

            $GLI_Total_Quantity += $value->GL_Total_Quantity ?? 0;
            $GLI_Total_Payment += $value->GL_Total_Payment ?? 0;

            if ($value->status_id == "5") { //รอเปิดไพ่
                $GroupLiveCardOpenModel->update($value->glco_ID, [
                    "glcoCancel" => "1",
                    "status_id" => "6", // ปิดไลฟ์
                    "GLCO_STEP" => 5
                ]);
            }

            $GroupLiveCardOpenModel->update($value->glco_ID, [
                "GLCO_STEP" => 5
            ]);
        }

        $GLI_Remaining_Balance = floatval($GLI_Total_Quantity) -  floatval($GLI_Total_Payment);

        $GroupLiveModel->update($id, [
            "statusCloseLive" => '1',
            "GLI_Total_Quantity" => $GLI_Total_Quantity,
            "GLI_Total_Payment" => $GLI_Total_Payment,
            "GLI_Remaining_Balance" => $GLI_Remaining_Balance,
            "GLI_Confirm_Result" => 1,
        ]);


        $MessageKeyLibrarie =  new MessageKeyLibrarie();
        $MessageKeyLibrarie->sendMessageFormWeb($_row->groupId, [
            [
                "type" => "flex",
                "altText" => lang("line.text.liveBroadcastClose"),
                "contents" => [
                    "type" => "bubble",
                    "body" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => lang("line.text.liveBroadcastClose"),
                                "weight" => "bold",
                                "color" => "#1DB446",
                                "size" => "sm"
                            ],

                        ]
                    ],
                    "styles" => [
                        "footer" => [
                            "separator" => true
                        ]
                    ]
                ]
            ]
        ]);



        return $this->respond(["success" => "Close Live Success", "status" => true], 200);
    }
}
