<script type="text/javascript" src="https://storage.sociabuzz.com/storage/js/main/buttononwebsite/index.min.js"></script>
<script>
    sbBoW.draw("petapemilu", "QmVyaSBEdWt1bmdhbiE", "position-bottom-right", "#76cc11", "#ffffff")
</script>
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