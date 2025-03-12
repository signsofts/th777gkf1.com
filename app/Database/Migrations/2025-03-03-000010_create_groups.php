<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroups extends Migration
{
    public function up()
    {
        $fields = [ 
            'groupId'               => [ 
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => FALSE,
                'comment'    => 'รหัสประจำตัวกลุ่ม (Primary Key)'
            ],
            'groupName'             => [ 
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => FALSE,
                'comment'    => 'ชื่อกลุ่ม'
            ],
            'msID'                  => [ 
                'type'    => 'BIGINT',
                'null'    => TRUE,
                'comment' => 'รหัสเกมหลัก (Foreign Key จาก gamemasters)'
            ],
            'datetime'              => [ 
                'type'    => 'TIMESTAMP',
                'null'    => TRUE,
                'comment' => 'วันเวลาของรายการ'
            ],
            'groupDelete'           => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => FALSE,
                'default'    => 0,
                'comment'    => 'สถานะการลบ (0 = ใช้งาน, 1 = ลบ)'
            ],
            'created_at'            => [ 
                'type'    => 'TIMESTAMP',
                'null'    => TRUE,
                'comment' => 'วันเวลาที่สร้างข้อมูล'
            ],
            'updated_at'            => [ 
                'type'    => 'TIMESTAMP',
                'null'    => TRUE,
                'comment' => 'วันเวลาที่อัพเดทข้อมูลล่าสุด'
            ],
            'deleted_at'            => [ 
                'type'    => 'TIMESTAMP',
                'null'    => TRUE,
                'comment' => 'วันเวลาที่ลบข้อมูล (Soft Delete)'
            ],
            'pictureUrl'            => [ 
                'type'    => 'TEXT',
                'null'    => TRUE,
                'comment' => 'URL รูปภาพของกลุ่ม'
            ],
            'group_language'        => [ 
                'type'       => 'ENUM',
                'constraint' => [ 'th', 'en' ],
                'null'       => TRUE,
                'default'    => 'th',
                'comment'    => 'ภาษาของกลุ่ม (th = ไทย, en = อังกฤษ)'
            ],
            'GRO_Total_Quantity'    => [ 
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => FALSE,
                'default'    => '0.00',
                'comment'    => 'จำนวนเงินทั้งหมดที่ลง'
            ],
            'GRO_Total_Payment'     => [ 
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => FALSE,
                'default'    => '0.00',
                'comment'    => 'ยอดชำระเงินทั้งหมด'
            ],
            'GRO_Remaining_Balance' => [ 
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => FALSE,
                'default'    => '0.00',
                'comment'    => 'ยอดเงินคงเหลือของกลุ่ม'
            ],
            'GRO_InviteLink'        => [ 
                'type'    => 'TEXT',
                'null'    => TRUE,
                'comment' => 'ลิงค์เชิญเข้ากลุ่ม'
            ],
        ];

        $this->forge->addField ( $fields );
        $this->forge->addPrimaryKey ( 'groupId' );
        $this->forge->addUniqueKey ( 'groupId' );
        $this->forge->addKey ( 'msID', FALSE, FALSE, 'msIDTo1' );
        $this->forge->addForeignKey ( 'msID', 'gamemasters', 'msID', 'CASCADE', 'CASCADE', 'msIDTo1' );

        $attributes = [ 
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable ( 'groups', TRUE, $attributes );

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม ดังนั้นจะไม่มีการ insertBatch
    }

    public function down()
    {
        $this->forge->dropTable ( 'groups', TRUE );
    }
}