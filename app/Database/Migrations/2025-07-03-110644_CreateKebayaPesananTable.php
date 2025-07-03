<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKebayaPesananTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kebaya_pesanan' => [
                'type' => 'int',
                'constraint' => 11,
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'id_sewa' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_kebaya' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'kuantitas' => [
                'type' => 'int',
                'constraint' => 11
            ]
        ]);
        $this->forge->addPrimaryKey('id_kebaya_pesanan');
        $this->forge->addForeignKey('id_sewa', 'sewa', 'id_sewa', '', 'cascade');
        $this->forge->addForeignKey('id_kebaya', 'kebaya', 'id_kebaya', '', 'cascade');
        $this->forge->createTable('kebaya_pesanan');
    }

    public function down()
    {
        $this->forge->dropTable('kebaya_pesanan');
    }
}
