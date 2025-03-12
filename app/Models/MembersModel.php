<?php

namespace App\Models;

use CodeIgniter\Model;

class MembersModel extends Model
{
    protected $table = 'members';
    protected $primaryKey = 'user_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id',
        'user_register_status',
        'userId',
        'userDelete',
        "displayName",
        'pictureUrl',
        'language',
        'statusMessage',
        'follow',
        'user_remain',
        "user_agent",
        "user_agent_date",
        "user_TotalAmount",
        "user_TotalWithdrawal",
        "user_bank",
        "user_bankNumber",
        "user_bankFName",
        "user_bankLName",
        "user_fname",
        "user_lname",
        "user_email",
        "user_phone",
        "user_address",
        "user_zipCode",
        "user_country",
        "user_currency",
        'user_line_id',
        'user_line_status',
        'user_password',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];
}
