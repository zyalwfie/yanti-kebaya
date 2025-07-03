<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Yanti Kebaya adalah penyedia jasa sewa kebaya modern dan tradisional berkualitas. Temukan koleksi kebaya pengantin, kebaya wisuda, kebaya pesta, serta aksesoris pelengkap dengan harga terjangkau." />
    <meta name="author" content="Yanti Kebaya" />
    <meta name="keywords" content="sewa kebaya, rental kebaya, kebaya pengantin, kebaya wisuda, kebaya pesta, kebaya tradisional, kebaya modern, aksesoris kebaya, sanggul kebaya, yanti kebaya" />

    <title><?= $this->renderSection('page_title'); ?></title>

    <?= $this->include('layouts/landing/partials/links') ?>

    <?= $this->renderSection('head_css'); ?>

</head>

<body id="index-page">
    <?= $this->include('layouts/landing/partials/header') ?>

    <main class="main">
        <?= $this->renderSection('content'); ?>
    </main>

    <?= $this->include('layouts/landing/partials/footer') ?>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <?= $this->include('layouts/landing/partials/scripts'); ?>
    <?= $this->renderSection('foot_js'); ?>

</body>

</html>