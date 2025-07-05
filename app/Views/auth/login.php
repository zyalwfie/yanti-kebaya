<?= $this->extend('layouts/auth/app'); ?>

<?= $this->section('page_title'); ?>
Yanti Kebaya | Halaman Masuk
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="col-md-8 col-lg-4">
    <div class="card mb-0">
        <div class="card-body">
            <a href="<?= base_url() ?>" class="text-nowrap logo-img text-center d-block py-3 w-100 mb-3 d-flex align-items-center justify-content-center">
                <img src="<?= base_url('img/logo.png') ?>" alt="Yanti Kebaya Logo" width="100">
                <h1 class="h2">Yanti Kebaya</h1>
            </a>
            <?= view('Myth\Auth\Views\_message_block') ?>
            <?= form_open(url_to('login')) ?>
            <?= csrf_field() ?>
            <?php if ($config->validFields === ['email']): ?>
                <div class="form-group mb-3">
                    <label for="login" class="form-label">Surel</label>
                    <input type="email" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                        name="login" placeholder="Tulis surelmu">
                    <div class="invalid-feedback">
                        <?= session('errors.login') ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="form-group mb-3">
                    <label for="login" class="form-label">Identitas</label>
                    <input type="text" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                        name="login" placeholder="Tulis surel atau nama pengguna">
                    <div class="invalid-feedback">
                        <?= session('errors.login') ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-group mb-1">
                <label for="password" class="form-label">Sandi</label>
                <div class="position-relative">
                    <input type="password" id="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?> pe-5" placeholder="Tulis sandimu">
                    <button type="button" class="btn btn-link position-absolute fs-5" tabindex="-1" id="togglePassword" style="z-index:2; top:50%; transform: translateY(-50%); right: .25rem">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
                <div class="invalid-feedback">
                    <?= session('errors.password') ?>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <?php if ($config->allowRemembering): ?>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
                            Ingat saya
                        </label>
                    </div>
                <?php endif; ?>

                <?php if ($config->activeResetter): ?>
                    <a class="text-primary fw-bold" href="<?= url_to('forgot') ?>">Lupa sandi?</a>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-3 rounded-2">Masuk</button>

            <?php if ($config->allowRegistration) : ?>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Baru di sini?</p>
                    <a class="text-primary fw-bold ms-2" href="<?= url_to('register') ?>">Daftar segera</a>
                </div>
            <?php endif; ?>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('foot_js'); ?>
<script>
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    console.log(togglePassword);
    const eyeIcon = document.getElementById('eyeIcon');
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        eyeIcon.classList.toggle('bi-eye');
        eyeIcon.classList.toggle('bi-eye-slash');
    });
</script>
<?= $this->endSection(); ?>