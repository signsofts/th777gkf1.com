<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountsAdminModel;
use App\Models\RolesModel;
use CodeIgniter\API\ResponseTrait;

class AdminController extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $AccountsAdminModel = new AccountsAdminModel();
        $list = $AccountsAdminModel->where("{$AccountsAdminModel->table}.ac_delete", '0')
            ->where("{$AccountsAdminModel->table}.RoleID !=", '4')
            ->where("{$AccountsAdminModel->table}.ac_code !=", SYS_CODE)
            ->join('roles', "roles.RoleID = {$AccountsAdminModel->table}.RoleID ", "inner")
            ->findAll();

            
        $this->setViewData('admin', $list);
        $this->setViewData('adCount', count($list));

        $RolesModel = new RolesModel();
        $this->setViewData("RoleList", $RolesModel
            ->where("RoleID != 4")
            ->findAll());
        // return $this->respond($data ?? [] );
        return view('pages/admin/index', $this->viewData);
    }
}
