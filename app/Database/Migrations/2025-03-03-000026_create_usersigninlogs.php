<?php


namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersigninlogs extends Migration
{
    public function up()
    {
        $fields = [
            'USIG_ID' => [
                'type' => 'INT',
                'auto_increment' => true,
                'comment' => 'รหัสประจำตัวล็อกการเข้าใช้ของผู้ใช้ (Primary Key)'
            ],
            'USIG_created_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'comment' => 'วันเวลาที่สร้างข้อมูล'
            ],
            'USIG_datetime' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'comment' => 'วันเวลาของรายการ'
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 255,
                'null' => true,
                'comment' => 'รหัสผู้ใช้ (Foreign Key จาก members)'
            ],
            'USIG_TOKEN' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'โทเค็นการเข้าใช้'
            ],
            'USIG_TYPE' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'comment' => 'ประเภทการเข้าใช้'
            ],
            'USIG_IP' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'ที่อยู่ IP'
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('USIG_ID');
        $this->forge->addForeignKey('user_id', 'members', 'user_id', 'CASCADE', 'CASCADE');

        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable('usersigninlogs', true, $attributes);

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม
    }

    public function down()
    {
        $this->forge->dropTable('usersigninlogs', true);
    }
}




