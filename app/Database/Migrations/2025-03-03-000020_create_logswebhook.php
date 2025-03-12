<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogswebhook extends Migration
{
    public function up()
    {
        $fields = [ 
            'lwb_id'          => [ 
                'type'           => 'BIGINT',
                'auto_increment' => TRUE,
                'comment'        => 'รหัสประจำตัวล็อก webhook (Primary Key)'
            ],
            'lwb_destination' => [ 
                'type'    => 'TEXT',
                'null'    => FALSE,
                'comment' => 'ปลายทางของ webhook'
            ],
            'lwb_events'      => [ 
                'type'    => 'LONGTEXT',
                'null'    => FALSE,
                'comment' => 'เหตุการณ์ของ webhook'
            ],
            'created_at'      => [ 
                'type'    => 'TIMESTAMP',
                'null'    => FALSE,
                'comment' => 'วันเวลาที่สร้างข้อมูล'
            ],
            'update_at'       => [ 
                'type'    => 'DATETIME',
                'null'    => FALSE,
                'comment' => 'วันเวลาที่อัพเดทข้อมูลล่าสุด'
            ],
        ];

        $this->forge->addField ( $fields );
        $this->forge->addPrimaryKey ( 'lwb_id' );

        $attributes = [ 
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable ( 'logswebhook', TRUE, $attributes );

        // ไม่มีข้อมูลเริ่มต้นใน SQL dump เดิม
    }

    public function down()
    {
        $this->forge->dropTable ( 'logswebhook', TRUE );
    }
}