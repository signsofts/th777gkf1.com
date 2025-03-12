<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRoles extends Migration
{
    public function up()
    {
        $fields = [
            'RoleID' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'comment'        => 'รหัสประจำตัวบทบาท (Primary Key)'
            ],
            'RoleName' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'comment'    => 'ชื่อบทบาท'
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('RoleID');
        
        $attributes = [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];
        
        $this->forge->createTable('roles', true, $attributes);

        // เพิ่มข้อมูลเริ่มต้นจาก SQL dump
        $data = [
            ['RoleID' => 1, 'RoleName' => 'Admin'],
            ['RoleID' => 2, 'RoleName' => 'MANAGER'],
            ['RoleID' => 3, 'RoleName' => 'STAFF'],
            ['RoleID' => 4, 'RoleName' => 'Super Admin'],
            ['RoleID' => 5, 'RoleName' => 'STAFF ROOM'],
            ['RoleID' => 6, 'RoleName' => 'STAFF MEMBER'],
            ['RoleID' => 7, 'RoleName' => 'STAFF BANK'],
            ['RoleID' => 8, 'RoleName' => 'AGENT'],
        ];
        $this->db->table('roles')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('roles', true);
    }
}