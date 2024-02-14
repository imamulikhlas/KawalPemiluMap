<?php
// URL API
$url = "https://us-central1-kp24-fd486.cloudfunctions.net/hierarchy2";

// Data yang akan dikirim melalui POST
$data = array("data" => array("id" => ""));
$data_string = json_encode($data);

// Setup cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
);

// Execute cURL, fetch the JSON data, decode it into an array, and then close the cURL session
$result = curl_exec($ch);
$resultArray = json_decode($result, true);
curl_close($ch);

// Prepare data for use in JavaScript
$jsonData = json_encode($resultArray['result']['aggregated']);
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
    <h2>KAWAL PEMILU 2024 - #BANTUMENGAWAL</h2>
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

    function getColor(data) {
        if (!data) return 'gray'; 
        var pas1 = data.pas1, pas2 = data.pas2, pas3 = data.pas3;
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
                    if (hasilPemilu[kodeProvinsi] && hasilPemilu[kodeProvinsi].length > 0) {
                        var dataProvinsi = hasilPemilu[kodeProvinsi][0];
                        warna = getColor(dataProvinsi);
                    }
                    return {color: warna, weight: 2, fillOpacity: 0.8};
                },
                onEachFeature: function(feature, layer) {
                    var kodeProvinsi = feature.properties.kode.toString();
                    var data = hasilPemilu[kodeProvinsi] ? hasilPemilu[kodeProvinsi][0] : null;
                    if (data) {
                        // Menambahkan tag img untuk logo paslon
                        var logoPaslon1 = `<img src="img/amin.webp" class="mt-3 mb-3 mr-2" alt="Logo Paslon 1" style="width: 50px; height: 50px;">`;
                        var logoPaslon2 = `<img src="img/pragib.webp" class="mb-3 mr-2" alt="Logo Paslon 2" style="width: 50px; height: 45px;">`;
                        var logoPaslon3 = `<img src="img/gamud.webp" class="mb-3 mr-2" alt="Logo Paslon 3" style="width: 50px; height: 50px;">`;
                        
                        // Memasukkan tag img ke dalam infoPemilu
                        var infoPemiluWithLogo = `<b>${logoPaslon1} ANIES - MUHAIMIN: ${data.pas1} Suara<br>${logoPaslon2} PRABOWO - GIBRAN: ${data.pas2} Suara<br>${logoPaslon3} GANJAR - MAHFUD: ${data.pas3} Suara</b>`;
                        
                        layer.bindTooltip(feature.properties.Propinsi);
                        // Menggunakan infoPemiluWithLogo sebagai konten popup
                        layer.bindPopup(`<strong>${feature.properties.Propinsi}</strong><br>${infoPemiluWithLogo}`);
                    }
                }

            }).addTo(map);
        });

    // Add a legend for overseas data
    var overseasData = hasilPemilu["99"] ? hasilPemilu["99"][0] : null;
    if (overseasData) {
        var legend = L.control({position: 'bottomright'});

        legend.onAdd = function (map) {
            var div = L.DomUtil.create('div', 'card p-2 info legend');
            div.innerHTML += `<p class="mb-0"><b>LUAR NEGERI</b><br>ANIES - MUHAIMIN: ${overseasData.pas1} Suara<br>PRABOWO - GIBRAN: ${overseasData.pas2} Suara<br>GANJAR - MAHFUD: ${overseasData.pas3} Suara</p>`;
            return div;
        };

        legend.addTo(map);
    }
</script>

</body>
</html>
