<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePembayaranTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pembayaran' => [
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
            'bukti_pembayaran' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
            ],
            'waktu_dibuat' => [
                'type' => 'datetime',
                'null' => true
            ],
            'waktu_diubah' => [
                'type' => 'datetime',
                'null' => true
            ],
        ]);
        $this->forge->addPrimaryKey('id_pembayaran');
        $this->forge->addForeignKey('id_sewa', 'sewa', 'id_sewa', '', 'cascade');
        $this->forge->createTable('pembayaran');
    }

    public function down()
    {
        $this->forge->dropTable('pembayaran');
    }
}
