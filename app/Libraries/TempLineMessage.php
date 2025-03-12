<?php

namespace App\Libraries;

use App\Models\GamblingHistorieModel;
use App\Models\GameMasterModel;
use App\Models\GameRuleModel;
use App\Models\GroupLiveCardOpenModel;
use App\Models\GroupLiveModel;
use App\Models\GroupModel;
use App\Models\MembersModel;
use stdClass;

class TempLineMessage
{

    private $senderName;
    private $tempMsg = NULL;

    private $altText = 'Message';

    function __construct($senderName = NULL, $altText = NULL)
    {
        $this->tempMsg = json_decode(file_get_contents(WRITEPATH . "lineMessage/temp.json"));
        if (!is_null($senderName)) {
            $this->setSenderName($senderName);
        }

        if (!is_null($altText)) {
            $this->setaltText($altText);
            $this->tempMsg->altText = $altText;
        }
    }

    public function getTempBank($number, $nameBank, $name, $image)
    {
        $bankTemp = json_decode(file_get_contents(WRITEPATH . "lineMessage/bankTemp.json"), TRUE);
        $bankTemp['hero']['url'] = $image;
        $bankTemp['body']['contents'][0]['text'] = $number; // เลข บัญชี
        $bankTemp['body']['contents'][1]['contents'][0]['contents'][1]['text'] = $nameBank; // ชื่อธนาคาร
        $bankTemp['body']['contents'][1]['contents'][1]['contents'][1]['text'] = $name; // ชื่อบุคคล

        $this->tempMsg->contents = $bankTemp;

        return $this->tempMsg;
    }

    public function historyGames($groupLive_ID)
    {
        $tempJson = json_decode(file_get_contents(WRITEPATH . "lineMessage/summaryLiveCards.json"), TRUE);

        $langing = \Config\Services::language()->getLocale();

        $GroupLiveModel = new GroupLiveModel();
        $GroupLiveCardOpenModel = new GroupLiveCardOpenModel();
        $GameRuleModel = new GameRuleModel();
        $_rowLive = $GroupLiveModel->find($groupLive_ID);
        $_rowAllGaameRule = $GameRuleModel
            ->where("msID", $_rowLive->msID)
            ->findAll();

        $tempJson['body']['contents'][0]['contents'][0]['text'] = lang('line.text.summeryTitle');
        $tempJson['body']['contents'][0]['contents'][1]['text'] = "#" . sprintf("GL-%05d", $groupLive_ID);
        foreach ($_rowAllGaameRule as $key => $value) {
            $tempIcon = new stdClass();
            $tempIcon->type = "icon";
            $tempIcon->size = "sm";
            $tempIcon->margin = "sm";
            $tempIcon->url = $value->grUrlIcon;

            $tempText = new stdClass();
            $tempText->type = "text";
            $tempText->text = "";
            $tempText->size = "sm";
            $tempText->wrap = TRUE;
            $tempText->margin = "sm";
            switch ($langing) {
                case 'th':
                    $tempText->text = $value->grName;
                    break;
                default:
                    $tempText->text = $value->grNameEN;
                    break;
            }
            array_push($tempJson['body']['contents'][1]['contents'], $tempIcon);
            array_push($tempJson['body']['contents'][1]['contents'], $tempText);
        }


        $_rAll = $GroupLiveCardOpenModel
            ->where("group_live_card_opens.groupLive_ID", $groupLive_ID)
            ->where("group_live_card_opens.status_id", 8)
            ->join("gamerules", "gamerules.grId = group_live_card_opens.grId", "inner")
            ->orderBy("group_live_card_opens.datetime", "ASC")
            ->findAll();

        $rows_per_page = 18;
        $current_page = 0;
        $current_number = 0;
        foreach ($_rAll as $key => $value) {

            $tResulteGameRow = new stdClass();
            $tResulteGameRow->type = "box";
            $tResulteGameRow->layout = "baseline";
            $tResulteGameRow->margin = "xs";
            $tResulteGameRow->maxWidth = "100%";
            $tResulteGameRow->contents = [];

            if ($current_page == 0) {
                array_push($tempJson['body']['contents'][3]['contents'], $tResulteGameRow);
            }

            if ($current_number >= $rows_per_page) {
                $current_page++;
                $current_number = 0;
            }

            // log_message("error", json_encode($current_page));

            $tResulteGameCol = new stdClass();
            $tResulteGameCol->type = "icon";
            $tResulteGameCol->size = "md";
            $tResulteGameCol->url = $value->grUrlIcon;
            $tResulteGameCol->scaling = TRUE;

            array_push($tempJson['body']['contents'][3]['contents'][$current_page]->contents, $tResulteGameCol);

            $current_number++;
        }

        $this->tempMsg->contents = $tempJson;
        return $this->tempMsg;
    }

