<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSigninlogs extends Migration
{
    public function up()
    {
        $fields = [
            'sig_id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
                'comment'        => 'รหัสประจำตัวล็อกการเข้าใช้ (Primary Key)'
            ],
            'sig_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'ประเภทการเข้าใช้'
            ],
            'sig_text' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'เนื้อหาของล็อก'
            ],
            'sig_ip' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'ที่อยู่ IP'
            ],
            'sig_comment' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'หมายเหตุเพิ่มเติม'
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
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('sig_id');
        
        $attributes = [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];
        
        $this->forge->createTable('signinlogs', true, $attributes);

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม
    }

    public function down()
    {
        $this->forge->dropTable('signinlogs', true);
    }
}