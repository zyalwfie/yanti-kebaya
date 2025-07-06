<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\KebayaModel;
use App\Models\KebayaPesananModel;
use App\Models\KeranjangModel;
use App\Models\PembayaranModel;
use App\Models\SewaModel;

class LandingController extends BaseController
{
    protected $db, $kategoriModel, $kebayaModel, $keranjangModel, $sewaModel, $kebayaPesananModel, $pembayaranModel, $cartsTotalAmount;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->kategoriModel = new KategoriModel();
        $this->kebayaModel = new KebayaModel();
        $this->keranjangModel = new KeranjangModel();
        $this->sewaModel = new SewaModel();
        $this->kebayaPesananModel = new KebayaPesananModel();
        $this->pembayaranModel = new PembayaranModel();
    }
    
    public function index()
    {
        $products = $this->kebayaModel->where('rekomendasi', 1)->findAll(4);
        
        $data = [
            'pageTitle' => 'Yanti Kebaya',
            'products' => $products,
            'cartsTotalCount' => ((!logged_in()) ? 0 : $this->keranjangModel->where('id_pengguna', user()->id)->countAllResults())
        ];

        return view('landing/index', $data);
    }

    public function shop()
    {
        $data = [
            'pageTitle' => 'Yanti Kebaya | Sewa',
            'products' => $this->kebayaModel->findAll(),
            'categories' => $this->kategoriModel->findAll(),
            'cartsTotalCount' => ((!logged_in()) ? 0 : $this->keranjangModel->where('id_pengguna', user()->id)->countAllResults())
        ];

        return view('landing/shop/index', $data);
    }

    public function showShop($slug)
    {
        $product = $this->kebayaModel->where('slug', $slug)->first();
        $relatedProducts = $this->kebayaModel
            ->where('id_kategori', $product['id_kategori'])
            ->where('slug !=', $product['slug'])
            ->limit(4)
            ->find();

        $data = [
            'pageTitle' => 'Yanti Kebaya | ' . $product['nama_kebaya'],
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'cartsTotalCount' => ((!logged_in()) ? 0 : $this->keranjangModel->where('id_pengguna', user()->id)->countAllResults())
        ];

        return view('landing/shop/show', $data);
    }

    public function cart()
    {
        $cartsBuilder = $this->db->table('keranjang');
        $query = $cartsBuilder
            ->select('id_keranjang, nama_kategori, kebaya.id_kebaya as idKebaya, nama_kebaya, kebaya.deskripsi as deskripsi_kebaya, foto, slug, harga_sewa, harga_saat_ditambah, kuantitas, stok, status')
            ->join('kebaya', 'keranjang.id_kebaya = kebaya.id_kebaya')
            ->join('kategori', 'kebaya.id_kategori = kategori.id_kategori')
            ->get();
        $carts = $query->getResult();

        foreach ($carts as $cart) {
            $this->cartsTotalAmount += $cart->harga_saat_ditambah;
        }

        $data = [
            'pageTitle' => 'Yanti Kebaya | Keranjang',
            'carts' => $carts,
            'cartsTotalCount' => ((!logged_in()) ? 0 : $this->keranjangModel->where('id_pengguna', user()->id)->countAllResults()),
            'cartsTotalAmount' => $this->cartsTotalAmount
        ];

        return view('landing/cart', $data);
    }

    public function addToCart()
    {
        $quantity = $this->request->getPost('quantity') ?? 1;

        if (!preg_match('/^\d+$/', $quantity)) {
            return redirect()->back()->withInput()->with('wrong_type_of', 'Kuantitas yang kamu masukkan harus berupa angka!');
        }

        $productId = $this->request->getPost('product_id');
        $product = $this->kebayaModel->find($productId);
        $cart = $this->keranjangModel->where(['id_kebaya' => $productId, 'id_pengguna' => user()->id])->first();
        $currentCartQty = $cart ? (int)$cart['kuantitas'] : 0;
        $totalRequestedQty = $currentCartQty + $quantity;
        $priceAtAdd = $product['harga_sewa'];

        if ($product['stok'] < 1 || $totalRequestedQty > $product['stok']) {
            return redirect()->back()->withInput()->with('not_in_stock', 'Stok baju tidak mencukupi!');
        }

        if ($cart) {
            $newQuantity = $totalRequestedQty;
            $newPriceAtAdd = $priceAtAdd;
            $this->keranjangModel->update($cart['id_keranjang'], [
                'kuantitas' => $newQuantity,
                'harga_saat_ditambah' => $newPriceAtAdd
            ]);
        } else {
            $this->keranjangModel->save([
                'id_pengguna' => user()->id,
                'id_kebaya' => $productId,
                'kuantitas' => $totalRequestedQty,
                'harga_saat_ditambah' => $priceAtAdd
            ]);
        }

        return redirect()->route('landing.cart.index')->with('success', 'Kuantitas baju berhasil ditambahkan!');
    }

    public function increaseCartQuantity($cartId)
    {
        $cart = $this->keranjangModel->find($cartId);
        $currentCartQty = $cart['kuantitas'];
        if (!$cart || $cart['id_pengguna'] !== user()->id) {
            return redirect()->route('landing.cart.index');
        }

        $product = $this->kebayaModel->find($cart['id_kebaya']);
        if (!$product) {
            return redirect()->route('landing.cart.index');
        }

        if ($currentCartQty > $product['stok']) {
            return redirect()->back()->with('not_in_stock', 'Stok baju tidak mencukupi!');
        } else {
            $newQuantity = $cart['kuantitas'] + 1;
            $newPriceAtAdd = $product['harga_sewa'] * $newQuantity;
            $this->keranjangModel->update($cartId, [
                'kuantitas' => $newQuantity,
                'harga_saat_ditambah' => $newPriceAtAdd
            ]);
            return redirect()->back()->with('success', 'Kuantitas baju berhasil ditambahkan!');
        }
    }

    public function decreaseCartQuantity($cartId)
    {
        $cart = $this->keranjangModel->find($cartId);
        $currentCartQty = $cart['kuantitas'];
        if (!$cart || $cart['id_pengguna'] !== user()->id) {
            return redirect()->route('landing.cart.index');
        }

        if ($currentCartQty > 1) {
            $product = $this->kebayaModel->find($cart['id_kebaya']);
            $newQuantity = $currentCartQty - 1;
            $newPriceAtAdd = $product['harga_sewa'] * $newQuantity;
            $this->keranjangModel->update($cartId, [
                'kuantitas' => $newQuantity,
                'harga_saat_ditambah' => $newPriceAtAdd
            ]);
        }

        return redirect()->back()->with('success', 'Kuantitas baju berhasil dikurangi!');
    }

    public function destroyCart($cartId)
    {
        $cart = $this->keranjangModel->find($cartId);
        if ($cart && $cart['id_pengguna'] === user()->id) {
            $this->keranjangModel->delete($cartId);
        }
        return redirect()->route('landing.cart.index')->with('success', 'Baju dihapus dari keranjang!');
    }

    public function paymentCreate()
    {
        $carts = $this->keranjangModel->where('id_pengguna', user()->id)->findAll();
        $postData = $this->request->getPost();

        if (!$this->validateData($postData, $this->sewaModel->getValidationRules(), $this->sewaModel->validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        } elseif (!$carts) {
            return redirect()->back()->withInput()->with('empty_cart', 'Tidak ada apa-apa di dalam keranjang!');
        }

        $postData['id_pengguna'] = user()->id;
        $uniqCode = strtoupper(uniqid('#'));
        $postData['kode_sewa'] = $uniqCode;
        $this->sewaModel->save($postData);
        $order = $this->sewaModel->orderBy('waktu_dibuat', 'DESC')->first();

        if (isset($postData['product_id'], $postData['quantity'])) {
            foreach ($postData['product_id'] as $idx => $productId) {
                $quantity = isset($postData['quantity'][$idx]) ? $postData['quantity'][$idx] : 1;
                $this->kebayaPesananModel->save([
                    'id_sewa' => $order['id_sewa'],
                    'id_kebaya' => $productId,
                    'kuantitas' => $quantity
                ]);
            }
        }

        $this->keranjangModel->where('id_pengguna', user()->id)->delete();
        $orderId = [
            'id_sewa' => $order['id_sewa']
        ];
        $paymentResult = $this->pembayaranModel->save($orderId);

        if ($paymentResult) {
            return redirect()->route('landing.cart.payment.index', [$order['id_sewa']])->with('success', 'Pesanan telah dibuat!');
        } else {
            return redirect()->back()->with('failed', 'Pesanan gagal dibuat!');
        }
    }

    public function payment($orderId)
    {
        $order = $this->sewaModel->where('id_sewa', $orderId)->first();
        $payment = $this->pembayaranModel->where('id_sewa', $order['id_sewa'])->first();

        if (!$order) {
            return redirect()->back()->with('no_order', 'Pesanan belum dibuat');
        }

        if ($payment && $payment['bukti_pembayaran']) {
            return redirect()->route('landing.cart.payment.done');
        }

        $data = [
            'pageTitle' => 'Tektok Adventure | Pembayaran',
            'cartsTotalCount' => ((!logged_in()) ? 0 : $this->keranjangModel->where('id_pengguna', user()->id)->countAllResults()),
            'order_id' => $order['id_sewa']
        ];

        return view('landing/payment', $data);
    }

    public function paymentUpload()
    {
        $file = $this->request->getFile('bukti_pembayaran');
        $orderId = $this->request->getPost('id_sewa');
        $uriString = $this->request->getPost('uri_string');
        $errors = [];

        if ($file->isValid()) {
            $mimeType = $file->getMimeType();
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
            if (!in_array($mimeType, $allowedTypes)) {
                $errors['proof_of_payment'] = 'File harus berupa gambar (jpg, jpeg, png) atau PDF.';
            } elseif ($file->getSize() > 2097152) {
                $errors['proof_of_payment'] = 'Ukuran file maksimal 2MB.';
            }
        } else {
            $errors['proof_of_payment'] = 'Bukti pembayaran harus diunggah!';
        }

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $paymentData = $this->pembayaranModel->where('id_sewa', $orderId)->first();
        $newName = $file->getRandomName();
        $this->pembayaranModel->update($paymentData['id_pembayaran'], [
            'bukti_pembayaran' => $newName
        ]);
        
        if ($paymentData) {
            $file->move(FCPATH . 'img/product/proof/', $newName);
        }

        if ($uriString === 'dashboard/user/orders/show/' . $orderId) {
            return redirect()->back()->with('proofed', 'File bukti berhasil diunggah!');
        }

        return redirect()->route('landing.cart.payment.done');
    }

    public function paymentUpdate()
    {
        dd($this->request->getFile('proof_of_payment'));

        $file = $this->request->getFile('proof_of_payment');
        $orderId = $this->request->getPost('order_id');
        $errors = [];

        if ($file->isValid()) {
            $mimeType = $file->getMimeType();
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($mimeType, $allowedTypes)) {
                $errors['proof_of_payment'] = 'File harus berupa gambar (jpg, jpeg, png) atau PDF.';
            } elseif ($file->getSize() > 2097152) {
                $errors['proof_of_payment'] = 'Ukuran file maksimal 2MB.';
            }
        } else {
            $errors['proof_of_payment'] = 'Bukti pembayaran harus diunggah!';
        }

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $newName = $file->getRandomName();
        $file->move(FCPATH . 'img/product/proof', $newName);

        $payment = $this->pembayaranModel->where('order_id', $orderId)->first();
        if ($payment) {
            if (!empty($payment['proof_of_payment'])) {
                $oldPath = FCPATH . 'img/product/proof/' . $payment['proof_of_payment'];
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
            $this->pembayaranModel->update($payment['id'], [
                'proof_of_payment' => $newName
            ]);
        }

        return redirect()->back()->with('proofed', 'File bukti berhasil diperbarui!');
    }

    public function paymentDone()
    {
        $data = [
            'pageTitle' => 'Nuansa | Pembayaran',
            'cartsTotalCount' => ((!logged_in()) ? 0 : $this->keranjangModel->where('id_pengguna', user()->id)->countAllResults()),
        ];

        return view('landing/thanks', $data);
    }
}
