<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroupLiveCardOpens extends Migration
{
    public function up()
    {
        $fields = [ 
            'glco_ID'              => [ 
                'type'           => 'BIGINT',
                'auto_increment' => TRUE,
                'comment'        => 'รหัสประจำตัวการเปิดไพ่ (Primary Key)'
            ],
            'groupLive_ID'         => [ 
                'type'    => 'BIGINT',
                'null'    => TRUE,
                'comment' => 'รหัสกลุ่มไลฟ์ (Foreign Key จาก group_lives)'
            ],
            'glco_count'           => [ 
                'type'    => 'INT',
                'null'    => TRUE,
                'comment' => 'รอบการเล่นที่เปิดไพ่'
            ],
            'grId'                 => [ 
                'type'    => 'BIGINT',
                'null'    => TRUE,
                'comment' => 'รหัสผลแพ้ชนะ (Foreign Key จาก gamerules)'
            ],
            'msID'                 => [ 
                'type'    => 'BIGINT',
                'null'    => TRUE,
                'comment' => 'รหัสเกม (Foreign Key จาก gamemasters)'
            ],
            'datetime'             => [ 
                'type'    => 'DATETIME',
                'null'    => TRUE,
                'comment' => 'วันเวลาของการเปิดไพ่'
            ],
            'created_at'           => [ 
                'type'    => 'TIMESTAMP',
                'null'    => TRUE,
                'comment' => 'วันเวลาที่สร้างข้อมูล'
            ],
            'updated_at'           => [ 
                'type'    => 'TIMESTAMP',
                'null'    => TRUE,
                'comment' => 'วันเวลาที่อัพเดทข้อมูลล่าสุด'
            ],
            'deleted_at'           => [ 
                'type'    => 'INT',
                'null'    => TRUE,
                'comment' => 'วันเวลาที่ลบข้อมูล (ในรูปแบบ integer)'
            ],
            'groupId'              => [ 
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => TRUE,
                'comment'    => 'รหัสกลุ่ม (Foreign Key จาก groups)'
            ],
            'glcoDelete'           => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => TRUE,
                'default'    => 0,
                'comment'    => 'สถานะการลบการเปิด (0 = ใช้งาน, 1 = ลบ)'
            ],
            'glcoCancel'           => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => TRUE,
                'default'    => 0,
                'comment'    => 'สถานะการยกเลิกการเปิด (0 = ไม่ยกเลิก, 1 = ยกเลิก)'
            ],
            'status_id'            => [ 
                'type'    => 'INT',
                'null'    => TRUE,
                'default' => 5,
                'comment' => 'รหัสสถานะ (Foreign Key จาก status)'
            ],
            'GL_Total_Quantity'    => [ 
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => TRUE,
                'default'    => '0.00',
                'comment'    => 'จำนวนเงินทั้งหมดที่ลง'
            ],
            'GL_Total_Payment'     => [ 
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => TRUE,
                'default'    => '0.00',
                'comment'    => 'ยอดชำระเงินทั้งหมด'
            ],
            'GL_Remaining_Balance' => [ 
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => TRUE,
                'default'    => '0.00',
                'comment'    => 'ยอดเงินคงเหลือ'
            ],
            'GL_Confirm_Result'    => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => FALSE,
                'default'    => 0,
                'comment'    => 'สถานะยืนยันผล (0 = ยังไม่ยืนยัน, 1 = ยืนยันแล้ว)'
            ],
            'GL_Confirm_User'      => [ 
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => TRUE,
                'comment'    => 'รหัสผู้ใช้ที่ยืนยันผล'
            ],
            'GL_Win_Total'         => [ 
                'type'    => 'INT',
                'null'    => TRUE,
                'default' => 0,
                'comment' => 'จำนวนคนที่ชนะทั้งหมด'
            ],
            'GL_Loss_Total'        => [ 
                'type'    => 'INT',
                'null'    => TRUE,
                'default' => 0,
                'comment' => 'จำนวนคนที่แพ้ทั้งหมด'
            ],
            'GL_Games_Played'      => [ 
                'type'    => 'INT',
                'null'    => TRUE,
                'default' => 0,
                'comment' => 'จำนวนครั้งที่เล่นทั้งหมด'
            ],
            'GLCO_STEP'            => [ 
                'type'    => 'INT',
                'null'    => FALSE,
                'default' => 1,
                'comment' => 'ขั้นตอนการเปิดไพ่'
            ],
        ];

        $this->forge->addField ( $fields );
        $this->forge->addPrimaryKey ( 'glco_ID' );
        $this->forge->addKey ( 'grId', FALSE, FALSE, 'glco_1' );
        $this->forge->addKey ( 'groupId', FALSE, FALSE, 'glco_2' );
        $this->forge->addKey ( 'groupLive_ID', FALSE, FALSE, 'glco_3' );
        $this->forge->addKey ( 'msID', FALSE, FALSE, 'glco_4' );
        $this->forge->addKey ( 'status_id', FALSE, FALSE, 'glco_5' );
        $this->forge->addForeignKey ( 'grId', 'gamerules', 'grId', 'CASCADE', 'CASCADE', 'glco_1' );
        $this->forge->addForeignKey ( 'groupId', 'groups', 'groupId', 'CASCADE', 'CASCADE', 'glco_2' );
        $this->forge->addForeignKey ( 'groupLive_ID', 'group_lives', 'groupLive_ID', 'CASCADE', 'CASCADE', 'glco_3' );
        $this->forge->addForeignKey ( 'msID', 'gamemasters', 'msID', 'CASCADE', 'CASCADE', 'glco_4' );
        $this->forge->addForeignKey ( 'status_id', 'status', 'status_id', 'CASCADE', 'CASCADE', 'glco_5' );

        $attributes = [ 
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable ( 'group_live_card_opens', TRUE, $attributes );

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม
    }

    public function down()
    {
        $this->forge->dropTable ( 'group_live_card_opens', TRUE );
    }
}