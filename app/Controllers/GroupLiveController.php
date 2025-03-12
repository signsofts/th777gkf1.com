<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\MessageKeyLibrarie;
use App\Models\GamblingHistorieModel;
use App\Models\GameRuleModel;
use App\Models\GroupLiveCardOpenModel;
use App\Models\GroupLiveModel;
use App\Models\GroupMemberListModel;
use App\Models\GroupModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\Cookie\CookieStore;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use PhpParser\Node\Stmt\Return_;

class GroupLiveController extends BaseController
{
    // use ResponseInterface;
    use ResponseTrait;

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

    public function index($gId, $id)
    {
        if (empty($id)) {
            return redirect()->back()->with('error', "empty data");
        }

        try {
            $GroupLiveModel = new GroupLiveModel();
            $GameRuleModel = new GameRuleModel();
            $GroupLiveCardOpenModel = new GroupLiveCardOpenModel();
            $GamblingHistorieModel = new GamblingHistorieModel();
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
                // $Historie = $GamblingHistorieModel->where("glco_ID", $item->glco_ID)->findAll();
                // $item->historie = $Historie;

                $list->moneySum += $item->GL_Total_Quantity;
                $list->moneyPay += $item->GL_Total_Payment;


                // $item->count_play = 0;
                // $item->resule_win = 0;
                // $item->resule_los = 0;
                // $item->count_money = 0;
                // $item->noney_pay = 0;
                // $item->noney_sum = 0;

                // foreach ($Historie  as $kh => $vh) {
                //     $item->count_play += 1;
                //     $item->count_money += floatval($vh->glco_quantity);

                //     if ($item->GL_Confirm_Result  == 1) {
                //         $item->noney_pay += floatval($vh->glco_refund);

                //         if ($vh->grId == $item->grId) {
                //             $item->resule_win += 1;
                //         } else {
                //             $item->resule_los += 1;
                //         }
                //     }
                // }

                // $item->noney_sum = floatval( $item->count_money) - floatval( $item->noney_pay);
            }

            $list->moneyTotle = $list->moneySum - $list->moneyPay;
            // dd(site_url("api/v1/resource/live/" . $id));
        } catch (\Throwable $e) {
            dd($e->getMessage());
            return;
        }