    public function getRulesForPlay($msID)
    {
        $tempJson = json_decode(file_get_contents(WRITEPATH . "lineMessage/rulesForPlay.json"), TRUE);
        $langing = \Config\Services::language()->getLocale();

        $GameMasterModel = new GameMasterModel();
        $GameRuleModel = new GameRuleModel();
        $_row = $GameMasterModel->find($msID);
        $_d = $langing == 'th' ? $_row->msRulesForPlayTH ?? " - " : $_row->msRulesForPlayEN ?? " - ";

        $tempJson['body']['contents'][0]['text'] = lang('line.text.RulesForPlay');
        $tempJson['body']['contents'][1]['text'] = $_d;

        $_r1 = $GameRuleModel->where('msID', $msID)
            ->orderBy("grKeyLine", "ASC")
            ->findAll();
        foreach ($_r1 as $key => $value) {

            switch ($langing) {
                case 'th':
                    $text = "{$value->grTextRulesTH}";
                    break;
                default:
                    $text = "{$value->grTextRulesEN}";
                    break;
            }
            $col_1 = new stdClass();
            $col_1->type = "text";
            $col_1->text = $text;
            $col_1->size = "md";
            $col_1->color = "#111111";
            $col_1->margin = "sm";

            array_push($tempJson['body']['contents'], $col_1);
        }
        $this->tempMsg->contents = $tempJson;
        return $this->tempMsg;
    }

    public function getHowToPlay($msID)
    {
        $tempJson = json_decode(file_get_contents(WRITEPATH . "lineMessage/howToPlay.json"), TRUE);
        $langing = \Config\Services::language()->getLocale();

        $GameMasterModel = new GameMasterModel();
        $GameRuleModel = new GameRuleModel();
        $_row = $GameMasterModel->find($msID);
        $_d = $langing == 'th' ? $_row->HowToPlayTextTH ?? " - " : $_row->HowToPlayTextEN ?? " - ";

        $tempJson['body']['contents'][0]['text'] = lang('line.text.howtoplay');
        $tempJson['body']['contents'][1]['text'] = $_d;

        $_r1 = $GameRuleModel->where('msID', $msID)
            ->orderBy("grKeyLine", "ASC")
            ->findAll();
        foreach ($_r1 as $key => $value) {

            switch ($langing) {
                case 'th':
                    $text = "{$value->grKeyLine}  {$value->grName} {$value->grKeyLine}/100  {$value->grTextTH}";
                    break;
                default:
                    $text = "{$value->grKeyLine}  {$value->grNameEN} {$value->grKeyLine}/100  {$value->grTextEN}";
                    break;
            }
            $col_1 = new stdClass();
            $col_1->type = "text";
            $col_1->text = $text;
            $col_1->size = "md";
            $col_1->color = "#111111";
            $col_1->margin = "sm";

            array_push($tempJson['body']['contents'], $col_1);
        }

        $this->tempMsg->contents = $tempJson;


        return $this->tempMsg;
    }

