<?php
date_default_timezone_set('Asia/Jakarta');
// Tentukan lokasi dan nama file data gabungan
$combinedDataFile = 'bantukawalpemilu.online/data/data-city-kawalpemilu.json';
$dataFile = 'bantukawalpemilu.online/data/data-prov-kpu.json'; // File sumber data kode provinsi

// Fungsi untuk melakukan request ke API dan mengembalikan data
function fetchApiData($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true); // Decode dan kembalikan sebagai array
}

// Baca dan ekstrak daftar kode provinsi dari data-kpu.json
$dataContents = file_get_contents($dataFile);
$dataArray = json_decode($dataContents, true);
$provinceIds = array_keys($dataArray['table']); // Dapatkan daftar kode provinsi

// Array untuk menyimpan data gabungan
$combinedData = [];

foreach ($provinceIds as $id) {
    $url = "https://kp24-fd486.et.r.appspot.com/h?id=$id";
    $data = fetchApiData($url);
    if (!empty($data) && isset($data['result']['aggregated'])) {
        // Langsung gabungkan data berdasarkan ID lokasi
        foreach ($data['result']['aggregated'] as $locId => $entries) {
            if (!isset($combinedData[$locId])) {
                $combinedData[$locId] = [];
            }
            // Asumsikan struktur data dari setiap API konsisten dan dapat langsung digabungkan
            $combinedData[$locId] = array_merge($combinedData[$locId], $entries);
        }
    }
}

// Tambahkan timestamp ke dalam data gabungan
$combinedData['timestamp'] = date('c'); // Format ISO 8601

// Simpan data gabungan dan timestamp ke file JSON
file_put_contents($combinedDataFile, json_encode($combinedData));

// Siapkan data untuk digunakan dalam JavaScript dan PHP lainnya
$jsonData = json_encode($combinedData);

?>
