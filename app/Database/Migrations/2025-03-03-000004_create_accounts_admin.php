<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAccountsAdmin extends Migration
{
    public function up()
    {
        $fields = [
            'ac_id' => [
                'type' => 'BIGINT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
                'comment' => 'รหัสประจำตัวแอดมิน (Primary Key)'
            ],
            'ac_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
                'comment' => 'รหัสเฉพาะของแอดมิน (Unique)'
            ],
            'ac_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
                'comment' => 'อีเมลของแอดมิน (Unique)'
            ],
            'ac_password' => [
                'type' => 'TEXT',
                'null' => FALSE,
                'comment' => 'รหัสผ่านของแอดมิน (เข้ารหัส)'
            ],
            'ac_fname' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE,
                'comment' => 'ชื่อจริงของแอดมิน'
            ],
            'ac_lname' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE,
                'comment' => 'นามสกุลของแอดมิน'
            ],
            'ac_niname' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE,
                'comment' => 'ชื่อเล่นของแอดมิน'
            ],
            'datetime' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
                'comment' => 'วันเวลาที่บันทึกข้อมูล'
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
                'comment' => 'วันเวลาที่สร้างข้อมูล'
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
                'comment' => 'วันเวลาที่อัพเดทข้อมูลล่าสุด'
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
                'comment' => 'วันเวลาที่ลบข้อมูล (Soft Delete)'
            ],
            'ac_delete' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 0,
                'comment' => 'สถานะการลบ (0 = ใช้งาน, 1 = ลบ)'
            ],
            'RoleID' => [
                'type' => 'INT',
                'null' => FALSE,
                'comment' => 'รหัสบทบาทของแอดมิน (Foreign Key จากตาราง roles)'
            ],
            'ac_referral' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
                'comment' => 'รหัสแนะนำของแอดมิน'
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('ac_id');
        $this->forge->addUniqueKey('ac_code');
        $this->forge->addUniqueKey('ac_email');
        $this->forge->addKey('RoleID');
        $this->forge->addForeignKey('RoleID', 'roles', 'RoleID', 'CASCADE', 'CASCADE', 'roles999');

        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable('accounts_admin', TRUE, $attributes);

        // ข้อมูลเริ่มต้น
        $data = [
            [
                'ac_id' => 1,
                'ac_code' => 'bmU-85368698',
                'ac_email' => 'system@system.com',
                'ac_password' => '$2y$10$ma0fgCcmUmN4sC0mw.yvVOAxU100bJlnsxyoenmsmniNHmbgh8j.C',
                'ac_fname' => 'system',
                'ac_lname' => 'system',
                'ac_niname' => 'system',
                'datetime' => NULL,
                'created_at' => '2024-06-18 20:21:27',
                'updated_at' => '2024-07-02 15:06:43',
                'deleted_at' => NULL,
                'ac_delete' => 0,
                'RoleID' => 4,
                'ac_referral' => NULL
            ],
            [
                'ac_id' => 2,
                'ac_code' => 'bmU-85368699',
                'ac_email' => 'sadmin@gmail.com',
                'ac_password' => '$2y$10$4IWS/MKlpdiVP6rt01NNLuS6W6V/6YetpKxZTO3/Uj70iVDXus0Mm',
                'ac_fname' => 'Super Admin',
                'ac_lname' => 'Super Admin',
                'ac_niname' => 'Super Admin',
                'datetime' => NULL,
                'created_at' => '2024-06-18 20:21:27',
                'updated_at' => '2024-07-02 15:06:43',
                'deleted_at' => NULL,
                'ac_delete' => 0,
                'RoleID' => 4,
                'ac_referral' => NULL
            ],
            // เพิ่มข้อมูลอื่นๆ...
        ];
        $this->db->table('accounts_admin')->insertBatch($data);


    }

    public function down()
    {
        $this->forge->dropTable('accounts_admin', TRUE);
    }
}