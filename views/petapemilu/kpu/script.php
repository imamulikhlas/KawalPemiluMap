<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet-search/dist/leaflet-search.min.js"></script>

<!-- Donation -->
<script>
    function loadDonations() {
        fetch('<?php echo $dataDonation; ?>')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('donations-container');
                // Start a new row
                let cardsRow = '<div class="row">';
                data.forEach((donation, index) => {
                    cardsRow += `
                            <div class="col-md-4 mb-4">
                                <div class="card shadow h-100">
                                    <div class="card-body">
                                        <h5 class="card-title badge badge-success" style="font-size: 18px;">👑 ${donation.name}</h5>
                                        <p class="card-text">Mendukung: <b>Rp ${donation.donation} 💸</b></p>
                                    </div>
                                </div>
                            </div>
                        `;
                });
                cardsRow += '</div>'; // Close the row
                container.innerHTML = cardsRow; // Insert the row of cards into the container
            })
            .catch(console.error);
    }
    // Load donations immediately and then every 15 seconds
    loadDonations();
    setInterval(loadDonations, 15000);
</script>

<!-- Peta -->
<script>
    // Lokasi awal dan zoom level
    var awalLokasi = [-2.548926, 118.0148634];
    var awalZoom = 5;

    var map = L.map('mapid', {
        fullscreenControl: true,
        fullscreenControlOptions: {
            position: 'topleft'
        }
    }).setView(awalLokasi, awalZoom);

    // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    //     attribution: '© OpenStreetMap contributors'
    // }).addTo(map);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/light-v10',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiaW1hbXVsaWtobGFzIiwiYSI6ImNsc3o4bGZ6YTBna3cya282MmVibzR1cjYifQ.oyGiNCtgqbIm4KDozbu4cQ'
    }).addTo(map);

    // Tambahkan fungsi untuk kembali ke lokasi awal
    var kembaliKeAwal = function() {
        map.flyTo(awalLokasi, awalZoom);
    };

    // Membuat control kustom
    var kustomControl = L.Control.extend({
        options: {
            position: 'topleft'
        },

        onAdd: function(map) {
            var controlDiv = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
            controlDiv.innerHTML = '<button style="background-color: #fff; border: none; cursor: pointer; width: 30px; height: 30px; text-align: center;"><i class="fa fa-home"></i></button>';
            controlDiv.title = "Kembali ke awal";
            controlDiv.onclick = function() {
                kembaliKeAwal();
            }
            return controlDiv;
        }
    });

    map.addControl(new kustomControl());

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
        if (!data) return 'grey';
        var pas1 = data['100025'];
        var pas2 = data['100026'];
        var pas3 = data['100027'];
        var max = Math.max(pas1, pas2, pas3);
        if (max === pas1) return 'orange';
        if (max === pas2) return 'blue';
        if (max === pas3) return 'red';
        return 'grey';
    }

    fetch('/geojson/indonesia-prov1001.geojson')
        .then(function(response) {
            return response.json();
        })
        .then(function(json) {
            var geoJsonLayer = L.geoJson(json, {
                style: function(feature) {
                    var kodeProvinsi = feature.properties.kode.toString();
                    var warna = 'gray';
                    if (hasilPemilu.table[kodeProvinsi]) {
                        var dataProvinsi = hasilPemilu.table[kodeProvinsi];
                        warna = getColor(dataProvinsi);
                    }

                    return {
                        color: 'white',
                        weight: 1,
                        fillColor: warna,
                        fillOpacity: 0.8
                    };
                },
                onEachFeature: function(feature, layer) {
                    //HOVER FUNCTION
                    function resetHighlight(e) {
                        geoJsonLayer.resetStyle(e.target);
                    }
                    
                    function highlightFeature(e) {
                        var layer = e.target;

                        layer.setStyle({
                            weight: 3,
                            color: 'white', 
                            dashArray: '',
                            fillOpacity: 1
                        });

                        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                            layer.bringToFront();
                        }
                    }

                    layer.on({
                        mouseover: highlightFeature,
                        mouseout: resetHighlight
                    });
                    //END HOVER STYLE

                    var kodeProvinsi = feature.properties.kode.toString();
                    var dataProvinsi = hasilPemilu.table[kodeProvinsi];
                    if (!dataProvinsi || typeof dataProvinsi['100025'] === 'undefined' || typeof dataProvinsi['100026'] === 'undefined' || typeof dataProvinsi['100027'] === 'undefined' || !dataProvinsi.status_progress) {
                        var infoPemilu = "Data belum tersedia";
                        layer.bindTooltip(feature.properties.Propinsi);
                        layer.bindPopup(`<strong style="font-size:16px !important;">${feature.properties.Propinsi}</strong><br>${infoPemilu}`);
                    } else if (dataProvinsi) {

                        // Menghitung total suara di provinsi
                        var totalSuaraProvinsi = dataProvinsi['100025'] + dataProvinsi['100026'] + dataProvinsi['100027'];
                        var totalPersenSuara = dataProvinsi.persen;

                        // Menghitung persentase untuk setiap paslon
                        var persenPas1 = ((dataProvinsi['100025'] / totalSuaraProvinsi) * 100).toFixed(2);
                        var persenPas2 = ((dataProvinsi['100026'] / totalSuaraProvinsi) * 100).toFixed(2);
                        var persenPas3 = ((dataProvinsi['100027'] / totalSuaraProvinsi) * 100).toFixed(2);

                        // Menambahkan tag img untuk logo paslon
                        var logoPaslon1 = `<img src="/assets/img/amin.webp" class="mt-3 mb-3 mr-2" alt="Logo Paslon 1" style="width: 50px; height: 50px;">`;
                        var logoPaslon2 = `<img src="/assets/img/pragib.webp" class="mb-3 mr-2" alt="Logo Paslon 2" style="width: 50px; height: 45px;">`;

                        var infoPemilu = `
                            <div class="container">
                                <!-- Paslon 1: ANIES - MUHAIMIN -->
                                <div class="row align-items-center my-3">
                                    <div class="col-auto">
                                        <img src="/assets/img/amin.webp" alt="Logo Paslon 1" style="width: 50px; height: 50px;">
                                    </div>
                                    <div class="col">
                                        <strong>ANIES - MUHAIMIN:</strong> ${formatNumber(dataProvinsi['100025'])} (${persenPas1}%)
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar" role="progressbar" style="width: ${persenPas1}%; background-color: orange;" aria-valuenow="${persenPas1}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paslon 2: PRABOWO - GIBRAN -->
                                <div class="row align-items-center my-3">
                                    <div class="col-auto">
                                        <img src="/assets/img/pragib.webp" alt="Logo Paslon 2" style="width: 50px; height: 45px;">
                                    </div>
                                    <div class="col">
                                        <strong>PRABOWO - GIBRAN:</strong> ${formatNumber(dataProvinsi['100026'])} (${persenPas2}%)
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar" role="progressbar" style="width: ${persenPas2}%; background-color: blue;" aria-valuenow="${persenPas2}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paslon 3: GANJAR - MAHFUD -->
                                <div class="row align-items-center my-3">
                                    <div class="col-auto">
                                        <img src="/assets/img/gamud.webp" alt="Logo Paslon 3" style="width: 50px; height: 50px;">
                                    </div>
                                    <div class="col">
                                        <strong>GANJAR - MAHFUD:</strong> ${formatNumber(dataProvinsi['100027'])} (${persenPas3}%)
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar" role="progressbar" style="width: ${persenPas3}%; background-color: red;" aria-valuenow="${persenPas3}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;

                        layer.bindTooltip(feature.properties.Propinsi);
                        layer.bindPopup(`
                            <strong style="font-size:16px !important;">${feature.properties.Propinsi}</strong>
                            <div class="progress mt-2 mb-0" style="height: 20px; position: relative; overflow: visible;">
                                <div class="progress-bar" role="progressbar" style="border-radius: .25rem; width: ${totalPersenSuara}%; background-color: green;" aria-valuenow="${totalPersenSuara}" aria-valuemin="0" aria-valuemax="100"></div>
                                <div style="position: absolute; width: 100%; text-align: center; font-weight: bold; color: white; height: 20px; line-height: 20px; top: 0; text-shadow: -1px -1px 0 #000000, 1px -1px 0 #000000, -1px 1px 0 #000000, 1px 1px 0 #000000;">
                                    ${totalPersenSuara}% Suara Masuk
                                </div>
                            </div>
                            ${infoPemilu}`);
                    }
                }


            }).addTo(map);


            var searchControl = new L.Control.Search({
                layer: geoJsonLayer,
                position: 'topright',
                propertyName: 'Propinsi',
                moveToLocation: function(latlng, title, map) {
                    map.flyTo(latlng, 10, {
                        animate: true,
                        duration: 0.5
                    });

                    map.once('zoomend', function() {
                        var matchingLayer = geoJsonLayer.getLayers().find(function(layer) {
                            return layer.feature.properties.Propinsi === title;
                        });

                        if (matchingLayer) {
                            matchingLayer.fire('click');
                        }
                    });
                }
            });

            searchControl.addTo(map);

        });

    // Add a legend for overseas data
    var overseasData = hasilPemilu["table"]["99"] ? hasilPemilu["table"]["99"] : null;
    if (overseasData) {
        var legend = L.control({
            position: 'bottomright'
        });

        legend.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'card p-2 info legend');

            var pas1Formatted = formatNumber(overseasData["100025"]);
            var pas2Formatted = formatNumber(overseasData["100026"]);
            var pas3Formatted = formatNumber(overseasData["100027"]);

            var warnaPas1 = 'orange';
            var warnaPas2 = 'blue';
            var warnaPas3 = 'red';

            div.innerHTML += `<b class="mb-2">LUAR NEGERI</b><div class="legend-item"><span class="legend-color" style="background-color: ${warnaPas1};"></span><b>ANIES - MUHAIMIN: ${pas1Formatted} Suara</b></div>`;
            div.innerHTML += `<div class="legend-item"><span class="legend-color" style="background-color: ${warnaPas2};"></span><b>PRABOWO - GIBRAN: ${pas2Formatted} Suara</b></div>`;
            div.innerHTML += `<div class="legend-item"><span class="legend-color" style="background-color: ${warnaPas3};"></span><b>GANJAR - MAHFUD: ${pas3Formatted} Suara</b></div>`;

            return div;
        };


        legend.addTo(map);
    }


    function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>

<!-- Pie Chart -->
<script>
    var ctx = document.getElementById('suaraPaslonPieChart').getContext('2d');
    var suaraPaslonPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Anies-Muhaimin', 'Prabowo-Gibran', 'Ganjar-Mahfud'],
            datasets: [{
                label: 'Jumlah Suara',
                data: [
                    <?php echo $resultArray['chart']['100025']; ?>,
                    <?php echo $resultArray['chart']['100026']; ?>,
                    <?php echo $resultArray['chart']['100027']; ?>
                ],
                backgroundColor: [
                    'orange',
                    'blue',
                    'red'
                ],
                borderColor: [
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true
                }
            }
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("loadingIndicator").style.display = 'none';
    });
</script>