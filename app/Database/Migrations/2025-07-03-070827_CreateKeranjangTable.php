<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKeranjangTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_keranjang' => [
                'type' => 'int',
                'constraint' => 11,
                'auto_increment' => true,
                'unsigned' => true
            ],
            'id_pengguna' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true
            ],
            'id_kebaya' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true
            ],
            'kuantitas' => [
                'type' => 'int',
                'constraint' => 11,
                'default' => 1,
            ],
            'harga_saat_ditambah' => [
                'type' => 'int',
                'constraint' => 11
            ],
            'waktu_dibuat' => ['type' => 'datetime', 'null' => true],
            'waktu_diubah' => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_keranjang');
        $this->forge->addForeignKey('id_pengguna', 'users', 'id', '', 'cascade');
        $this->forge->addForeignKey('id_kebaya', 'kebaya', 'id_kebaya', '', 'cascade');
        $this->forge->createTable('keranjang');
    }

    public function down()
    {
        $this->forge->dropTable('keranjang');
    }
}
