<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroupmemberlists extends Migration
{
    public function up()
    {
        $fields = [ 
            'listId'     => [ 
                'type'           => 'BIGINT',
                'auto_increment' => TRUE,
                'comment'        => 'รหัสประจำตัวรายการสมาชิกกลุ่ม (Primary Key)'
            ],
            'user_id'     => [ 
                'type'       => 'INT',
                'constraint' => 255,
                'null'       => FALSE,
                'comment'    => 'รหัสผู้ใช้ (Foreign Key จาก members)'
            ],
            'groupId'    => [ 
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => FALSE,
                'comment'    => 'รหัสกลุ่ม (Foreign Key จาก groups)'
            ],
            'listDelete' => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => FALSE,
                'default'    => 0,
                'comment'    => 'สถานะการลบ (0 = ใช้งาน, 1 = ลบ)'
            ],
            'datetime'   => [ 
                'type'    => 'TIMESTAMP',
                'null'    => TRUE,
                'comment' => 'วันเวลาของรายการ'
            ],
            'created_at' => [ 
                'type'    => 'TIMESTAMP',
                'null'    => FALSE,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
                'comment' => 'วันเวลาที่สร้างข้อมูล'
            ],
            'updated_at' => [ 
                'type'      => 'TIMESTAMP',
                'null'      => FALSE,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
                'on_update' => 'CURRENT_TIMESTAMP',
                'comment'   => 'วันเวลาที่อัพเดทข้อมูลล่าสุด'
            ],
            'deleted_at' => [ 
                'type'    => 'TIMESTAMP',
                'null'    => TRUE,
                'comment' => 'วันเวลาที่ลบข้อมูล (Soft Delete)'
            ],
        ];

        $this->forge->addField ( $fields );
        $this->forge->addPrimaryKey ( 'listId' );
        $this->forge->addForeignKey ( 'user_id', 'members', 'user_id', 'CASCADE', 'CASCADE' );
        $this->forge->addForeignKey ( 'groupId', 'groups', 'groupId', 'CASCADE', 'CASCADE' );

        $attributes = [ 
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable ( 'groupmemberlists', TRUE, $attributes );

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม ดังนั้นจะไม่มีการ insertBatch
    }

    public function down()
    {
        $this->forge->dropTable ( 'groupmemberlists', TRUE );
    }
}