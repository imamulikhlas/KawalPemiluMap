<?php
// Mendapatkan path dari URL dan menghapus trailing slash
$currentPath = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
?>

<nav>
    <div class="text-center">
        <h3 class="font-weight-bold">
            <a href="/">PETA SEBARAN SUARA PEMILU 2024 </a>
            <img src="/assets/img/favicon/favicon-32x32.png" alt="Icon" style="max-width: 20px; max-height: 20px; vertical-align: middle; margin-right: 5px; margin-bottom:4px;">
        </h3>
        <div class="primary-nav has-mega-menu" style="border-right:0px !important;">
            <ul class="navigation">
                <li>
                    <a class="<?php echo ($currentPath == '/petapemilu/kpu' ? 'btn btn-danger rounded btn-xs' : 'btn btn-secondary rounded btn-xs'); ?>" href="/petapemilu/kpu">
                        <img src="/assets/img/logokpu.png" alt="Icon" style="max-width: 20px; max-height: 20px; vertical-align: middle; margin-right: 5px;">
                        KPU
                    </a>
                </li>
                <li>
                    <a class="<?php echo ($currentPath == '/petapemilu/kawalpemilu' ? 'btn btn-danger rounded btn-xs' : 'btn btn-secondary rounded btn-xs'); ?>" href="/petapemilu/kawalpemilu">
                        <img src="/assets/img/logokawalpemilu.png" alt="Icon" style="max-width: 20px; max-height: 20px; vertical-align: middle; margin-right: 5px; background-color: white; border-radius: .5rem; ">
                        Kawal Pemilu
                    </a>
                </li>
                <li>
                    <a class="<?php echo ($currentPath == '/petapemilu/kawalamin' ? 'btn btn-danger rounded btn-xs' : 'btn btn-secondary rounded btn-xs'); ?>" href="/petapemilu/kawalamin">
                        <img src="/assets/img/amin.webp" alt="Icon" style="max-width: 20px; max-height: 20px; vertical-align: middle; margin-right: 5px; background-color: white; border-radius: .5rem; ">
                        KawalAmin
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
