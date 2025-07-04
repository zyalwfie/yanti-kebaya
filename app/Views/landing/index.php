<?= $this->extend('layouts/landing/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle; ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<section id="hero" class="hero section">
    <img src="<?= base_url() ?>img/hero-bg-index.jpg" alt="Model Kebaya Elegan" data-aos="fade-in" style="filter: brightness(0.7);">

    <div class="container text-center" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 style="text-shadow: 1px 1px 3px #000000;" class="text-white display-4">Temukan Kebaya Istimewa</h2>
                <p style="text-shadow: 1px 1px 3px #000000;" class="text-white">Koleksi kebaya premium untuk pengantin, wisuda & acara penting lainnya</p>
                <a href="<?= route_to('landing.shop.index') ?>" class="btn-get-started">Lihat Koleksi</a>
            </div>
        </div>
    </div>
</section>

<section id="about" class="about section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Tentang Kami</h2>
        <p>Lebih dari sekadar penyewaan kebaya, kami adalah partner penampilan elegan Anda</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
            <div class="col-lg-6">
                <img src="<?= base_url() ?>img/tentang-kami.jpg" class="img-fluid" alt="Tim Yanti Kebaya">
            </div>
            <div class="col-lg-6 content">
                <h3>Kenapa Memilih Yanti Kebaya?</h3>
                <p class="fst-italic">
                    Sejak 2020, kami berkomitmen menyediakan kebaya berkualitas dengan perawatan terbaik,
                    karena kami percaya setiap wanita berhak tampil anggun dengan kebaya yang sempurna.
                </p>
                <ul>
                    <li><i class="bi bi-check2-all"></i> <span><strong>Koleksi Eksklusif:</strong> Kebaya dengan bahan premium dan detail bordir yang indah.</span></li>
                    <li><i class="bi bi-check2-all"></i> <span><strong>Perawatan Hygienis:</strong> Setiap kebaya dibersihkan secara profesional setelah penggunaan.</span></li>
                    <li><i class="bi bi-check2-all"></i> <span><strong>Layanan Lengkap:</strong> Paket lengkap dengan aksesoris dan konsultasi styling gratis.</span></li>
                </ul>
                <p>
                    Berawal dari kecintaan terhadap budaya Indonesia, Yanti Kebaya hadir untuk melestarikan keindahan kebaya modern maupun tradisional.
                    Kami memahami betapa pentingnya penampilan sempurna di hari spesial Anda, itulah mengapa kami memberikan perhatian ekstra pada setiap detail kebaya yang kami sewakan.
                </p>
            </div>
        </div>
    </div>

</section>

<section id="why-us" class="why-us section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Kenapa Memilih Kami?</h2>
        <p>Alasan mengapa Yanti Kebaya menjadi pilihan tepat untuk kebaya istimewa Anda</p>
    </div><!-- End Section Title -->

    <div class="container">
        <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">

            <div class="col-md-4">
                <div class="card">
                    <div class="img">
                        <img src="<?= base_url() ?>img/kebaya-premium.jpg" alt="Koleksi Kebaya Berkualitas" class="img-fluid">
                        <div class="icon"><i class="bi bi-stars"></i></div>
                    </div>
                    <h2 class="title"><a href="#" class="stretched-link">Koleksi Eksklusif</a></h2>
                    <p>
                        Kebaya kami dipilih dari bahan premium dengan detail bordir halus. Setiap piece melalui proses quality control ketat untuk memastikan kesempurnaan penampilan Anda.
                    </p>
                </div>
            </div><!-- End Card Item -->

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card">
                    <div class="img">
                        <img src="<?= base_url() ?>img/perawatan-higienis.jpg" alt="Kebaya Bersih dan Rapi" class="img-fluid">
                        <div class="icon"><i class="bi bi-shield-check"></i></div>
                    </div>
                    <h2 class="title"><a href="#" class="stretched-link">Perawatan Hygienis</a></h2>
                    <p>
                        Setiap kebaya melalui proses dry cleaning profesional setelah penggunaan. Kami menjamin kebersihan dan kerapian sehingga Anda bisa merasa nyaman dan percaya diri.
                    </p>
                </div>
            </div><!-- End Card Item -->

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card">
                    <div class="img">
                        <img src="<?= base_url() ?>img/layanan-lengkap.jpg" alt="Konsultasi Kebaya" class="img-fluid">
                        <div class="icon"><i class="bi bi-heart"></i></div>
                    </div>
                    <h2 class="title"><a href="#" class="stretched-link">Layanan Personal</a></h2>
                    <p>
                        Tim styling kami siap membantu memilih kebaya yang sesuai dengan bentuk tubuh dan tema acara. Gratis konsultasi pemilihan warna, model, dan aksesoris pendukung.
                    </p>
                </div>
            </div><!-- End Card Item -->

        </div>
    </div>
</section>

<section id="services" class="services section light-background">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Layanan Kami</h2>
        <p>Solusi lengkap untuk segala kebutuhan kebaya istimewa Anda</p>
    </div><!-- End Section Title -->

    <div class="container">
        <div class="row gy-4">

            <!-- Layanan 1 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="service-item position-relative">
                    <div class="icon">
                        <i class="bi bi-percent"></i>
                    </div>
                    <a href="#" class="stretched-link">
                        <h3>Paket Spesial</h3>
                    </a>
                    <p>Nikmati promo eksklusif untuk paket lengkap kebaya + aksesoris dengan diskon hingga 30% khusus hari tertentu.</p>
                </div>
            </div><!-- End Service Item -->

            <!-- Layanan 2 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="service-item position-relative">
                    <div class="icon">
                        <i class="bi bi-chat-square-text-fill"></i>
                    </div>
                    <a href="#" class="stretched-link">
                        <h3>Konsultasi Styling</h3>
                    </a>
                    <p>Gratis konsultasi pemilihan kebaya sesuai bentuk tubuh, warna kulit, dan tema acara bersama stylist kami.</p>
                </div>
            </div><!-- End Service Item -->

            <!-- Layanan 3 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="service-item position-relative">
                    <div class="icon">
                        <i class="bi bi-scissors"></i>
                    </div>
                    <a href="#" class="stretched-link">
                        <h3>Minor Alteration</h3>
                    </a>
                    <p>Penyesuaian kecil gratis (pinggang, panjang kebaya) untuk mendapatkan fit yang sempurna di tubuh Anda.</p>
                </div>
            </div><!-- End Service Item -->

            <!-- Layanan 4 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="service-item position-relative">
                    <div class="icon">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <a href="#" class="stretched-link">
                        <h3>Paket Lengkap</h3>
                    </a>
                    <p>Sewa kebaya sudah termasuk aksesoris pelengkap (kerongsang, selendang, tas) tanpa biaya tambahan.</p>
                </div>
            </div><!-- End Service Item -->

            <!-- Layanan 5 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="service-item position-relative">
                    <div class="icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <a href="#" class="stretched-link">
                        <h3>Pengantaran</h3>
                    </a>
                    <p>Layanan antar-jemput kebaya ke lokasi Anda (area tertentu) dengan biaya terjangkau.</p>
                </div>
            </div><!-- End Service Item -->

            <!-- Layanan 6 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="service-item position-relative">
                    <div class="icon">
                        <i class="bi bi-camera-fill"></i>
                    </div>
                    <a href="#" class="stretched-link">
                        <h3>Rekomendasi Photoshoot</h3>
                    </a>
                    <p>Dapatkan referensi lokasi foto terbaik untuk kebaya Anda dan tips pose profesional.</p>
                </div>
            </div><!-- End Service Item -->

        </div>
    </div>
</section>

<section id="products" class="products section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Koleksi Kebaya Kami</h2>
        <p>Temukan keanggunan dalam setiap helai untuk momen paling berharga Anda. Jelajahi koleksi lengkapnya <a href="<?= route_to('landing.kebaya.index') ?>" class="text-decoration-underline">di sini</a>.</p>
    </div>
    <!-- End Section Title -->

    <div class="container">
        <div class="row g-4 row-cols-2 row-cols-md-4 justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <?php foreach ($products as $product) : ?>
                <div class="product-item">
                    <div class="card h-100">
                        <div
                            class="badge position-absolute"
                            style="top: 0.5rem; right: 0.5rem">
                            <?= $product['status'] ?>
                        </div>
                        <!-- Product image-->
                        <img
                            class="card-img-top"
                            src="<?= base_url('img/product/uploads/') . $product['foto'] ?>"
                            alt="<?= $product['nama_kebaya'] ?>" />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder"><?= $product['nama_kebaya'] ?></h5>
                                <!-- Product price -->
                                <span>Rp<?= number_format($product['harga_sewa'], '0', '.', ',') ?></span>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div
                            class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="d-flex flex-column flex-md-row gap-2 align-items-center justify-content-center">
                                <a
                                    class="btn cart-btn mt-auto"
                                    href="<?= route_to('landing.shop.show', $product['slug']) ?>">
                                    Lihat detail
                                </a>
                                <?php if (logged_in() && in_groups('user')) : ?>
                                    <?= form_open(route_to('landing.cart.add')) ?>
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= $product['id_kebaya'] ?>">
                                    <button type="submit" class="btn cart-btn">
                                        <i class="bi bi-cart-plus-fill"></i>
                                    </button>
                                    <?= form_close() ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="contact" class="contact section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Hubungi Kami</h2>
        <p>Tim Yanti Kebaya siap membantu Anda memilih kebaya yang membuat Anda percaya diri di hari istimewa.</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">

            <div class="col-lg-4">
                <div class="info-item d-flex flex-column justify-content-center align-items-center">
                    <i class="bi bi-geo-alt"></i>
                    <h3>Alamat</h3>
                    <p>Desa Rumak, Lombok Barat, NTB 83370</p>
                </div>
            </div><!-- End Info Item -->

            <div class="col-lg-4">
                <div class="info-item d-flex flex-column justify-content-center align-items-center info-item-borders">
                    <i class="bi bi-telephone"></i>
                    <h3>Telepon</h3>
                    <p>+62 823-3954-4560</p>
                </div>
            </div><!-- End Info Item -->

            <div class="col-lg-4">
                <div class="info-item d-flex flex-column justify-content-center align-items-center">
                    <i class="bi bi-envelope"></i>
                    <h3>Surel</h3>
                    <p>yantikebaya@business.com</p>
                </div>
            </div><!-- End Info Item -->

        </div>

        <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="300">
            <div class="row gy-4">

                <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Tulis namamu di sini" required="">
                </div>

                <div class="col-md-6 ">
                    <input type="email" class="form-control" name="email" placeholder="Tulis surelmu di sini" required="">
                </div>

                <div class="col-md-12">
                    <input type="text" class="form-control" name="subject" placeholder="Tentang apa pesanmu" required="">
                </div>

                <div class="col-md-12">
                    <textarea class="form-control" name="message" rows="6" placeholder="Tulis pesanmu di sini" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                    <div class="loading">Memuat</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Pesan Anda telah terkirim. Terima kasih!</div>

                    <button type="submit">Kirim Pesan</button>
                </div>

            </div>
        </form><!-- End Contact Form -->

    </div>

</section>
<?= $this->endSection(); ?>

<?= $this->section('head_css'); ?>
<style>
    .product-item .card {
        transition: .3s ease-in-out;
    }

    .product-item .card:hover {
        border-color: var(--accent-color);
    }

    .product-item .cart-btn {
        border: 1px solid var(--accent-color);
        transition: ease-in-out .3s;
        color: var(--accent-color);
    }

    .product-item .cart-btn:hover {
        color: var(--contrast-color) !important;
        background-color: var(--accent-color) !important;
    }

    .product-item .badge {
        background-color: var(--accent-color);
        color: var(--contrast-color);
    }
</style>
<?= $this->endSection(); ?>