<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKebayaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kebaya' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_kategori' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'      => true,
            ],
            'nama_kebaya' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'unique' => true
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'unique'     => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ukuran_tersedia' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'comment'   => 'S,M,L,XL atau Semua Ukuran',
            ],
            'harga_sewa' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'stok' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 1,
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => 'default.png',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['tersedia', 'disewa', 'perbaikan'],
                'default'    => 'tersedia',
            ],
            'rekomendasi' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => '0: tidak rekomendasi, 1: rekomendasi',
            ],
        ]);

        $this->forge->addPrimaryKey('id_kebaya');
        $this->forge->addForeignKey('id_kategori', 'kategori', 'id_kategori', '', 'CASCADE');
        $this->forge->createTable('kebaya');
    }

    public function down()
    {
        $this->forge->dropTable('kebaya');
    }
}