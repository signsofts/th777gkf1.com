<?php

namespace App\Models;

use CodeIgniter\Model;

class GameRuleModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'gamerules';
    protected $primaryKey = 'grId';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        "grId",
        "grName",
        "grKeyLine",
        "grMultiply",
        "grDelete",
        "msID",
        "grTextTH",
        "grTextEN",
        "grTextRulesTH",
        "grTextRulesEN",
    ];

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
