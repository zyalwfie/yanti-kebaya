<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\KebayaModel;
use App\Models\KeranjangModel;

class LandingController extends BaseController
{
    protected $db, $kategoriModel, $kebayaModel, $keranjangModel, $cartsTotalAmount;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->kategoriModel = new KategoriModel();
        $this->kebayaModel = new KebayaModel();
        $this->keranjangModel = new KeranjangModel();
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
        return redirect()->route('landing.cart.index');
    }
}
