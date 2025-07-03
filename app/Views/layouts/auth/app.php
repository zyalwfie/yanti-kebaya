<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url() ?>css/styles.min.css" />
    <meta name="description" content="Yanti Kebaya adalah penyedia jasa sewa kebaya modern dan tradisional berkualitas. Temukan koleksi kebaya pengantin, kebaya wisuda, kebaya pesta, serta aksesoris pelengkap dengan harga terjangkau." />
    <meta name="author" content="Yanti Kebaya" />
    <meta name="keywords" content="sewa kebaya, rental kebaya, kebaya pengantin, kebaya wisuda, kebaya pesta, kebaya tradisional, kebaya modern, aksesoris kebaya, sanggul kebaya, yanti kebaya" />
    <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <title><?= $this->renderSection('page_title'); ?></title>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <?= $this->renderSection('content'); ?>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url() ?>jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() ?>bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    <?= $this->renderSection('foot_js'); ?>
</body>

</html>