<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupLiveCardOpenModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'group_live_card_opens';
    protected $primaryKey       = 'glco_ID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "glco_ID",
        "groupLive_ID",
        "glco_count", // รอบที่
        "grId", // ผลแพ้ชนะ
        "msID",
        "groupId",
        "glcoDelete",
        "glcoCancel",
        "status_id",
        "GL_Total_Quantity",
        "GL_Total_Payment",
        "GL_Remaining_Balance",
        "GL_Confirm_Result",
        "GL_Confirm_User",
        "GL_Win_Total",
        "GL_Loss_Total",
        "GL_Games_Played",
        "GLCO_STEP",
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
