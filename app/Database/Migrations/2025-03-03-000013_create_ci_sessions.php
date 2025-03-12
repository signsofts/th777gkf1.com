<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCiSessions extends Migration
{
    public function up()
    {
        $fields = [ 
            'id'         => [ 
                'type'       => 'VARCHAR',
                'constraint' => 128,
                'null'       => FALSE,
                'comment'    => 'รหัสเซสชัน (Primary Key)'
            ],
            'ip_address' => [ 
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => FALSE,
                'comment'    => 'ที่อยู่ IP ของผู้ใช้'
            ],
            'timestamp'  => [ 
                'type'     => 'BIGINT',
                'unsigned' => TRUE,
                'null'     => FALSE,
                'default'  => 0,
                'comment'  => 'เวลาเซสชันในรูปแบบ timestamp'
            ],
            'data'       => [ 
                'type'    => 'BLOB',
                'null'    => FALSE,
                'comment' => 'ข้อมูลเซสชันที่ถูกเก็บในรูปแบบ binary'
            ],
        ];

        $this->forge->addField ( $fields );
        $this->forge->addPrimaryKey ( 'id' );
        $this->forge->addKey ( 'timestamp', FALSE, FALSE, 'ci_sessions_timestamp' );

        $attributes = [ 
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable ( 'ci_sessions', TRUE, $attributes );

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม ดังนั้นจะไม่มีการ insertBatch
    }

    public function down()
    {
        $this->forge->dropTable ( 'ci_sessions', TRUE );
    }
}