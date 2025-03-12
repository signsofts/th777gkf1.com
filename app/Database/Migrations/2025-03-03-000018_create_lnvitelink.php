<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLnvitelink extends Migration
{
    public function up()
    {
        $fields = [ 
            'LL_ID'         => [ 
                'type'           => 'INT',
                'auto_increment' => TRUE,
                'comment'        => 'รหัสประจำตัวลิงค์เชิญ (Primary Key)'
            ],
            'LL_CODE'       => [ 
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => FALSE,
                'comment'    => 'รหัสลิงค์เชิญ'
            ],
            'ac_code'       => [ 
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => FALSE,
                'comment'    => 'รหัสแอดมิน (Foreign Key จาก accounts_admin)'
            ],
            'groupId'       => [ 
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => TRUE,
                'comment'    => 'รหัสกลุ่ม (Foreign Key จาก groups)'
            ],
            'LL_LINK'       => [ 
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => FALSE,
                'comment'    => 'URL ลิงค์เชิญ'
            ],
            'LL_created_at' => [ 
                'type'    => 'TIMESTAMP',
                'null'    => FALSE,
                'comment' => 'วันเวลาที่สร้างลิงค์'
            ],
            'LL_updated_at' => [ 
                'type'    => 'TIMESTAMP',
                'null'    => FALSE,
                'comment' => 'วันเวลาที่อัพเดทลิงค์ล่าสุด'
            ],
            'LL_deleted_at' => [ 
                'type'    => 'TIMESTAMP',
                'null'    => FALSE,
                'comment' => 'วันเวลาที่ลบลิงค์'
            ],
            'LL_START_DATE' => [ 
                'type'    => 'DATE',
                'null'    => FALSE,
                'comment' => 'วันที่เริ่มใช้งานลิงค์'
            ],
            'LL_EXPIRE'     => [ 
                'type'    => 'DATE',
                'null'    => TRUE,
                'comment' => 'วันที่หมดอายุลิงค์'
            ],
            'LL_COUNT'      => [ 
                'type'    => 'INT',
                'null'    => FALSE,
                'default' => 0,
                'comment' => 'จำนวนครั้งที่ใช้งานลิงค์'
            ],
            'LL_TYPE'       => [ 
                'type'       => 'ENUM',
                'constraint' => [ 'lnv', 'member' ],
                'null'       => FALSE,
                'default'    => 'lnv',
                'comment'    => 'ประเภทลิงค์ (lnv = ลิงค์ทั่วไป, member = ลิงค์สมาชิก)'
            ],
            'user_id'        => [ 
                'type'       => 'INT',
                'constraint' => 255,
                'null'       => TRUE,
                'comment'    => 'รหัสผู้ใช้ (Foreign Key จาก members)'
            ],
            'LL_LIMIT'      => [ 
                'type'    => 'INT',
                'null'    => TRUE,
                'comment' => 'จำนวนจำกัดการใช้งานลิงค์'
            ],
            'LL_ACTION'     => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => FALSE,
                'default'    => 0,
                'comment'    => 'สถานะการกระทำ (0 = ปกติ, 1 = มีการกระทำ)'
            ],
            'LL_DELETE'     => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => FALSE,
                'default'    => 0,
                'comment'    => 'สถานะการลบ (0 = ใช้งาน, 1 = ลบ)'
            ],
        ];

        $this->forge->addField ( $fields );
        $this->forge->addPrimaryKey ( 'LL_ID' );
        $this->forge->addKey ( 'ac_code', FALSE, FALSE, 'lnvitelink1' );
        $this->forge->addKey ( 'groupId', FALSE, FALSE, 'lnvitelink2' );
        $this->forge->addKey ( 'user_id', FALSE, FALSE, 'lnvitelink3' );
        $this->forge->addForeignKey ( 'ac_code', 'accounts_admin', 'ac_code', 'CASCADE', 'CASCADE', 'lnvitelink1' );
        $this->forge->addForeignKey ( 'groupId', 'groups', 'groupId', 'CASCADE', 'CASCADE', 'lnvitelink2' );
        $this->forge->addForeignKey ( 'user_id', 'members', 'user_id', 'CASCADE', 'CASCADE', 'lnvitelink3' );

        $attributes = [ 
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable ( 'lnvitelink', TRUE, $attributes );

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม
    }

    public function down()
    {
        $this->forge->dropTable ( 'lnvitelink', TRUE );
    }
}