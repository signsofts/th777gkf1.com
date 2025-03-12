<?php

namespace App\Models;

use CodeIgniter\Model;

class BankStatementModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'bank_statements';
    protected $primaryKey       = 'bstate_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'bstate_id',
        'bank_id',
        'blit_id',
        'user_id',
        'status_id',
        'bstate_IN',
        'bstate_out',
        'bstate_note',
        'bstate_remain',
        'money_incoming',
        'money_out',
        'bstate_delete',
        'ac_code',
        "bstate_slip"
        // 'bstate_delete',
        // 'bstate_delete',
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
