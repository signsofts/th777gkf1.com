<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGamerules extends Migration
{
    public function up()
    {
        $fields = [
            'grId' => [
                'type' => 'BIGINT',
                'auto_increment' => true,
                'comment' => 'รหัสประจำตัวกติกา (Primary Key)'
            ],
            'grName' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'ชื่อกติกาภาษาไทย'
            ],
            'grKeyLine' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
                'comment' => 'รหัสกติกาแบบสั้น'
            ],
            'grMultiply' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'default' => '1.00',
                'comment' => 'อัตราต่อรอง (ค่าเริ่มต้น 1.00)'
            ],
            'grDelete' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => true,
                'default' => 0,
                'comment' => 'สถานะการลบ (0 = ใช้งาน, 1 = ลบ)'
            ],
            'msID' => [
                'type' => 'BIGINT',
                'null' => true,
                'comment' => 'รหัสเกม (Foreign Key จาก gamemasters)'
            ],
            'grNote' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'หมายเหตุของกติกา'
            ],
            'grNameEN' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'ชื่อกติกาภาษาอังกฤษ'
            ],
            'grTextTH' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'คำอธิบายกติกาภาษาไทย'
            ],
            'grTextEN' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'คำอธิบายกติกาภาษาอังกฤษ'
            ],
            'grTextRulesTH' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'กฎการเล่นภาษาไทย'
            ],
            'grTextRulesEN' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'กฎการเล่นภาษาอังกฤษ'
            ],
            'grUrlIcon' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'URL ของไอคอนกติกา'
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('grId');
        $this->forge->addKey('msID', false, false, 'mg_gr_1');
        $this->forge->addForeignKey('msID', 'gamemasters', 'msID', 'CASCADE', 'CASCADE', 'mg_gr_1');

        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci'
        ];

        $this->forge->createTable('gamerules', true, $attributes);

        // เพิ่มข้อมูลเริ่มต้นจาก SQL dump
        $data = [
            [
                'grId' => 1,
                'grName' => 'เสือ',
                'grKeyLine' => '1',
                'grMultiply' => '1.00',
                'grDelete' => 0,
                'msID' => 1,
                'grNote' => '',
                'grNameEN' => 'tiger',
                'grTextTH' => 'ชนะ ได้ 100',
                'grTextEN' => 'WIN receive 100',
                'grTextRulesTH' => 'แทง เสือ 100 ได้ 100',
                'grTextRulesEN' => 'Bet on Tiger 100, get 100.',
                'grUrlIcon' => 'https://img.icons8.com/?size=100&id=amr4dGCohyBU&format=png&color=111111'
            ],
            [
                'grId' => 2,
                'grName' => 'มังกร',
                'grKeyLine' => '2',
                'grMultiply' => '1.00',
                'grDelete' => 0,
                'msID' => 1,
                'grNote' => '',
                'grNameEN' => 'dragon',
                'grTextTH' => 'ชนะ ได้ 100',
                'grTextEN' => 'WIN receive 100',
                'grTextRulesTH' => 'แทง มังกร 100 ได้ 100',
                'grTextRulesEN' => 'Bet on Dragon 100 and get 100.',
                'grUrlIcon' => 'https://img.icons8.com/?size=100&id=SCY7gqvxY0DC&format=png&color=000000'
            ],
            [
                'grId' => 3,
                'grName' => 'คู่',
                'grKeyLine' => '3',
                'grMultiply' => '20.00',
                'grDelete' => 0,
                'msID' => 1,
                'grNote' => '-',
                'grNameEN' => 'dual',
                'grTextTH' => 'ชนะ ได้ 2000',
                'grTextEN' => 'WIN receive 2000',
                'grTextRulesTH' => 'แทง คู่ 100 ได้ 2000',
                'grTextRulesEN' => 'Bet on pair 100, get 2000',
                'grUrlIcon' => 'https://img.icons8.com/emoji/48/green-circle-emoji.png'
            ],
            [
                'grId' => 4,
                'grName' => 'เสมอ',
                'grKeyLine' => '4',
                'grMultiply' => '20.00',
                'grDelete' => 0,
                'msID' => 1,
                'grNote' => '-',
                'grNameEN' => 'always',
                'grTextTH' => 'ชนะ ได้ 2000',
                'grTextEN' => 'WIN receive 2000',
                'grTextRulesTH' => 'แทง เสมอ 100 ได้ 2000',
                'grTextRulesEN' => 'Always bet 100, get 2,000',
                'grUrlIcon' => 'https://img.icons8.com/ios-filled/50/F4F206/filled-circle.png'
            ],
            [
                'grId' => 5,
                'grName' => 'ผู้เล่น',
                'grKeyLine' => '1',
                'grMultiply' => '1.00',
                'grDelete' => 0,
                'msID' => 2,
                'grNote' => '-',
                'grNameEN' => 'PLAYER',
                'grTextTH' => 'ชนะ ได้ 100',
                'grTextEN' => 'WIN receive 100',
                'grTextRulesTH' => '-แทง ผู้เล่น 100 ได้ 100',
                'grTextRulesEN' => 'Bet on Player 100, get 100.',
                'grUrlIcon' => 'https://img.icons8.com/?size=100&id=SCY7gqvxY0DC&format=png&color=000000'
            ],
            [
                'grId' => 6,
                'grName' => 'เจ้ามือ',
                'grKeyLine' => '2',
                'grMultiply' => '1.00',
                'grDelete' => 0,
                'msID' => 2,
                'grNote' => '-',
                'grNameEN' => 'BANKER',
                'grTextTH' => 'ชนะ ได้ 100',
                'grTextEN' => 'WIN receive 100',
                'grTextRulesTH' => '-แทง ผู้เล่น 100 ได้ 100',
                'grTextRulesEN' => 'Bet on Banker 100, get 100.',
                'grUrlIcon' => 'https://img.icons8.com/?size=100&id=amr4dGCohyBU&format=png&color=111111'
            ],
            [
                'grId' => 7,
                'grName' => 'เสมอ',
                'grKeyLine' => '3',
                'grMultiply' => '20.00',
                'grDelete' => 0,
                'msID' => 2,
                'grNote' => '-',
                'grNameEN' => 'always',
                'grTextTH' => 'ชนะ ได้ 2000',
                'grTextEN' => 'WIN receive 2000',
                'grTextRulesTH' => '-แทง ผู้เล่น 100 ได้ 2000',
                'grTextRulesEN' => 'Bet on Banker 100, get 2000.',
                'grUrlIcon' => 'https://img.icons8.com/ios-filled/50/F4F206/filled-circle.png'
            ],
            [
                'grId' => 8,
                'grName' => 'ขา 1 ชนะ',
                'grKeyLine' => '1',
                'grMultiply' => '1.00',
                'grDelete' => 0,
                'msID' => 3,
                'grNote' => '-',
                'grNameEN' => 'Leg 1 wins',
                'grTextTH' => 'ชนะ ได้ 100',
                'grTextEN' => 'WIN receive 100',
                'grTextRulesTH' => '- แทง ขา 1 100 ได้ 100',
                'grTextRulesEN' => 'Bet 1 leg 100 get 100.',
                'grUrlIcon' => 'https://img.icons8.com/?size=100&id=SCY7gqvxY0DC&format=png&color=000000'
            ],
            [
                'grId' => 9,
                'grName' => 'ขา 2 ชนะ',
                'grKeyLine' => '2',
                'grMultiply' => '1.00',
                'grDelete' => 0,
                'msID' => 3,
                'grNote' => '-',
                'grNameEN' => 'Leg 2 wins',
                'grTextTH' => 'ชนะ ได้ 100',
                'grTextEN' => 'WIN receive 100',
                'grTextRulesTH' => '- แทง ขา 2 100 ได้ 100',
                'grTextRulesEN' => 'Bet 2 leg 100 get 100.',
                'grUrlIcon' => 'https://img.icons8.com/ios-filled/50/F4F206/filled-circle.png'
            ],
            [
                'grId' => 10,
                'grName' => 'ขา 3 ชนะ',
                'grKeyLine' => '3',
                'grMultiply' => '1.00',
                'grDelete' => 0,
                'msID' => 3,
                'grNote' => '-',
                'grNameEN' => 'Leg 3 wins',
                'grTextTH' => 'ชนะ ได้ 100',
                'grTextEN' => 'WIN receive 100',
                'grTextRulesTH' => '- แทง ขา 3 100 ได้ 100',
                'grTextRulesEN' => 'Bet 3 leg 100 get 100.',
                'grUrlIcon' => 'https://img.icons8.com/emoji/48/green-circle-emoji.png'
            ],

        ];
        $this->db->table('gamerules')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('gamerules', true);
    }
}