<?= $this->extend('layouts/dashboard/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">
            <?= isset($product) ? 'Ubah Produk' : 'Tambah Produk Baru' ?>
        </h5>
        <div class="card">
            <div class="card-body">
                <?= form_open_multipart(isset($product) ? url_to('admin.products.update', $product['id_kebaya']) : url_to('admin.products.store')) ?>
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="nama_kebaya" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?= session('errors.nama_kebaya') ? 'is-invalid' : '' ?>"
                        id="nama_kebaya" name="nama_kebaya" value="<?= old('nama_kebaya', $product['nama_kebaya'] ?? '') ?>" autocomplete="on">
                    <?php if (session('errors.nama_kebaya')): ?>
                        <div class="invalid-feedback"><?= session('errors.nama_kebaya') ?></div>
                    <?php endif; ?>
                </div>

                <div class="row row-cols-1 g-3 row-cols-md-3 mb-3">
                    <div class="col">
                        <label for="harga_sewa" class="form-label">Harga Sewa<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text <?= session('errors.harga_sewa') ? 'is-invalid' : '' ?>" id="harga_sewa">Rp</span>
                            <input id="harga_sewa" type="number" class="form-control" aria-label="Harga Sewa" name="harga_sewa" value="<?= old('harga_sewa', $product['harga_sewa'] ?? '') ?>">
                            <?php if (session('errors.harga_sewa')): ?>
                                <div class="invalid-feedback"><?= session('errors.harga_sewa') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control <?= session('errors.stok') ? 'is-invalid' : '' ?>"
                            id="stok" name="stok" value="<?= old('stok', $product['stok'] ?? '') ?>">
                        <?php if (session('errors.stok')): ?>
                            <div class="invalid-feedback"><?= session('errors.stok') ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-select <?= session('errors.status') ? 'is-invalid' : '' ?>" aria-label="Select Category">
                            <option selected>Pilih status</option>
                            <?php if (isset($product)) : ?>
                                <option value="tersedia" <?= $product['status'] === 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                <option value="disewa" <?= $product['status'] === 'disewa' ? 'selected' : '' ?>>Disewa</option>
                                <option value="perbaikan" <?= $product['status'] === 'perbaikan' ? 'selected' : '' ?>>Perbaikan</option>
                            <?php else : ?>
                                <option value="tersedia">Tersedia</option>
                                <option value="disewa">Disewa</option>
                                <option value="perbaikan">Perbaikan</option>
                            <?php endif; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= session('errors.status') ?>
                        </div>
                    </div>
                </div>

                <div class="row row-cols-1 g-3 row-cols-md-3 mb-3">
                    <div class="col">
                        <label for="foto" class="form-label">Gambar</label>
                        <input class="form-control <?= session()->has('error_foto') ? 'is-invalid' : '' ?>" type="file" accept="image/png, image/jpeg, image/jpg" id="foto" name="foto" onchange="previewImage(event)">
                        <?php if (session()->has('error_foto')): ?>
                            <div class="invalid-feedback"><?= session('error_foto') ?></div>
                        <?php endif; ?>
                        <small class="text-muted">Maksimal ukuran 2MB (png, jpg, jpeg)</small>
                        <div class="mt-2" id="previewImg">
                            <?php if (isset($product['foto'])): ?>
                                <img src="<?= base_url() ?>img/product/uploads/<?= $product['foto'] ?>" alt="Gambar" style="height: 150px; width: 150px; object-fit: cover;" class="img-thumbnail">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col">
                        <label for="id_kategori" class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-select <?= session()->has('error_category') ? 'is-invalid' : '' ?>" aria-label="Select Category">
                            <option selected>Pilih kategori</option>
                            <?php foreach ($categories as $category) : ?>
                                <?php if (isset($product)) : ?>
                                    <option value="<?= $category['id_kategori'] ?>" <?= $category['id_kategori'] === $product['id_kategori'] ? 'selected' : '' ?>><?= $category['nama_kategori'] ?></option>
                                <?php endif; ?>
                                <option value="<?= $category['id_kategori'] ?>"><?= $category['nama_kategori'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= session('error_category') ?>
                        </div>
                    </div>
                    <div class="col">
                        <label for="ukuran_tersedia" class="form-label">Ukuran</label>
                        <select name="ukuran_tersedia" class="form-select <?= session('errors.ukuran_tersedia') ? 'is-invalid' : '' ?>" aria-label="Select Category">
                            <option selected>Pilih ukuran</option>
                            <?php if (isset($product)) : ?>
                                <option value="S" <?= $product['ukuran_tersedia'] === 'S' ? 'selected' : '' ?>>S</option>
                                <option value="M" <?= $product['ukuran_tersedia'] === 'M' ? 'selected' : '' ?>>M</option>
                                <option value="L" <?= $product['ukuran_tersedia'] === 'L' ? 'selected' : '' ?>>L</option>
                                <option value="XL" <?= $product['ukuran_tersedia'] === 'XL' ? 'selected' : '' ?>>XL</option>
                                <option value="All Size" <?= $product['ukuran_tersedia'] === 'All Size' ? 'selected' : '' ?>>Semua Ukuran</option>
                            <?php else : ?>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="All Size">Semua Ukuran</option>
                            <?php endif; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= session('errors.ukuran_tersedia') ?>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <?php if (isset($product)) : ?>
                            <input class="form-check-input" type="checkbox" value="1" id="rekomendasi" name="rekomendasi" <?= $product['rekomendasi'] === '1' ? 'checked' : '' ?>>
                        <?php else : ?>
                            <input class="form-check-input" type="checkbox" value="1" id="rekomendasi" name="rekomendasi">
                        <?php endif; ?>
                        <label class="form-check-label" for="rekomendasi">
                            Rekomendasi
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <div id="editor" style="height: 200px;"><?= old('deskripsi', $product['deskripsi'] ?? '') ?></div>
                    <input type="hidden" id="deskripsi" name="deskripsi">
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="<?= base_url(route_to('admin.products.index')) ?>" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary"><?= isset($product) ? 'Perbarui' : 'Tambah' ?></button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('foot_js'); ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{
                    'header': [1, 2, 3, 4, 5, 6, false]
                }],
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'align': []
                }],
                [{
                    'indent': '-1'
                }, {
                    'indent': '+1'
                }],
            ]
        },
        placeholder: 'Tulis deskripsi produk...',
    });

    function htmlToPlainText(html) {
        const div = document.createElement("div");
        div.innerHTML = html;
        return div.textContent || div.innerText || "";
    }

    const rawHtml = `<?= old('deskripsi', $product['deskripsi'] ?? '') ?>`;

    if (rawHtml) {
        const plain = htmlToPlainText(rawHtml);
        quill.setText(plain);
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        const descriptionInput = document.getElementById('deskripsi');
        descriptionInput.value = quill.root.innerHTML;
    });

    function previewImage(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('previewImg');
        previewContainer.innerHTML = '';
        if (!file) return;
        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.height = '150px';
            img.style.width = '150px';
            img.style.objectFit = 'cover';
            img.className = 'img-thumbnail';
            previewContainer.appendChild(img);
        } else {
            previewContainer.innerHTML = '<span class="text-danger">File tidak didukung.</span>';
        }
    }
</script>
<?= $this->endSection(); ?>