// js/script.js
document.addEventListener('DOMContentLoaded', function() {
    var map = L.map('mapid').setView([-2.548926, 118.0148634], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    fetch('data/pemilu.json')
        .then(response => response.json())
        .then(data => {
            Object.values(data.result.aggregated).forEach(provinsi => {
                var item = provinsi[0];
                var latLng = getLatLngByProvinsi(item.name);
                if (latLng) { // Pastikan koordinat ditemukan
                    var marker = L.marker(latLng).addTo(map);
                    marker.bindPopup(`<b>${item.name}</b><br>Paslon 1: ${item.pas1}<br>Paslon 2: ${item.pas2}<br>Paslon 3: ${item.pas3}`);
                }
            });
        })
        .catch(err => console.log(err));
});

function getLatLngByProvinsi(provinsiName) {
    // Contoh koordinat, perlu diisi dengan data sesungguhnya
    var coords = {
        'ACEH': [4.695135, 96.7493993],
        'SUMATERA UTARA': [2.1153547, 99.5450974],
        'SUMATERA BARAT': [-0.7399397, 100.8000051],
        // Tambahkan lebih banyak koordinat provinsi di sini
    };
    return coords[provinsiName.toUpperCase()] || null;
}
