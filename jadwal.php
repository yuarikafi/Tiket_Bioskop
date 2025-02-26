<?php
include 'koneksi.php';
session_start();
//mengambil id film
$id_film = isset($_GET['id']) ? intval($_GET['id']) : 0;

//query untuk mengambil data film berdasarkan (termassuk harga tiket)
$sql = "SELECT * FROM film WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_film);
$stmt->execute();
$result = $stmt->get_result();

//memeriksa apakah film di temukan   
if ($result->num_rows > 0) {
    $film = $result->fetch_assoc();
    $harga_tiket = $film['harga'];
} else {
    echo "Film Tidak Ditemukan";
    exit;
}

//query untuk mengambil data
$sql_jadwal = "
SELECT jadwal_film.*, akun_mall.nama_mall
FROM jadwal_film
INNER JOIN akun_mall ON jadwal_film.mall_id = akun_mall.id
WHERE jadwal_film.film_id = ? AND CURDATE() BETWEEN jadwal_film.tanggal_tayang AND jadwal_film.tanggal_akhir_tayang
";
$stmt_jadwal = $conn->prepare($sql_jadwal);
$stmt_jadwal->bind_param("i", $id_film);
$stmt_jadwal->execute();
$jadwal_result = $stmt_jadwal->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Cinema</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link rel="icon" type="image/png" href="img/logo_cinema.png" sizes="256x256">

</head>

<!-- Google Web Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap"
    rel="stylesheet">

<!-- Icon Font Stylesheet -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Libraries Stylesheet -->
<link href="lib/animate/animate.min.css" rel="stylesheet">
<link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

<!-- Customized Bootstrap Stylesheet -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Template Stylesheet -->
<link href="css/style.css" rel="stylesheet">

<style>
    body {
        background-color: #f5f5f5;
    }

    .card {
        border: none;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 20px;
    }

    .showtime-btn {
        border: 1px solid #d1d1d1;
        border-radius: 5px;
        padding: 5px 10px;
        margin-top: 10px;
        display: inline-block;
    }

    .showtime-btn:hover {
        background-color: #f0f0f0;
    }

    .cinema-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-top: 1px solid #d1d1d1;
    }

    .cinema-info:first-child {
        border-top: none;
    }

    .cinema-info {
        display: flex;
        margin-right: 450px;
        flex-direction: column;
        gap: 15px;
    }

    .showtime-btn {
        display: inline-block;
        margin-right: 10px;
    }
</style>
<?php
$username = isset($_SESSION['email']) ? $_SESSION['email'] : "";
?>

</head>

