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

    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/custom1002.css" type="text/css">
    <style>
        .highlight { background-color: #ddffdd; } 
    </style>

    <title>BANTU KAWAL PEMILU 2024</title>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-W4T8S7DD');
    </script>
    <!-- End Google Tag Manager -->

</head>

<body class="homepage">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W4T8S7DD" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="loadingIndicator" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 1); display: flex; justify-content: center; align-items: center; z-index: 9999;">
        <img src="assets/img/loading1001.gif" alt="Loading..." />
    </div>

    <div class="page-wrapper">
        <header id="page-header">
            <nav>
                <div class="text-center">
                    <h3 class="font-weight-bold">BANTUKAWALPEMILU.ONLINE</h3>
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
                                <a href="/kawalamin.php">
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
            <div class="container py-3">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="text-center mt-4">
                                <a href="/" class="btn btn-primary">Kembali Ke Halaman Utama</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-3">
                                    <img src="assets/img/logokpu.png" alt="Icon" style="max-width: 30px; max-height: 30px; vertical-align: middle; margin-right: 5px; margin-bottom: 3px;">
                                    KPU : 
                                    <a href="/" class="font-weight-bold" style="font-size: 17px;">📍 LIHAT PETA</a>
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
                                    <img src="assets/img/logokawalpemilu.png" alt="Icon" style="max-width: 30px; max-height: 30px; vertical-align: middle; margin-right: 2px; margin-bottom: 3px;">
                                    KAWALPEMILU : 
                                    <a href="/" class="font-weight-bold" style="font-size: 17px;">📍 LIHAT PETA</a>
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
                                    <img src="assets/img/amin.webp" alt="Icon" style="max-width: 30px; max-height: 30px; vertical-align: middle; margin-right: 2px; margin-bottom: 3px;">
                                    KAWALAMIN : 
                                    <a href="/" class="font-weight-bold" style="font-size: 17px;">📍 LIHAT PETA</a>
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
                </div>
            </div>
        </div>
        <!--end page-content-->
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
    <script type="text/javascript" src="https://storage.sociabuzz.com/storage/js/main/buttononwebsite/index.min.js"></script><script>sbBoW.draw("petapemilu","QmVyaSBEdWt1bmdhbiE","position-bottom-right","#76cc11","#ffffff")</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        loadDataKpu();
        loadDataKawalPemilu();
        loadDataKawalAmin();

        setInterval(loadDataKpu, 10000); 
        setInterval(loadDataKawalPemilu, 10000); 
        setInterval(loadDataKawalAmin, 10000); 
    });

    function loadDataKpu() {
        $.ajax({
            url: 'https://api2.bantukawalpemilu.online/api/kpu/',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var rows = '';
                var formatter = new Intl.NumberFormat('id-ID');
                var totalP1 = 0; 
                var totalP2 = 0; 
                var totalP3 = 0;

                $.each(data.table, function(key, value) {
                    var wilayah = mapWilayah(key);
                    var suaraTerbanyak = Math.max(value['100025'], value['100026'], value['100027']);

                    // Akumulasi total suara untuk masing-masing paslon
                    totalP1 += value['100025'];
                    totalP2 += value['100026'];
                    totalP3 += value['100027'];

                    // Menentukan kelas untuk menyoroti jumlah suara terbanyak
                    var highlightClassP1 = suaraTerbanyak === value['100025'] ? 'highlight' : '';
                    var highlightClassP2 = suaraTerbanyak === value['100026'] ? 'highlight' : '';
                    var highlightClassP3 = suaraTerbanyak === value['100027'] ? 'highlight' : '';

                    rows += '<tr>' +
                            '<td>' + wilayah + ' <span class="badge badge-success">' + value['persen'] + '%</span>' + '</td>' +
                            `<td class="${highlightClassP1}">${formatter.format(value['100025'])}</td>` +
                            `<td class="${highlightClassP2}">${formatter.format(value['100026'])}</td>` +
                            `<td class="${highlightClassP3}">${formatter.format(value['100027'])}</td>` +
                            '</tr>';
                });
                var maxTotal = Math.max(totalP1, totalP2, totalP3);

                var highlightClassP1 = totalP1 === maxTotal ? 'highlight' : '';
                var highlightClassP2 = totalP2 === maxTotal ? 'highlight' : '';
                var highlightClassP3 = totalP3 === maxTotal ? 'highlight' : '';

                rows += `<tr class="font-weight-bold">
                            <td>Total Suara</td>
                            <td class="${highlightClassP1}">${formatter.format(totalP1)}</td>
                            <td class="${highlightClassP2}">${formatter.format(totalP2)}</td>
                            <td class="${highlightClassP3}">${formatter.format(totalP3)}</td>
                        </tr>`;
                rows += `<tr class="font-weight-bold">
                            <td>Total Suara Keseluruhan</td>
                            <td colspan="3">${formatter.format(totalP1 + totalP2 + totalP3)}</td>
                        </tr>`;

                $('#table-data-kpu').html(rows);
            }
        });
    }

    function loadDataKawalPemilu() {
        $.ajax({
            url: 'https://api2.bantukawalpemilu.online/api/kawalpemilu/prov/',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var rows = '';
                var formatter = new Intl.NumberFormat('id-ID');
                var totalP1 = 0; 
                var totalP2 = 0; 
                var totalP3 = 0;

                // Iterasi melalui data.result.aggregated karena struktur responsnya berbeda
                $.each(data.result.aggregated, function(idLokasi, wilayahArray) {
                    var wilayahData = wilayahArray[0]; 
                    var wilayah = mapWilayah(wilayahData.idLokasi);

                    // Akumulasi total suara untuk masing-masing paslon
                    totalP1 += wilayahData.pas1;
                    totalP2 += wilayahData.pas2;
                    totalP3 += wilayahData.pas3;

                    var suaraTerbanyak = Math.max(wilayahData.pas1, wilayahData.pas2, wilayahData.pas3);

                    // Menghitung persentase
                    var persentase = (wilayahData.totalCompletedTps / wilayahData.totalTps * 100).toFixed(2); 

                    var highlightClassP1 = suaraTerbanyak === wilayahData.pas1 ? 'highlight' : '';
                    var highlightClassP2 = suaraTerbanyak === wilayahData.pas2 ? 'highlight' : '';
                    var highlightClassP3 = suaraTerbanyak === wilayahData.pas3 ? 'highlight' : '';

                    rows += '<tr>' +
                            `<td>${wilayah} <span class="badge badge-success">${persentase}%</span></td>` +
                            `<td class="${highlightClassP1}">${formatter.format(wilayahData.pas1)}</td>` +
                            `<td class="${highlightClassP2}">${formatter.format(wilayahData.pas2)}</td>` +
                            `<td class="${highlightClassP3}">${formatter.format(wilayahData.pas3)}</td>` +
                            '</tr>';
                });
                var maxTotal = Math.max(totalP1, totalP2, totalP3);

                var highlightClassP1 = totalP1 === maxTotal ? 'highlight' : '';
                var highlightClassP2 = totalP2 === maxTotal ? 'highlight' : '';
                var highlightClassP3 = totalP3 === maxTotal ? 'highlight' : '';

                rows += `<tr class="font-weight-bold">
                            <td>Total Suara</td>
                            <td class="${highlightClassP1}">${formatter.format(totalP1)}</td>
                            <td class="${highlightClassP2}">${formatter.format(totalP2)}</td>
                            <td class="${highlightClassP3}">${formatter.format(totalP3)}</td>
                        </tr>`;
                rows += `<tr class="font-weight-bold">
                            <td>Total Suara Keseluruhan</td>
                            <td colspan="3">${formatter.format(totalP1 + totalP2 + totalP3)}</td>
                        </tr>`;

                $('#table-data-kawalpemilu').html(rows); 
            }
        });
    }

    function loadDataKawalAmin() {
        $.ajax({
            url: 'https://api2.bantukawalpemilu.online/api/kawalamin/',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var rows = '';
                var formatter = new Intl.NumberFormat('id-ID');
                var totalP1 = 0; 
                var totalP2 = 0; 
                var totalP3 = 0;

                $.each(data.table, function(key, val) {
                    var province = val.province;
                    var p1Votes = val.p1;
                    var p2Votes = val.p2;
                    var p3Votes = val.p3;

                    // Akumulasi total suara untuk masing-masing paslon
                    totalP1 += p1Votes;
                    totalP2 += p2Votes;
                    totalP3 += p3Votes;

                    var maxVotes = Math.max(p1Votes, p2Votes, p3Votes);

                    var highlightClassP1 = p1Votes === maxVotes ? 'highlight' : '';
                    var highlightClassP2 = p2Votes === maxVotes ? 'highlight' : '';
                    var highlightClassP3 = p3Votes === maxVotes ? 'highlight' : '';

                    rows += `<tr>
                                <td>${province}</td>
                                <td class="${highlightClassP1}">${formatter.format(p1Votes)}</td>
                                <td class="${highlightClassP2}">${formatter.format(p2Votes)}</td>
                                <td class="${highlightClassP3}">${formatter.format(p3Votes)}</td>
                            </tr>`;
                });

                var maxTotal = Math.max(totalP1, totalP2, totalP3);

                var highlightClassP1 = totalP1 === maxTotal ? 'highlight' : '';
                var highlightClassP2 = totalP2 === maxTotal ? 'highlight' : '';
                var highlightClassP3 = totalP3 === maxTotal ? 'highlight' : '';

                rows += `<tr class="font-weight-bold">
                            <td>Total Suara</td>
                            <td class="${highlightClassP1}">${formatter.format(totalP1)}</td>
                            <td class="${highlightClassP2}">${formatter.format(totalP2)}</td>
                            <td class="${highlightClassP3}">${formatter.format(totalP3)}</td>
                        </tr>`;
                rows += `<tr class="font-weight-bold">
                            <td>Total Suara Keseluruhan</td>
                            <td colspan="3">${formatter.format(totalP1 + totalP2 + totalP3)}</td>
                        </tr>`;

                $('#table-data-kawalamin').html(rows);
            }
        });
    }


    function mapWilayah(kode) {
        var wilayahMap = {
            "11" : "ACEH",
            "12" : "SUMATERA UTARA",
            "13" : "SUMATERA BARAT",
            "14" : "RIAU",
            "15" : "JAMBI",
            "16" : "SUMATERA SELATAN",
            "17" : "BENGKULU",
            "18" : "LAMPUNG",
            "19" : "KEPULAUAN BANGKA BELITUNG",
            "21" : "KEPULAUAN RIAU",
            "31" : "DKI JAKARTA",
            "32" : "JAWA BARAT",
            "33" : "JAWA TENGAH",
            "34" : "DI YOGYAKARTA",
            "35" : "JAWA TIMUR",
            "36" : "BANTEN",
            "51" : "BALI",
            "52" : "NUSA TENGGARA BARAT",
            "53" : "NUSA TENGGARA TIMUR",
            "61" : "KALIMANTAN BARAT",
            "62" : "KALIMANTAN TENGAH",
            "63" : "KALIMANTAN SELATAN",
            "64" : "KALIMANTAN TIMUR",
            "65" : "KALIMANTAN UTARA",
            "71" : "SULAWESI UTARA",
            "72" : "SULAWESI TENGAH",
            "73" : "SULAWESI SELATAN",
            "74" : "SULAWESI TENGGARA",
            "75" : "GORONTALO",
            "76" : "SULAWESI BARAT",
            "81" : "MALUKU",
            "82" : "MALUKU UTARA",
            "91" : "PAPUA",
            "92" : "PAPUA BARAT",
            "93" : "PAPUA SELATAN",
            "94" : "PAPUA TENGAH",
            "95" : "PAPUA PEGUNUNGAN",
            "96" : "PAPUA BARAT DAYA",
            "99" : "LUAR NEGRI",
        };
        return wilayahMap[kode] || kode;
    }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("loadingIndicator").style.display = 'none';
        });
    </script>
</body>