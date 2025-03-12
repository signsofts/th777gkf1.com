<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroupLives extends Migration
{
    public function up()
    {
        $fields = [ 
            'groupLive_ID'          => [ 
                'type'           => 'BIGINT',
                'auto_increment' => TRUE,
                'comment'        => 'รหัสประจำตัวกลุ่มไลฟ์ (Primary Key)'
            ],
            'groupId'               => [ 
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => FALSE,
                'comment'    => 'รหัสกลุ่ม (Foreign Key จาก groups)'
            ],
            'statusCloseLive'       => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => FALSE,
                'default'    => 0,
                'comment'    => 'สถานะปิดไลฟ์ (0 = เปิด, 1 = ปิด)'
            ],
            'datetime'              => [ 
                'type'    => 'DATETIME',
                'null'    => TRUE,
                'comment' => 'วันเวลาของรายการ'
            ],
            'created_at'            => [ 
                'type'    => 'TIMESTAMP',
                'null'    => FALSE,
                'comment' => 'วันเวลาที่สร้างข้อมูล'
            ],
            'updated_at'            => [ 
                'type'    => 'TIMESTAMP',
                'null'    => FALSE,
                'comment' => 'วันเวลาที่อัพเดทข้อมูลล่าสุด'
            ],
            'deleted_at'            => [ 
                'type'    => 'DATETIME',
                'null'    => TRUE,
                'comment' => 'วันเวลาที่ลบข้อมูล (Soft Delete)'
            ],
            'glDelete'              => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => FALSE,
                'default'    => 0,
                'comment'    => 'สถานะการลบ (0 = ใช้งาน, 1 = ลบ)'
            ],
            'openCardSum'           => [ 
                'type'    => 'INT',
                'null'    => FALSE,
                'comment' => 'ผลรวมของการเปิดไพ่'
            ],
            'msID'                  => [ 
                'type'    => 'BIGINT',
                'null'    => FALSE,
                'comment' => 'รหัสเกม (Foreign Key จาก gamemasters)'
            ],
            'GLI_Total_Quantity'    => [ 
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => TRUE,
                'default'    => '0.00',
                'comment'    => 'จำนวนเงินทั้งหมดที่ลง'
            ],
            'GLI_Total_Payment'     => [ 
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => TRUE,
                'default'    => '0.00',
                'comment'    => 'ยอดชำระเงินทั้งหมด'
            ],
            'GLI_Remaining_Balance' => [ 
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => TRUE,
                'default'    => '0.00',
                'comment'    => 'ยอดเงินคงเหลือ'
            ],
            'GLI_Confirm_Result'    => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => FALSE,
                'default'    => 0,
                'comment'    => 'สถานะยืนยันผล (0 = ยังไม่ยืนยัน, 1 = ยืนยันแล้ว)'
            ],
        ];

        $this->forge->addField ( $fields );
        $this->forge->addPrimaryKey ( 'groupLive_ID' );
        $this->forge->addKey ( 'groupId', FALSE, FALSE, 'groupIDTOGL' );
        $this->forge->addKey ( 'msID', FALSE, FALSE, 'msGame_Live' );
        $this->forge->addForeignKey ( 'groupId', 'groups', 'groupId', 'CASCADE', 'CASCADE', 'groupIDTOGL' );
        $this->forge->addForeignKey ( 'msID', 'gamemasters', 'msID', 'CASCADE', 'CASCADE', 'msGame_Live' );

        $attributes = [ 
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable ( 'group_lives', TRUE, $attributes );

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม ดังนั้นจะไม่มีการ insertBatch
    }

    public function down()
    {
        $this->forge->dropTable ( 'group_lives', TRUE );
    }
}