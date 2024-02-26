<?php
date_default_timezone_set('Asia/Jakarta');

//Read .env
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Tentukan path ke direktori root proyek tempat file .env berada
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

//END

// Data From ENV
$dataDonation = $_ENV['API_DONATION'];
$combinedDataFile = $_ENV['API_DATA_KAWALAMIN'];
// $combinedDataFile = 'data/data-prov-kawalamin.json';

// Baca data dari file JSON
$result = file_get_contents($combinedDataFile);

// Decode data JSON menjadi array
$resultArray = json_decode($result, true);

// Siapkan data untuk digunakan dalam JavaScript dan PHP lainnya
$jsonData = json_encode($resultArray);

// // Ambil timestamp dan persentase suara masuk dari data
$timestamp = $resultArray['timestamp'];
// $persentaseSuaraMasuk = $resultArray['chart']['persen'];

// HITUNG Suara
$totalPas1 = 0;
$totalPas2 = 0;
$totalPas3 = 0;

foreach ($resultArray['table'] as $provinceData) {
    $totalPas1 += $provinceData['p1'];
    $totalPas2 += $provinceData['p2'];
    $totalPas3 += $provinceData['p3'];
}

$resultArray['chart'] = [
    'p1' => $totalPas1,
    'p2' => $totalPas2,
    'p3' => $totalPas3,
];

$totalSuaraMasuk = $totalPas1 + $totalPas2 + $totalPas3;

$persentaseSuara = ($totalSuaraMasuk / 146643385) * 100;

// HITUNG PERSENTASE
$persentasePas1 = ($totalPas1 / $totalSuaraMasuk) * 100;
$persentasePas2 = ($totalPas2 / $totalSuaraMasuk) * 100;
$persentasePas3 = ($totalPas3 / $totalSuaraMasuk) * 100;


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
                    </div>

                </div>
                <!--end map-wrapper-->
                <div class="results-wrapper">
                    <div class="text-center my-3 font-weight-bold">
                        <h3>Data diambil dari : <a class="font-weight-bold" href="https://kawalamin.com">KAWALAMIN.COM</a>
                        <img src="/assets/img/amin.webp" class="ml-2" alt="Icon" style="max-width: 40px; max-height: 40px; vertical-align: middle; ">
                        </h3>
                    </div>
                    <div class="container my-3">
                        <div class="row">
                            <div class="col-12">
                                <div class="card text-center">
                                    <div class="card-header bg-secondary" style="color: white;">
                                        Update Data Terakhir: <b class="badge badge-success" style="font-size: 18px;"><?php echo date('d M Y H:i:s', strtotime($timestamp)); ?> WIB</b>
                                    </div>
                                    <!-- <div class="card-header bg-secondary" style="color: white;">
                                        Update Data Terakhir: <b class="badge badge-success" style="font-size: 18px;">2024-02-21 19:55:18 WIB</b>
                                    </div> -->
                                    <div class="card-body">
                                        <h5 class="card-title">Total Suara Masuk: <span class="font-weight-bold"> <?php echo number_format($persentaseSuara, 2, '.', '') ; ?>% </span></h5>
                                        <!-- <h5 class="card-title">Total Suara Masuk: <span class="font-weight-bold"> <?php echo number_format($totalSuaraMasuk, 0, '', '.'); ?> </span></h5> -->
                                        <div class="row">
                                            <div class="col-lg-12 mb-3">
                                                <div class="card">
                                                    <div class="card-body padding-card-body1">
                                                        <h5 class="card-title">Anies - Muhaimin</h5>
                                                        <img src="/assets/img/amin.webp" alt="Paslon 2" class="img-fluid mb-3" style="max-width: auto; height: 80px;">
                                                        <p class="card-text font-weight-bold"><?php echo number_format($resultArray['chart']['p1'], 0, '', '.');  ?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class="card">
                                                    <div class="card-body padding-card-body1">
                                                        <h5 class="card-title">Prabowo - Gibran</h5>
                                                        <img src="/assets/img/pragib.webp" alt="Paslon 2" class="img-fluid mb-3" style="max-width: auto; height: 80px;">
                                                        <p class="card-text font-weight-bold"><?php echo number_format($resultArray['chart']['p2'], 0, '', '.');  ?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class="card">
                                                    <div class="card-body padding-card-body1">
                                                        <h5 class="card-title">Ganjar - Mahfud</h5>
                                                        <img src="/assets/img/gamud.webp" alt="Paslon 2" class="text-center mb-3" style="max-width: auto; height: 80px;">
                                                        <p class="card-text font-weight-bold"><?php echo number_format($resultArray['chart']['p3'], 0, '', '.');  ?> </p>
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
                            <h6>Anies-Muhaimin</h6>
                            <div class="progress mb-2">
                                <div class="progress-bar" role="progressbar" style="width: <?php echo number_format($persentasePas1, 2); ?>%; background-color: orange;" aria-valuenow="<?php echo number_format($persentasePas1, 2); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($persentasePas1, 2); ?>%</div>
                            </div>
                            <h6>Prabowo-Gibran</h6>
                            <div class="progress mb-2">
                                <div class="progress-bar" role="progressbar" style="width: <?php echo number_format($persentasePas2, 2); ?>%; background-color: blue;" aria-valuenow="<?php echo number_format($persentasePas2, 2); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($persentasePas2, 2); ?>%</div>
                            </div>
                            <h6>Ganjar-Mahfud</h6>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: <?php echo number_format($persentasePas3, 2); ?>%; background-color: red;" aria-valuenow="<?php echo number_format($persentasePas3, 2); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($persentasePas3, 2); ?>%</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-center font-weight-bold">Total Suara</h5> <h1 class="text-center font-weight-bold"><?php echo number_format($totalSuaraMasuk, 0, '', '.'); ?></h1>
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