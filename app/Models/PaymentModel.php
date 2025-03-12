<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'payments';
    protected $primaryKey       = 'PAY_ID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "PAY_ID",
        "user_id",
        "PAY_IN",
        "PAY_OUT",
        "status_id",
        "PAY_created_at",
        "PAY_updated_at",
        "PAY_deleted_at",
        "blit_id",
        "PAY_APPROVE",
        "PAY_APPROVE_USER",
        "PAY_APPROVE_TIME",
        "PAY_SLIP",
        "PAY_MONEY",
        "PAY_DATE",
        "PAY_TIME",
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
