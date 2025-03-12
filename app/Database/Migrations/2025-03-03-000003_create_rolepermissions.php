<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolepermissions extends Migration
{
    public function up()
    {
        $fields = [ 
            'RoleID'       => [ 
                'type'    => 'INT',
                'null'    => FALSE,
                'comment' => 'รหัสบทบาท (Foreign Key จาก roles)'
            ],
            'PermissionID' => [ 
                'type'    => 'INT',
                'null'    => FALSE,
                'comment' => 'รหัสสิทธิ์ (Foreign Key จาก permissions)'
            ],
        ];

        $this->forge->addField ( $fields );
        $this->forge->addPrimaryKey ( [ 'RoleID', 'PermissionID' ] );
        $this->forge->addKey ( 'PermissionID' );
        $this->forge->addForeignKey ( 'RoleID', 'roles', 'RoleID', 'CASCADE', 'CASCADE' );
        $this->forge->addForeignKey ( 'PermissionID', 'permissions', 'PermissionID', 'CASCADE', 'CASCADE' );

        $attributes = [ 
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable ( 'rolepermissions', TRUE, $attributes );

        // เพิ่มข้อมูลเริ่มต้นจาก SQL dump
        $data = [ 
            [ 'RoleID' => 1, 'PermissionID' => 1 ],
            [ 'RoleID' => 2, 'PermissionID' => 1 ],
            [ 'RoleID' => 1, 'PermissionID' => 2 ],
            [ 'RoleID' => 2, 'PermissionID' => 2 ],
            [ 'RoleID' => 3, 'PermissionID' => 2 ],
            [ 'RoleID' => 1, 'PermissionID' => 3 ],
            [ 'RoleID' => 2, 'PermissionID' => 3 ],
            [ 'RoleID' => 1, 'PermissionID' => 4 ],
            [ 'RoleID' => 2, 'PermissionID' => 4 ],
            [ 'RoleID' => 3, 'PermissionID' => 4 ],
        ];
        $this->db->table ( 'rolepermissions' )->insertBatch ( $data );
    }

    public function down()
    {
        $this->forge->dropTable ( 'rolepermissions', TRUE );
    }
}