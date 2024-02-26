<?php
//Read .env
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Tentukan path ke direktori root proyek tempat file .env berada
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

//END

// Data From ENV
$dataDonation = $_ENV['API_DONATION'];
$dataProvinsi = $_SERVER['DOCUMENT_ROOT'] . $_ENV['API_DATA_KAWALPEMILU'];

// Baca data dari file JSON
$resultProvinsi = file_get_contents($dataProvinsi);

// Decode data JSON menjadi array
$resultArrayProvinsi = json_decode($resultProvinsi, true);

// Siapkan data untuk digunakan dalam JavaScript dan PHP lainnya
$jsonDataProv = json_encode($resultArrayProvinsi['result']['aggregated']);

// Ambil timestamp dan persentase suara masuk dari data
date_default_timezone_set('Asia/Jakarta'); 
$timestamp = date('Y-m-d H:i:s');

?>

<?php
// Lokasi file JSON yang berisi data dan timestamp
$dataKota = $_SERVER['DOCUMENT_ROOT'] . $_ENV['API_DATA_CITY_KAWALPEMILU'];

// Baca data dari file JSON
$resultKota = file_get_contents($dataKota);

// Decode data JSON menjadi array
$resultArrayKota = json_decode($resultKota, true);

// Siapkan data untuk digunakan dalam JavaScript dan PHP lainnya
$jsonDataKota = json_encode($resultArrayKota);
?>


<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php include realpath(__DIR__ . '/../../') . '/layout/header.php'; ?>
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
            <?php include realpath(__DIR__ . '/../../') . '/layout/navbar.php'; ?>
        </header>

        <div id="page-content">
            <div class="hero-section full-screen has-map has-sidebar">
                <div class="map-wrapper">
                    <div id="mapid">
                        <div class="watermark">© BANTUKAWALPEMILU.ONLINE</div>
                        <div id="loading" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000;">
                            <div class="loader"></div>
                        </div>
                    </div>

                </div>
                <!--end map-wrapper-->
                <div class="results-wrapper">
                    <div class="text-center my-3 font-weight-bold">
                        <h3>Data diambil dari : <a class="font-weight-bold" href="https://kawalpemilu.org">KAWALPEMILU.ORG</a>
                        <img src="/assets/img/logokawalpemilu.png" alt="Icon" style="max-width: 40px; max-height: 40px; vertical-align: middle; ">
                        </h3>
                    </div>
                    <div class="container my-3">
                        <div class="row">
                            <div class="col-12">
                                <div class="card text-center">
                                    <div class="card-header bg-secondary" style="color: white;">
                                        Update Data Terakhir: <b class="badge badge-success" style="font-size: 18px;"><?php echo date('d M Y H:i:s', strtotime($timestamp)); ?> WIB</b>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Total Suara Masuk: <span class="font-weight-bold" id="percentageOutput"></span></h5>
                                        <div class="row">
                                            <div class="col-lg-12 mb-3">
                                                <div class="card">
                                                    <div class="card-body padding-card-body1">
                                                        <h5 class="card-title">Anies - Muhaimin</h5>
                                                        <img src="/assets/img/amin.webp" alt="Paslon 2" class="img-fluid mb-3" style="max-width: auto; height: 80px;">
                                                        <p class="card-text"><span class="font-weight-bold totalPas1" ></span> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class="card">
                                                    <div class="card-body padding-card-body1">
                                                        <h5 class="card-title">Prabowo - Gibran</h5>
                                                        <img src="/assets/img/pragib.webp" alt="Paslon 2" class="img-fluid mb-3" style="max-width: auto; height: 80px;">
                                                        <p class="card-text"><span class="font-weight-bold totalPas2"></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class="card">
                                                    <div class="card-body padding-card-body1">
                                                        <h5 class="card-title">Ganjar - Mahfud</h5>
                                                        <img src="/assets/img/gamud.webp" alt="Paslon 2" class="text-center mb-3" style="max-width: auto; height: 80px;">
                                                        <p class="card-text"><span class="font-weight-bold totalPas3"></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--end results-wrapper-->
            </div>
            <!--end hero-section-->
        </div>
        <!--end page-content-->
        <div class="container my-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-center mb-3">Mengenal Bantukawalpemilu.online</h5>
                    <p class="text-justify" style="font-size: 0.9rem; line-height: 1.5;">
                        <strong>Bantukawalpemilu.online</strong> merupakan platform inovatif yang berkomitmen untuk meningkatkan transparansi dan keadilan dalam pemilihan umum Indonesia 2024. Dengan menghimpun data resmi dari <strong>KPU.GO.ID</strong>, <strong>KAWALPEMILU.ORG</strong>, dan <strong>KAWALAMIN.COM</strong>, situs ini menyediakan akses terpadu kepada publik untuk memantau proses pemilu. Melalui visualisasi data yang intuitif dan pembaruan data per Kota/Kabupaten, kami memfasilitasi partisipasi aktif warga dalam mengawasi pemilu, memastikan proses demokrasi berjalan dengan integritas dan keadilan.
                    </p>
                    <div class="text-center mt-4">
                        <a href="/about" class="btn btn-primary">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 my-3">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title text-center">Distribusi Suara</h5>
                            <canvas id="suaraPaslonPieChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 my-3">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title text-center">Persentase Suara</h5>
                            <!-- Progress Bars Start Here -->
                            <h6>Anies-Muhaimin</h6>
                            <div class="progress mb-2">
                                <div class="progress-bar" id="progressBarPas1" role="progressbar" style="background-color: orange;" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <h6>Prabowo-Gibran</h6>
                            <div class="progress mb-2">
                                <div class="progress-bar" id="progressBarPas2" role="progressbar" style="background-color: blue;" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <h6>Ganjar-Mahfud</h6>
                            <div class="progress">
                                <div class="progress-bar" id="progressBarPas3" role="progressbar" style="background-color: red;" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <!-- Progress Bars End Here -->
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-center font-weight-bold">Total Suara</h5> <h1 class="text-center font-weight-bold" id="totalSuara"></h1>
                            <div class="text-center my-2">
                                <a href="/" class="btn btn-primary">🕵️ Lihat Tabel Data</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-3">
                <div class="card-body">
                    <h5 class="card-title text-center mb-3 font-weight-bold">BARISAN RELAWAN DONATUR BANTUKAWALPEMILU.ONLINE</h5>
                    <div id="donations-container"></div>
                    <h5 class="card-title text-center mb-3">Terimakasih Buat Seluruh Relawan ❤️</h5>
                </div>
            </div>  
        </div>
        <footer id="page-footer">
            <?php include realpath(__DIR__ . '/../../') . '/layout/footer.php'; ?>
        </footer>
        <!--end page-footer-->
    </div>
    <!--end page-wrapper-->
    <a href="#" class="to-top scroll" data-show-after-scroll="600"><i class="arrow_up"></i></a>
    <?php include realpath(__DIR__ . '/../../') . '/layout/script.php'; ?>

    <!-- script bawaan -->
    <?php include 'script.php'; ?>

</body>