<?php

namespace App\Controllers\Resources;

use App\Libraries\MessageKeyLibrarie;
use App\Libraries\TempLineMessage;
use App\Models\GamblingHistorieModel;
use App\Models\GameRuleModel;
use App\Models\GroupLiveCardOpenModel;
use App\Models\GroupLiveModel;
use App\Models\GroupModel;
use CodeIgniter\RESTful\ResourceController;

class GroupLiveCardOpenResource extends ResourceController
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
        $GamblingHistorieModel = new GamblingHistorieModel();

        $row = $GroupLiveCardOpenModel
            ->select("*")
            ->select("group_lives.msID AS liveMsID")
            // ->where("{$GroupLiveModel->table}.RoleID !=", '4')
            ->join('group_lives', "group_lives.groupLive_ID = group_live_card_opens.groupLive_ID ", "inner")
            ->join('groups', "groups.groupId = group_live_card_opens.groupId ", "inner")
            ->join('gamemasters', "gamemasters.msID = group_live_card_opens.msID ", "inner")
            ->join('gamerules', "gamerules.grId = group_live_card_opens.grId ", "left")
            ->find($id);

        $row->next = ($row->glco_count + 1);
        $row->previous = ($row->glco_count - 1) == 0 ? 0 : $row->glco_count - 1;
        // $row->nextID = $id + 1;

        $row->gamerules = $GameRuleModel
            ->where("msID", $row->liveMsID)
            ->findAll();

        $Gambling = $GamblingHistorieModel
            ->select("*")
            ->select("$GamblingHistorieModel->table.created_at as gambcreated_at")
            ->select("members.pictureUrl as memberpictureUrl")
            ->where("glco_ID", $id)
            ->join('group_lives', "group_lives.groupLive_ID = {$GamblingHistorieModel->table}.groupLive_ID", "inner")
            ->join('members', "members.user_id = {$GamblingHistorieModel->table}.user_id ", "inner")
            ->join('gamemasters', "gamemasters.msID = {$GamblingHistorieModel->table}.msID ", "inner")
            ->join('groups', "groups.groupId = {$GamblingHistorieModel->table}.groupId ", "inner")
            // ->join('group_live_card_opens', "group_live_card_opens.glco_ID = {$GamblingHistorieModel->table}.glco_ID", "inner")
            ->join('gamerules', "gamerules.grId = {$GamblingHistorieModel->table}.grId", "inner")
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
        // $row->session = $_SESSION;

        return $this->respond($row, 200);
    }

    public function new()
    {
        //
    }

    public function create()
    {
    }

    public function edit($id = null)
    {
        //
    }

    public function update($id = null)
    {
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

        // $GroupLiveModel = new GroupLiveModel();
        $GroupModel = new GroupModel();
        // $GameRuleModel = new GameRuleModel();
        $GroupLiveCardOpenModel = new GroupLiveCardOpenModel();
        $GamblingHistorieModel = new GamblingHistorieModel();

        $glco_ID = $data->glco_ID;
        $grId = $data->grId;
        $groupLive_ID = $data->groupLive_ID;
        $groupId = $data->groupId;

        // Multiplication rate
        $grIdWin = isset($data->grIdWin) ? (int) $data->grIdWin : 1;
        $msID = $data->msID;

        $resp = $GamblingHistorieModel->predicted($glco_ID, $grId, $msID, $grIdWin);

        
        if ($resp === false) {
            // return $this->fail('Failed to update data', 401);
            return $this->respond(["error" => 'Failed to update data', "status" => false], 401);
        }
        $g_row = $GroupModel->find($groupId);
        $langing = \Config\Services::language()->setLocale($g_row->group_language ?? "en");
        $GroupLiveCardOpenModel->update($glco_ID, [
            "grId" => $grId,
            "status_id" => 8,
            "GLCO_STEP" => 4,
        ]);

        $MessageKeyLibrarie = new MessageKeyLibrarie();
        $TempLineMessage = new TempLineMessage("System");
        $tempMessage = $TempLineMessage->historyGames($groupLive_ID);
        $MessageKeyLibrarie->sendMessageFormWeb($groupId, [$tempMessage]);

        $result = true;
        if ($result) {
            return $this->respond(['success' => 'Data updated successfully', "status" => true], 200);
        } else {
            return $this->respond(["error" => 'Failed to update data', "status" => false], 401);
        }
    }

    public function delete($id = null)
    {
    }
}
