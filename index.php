<?php
// URL API
$url = "https://sirekap-obj-data.kpu.go.id/pemilu/hhcw/ppwp.json";

// Setup cURL untuk GET request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);

// Execute cURL, fetch the JSON data, decode it into an array, and then close the cURL session
$result = curl_exec($ch);
$resultArray = json_decode($result, true);
curl_close($ch);

// Siapkan data untuk digunakan dalam JavaScript
// Disini, Anda bisa memilih untuk langsung mengirimkan seluruh response atau hanya bagian tertentu
$jsonData = json_encode($resultArray);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kawal Pemilu 2024</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-4">
    <div class="text-center">
    <h2>Peta Sebaran Suara - KAWAL PEMILU 2024</h2>
    </div>
    <div id="mapid" style="height: 500px;"></div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js"></script>
<script>
    var map = L.map('mapid', {
        fullscreenControl: true, 
        fullscreenControlOptions: { 
        position: 'topleft'
        }
    }).setView([-2.548926, 118.0148634], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Data pemilu diperoleh dari PHP
    var hasilPemilu = JSON.parse('<?php echo $jsonData; ?>');

    var timestamp = hasilPemilu.ts;
    var psu = hasilPemilu.psu;
    var chartData = hasilPemilu.chart;

    // Contoh: Menampilkan data ts, psu, dan chart pada konsol
    console.log('Timestamp:', timestamp);
    console.log('PSU:', psu);
    console.log('Chart Data:', chartData);

    
    function getColor(data) {
    if (!data) return 'gray'; 
    var pas1 = data['100025']; 
    var pas2 = data['100026'];
    var pas3 = data['100027'];
    var max = Math.max(pas1, pas2, pas3);
    if (max === pas1) return 'orange';
    if (max === pas2) return 'blue';
    return 'red';
    }

    fetch('geojson/indonesia-prov.geojson')
        .then(function(response) { return response.json(); })
        .then(function(json) {
            L.geoJson(json, {
                style: function(feature) {
                    var kodeProvinsi = feature.properties.kode.toString();
                    var warna = 'gray';
                    if (hasilPemilu.table[kodeProvinsi]) {
                        var dataProvinsi = hasilPemilu.table[kodeProvinsi];
                        warna = getColor(dataProvinsi);
                    }
                    return {color: warna, weight: 2, fillOpacity: 0.8};
                },
                onEachFeature: function(feature, layer) {
                    var kodeProvinsi = feature.properties.kode.toString();
                    var data = hasilPemilu.table[kodeProvinsi];
                    if (data) {
                        // Menambahkan tag img untuk logo paslon
                        var logoPaslon1 = `<img src="img/amin.webp" class="mt-3 mb-3 mr-2" alt="Logo Paslon 1" style="width: 50px; height: 50px;">`;
                        var logoPaslon2 = `<img src="img/pragib.webp" class="mb-3 mr-2" alt="Logo Paslon 2" style="width: 50px; height: 45px;">`;
                        var logoPaslon3 = `<img src="img/gamud.webp" class="mb-3 mr-2" alt="Logo Paslon 3" style="width: 50px; height: 50px;">`;
                        
                        // Memasukkan tag img ke dalam infoPemilu
                        var infoPemiluWithLogo = `<b>${logoPaslon1} ANIES - MUHAIMIN: ${data['100025']} Suara<br>${logoPaslon2} PRABOWO - GIBRAN: ${data['100026']} Suara<br>${logoPaslon3} GANJAR - MAHFUD: ${data['100027']} Suara</b>`;
                        
                        layer.bindTooltip(feature.properties.Propinsi);
                        // Menggunakan infoPemiluWithLogo sebagai konten popup
                        layer.bindPopup(`<strong>${feature.properties.Propinsi}</strong><br>${infoPemiluWithLogo}`);
                    }
                }

            }).addTo(map);
        });

    // Add a legend for overseas data
    var overseasData = hasilPemilu["table"]["99"] ? hasilPemilu["table"]["99"] : null;
    if (overseasData) {
        var legend = L.control({position: 'bottomright'});

        legend.onAdd = function (map) {
            var div = L.DomUtil.create('div', 'card p-2 info legend');
            div.innerHTML += `<p class="mb-0"><b>LUAR NEGERI</b><br>ANIES - MUHAIMIN: ${overseasData["100025"]} Suara<br>PRABOWO - GIBRAN: ${overseasData["100026"]} Suara<br>GANJAR - MAHFUD: ${overseasData["100027"]} Suara</p>`;
            return div;
        };

        legend.addTo(map);
    }
</script>

</body>
</html>
