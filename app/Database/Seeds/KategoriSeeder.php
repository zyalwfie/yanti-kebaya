<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_kategori' => 1, 'nama_kategori' => 'Kebaya Kutu Baru', 'deskripsi' => 'Kebaya klasik Jawa dengan ciri khas bef atau kain di bagian tengah yang menghubungkan sisi kiri dan kanan.'],
            ['id_kategori' => 2, 'nama_kategori' => 'Kebaya Kartini', 'deskripsi' => 'Model kebaya klasik dengan ciri khas kerah V dan panjang hingga menutupi panggul, terinspirasi dari gaya R.A. Kartini.'],
            ['id_kategori' => 3, 'nama_kategori' => 'Kebaya Bali', 'deskripsi' => 'Kebaya khas Bali dengan ciri penggunaan selendang atau obi yang diikat di pinggang, seringkali menggunakan bahan brokat atau katun.'],
            ['id_kategori' => 4, 'nama_kategori' => 'Kebaya Encim', 'deskripsi' => 'Kebaya hasil akulturasi budaya Betawi dan Tionghoa, biasanya dibuat dari bahan katun halus dengan bordiran khas di bagian depan dan pergelangan tangan.'],
            ['id_kategori' => 5, 'nama_kategori' => 'Kebaya Modern', 'deskripsi' => 'Kebaya dengan desain kontemporer, seringkali dimodifikasi pada bagian potongan, bahan, dan detail untuk tampilan yang lebih modern dan praktis.'],
            ['id_kategori' => 6, 'nama_kategori' => 'Kebaya Pengantin', 'deskripsi' => 'Kebaya yang dirancang khusus untuk acara pernikahan, biasanya lebih mewah, detail, dan seringkali berwarna putih atau warna-warna cerah.'],
            ['id_kategori' => 7, 'nama_kategori' => 'Kebaya Wisuda', 'deskripsi' => 'Kebaya yang didesain untuk acara kelulusan, menyeimbangkan antara tampilan formal, anggun, dan tetap nyaman dipakai seharian.'],
            ['id_kategori' => 8, 'nama_kategori' => 'Kebaya Brokat', 'deskripsi' => 'Kategori kebaya yang menonjolkan penggunaan bahan brokat (brocade) sebagai material utamanya, memberikan kesan mewah dan elegan.'],
            ['id_kategori' => 9, 'nama_kategori' => 'Kebaya Jumputan', 'deskripsi' => 'Kebaya yang dibuat dari kain jumputan (tie-dye) khas Palembang atau daerah lain, menawarkan corak yang unik dan etnik.'],
            ['id_kategori' => 10, 'nama_kategori' => 'Kebaya Songket', 'deskripsi' => 'Kebaya yang dipadukan dengan kain songket, baik sebagai bawahan maupun sebagai aksen pada kebaya itu sendiri, memberikan nuansa kemewahan tradisional.'],
        ];

        $this->db->table('kategori')->insertBatch($data);
    }
}