        // $response = json_decode($resp);
        $this->setViewData('dRow', $list);
        // return $this->respond($this->getViewData());
        return $this->view('pages/group/showLive', $this->getViewData());
    }

    public function openCard($groupId, $groupLive_ID, $glco_count)
    {

        if (empty($groupId) || empty($groupLive_ID) || empty($glco_count)) {
            return redirect()->back()->with('error', "empty data");
        }

        $GroupLiveCardOpenModel = new GroupLiveCardOpenModel();
        $rows = $GroupLiveCardOpenModel
            // ->select("glco_ID")
            ->where("groupId", $groupId)
            ->where("groupLive_ID", $groupLive_ID)
            ->where("glco_count", $glco_count)
            ->first();

        $GroupLiveModel = new GroupLiveModel();
        $GameRuleModel = new GameRuleModel();
        $GroupLiveCardOpenModel = new GroupLiveCardOpenModel();
        $GamblingHistorieModel = new GamblingHistorieModel();

        $row = $GroupLiveCardOpenModel
            ->select("*")
            ->select("group_lives.msID AS liveMsID")
            // ->where("{$GroupLiveModel->table}.RoleID !=", '4')
            ->join('group_lives', "group_lives.groupLive_ID = group_live_card_opens.groupLive_ID ", "inner")
            ->join('groups', "groups.groupId = group_live_card_opens.groupId ", "inner")
            ->join('gamemasters', "gamemasters.msID = group_live_card_opens.msID ", "inner")
            ->join('gamerules', "gamerules.grId = group_live_card_opens.grId ", "left")
            ->find($rows->glco_ID);

        $row->next = ($row->glco_count + 1);
        $row->previous = ($row->glco_count - 1) == 0 ? 0 : $row->glco_count - 1;
        // $row->nextID =  $row->glco_ID + 1;

        $row->gamerules = $GameRuleModel
            ->where("msID", $row->liveMsID)
            ->findAll();

        $Gambling = $GamblingHistorieModel
            ->select("*")
            ->select("$GamblingHistorieModel->table.created_at as gambcreated_at")
            ->select("members.pictureUrl as memberpictureUrl")
            ->where("glco_ID", $rows->glco_ID)
            ->join('group_lives', "group_lives.groupLive_ID = gambling_histories.groupLive_ID", "inner")
            ->join('members', "members.user_id = gambling_histories.user_id ", "inner")
            ->join('gamemasters', "gamemasters.msID = gambling_histories.msID ", "inner")
            ->join('groups', "groups.groupId = gambling_histories.groupId ", "inner")
            // ->join('group_live_card_opens', "group_live_card_opens.glco_ID = gambling_histories.glco_ID", "inner")
            ->join('gamerules', "gamerules.grId = gambling_histories.grId", "inner")
            ->findAll();

        $lang = \Config\Services::language()->getLocale();
        $row->grName = $lang == "th" ? $row->grName : $row->grNameEN;
        foreach ($Gambling as $key => $value) {
            $value->grName = $lang == "th" ? $value->grName : $value->grNameEN;
            // $value->grName =  $lang == "th" ? "sdfdsf" : "+" ;
            $value->result = $row->grName ?? "-";
            $value->money_pay = 0;
            $value->money_sum = 0;
        }

        $row->Gambling = $Gambling;


        $this->setViewData('mRow', $rows);
        $this->setViewData('dRow', $row);
        // return $this->respond($this->getViewData());

        return $this->view('pages/group/openCard', $this->getViewData());
    }

    public function openling($glco_ID)
    {

        $GroupLiveCardOpenModel = new GroupLiveCardOpenModel();
        $GroupLiveCardOpenModel->update($glco_ID, [
            "status_id" => 7,
            "GLCO_STEP" => 2,
        ]);

        $_row = $GroupLiveCardOpenModel->find($glco_ID);

        $GroupModel = new GroupModel();
        $g_row = $GroupModel->find($_row->groupId);
        $langing = \Config\Services::language()->setLocale($g_row->group_language ?? "en");

        $MessageKeyLibrarie = new MessageKeyLibrarie();
        $MessageKeyLibrarie->sendMessageFormWeb($_row->groupId, [
            [
                "type" => "flex",
                "altText" => lang('line.text.Place_bet', ["count" => $_row->glco_count]),
                "contents" => [
                    "type" => "bubble",
                    "body" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => lang('line.text.Place_bet', ["count" => $_row->glco_count]),
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


        return $this->respond(["success" => "Open Success", "status" => true], 200);
    }
    public function stoping($glco_ID)
    {

        $GroupLiveCardOpenModel = new GroupLiveCardOpenModel();
        $GroupLiveCardOpenModel->update($glco_ID, [
            // "status_id" => 7,
            "GLCO_STEP" => 3,
        ]);

        $_row = $GroupLiveCardOpenModel->find($glco_ID);

        $GroupModel = new GroupModel();
        $g_row = $GroupModel->find($_row->groupId);
        $langing = \Config\Services::language()->setLocale($g_row->group_language ?? "en");

        $MessageKeyLibrarie = new MessageKeyLibrarie();
        $MessageKeyLibrarie->sendMessageFormWeb($_row->groupId, [
            [
                "type" => "flex",
                "altText" => lang('line.text.stop_bet', ["count" => $_row->glco_count]),
                "contents" => [
                    "type" => "bubble",
                    "body" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => lang('line.text.stop_bet', ["count" => $_row->glco_count]),
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


        return $this->respond(["success" => "Open Success", "status" => true], 200);
    }
}
