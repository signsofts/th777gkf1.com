<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMembers extends Migration
{
    public function up()
    {
        $fields = [
            'user_id' => [
                'type' => 'INT',
                'auto_increment' => TRUE,
                'comment' => 'รหัสประจำตัวสมาชิก (Primary Key)'
            ],
            'user_register_status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => TRUE,
                'comment' => 'สถานะการลงทะเบียน'
            ],
            'user_line_id' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
                'comment' => 'รหัส LINE ของสมาชิก'
            ],
            'user_line_status' => [
                'type' => 'VARCHAR',
                'constraint' => 2,
                'null' => TRUE,
                'comment' => 'ผู้บัญชีไลน์'
            ],
            'userId' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
                'comment' => 'รหัสผู้ใช้ LINE (Unique)'
            ],
            'displayName' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
                'comment' => 'ชื่อที่แสดง'
            ],
            'userDelete' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 0,
                'comment' => 'สถานะการลบ (0 = ใช้งาน, 1 = ลบ)'
            ],
            'datetime' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
                'comment' => 'วันเวลาของรายการ'
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
            'pictureUrl' => [
                'type' => 'TEXT',
                'null' => TRUE,
                'comment' => 'URL รูปโปรไฟล์'
            ],
            'language' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
                'default' => 'th',
                'comment' => 'ภาษาที่ใช้'
            ],
            'statusMessage' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
                'comment' => 'ข้อความสถานะ'
            ],
            'follow' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 1,
                'comment' => 'สถานะการติดตาม (0 = ไม่ติดตาม, 1 = ติดตาม)'
            ],
            'user_remain' => [
                'type' => 'DECIMAL',
                'constraint' => '65,2',
                'null' => FALSE,
                'default' => '0.00',
                'comment' => 'ยอดเงินคงเหลือของสมาชิก'
            ],
            'user_agent' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
                'comment' => 'รหัสตัวแทน (Foreign Key จาก accounts_admin)'
            ],
            'user_agent_date' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
                'comment' => 'วันเวลาที่กำหนดตัวแทน'
            ],
            'user_TotalAmount' => [
                'type' => 'DECIMAL',
                'constraint' => '65,2',
                'null' => FALSE,
                'default' => '0.00',
                'comment' => 'ยอดเงินรวมทั้งหมด'
            ],
            'user_TotalWithdrawal' => [
                'type' => 'DECIMAL',
                'constraint' => '65,2',
                'null' => FALSE,
                'default' => '0.00',
                'comment' => 'ยอดถอนเงินรวมทั้งหมด'
            ],
            'user_bank' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
                'comment' => 'ชื่อธนาคารของสมาชิก'
            ],
            'user_bankNumber' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
                'comment' => 'เลขที่บัญชีธนาคาร'
            ],
            'user_bankFName' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
                'comment' => 'ชื่อบัญชีธนาคาร'
            ],
            'user_fname' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
                'comment' => 'ชื่อจริงของสมาชิก'
            ],
            'user_lname' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
                'comment' => 'นามสกุลของสมาชิก'
            ],
            'user_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
                'comment' => 'อีเมลของสมาชิก'
            ],
            'user_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE,
                'comment' => 'เบอร์โทรศัพท์ของสมาชิก'
            ],
            'user_address' => [
                'type' => 'TEXT',
                'null' => TRUE,
                'comment' => 'ที่อยู่ของสมาชิก'
            ],
            'user_zipCode' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => TRUE,
                'comment' => 'รหัสไปรษณีย์'
            ],
            'user_country' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
                'comment' => 'ประเทศ'
            ],
            'user_currency' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE,
                'default' => 'THB',
                'comment' => 'สกุลเงินที่ใช้'
            ],
            'user_bankLName' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
                'comment' => 'นามสกุลบัญชีธนาคาร'
            ],
            'user_password' => [
                'type' => 'TEXT',
                'null' => TRUE,
                'comment' => 'รหัสผ่านของสมาชิก (เข้ารหัส)'
            ],

        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('user_id');
        // $this->forge->addUniqueKey('userId');
        $this->forge->addKey('user_agent', FALSE, FALSE, 'member_1');
        $this->forge->addForeignKey('user_agent', 'accounts_admin', 'ac_code', 'CASCADE', 'CASCADE', 'member_1');

        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable('members', TRUE, $attributes);

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม
    }

    public function down()
    {
        $this->forge->dropTable('members', TRUE);
    }
}