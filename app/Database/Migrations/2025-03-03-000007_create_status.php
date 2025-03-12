<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStatus extends Migration
{
    public function up()
    {
        $fields = [
            'status_id' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'comment'        => 'รหัสประจำตัวสถานะ (Primary Key)'
            ],
            'status_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'comment'    => 'ชื่อสถานะภาษาไทย'
            ],
            'status_note' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'หมายเหตุของสถานะ'
            ],
            'status_type' => [
                'type'       => 'ENUM',
                'constraint' => ['bank', 'user', 'admin', 'live'],
                'null'       => false,
                'comment'    => 'ประเภทสถานะ (bank, user, admin, live)'
            ],
            'status_nameEN' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'comment'    => 'ชื่อสถานะภาษาอังกฤษ'
            ],
            'status_class' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
                'comment'    => 'คลาส CSS ของสถานะ'
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('status_id');
        
        $attributes = [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];
        
        $this->forge->createTable('status', true, $attributes);

        // เพิ่มข้อมูลเริ่มต้นจาก SQL dump
        $data = [
            ['status_id' => 1, 'status_name' => 'เงินเข้า', 'status_note' => null, 'status_type' => 'bank', 'status_nameEN' => 'Incoming money', 'status_class' => 'text-success'],
            ['status_id' => 2, 'status_name' => 'เงินออก', 'status_note' => null, 'status_type' => 'bank', 'status_nameEN' => 'Money out', 'status_class' => 'text-danger'],
            ['status_id' => 3, 'status_name' => 'เงินเข้า', 'status_note' => null, 'status_type' => 'user', 'status_nameEN' => 'Incoming money', 'status_class' => 'text-success'],
            ['status_id' => 4, 'status_name' => 'เงินออก', 'status_note' => null, 'status_type' => 'user', 'status_nameEN' => 'Money out', 'status_class' => 'text-danger'],
            ['status_id' => 5, 'status_name' => 'รอเปิด', 'status_note' => null, 'status_type' => 'live', 'status_nameEN' => 'รอเปิด', 'status_class' => 'text-info'],
            ['status_id' => 6, 'status_name' => 'ปิด Live', 'status_note' => null, 'status_type' => 'live', 'status_nameEN' => 'ปิด Live', 'status_class' => 'text-danger'],
            ['status_id' => 7, 'status_name' => 'กำลังเล่น', 'status_note' => null, 'status_type' => 'live', 'status_nameEN' => 'กำลังเล่น', 'status_class' => 'text-primary'],
            ['status_id' => 8, 'status_name' => 'เปิดแล้ว', 'status_note' => null, 'status_type' => 'live', 'status_nameEN' => 'เปิดแล้ว', 'status_class' => 'text-success'],
            ['status_id' => 9, 'status_name' => 'ลงเดิมพัน', 'status_note' => 'ลงเดิมพัน', 'status_type' => 'live', 'status_nameEN' => 'ลงเดิมพัน', 'status_class' => 'text-danger'],
            ['status_id' => 10, 'status_name' => 'ชนะเดิมพัน', 'status_note' => 'ชนะเดิมพัน', 'status_type' => 'live', 'status_nameEN' => 'ชนะเดิมพัน', 'status_class' => 'text-success'],
        ];
        $this->db->table('status')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('status', true);
    }
}