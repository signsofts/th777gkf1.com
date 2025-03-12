<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermissions extends Migration
{
    public function up()
    {
        $fields = [ 
            'PermissionID'   => [ 
                'type'           => 'INT',
                'auto_increment' => TRUE,
                'comment'        => 'รหัสประจำตัวสิทธิ์ (Primary Key)'
            ],
            'PermissionName' => [ 
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => TRUE,
                'comment'    => 'ชื่อสิทธิ์'
            ],
        ];

        $this->forge->addField ( $fields );
        $this->forge->addPrimaryKey ( 'PermissionID' );

        $attributes = [ 
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable ( 'permissions', TRUE, $attributes );

        // เพิ่มข้อมูลเริ่มต้นจาก SQL dump
        $data = [ 
            [ 'PermissionID' => 1, 'PermissionName' => 'Add' ],
            [ 'PermissionID' => 2, 'PermissionName' => 'Edit' ],
            [ 'PermissionID' => 3, 'PermissionName' => 'Delete' ],
            [ 'PermissionID' => 4, 'PermissionName' => 'show' ],
        ];
        $this->db->table ( 'permissions' )->insertBatch ( $data );
    }

    public function down()
    {
        $this->forge->dropTable ( 'permissions', TRUE );
    }
}