<body>
    <!-- Spinner Start -->

    <!-- Spinner End -->


    <!-- Navbar Start -->
    <?php
    include 'components/navbar.php'
    ?>

    <!-- Navbar End -->

    <!-- Project Start -->

    <div class="container mt-5">
        <div class="card">
            <div class="row g-3">
                <div class="col-md-4">
                    <img src="<?php echo $film['poster'] ?>" class="img-fluid rounded-start" alt="Film Poster">
                </div>
                <div class="col-md-8">
                    <h5 class="card-title"><?php echo $film['nama_film'] ?></h5>
                    <p class="card-text"><i class="fas fa-clock"></i><?php echo $film['total_menit'] ?> Minutes</p>
                    <div class="mb-3">
                        <button type="button" class="btn btn-outline-secondary btn-sm"><?php echo $film['dimensi'] ?></button>
                        <button type="button" class="btn btn-outline-secondary btn-sm"><?php echo $film['usia'] ?></button>
                    </div>
                    <?php if ($jadwal_result->num_rows > 0): ?>
                        <?php while ($jadwal = $jadwal_result->fetch_assoc()): ?>
                            <?php
                            $today = date('Y-m-d');
                            $tanggal_tayang = date('Y-m-d', strtotime($jadwal['tanggal_tayang']));
                            $tanggal_akhir_tayang = date('Y-m-d', strtotime($jadwal['tanggal_akhir_tayang']));
                            ?>
                            <?php if ($tanggal_tayang <= $today && $tanggal_akhir_tayang >= $today): ?>
                                <h6 class="mb-1"><?php echo $jadwal['nama_mall']; ?></h6>
                                <p class="mb-1"><?php echo date('d-m-Y', strtotime($today)); ?></p>
                                <?php if ($jadwal['jam_tayang_1']): ?>
                                    <button type="button" class="btn btn-primary showtime-btn"
                                        data-bs-jam="<?php echo date('H:i', strtotime($jadwal['jam_tayang_1'])); ?>"
                                        data-bs-mall="<?php echo $jadwal['nama_mall']; ?>"
                                        data-bs-toggle="modal" data-bs-target="#ticketModal">
                                        <?php echo date('H:i', strtotime($jadwal['jam_tayang_1'])); ?>
                                    </button>
                                <?php endif; ?>
                                <?php if ($jadwal['jam_tayang_2']): ?>
                                    <button type="button" class="btn btn-primary showtime-btn"
                                        data-bs-jam="<?php echo date('H:i', strtotime($jadwal['jam_tayang_2'])); ?>"
                                        data-bs-mall="<?php echo $jadwal['nama_mall']; ?>"
                                        data-bs-toggle="modal" data-bs-target="#ticketModal">
                                        <?php echo date('H:i', strtotime($jadwal['jam_tayang_2'])); ?>
                                    </button>
                                <?php endif; ?>
                                <?php if ($jadwal['jam_tayang_3']): ?>
                                    <button type="button" class="btn btn-primary showtime-btn"
                                        data-bs-jam="<?php echo date('H:i', strtotime($jadwal['jam_tayang_3'])); ?>"
                                        data-bs-mall="<?php echo $jadwal['nama_mall']; ?>"
                                        data-bs-toggle="modal" data-bs-target="#ticketModal">
                                        <?php echo date('H:i', strtotime($jadwal['jam_tayang_3'])); ?>
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <?php
                        $id_film = isset($_GET['id']) ? intval($_GET['id']) : 0;

                        $jadwal_film = $conn->query("SELECT MIN(tanggal_tayang) as tanggal_terdekat FROM jadwal_film WHERE film_id = {$id_film}");
                        $row = $jadwal_film->fetch_assoc();
                        $tanggal_terdekat = $row['tanggal_terdekat'] ?? null;

                        if ($tanggal_terdekat) {
                            echo "<p>Jadwal Akan Tersedia Pada Tanggal: " . date('d-m-Y', strtotime($tanggal_terdekat)) . "</p>";
                        } else {
                            echo "<p>Belum Ada Jadwal</p>";
                        }
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="ticketModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-tittle" id="ticketModalLabel">Pilih Tiket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama Film: </strong><span><?php echo $film['nama_film'] ?> </span></p>
                    <p><strong>Nama Mall: </strong><span id="mallName"></span></p>
                    <p><strong>Jam Tayang: </strong><span id="showtime"></span></p>
                    <p><strong>Harga Per Tiket: </strong>Rp<span
                            id="ticketPrice"><?php echo number_format($film['harga'], 0, ',', '.'); ?></span></p>

                    <div class="form-group">
                        <label for="ticketCount">Jumlah Tiket</label>
                        <input type="number" class="form-control" id="ticketCount" readonly value="0">
                    </div>
                    <div class="form-group">
                        <label for="ticketCount">Total Harga TIket</label>
                        <input type="text" class="form-control" id="hargatiket" readonly>
                    </div>
                    <div class="form-group">
                        <label for="seatSelection">Pilih Kursi</label>
                        <div id="seatSelection" class="d-flex flex-wrap gap-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="bookTicket">Pesan Tiket</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Project End -->

    <!-- Footer Start -->
    <?php
    include 'components/footer.php'
    ?>
    <!-- Footer End -->




    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-square rounded-circle back-to-top" style="background-color: #D32F2F; border-color: #D32F2F;">
        <i class="bi bi-arrow-up" style="color: white;"></i>
    </a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Vatx0pDVsL47sXiN"></script>
    <script>
        var username = "<?php echo $username; ?>";

        if (!username) {
            Swal.fire({
                icon: 'warning',
                title: 'Anda belum login',
                text: 'Login terlebih dahulu untuk melanjutkan.',
                confirmButtonText: 'Ke Halaman Login'
            }).then(() => {
                window.location.href = "login.php";
            });
        } else {
            document.addEventListener('DOMContentLoaded', function() {
                var ticketModal = document.getElementById('ticketModal');

                if (ticketModal) {
                    var modalShown = false;

                    ticketModal.addEventListener('show.bs.modal', function(event) {
                        if (modalShown) return;
                        modalShown = true;

                        var button = event.relatedTarget;
                        var mallName = button.getAttribute('data-bs-mall');
                        var showtime = button.getAttribute('data-bs-jam');

                        var mallNameElement = ticketModal.querySelector('#mallName');
                        var showtimeElement = ticketModal.querySelector('#showtime');

                        if (mallNameElement && showtimeElement) {
                            mallNameElement.textContent = mallName;
                            showtimeElement.textContent = showtime;
                        }

                        let seatContainer = document.getElementById("seatSelection");
                        seatContainer.innerHTML = "";

                        let seatWrapper = document.createElement("div");
                        seatWrapper.classList.add("seat-wrapper", "d-flex", "flex-column", "align-items-center");

                        let seatRows = [{
                                row: "A",
                                seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                            },
                            {
                                row: "B",
                                seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                            },
                            {
                                row: "C",
                                seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                            },
                            {
                                row: "D",
                                seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                            },
                            {
                                row: "E",
                                seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                            },
                            {
                                row: "F",
                                seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                            },
                            {
                                row: "G",
                                seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                            },
                            {
                                row: "H",
                                seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                            }
                        ];

                        seatRows.forEach(group => {
                            let row = document.createElement("div");
                            row.classList.add("d-flex", "justify-content-center", "mb-3");

                            // Kelompok pertama
                            for (let i = 0; i < 3; i++) {
                                let seatDiv = document.createElement("div");
                                seatDiv.classList.add("seat", "btn", "btn-outline-primary", "m-1", "btn-sm");
                                seatDiv.setAttribute("data-seat", `${group.row}${group.seats[i]}`);
                                seatDiv.textContent = `${group.row}${group.seats[i]}`;
                                seatDiv.addEventListener("click", function() {
                                    if (!this.classList.contains("btn-danger")) {
                                        this.classList.toggle("btn-primary");
                                        updatePrice();
                                    }
                                });
                                row.appendChild(seatDiv);
                            }

                            // Tambahan spacer
                            let spacer1 = document.createElement("div");
                            spacer1.classList.add("mx-4");
                            row.appendChild(spacer1);

                            // Kelompok kedua
                            for (let i = 3; i < 7; i++) {
                                let seatDiv = document.createElement("div");
                                seatDiv.classList.add("seat", "btn", "btn-outline-primary", "m-1", "btn-sm");
                                seatDiv.setAttribute("data-seat", `${group.row}${group.seats[i]}`);
                                seatDiv.textContent = `${group.row}${group.seats[i]}`;
                                seatDiv.addEventListener("click", function() {
                                    if (!this.classList.contains("btn-danger")) {
                                        this.classList.toggle("btn-primary");
                                        updatePrice();
                                    }
                                });
                                row.appendChild(seatDiv);
                            }

                            // Tambahan spacer 2
                            let spacer2 = document.createElement("div");
                            spacer2.classList.add("mx-4");
                            row.appendChild(spacer2);

                            // Kelompok ketiga
                            for (let i = 7; i < 10; i++) {
                                let seatDiv = document.createElement("div");
                                seatDiv.classList.add("seat", "btn", "btn-outline-primary", "m-1", "btn-sm");
                                seatDiv.setAttribute("data-seat", `${group.row}${group.seats[i]}`);
                                seatDiv.textContent = `${group.row}${group.seats[i]}`;
                                seatDiv.addEventListener("click", function() {
                                    if (!this.classList.contains("btn-danger")) {
                                        this.classList.toggle("btn-primary");
                                        updatePrice();
                                    }
                                });
                                row.appendChild(seatDiv);
                            }

                            seatWrapper.appendChild(row);
                        });

                        seatContainer.appendChild(seatWrapper);

                        let ticketPriceElement = document.getElementById("ticketPrice");
                        let ticketCountInput = document.getElementById("ticketCount");
                        let totalPriceInput = document.getElementById("hargatiket");

                        if (ticketPriceElement && totalPriceInput) {
                            let ticketPrice = parseInt(ticketPriceElement.textContent.replace(/\./g, ""));

                            function updatePrice() {
                                let selectedSeats = document.querySelectorAll(".seat.btn-primary");
                                let totalTickets = selectedSeats.length;
                                let totalPrice = totalTickets * ticketPrice;

                                ticketCountInput.value = totalTickets;
                                totalPriceInput.value = "Rp " + totalPrice.toLocaleString("id-ID");
                            }
                        }

                        let filmName = document.querySelector("#ticketModal span").textContent.trim();
                        fetch(`fetch_seats.php?mall_name=${encodeURIComponent(mallName)}&film_name=${encodeURIComponent(filmName)}`)
                            .then(response => response.json())
                            .then(data => {
                                let occupiedSeats = data.occupiedSeats || [];
                                seatRows.forEach(group => {
                                    group.seats.forEach(seat => {
                                        let seatNumber = `${group.row}${seat}`;
                                        let seatDiv = document.querySelector(`[data-seat='${seatNumber}']`);

                                        if (occupiedSeats.includes(seatNumber)) {
                                            seatDiv.classList.add("btn-danger", "disabled");
                                        }
                                    });
                                });
                            })
                            .catch(error => console.error("Error fetching seat status:", error));
                    });
                }

                document.getElementById("bookTicket").addEventListener("click", function() {
                    console.log("Tombol 'Pesan Tiket' diklik.");

                    let mallName = document.getElementById("mallName").textContent.trim();
                    let filmName = document.querySelector("#ticketModal span").textContent.trim();
                    let showtime = document.getElementById("showtime").textContent.trim();
                    let price = parseInt(document.getElementById("ticketPrice").textContent.replace(/\./g, ""));
                    let selectedSeats = document.querySelectorAll(".seat.btn-primary");
                    let ticketCount = selectedSeats.length;
                    let totalPrice = price * ticketCount;

                    console.log("Mall:", mallName);
                    console.log("Film:", filmName);
                    console.log("Showtime:", showtime);
                    console.log("Harga Tiket per Kursi:", price);
                    console.log("Jumlah Kursi Dipilih:", ticketCount);
                    console.log("Total Harga:", totalPrice);

                    if (ticketCount === 0) {
                        console.warn("Tidak ada kursi yang dipilih.");
                        Swal.fire({
                            icon: 'error',
                            title: 'Pilih Kursi',
                            text: 'Silahkan pilih kursi terlebih dahulu.',
                            confirmButtonText: 'Tutup'
                        });
                        return;
                    }

                    let seatNumbers = Array.from(selectedSeats).map(seat => seat.getAttribute("data-seat")).join(",");
                    console.log("Nomor Kursi:", seatNumbers);

                    fetch("insert_seat.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: `seat_number=${seatNumbers}&mall_name=${mallName}&film_name=${filmName}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log("Response dari insert_seat.php:", data);

                            if (data.success) {
                                selectedSeats.forEach(seat => {
                                    seat.classList.remove("btn-outline-primary");
                                    seat.classList.add("btn-danger", "disabled");
                                });

                                console.log("Kursi berhasil dipesan. Melanjutkan ke pembayaran...");

                                // Proses pembayaran
                                $.ajax({
                                    url: "process_transaction.php",
                                    type: "POST",
                                    data: {
                                        mall_name: mallName,
                                        showtime: showtime,
                                        ticket_count: ticketCount,
                                        total_price: totalPrice,
                                        seat_number: seatNumbers,
                                        username: username
                                    },
                                    success: function(response) {
                                        console.log("Response dari process_transaction.php:", response);

                                        try {
                                            let data = JSON.parse(response);
                                            if (data.snap_token) {
                                                console.log("Token pembayaran didapatkan:", data.snap_token);

                                                window.snap.pay(data.snap_token, {
                                                    onSuccess: function(result) {
                                                        console.log("Pembayaran Berhasil:", result);
                                                        saveTransaction(result, seatNumbers, username);
                                                    },
                                                    onPending: function(result) {
                                                        console.warn("Pembayaran Pending:", result);
                                                        saveTransaction(result, seatNumbers, username);
                                                    },
                                                    onError: function(result) {
                                                        console.error("Pembayaran Gagal:", result);
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Pembayaran Gagal',
                                                            text: 'Ada masalah dengan pembayaran',
                                                            confirmButtonText: 'Coba lagi'
                                                        });
                                                    }
                                                });
                                            } else {
                                                console.error("Gagal mendapatkan token pembayaran.");
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Token Pembayaran Gagal',
                                                    text: 'Gagal mendapatkan token pembayaran',
                                                    confirmButtonText: 'Tutup'
                                                });
                                            }
                                        } catch (e) {
                                            console.error("Error parsing response JSON:", e);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("AJAX Error:", error);
                                        console.log("XHR Response:", xhr.responseText);
                                    }
                                });
                            } else {
                                console.error("Gagal memesan tiket:", data);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal Memesan Tiket',
                                    text: 'Terjadi Kesalahan saat memesan tiket',
                                    confirmButtonText: 'Coba lagi'
                                });
                            }
                        })
                        .catch(error => console.error("Error saat memesan kursi:", error));
                });

            });

            function saveTransaction(transactionData, seatNumber, username) {
                let filmName = document.querySelector("#ticketModal span").textContent.trim();
                transactionData.seat_number = seatNumber;
                transactionData.film_name = filmName;
                transactionData.username = username;

                console.log("Saving transaction: ", transactionData);
                console.log("Film Name: ", filmName);

                $.ajax({
                    url: "save_transaction.php",
                    type: "POST",
                    data: transactionData,
                    success: function(response) {
                        console.log("Response from save_transaction.php: ", response);
                        $.ajax({
                            url: "update_seat_status.php",
                            type: "POST",
                            data: {
                                seat_number: seatNumber,
                                transaction_data: transactionData,
                                film_name: filmName
                            },
                            success: function(updateResponse) {
                                console.log("Seat status updated: ", updateResponse);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pembayaran Berhasil',
                                    text: 'Tiket dan kursi anda sudah dipesan.',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload(); // Reload halaman
                                });
                            },
                            error: function(xhr, status, error) {
                                console.log("Error in updating seat status: ", error);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log("Error in saving transaction: ", error);
                    }
                });
            }
        }
    </script>

</body>

</html>