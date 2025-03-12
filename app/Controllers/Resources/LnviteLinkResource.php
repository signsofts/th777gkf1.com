<?php

namespace App\Controllers\Resources;

use App\Models\LnviteLinkModel;
use CodeIgniter\RESTful\ResourceController;

class LnviteLinkResource extends ResourceController
{

    protected $modelName = 'App\Models\LnviteLinkModel';
    protected $format = 'json';

    public function index()
    {
        $LnviteLinkModel = new LnviteLinkModel();

        // return $this->respond($Row, 200);
    }

    public function show($groupId = null)
    {
        $LnviteLinkModel = new LnviteLinkModel();


        // return $this->respond($gRow, 200);
    }

    public function new()
    {
        $LnviteLinkModel = new LnviteLinkModel();
        //
    }

    public function create()
    {
        $LnviteLinkModel = new LnviteLinkModel();
        //
        $Y = date("Y") - 2000;
        $M = date("m");
        $LL_CODE = $Y . $M . $this->generateRandomString();
        $che__code = true;

        while ($che__code) {
            $che_AcCodeRow = $LnviteLinkModel->where("LL_CODE", $LL_CODE)
                ->first();
            if (empty($che_AcCodeRow)) {
                $che__code = false;
            }
        }
        $type = $this->request->getVar('type');
        $LL_TYPE = 'lnv';
        $groupId = null;
        $user_id = null;
        switch ($type) {
            case 'member':
                $user_id = $this->request->getVar('user_id');
                $LL_TYPE = 'member';
                break;

            default:
                $groupId = $this->request->getVar('groupId');
                break;
        }

        // $LL_LINK = base_url("l/$LL_CODE");
        $LnviteLinkModel->save([
            "LL_CODE" => $LL_CODE,
            "ac_code" => session("ac_code"),
            "groupId" => $groupId,
            "user_id" => $user_id,
            "LL_LINK" => "l/$LL_CODE",
            "LL_START_DATE" => date("Y-m-d"),
            "LL_EXPIRE" => null,
            "LL_COUNT" => 0,
            "LL_TYPE" => $LL_TYPE,
        ]);

        return $this->respond(["message" => base_url("l/$LL_CODE"), "status" => true], 200);
    }

    public function edit($id = null)
    {
        $LnviteLinkModel = new LnviteLinkModel();
        //
    }

    public function update($id = null)
    {
        $LnviteLinkModel = new LnviteLinkModel();
    }

    public function delete($id = null)
    {
        $LnviteLinkModel = new LnviteLinkModel();
        //
    }

    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
