<?php
date_default_timezone_set('Asia/Jakarta');
$dataFile = 'kawalamin.json'; // Ganti dengan lokasi sebenarnya dari file JSON Anda
$combinedDataFile = '../../data/1.json';

// Membaca data dari file JSON
$jsonData = file_get_contents($dataFile);
if ($jsonData === false) {
    die("Error reading JSON file");
}

// Decode JSON data menjadi array
$dataArray = json_decode($jsonData, true);
if ($dataArray === null) {
    die("Error decoding JSON");
}

$provinceMapping = [
    "11" => "ACEH",
    "12" => "SUMATERA UTARA",
    "13" => "SUMATERA BARAT",
    "14" => "RIAU",
    "15" => "JAMBI",
    "16" => "SUMATERA SELATAN",
    "17" => "BENGKULU",
    "18" => "LAMPUNG",
    "19" => "KEPULAUAN BANGKA BELITUNG",
    "21" => "KEPULAUAN RIAU",
    "31" => "DKI JAKARTA",
    "32" => "JAWA BARAT",
    "33" => "JAWA TENGAH",
    "34" => "DI YOGYAKARTA",
    "35" => "JAWA TIMUR",
    "36" => "BANTEN",
    "51" => "BALI",
    "52" => "NUSA TENGGARA BARAT",
    "53" => "NUSA TENGGARA TIMUR",
    "61" => "KALIMANTAN BARAT",
    "62" => "KALIMANTAN TENGAH",
    "63" => "KALIMANTAN SELATAN",
    "64" => "KALIMANTAN TIMUR",
    "65" => "KALIMANTAN UTARA",
    "71" => "SULAWESI UTARA",
    "72" => "SULAWESI TENGAH",
    "73" => "SULAWESI SELATAN",
    "74" => "SULAWESI TENGGARA",
    "75" => "GORONTALO",
    "76" => "SULAWESI BARAT",
    "81" => "MALUKU",
    "82" => "MALUKU UTARA",
    "91" => "PAPUA",
    "92" => "PAPUA BARAT",
    "93" => "PAPUA SELATAN",
    "94" => "PAPUA TENGAH",
    "95" => "PAPUA PEGUNUNGAN",
    "96" => "PAPUA BARAT DAYA",
];
// Memproses data sebelum menyimpannya
$processedData = [
    'table' => []
];

foreach ($dataArray['query_result']['data']['rows'] as $row) {
    // Memeriksa apakah semua nama (p1_name, p2_name, p3_name) bukan null
    if ($row['p1_name'] !== null || $row['p2_name'] !== null || $row['p3_name'] !== null) {
        foreach ($provinceMapping as $code => $name) {
            if (strtoupper($row['province']) === strtoupper($name)) {
                // Menyimpan data menggunakan kode provinsi sebagai kunci jika nama provinsi cocok
                $processedData['table'][$code] = $row;
                break; // Keluar dari loop jika sudah menemukan dan menyimpan data
            }
        }
    }
}

// Menambahkan timestamp
$processedData['timestamp'] = date('Y-m-d\TH:i:sP');

// Menyimpan data yang sudah diproses ke dalam file JSON, menimpa data yang sudah ada
file_put_contents($combinedDataFile, json_encode($processedData));
?>
