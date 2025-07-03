<?php

namespace App\Models;

use CodeIgniter\Model;

class SewaModel extends Model
{
    protected $table            = 'sewa';
    protected $primaryKey       = 'id_sewa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kode_sewa',
        'id_pengguna',
        'nama_penyewa',
        'no_telepon_penyewa',
        'surel_penyewa',
        'alamat_pengiriman',
        'catatan',
        'tanggal_sewa',
        'tanggal_kembali',
        'total_bayar',
        'status_pembayaran',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'waktu_dibuat';
    protected $updatedField  = 'waktu_diubah';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'alamat_pengiriman' => 'required',
        'nama_penyewa' => 'required|max_length[255]',
        'surel_penyewa' => 'permit_empty|valid_email',
        'no_telepon_penyewa' => [
            'label' => 'Nomor Telepon',
            'rules' => 'required|regex_match[/^(\+62|62|0)8[1-9][0-9]{6,10}$/]'
        ],
        'tanggal_sewa' => 'required|valid_date',
        'tanggal_kembali' => 'required|valid_date'
    ];
    protected $validationMessages   = [
        'nama_penyewa' => [
            'required' => 'Nama penerima wajib diisi!',
            'max_length' => 'Karakter terlalu panjang!'
        ],
        'surel_penyewa' => [
            'valid_email' => 'Tolong masukkan email yang valid!'
        ],
        'alamat_pengiriman' => [
            'required' => 'Alamat wajib diisi!'
        ],
        'no_telepon_penyewa' => [
            'required' => 'Nomor telepon wajib diisi!',
            'regex_match' => 'Nomor telepon tidak valid!'
        ],
        'tanggal_sewa' => [
            'required' => 'Tanggal sewa wajib diisi!',
            'valid_date' => 'Tanggal sewa tidak valid!'
        ],
        'tanggal_kembali' => [
            'required' => 'Tanggal kembali wajib diisi!',
            'valid_date' => 'Tanggal kembali tidak valid!'
        ]
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
