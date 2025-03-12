<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBanklists extends Migration
{
    public function up()
    {
        $fields = [ 
            'blit_id'             => [ 
                'type'           => 'BIGINT',
                'auto_increment' => TRUE,
                'comment'        => 'รหัสประจำตัวบัญชีธนาคาร (Primary Key)'
            ],
            'ac_code'             => [ 
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => FALSE,
                'comment'    => 'รหัสแอดมินที่เป็นเจ้าของบัญชี (Foreign Key จาก accounts_admin)'
            ],
            'bank_id'             => [ 
                'type'    => 'BIGINT',
                'null'    => FALSE,
                'comment' => 'รหัสชื่อธนาคาร (Foreign Key จาก banks)'
            ],
            'blit_number'         => [ 
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => FALSE,
                'comment'    => 'เลขที่บัญชีธนาคาร (Unique)'
            ],
            'blit_name'           => [ 
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => FALSE,
                'comment'    => 'ชื่อบัญชีธนาคาร'
            ],
            'created_at'          => [ 
                'type'    => 'TIMESTAMP',
                'null'    => FALSE,
                'comment' => 'วันเวลาที่สร้างข้อมูล'
            ],
            'updated_at'          => [ 
                'type'    => 'TIMESTAMP',
                'null'    => FALSE,
                'comment' => 'วันเวลาที่อัพเดทข้อมูลล่าสุด'
            ],
            'blit_delete'         => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => FALSE,
                'default'    => 0,
                'comment'    => 'สถานะการลบ (0 = ใช้งาน, 1 = ลบ)'
            ],
            'blit_image'          => [ 
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => TRUE,
                'comment'    => 'ชื่อไฟล์รูปภาพของบัญชี (ถ้ามี)'
            ],
            'blit_remain'         => [ 
                'type'       => 'DECIMAL',
                'constraint' => '65,2',
                'null'       => FALSE,
                'default'    => '0.00',
                'comment'    => 'ยอดเงินคงเหลือในบัญชี'
            ],
            'blit_delete_ad_code' => [ 
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => FALSE,
                'comment'    => 'รหัสแอดมินที่ทำการลบ (ถ้ามีการลบ)'
            ],
        ];

        $this->forge->addField ( $fields );
        $this->forge->addPrimaryKey ( 'blit_id' );
        $this->forge->addUniqueKey ( 'blit_number' );
        $this->forge->addKey ( 'bank_id', FALSE, FALSE, 'banklists1' );
        $this->forge->addKey ( 'ac_code', FALSE, FALSE, 'banklists2' );
        $this->forge->addForeignKey ( 'bank_id', 'banks', 'bank_id', 'CASCADE', 'CASCADE', 'banklists1' );
        $this->forge->addForeignKey ( 'ac_code', 'accounts_admin', 'ac_code', 'CASCADE', 'CASCADE', 'banklists2' );

        $attributes = [ 
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable ( 'banklists', TRUE, $attributes );

        // ข้อมูลเริ่มต้น
        $data = [ 
            [ 
                'blit_id'             => 1,
                'ac_code'             => 'bmU-85368698',
                'bank_id'             => 25,
                'blit_number'         => '9999999999',
                'blit_name'           => 'System Bank',
                'created_at'          => '2024-07-13 16:30:33',
                'updated_at'          => '2024-07-13 16:31:59',
                'blit_delete'         => 0,
                'blit_image'          => NULL,
                'blit_remain'         => '0.00',
                'blit_delete_ad_code' => ''
            ],
        ];
        $this->db->table ( 'banklists' )->insertBatch ( $data );

    }

    public function down()
    {
        $this->forge->dropTable ( 'banklists', TRUE );
    }
}