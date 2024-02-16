<?php
// API URL for POST request
$url = "https://redash.estehtawar.online/api/queries/5/results";

// Data payload for POST request
$data = json_encode([
    "id" => 5,
    "parameters" => new stdClass() // Empty object for parameters
]);

// Initialize cURL session
$ch = curl_init($url);

// Set cURL options for POST request
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Key t2oVzFSSkDotlscXE0JZWd2pFciMSyyUAV9ZBPmj',
    'Content-Type: application/json'
]);

// Execute cURL session
$result = curl_exec($ch);

// Check for errors and handle the error case
if(curl_errno($ch))
{
    echo 'Curl error: ' . curl_error($ch);
}

// Decode JSON response
$resultArray = json_decode($result, true);

// Close cURL session
curl_close($ch);

// Prepare data for use in JavaScript (if needed)
$jsonData = json_encode($resultArray);

// Optionally, you can echo or use $jsonData as needed
// echo $jsonData;
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

    // Contoh: Menampilkan data ts, psu, dan chart pada konsol
    console.log('Timestamp:', hasilPemilu);

    
    // function getColor(data) {
    // if (!data) return 'gray'; 
    // var pas1 = data['100025']; 
    // var pas2 = data['100026'];
    // var pas3 = data['100027'];
    // var max = Math.max(pas1, pas2, pas3);
    // if (max === pas1) return 'orange';
    // if (max === pas2) return 'blue';
    // return 'red';
    // }

    // fetch('geojson/indonesia-prov.geojson')
    // .then(function(response) { return response.json(); })
    // .then(function(json) {
    //     L.geoJson(json, {
    //         style: function(feature) {
    //             var kodeProvinsi = feature.properties.kode.toString();
    //             var warna = 'gray'; 
    //             if (hasilPemilu.table[kodeProvinsi]) {
    //                 var dataProvinsi = hasilPemilu.table[kodeProvinsi];
    //                 warna = getColor(dataProvinsi); 
    //             }
                
    //             return {
    //                 color: 'white', 
    //                 weight: 1,
    //                 fillColor: warna, 
    //                 fillOpacity: 0.8 
    //             };
    //         },
    //         onEachFeature: function(feature, layer) {
    //             var kodeProvinsi = feature.properties.kode.toString();
    //             var data = hasilPemilu.table[kodeProvinsi];
    //             if (data) {
                    
    //                 var pas1Formatted = formatNumber(data['100025']);
    //                 var pas2Formatted = formatNumber(data['100026']);
    //                 var pas3Formatted = formatNumber(data['100027']);

    //                 // Menambahkan tag img untuk logo paslon
    //                 var logoPaslon1 = `<img src="img/amin.webp" class="mt-3 mb-3 mr-2" alt="Logo Paslon 1" style="width: 50px; height: 50px;">`;
    //                 var logoPaslon2 = `<img src="img/pragib.webp" class="mb-3 mr-2" alt="Logo Paslon 2" style="width: 50px; height: 45px;">`;
    //                 var logoPaslon3 = `<img src="img/gamud.webp" class="mb-3 mr-2" alt="Logo Paslon 3" style="width: 50px; height: 50px;">`;

    //                 // Memasukkan tag img ke dalam infoPemilu
    //                 var infoPemiluWithLogo = `<b>${logoPaslon1} ANIES - MUHAIMIN: ${pas1Formatted} Suara<br>${logoPaslon2} PRABOWO - GIBRAN: ${pas2Formatted} Suara<br>${logoPaslon3} GANJAR - MAHFUD: ${pas3Formatted} Suara</b>`;

    //                 layer.bindTooltip(feature.properties.Propinsi);
    //                 // Menggunakan infoPemiluWithLogo sebagai konten popup
    //                 layer.bindPopup(`<strong>${feature.properties.Propinsi}</strong><br>${infoPemiluWithLogo}`);
    //             }
    //         }

    //     }).addTo(map);
    // });

    // // Add a legend for overseas data
    // var overseasData = hasilPemilu["table"]["99"] ? hasilPemilu["table"]["99"] : null;
    // if (overseasData) {
    //     var legend = L.control({position: 'bottomright'});

    //     legend.onAdd = function (map) {
    //         var div = L.DomUtil.create('div', 'card p-2 info legend');

    //         var pas1Formatted = formatNumber(overseasData["100025"]);
    //         var pas2Formatted = formatNumber(overseasData["100026"]);
    //         var pas3Formatted = formatNumber(overseasData["100027"]);

    //         div.innerHTML += `<p class="mb-0"><b>LUAR NEGERI</b><br>ANIES - MUHAIMIN: ${pas1Formatted} Suara<br>PRABOWO - GIBRAN: ${pas2Formatted} Suara<br>GANJAR - MAHFUD: ${pas3Formatted} Suara</p>`;
    //         return div;
    //     };

    //     legend.addTo(map);
    // }


    // function formatNumber(number) {
    //     return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    // }
</script>

</body>
</html>
