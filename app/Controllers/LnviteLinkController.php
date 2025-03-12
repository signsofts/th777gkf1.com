<?php

namespace App\Controllers;

use App\Models\GroupModel;
use App\Models\LnviteLinkModel;
use App\Models\MembersModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

class LnviteLinkController extends Controller
{
    use ResponseTrait;
    public function index($code)
    {

        $LnviteLinkModel = new LnviteLinkModel();

        $_row = $LnviteLinkModel->where("LL_CODE", $code)
            ->where("LL_DELETE", 0)
            ->first();


        if (empty($_row)) {
            return $this->respond("error url path", 200);
        }

        \Config\Services::language('th');

        if ($_row->LL_ACTION == 1) {
            $text = lang('global.text.linkError');

            return redirect()->to(base_url('users/signin'))->with('error', $text);
            // echo "
            // <script>
            //     window.addEventListener('load', function () {
            //         alert('$text');
            //         location.href =  'https://www.google.com';
            //     });
            // </script>";
            // exit(1);
        }

        $count = 1 + (int) $_row->LL_COUNT;
        $LnviteLinkModel->update($_row->LL_ID, [
            "LL_COUNT" => $count,
        ]);


        $LL_ACTION = 0;

        switch ($_row->LL_TYPE) {
            case 'lnv':
                $GroupModel = new GroupModel();

                $groupId = $_row->groupId;
                $_rowG = $GroupModel->find($groupId);

                if (empty($_rowG)) {
                    return $this->respond("error url path", 304);
                }


                header('Location: ' . $_rowG->GRO_InviteLink);
                exit(1);

            case 'member':
                $LL_ACTION = 1;

                $MembersModel = new MembersModel();
                $user_id = $_row->user_id;

                $_rowM = $MembersModel->find($user_id);

                if (empty($_rowM)) {
                    return $this->respond("error url path", 304);
                }

                $MembersModel->update($user_id, [
                    "user_agent" => $_row->ac_code,
                ]);

                $LnviteLinkModel->update($_row->LL_ID, [
                    "LL_ACTION" => $LL_ACTION,
                ]);

                return redirect()->to(base_url('users/signin'))->with('success', lang('global.text.linkSuccess'));

            // header('Location: https://www.google.com');
            // exit(1);
            // $text = lang('global.text.linkSuccess');
            // echo "
            // <script>
            //     window.addEventListener('load', function () {
            //         alert('$text');
            //         location.href =  'https://www.google.com';
            //     });
            // </script>";
            // exit(1);
            default:
                # code...
                break;
        }
        return;
    }
}
