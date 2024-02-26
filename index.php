<?php

// Mendapatkan path dari URL dan menghapus trailing slash
$path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
// echo "Requested path: " . $path . "<br>";

// Jika path kosong, set ke '/'
if (empty($path)) {
    $path = '/';
}

// Routing dengan array mapping
$routes = [
    '/' => '/views/table/index.php',
    '/about' => '/views/about-us.php',
    // '/table' => '/views/table/index.php',
    '/petapemilu/kpu' => '/views/petapemilu/kpu/index.php',
    '/petapemilu/kawalpemilu' => '/views/petapemilu/kawalpemilu/index.php',
    '/petapemilu/kawalamin' => '/views/petapemilu/kawalamin/index.php',
];

// Cetak isi dari routes untuk debugging
// echo "<pre>Routes: ";
// print_r($routes);
// echo "</pre>";

// Cek jika path ada dalam routing array
if (isset($routes[$path])) {
    // echo "Routing to: " . __DIR__ . $routes[$path] . "<br>"; // Untuk debugging
    require __DIR__ . $routes[$path];
} else {
    // Jika tidak ada dalam array, berikan respons 404
    // echo "Path not found, showing 404 page.<br>"; // Untuk debugging
    http_response_code(404);
    // require __DIR__ . '/views/error/404.php';

    header('Location: /');
    exit; 
}
?>
