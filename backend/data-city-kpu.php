<?php
date_default_timezone_set('Asia/Jakarta');
// Tentukan lokasi dan nama file data gabungan
$combinedDataFile = 'data/data-city-kpu.json';
$dataFile = 'data/data-prov-kpu.json'; // File sumber data kode provinsi

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

// Baca dan ekstrak data baru dari file JSON
$dataContents = file_get_contents($dataFile);
$dataArray = json_decode($dataContents, true);

// Array untuk menyimpan data gabungan
$combinedData = [];

// Iterasi melalui dataArray untuk mendapatkan data dari setiap lokasi
foreach ($dataArray as $item) {
    $url = "https://sirekap-obj-data.kpu.go.id/wilayah/pemilu/ppwp/" . $item['id'] . '.json'; // URL API disesuaikan
    $data = fetchApiData($url);
    if (!empty($data)) {
        // Gunakan 'kode' sebagai key untuk mengidentifikasi data unik dari setiap lokasi
        $kode = $item['kode'];
        if (!isset($combinedData[$kode])) {
            $combinedData[$kode] = [];
        }
        // Asumsikan struktur data dari API konsisten dan dapat langsung digabungkan
        $combinedData[$kode][] = $data;
    }
}

// Tambahkan timestamp ke dalam data gabungan
$combinedData['timestamp'] = date('c'); // Format ISO 8601

// Simpan data gabungan dan timestamp ke file JSON
file_put_contents($combinedDataFile, json_encode($combinedData));

// Siapkan data untuk digunakan dalam JavaScript dan PHP lainnya
$jsonData = json_encode($combinedData);

?>