<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGamblingHistories extends Migration
{
    public function up()
    {
        $fields = [ 
            'gamb_ID'       => [ 
                'type'           => 'BIGINT',
                'auto_increment' => TRUE,
                'comment'        => 'รหัสประจำตัวประวัติการพนัน (Primary Key)'
            ],
            'user_id'        => [ 
                'type'       => 'INT',
                'constraint' => 255,
                'null'       => TRUE,
                'comment'    => 'รหัสผู้ใช้ (Foreign Key จาก members)'
            ],
            'glco_ID'       => [ 
                'type'    => 'BIGINT',
                'null'    => TRUE,
                'comment' => 'รหัสรอบการเปิดไพ่ (Foreign Key จาก group_live_card_opens)'
            ],
            'groupLive_ID'  => [ 
                'type'    => 'BIGINT',
                'null'    => TRUE,
                'comment' => 'รหัสกลุ่มไลฟ์ (Foreign Key จาก group_lives)'
            ],
            'msID'          => [ 
                'type'    => 'BIGINT',
                'null'    => TRUE,
                'comment' => 'รหัสเกม (Foreign Key จาก gamemasters)'
            ],
            'groupId'       => [ 
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => TRUE,
                'comment'    => 'รหัสกลุ่ม (Foreign Key จาก groups)'
            ],
            'grId'          => [ 
                'type'    => 'BIGINT',
                'null'    => TRUE,
                'comment' => 'รหัสกติกาการเดิมพัน (Foreign Key จาก gamerules)'
            ],
            'glco_quantity' => [ 
                'type'       => 'DECIMAL',
                'constraint' => '30,2',
                'null'       => TRUE,
                'comment'    => 'จำนวนเงินที่ลงเดิมพัน'
            ],
            'glco_lose'     => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => TRUE,
                'default'    => 0,
                'comment'    => 'สถานะแพ้ (0 = ไม่แพ้, 1 = แพ้)'
            ],
            'glco_win'      => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => TRUE,
                'default'    => 0,
                'comment'    => 'สถานะชนะ (0 = ไม่ชนะ, 1 = ชนะ)'
            ],
            'glco_multiply' => [ 
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => TRUE,
                'comment'    => 'อัตราต่อรอง (เช่น 1:1, 1:20)'
            ],
            'glco_refund'   => [ 
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => TRUE,
                'comment'    => 'จำนวนเงินที่คืนเมื่อชนะ'
            ],
            'datetime'      => [ 
                'type'    => 'TIMESTAMP',
                'null'    => TRUE,
                'comment' => 'วันเวลาของรายการ'
            ],
            'created_at'    => [ 
                'type'    => 'TIMESTAMP',
                'null'    => TRUE,
                'comment' => 'วันเวลาที่สร้างข้อมูล'
            ],
            'updated_at'    => [ 
                'type'    => 'TIMESTAMP',
                'null'    => TRUE,
                'comment' => 'วันเวลาที่อัพเดทข้อมูลล่าสุด'
            ],
            'deleted_at'    => [ 
                'type'    => 'TIMESTAMP',
                'null'    => TRUE,
                'comment' => 'วันเวลาที่ลบข้อมูล (Soft Delete)'
            ],
            'glco_delete'   => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => TRUE,
                'default'    => 0,
                'comment'    => 'สถานะการลบ (0 = ใช้งาน, 1 = ลบ)'
            ],
            'glco_cancel'   => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => TRUE,
                'default'    => 0,
                'comment'    => 'สถานะการยกเลิก (0 = ไม่ยกเลิก, 1 = ยกเลิก)'
            ],
            'timestamp'     => [ 
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => TRUE,
                'comment'    => 'ค่า timestamp เฉพาะของรายการ'
            ],
            'gamb_text'     => [ 
                'type'    => 'TEXT',
                'null'    => TRUE,
                'comment' => 'รายละเอียดเพิ่มเติมของรายการ'
            ],
            'isRedelivery'  => [ 
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => FALSE,
                'default'    => '0',
                'comment'    => 'สถานะการส่งซ้ำ (0 = ไม่ส่งซ้ำ, อื่นๆ = ส่งซ้ำ)'
            ],
            'glco_success'  => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => FALSE,
                'default'    => 0,
                'comment'    => 'สถานะสำเร็จ (0 = ไม่สำเร็จ, 1 = สำเร็จ)'
            ],
        ];

        $this->forge->addField ( $fields );
        $this->forge->addPrimaryKey ( 'gamb_ID' );
        $this->forge->addKey ( 'glco_ID', FALSE, FALSE, 'gambli1' );
        $this->forge->addKey ( 'grId', FALSE, FALSE, 'gambli2' );
        $this->forge->addKey ( 'groupId', FALSE, FALSE, 'gambli3' );
        $this->forge->addKey ( 'groupLive_ID', FALSE, FALSE, 'gambli4' );
        $this->forge->addKey ( 'msID', FALSE, FALSE, 'gambli5' );
        $this->forge->addKey ( 'user_id', FALSE, FALSE, 'gambli6' );

        $this->forge->addForeignKey ( 'glco_ID', 'group_live_card_opens', 'glco_ID', 'CASCADE', 'CASCADE', 'gambli1' );
        $this->forge->addForeignKey ( 'grId', 'gamerules', 'grId', 'CASCADE', 'CASCADE', 'gambli2' );
        $this->forge->addForeignKey ( 'groupId', 'groups', 'groupId', 'CASCADE', 'CASCADE', 'gambli3' );
        $this->forge->addForeignKey ( 'groupLive_ID', 'group_lives', 'groupLive_ID', 'CASCADE', 'CASCADE', 'gambli4' );
        $this->forge->addForeignKey ( 'msID', 'gamemasters', 'msID', 'CASCADE', 'CASCADE', 'gambli5' );
        $this->forge->addForeignKey ( 'user_id', 'members', 'user_id', 'CASCADE', 'CASCADE', 'gambli6' );

        $attributes = [ 
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable ( 'gambling_histories', TRUE, $attributes );

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม ดังนั้นจะไม่มีการ insertBatch
    }

    public function down()
    {
        $this->forge->dropTable ( 'gambling_histories', TRUE );
    }
}