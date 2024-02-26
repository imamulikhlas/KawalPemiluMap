<?php
//Read .env
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Tentukan path ke direktori root proyek tempat file .env berada
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
//END

// Data From ENV
$dataDonation = $_ENV['API_DONATION'];
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php include realpath(__DIR__ . '/../') . '/layout/header.php'; ?>
</head>

<body class="homepage">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W4T8S7DD" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="loadingIndicator" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 1); display: flex; justify-content: center; align-items: center; z-index: 9999;">
        <img src="/assets/img/loading1001.gif" alt="Loading..." />
    </div>

    <div class="page-wrapper">
        <header id="page-header">
            <?php include realpath(__DIR__ . '/../') . '/layout/navbar.php'; ?>
        </header>

        <div id="page-content">
            <div class="container py-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm">
                                        <a href="/petapemilu/kpu" class="btn btn-primary rounded d-flex align-items-center justify-content-center mb-2">
                                            <img src="/assets/img/logokpu.png" alt="Icon" style="max-width: 30px; max-height: 30px; vertical-align: middle; margin-right: 5px;">
                                            Lihat Peta Suara KPU
                                        </a>
                                    </div>
                                    <div class="col-sm">
                                        <a href="/petapemilu/kawalpemilu" class="btn btn-primary rounded d-flex align-items-center justify-content-center mb-2">
                                            <img src="/assets/img/logokawalpemilu.png" alt="Icon" style="max-width: 30px; max-height: 30px; vertical-align: middle; margin-right: 5px;background-color: white; border-radius: .5rem;">
                                            Lihat Peta Suara KAWAL PEMILU
                                        </a>
                                    </div>
                                    <div class="col-sm">
                                        <a href="/petapemilu/kawalamin" class="btn btn-primary rounded d-flex align-items-center justify-content-center">
                                            <img src="/assets/img/amin.webp" alt="Icon" style="max-width: 30px; max-height: 30px; vertical-align: middle; margin-right: 5px;">
                                            Lihat Peta Suara KAWAL AMIN
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-3">
                                    <img src="/assets/img/logokpu.png" alt="Icon" style="max-width: 30px; max-height: 30px; vertical-align: middle; margin-right: 5px; margin-bottom: 3px;">
                                    KPU :
                                    <a href="/petapemilu/kpu" class="font-weight-bold" style="font-size: 17px;">📍 LIHAT PETA</a>
                                </h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Wilayah</th>
                                            <th>Paslon 1</th>
                                            <th>Paslon 2</th>
                                            <th>Paslon 3</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-data-kpu">
                                        <!-- Data akan dimuat di sini -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-3">
                                    <img src="/assets/img/logokawalpemilu.png" alt="Icon" style="max-width: 30px; max-height: 30px; vertical-align: middle; margin-right: 2px; margin-bottom: 3px;">
                                    KAWALPEMILU :
                                    <a href="/petapemilu/kawalpemilu" class="font-weight-bold" style="font-size: 17px;">📍 LIHAT PETA</a>
                                </h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Wilayah</th>
                                            <th>Paslon 1</th>
                                            <th>Paslon 2</th>
                                            <th>Paslon 3</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-data-kawalpemilu">
                                        <!-- Data akan dimuat di sini -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-3">
                                    <img src="/assets/img/amin.webp" alt="Icon" style="max-width: 30px; max-height: 30px; vertical-align: middle; margin-right: 2px; margin-bottom: 3px;">
                                    KAWALAMIN :
                                    <a href="/petapemilu/kawalamin" class="font-weight-bold" style="font-size: 17px;">📍 LIHAT PETA</a>
                                </h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Wilayah</th>
                                            <th>Paslon 1</th>
                                            <th>Paslon 2</th>
                                            <th>Paslon 3</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-data-kawalamin">
                                        <!-- Data akan dimuat di sini -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-3">TABEL DATA BANTU KAWAL PEMILU</h5>
                                <p class="text-justify" style="font-size: 0.9rem; line-height: 1.5;">
                                    Berikut adalah tabel data yang kami tampilkan untuk peta dimana data ini didapatkan dari sistem KPU, Kawalpemilu.org, KawalAmin dan dirancang agar dapat mudah dibaca oleh pengunjung Bantukawalpemilu.online. Semoga dapat membantu teman-teman semua dalam memantau dan mengawal Pemilu Presiden 2024.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card shadow mb-3">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-3 font-weight-bold">BARISAN RELAWAN DONATUR BANTUKAWALPEMILU.ONLINE</h5>
                                <div id="donations-container"></div>
                                <h5 class="card-title text-center mb-3">Terimakasih Buat Seluruh Relawan ❤️</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer id="page-footer">
            <?php include realpath(__DIR__ . '/../') . '/layout/footer.php'; ?>
        </footer>
        <!--end page-footer-->
    </div>
    <!--end page-wrapper-->
    <a href="#" class="to-top scroll" data-show-after-scroll="600"><i class="arrow_up"></i></a>
    <?php include realpath(__DIR__ . '/../') . '/layout/script.php'; ?>

    <!-- script bawaan -->
    <?php include 'script.php'; ?>

</body>