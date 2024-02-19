<?php
date_default_timezone_set('Asia/Jakarta');
// Tentukan lokasi dan nama file data gabungan
$combinedDataFile = 'bantukawalpemilu.online/data/data-prov-kpu.json';
$dataFile = 'https://sirekap-obj-data.kpu.go.id/pemilu/hhcw/ppwp.json'; // URL File sumber data kode provinsi

// Fungsi untuk melakukan request ke API dan mengembalikan data
function fetchApiData($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

// Lakukan request ke API
$result = fetchApiData($dataFile);

// Decode data JSON menjadi array
$resultArray = json_decode($result, true);

// Tambahkan timestamp ke dalam array
$resultArray['timestamp'] = date('Y-m-d\TH:i:sP'); // Format ISO 8601 dengan zona waktu Jakarta

// Simpan data gabungan dan timestamp ke file JSON
file_put_contents($combinedDataFile, json_encode($resultArray));
