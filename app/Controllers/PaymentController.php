<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class PaymentController extends BaseController
{

    // use ResponseInterface;
    use ResponseTrait;

    public function index()
    {
        //
        $BanklistModel = new \App\Models\BanklistModel();
        // $BankModel = new \App\Models\BankModel();
        // $PaymentModel = new \App\Models\PaymentModel();

        $this->setViewData(
            "banklist",
            $BanklistModel
                ->where("blit_delete", "0")
                ->where("blit_id !=", SYS_BANK)
                ->join("banks", "banks.bank_id = {$BanklistModel->table}.bank_id", 'inner')
                ->findAll()
        );

        return view('pages/bank/approve', $this->getViewData());
    }

    public function show($id)
    {
    }
}
