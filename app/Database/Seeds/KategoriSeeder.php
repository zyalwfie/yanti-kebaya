<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_kategori' => 'Kebaya Pengantin',
                'deskripsi'     => 'Koleksi kebaya mewah untuk pernikahan dengan berbagai model modern dan tradisional',
            ],
            [
                'nama_kategori' => 'Kebaya Wisuda',
                'deskripsi'     => 'Kebaya elegan khusus untuk acara wisuda dengan warna-warna cerah dan motif minimalis',
            ],
            [
                'nama_kategori' => 'Kebaya Pesta',
                'deskripsi'     => 'Kebaya untuk acara formal seperti resepsi, gala dinner, atau acara kenegaraan',
            ],
            [
                'nama_kategori' => 'Kebaya Tradisional',
                'deskripsi'     => 'Kebaya dengan desain klasik dan motif tradisional berbagai daerah di Indonesia',
            ],
            [
                'nama_kategori' => 'Kebaya Modern',
                'deskripsi'     => 'Kebaya dengan desain kontemporer dan inovatif untuk penampilan kekinian',
            ],
            [
                'nama_kategori' => 'Kebaya Resepsi',
                'deskripsi'     => 'Kebaya khusus untuk acara resepsi pernikahan dengan desain yang nyaman dipakai',
            ],
            [
                'nama_kategori' => 'Kebaya Tunangan',
                'deskripsi'     => 'Kebaya semi formal untuk acara tunangan atau pertunangan',
            ],
            [
                'nama_kategori' => 'Kebaya Kantor',
                'deskripsi'     => 'Kebaya sederhana dan praktis untuk keperluan kerja formal',
            ],
            [
                'nama_kategori' => 'Kebaya Batik',
                'deskripsi'     => 'Kebaya dengan kombinasi kain batik khas berbagai daerah',
            ],
            [
                'nama_kategori' => 'Kebaya Akad',
                'deskripsi'     => 'Kebaya khusus untuk acara akad nikah dengan desain syar\'i dan elegan',
            ]
        ];

        $this->db->table('kategori')->insertBatch($data);
    }
}
