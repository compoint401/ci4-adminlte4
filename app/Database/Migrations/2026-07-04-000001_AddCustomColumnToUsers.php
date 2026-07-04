<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCustomColumnToUsers extends Migration
{
    public function up()
    {
        $fields = [
            "gender SET('male', 'female', 'bisexual') NULL DEFAULT NULL COMMENT 'gender user'",
            'first_name' => [
                'type' => 'text',
                'constraint' => '50',
                'null' => TRUE
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE
            ],
            'avatar' => [
                'type' => 'VARCHAR',
                'constraint' => '1000',
                'null' => TRUE
            ],
            'phone_number' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ],
            'company' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '1200',
                'null' => TRUE
            ],
            'code_meli' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ],
            'birth_day date default NULL',
            'country' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ],
            'state' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ],
            'full_address' => [
                'type' => 'VARCHAR',
                'constraint' => '400',
                'null' => TRUE
            ],


        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
          $fields = [
            'gender',
            'first_name',
            'last_name',
            'company',
            'phone_number',
            'description',
            'code_meli',
            'birth_day',
            'country',
            'state',
            'city',
            'full_address',

        ];
        $this->forge->dropColumn('users', $fields);
    
    }
}
