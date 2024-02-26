<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php include realpath(__DIR__ . '/') . '/layout/header.php'; ?>
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
            <?php include realpath(__DIR__ . '/') . '/layout/navbar.php'; ?>
        </header>

        <div id="page-content">
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-3">Mengenal Bantukawalpemilu.online</h5>
                                <p class="text-justify" style="font-size: 0.9rem; line-height: 1.5;">
                                    <strong>Bantukawalpemilu.online</strong> merupakan platform inovatif yang berkomitmen untuk meningkatkan transparansi dan keadilan dalam pemilihan umum Indonesia 2024. Kami mengintegrasikan data resmi dari <strong>KPU.GO.ID</strong>, <strong>KAWALPEMILU.ORG</strong>, dan <strong>KAWALAMIN.COM</strong>, menyediakan akses terpadu kepada publik untuk memantau proses pemilu dengan akurat.
                                </p>
                            </div>
                        </div>

                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-3">Visi dan Misi Kami</h5>
                                <p class="text-justify" style="font-size: 0.9rem; line-height: 1.5;">
                                    Visi kami adalah mewujudkan proses pemilihan umum yang transparan dan adil, memastikan setiap suara dihitung dengan benar. Misi kami adalah memperkuat partisipasi masyarakat dalam pemilu melalui akses informasi yang mudah dan akurat, mendorong pemilu yang berintegritas.
                                </p>
                            </div>
                        </div>

                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-3">Bagaimana Kami Bekerja</h5>
                                <p class="text-justify" style="font-size: 0.9rem; line-height: 1.5;">
                                    Kami bekerja dengan menghimpun dan menganalisis data pemilu dari berbagai sumber terpercaya, menggunakan teknologi terkini untuk visualisasi data yang memudahkan pemahaman. Fitur pembaruan data per Kota/Kabupaten kami dirancang untuk memberikan wawasan lokal yang mendalam, mendukung pengawasan pemilu yang efektif.
                                </p>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="/" class="btn btn-primary">Kembali Ke Halaman Utama</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer id="page-footer">
            <?php include realpath(__DIR__ . '/') . '/layout/footer.php'; ?>
        </footer>
        <!--end page-footer-->
    </div>
    <!--end page-wrapper-->
    <a href="#" class="to-top scroll" data-show-after-scroll="600"><i class="arrow_up"></i></a>
    <?php include realpath(__DIR__ . '/') . '/layout/script.php'; ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("loadingIndicator").style.display = 'none';
        });
    </script>
</body>