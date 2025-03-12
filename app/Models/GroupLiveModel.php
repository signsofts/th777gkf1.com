<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupLiveModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'group_lives';
    protected $primaryKey       = 'groupLive_ID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "groupLive_ID",
        "groupId",
        "statusCloseLive",
        "glDelete",
        "openCardSum",
        "msID",
        "GLI_Total_Quantity",
        "GLI_Total_Payment",
        "GLI_Remaining_Balance",
        "GLI_Confirm_Result",
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