    public function getGambling($user_id, $groupLive_ID, $glco_ID, $gamb_ID, $displayName = '', $user_remain = 0.0, $glco_count = '', $glco_created_at = '', $langing = 'en')
    {
        $tempGambling = json_decode(file_get_contents(WRITEPATH . "lineMessage/tempGambling.json"), TRUE);
        // $langing = \Config\Services::language()->getLocale();
        // $MembersModel           = new MembersModel();
        // $GroupLiveCardOpenModel = new GroupLiveCardOpenModel();
        // $MemberRow              = $MembersModel->find ( $user_id );

        // $LiveCardRow = $GroupLiveCardOpenModel->find ( $glco_ID );

        $tempGambling['body']['contents'][0]['contents'][0]['text'] = "[ID:$glco_ID] " . $displayName; //[ID:00] NAME
        $tempGambling['body']['contents'][0]['contents'][1]['text'] = "#" . $groupLive_ID . $glco_ID . $gamb_ID; //#743289384279
        $tempGambling['body']['contents'][1]['contents'][0]['text'] = lang('line.text.credit'); // 999999 บาท
        $tempGambling['body']['contents'][1]['contents'][1]['text'] = $user_remain . " " . lang("global.text.currency"); // 999999 บาท
        $tempGambling['body']['contents'][2]['text'] = lang("line.text.count") . " " . $glco_count . " [ " . date("d/m/Y H:i", strtotime($glco_created_at)) . "]"; //เปิดที่ 999 [01/01/24   00:00 น.]


        $GamblingHistorieModel = new GamblingHistorieModel();
        $_rco = $GamblingHistorieModel
            ->select("gambling_histories.glco_quantity,gamerules.grName,gamerules.grNameEN")
            ->where("gambling_histories.user_id", $user_id)
            ->where("gambling_histories.groupLive_ID", $groupLive_ID)
            ->where("gambling_histories.glco_ID", $glco_ID)
            ->join("gamerules", "gamerules.grId = gambling_histories.grId", "inner")
            ->findAll();

        $sum = 0;

        foreach ($_rco as $key => $value) {

            $sum += floatval($value->glco_quantity);
            $separator = new stdClass();
            $separator->type = "separator";
            $separator->margin = "none";

            array_push($tempGambling['body']['contents'], $separator);

            $contents = new stdClass();
            $contents->type = "box";
            $contents->layout = "horizontal";
            $contents->contents = [];
            $contents->width = "100%";
            $contents->justifyContent = "space-between";

            $col_1 = new stdClass();
            $col_1->type = "text";
            $col_1->text = $langing == "th" ? $value->grName : $value->grNameEN;
            $col_1->wrap = TRUE;
            $col_1->size = "sm";

            $col_2 = new stdClass();
            $col_2->type = "text";
            $col_2->text = "+" . $value->glco_quantity . " " . lang("global.text.currency");
            $col_2->wrap = TRUE;
            $col_2->size = "sm";

            $col_3 = new stdClass();
            $col_3->type = "text";
            $col_3->text = $sum . " " . lang("global.text.currency");
            $col_3->wrap = TRUE;
            $col_3->size = "xs";

            array_push($contents->contents, $col_1);
            array_push($contents->contents, $col_2);
            array_push($contents->contents, $col_3);


            array_push($tempGambling['body']['contents'], $contents);
            array_push($tempGambling['body']['contents'], $separator);
        }

        $this->tempMsg->contents = $tempGambling;
        return $this->tempMsg;
    }



    /**
     * Get the value of senderName
     */
    public function getSenderName()
    {
        return $this->senderName;
    }

    /**
     * Set the value of senderName
     *
     * @return  self
     */
    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;
        $this->tempMsg->sender->name = $this->senderName;
        return $this;
    }

    /**
     * Get the value of senderName
     */
    public function getaltText()
    {
        return $this->altText;
    }

    /**
     * Set the value of altText
     *
     * @return  self
     */
    public function setaltText($altText)
    {
        $this->altText = $altText;
        $this->tempMsg->sender->name = $this->altText;
        return $this;
    }
}
