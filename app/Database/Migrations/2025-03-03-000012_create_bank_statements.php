<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBankStatements extends Migration
{
    public function up()
    {
        $fields = [ 
            'bstate_id'      => [ 
                'type'           => 'BIGINT',
                'auto_increment' => TRUE,
                'comment'        => 'รหัสประจำตัวรายการธนาคาร (Primary Key)'
            ],
            'bank_id'        => [ 
                'type'    => 'BIGINT',
                'null'    => FALSE,
                'comment' => 'รหัสธนาคาร (Foreign Key จาก banks)'
            ],
            'blit_id'        => [ 
                'type'    => 'BIGINT',
                'null'    => FALSE,
                'comment' => 'รหัสบัญชีธนาคาร (Foreign Key จาก banklists)'
            ],
            'user_id'         => [ 
                'type'       => 'INT',
                'constraint' => 255,
                'null'       => TRUE,
                'comment'    => 'รหัสผู้ใช้ (Foreign Key จาก members)'
            ],
            'status_id'      => [ 
                'type'    => 'INT',
                'null'    => TRUE,
                'comment' => 'รหัสสถานะ (Foreign Key จาก status)'
            ],
            'bstate_IN'      => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => FALSE,
                'default'    => 0,
                'comment'    => 'สถานะเงินเข้า (0 = ไม่เข้า, 1 = เข้า)'
            ],
            'bstate_out'     => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => FALSE,
                'default'    => 0,
                'comment'    => 'สถานะเงินออก (0 = ไม่ออก, 1 = ออก)'
            ],
            'bstate_note'    => [ 
                'type'    => 'TEXT',
                'null'    => TRUE,
                'comment' => 'หมายเหตุของรายการ'
            ],
            'bstate_remain'  => [ 
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => FALSE,
                'comment'    => 'ยอดเงินคงเหลือ'
            ],
            'money_incoming' => [ 
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => FALSE,
                'comment'    => 'จำนวนเงินที่เข้า'
            ],
            'money_out'      => [ 
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => FALSE,
                'comment'    => 'จำนวนเงินที่ออก'
            ],
            'bstate_delete'  => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => FALSE,
                'default'    => 0,
                'comment'    => 'สถานะการลบ (0 = ใช้งาน, 1 = ลบ)'
            ],
            'datetime'       => [ 
                'type'    => 'DATETIME',
                'null'    => TRUE,
                'comment' => 'วันเวลาของรายการ'
            ],
            'created_at'     => [ 
                'type'    => 'TIMESTAMP',
                'null'    => FALSE,
                'comment' => 'วันเวลาที่สร้างข้อมูล'
            ],
            'updated_at'     => [ 
                'type'    => 'TIMESTAMP',
                'null'    => FALSE,
                'comment' => 'วันเวลาที่อัพเดทข้อมูลล่าสุด'
            ],
            'deleted_at'     => [ 
                'type'    => 'INT',
                'null'    => TRUE,
                'comment' => 'วันเวลาที่ลบข้อมูล (ในรูปแบบ integer)'
            ],
            'ac_code'        => [ 
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => FALSE,
                'comment'    => 'รหัสแอดมินที่ทำรายการ (Foreign Key จาก accounts_admin)'
            ],
            'bstate_slip'    => [ 
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => TRUE,
                'comment'    => 'ชื่อไฟล์สลิป (ถ้ามี)'
            ],
        ];

        $this->forge->addField ( $fields );
        $this->forge->addPrimaryKey ( 'bstate_id' );
        $this->forge->addKey ( 'bank_id', FALSE, FALSE, 'bank_statements1' );
        $this->forge->addKey ( 'blit_id', FALSE, FALSE, 'bank_statements2' );
        $this->forge->addKey ( 'user_id', FALSE, FALSE, 'bank_statements3' );
        $this->forge->addKey ( 'status_id', FALSE, FALSE, 'bank_statements4' );
        $this->forge->addKey ( 'ac_code', FALSE, FALSE, 'bank_statements5' );

        $this->forge->addForeignKey ( 'bank_id', 'banks', 'bank_id', 'CASCADE', 'CASCADE', 'bank_statements1' );
        $this->forge->addForeignKey ( 'blit_id', 'banklists', 'blit_id', 'CASCADE', 'CASCADE', 'bank_statements2' );
        $this->forge->addForeignKey ( 'user_id', 'members', 'user_id', 'CASCADE', 'CASCADE', 'bank_statements3' );
        $this->forge->addForeignKey ( 'status_id', 'status', 'status_id', 'CASCADE', 'CASCADE', 'bank_statements4' );
        $this->forge->addForeignKey ( 'ac_code', 'accounts_admin', 'ac_code', 'CASCADE', 'CASCADE', 'bank_statements5' );

        $attributes = [ 
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable ( 'bank_statements', TRUE, $attributes );

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม ดังนั้นจะไม่มีการ insertBatch
    }

    public function down()
    {
        $this->forge->dropTable ( 'bank_statements', TRUE );
    }
}