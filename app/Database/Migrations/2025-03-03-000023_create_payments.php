<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePayments extends Migration
{
    public function up()
    {
        $fields = [ 
            'PAY_ID'           => [ 
                'type'           => 'BIGINT',
                'auto_increment' => TRUE,
                'comment'        => 'รหัสประจำตัวการชำระเงิน (Primary Key)'
            ],
            'user_id'           => [ 
                'type'       => 'INT',
                'constraint' => 255,
                'null'       => FALSE,
                'comment'    => 'รหัสผู้ใช้ (Foreign Key จาก members)'
            ],
            'PAY_IN'           => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => FALSE,
                'default'    => 0,
                'comment'    => 'สถานะเงินเข้า (0 = ไม่เข้า, 1 = เข้า)'
            ],
            'PAY_OUT'          => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => FALSE,
                'default'    => 0,
                'comment'    => 'สถานะเงินออก (0 = ไม่ออก, 1 = ออก)'
            ],
            'status_id'        => [ 
                'type'    => 'INT',
                'null'    => FALSE,
                'comment' => 'รหัสสถานะ (Foreign Key จาก status)'
            ],
            'PAY_created_at'   => [ 
                'type'    => 'TIMESTAMP',
                'null'    => FALSE,
                'comment' => 'วันเวลาที่สร้างข้อมูล'
            ],
            'PAY_updated_at'   => [ 
                'type'    => 'TIMESTAMP',
                'null'    => FALSE,
                'comment' => 'วันเวลาที่อัพเดทข้อมูลล่าสุด'
            ],
            'PAY_deleted_at'   => [ 
                'type'    => 'TIMESTAMP',
                'null'    => FALSE,
                'comment' => 'วันเวลาที่ลบข้อมูล'
            ],
            'blit_id'          => [ 
                'type'    => 'BIGINT',
                'null'    => TRUE,
                'comment' => 'รหัสบัญชีธนาคาร (Foreign Key จาก banklists)'
            ],
            'PAY_APPROVE'      => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => TRUE,
                'comment'    => 'สถานะการอนุมัติ (0 = ยังไม่อนุมัติ, 1 = อนุมัติ)'
            ],
            'PAY_APPROVE_USER' => [ 
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => TRUE,
                'comment'    => 'รหัสผู้ใช้อนุมัติ'
            ],
            'PAY_APPROVE_TIME' => [ 
                'type'    => 'TIMESTAMP',
                'null'    => TRUE,
                'comment' => 'วันเวลาที่อนุมัติ'
            ],
            'PAY_SLIP'         => [ 
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => TRUE,
                'comment'    => 'ชื่อไฟล์สลิป (ถ้ามี)'
            ],
            'PAY_MONEY'        => [ 
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => FALSE,
                'default'    => '0.00',
                'comment'    => 'จำนวนเงินที่ชำระ'
            ],
            'PAY_DATE'         => [ 
                'type'    => 'DATE',
                'null'    => TRUE,
                'comment' => 'วันที่โอนเงิน'
            ],
            'PAY_TIME'         => [ 
                'type'    => 'TIME',
                'null'    => TRUE,
                'comment' => 'เวลาที่โอนเงิน'
            ],
        ];

        $this->forge->addField ( $fields );
        $this->forge->addPrimaryKey ( 'PAY_ID' );
        $this->forge->addKey ( 'status_id', FALSE, FALSE, 'payments2' );
        $this->forge->addKey ( 'user_id', FALSE, FALSE, 'payments3' );
        $this->forge->addKey ( 'blit_id', FALSE, FALSE, 'payments1' );
        $this->forge->addForeignKey ( 'blit_id', 'banklists', 'blit_id', 'CASCADE', 'CASCADE', 'payments1' );
        $this->forge->addForeignKey ( 'status_id', 'status', 'status_id', 'CASCADE', 'CASCADE', 'payments2' );
        $this->forge->addForeignKey ( 'user_id', 'members', 'user_id', 'CASCADE', 'CASCADE', 'payments3' );

        $attributes = [ 
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable ( 'payments', TRUE, $attributes );

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม
    }

    public function down()
    {
        $this->forge->dropTable ( 'payments', TRUE );
    }
}