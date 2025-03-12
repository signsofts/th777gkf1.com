<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGamemasters extends Migration
{
    public function up()
    {
        $fields = [
            'msID' => [
                'type'           => 'BIGINT',
                'auto_increment' => true,
                'comment'        => 'รหัสประจำตัวเกม (Primary Key)'
            ],
            'msNameT' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'comment'    => 'ชื่อเกมภาษาไทย'
            ],
            'msNameE' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'comment'    => 'ชื่อเกมภาษาอังกฤษ'
            ],
            'msDelete' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
                'default'    => 0,
                'comment'    => 'สถานะการลบ (0 = ใช้งาน, 1 = ลบ)'
            ],
            'datetime' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'comment' => 'วันเวลาของรายการ'
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'comment' => 'วันเวลาที่สร้างข้อมูล'
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'comment' => 'วันเวลาที่อัพเดทข้อมูลล่าสุด'
            ],
            'deleted_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'comment' => 'วันเวลาที่ลบข้อมูล (Soft Delete)'
            ],
            'HowToPlayTextTH' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'วิธีการเล่นภาษาไทย'
            ],
            'HowToPlayTextEN' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'วิธีการเล่นภาษาอังกฤษ'
            ],
            'msRulesForPlayTH' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'กติกาการเล่นภาษาไทย'
            ],
            'msRulesForPlayEN' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'กติกาการเล่นภาษาอังกฤษ'
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('msID');
        
        $attributes = [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];
        
        $this->forge->createTable('gamemasters', true, $attributes);

        // เพิ่มข้อมูลเริ่มต้นจาก SQL dump
        $data = [
            [
                'msID'             => 1,
                'msNameT'          => 'เสือ - มังกร',
                'msNameE'          => 'Tiger - Dragon',
                'msDelete'         => 0,
                'datetime'         => null,
                'created_at'       => '2024-06-05 18:52:47',
                'updated_at'       => '2024-06-24 18:14:24',
                'deleted_at'       => null,
                'HowToPlayTextTH'  => null,
                'HowToPlayTextEN'  => null,
                'msRulesForPlayTH' => '-',
                'msRulesForPlayEN' => '-'
            ],
            [
                'msID'             => 2,
                'msNameT'          => 'บาคาร่า',
                'msNameE'          => 'Baccarat',
                'msDelete'         => 0,
                'datetime'         => null,
                'created_at'       => '2024-06-05 18:52:47',
                'updated_at'       => '2024-06-24 18:14:28',
                'deleted_at'       => null,
                'HowToPlayTextTH'  => null,
                'HowToPlayTextEN'  => null,
                'msRulesForPlayTH' => '-',
                'msRulesForPlayEN' => '-'
            ],
            [
                'msID'             => 3,
                'msNameT'          => 'โป๊กเกอร์',
                'msNameE'          => 'POKER',
                'msDelete'         => 0,
                'datetime'         => null,
                'created_at'       => '2024-06-05 18:52:47',
                'updated_at'       => '2024-06-24 18:14:28',
                'deleted_at'       => null,
                'HowToPlayTextTH'  => null,
                'HowToPlayTextEN'  => null,
                'msRulesForPlayTH' => '-',
                'msRulesForPlayEN' => '-'
            ],
        ];
        $this->db->table('gamemasters')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('gamemasters', true);
    }
}