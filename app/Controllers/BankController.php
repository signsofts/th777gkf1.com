<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class BankController extends BaseController
{

    // use ResponseInterface;
    use ResponseTrait;

    public function index()
    {
        $BanklistModel = new \App\Models\BanklistModel();
        $BankModel = new \App\Models\BankModel();

        $this->setViewData(
            "banklist",
            $BanklistModel
                ->where("blit_delete", "0")
                ->join("banks", "banks.bank_id = banklists.bank_id", 'inner')
                ->findAll()
        );

        $this->setViewData(
            "remain",
            $BanklistModel
                ->selectSum('blit_remain')
                ->where("blit_delete", "0")
                ->first()->blit_remain
        );
        $this->setViewData(
            "Bank",
            $BankModel
                ->findAll()
        );
        // $this->viewData["Bank"] = 
        // return $this->respond($this->viewData, 200);
        return view('pages/bank/index', $this->getViewData());
    }

    public function show($id)
    {

        $BanklistModel = new \App\Models\BanklistModel();
        $BankStatementModel = new \App\Models\BankStatementModel();
        $this->viewData["bank"] = $BanklistModel
            ->where("blit_delete", "0")
            ->where("blit_id", $id)
            ->join("banks", "banks.bank_id = banklists.bank_id", 'inner')
            ->first();

        $this->viewData["statements"] = $BankStatementModel
            ->select("*")
            ->select("bank_statements.created_at as BlCreated_at")
            // ->select("banklists.*")
            ->where("bstate_delete", "0")
            ->where("bank_statements.blit_id", $id)
            // ->join("banklists", "banklists.blit_id = bank_statements.blit_id", 'inner')
            // ->join("banks", "banks.bank_id = banklists.bank_id", 'inner')
            ->join("members", "members.user_id = bank_statements.user_id", 'left')
            ->join("status", "status.status_id = bank_statements.status_id", 'left')
            ->join("accounts_admin", "accounts_admin.ac_code = bank_statements.ac_code", 'inner')
            ->orderBy("BlCreated_at", 'desc')
            ->findAll();

        // dd($banklist);

        if (is_null($this->viewData["bank"])) {
            return redirect()->back();
        }
        // return $this->respond($this->viewData, 200);

        return view('pages/bank/show', $this->getViewData());
    }

    public function create()
    {
        // dd(session("ac_code"));
        $rules = [
            'blit_number' => ['rules' => 'required'], //|is_unique[banklists.blit_number]
            'blit_name' => ['rules' => 'required'],
            'bank_id' => ['rules' => 'required'],
            'blit_image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[blit_image]|is_image[blit_image]|max_size[blit_image,10240]',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getErrors());
        }

        $BanklistModel = new \App\Models\BanklistModel();
        $BanklistCheck = $BanklistModel
            ->where('blit_number', $this->request->getVar('blit_number'))
            ->findAll();

        if (count($BanklistCheck) > 0) {
            return redirect()->back()->with('error', "พบข้อมูลซ้ำในระบบ");
        }

        $blit_image = $this->request->getFile('blit_image');
        $blit_image_name = '';
        if ($blit_image->isValid() && !$blit_image->hasMoved()) {
            // Get the original file name
            $originalName = $blit_image->getClientName();

            // Define a custom file name if needed
            $newName = $blit_image->getRandomName(); // You can change this to $originalName if you want to keep the original

            // Move the file to the writable/uploads directory


            $path = WRITEPATH . 'uploads/' . date("Ymd");
            $blit_image->move($path, $newName);

            // Store the relative path
            // $filepath        = 'uploads/' . $newName;
            $blit_image_name = date("Ymd") . "/" . $newName;
        }

        $data = [
            'blit_number' => $this->request->getVar('blit_number'),
            'blit_name' => $this->request->getVar('blit_name'),
            'bank_id' => $this->request->getVar('bank_id'),
            'blit_image' => $blit_image_name,
            'ac_code' => session("ac_code"),
        ];
        if ($BanklistModel->save($data)) {
            return redirect()->back()->with('success', "insert data success");
        } else {
            return redirect()->back()->with('error', "insert data error.");
        }
    }


}
