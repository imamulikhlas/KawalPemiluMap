<?php
// Inisialisasi cURL session (contoh ini hanya sebagai ilustrasi, sesuaikan URL dan query XPath Anda)
$url = 'https://kawalpemilu.org/';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);

$total = '';
$votes = '';

if ($html) {
    // Membuat DOMDocument dan memuat HTML
    @$dom = new DOMDocument();
    @$dom->loadHTML($html);
    $xpath = new DOMXPath($dom);

    // Sesuaikan XPath berdasarkan struktur HTML yang aktual
    $query = "//th//app-percent//span[@class='fraction ng-star-inserted']";
    $elements = $xpath->query($query);

    if (!is_null($elements) && $elements->length > 0) {
        $element = $elements->item(0); // Mengambil elemen pertama saja untuk contoh
        $text = $element->nodeValue;
        $parts = explode('/', $text);
        $total = trim(end($parts)); // Misal "823,366"
        $votes = trim($parts[0]); // Misal "122,293"
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scrape KawalPemilu</title>
</head>
<body>
    <h1>Hasil Scraping KawalPemilu</h1>
    <p>Total: <?php echo htmlspecialchars($total); ?></p>
    <p>Votes: <?php echo htmlspecialchars($votes); ?></p>
</body>
</html>
