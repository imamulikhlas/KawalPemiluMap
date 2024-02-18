<?php

// Atur zona waktu ke Jakarta
date_default_timezone_set('Asia/Jakarta');

// Tentukan lokasi dan nama file data gabungan
$combinedDataFile = 'bantukawalpemilu.online/data/data-prov-kawalpemilu.json';

// URL API KawalPemilu
$url = "https://kp24-fd486.et.r.appspot.com/h?id="; // Tambahkan ID yang sesuai jika diperlukan

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
$result = fetchApiData($url);

// Decode data JSON menjadi array
$resultArray = json_decode($result, true);

// Tambahkan timestamp ke dalam array
$resultArray['timestamp'] = date('Y-m-d H:i:s'); // Timestamp dalam waktu lokal Jakarta

// Simpan data gabungan dan timestamp ke file JSON
file_put_contents($combinedDataFile, json_encode($resultArray));

?>
