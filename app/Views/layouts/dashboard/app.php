<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Yanti Kebaya adalah penyedia jasa sewa kebaya modern dan tradisional berkualitas. Temukan koleksi kebaya pengantin, kebaya wisuda, kebaya pesta, serta aksesoris pelengkap dengan harga terjangkau." />
    <meta name="author" content="Yanti Kebaya" />
    <meta name="keywords" content="sewa kebaya, rental kebaya, kebaya pengantin, kebaya wisuda, kebaya pesta, kebaya tradisional, kebaya modern, aksesoris kebaya, sanggul kebaya, yanti kebaya" />

    <title><?= $this->renderSection('page_title'); ?></title>

    <?= $this->include('layouts/dashboard/partials/links'); ?>
    <?= $this->renderSection('head_css'); ?>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <?= $this->include('layouts/dashboard/partials/sidebar'); ?>

        <!--  Main wrapper -->
        <div class="body-wrapper">

            <?= $this->include('layouts/dashboard/partials/header'); ?>

            <div class="body-wrapper-inner">
                <div class="container-fluid">
                    <?= $this->renderSection('content'); ?>

                    <?= $this->include('layouts/dashboard/partials/footer'); ?>

                </div>
            </div>
        </div>
    </div>

    <?= $this->include('layouts/dashboard/partials/scripts'); ?>
    <?= $this->renderSection('foot_js'); ?>
</body>

</html>