<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMemberStatements extends Migration
{
    public function up()
    {
        $fields = [
            'statement_ID' => [
                'type'           => 'BIGINT',
                'auto_increment' => true,
                'comment'        => 'รหัสประจำตัวรายการสมาชิก (Primary Key)'
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'รหัสผู้ใช้ (Foreign Key จาก members)'
            ],
            'statement_IN' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
                'default'    => 0,
                'comment'    => 'สถานะเงินเข้า (0 = ไม่เข้า, 1 = เข้า)'
            ],
            'statement_OUT' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
                'default'    => 0,
                'comment'    => 'สถานะเงินออก (0 = ไม่ออก, 1 = ออก)'
            ],
            'status_id' => [
                'type'    => 'INT',
                'null'    => true,
                'comment' => 'รหัสสถานะ (Foreign Key จาก status)'
            ],
            'statement_note' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'หมายเหตุของรายการ'
            ],
            'datetime' => [
                'type'    => 'DATETIME',
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
            'statement_remain' => [
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => true,
                'default'    => '0.00',
                'comment'    => 'ยอดเงินคงเหลือ'
            ],
            'money_incoming' => [
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => true,
                'default'    => '0.00',
                'comment'    => 'จำนวนเงินที่เข้า'
            ],
            'money_out' => [
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => true,
                'default'    => '0.00',
                'comment'    => 'จำนวนเงินที่ออก'
            ],
            'ac_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'รหัสแอดมิน (Foreign Key จาก accounts_admin)'
            ],
            'statement_slip' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'comment'    => 'ชื่อไฟล์สลิป (ถ้ามี)'
            ],
            'blit_id' => [
                'type'    => 'BIGINT',
                'null'    => true,
                'comment' => 'รหัสบัญชีธนาคาร (Foreign Key จาก banklists)'
            ],
            'gamb_ID' => [
                'type'    => 'BIGINT',
                'null'    => true,
                'comment' => 'รหัสประวัติการพนัน (Foreign Key จาก gambling_histories)'
            ],
            'PAY_ID' => [
                'type'    => 'BIGINT',
                'null'    => true,
                'comment' => 'รหัสการชำระเงิน (Foreign Key จาก payments)'
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('statement_ID');
        $this->forge->addKey('user_id', false, false, 'member_statements1');
        $this->forge->addKey('status_id', false, false, 'member_statements2');
        $this->forge->addKey('blit_id', false, false, 'member_statements3');
        $this->forge->addKey('ac_code', false, false, 'member_statements4');
        $this->forge->addKey('PAY_ID', false, false, 'member_statements5');
        $this->forge->addForeignKey('user_id', 'members', 'user_id', 'CASCADE', 'CASCADE', 'member_statements1');
        $this->forge->addForeignKey('status_id', 'status', 'status_id', 'CASCADE', 'CASCADE', 'member_statements2');
        $this->forge->addForeignKey('blit_id', 'banklists', 'blit_id', 'CASCADE', 'CASCADE', 'member_statements3');
        $this->forge->addForeignKey('ac_code', 'accounts_admin', 'ac_code', 'CASCADE', 'CASCADE', 'member_statements4');
        $this->forge->addForeignKey('PAY_ID', 'payments', 'PAY_ID', 'CASCADE', 'CASCADE', 'member_statements5');
        
        $attributes = [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];
        
        $this->forge->createTable('member_statements', true, $attributes);

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม
    }

    public function down()
    {
        $this->forge->dropTable('member_statements', true);
    }
}