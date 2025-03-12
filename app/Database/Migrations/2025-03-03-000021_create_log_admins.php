<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogAdmins extends Migration
{
    public function up()
    {
        $fields = [ 
            'log_id'      => [ 
                'type'           => 'BIGINT',
                'auto_increment' => TRUE,
                'comment'        => 'รหัสประจำตัวล็อกแอดมิน (Primary Key)'
            ],
            'ac_code'     => [ 
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => TRUE,
                'comment'    => 'รหัสแอดมินที่กระทำ (Foreign Key จาก accounts_admin)'
            ],
            'status_id'   => [ 
                'type'    => 'INT',
                'null'    => TRUE,
                'comment' => 'รหัสสถานะ (Foreign Key จาก status)'
            ],
            'action_note' => [ 
                'type'    => 'TEXT',
                'null'    => TRUE,
                'comment' => 'หมายเหตุการกระทำ'
            ],
            'user_id'      => [ 
                'type'       => 'INT',
                'constraint' => 255,
                'null'       => TRUE,
                'comment'    => 'รหัสผู้ใช้ (Foreign Key จาก members)'
            ],
            'created_at'  => [ 
                'type'    => 'TIMESTAMP',
                'null'    => FALSE,
                'comment' => 'วันเวลาที่สร้างข้อมูล'
            ],
        ];

        $this->forge->addField ( $fields );
        $this->forge->addPrimaryKey ( 'log_id' );
        $this->forge->addKey ( 'status_id', FALSE, FALSE, 'log_admins' );
        $this->forge->addForeignKey ( 'ac_code', 'accounts_admin', 'ac_code', 'CASCADE', 'CASCADE' );
        $this->forge->addForeignKey ( 'status_id', 'status', 'status_id', 'CASCADE', 'CASCADE', 'log_admins' );
        $this->forge->addForeignKey ( 'user_id', 'members', 'user_id', 'CASCADE', 'CASCADE' );

        $attributes = [ 
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable ( 'log_admins', TRUE, $attributes );

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม
    }

    public function down()
    {
        $this->forge->dropTable ( 'log_admins', TRUE );
    }
}