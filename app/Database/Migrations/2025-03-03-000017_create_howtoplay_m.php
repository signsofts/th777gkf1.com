<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHowtoplayM extends Migration
{
    public function up()
    {
        $fields = [
            'htp_id' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'comment'        => 'รหัสประจำตัววิธีการเล่น (Primary Key)'
            ],
            'msID' => [
                'type'    => 'BIGINT',
                'null'    => false,
                'comment' => 'รหัสเกม (Foreign Key จาก gamemasters)'
            ],
            'htp_text' => [
                'type'    => 'TEXT',
                'null'    => false,
                'comment' => 'เนื้อหาวิธีการเล่น'
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('htp_id');
        $this->forge->addForeignKey('msID', 'gamemasters', 'msID', 'CASCADE', 'CASCADE');
        
        $attributes = [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];
        
        $this->forge->createTable('howtoplay_m', true, $attributes);

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม
    }

    public function down()
    {
        $this->forge->dropTable('howtoplay_m', true);
    }
}