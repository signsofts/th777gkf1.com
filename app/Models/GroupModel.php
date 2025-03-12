<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{
    protected $table = 'groups';
    protected $primaryKey = 'groupId';
    protected $useAutoIncrement = false;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'groupId',
        'groupName',
        'groupDelete',
        'pictureUrl',
        "msID",
        "group_language",
        "GRO_Total_Quantity",
        "GRO_Total_Payment",
        "GRO_Remaining_Balance",
        "GRO_InviteLink",
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


    public function getGroupsData($groupId = null)
    {

        $GroupMemberListModel = new GroupMemberListModel();
        $GameRuleModel = new GameRuleModel();
        $GroupLiveModel = new GroupLiveModel();

        $gRow = $this
            ->where("groupId", $groupId)
            ->join("gamemasters", "gamemasters.msId ={$this->table}.msId", "left")
            ->first();
        $gRow->members = $GroupMemberListModel
            ->where("groupId", $groupId)
            ->join("members", 'members.userId = groupmemberlists.userId', 'inner')
            ->findAll();


        $gRow->gamekey = $GameRuleModel
            ->where("msID", $gRow->msID)
            ->findAll();
        $gRow->lives = $GroupLiveModel
            ->where("groupId", $groupId)
            ->join("gamemasters", "gamemasters.msId ={$GroupLiveModel->table}.msId", "inner")
            ->findAll();
        $gRow->moneySum = 0; // ยอดเล่นทั้งหมด
        $gRow->moneyPay = 0; // ยอดจ่ายคืน
        $gRow->moneyTotle = 0; // ยอดจคงเหลือ


        return $gRow;
    }
}
