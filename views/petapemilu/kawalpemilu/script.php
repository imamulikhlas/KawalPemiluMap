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

    // Fungsi untuk kembali ke lokasi awal
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
            controlDiv.onclick = kembaliKeAwal;
            return controlDiv;
        }
    });

    map.addControl(new kustomControl());

    // Data pemilu diperoleh dari PHP untuk provinsi
    var hasilPemiluProvinsi = JSON.parse('<?php echo $jsonDataProv; ?>');

    // Data pemilu untuk kota akan diinisialisasi ketika mode diubah
    var hasilPemiluKota = JSON.parse('<?php echo $jsonDataKota; ?>');

    // Variabel untuk menyimpan layer aktif dan mode saat ini
    var activeLayer;
    var currentMode = 'provinsi'; // Mode awal

    // Fungsi untuk mengganti mode dan memperbarui peta
    function toggleMode() {
        // Tampilkan elemen loading
        document.getElementById('loading').style.display = 'block';

        if (currentMode === 'provinsi') {
            currentMode = 'kota';
            modeToggleButton.innerHTML = 'LIHAT PER PROV';
            // Menghapus legenda
            if (window.legend) {
                map.removeControl(window.legend);
                window.legend = null;
            }
            // Memperbarui peta dengan data kota (tanpa legenda)
            updateMap('/geojson/indonesia-city1001.geojson', hasilPemiluKota)
        } else {
            currentMode = 'provinsi';
            modeToggleButton.innerHTML = 'LIHAT PER KOTA';
            // Menghapus legenda
            if (window.legend) {
                map.removeControl(window.legend);
                window.legend = null;
            }
            updateMap('/geojson/indonesia-prov1001.geojson', hasilPemiluProvinsi)
        }
    }

    function getColor(data) {
        if (!data) return 'grey'; // Jika tidak ada data, kembalikan warna abu-abu
        var pas1 = data.pas1 || 0;
        var pas2 = data.pas2 || 0;
        var pas3 = data.pas3 || 0;

        // Jika semua paslon memiliki suara 0, kembalikan warna abu-abu
        if (pas1 === 0 && pas2 === 0 && pas3 === 0) {
            return 'grey';
        }

        // Tentukan paslon dengan suara terbanyak
        var max = Math.max(pas1, pas2, pas3);
        if (max === pas1) return 'orange'; // Warna untuk paslon 1
        if (max === pas2) return 'blue'; // Warna untuk paslon 2
        if (max === pas3) return 'red'; // Warna untuk paslon 3
        return 'grey'; // Default jika ada kondisi lain yang tidak terpenuhi
    }

    // Fungsi untuk menonjolkan (highlight) fitur saat mouseover
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

    // Fungsi untuk mereset penonjolan (highlight) fitur saat mouseout
    function resetHighlight(e) {
        activeLayer.resetStyle(e.target);
    }
    
    // Fungsi untuk memperbarui peta berdasarkan mode saat ini
    function updateMap(geojsonPath, data) {
        if (activeLayer) {
            map.removeLayer(activeLayer);
        }

        fetch(geojsonPath)
            .then(function(response) {
                return response.json();
            })
            .then(function(json) {
                activeLayer = L.geoJson(json, {
                    style: function(feature) {
                        var kode = currentMode === 'provinsi' ? feature.properties.kode.toString() : feature.properties.CC_2.toString();
                        var dataItem = (currentMode === 'provinsi' ? data[kode] : data[kode]) || [];
                        var warna = dataItem.length > 0 ? getColor(dataItem[0]) : 'grey';
                        return {
                            color: 'white',
                            weight: 1,
                            fillColor: warna,
                            fillOpacity: 0.8
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        //Call Hover
                        layer.on({
                            mouseover: highlightFeature,
                            mouseout: resetHighlight
                        });

                        var kode = currentMode === 'provinsi' ? feature.properties.kode.toString() : feature.properties.CC_2.toString();
                        var dataProvinsi = (currentMode === 'provinsi' ? data[kode] : data[kode]) || [];

                        if (dataProvinsi.length > 0) {
                            var dataProvinsiItem = dataProvinsi[0];
                            if (dataProvinsiItem.pas1 + dataProvinsiItem.pas2 + dataProvinsiItem.pas3 === 0) {
                                var infoPemilu = "Data belum tersedia";
                                layer.bindTooltip(feature.properties.Propinsi || feature.properties.NAME_2);
                                layer.bindPopup(`<strong style="font-size:16px !important;">${feature.properties.Propinsi || feature.properties.NAME_2}</strong><br>${infoPemilu}`);
                            } else {
                                // Menghitung total suara di provinsi atau kota
                                var totalSuara = dataProvinsiItem.pas1 + dataProvinsiItem.pas2 + dataProvinsiItem.pas3;

                                // Menghitung persentase untuk setiap paslon
                                var persenPas1 = ((dataProvinsiItem.pas1 / totalSuara) * 100).toFixed(2);
                                var persenPas2 = ((dataProvinsiItem.pas2 / totalSuara) * 100).toFixed(2);
                                var persenPas3 = ((dataProvinsiItem.pas3 / totalSuara) * 100).toFixed(2);

                                var totalTps = dataProvinsiItem.totalTps;
                                var totalCompletedTps = dataProvinsiItem.totalCompletedTps;

                                // Menghitung persentase TPS yang telah selesai
                                var totalPersenSuara = (totalCompletedTps / totalTps) * 100;
                                totalPersenSuara = totalTps > 0 ? totalPersenSuara.toFixed(2) : 0;

                                var infoPemilu = `
                            <div class="container">
                                <!-- Paslon 1: ANIES - MUHAIMIN -->
                                <div class="row align-items-center mt-2 mb-3">
                                    <div class="col-auto">
                                        <img src="/assets/img/amin.webp" alt="Logo Paslon 1" style="width: 50px; height: 50px;">
                                    </div>
                                    <div class="col">
                                        <strong>ANIES - MUHAIMIN:</strong> ${formatNumber(dataProvinsiItem.pas1)} (${persenPas1}%)
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
                                        <strong>PRABOWO - GIBRAN:</strong> ${formatNumber(dataProvinsiItem.pas2)} (${persenPas2}%)
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
                                        <strong>GANJAR - MAHFUD:</strong> ${formatNumber(dataProvinsiItem.pas3)} (${persenPas3}%)
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar" role="progressbar" style="width: ${persenPas3}%; background-color: red;" aria-valuenow="${persenPas3}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;

                                layer.bindTooltip(feature.properties.Propinsi || feature.properties.NAME_2);
                                layer.bindPopup(`
                                <strong style="font-size:16px !important;">${feature.properties.Propinsi || feature.properties.NAME_2}</strong>
                                <div class="progress mt-2 mb-3" style="height: 20px; position: relative; overflow: visible;">
                                    <div class="progress-bar" role="progressbar" style="border-radius: .25rem; width: ${totalPersenSuara}%; background-color: green;" aria-valuenow="${totalPersenSuara}" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div style="position: absolute; width: 100%; text-align: center; font-weight: bold; color: white; height: 20px; line-height: 20px; top: 0; text-shadow: -1px -1px 0 #000000, 1px -1px 0 #000000, -1px 1px 0 #000000, 1px 1px 0 #000000;">
                                        ${totalPersenSuara}% Suara Masuk
                                    </div>
                                </div>
                                ${infoPemilu}`);
                            }
                        }
                    }
                }).addTo(map);

                // Tampilkan legenda hanya untuk mode 'provinsi'
                showLegend(data);

                initializeSearchControl(activeLayer);
                document.getElementById('loading').style.display = 'none';

            });

    }

    var searchControl;

    function initializeSearchControl(layer) {
        if (searchControl) {
            map.removeControl(searchControl);
        }

        searchControl = new L.Control.Search({
            layer: layer,
            position: 'topright',
            propertyName: currentMode === 'provinsi' ? 'Propinsi' : 'NAME_2',
            initial: false,
            moveToLocation: function(latlng, title, map) {
                map.flyTo(latlng, 10, {
                    animate: true,
                    duration: 0.5
                });

                map.once('zoomend', function() {
                    // Temukan layer yang cocok berdasarkan judul (nama) yang dipilih
                    var matchingLayer = layer.getLayers().find(function(layer) {
                        return layer.feature.properties[currentMode === 'provinsi' ? 'Propinsi' : 'NAME_2'] === title;
                    });

                    // Jika layer yang cocok ditemukan, buka popupnya
                    if (matchingLayer) {
                        if (matchingLayer.openPopup) {
                            matchingLayer.openPopup();
                        }
                    }
                });
            }
        }).addTo(map);
    }

    // Menambahkan control untuk mengganti mode
    var modeToggleControl = L.Control.extend({
        options: {
            position: 'topright'
        },
        onAdd: function(map) {
            var controlDiv = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
            controlDiv.innerHTML = '<button id="modeToggleButton" onclick="toggleMode()" style="background-color: #fff; border: none; cursor: pointer; width: 80px; height: 40px;">LIHAT PER KOTA</button>';
            controlDiv.title = "Ganti Mode Tampilan";
            return controlDiv;
        }
    });

    map.addControl(new modeToggleControl());

    // Memanggil fungsi updateMap untuk memuat mode awal dengan data provinsi
    updateMap('/geojson/indonesia-prov1001.geojson', hasilPemiluProvinsi);

    //legend Luar Negri
    function showLegend(data) {
        var legend = L.control({
            position: 'bottomright'
        });

        legend.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'card p-2 info legend');

            if (currentMode === 'provinsi') {
                // Mode Provinsi: Tampilkan legenda dengan data
                var overseasData = data[99] ? data[99] : null;
                if (overseasData) {
                    var pas1Formatted = formatNumber(overseasData[0].pas1);
                    var pas2Formatted = formatNumber(overseasData[0].pas2);
                    var pas3Formatted = formatNumber(overseasData[0].pas3);

                    var warnaPas1 = 'orange';
                    var warnaPas2 = 'blue';
                    var warnaPas3 = 'red';

                    div.innerHTML += `<b class="mb-2">LUAR NEGERI</b><div class="legend-item"><span class="legend-color" style="background-color: ${warnaPas1};"></span><b>ANIES - MUHAIMIN: ${pas1Formatted} Suara</b></div>`;
                    div.innerHTML += `<div class="legend-item"><span class="legend-color" style="background-color: ${warnaPas2};"></span><b>PRABOWO - GIBRAN: ${pas2Formatted} Suara</b></div>`;
                    div.innerHTML += `<div class="legend-item"><span class="legend-color" style="background-color: ${warnaPas3};"></span><b>GANJAR - MAHFUD: ${pas3Formatted} Suara</b></div>`;
                }
            } else {
                div.innerHTML += `<div class="legend-item"><span class="legend-color" style="background-color: orange;"></span><b>ANIES - MUHAIMIN</b></div>`;
                div.innerHTML += `<div class="legend-item"><span class="legend-color" style="background-color: blue;"></span><b>PRABOWO - GIBRAN</b></div>`;
                div.innerHTML += `<div class="legend-item"><span class="legend-color" style="background-color: red;"></span><b>GANJAR - MAHFUD</b></div>`;
            }

            return div;
        };

        window.legend = legend;
        legend.addTo(map);
    }



    function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>

<!-- Hitung Persentase Suara Masuk -->
<script>
    // Fungsi untuk menghitung dan menampilkan persentase
    function calculateAndDisplayTotalPercentage(data) {
        let totalTps = 0;
        let totalCompletedTps = 0;
        let totalPas1 = 0;
        let totalPas2 = 0;
        let totalPas3 = 0;

        // Iterasi melalui semua entri di 'aggregated'
        for (const key in data.aggregated) {
            if (data.aggregated.hasOwnProperty(key)) {
                const locations = data.aggregated[key];
                locations.forEach(location => {
                    totalTps += location.totalTps;
                    totalCompletedTps += location.totalCompletedTps;
                    totalPas1 += location.pas1;
                    totalPas2 += location.pas2;
                    totalPas3 += location.pas3;
                });
            }
        }

        let totalVotes = totalPas1 + totalPas2 + totalPas3;

        // Hitung persentase
        const percentagePas1 = (totalPas1 / totalVotes) * 100;
        const percentagePas2 = (totalPas2 / totalVotes) * 100;
        const percentagePas3 = (totalPas3 / totalVotes) * 100;

        document.getElementById('progressBarPas1').style.width = `${percentagePas1.toFixed(2)}%`;
        document.getElementById('progressBarPas1').innerText = `${percentagePas1.toFixed(2)}%`;

        document.getElementById('progressBarPas2').style.width = `${percentagePas2.toFixed(2)}%`;
        document.getElementById('progressBarPas2').innerText = `${percentagePas2.toFixed(2)}%`;

        document.getElementById('progressBarPas3').style.width = `${percentagePas3.toFixed(2)}%`;
        document.getElementById('progressBarPas3').innerText = `${percentagePas3.toFixed(2)}%`;

        // Hitung persentase dan tampilkan hasil
        const percentage = (totalCompletedTps / totalTps) * 100;
        document.getElementById('percentageOutput').innerHTML = `${percentage.toFixed(2)}%`;

        // Update DOM untuk totalPas1, totalPas2, dan totalPas3
        document.querySelectorAll('.totalPas1').forEach(element => {
            element.innerHTML = `${totalPas1.toLocaleString('id-ID')}`;
        });
        document.querySelectorAll('.totalPas2').forEach(element => {
            element.innerHTML = `${totalPas2.toLocaleString('id-ID')}`;
        });
        document.querySelectorAll('.totalPas3').forEach(element => {
            element.innerHTML = `${totalPas3.toLocaleString('id-ID')}`;
        });

        // Total Suara
        document.getElementById('totalSuara').innerHTML = `${totalVotes.toLocaleString('id-ID')}`;

        // Mengembalikan nilai totalPas1, totalPas2, dan totalPas3
        return {
            totalPas1,
            totalPas2,
            totalPas3
        };
    }

    // Memuat data dari file JSON dan menjalankan fungsi penghitungan
    const dataProvinsi = <?php echo $resultProvinsi; ?>;
    const totals = calculateAndDisplayTotalPercentage(dataProvinsi.result);
    updatePieChart(totals);

    // Fungsi untuk mengupdate chart pie
    function updatePieChart(totals) {
        var ctx = document.getElementById('suaraPaslonPieChart').getContext('2d');
        var suaraPaslonPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Anies-Muhaimin', 'Prabowo-Gibran', 'Ganjar-Mahfud'],
                datasets: [{
                    label: 'Jumlah Suara',
                    data: [totals.totalPas1, totals.totalPas2, totals.totalPas3],
                    backgroundColor: ['orange', 'blue', 'red'],
                    borderColor: ['rgba(255, 255, 255, 1)', 'rgba(255, 255, 255, 1)', 'rgba(255, 255, 255, 1)'],
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
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("loadingIndicator").style.display = 'none';
    });
</script>