<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GroupMemberListModel;
use App\Models\MembersModel;
use App\Models\MemberStatementModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use GuzzleHttp\Client;

class MemberController extends BaseController
{
    use ResponseTrait;
    public function index()
    {

        $response  = $this->requestApi(
            site_url('/api/v1/resource/member'),
            "GET",
            [],
            false,
            ["lang" => get_cookie('lang') ?? "en"]
        );
        $data = json_decode($response);
        // return $this->respond($data, 200);
        // $MembersModel = new MembersModel();
        // $GroupMemberListModel  = new GroupMemberListModel();
        // $MemberStatementModel = new MemberStatementModel();
        // $list = $MembersModel->where("userDelete", '0')
        //     ->findAll();

        $momneySum =  0;
        foreach ($data as $key => $item) {
            $momneySum += floatval($item->user_remain);
        }

        $this->setViewData("member", $data);
        $this->setViewData("momneySum", $momneySum);
        $this->setViewData("memberCount", count($data));
        // return $this->respond($this->viewData);
        return view('pages/member/index', $this->viewData);
    }

    function getCurrentPageURL()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
    public function show($user_id)
    {

        // $response  = $this->requestApi(
        //     site_url('api/v1/resource/member/') . $user_id,
        //     "GET",
        //     [],
        //     false,
        //     ["lang" => get_cookie('lang') ?? "en"]
        // );
        // var_dump($response);
        // exit;
        if (empty($user_id)) {
            return redirect()->back()->with('errors', "User Empty");
        }

        $response  = $this->requestApi(
            site_url('api/v1/resource/member/') . $user_id,
            "GET",
            [],
            false,
            ["lang" => get_cookie('lang') ?? "en"]
        );

        $data = json_decode($response);


        $responseBankList  = $this->requestApi(
            site_url('api/v1/resource/bank'),
            "GET",
            [],
            false,
            ["lang" => get_cookie('lang') ?? "en"]
        );
        $dataBankList = json_decode($responseBankList);

        $responseAgent  = $this->requestApi(
            site_url('api/v1/resource/admin'),
            "GET",
            [],
            false,
            ["lang" => get_cookie('lang') ?? "en"]
        );

        $agent = json_decode($responseAgent);
        $this->setViewData("agent", $agent);
        $this->setViewData("member", $data);

        $this->setViewData("bankList", $dataBankList);


        // return $this->respond($this->viewData, 200);


        return view('pages/member/show', $this->viewData);
    }

    public function setagent()
    {
        $user_id = $this->request->getVar("user_id");
        $user_agent = $this->request->getVar("user_agent");
        $MembersModel  = new MembersModel();

        try {
            $MembersModel->update($user_id, [
                "user_agent" => $user_agent,
                "user_agent_date" => date("Y-m-d H:i:s"),
            ]);
            return $this->respond(["message" => "Data saved successfully", "status" => true], 200);
        } catch (\Throwable $e) {
            return $this->respond(["message" => "Data saved error", "status" => false], 200);
        }

    }
}
