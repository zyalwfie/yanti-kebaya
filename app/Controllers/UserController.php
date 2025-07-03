<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SewaModel;
use Myth\Auth\Models\UserModel;

class UserController extends BaseController
{
    protected $sewaModel, $sewaBuilder, $userModel, $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->sewaBuilder = $this->db->table('sewa');
        $this->sewaModel = new SewaModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $this->sewaBuilder
            ->select('SUM(total_bayar) AS total_spent')
            ->where(['status_pembayaran' => 'berhasil', 'id_pengguna' => user()->id]);
        $query = $this->sewaBuilder->get();
        $totalEarning = $query->getRow();

        $completedOrdersCount = $this->sewaModel->where(['status_pembayaran' => 'berhasil', 'id_pengguna' => user()->id])->countAllResults();
        $pendingOrdersCount = $this->sewaModel->where(['status_pembayaran' => 'tertunda', 'id_pengguna' => user()->id])->countAllResults();
        $totalEarningAmount = $totalEarning->total_spent ? $totalEarning->total_spent : 0;

        $query = $this->sewaBuilder
            ->select('nama_penyewa, no_telepon_penyewa, avatar, status_pembayaran, total_bayar')
            ->join('users', 'sewa.id_pengguna = users.id')
            ->where('sewa.id_pengguna', user()->id)
            ->get(4);
        $orders = $query->getResult();

        $data = [
            'pageTitle' => 'Yanti Kebaya | Dasbor',
            'totalEarning' => $totalEarningAmount,
            'completedOrdersCount' => $completedOrdersCount,
            'pendingOrdersCount' => $pendingOrdersCount,
            'usersAmount' => $this->userModel->countAllResults(),
            'orders' => $orders
        ];

        return view('dashboard/user/index', $data);
    }

    public function orders()
    {
        $data = [
            'pageTitle' => 'Tektok Adventure | Data Pesanan',
            'orders' => $this->sewaModel->where('id_pengguna', user()->id)->findAll(),
        ];

        return view('dashboard/user/order/index', $data);
    }

    public function showOrder($orderId)
    {
        $this->sewaBuilder->select('kebaya_pesanan.id_kebaya_pesanan as idKebayaPesanan, kode_sewa, nama_kebaya, total_bayar, foto, harga_sewa, kuantitas');
        $this->sewaBuilder->join('kebaya_pesanan', 'sewa.id_sewa = kebaya_pesanan.id_sewa');
        $this->sewaBuilder->join('kebaya', 'kebaya_pesanan.id_kebaya = kebaya.id_kebaya');
        $this->sewaBuilder->where('sewa.id_pengguna', user()->id);
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

        return view('dashboard/user/order/show', $data);
    }

    public function profile()
    {
        $data = [
            'pageTitle' => "Dasbor | Pengguna | Profil"
        ];

        return view('dashboard/user/profile/index', $data);
    }

    public function editProfile()
    {
        $data = [
            'pageTitle' => "Dasbord | Pengguna | Edit Profil"
        ];

        return view('dashboard/user/profile/edit', $data);
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
            return redirect()->route('user.profile.index')->with('success', 'Profil berhasil diperbarui!');
        } else {
            return redirect()->route('user.profile.index')->with('failed', 'Profil gagal diperbarui!');
        }
    }
}
