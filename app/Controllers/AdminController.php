<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\KebayaModel;
use App\Models\SewaModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Myth\Auth\Models\UserModel;

class AdminController extends BaseController
{
    protected $userModel, $kebayaModel, $sewaModel, $kategoriModel, $kebayaBuilder, $sewaBuilder, $kebayaPesananBuilder, $userBuilder, $authGroupUserBuilder, $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->kebayaBuilder = $this->db->table('kebaya');
        $this->sewaBuilder = $this->db->table('sewa');
        $this->userBuilder = $this->db->table('users');
        $this->kebayaPesananBuilder = $this->db->table('kebaya_pesanan');
        $this->authGroupUserBuilder = $this->db->table('auth_groups_users');
        $this->userModel = new UserModel();
        $this->kebayaModel = new KebayaModel();
        $this->kategoriModel = new KategoriModel();
        $this->sewaModel = new SewaModel();
    }

    public function index()
    {
        $this->sewaBuilder
            ->select('SUM(total_bayar) AS total_spent')
            ->where('status_pembayaran', 'berhasil');
        $query = $this->sewaBuilder->get();
        $totalEarning = $query->getRow();

        $completedOrdersCount = $this->sewaModel->where('status_pembayaran', 'berhasil')->countAllResults();
        $pendingOrdersCount = $this->sewaModel->where('status_pembayaran', 'tertunda')->countAllResults();
        $totalEarningAmount = $totalEarning->total_spent ? $totalEarning->total_spent : 0;

        $query = $this->sewaBuilder
            ->select('nama_penyewa, no_telepon_penyewa, avatar, status_pembayaran, total_bayar')
            ->join('users', 'sewa.id_pengguna = users.id')
            ->get(4);
        $orders = $query->getResult();
        $userCount = $this->db->table('auth_groups_users')
            ->where('group_id', 2)
            ->countAllResults();

        $data = [
            'pageTitle' => 'Yanti Kebaya | Dasbor',
            'totalEarning' => $totalEarningAmount,
            'completedOrdersCount' => $completedOrdersCount,
            'pendingOrdersCount' => $pendingOrdersCount,
            'usersAmount' => $userCount,
            'orders' => $orders
        ];

        return view('dashboard/admin/index', $data);
    }

    // Profile Controller
    public function profile()
    {
        $data = [
            'pageTitle' => "Dasbor | Admin | Profil",
        ];

        return view('dashboard/admin/profile/index', $data);
    }

    public function editProfile()
    {
        $data = [
            'pageTitle' => 'Dasbor | Admin | Edit Profil'
        ];

        return view('dashboard/admin/profile/edit', $data);
    }

    public function updateProfile()
    {
        $userId = user()->id;
        $postData = $this->request->getPost();

        $postData['id'] = $userId;

        $rules = $this->userModel->validationRules;
        $rules['id'] = 'permit_empty';

        $rules['email'] = str_replace('{id}', $userId, $rules['email']);
        $rules['username'] = str_replace('{id}', $userId, $rules['username']);

        if (!$this->userModel->validate($postData)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        $result = $this->userModel->save($postData);

        if ($result) {
            return redirect()->route('admin.profile.index')->with('success', 'Profil berhasil diperbarui!');
        } else {
            return redirect()->route('admin.profile.index')->with('failed', 'Profil gagal diperbarui!');
        }
    }

    // Product Controller
    public function products()
    {
        $query = $this->kebayaBuilder
            ->select('kategori.id_kategori as idKategori, id_kebaya, nama_kategori, nama_kebaya, slug, kebaya.deskripsi as deskripsiKebaya, rekomendasi, foto, status, harga_sewa, stok')
            ->join('kategori', 'kebaya.id_kategori = kategori.id_kategori')
            ->orderBy('kebaya.nama_kebaya', 'ASC')
            ->get();

        $products = $query->getResultArray();

        $data = [
            'pageTitle' => 'Yanti Kebaya | Kelola Produk',
            'products' => $products
        ];

        return view('dashboard/admin/product/index', $data);
    }

    public function createProduct()
    {
        $data = [
            'pageTitle' => 'Yanti Kebaya | Tambah Kebaya Baru',
            'categories' => $this->kategoriModel->findAll(),
        ];

        return view('dashboard/admin/product/form', $data);
    }

    public function storeProduct()
    {
        $postData = $this->request->getPost();
        $postData['slug'] = url_title($postData['nama_kebaya'], '-', true);

        $categoryExists = $this->kategoriModel->find($postData['id_kategori'] ?? null);
        if (!$categoryExists) {
            return redirect()->back()->withInput()->with('error_category', 'Kategori harus diisi!');
        }

        $imageFile = $this->request->getFile('foto');

        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
        if ($imageFile->isValid() && !in_array($imageFile->getExtension(), $allowedExt)) {
            return redirect()->back()->withInput()->with('error_image', 'Format gambar tidak valid!');
        }

        if ($imageFile->isValid() && $imageFile->getSize() > 2097152) {
            return redirect()->back()->withInput()->with('error_image', 'Ukuran gambar terlalu besar! Maksimal 2MB.');
        }

        if (!$this->validateData($postData, $this->kebayaModel->getValidationRules(), $this->kebayaModel->validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($imageFile->isValid() && !$imageFile->hasMoved()) {
            $newName = $imageFile->getRandomName();
            $imageFile->move(FCPATH . 'img/product/uploads/', $newName);

            $postData['image'] = $newName;
        }

        $result = $this->kebayaModel->save($postData);

        if ($result) {
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
        } else {
            return redirect()->route('admin.products.index')->with('failed', 'Produk gagal ditambahkan!');
        }
    }

    public function editProduct($slug)
    {
        $data = [
            'pageTitle' => 'Yanti Kebaya | Ubah Kebaya',
            'product' => $this->kebayaModel->where('slug', $slug)->first(),
            'categories' => $this->kategoriModel->findAll()
        ];

        return view('dashboard/admin/product/form', $data);
    }

    public function updateProduct($id)
    {
        $product = $this->kebayaModel->find($id);

        $postData = $this->request->getPost();
        $postData['slug'] = $product['nama_kebaya'] !== $postData['nama_kebaya'] ? url_title($postData['nama_kebaya'], '-', true) : $product['slug'];

        $categoryExists = $this->kategoriModel->find($postData['id_kategori'] ?? null);
        if (!$categoryExists) {
            return redirect()->back()->withInput()->with('error_category', 'Kategori harus diisi!');
        }

        $imageFile = $this->request->getFile('foto');

        if ($imageFile && $imageFile->isValid() && $imageFile->getError() === 0) {
            $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($imageFile->getExtension(), $allowedExt)) {
                return redirect()->back()->withInput()->with('error_image', 'Format gambar tidak valid!');
            }
            if ($imageFile->getSize() > 2097152) {
                return redirect()->back()->withInput()->with('error_image', 'Ukuran gambar terlalu besar! Maksimal 2MB.');
            }
            if (!$imageFile->hasMoved()) {
                $newName = $imageFile->getRandomName();
                $imageFile->move(FCPATH . 'img/product/uploads/', $newName);

                if (!empty($product['foto']) && file_exists(FCPATH . $product['foto']) && $product['foto'] !== 'img/product/uploads/default-img-product.svg') {
                    @unlink(FCPATH . $product['foto']);
                }

                $postData['foto'] = $newName;
            }
        } else {
            $postData['foto'] = $product['foto'];
        }

        if (!$this->validateData($postData, $this->kebayaModel->getValidationRules(), $this->kebayaModel->validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $postData['id_kebaya'] = $id;
        $result = $this->kebayaModel->save($postData);

        if ($result) {
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
        } else {
            return redirect()->route('admin.products.index')->with('failed', 'Produk gagal diperbarui!');
        }
    }

    public function destroyProduct($slug)
    {
        $product = $this->kebayaModel->where('slug', $slug)->first();
        if (!$product) {
            return redirect()->route('admin.products.index')->with('failed', 'Produk tidak ditemukan!');
        }

        if (!empty($product['foto']) && file_exists(FCPATH . 'img/product/uploads/' . $product['foto']) && $product['foto'] !== 'img/product/uploads/default.png') {
            @unlink(FCPATH . 'img/product/uploads/' . $product['foto']);
        }

        $this->kebayaModel->delete($product['id_kebaya']);
        $query = $this->request->getServer('QUERY_STRING');
        $url = route_to('admin.products.index') . ($query ? '?' . $query : '');
        return redirect()->to($url)->with('success', 'Produk berhasil dihapus!');
    }

    public function users()
    {
        $this->userBuilder->select('users.id as userId, email, full_name, username, avatar, active');
        $this->userBuilder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->userBuilder->where('auth_groups_users.group_id', 2);
        $query = $this->userBuilder->get();
        $users = $query->getResultArray();

        $data = [
            'index' => 1,
            'pageTitle' => 'Dasbor | Admin | Pengguna',
            'users' => $users
        ];

        return view('dashboard/admin/user/index', $data);
    }

    public function destroyUser($username)
    {
        $queryAuthGroupsUsers = $this->authGroupUserBuilder->get();
        $authGroupsUsers = $queryAuthGroupsUsers->getResult();

        $authGroupsUserId = [];

        foreach ($authGroupsUsers as $row) {
            $authGroupsUserId[] = $row->user_id;
        }

        $user = $this->userBuilder->where('username', $username)->get()->getRow();
        $userId = $user->id;

        if (!$user && !in_array($userId, $authGroupsUserId)) {
            return redirect()->route('admin.users')->with('failed', 'Pengguna tidak ditemukan!');
        }

        if (!empty($user->avatar) && $user->avatar !== 'default-img-avatar.svg') {
            $avatarPath = FCPATH . 'img/uploads/avatar/' . $user->avatar;
            if (file_exists($avatarPath)) {
                @unlink($avatarPath);
            }
        }

        $this->userBuilder->where('username', $username)->delete();
        $query = $this->request->getServer('QUERY_STRING');
        $url = route_to('admin.users.index') . ($query ? '?' . $query : '');
        return redirect()->to($url)->with('success', 'Pengguna berhasil dihapus!');
    }
    
    // Order Controller
    public function orders()
    {
        $orders = $this->sewaModel->findAll();

        $data = [
            'pageTitle' => 'Yanti Kebaya | Admin | Pesanan',
            'orders' => $orders
        ];

        return view('dashboard/admin/order/index', $data);
    }

    public function showOrder($orderId)
    {
        $this->sewaBuilder->select('id_kebaya_pesanan, nama_kebaya, harga_sewa, foto, kuantitas');
        $this->sewaBuilder->join('kebaya_pesanan', 'sewa.id_sewa = kebaya_pesanan.id_sewa');
        $this->sewaBuilder->join('kebaya', 'kebaya_pesanan.id_kebaya = kebaya.id_kebaya');
        $this->sewaBuilder->where('kebaya_pesanan.id_sewa', $orderId);
        $query = $this->sewaBuilder->get();
        $orderItems = $query->getResult();

        $order = $this->sewaModel->where('id_sewa', $orderId)->first();

        $proofOfPayment = $this->sewaBuilder->select('bukti_pembayaran')
            ->join('pembayaran', 'sewa.id_sewa = pembayaran.id_sewa')
            ->where('pembayaran.id_sewa', $orderId)
            ->get()
            ->getRow();

        $data = [
            'pageTitle' => 'Yanti Kebaya | Detail Pesanan',
            'order_items' => $orderItems,
            'order' => $order,
            'proof_of_payment' => $proofOfPayment
        ];

        return view('dashboard/admin/order/show', $data);
    }

    public function updateOrder($orderId)
    {
        $query = $this->kebayaPesananBuilder
            ->select('kuantitas, kebaya.id_kebaya as idKebaya, stok')
            ->join('sewa', 'kebaya_pesanan.id_sewa = sewa.id_sewa')
            ->join('kebaya', 'kebaya_pesanan.id_kebaya = kebaya.id_kebaya')
            ->where('kebaya_pesanan.id_sewa', $orderId)
            ->get();

        $orders = $query->getResultArray();

        $status = $this->request->getPost('status');

        $this->sewaModel->update($orderId, [
            'status_pembayaran' => $status,
        ]);

        if ($status === 'berhasil') {
            foreach ($orders as $order) {
                $this->kebayaModel->update($order['idKebaya'], [
                    'stok' => $order['stok'] - $order['kuantitas']
                ]);
            }
            return redirect()->back()->with('proofed', 'Pesanan berhasil disetujui!');
        } else {
            return redirect()->back()->with('proofed', 'Pesanan berhasil dibatalkan!');
        }
    }

    // Report
    public function reports()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        $this->sewaBuilder->select('sewa.*, users.email as surelPenyewa')
            ->join('users', 'users.id = sewa.id_pengguna')
            ->where('sewa.status_pembayaran', 'berhasil');

        if ($startDate) {
            $this->sewaBuilder->where('sewa.waktu_dibuat >=', $startDate);
        }
        if ($endDate) {
            $this->sewaBuilder->where('sewa.waktu_dibuat <=', $endDate . ' 23:59:59');
        }

        $query = $this->sewaBuilder->get();
        $filteredOrders = $query->getResultArray();

        $totalSales = array_reduce($filteredOrders, function ($carry, $order) {
            return $carry + $order['total_bayar'];
        }, 0);

        $data = [
            'pageTitle' => 'Yanti Kebaya | Admin | Laporan Transaksi',
            'orders' => $this->sewaModel->findAll(),
            'filteredOrders' => $filteredOrders,
            'totalSales' => $totalSales,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        return view('dashboard/admin/report/index', $data);
    }

    public function previewReportPdf()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        $this->sewaBuilder->select('sewa.*, users.email as surelPenyewa')
            ->join('users', 'users.id = sewa.id_pengguna')
            ->where('sewa.status_pembayaran', 'berhasil');

        if ($startDate) {
            $this->sewaBuilder->where('sewa.waktu_dibuat >=', $startDate);
        }
        if ($endDate) {
            $this->sewaBuilder->where('sewa.waktu_dibuat <=', $endDate . ' 23:59:59');
        }

        $query = $this->sewaBuilder->get();
        $filteredOrders = $query->getResultArray();

        $totalSales = array_reduce($filteredOrders, function ($carry, $order) {
            return $carry + $order['total_bayar'];
        }, 0);

        $data = [
            'pageTitle' => 'Preview Laporan Penyewaan',
            'orders' => $filteredOrders,
            'totalSales' => $totalSales,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        return view('dashboard/admin/report/preview', $data);
    }

    public function exportReportPdf()
    {
        if (!class_exists('Dompdf\Dompdf')) {
            throw new \RuntimeException('Dompdf library is not installed. Please run: composer require dompdf/dompdf');
        }

        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        $this->sewaBuilder->select('sewa.*, users.email as surelPenyewa')
            ->join('users', 'users.id = sewa.id_pengguna')
            ->where('sewa.status_pembayaran', 'berhasil');

        if ($startDate) {
            $this->sewaBuilder->where('sewa.waktu_dibuat >=', $startDate);
        }
        if ($endDate) {
            $this->sewaBuilder->where('sewa.waktu_dibuat <=', $endDate . ' 23:59:59');
        }

        $query = $this->sewaBuilder->get();
        $filteredOrders = $query->getResultArray();

        $totalSales = array_reduce($filteredOrders, function ($carry, $order) {
            return $carry + $order['total_bayar'];
        }, 0);

        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $html = $this->generatePdfContent($filteredOrders, $totalSales, $startDate, $endDate);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $filename = 'Laporan_Penjualan_';
        if ($startDate && $endDate) {
            $filename .= date('d_m_Y', strtotime($startDate)) . '_to_' . date('d_m_Y', strtotime($endDate));
        } elseif ($startDate) {
            $filename .= 'dari_' . date('d_m_Y', strtotime($startDate));
        } elseif ($endDate) {
            $filename .= 'sampai_' . date('d_m_Y', strtotime($endDate));
        } else {
            $filename .= 'semua_periode';
        }
        $filename .= '.pdf';

        $dompdf->stream($filename, ["Attachment" => true]);
    }

    private function generatePdfContent($orders, $totalSales, $startDate = null, $endDate = null)
    {
        $html = '
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Laporan Penjualan</title>
            <style>
                body { 
                    font-family: Helvetica, Arial, sans-serif; 
                    font-size: 10pt;
                    margin: 0;
                    padding: 20px;
                }
                .report-header { 
                    text-align: center; 
                    margin-bottom: 20px;
                    border-bottom: 2px solid #000;
                    padding-bottom: 10px;
                }
                .report-header h1 { 
                    margin: 0; 
                    color: #333;
                    font-size: 24pt;
                }
                .report-header p { 
                    margin: 5px 0; 
                    color: #666;
                    font-size: 12pt;
                }
                .company-info {
                    text-align: center;
                    margin-bottom: 10px;
                }
                .company-info p {
                    margin: 2px 0;
                    font-size: 9pt;
                    color: #555;
                }
                .total-sales {
                    background-color: #f0f0f0;
                    padding: 15px;
                    text-align: center;
                    margin-bottom: 20px;
                    font-weight: bold;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                }
                .total-sales h3 {
                    margin: 0 0 5px 0;
                    color: #333;
                }
                .total-sales .amount {
                    font-size: 18pt;
                    color: #28a745;
                }
                table { 
                    width: 100%; 
                    border-collapse: collapse; 
                    margin-bottom: 20px; 
                }
                table th, table td { 
                    border: 1px solid #ddd; 
                    padding: 8px;
                    text-align: left;
                }
                th { 
                    background-color: #f8f8f8;
                    font-weight: bold;
                    color: #333;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                .text-center {
                    text-align: center;
                }
                .text-right {
                    text-align: right;
                }
                .footer {
                    font-size: 8pt;
                    text-align: center;
                    color: #666;
                    margin-top: 30px;
                    padding-top: 10px;
                    border-top: 1px solid #ddd;
                }
                .summary-info {
                    margin-bottom: 20px;
                    padding: 10px;
                    background-color: #f5f5f5;
                    border-radius: 5px;
                }
                .summary-info p {
                    margin: 5px 0;
                    font-size: 10pt;
                }
            </style>
        </head>
        <body>
            <div class="company-info">
                <p><strong>Yanti Kebaya</strong></p>
                <p>Desa Rumak, Lombok Barat, NTB 83370</p>
                <p>+62 823-3954-4560 | yantikebaya@business.com</p>
            </div>
            
            <div class="report-header">
                <h1>Laporan Penjualan</h1>';

        if ($startDate && $endDate) {
            $html .= "<p>Periode: " . date('d F Y', strtotime($startDate)) . " - " . date('d F Y', strtotime($endDate)) . "</p>";
        } elseif ($startDate) {
            $html .= "<p>Mulai dari: " . date('d F Y', strtotime($startDate)) . "</p>";
        } elseif ($endDate) {
            $html .= "<p>Sampai dengan: " . date('d F Y', strtotime($endDate)) . "</p>";
        } else {
            $html .= "<p>Semua Periode</p>";
        }

        $html .= '
            </div>
            
            <div class="total-sales">
                <h3>Total Penjualan</h3>
                <div class="amount">Rp ' . number_format($totalSales, 0, ',', '.') . '</div>
            </div>
            
            <div class="summary-info">
                <p><strong>Ringkasan Laporan:</strong></p>
                <p>Total Transaksi: ' . count($orders) . ' pesanan</p>
                <p>Status: Semua transaksi berhasil</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th width="25%">Nama Penerima</th>
                        <th width="25%">Email</th>
                        <th width="15%">No. Telepon</th>
                        <th class="text-right" width="15%">Total Harga</th>
                    </tr>
                </thead>
                <tbody>';

        if (empty($orders)) {
            $html .= '
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data penjualan yang ditemukan.</td>
                </tr>';
        } else {
            foreach ($orders as $index => $order) {
                $html .= "
                <tr>
                    <td class='text-center'>" . ($index + 1) . "</td>
                    <td>" . date('d/m/Y', strtotime($order['waktu_dibuat'])) . "</td>
                    <td>" . htmlspecialchars($order['nama_penyewa']) . "</td>
                    <td>" . htmlspecialchars($order['surel_penyewa']) . "</td>
                    <td>" . htmlspecialchars($order['no_telepon_penyewa'] ?? '-') . "</td>
                    <td class='text-right'>Rp " . number_format($order['total_bayar'], 0, ',', '.') . "</td>
                </tr>";
            }
        }

        $html .= '
                </tbody>
            </table>
            
            <div class="footer">
                <p>Laporan ini dicetak pada: ' . date('d F Y H:i:s') . '</p>
                <p>© ' . date('Y') . ' Yanti Kebaya - Laporan Penjualan</p>
            </div>
        </body>
        </html>';

        return $html;
    }
}
