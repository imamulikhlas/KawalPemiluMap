<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        loadDataKpu();
        loadDataKawalPemilu();
        loadDataKawalAmin();

        setInterval(loadDataKpu, 10000); 
        setInterval(loadDataKawalPemilu, 10000); 
        setInterval(loadDataKawalAmin, 10000); 
    });

    function loadDataKpu() {
        $.ajax({
            url: 'https://api2.bantukawalpemilu.online/api/kpu/',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var rows = '';
                var formatter = new Intl.NumberFormat('id-ID');
                var totalP1 = 0; 
                var totalP2 = 0; 
                var totalP3 = 0;

                $.each(data.table, function(key, value) {
                    var wilayah = mapWilayah(key);
                    var suaraTerbanyak = Math.max(value['100025'], value['100026'], value['100027']);

                    // Akumulasi total suara untuk masing-masing paslon
                    totalP1 += value['100025'];
                    totalP2 += value['100026'];
                    totalP3 += value['100027'];

                    // Menentukan kelas untuk menyoroti jumlah suara terbanyak
                    var highlightClassP1 = suaraTerbanyak === value['100025'] ? 'highlight' : '';
                    var highlightClassP2 = suaraTerbanyak === value['100026'] ? 'highlight' : '';
                    var highlightClassP3 = suaraTerbanyak === value['100027'] ? 'highlight' : '';

                    rows += '<tr>' +
                            '<td>' + wilayah + ' <span class="badge badge-success">' + value['persen'] + '%</span>' + '</td>' +
                            `<td class="${highlightClassP1}">${formatter.format(value['100025'])}</td>` +
                            `<td class="${highlightClassP2}">${formatter.format(value['100026'])}</td>` +
                            `<td class="${highlightClassP3}">${formatter.format(value['100027'])}</td>` +
                            '</tr>';
                });
                var maxTotal = Math.max(totalP1, totalP2, totalP3);

                var highlightClassP1 = totalP1 === maxTotal ? 'highlight' : '';
                var highlightClassP2 = totalP2 === maxTotal ? 'highlight' : '';
                var highlightClassP3 = totalP3 === maxTotal ? 'highlight' : '';

                rows += `<tr class="font-weight-bold">
                            <td>Total Suara</td>
                            <td class="${highlightClassP1}">${formatter.format(totalP1)}</td>
                            <td class="${highlightClassP2}">${formatter.format(totalP2)}</td>
                            <td class="${highlightClassP3}">${formatter.format(totalP3)}</td>
                        </tr>`;
                rows += `<tr class="font-weight-bold">
                            <td>Total Suara Keseluruhan</td>
                            <td colspan="3">${formatter.format(totalP1 + totalP2 + totalP3)}</td>
                        </tr>`;

                $('#table-data-kpu').html(rows);
            }
        });
    }

    function loadDataKawalPemilu() {
        $.ajax({
            url: 'https://api2.bantukawalpemilu.online/api/kawalpemilu/prov/',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var rows = '';
                var formatter = new Intl.NumberFormat('id-ID');
                var totalP1 = 0; 
                var totalP2 = 0; 
                var totalP3 = 0;

                // Iterasi melalui data.result.aggregated karena struktur responsnya berbeda
                $.each(data.result.aggregated, function(idLokasi, wilayahArray) {
                    var wilayahData = wilayahArray[0]; 
                    var wilayah = mapWilayah(wilayahData.idLokasi);

                    // Akumulasi total suara untuk masing-masing paslon
                    totalP1 += wilayahData.pas1;
                    totalP2 += wilayahData.pas2;
                    totalP3 += wilayahData.pas3;

                    var suaraTerbanyak = Math.max(wilayahData.pas1, wilayahData.pas2, wilayahData.pas3);

                    // Menghitung persentase
                    var persentase = (wilayahData.totalCompletedTps / wilayahData.totalTps * 100).toFixed(2); 

                    var highlightClassP1 = suaraTerbanyak === wilayahData.pas1 ? 'highlight' : '';
                    var highlightClassP2 = suaraTerbanyak === wilayahData.pas2 ? 'highlight' : '';
                    var highlightClassP3 = suaraTerbanyak === wilayahData.pas3 ? 'highlight' : '';

                    rows += '<tr>' +
                            `<td>${wilayah} <span class="badge badge-success">${persentase}%</span></td>` +
                            `<td class="${highlightClassP1}">${formatter.format(wilayahData.pas1)}</td>` +
                            `<td class="${highlightClassP2}">${formatter.format(wilayahData.pas2)}</td>` +
                            `<td class="${highlightClassP3}">${formatter.format(wilayahData.pas3)}</td>` +
                            '</tr>';
                });
                var maxTotal = Math.max(totalP1, totalP2, totalP3);

                var highlightClassP1 = totalP1 === maxTotal ? 'highlight' : '';
                var highlightClassP2 = totalP2 === maxTotal ? 'highlight' : '';
                var highlightClassP3 = totalP3 === maxTotal ? 'highlight' : '';

                rows += `<tr class="font-weight-bold">
                            <td>Total Suara</td>
                            <td class="${highlightClassP1}">${formatter.format(totalP1)}</td>
                            <td class="${highlightClassP2}">${formatter.format(totalP2)}</td>
                            <td class="${highlightClassP3}">${formatter.format(totalP3)}</td>
                        </tr>`;
                rows += `<tr class="font-weight-bold">
                            <td>Total Suara Keseluruhan</td>
                            <td colspan="3">${formatter.format(totalP1 + totalP2 + totalP3)}</td>
                        </tr>`;

                $('#table-data-kawalpemilu').html(rows); 
            }
        });
    }

    function loadDataKawalAmin() {
        $.ajax({
            url: 'https://api2.bantukawalpemilu.online/api/kawalamin/',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var rows = '';
                var formatter = new Intl.NumberFormat('id-ID');
                var totalP1 = 0; 
                var totalP2 = 0; 
                var totalP3 = 0;

                $.each(data.table, function(key, val) {
                    var province = val.province;
                    var p1Votes = val.p1;
                    var p2Votes = val.p2;
                    var p3Votes = val.p3;

                    // Akumulasi total suara untuk masing-masing paslon
                    totalP1 += p1Votes;
                    totalP2 += p2Votes;
                    totalP3 += p3Votes;

                    var maxVotes = Math.max(p1Votes, p2Votes, p3Votes);

                    var highlightClassP1 = p1Votes === maxVotes ? 'highlight' : '';
                    var highlightClassP2 = p2Votes === maxVotes ? 'highlight' : '';
                    var highlightClassP3 = p3Votes === maxVotes ? 'highlight' : '';

                    rows += `<tr>
                                <td>${province}</td>
                                <td class="${highlightClassP1}">${formatter.format(p1Votes)}</td>
                                <td class="${highlightClassP2}">${formatter.format(p2Votes)}</td>
                                <td class="${highlightClassP3}">${formatter.format(p3Votes)}</td>
                            </tr>`;
                });

                var maxTotal = Math.max(totalP1, totalP2, totalP3);

                var highlightClassP1 = totalP1 === maxTotal ? 'highlight' : '';
                var highlightClassP2 = totalP2 === maxTotal ? 'highlight' : '';
                var highlightClassP3 = totalP3 === maxTotal ? 'highlight' : '';

                rows += `<tr class="font-weight-bold">
                            <td>Total Suara</td>
                            <td class="${highlightClassP1}">${formatter.format(totalP1)}</td>
                            <td class="${highlightClassP2}">${formatter.format(totalP2)}</td>
                            <td class="${highlightClassP3}">${formatter.format(totalP3)}</td>
                        </tr>`;
                rows += `<tr class="font-weight-bold">
                            <td>Total Suara Keseluruhan</td>
                            <td colspan="3">${formatter.format(totalP1 + totalP2 + totalP3)}</td>
                        </tr>`;

                $('#table-data-kawalamin').html(rows);
            }
        });
    }


    function mapWilayah(kode) {
        var wilayahMap = {
            "11" : "ACEH",
            "12" : "SUMATERA UTARA",
            "13" : "SUMATERA BARAT",
            "14" : "RIAU",
            "15" : "JAMBI",
            "16" : "SUMATERA SELATAN",
            "17" : "BENGKULU",
            "18" : "LAMPUNG",
            "19" : "KEPULAUAN BANGKA BELITUNG",
            "21" : "KEPULAUAN RIAU",
            "31" : "DKI JAKARTA",
            "32" : "JAWA BARAT",
            "33" : "JAWA TENGAH",
            "34" : "DI YOGYAKARTA",
            "35" : "JAWA TIMUR",
            "36" : "BANTEN",
            "51" : "BALI",
            "52" : "NUSA TENGGARA BARAT",
            "53" : "NUSA TENGGARA TIMUR",
            "61" : "KALIMANTAN BARAT",
            "62" : "KALIMANTAN TENGAH",
            "63" : "KALIMANTAN SELATAN",
            "64" : "KALIMANTAN TIMUR",
            "65" : "KALIMANTAN UTARA",
            "71" : "SULAWESI UTARA",
            "72" : "SULAWESI TENGAH",
            "73" : "SULAWESI SELATAN",
            "74" : "SULAWESI TENGGARA",
            "75" : "GORONTALO",
            "76" : "SULAWESI BARAT",
            "81" : "MALUKU",
            "82" : "MALUKU UTARA",
            "91" : "PAPUA",
            "92" : "PAPUA BARAT",
            "93" : "PAPUA SELATAN",
            "94" : "PAPUA TENGAH",
            "95" : "PAPUA PEGUNUNGAN",
            "96" : "PAPUA BARAT DAYA",
            "99" : "LUAR NEGRI",
        };
        return wilayahMap[kode] || kode;
    }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("loadingIndicator").style.display = 'none';
        });
    </script>