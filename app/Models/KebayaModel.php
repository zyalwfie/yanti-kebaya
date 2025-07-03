<?php

namespace App\Models;

use CodeIgniter\Model;

class KebayaModel extends Model
{
    protected $table            = 'kebaya';
    protected $primaryKey       = 'id_kebaya';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_kategori',
        'nama_kebaya',
        'slug',
        'deskripsi',
        'ukuran_tersedia',
        'harga_sewa',
        'stok',
        'foto',
        'status',
        'rekomendasi'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_kebaya' => 'permit_empty',
        'id_kategori' => 'required',
        'slug' => 'required',
        'nama_kebaya' => 'required|is_unique[kebaya.nama_kebaya,slug,{slug}]',
        'deskripsi' => 'required',
        'ukuran_tersedia' => 'required',
        'harga_sewa' => 'required',
        'stok' => 'required',
        'status' => 'required',
    ];
    protected $validationMessages   = [
        'id_kategori' => [
            'required' => 'Kategori harus dipilih!',
        ],
        'nama_kebaya' => [
            'required' => 'Nama kebaya harus diisi!',
            'is_unique' => 'Nama kebaya sudah digunakan!'
        ],
        'deskripsi' => [
            'required' => 'deskripsi harus diisi!',
        ],
        'ukuran_tersedia' => [
            'required' => 'Ukuran harus dipilih!',
        ],
        'harga_sewa' => [
            'required' => 'Harga harus ditentukan!',
        ],
        'stok' => [
            'required' => 'Stok harus diisi!',
        ],
        'status' => [
            'required' => 'Status harus diisi!',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
