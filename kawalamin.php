<?php
date_default_timezone_set('Asia/Jakarta');
// Lokasi file JSON yang berisi data dan timestamp
$combinedDataFile = 'http://47.236.80.211/data-prov-kawalamin.json';
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

// HITUNG PERSENTASE
$persentasePas1 = ($totalPas1 / $totalSuaraMasuk) * 100;
$persentasePas2 = ($totalPas2 / $totalSuaraMasuk) * 100;
$persentasePas3 = ($totalPas3 / $totalSuaraMasuk) * 100;


?>


<!DOCTYPE html>

<html lang="en-US">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Muhammad Imamul Ikhlas">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <link href="assets/fonts/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="assets/fonts/elegant-fonts.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700,900,400italic' rel='stylesheet' type='text/css'>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-search/dist/leaflet-search.min.css" />

    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/custom1001.css" type="text/css">

    <title>BANTU KAWAL PEMILU 2024</title>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-W4T8S7DD');</script>
    <!-- End Google Tag Manager -->

</head>

<body class="homepage">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W4T8S7DD"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="loadingIndicator" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 1); display: flex; justify-content: center; align-items: center; z-index: 9999;">
        <img src="assets/img/loading1001.gif" alt="Loading..." />
    </div>

    <div class="page-wrapper">
        <header id="page-header">
            <nav>
                <div class="text-center">
                    <h3 class="font-weight-bold">PETA SEBARAN SUARA PEMILU 2024 🇮🇩</h3>
                    <div class="primary-nav has-mega-menu" style="border-right:0px !important;">
                        <ul class="navigation">
                            <li>
                                <a href="/">
                                    <img src="assets/img/logokpu.png" alt="Icon" style="max-width: 20px; max-height: 20px; vertical-align: middle; margin-right: 5px;">
                                    KPU
                                </a>
                            </li>
                            <li>
                                <a href="/kawalpemilu.php">
                                <img src="assets/img/logokawalpemilu.png" alt="Icon" style="max-width: 20px; max-height: 20px; vertical-align: middle; margin-right: 5px;">
                                    Kawal Pemilu
                                </a>
                            </li>
                            <li>
                                <a  class="btn btn-danger rounded btn-xs" href="/kawalamin.php">
                                <img src="img/amin.webp" alt="Icon" style="max-width: 20px; max-height: 20px; vertical-align: middle; margin-right: 5px;">
                                    KawalAmin
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!--end nav-->
        </header>
        <!--end page-header-->

        <div id="page-content">
            <div class="hero-section full-screen has-map has-sidebar">
                <div class="map-wrapper">
                    <div id="mapid"></div>

                </div>
                <!--end map-wrapper-->
                <div class="results-wrapper">
                    <div class="text-center my-3 font-weight-bold">
                        <h3>Data diambil dari : <a class="font-weight-bold" href="https://kawalamin.com">KAWALAMIN.COM</a>
                        <img src="img/amin.webp" class="ml-2" alt="Icon" style="max-width: 40px; max-height: 40px; vertical-align: middle; ">
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
                                        <!-- <h5 class="card-title">Total Suara Masuk: <span class="font-weight-bold"> <?php echo $persentaseSuaraMasuk; ?>% </span></h5> -->
                                        <h5 class="card-title">Total Suara Masuk: <span class="font-weight-bold"> <?php echo number_format($totalSuaraMasuk, 0, '', '.'); ?> </span></h5>
                                        <div class="row">
                                            <div class="col-lg-12 mb-3">
                                                <div class="card">
                                                    <div class="card-body padding-card-body1">
                                                        <h5 class="card-title">Anies - Muhaimin</h5>
                                                        <img src="img/amin.webp" alt="Paslon 2" class="img-fluid mb-3" style="max-width: auto; height: 80px;">
                                                        <p class="card-text font-weight-bold"><?php echo number_format($resultArray['chart']['p1'], 0, '', '.');  ?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class="card">
                                                    <div class="card-body padding-card-body1">
                                                        <h5 class="card-title">Prabowo - Gibran</h5>
                                                        <img src="img/pragib.webp" alt="Paslon 2" class="img-fluid mb-3" style="max-width: auto; height: 80px;">
                                                        <p class="card-text font-weight-bold"><?php echo number_format($resultArray['chart']['p2'], 0, '', '.');  ?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class="card">
                                                    <div class="card-body padding-card-body1">
                                                        <h5 class="card-title">Ganjar - Mahfud</h5>
                                                        <img src="img/gamud.webp" alt="Paslon 2" class="text-center mb-3" style="max-width: auto; height: 80px;">
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
                        <a href="about-us.php" class="btn btn-primary">Pelajari Lebih Lanjut</a>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer id="page-footer">
            <div class="footer-wrapper">
                <div class="container">
                    <h3 class="text-center font-weight-bold text-secondary">CREDIT TO</h3>
                    <div class="logos">
                        <div class="logo">
                            <a href="https://pemilu2024.kpu.go.id"><img src="assets/img/logokpu.png" style="width: 50px; height: 50px;" alt=""></a>
                        </div>
                        <div class="logo">
                            <a href="https://kawalpemilu.org/"><img src="assets/img/logokawalpemilu.png" style="width: 60px; height: 60px;" alt=""></a>
                        </div>
                        <div class="logo">
                            <a href="https://mams-ark.my.id"><img src="assets/img/logomams.png" style="width: 50px; height: 50px;" alt=""></a>
                        </div>
                        <!-- <div class="logo">
                            <a href="https://mams-ark.my.id"><img src="assets/img/logomams.png" style="width: 50px; height: 50px;" alt=""></a>
                        </div> -->
                        <!-- <div class="logo">
                        <a href="https://mams-ark.my.id"><img src="assets/img/logomams.png" style="width: 50px; height: 50px;" alt=""></a>
                    </div> -->
                    </div>
                    <!--/ .logos-->
                </div>

                <div class="container">
                    <hr>
                </div>

                <div class="block">
                    <div class="container">
                        <div class="vertical-aligned-elements">
                            <div class="element width-50">
                                <p data-toggle="modal" data-target="#myModal">Selamat menggunakan web ini untuk mengawal demokrasi dan hasil Pemilu Presiden 2024. Dapatkan source code : <a href="https://github.com/imamulikhlas">GITHUB</a> dan boleh juga kunjungi <a href="https://mams-ark.my.id">MAMS-ARK.MY.ID</a>.</p>
                            </div>
                            <div class="element width-50 text-align-right">
                                <a href="/" class="circle-icon"><i class="fas "></i></a>
                            </div>
                        </div>
                        <div class="background-wrapper">
                            <div class="bg-transfer opacity-50">
                                <img src="assets/img/footer-bg.png" alt="">
                            </div>
                        </div>
                        <!--end background-wrapper-->
                    </div>
                </div>
                <div class="footer-navigation">
                    <div class="container">
                        <div class="vertical-aligned-elements">
                            <div class="element width-50">🇮🇩 #KAWALPEMILU2024 Mams-ark.my.id</div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!--end page-footer-->
    </div>
    <!--end page-wrapper-->
    <a href="#" class="to-top scroll" data-show-after-scroll="600"><i class="arrow_up"></i></a>


    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-search/dist/leaflet-search.min.js"></script>

    <script>
        // Lokasi awal dan zoom level
        var awalLokasi = [-2.548926, 118.0148634];
        var awalZoom = 5;

        var map = L.map('mapid', {
            fullscreenControl: true,
            fullscreenControlOptions: {
                position: 'topleft'
            }
        }).setView(awalLokasi, awalZoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan fungsi untuk kembali ke lokasi awal
        var kembaliKeAwal = function() {
            map.flyTo(awalLokasi, awalZoom);
        };

        // Membuat control kustom
        var kustomControl = L.Control.extend({
            options: {
                position: 'topleft'
            },

            onAdd: function(map) {
                var controlDiv = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
                controlDiv.innerHTML = '<button style="background-color: #fff; border: none; cursor: pointer; width: 30px; height: 30px; text-align: center;"><i class="fa fa-home"></i></button>';
                controlDiv.title = "Kembali ke awal";
                controlDiv.onclick = function() {
                    kembaliKeAwal();
                }
                return controlDiv;
            }
        });

        map.addControl(new kustomControl());

        // Data pemilu diperoleh dari PHP
        var hasilPemilu = JSON.parse('<?php echo $jsonData; ?>');

        var timestamp = hasilPemilu.ts;
        var psu = hasilPemilu.psu;
        var chartData = hasilPemilu.chart;

        // Contoh: Menampilkan data ts, psu, dan chart pada konsol
        console.log('Timestamp:', timestamp);
        console.log('PSU:', psu);
        console.log('Chart Data:', chartData);


        function getColor(data) {
            if (!data) return 'grey';
            var pas1 = data['p1'];
            var pas2 = data['p2'];
            var pas3 = data['p3'];
            var max = Math.max(pas1, pas2, pas3);
            if (max === pas1) return 'orange';
            if (max === pas2) return 'blue';
            if (max === pas3) return 'red';
            return 'grey';
        }

        fetch('geojson/indonesia-prov1001.geojson')
            .then(function(response) {
                return response.json();
            })
            .then(function(json) {
                var geoJsonLayer = L.geoJson(json, {
                    style: function(feature) {
                        var kodeProvinsi = feature.properties.kode.toString();
                        var warna = 'gray';
                        if (hasilPemilu.table[kodeProvinsi]) {
                            var dataProvinsi = hasilPemilu.table[kodeProvinsi];
                            warna = getColor(dataProvinsi);
                        }

                        return {
                            color: 'white',
                            weight: 1,
                            fillColor: warna,
                            fillOpacity: 0.8
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        var kodeProvinsi = feature.properties.kode.toString();
                        var dataProvinsi = hasilPemilu.table[kodeProvinsi];

                        if (!dataProvinsi || typeof dataProvinsi['p1'] === 0 || typeof dataProvinsi['p2'] === 0 || typeof dataProvinsi['p3'] === 0 ) {
                            var infoPemilu = "Data belum tersedia";
                            layer.bindTooltip(feature.properties.Propinsi);
                            layer.bindPopup(`<strong style="font-size:16px !important;">${feature.properties.Propinsi}</strong><br>${infoPemilu}`);

                        } else if (dataProvinsi) {

                            // Menghitung total suara di provinsi
                            var totalSuaraProvinsi = dataProvinsi['p1'] + dataProvinsi['p2'] + dataProvinsi['p3'];
                            var totalPersenSuara = dataProvinsi.persen;

                            // Menghitung persentase untuk setiap paslon
                            var persenPas1 = ((dataProvinsi['p1'] / totalSuaraProvinsi) * 100).toFixed(2);
                            var persenPas2 = ((dataProvinsi['p2'] / totalSuaraProvinsi) * 100).toFixed(2);
                            var persenPas3 = ((dataProvinsi['p3'] / totalSuaraProvinsi) * 100).toFixed(2);

                            // Menambahkan tag img untuk logo paslon
                            var logoPaslon1 = `<img src="img/amin.webp" class="mt-3 mb-3 mr-2" alt="Logo Paslon 1" style="width: 50px; height: 50px;">`;
                            var logoPaslon2 = `<img src="img/pragib.webp" class="mb-3 mr-2" alt="Logo Paslon 2" style="width: 50px; height: 45px;">`;
                            var logoPaslon3 = `<img src="img/gamud.webp" class="mb-3 mr-2" alt="Logo Paslon 3" style="width: 50px; height: 50px;">`;
                        
                            var infoPemilu = `
                            <div class="container">
                                <!-- Paslon 1: ANIES - MUHAIMIN -->
                                <div class="row align-items-center my-3">
                                    <div class="col-auto">
                                        <img src="img/amin.webp" alt="Logo Paslon 1" style="width: 50px; height: 50px;">
                                    </div>
                                    <div class="col">
                                        <strong>ANIES - MUHAIMIN:</strong> ${formatNumber(dataProvinsi['p1'])} (${persenPas1}%)
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar" role="progressbar" style="width: ${persenPas1}%; background-color: orange;" aria-valuenow="${persenPas1}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paslon 2: PRABOWO - GIBRAN -->
                                <div class="row align-items-center my-3">
                                    <div class="col-auto">
                                        <img src="img/pragib.webp" alt="Logo Paslon 2" style="width: 50px; height: 45px;">
                                    </div>
                                    <div class="col">
                                        <strong>PRABOWO - GIBRAN:</strong> ${formatNumber(dataProvinsi['p2'])} (${persenPas2}%)
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar" role="progressbar" style="width: ${persenPas2}%; background-color: blue;" aria-valuenow="${persenPas2}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paslon 3: GANJAR - MAHFUD -->
                                <div class="row align-items-center my-3">
                                    <div class="col-auto">
                                        <img src="img/gamud.webp" alt="Logo Paslon 3" style="width: 50px; height: 50px;">
                                    </div>
                                    <div class="col">
                                        <strong>GANJAR - MAHFUD:</strong> ${formatNumber(dataProvinsi['p3'])} (${persenPas3}%)
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar" role="progressbar" style="width: ${persenPas3}%; background-color: red;" aria-valuenow="${persenPas3}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;

                            layer.bindTooltip(feature.properties.Propinsi);
                            // layer.bindPopup(`
                            // <strong style="font-size:16px !important;">${feature.properties.Propinsi}</strong>
                            // <div class="progress mt-2 mb-0" style="height: 20px; position: relative; overflow: visible;">
                            //     <div class="progress-bar" role="progressbar" style="border-radius: .25rem; width: ${totalPersenSuara}%; background-color: green;" aria-valuenow="${totalPersenSuara}" aria-valuemin="0" aria-valuemax="100"></div>
                            //     <div style="position: absolute; width: 100%; text-align: center; font-weight: bold; color: black; height: 20px; line-height: 20px; top: 0;">
                            //         ${totalPersenSuara}% Suara Masuk
                            //     </div>
                            // </div>
                            // ${infoPemilu}`);
                            layer.bindPopup(`
                            <strong style="font-size:16px !important;">${feature.properties.Propinsi}</strong><br>
                            ${infoPemilu}`);
                        }
                    }


                }).addTo(map);
                

                var searchControl = new L.Control.Search({
                    layer: geoJsonLayer,
                    position: 'topright',
                    propertyName: 'Propinsi', 
                    moveToLocation: function(latlng, title, map) {
                        map.flyTo(latlng, 10, {
                            animate: true,
                            duration: 0.5
                        });

                        map.once('zoomend', function() {
                            var matchingLayer = geoJsonLayer.getLayers().find(function(layer) {
                                return layer.feature.properties.Propinsi === title;
                            });

                            if (matchingLayer) {
                                matchingLayer.fire('click');
                            }
                        });
                    }
                });

                searchControl.addTo(map);

            });

        // Add a legend for overseas data
        var overseasData = hasilPemilu.table['11'];
        if (overseasData) {
            var legend = L.control({
                position: 'bottomright'
            });

            legend.onAdd = function(map) {
                var div = L.DomUtil.create('div', 'card p-2 info legend');

                // var pas1Formatted = formatNumber(overseasData["p1"]);
                // var pas2Formatted = formatNumber(overseasData["p2"]);
                // var pas3Formatted = formatNumber(overseasData["p3"]);

                // var warnaPas1 = 'orange';
                // var warnaPas2 = 'blue';
                // var warnaPas3 = 'red';

                // div.innerHTML += `<b class="mb-2">LUAR NEGERI</b><div class="legend-item"><span class="legend-color" style="background-color: ${warnaPas1};"></span><b>ANIES - MUHAIMIN: ${pas1Formatted} Suara</b></div>`;
                // div.innerHTML += `<div class="legend-item"><span class="legend-color" style="background-color: ${warnaPas2};"></span><b>PRABOWO - GIBRAN: ${pas2Formatted} Suara</b></div>`;
                // div.innerHTML += `<div class="legend-item"><span class="legend-color" style="background-color: ${warnaPas3};"></span><b>GANJAR - MAHFUD: ${pas3Formatted} Suara</b></div>`;
                div.innerHTML += `<div class="legend-item"><span class="legend-color" style="background-color: orange;"></span><b>ANIES - MUHAIMIN</b></div>`;
                div.innerHTML += `<div class="legend-item"><span class="legend-color" style="background-color: blue;"></span><b>PRABOWO - GIBRAN</b></div>`;
                div.innerHTML += `<div class="legend-item"><span class="legend-color" style="background-color: red;"></span><b>GANJAR - MAHFUD</b></div>`;
                return div;
            };


            legend.addTo(map);
        }


        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>

    <!-- Pie Chart -->
    <script>
        var ctx = document.getElementById('suaraPaslonPieChart').getContext('2d');
        var suaraPaslonPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Anies-Muhaimin', 'Prabowo-Gibran', 'Ganjar-Mahfud'],
                datasets: [{
                    label: 'Jumlah Suara',
                    data: [
                        <?php echo $totalPas1; ?>,
                        <?php echo $totalPas2; ?>,
                        <?php echo $totalPas3; ?>
                    ],
                    backgroundColor: [
                        'orange',
                        'blue',
                        'red'
                    ],
                    borderColor: [
                        'rgba(255, 255, 255, 1)',
                        'rgba(255, 255, 255, 1)',
                        'rgba(255, 255, 255, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true
                    }
                }
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("loadingIndicator").style.display = 'none';
        });
    </script>

</body>