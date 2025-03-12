<?php

namespace App\Models;

use CodeIgniter\Model;

class LnviteLinkModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'lnvitelink';
    protected $primaryKey       = 'LL_ID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "LL_ID",
        "LL_CODE",
        "ac_code",
        "groupId",
        "LL_LINK",
        "LL_START_DATE",
        "LL_EXPIRE",
        "LL_COUNT",
        "LL_TYPE",
        "LL_ACTION",
        "user_id",
        "LL_DELETE",
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
