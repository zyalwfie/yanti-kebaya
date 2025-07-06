<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSewaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sewa' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_sewa' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'unique'     => true,
            ],
            'id_pengguna' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nama_penyewa' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'no_telepon_penyewa' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'surel_penyewa' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'alamat_pengiriman' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggal_sewa' => [
                'type' => 'DATE',
            ],
            'tanggal_kembali' => [
                'type' => 'DATE',
            ],
            'total_bayar' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'status_sewa' => [
                'type'       => 'ENUM',
                'constraint' => ['disewa', 'selesai'],
            ],
            'status_pembayaran' => [
                'type'       => 'ENUM',
                'constraint' => ['tertunda', 'berhasil', 'gagal'],
                'default'    => 'tertunda',
            ],
            'waktu_dibuat' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'waktu_diubah' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id_sewa');
        $this->forge->addForeignKey('id_pengguna', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('sewa');
    }

    public function down()
    {
        $this->forge->dropTable('sewa');
    }
}