<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('KategoriSeeder');
        $this->call('KebayaSeeder');
    }
}
