<?php

namespace App\Controllers\Resources;

use App\Models\BanklistModel;
use CodeIgniter\RESTful\ResourceController;

class BankListResource extends ResourceController
{

    protected $modelName = 'App\Models\BanklistModel';
    protected $format = 'json';

    public function index()
    {
        $BanklistModel = new BanklistModel();
        $list = $BanklistModel
            ->join("banks", "banks.bank_id = banklists.bank_id", "inner")
            ->where("banklists.blit_delete", '0')
            ->where("banklists.blit_id != ", SYS_BANK)
            // ->whereNotIn("banklists.blit_id", SYS_BANK)
            ->findAll();
            
        return $this->respond($list);
    }

    public function show($id = null)
    {
        $BanklistModel = new BanklistModel();
        $list = $BanklistModel->find($id);
        return $this->respond($list);
    }

    public function new()
    {
        $BanklistModel = new BanklistModel();
    }

    public function create()
    {
        $BanklistModel = new BanklistModel();
    }

    public function edit($id = null)
    {
        $BanklistModel = new BanklistModel();
    }

    public function update($id = null)
    {
        $BanklistModel = new BanklistModel();
    }

    public function delete($id = null)
    {
        $BanklistModel = new BanklistModel();
        $BanklistModel->update($id, [
            "blit_delete" => "1",
            "blit_delete_ad_code" => session('ac_code'),
        ]);

        return $this->respond(['success' => true, "msg" => "delete success"], 200);
    }
}
