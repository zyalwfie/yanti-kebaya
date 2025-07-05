<?= $this->extend('layouts/dashboard/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(route_to('user.orders.index')) ?>">Pesanan</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url(route_to('user.orders.show', $order['id_sewa'])) ?>" class="text-secondary">Detail</a></li>
    </ol>
</nav>
<div>
    <h1 class="h3 mb-2 text-gray-800">Detail Pesanan</h1>
    <p class="lead"><?= $order['kode_sewa'] ?></p>
</div>
<p class="mb-4">Dapatkan informasi lengkap mengenai pesanan dan kelola pesanan atas nama <span class="fw-semibold text-capitalize"><?= $order['nama_penyewa'] ?></span></p>

<div class="row">
    <div class="col">
        <h2 class="h3 mb-3 text-black">Rincian Pengiriman</h2>
        <div class="p-3 p-lg-5 border bg-white">

            <div class="form-group mb-3 row">
                <div class="col">
                    <label for="nama_penyewa" class="text-black">Nama Penerima</label>
                    <input type="text" class="form-control" id="nama_penyewa" name="nama_penyewa" value="<?= $order['nama_penyewa'] ?>" disabled>
                </div>
                <div class="col">
                    <label for="surel_penyewa" class="text-black">Email</label>
                    <input type="text" class="form-control" id="surel_penyewa" name="surel_penyewa" value="<?= $order['surel_penyewa'] ?>" disabled>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="alamat_pengiriman" class="text-black">Alamat Penerima</label>
                <input type="text" class="form-control" id="alamat_pengiriman" name="alamat_pengiriman" value="<?= $order['alamat_pengiriman'] ?>" disabled>
            </div>

            <div class="form-group mb-3">
                <label for="no_telepon_penyewa" class="text-black">Nomor Telepon</label>
                <input type="text" class="form-control" id="no_telepon_penyewa" name="no_telepon_penyewa" aria-describedby="phoneHelp" value="<?= $order['no_telepon_penyewa'] ?>" disabled>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 form-group mb-3">
                    <label for="rent_date" class="text-black">Tanggal Sewa</label>
                    <input type="date" class="form-control" id="rent_date" value="<?= $order['tanggal_sewa'] ?>" disabled>
                </div>
                <div class="col-12 col-md-6 form-group mb-3 ">
                    <label for="return_date" class="text-black">Tanggal Pengembalian</label>
                    <input type="date" class="form-control" id="return_date" value="<?= $order['tanggal_kembali'] ?>" disabled>
                </div>
            </div>

            <div class="form-group">
                <label for="catatan" class="text-black">Catatan</label>
                <textarea name="catatan" id="catatan" cols="30" rows="5" name="catatan" class="form-control" disabled><?= $order['catatan'] ?></textarea>
            </div>

        </div>
    </div>

    <div class="col">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col">
                        <h2 class="h3 mb-3 text-black">Pesananmu</h2>
                    </div>
                    <div class="col text-end">
                        <span class="badge <?php if ($order['status_pembayaran'] === 'tertunda') : ?>text-bg-warning <?php elseif ($order['status_pembayaran'] === 'berhasil') : ?>text-bg-success <?php else: ?>text-bg-danger<?php endif; ?> text-capitalize">
                            <?= $order['status_pembayaran'] ?>
                        </span>
                    </div>
                </div>
                <div class="p-3 p-lg-5 border bg-white">
                    <p class="lead fs-6">
                        <?php
                        $createdAt = new DateTime($order['waktu_dibuat']);

                        $timezone = new DateTimeZone('Asia/Jakarta');
                        $createdAt->setTimezone($timezone);

                        $offset = $timezone->getOffset($createdAt);

                        if ($offset == 7 * 3600) {
                            $timezoneLabel = 'WIB';
                        } elseif ($offset == 9 * 3600) {
                            $timezoneLabel = 'WIT';
                        } else {
                            $timezoneLabel = 'WITA';
                        }

                        $formattedDate = $createdAt->format('d F Y, H:i') . ' ' . $timezoneLabel;
                        ?>
                        <?= $formattedDate ?>
                    </p>
                    <table class="table site-block-order-table mb-5">
                        <thead>
                            <th>Produk</th>
                            <th>Hari</th>
                            <th>Total</th>
                        </thead>
                        <tbody>
                            <?php foreach ($order_items as $orderItem) : ?>
                                <tr>
                                    <td><?= $orderItem->nama_kebaya ?> <strong class="mx-2">x</strong> <?= $orderItem->kuantitas ?></td>
                                    <td></td>
                                    <td>Rp<?= number_format($orderItem->harga_sewa, '0', '.', ',') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-black font-weight-bold"><strong>Total Pesanan</strong></td>
                                <td id="dayShow"></td>
                                <td class="text-black font-weight-bold"><strong>Rp<?= number_format($order['total_bayar'], '0', '.', ',') ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row align-items-center justify-content-between">
                    <div class="col">
                        <h2 class="h3 mb-3 text-black">Bukti Pembayaran</h2>
                    </div>
                    <div class="col">
                        <?php if (session()->has('proofed')) : ?>
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <?= session('proofed') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="p-3 p-lg-5 border bg-white">
                    <div class="row">
                        <?php if ($proof_of_payment->bukti_pembayaran) : ?>
                            <div class="col">
                                <img id="paymentProofImg" src="<?= base_url('img/product/proof/') . $proof_of_payment->bukti_pembayaran ?>" alt="Bukti Pembayaran" style="width: 100%; height: auto; object-fit: cover; cursor: pointer;">
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <p>Gambar di samping adalah bukti pembayaran yang telah diunggah</p>
                                </div>
                                <?= form_open_multipart(route_to('landing.cart.payment.update')) ?>
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label for="bukti_pembayaran" class="form-label">File Bukti Pembayaran <span class="text-danger">*</span></label>
                                    <input class="form-control <?= session('errors.bukti_pembayaran') ? 'is-invalid' : '' ?>" type="file" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*,application/pdf" onchange="previewProof(event)">
                                    <?php if (session('errors.bukti_pembayaran')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.bukti_pembayaran') ?>
                                        </div>
                                    <?php endif; ?>
                                    <input type="hidden" name="id_sewa" value="<?= $order['id_sewa'] ?>">
                                </div>
                                <div class="mb-3" id="previewContainer"></div>
                                <button type="submit" class="btn btn-primary">Perbarui Bukti</button>
                                <?= form_close() ?>
                            <?php else : ?>
                                <?= form_open_multipart(route_to('landing.cart.payment.upload')) ?>
                                <?= csrf_field() ?>
                                <div id="previewContainer" class="mb-3">
                                    <div class="alert alert-warning d-flex align-items-center gap-2" role="alert">
                                        <i class="bi bi-exclamation-octagon"></i>
                                        <div>
                                            Belum ada bukti pembayaran!
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <?php if (!$proof_of_payment->bukti_pembayaran) : ?>
                                        <input type="hidden" name="uri_string" value="<?= uri_string() ?>">
                                    <?php endif; ?>
                                    <label for="bukti_pembayaran" class="form-label">File Bukti Pembayaran <span class="text-danger">*</span></label>
                                    <input class="form-control <?= session('errors.bukti_pembayaran') ? 'is-invalid' : '' ?>" type="file" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*,application/pdf" onchange="previewProof(event)">
                                    <?php if (session('errors.bukti_pembayaran')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.bukti_pembayaran') ?>
                                        </div>
                                    <?php endif; ?>
                                    <input type="hidden" name="id_sewa" value="<?= $order['id_sewa'] ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Unggah Bukti</button>
                                <?= form_close() ?>
                            <?php endif; ?>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('foot_js'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const img = document.getElementById('paymentProofImg');
        const previewImg = document.getElementById('previewContainer');
        let viewer;
        if (img) {
            viewer = new Viewer(img, {
                toolbar: true,
                navbar: false,
                title: false,
                movable: true,
                zoomable: true,
                scalable: true,
                transition: true,
                fullscreen: true,
            });
            img.addEventListener('click', function() {
                viewer.show();
            });
        }
        if (previewImg) {
            const observer = new MutationObserver(function(mutationsList) {
                for (const mutation of mutationsList) {
                    if (mutation.type === 'childList') {
                        const imgEl = previewImg.querySelector('img');
                        if (imgEl) {
                            if (viewer) viewer.destroy();
                            viewer = new Viewer(imgEl, {
                                toolbar: true,
                                navbar: false,
                                title: false,
                                movable: true,
                                zoomable: true,
                                scalable: true,
                                transition: true,
                                fullscreen: true,
                            });
                        }
                    }
                }
            });
            observer.observe(previewImg, {
                childList: true
            });
        }
    });

    function previewProof(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('previewContainer');
        previewContainer.innerHTML = '';
        if (!file) return;
        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.maxWidth = '100%';
            img.style.maxHeight = '300px';
            img.className = 'img-fluid border rounded';
            previewContainer.appendChild(img);
        } else {
            previewContainer.innerHTML = '<span class="text-danger">File tidak didukung.</span>';
        }
    }

    const dayShow = document.querySelector('#dayShow');
    const rentDate = document.querySelector('#rent_date');
    const returnDate = document.querySelector('#return_date');
    const start = new Date(rentDate.value);
    const end = new Date(returnDate.value);
    const diffTime = end - start;
    let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    dayShow.textContent = diffDays;
</script>
<?= $this->endSection(); ?>