<?php
date_default_timezone_set('Asia/Jakarta');
$combinedDataFile = 'bantukawalpemilu.online/data/data-prov-kawalamin.json';
$requestUrl = 'https://redash.estehtawar.online/api/queries/5/results';
$authHeader = 'Authorization: Key t2oVzFSSkDotlscXE0JZWd2pFciMSyyUAV9ZBPmj';

function fetchApiData($url, $headers) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }
    curl_close($ch);
    return $result;
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

$headers = [
    $authHeader,
    'Content-Type: application/json',
    'Accept: application/json'
];

try {
    $result = fetchApiData($requestUrl, $headers);
} catch (Exception $e) {
    die("Error fetching API data: " . $e->getMessage());
}

$resultArray = json_decode($result, true);

// Memproses data sebelum menyimpannya
$processedData = [
    'table' => []
];

foreach ($resultArray['query_result']['data']['rows'] as $row) {
    // Hanya menyimpan data jika salah satu nama tidak null
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
