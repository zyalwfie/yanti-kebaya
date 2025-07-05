<?= $this->extend('layouts/auth/app'); ?>

<?= $this->section('page_title'); ?>
Yanti Kebaya | Halaman Daftar
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
            <?= form_open(url_to('register')) ?>
            <?= csrf_field() ?>
            <div class="form-group mb-3">
                <label class="form-label" for="email">Surel</label>
                <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                    name="email" aria-describedby="emailHelp" placeholder="Tulis surelmu di sini" value="<?= old('email') ?>">
                <small id="emailHelp" class="form-text text-muted">Kami tidak akan pernah membagikan surel Anda dengan orang lain.</small>
            </div>

            <div class="form-group mb-3">
                <label class="form-label" for="username">Nama Pengguna</label>
                <input type="text" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="Nama pengguna" value="<?= old('username') ?>">
            </div>

            <div class="form-group mb-3">
                <label class="form-label" for="password">Sandi</label>
                <div class="position-relative">
                    <input type="password" name="password" id="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="Tulis sandimu di sini" autocomplete="off">
                    <button type="button" class="btn btn-link position-absolute fs-5" tabindex="-1" id="togglePassword" style="z-index:2; top:50%; transform: translateY(-50%); right: .25rem">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="form-label" for="pass_confirm">Konfirmasi Sandi</label>
                <div class="position-relative">
                    <input type="password" name="pass_confirm" id="confirmPassword" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="Tulis ulang sandimu" autocomplete="off">
                    <button type="button" class="btn btn-link position-absolute fs-5" tabindex="-1" id="toggleConfirmPassword" style="z-index:2; top:50%; transform: translateY(-50%); right: .25rem">
                        <i class="bi bi-eye" id="eyeIconConfirm"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Daftar</button>

            <div class="d-flex align-items-center justify-content-center">
                <p class="fs-4 mb-0 fw-bold">Sudah punya akun?</p>
                <a class="text-primary fw-bold ms-2" href="<?= url_to('login') ?>">Masuk</a>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('foot_js'); ?>
<script>
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eyeIcon');
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        eyeIcon.classList.toggle('bi-eye');
        eyeIcon.classList.toggle('bi-eye-slash');
    });

    const confirmPasswordInput = document.getElementById('confirmPassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const eyeIconConfirm = document.getElementById('eyeIcon');
    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);
        eyeIconConfirm.classList.toggle('bi-eye');
        eyeIconConfirm.classList.toggle('bi-eye-slash');
    });
</script>
<?= $this->endSection(); ?>