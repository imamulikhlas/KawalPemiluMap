<?php
// Lokasi file JSON yang berisi data dan timestamp
$combinedDataFile = 'data/data-city-kawalpemilu.json';

// Baca data dari file JSON
$result = file_get_contents($combinedDataFile);

// Decode data JSON menjadi array
$resultArray = json_decode($result, true);

// Siapkan data untuk digunakan dalam JavaScript dan PHP lainnya
$jsonData = json_encode($resultArray);
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

    <link rel="stylesheet" href="assets/css/custom.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">

    <title>BANTU KAWAL PEMILU 2024</title>

</head>

<body class="homepage">
    <div id="loadingIndicator" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 1); display: flex; justify-content: center; align-items: center; z-index: 9999;">
        <img src="assets/img/loading100.gif" alt="Loading..." />
    </div>

    <div class="page-wrapper">
        <header id="page-header">
            <nav>
                <div class="text-center">
                    <h3 class="font-weight-bold">PETA SEBARAN SUARA PEMILU 2024 🇮🇩</h3>
                    <div class="primary-nav has-mega-menu" style="border-right:0px !important;">
                    <ul class="navigation">
                            <li>
                                <a  href="/">
                                    <img src="assets/img/logokpu.png" alt="Icon" style="max-width: 20px; max-height: 20px; vertical-align: middle; margin-right: 5px;">
                                    Data KPU
                                </a>
                            </li>
                            <li><a class="btn btn-danger rounded btn-xs" href="/kawalpemilu.php">
                                <img src="assets/img/logokawalpemilu.png" alt="Icon" style="max-width: 20px; max-height: 20px; vertical-align: middle; margin-right: 5px; background-color: white; border-radius: .5rem; ">
                                Data Kawal Pemilu</a>
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
                        <h3>Data diambil dari : <a class="font-weight-bold" href="https://kawalpemilu.org">KAWALPEMILU.ORG</a>
                        <img src="assets/img/logokawalpemilu.png" alt="Icon" style="max-width: 40px; max-height: 40px; vertical-align: middle; ">
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
                                                    <div class="card-body">
                                                        <h5 class="card-title">Anies - Muhaimin</h5>
                                                        <img src="img/amin.webp" alt="Paslon 2" class="img-fluid mb-3" style="max-width: auto; height: 80px;">
                                                        <p class="card-text"><span class="font-weight-bold totalPas1" ></span> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Prabowo - Gibran</h5>
                                                        <img src="img/pragib.webp" alt="Paslon 2" class="img-fluid mb-3" style="max-width: auto; height: 80px;">
                                                        <p class="card-text"><span class="font-weight-bold totalPas2"></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Ganjar - Mahfud</h5>
                                                        <img src="img/gamud.webp" alt="Paslon 2" class="text-center mb-3" style="max-width: auto; height: 80px;">
                                                        <p class="card-text"><span class="font-weight-bold totalPas3""></span></p>
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
                <div class="card-body text-center">
                    <p class="mb-0 font-weight-bold">⚠️ Update untuk Peta Sebaran Suara dari KawalPemilu, KawalAmin, Kawal Pemenangan Ganjar sedang diproses, mohon menunggu. ⚠️</p>
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
                                <a href="mams-ark.my.id" class="circle-icon"><i class="fas "></i></a>
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

        function getColor(data) {
            if (!data) return 'grey';
            var pas1 = data.pas1;
            var pas2 = data.pas2;
            var pas3 = data.pas3;

            if (pas1 === 0 && pas2 === 0 && pas3 === 0) {
                return 'grey';
            }

            var max = Math.max(pas1, pas2, pas3);
            if (max === pas1) return 'orange';
            if (max === pas2) return 'blue';
            if (max === pas3) return 'red';
            return 'grey';
        }

        fetch('geojson/indonesia-city1001.geojson')
            .then(function(response) {
                return response.json();
            })
            .then(function(json) {
                L.geoJson(json, {
                    style: function(feature) {
                        var kodeProvinsi = feature.properties.CC_2.toString();
                        var warna = 'gray';
                        if (hasilPemilu.table[kodeProvinsi]) {
                            var dataProvinsi = hasilPemilu.table[kodeProvinsi][0];
                            warna = getColor(dataProvinsi); // Mengambil warna berdasarkan data provinsi
                        } 

                        return {
                            color: 'white',
                            weight: 1,
                            fillColor: warna,
                            fillOpacity: 0.8
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        var kodeProvinsi = feature.properties.CC_2.toString();
                        if (hasilPemilu.table && hasilPemilu.table.hasOwnProperty(kodeProvinsi) && hasilPemilu.table[kodeProvinsi].length > 0) {
                            var dataProvinsi = hasilPemilu.table[kodeProvinsi][0];
                            if (dataProvinsi.pas1 + dataProvinsi.pas2 + dataProvinsi.pas3 === 0) {
                                var infoPemilu = "Data belum tersedia";
                                layer.bindTooltip(feature.properties.Propinsi);
                                layer.bindPopup(`<strong>${feature.properties.Propinsi}</strong><br>${infoPemilu}`);
                            } else if (dataProvinsi) {

                                // Menghitung total suara di provinsi
                                var totalSuaraProvinsi = dataProvinsi.pas1 + dataProvinsi.pas2 + dataProvinsi.pas3;

                                // Menghitung persentase untuk setiap paslon
                                var persenPas1 = ((dataProvinsi.pas1 / totalSuaraProvinsi) * 100).toFixed(2);
                                var persenPas2 = ((dataProvinsi.pas2 / totalSuaraProvinsi) * 100).toFixed(2);
                                var persenPas3 = ((dataProvinsi.pas3 / totalSuaraProvinsi) * 100).toFixed(2);

                                var totalTps = dataProvinsi.totalTps;
                                var totalCompletedTps = dataProvinsi.totalCompletedTps;

                                // Menghitung persentase TPS yang telah selesai
                                var totalPersenSuara = (totalCompletedTps / totalTps) * 100;
                                totalPersenSuara = totalTps > 0 ? totalPersenSuara.toFixed(2) : 0;

                                // Menambahkan tag img untuk logo paslon
                                var logoPaslon1 = `<img src="img/amin.webp" class="mt-3 mb-3 mr-2" alt="Logo Paslon 1" style="width: 50px; height: 50px;">`;
                                var logoPaslon2 = `<img src="img/pragib.webp" class="mb-3 mr-2" alt="Logo Paslon 2" style="width: 50px; height: 45px;">`;
                                var logoPaslon3 = `<img src="img/gamud.webp" class="mb-3 mr-2" alt="Logo Paslon 3" style="width: 50px; height: 50px;">`;
                                var infoPemilu = `
                                    ${logoPaslon1} ANIES - MUHAIMIN: ${formatNumber(dataProvinsi.pas1)}  (${persenPas1}%)<br>
                                    ${logoPaslon2} PRABOWO - GIBRAN: ${formatNumber(dataProvinsi.pas2)}  (${persenPas2}%)<br>
                                    ${logoPaslon3} GANJAR - MAHFUD: ${formatNumber(dataProvinsi.pas3)}  (${persenPas3}%) 
                                `;

                                layer.bindTooltip(feature.properties.NAME_2);
                                layer.bindPopup(`
                                <strong style="font-size:16px !important;">${feature.properties.NAME_2}</strong>
                                <div class="progress mt-2 mb-0" style="height: 20px; position: relative; overflow: visible;">
                                    <div class="progress-bar" role="progressbar" style="border-radius: .25rem; width: ${totalPersenSuara}%; background-color: green;" aria-valuenow="${totalPersenSuara}" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div style="position: absolute; width: 100%; text-align: center; font-weight: bold; color: black; height: 20px; line-height: 20px; top: 0;">
                                        ${totalPersenSuara}% Suara Masuk
                                    </div>
                                </div>
                                ${infoPemilu}`);
                                }
                            } else {
                            layer.bindTooltip(feature.properties.NAME_2);
                            layer.bindPopup(`<strong>${feature.properties.NAME_2}</strong><br>Data belum tersedia`);
                        }
                    }


                }).addTo(map);
            });

        // // Add a legend for overseas data
        // var overseasData = hasilPemilu[99] ? hasilPemilu[99] : null;
        // if (overseasData) {
        //     var legend = L.control({
        //         position: 'bottomright'
        //     });

        //     legend.onAdd = function(map) {
        //         var div = L.DomUtil.create('div', 'card p-2 info legend');

        //         var pas1Formatted = formatNumber(overseasData[0].pas1);
        //         var pas2Formatted = formatNumber(overseasData[0].pas2);
        //         var pas3Formatted = formatNumber(overseasData[0].pas3);

        //         var warnaPas1 = 'orange';
        //         var warnaPas2 = 'blue';
        //         var warnaPas3 = 'red';

        //         div.innerHTML += `<b class="mb-2">LUAR NEGERI</b><div class="legend-item"><span class="legend-color" style="background-color: ${warnaPas1};"></span><b>ANIES - MUHAIMIN: ${pas1Formatted} Suara</b></div>`;
        //         div.innerHTML += `<div class="legend-item"><span class="legend-color" style="background-color: ${warnaPas2};"></span><b>PRABOWO - GIBRAN: ${pas2Formatted} Suara</b></div>`;
        //         div.innerHTML += `<div class="legend-item"><span class="legend-color" style="background-color: ${warnaPas3};"></span><b>GANJAR - MAHFUD: ${pas3Formatted} Suara</b></div>`;

        //         return div;
        //     };

        //     legend.addTo(map);
        // }


        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>

    <!-- Hitung Persentase Suara Masuk -->
    <!-- <script>
        // Fungsi untuk menghitung dan menampilkan persentase
        function calculateAndDisplayTotalPercentage(data) {
            let totalTps = 0;
            let totalCompletedTps = 0;
            let totalPas1 = 0;
            let totalPas2 = 0;
            let totalPas3 = 0;  

            // Iterasi melalui semua entri di 'aggregated'
            for (const key in data.aggregated) {
                if (data.aggregated.hasOwnProperty(key)) {
                    const locations = data.aggregated[key];
                    locations.forEach(location => {
                        totalTps += location.totalTps;
                        totalCompletedTps += location.totalCompletedTps;
                        totalPas1 += location.pas1;
                        totalPas2 += location.pas2;
                        totalPas3 += location.pas3;
                    });
                }
            }

            let totalVotes = totalPas1 + totalPas2 + totalPas3; 

            // Hitung persentase
            const percentagePas1 = (totalPas1 / totalVotes) * 100;
            const percentagePas2 = (totalPas2 / totalVotes) * 100;
            const percentagePas3 = (totalPas3 / totalVotes) * 100;

            document.getElementById('progressBarPas1').style.width = `${percentagePas1.toFixed(2)}%`;
            document.getElementById('progressBarPas1').innerText = `${percentagePas1.toFixed(2)}%`;

            document.getElementById('progressBarPas2').style.width = `${percentagePas2.toFixed(2)}%`;
            document.getElementById('progressBarPas2').innerText = `${percentagePas2.toFixed(2)}%`;

            document.getElementById('progressBarPas3').style.width = `${percentagePas3.toFixed(2)}%`;
            document.getElementById('progressBarPas3').innerText = `${percentagePas3.toFixed(2)}%`;

            // Hitung persentase dan tampilkan hasil
            const percentage = (totalCompletedTps / totalTps) * 100;
            document.getElementById('percentageOutput').innerHTML = `${percentage.toFixed(2)}%`;

            // Update DOM untuk totalPas1, totalPas2, dan totalPas3
            document.querySelectorAll('.totalPas1').forEach(element => {
                element.innerHTML = `${totalPas1.toLocaleString('id-ID')}`;
            });
            document.querySelectorAll('.totalPas2').forEach(element => {
                element.innerHTML = `${totalPas2.toLocaleString('id-ID')}`;
            });
            document.querySelectorAll('.totalPas3').forEach(element => {
                element.innerHTML = `${totalPas3.toLocaleString('id-ID')}`;
            });

            // Mengembalikan nilai totalPas1, totalPas2, dan totalPas3
            return { totalPas1, totalPas2, totalPas3 };
        }
        

        // Memuat data dari file JSON dan menjalankan fungsi penghitungan
        fetch('data-kawalpemilu.json')
            .then(response => response.json())
            .then(data => {
                const totals = calculateAndDisplayTotalPercentage(data.result);
                updatePieChart(totals);
            })
            .catch(error => console.error('Error loading the JSON data: ', error));

        // Fungsi untuk mengupdate chart pie
        function updatePieChart(totals) {
            var ctx = document.getElementById('suaraPaslonPieChart').getContext('2d');
            var suaraPaslonPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Anies-Muhaimin', 'Prabowo-Gibran', 'Ganjar-Mahfud'],
                    datasets: [{
                        label: 'Jumlah Suara',
                        data: [totals.totalPas1, totals.totalPas2, totals.totalPas3],
                        backgroundColor: ['orange', 'blue', 'red'],
                        borderColor: ['rgba(255, 255, 255, 1)', 'rgba(255, 255, 255, 1)', 'rgba(255, 255, 255, 1)'],
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
        }

    </script> -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("loadingIndicator").style.display = 'none';
        });
    </script>

</body>