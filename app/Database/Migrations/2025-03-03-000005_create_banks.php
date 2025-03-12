<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBanks extends Migration
{
    public function up()
    {
        $fields = [ 
            'bank_id'     => [ 
                'type'           => 'BIGINT',
                'auto_increment' => TRUE,
                'comment'        => 'รหัสประจำตัวธนาคาร (Primary Key)'
            ],
            'bank_name'   => [ 
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => TRUE,
                'comment'    => 'ชื่อธนาคารภาษาไทย'
            ],
            'bank_icon'   => [ 
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => TRUE,
                'comment'    => 'ชื่อไฟล์ไอคอนของธนาคาร'
            ],
            'created_at'  => [ 
                'type'    => 'TIMESTAMP',
                'null'    => TRUE,
                'comment' => 'วันเวลาที่สร้างข้อมูล'
            ],
            'update_at'   => [ 
                'type'    => 'TIMESTAMP',
                'null'    => TRUE,
                'comment' => 'วันเวลาที่อัพเดทข้อมูลล่าสุด'
            ],
            'bank_delete' => [ 
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => 'สถานะการลบ (0 = ใช้งาน, 1 = ลบ)'
            ],
            'bank_nameEN' => [ 
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => TRUE,
                'comment'    => 'ชื่อธนาคารภาษาอังกฤษ'
            ],
        ];

        $this->forge->addField ( $fields );
        $this->forge->addPrimaryKey ( 'bank_id' );

        $attributes = [ 
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable ( 'banks', TRUE, $attributes );

        // เพิ่มข้อมูลเริ่มต้นทั้ง 25 รายการ
        $data = [ 
            [ 
                'bank_id'     => 1,
                'bank_name'   => 'ธนาคารแห่งประเทศไทย',
                'bank_icon'   => 'Seal_of_the_Bank_of_Thailand',
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-26 22:50:48',
                'bank_delete' => 0,
                'bank_nameEN' => 'Bank of Thailand'
            ],
            [ 
                'bank_id'     => 2,
                'bank_name'   => 'ธนาคารกรุงเทพ',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-26 22:50:48',
                'bank_delete' => 0,
                'bank_nameEN' => 'BANGKOK BANK PUBLIC COMPANY LIMITED'
            ],
            [ 
                'bank_id'     => 3,
                'bank_name'   => 'ธนาคารกสิกรไทย',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-26 22:50:48',
                'bank_delete' => 0,
                'bank_nameEN' => 'KASIKORNBANK PUBLIC COMPANY LIMITED'
            ],
            [ 
                'bank_id'     => 4,
                'bank_name'   => 'ธนาคารกรุงไทย',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-26 22:50:48',
                'bank_delete' => 0,
                'bank_nameEN' => 'Krung Thai Bank Public Company Limited'
            ],
            [ 
                'bank_id'     => 5,
                'bank_name'   => 'ธนาคารทหารไทยธนชาต',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-26 22:50:48',
                'bank_delete' => 0,
                'bank_nameEN' => 'TMBThanachart Bank Public Company Limited'
            ],
            [ 
                'bank_id'     => 6,
                'bank_name'   => 'ธนาคารไทยพาณิชย์',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-26 22:50:48',
                'bank_delete' => 0,
                'bank_nameEN' => 'Siam Commercial Bank PCL.'
            ],
            [ 
                'bank_id'     => 7,
                'bank_name'   => 'ธนาคารกรุงศรีอยุธยา',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-26 22:50:48',
                'bank_delete' => 0,
                'bank_nameEN' => 'BANK OF AYUDHYA PUBLIC COMPANY LIMITED'
            ],
            [ 
                'bank_id'     => 8,
                'bank_name'   => 'ธนาคารเกียรตินาคินภัทร',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-26 22:50:48',
                'bank_delete' => 0,
                'bank_nameEN' => 'KIATNAKIN PHATRA BANK PUBLIC COMPANY LIMITED'
            ],
            [ 
                'bank_id'     => 9,
                'bank_name'   => 'ธนาคารซีไอเอ็มบีไทย',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-26 22:50:48',
                'bank_delete' => 0,
                'bank_nameEN' => 'CIMB THAI BANK PUBLIC COMPANY LIMITED'
            ],
            [ 
                'bank_id'     => 10,
                'bank_name'   => 'ธนาคารทิสโก้',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-26 22:50:48',
                'bank_delete' => 0,
                'bank_nameEN' => 'TISCO BANK PUBLIC COMPANY LIMITED'
            ],
            [ 
                'bank_id'     => 11,
                'bank_name'   => 'ธนาคารยูโอบี',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-26 22:50:48',
                'bank_delete' => 0,
                'bank_nameEN' => 'UNITED OVERSEAS BANK (THAI) PUBLIC COMPANY LIMITED (UOB)'
            ],
            [ 
                'bank_id'     => 12,
                'bank_name'   => 'ธนาคารไทยเครดิต',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-26 22:50:48',
                'bank_delete' => 0,
                'bank_nameEN' => 'THAI CREDIT BANK PUBLIC COMPANY LIMITED'
            ],
            [ 
                'bank_id'     => 13,
                'bank_name'   => 'ธนาคารแลนด์ แอนด์ เฮ้าส์',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-26 22:50:48',
                'bank_delete' => 0,
                'bank_nameEN' => 'LAND AND HOUSES BANK PUBLIC COMPANY LIMITED'
            ],
            [ 
                'bank_id'     => 14,
                'bank_name'   => 'ธนาคารไอซีบีซี (ไทย)',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-09 07:00:44',
                'bank_delete' => 0,
                'bank_nameEN' => ''
            ],
            [ 
                'bank_id'     => 15,
                'bank_name'   => 'ธนาคารพัฒนาวิสาหกิจขนาดกลางและขนาดย่อมแห่งประเทศไทย',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-26 22:50:48',
                'bank_delete' => 0,
                'bank_nameEN' => 'Small and Medium Enterprise Development Bank of Thailand'
            ],
            [ 
                'bank_id'     => 16,
                'bank_name'   => 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-26 22:50:48',
                'bank_delete' => 0,
                'bank_nameEN' => 'Bank for Agriculture and Agricultural Cooperatives (BAAC)'
            ],
            [ 
                'bank_id'     => 17,
                'bank_name'   => 'ธนาคารเพื่อการส่งออกและนำเข้าแห่งประเทศไทย',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-09 07:00:44',
                'bank_delete' => 0,
                'bank_nameEN' => ''
            ],
            [ 
                'bank_id'     => 18,
                'bank_name'   => 'ธนาคารออมสิน',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-09 07:00:44',
                'bank_delete' => 0,
                'bank_nameEN' => ''
            ],
            [ 
                'bank_id'     => 19,
                'bank_name'   => 'ธนาคารอาคารสงเคราะห์',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-09 07:00:44',
                'bank_delete' => 0,
                'bank_nameEN' => ''
            ],
            [ 
                'bank_id'     => 20,
                'bank_name'   => 'ธนาคารอิสลามแห่งประเทศไทย',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-09 07:00:44',
                'bank_delete' => 0,
                'bank_nameEN' => ''
            ],
            [ 
                'bank_id'     => 21,
                'bank_name'   => 'ธนาคารเมกะ สากลพาณิชย์',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-09 07:00:44',
                'bank_delete' => 0,
                'bank_nameEN' => ''
            ],
            [ 
                'bank_id'     => 22,
                'bank_name'   => 'ธนาคารแห่งประเทศจีน (ไทย)',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-09 07:00:44',
                'bank_delete' => 0,
                'bank_nameEN' => ''
            ],
            [ 
                'bank_id'     => 23,
                'bank_name'   => 'ธนาคารเอเอ็นแซด (ไทย)',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-09 07:00:44',
                'bank_delete' => 0,
                'bank_nameEN' => ''
            ],
            [ 
                'bank_id'     => 24,
                'bank_name'   => 'ธนาคารซูมิโตโม มิตซุย ทรัสต์ (ไทย)',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-09 07:00:44',
                'update_at'   => '2024-06-09 07:00:44',
                'bank_delete' => 0,
                'bank_nameEN' => ''
            ],
            [ 
                'bank_id'     => 25,
                'bank_name'   => 'System Bank',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-18 20:29:34',
                'update_at'   => '2024-06-18 20:29:34',
                'bank_delete' => 0,
                'bank_nameEN' => 'System Bank'
            ],
            [ 
                'bank_id'     => 26,
                'bank_name'   => 'วอเลต',
                'bank_icon'   => NULL,
                'created_at'  => '2024-06-18 20:29:34',
                'update_at'   => '2024-06-18 20:29:34',
                'bank_delete' => 0,
                'bank_nameEN' => 'Wallet'
            ],
        ];
        $this->db->table ( 'banks' )->insertBatch ( $data );
    }

    public function down()
    {
        $this->forge->dropTable ( 'banks', TRUE );
    }
}