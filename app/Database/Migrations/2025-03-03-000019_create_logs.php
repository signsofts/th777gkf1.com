<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogs extends Migration
{
    public function up()
    {
        $fields = [
            'LogID' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'comment'        => 'รหัสประจำตัวล็อก (Primary Key)'
            ],
            'ac_id' => [
                'type'    => 'INT',
                'null'    => true,
                'comment' => 'รหัสแอดมิน (Foreign Key จาก accounts_admin)'
            ],
            'Action' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'comment'    => 'การกระทำที่บันทึก'
            ],
            'Timestamp' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'comment' => 'วันเวลาที่บันทึก'
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('LogID');
        
        $attributes = [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];
        
        $this->forge->createTable('logs', true, $attributes);

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม
    }

    public function down()
    {
        $this->forge->dropTable('logs', true);
    }
}