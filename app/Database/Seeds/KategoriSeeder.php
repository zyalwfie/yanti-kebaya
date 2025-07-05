<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_kategori' => 1, 'nama_kategori' => 'Kebaya Pesta Mewah', 'deskripsi' => 'Cocok untuk acara formal, resepsi pernikahan dan malam kesenian'],
            ['id_kategori' => 2, 'nama_kategori' => 'Kebaya Modern Elegan', 'deskripsi' => 'Acara semi formal, pesta keluarga, pertunjukan seni'],
            ['id_kategori' => 3, 'nama_kategori' => 'Kebaya Kontemporer', 'deskripsi' => 'Acara malam, pesta kecil, jamuan resmi'],
            ['id_kategori' => 4, 'nama_kategori' => 'Kebaya Tradisional Mewah', 'deskripsi' => 'Upacara adat, pernikahan tradisional, acara resmi kebudayaan'],
            ['id_kategori' => 5, 'nama_kategori' => 'Kebaya Modern Glamor', 'deskripsi' => 'Acara malam bergengsi, pertunjukan seni, pesta mewah'],
            ['id_kategori' => 6, 'nama_kategori' => 'Kebaya Casual Elegan', 'deskripsi' => 'Acara santai formal, pesta keluarga, pertemuan resmi'],
            ['id_kategori' => 7, 'nama_kategori' => 'Kebaya Romantis', 'deskripsi' => 'Acara pernikahan, pertunangan, pesta malam'],
        ];

        $this->db->table('kategori')->insertBatch($data);
    }
}
