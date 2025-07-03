<?= $this->extend('layouts/dashboard/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center justify-content-between">
                    <?php
                    $category = $_GET['category'] ?? '';
                    $tanggalSewa = $_GET['tanggal_sewa'] ?? '';
                    $tanggalKembali = $_GET['tanggal_kembali'] ?? '';
                    $filteredOrder = $orders;
                    if ($category) {
                        $filteredOrder = array_filter($orders, function ($order) use ($category) {
                            return stripos($order['status_pembayaran'], $category) !== false;
                        });
                    }
                    if ($tanggalSewa) {
                        $filteredOrder = array_filter($filteredOrder, function ($order) use ($tanggalSewa) {
                            return isset($order['tanggal_sewa']) && strpos($order['tanggal_sewa'], $tanggalSewa) === 0;
                        });
                    }
                    if ($tanggalKembali) {
                        $filteredOrder = array_filter($filteredOrder, function ($order) use ($tanggalKembali) {
                            return isset($order['tanggal_kembali']) && strpos($order['tanggal_kembali'], $tanggalKembali) === 0;
                        });
                    }
                    ?>
                    <div>
                        <h4 class="card-title">Daftar Pesanan</h4>
                        <p class="card-subtitle">
                            Semua pesanan yang telah pengguna buat
                        </p>
                    </div>
                    <div class="d-flex gap-3 align-items-center">
                        <form method="get" class="d-flex align-items-end justify-content-end gap-3" id="formEl">
                            <div>
                                <label for="tanggal_sewa" class="form-label">Tanggal sewa</label>
                                <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" value="<?= esc($tanggalSewa) ?>">
                            </div>
                            <div>
                                <label for="tanggal_kembali" class="form-label">Tanggal kembali</label>
                                <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" value="<?= esc($tanggalKembali) ?>">
                            </div>
                            <div>
                                <label for="selectEl" class="form-label">Status</label>
                                <select class="form-select" name="category" id="selectEl" aria-label="Status select">
                                    <option selected value="">Pilih status</option>
                                    <option value="berhasil" <?= $category === 'berhasil' ? 'selected' : '' ?>>Berhasil</option>
                                    <option value="tertunda" <?= $category === 'tertunda' ? 'selected' : '' ?>>Tertunda</option>
                                    <option value="gagal" <?= $category === 'gagal' ? 'selected' : '' ?>>Gagal</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Urutkan</button>
                        </form>
                    </div>
                </div>
                <?php
                $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
                $perPage = 5;
                $total = count($filteredOrder);
                $totalPages = (int) ceil($total / $perPage);
                $start = ($page - 1) * $perPage;
                $paginatedOrders = array_slice($filteredOrder, $start, $perPage);
                ?>
                <div class="table-responsive mt-4">
                    <table class="table mb-4 text-nowrap varient-table align-middle fs-3">
                        <thead>
                            <tr>
                                <th scope="col" class="px-0 text-muted">
                                    Nama Penyewa
                                </th>
                                <th scope="col" class="px-0 text-muted">
                                    Total Harga
                                </th>
                                <th scope="col" class="px-0 text-muted">
                                    Status
                                </th>
                                <th scope="col" class="px-0 text-muted text-end">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$paginatedOrders) : ?>
                                <tr>
                                    <th colspan="4" class="text-center">
                                        Pesanan tidak ditemukan. <a href="<?= route_to('admin.orders.index') ?>" class="text-secondary">Kembali</a>
                                    </th>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($paginatedOrders as $order) : ?>
                                    <tr>
                                        <td class="px-0">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h6 class="mb-0 fw-bolder"><?= $order['nama_penyewa'] ?></h6>
                                                    <span class="text-muted"><?= $order['surel_penyewa'] ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-0">Rp<?= number_format($order['total_bayar'], '0', '.', ',') ?></td>
                                        <td class="px-0">
                                            <span class="badge <?php if ($order['status_pembayaran'] === 'tertunda') : ?>text-bg-warning <?php elseif ($order['status_pembayaran'] === 'berhasil') : ?>text-bg-success <?php else: ?>text-bg-danger<?php endif; ?> text-capitalize"><?= $order['status_pembayaran'] ?></span>
                                        </td>
                                        <td class="px-0 text-dark fw-medium text-end">
                                            <a href="<?= route_to('admin.orders.show', $order['id_sewa']) ?>" class="text-info">Lihat</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </tbody>
                    </table>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item<?= $page <= 1 ? ' disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page - 1 ?>"><i class="ti ti-chevron-left"></i></a>
                            </li>
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item<?= $i == $page ? ' active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item<?= $page >= $totalPages ? ' disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page + 1 ?>"><i class="ti ti-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('foot_js'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#formEl');
        const categorySelect = form.querySelector('#selectEl');
        if (categorySelect) {
            categorySelect.addEventListener('change', function() {
                form.submit();
            });
        }
    });
</script>
<?= $this->endSection(); ?>