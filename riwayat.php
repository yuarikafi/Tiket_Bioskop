<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Cinema</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

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
</head>

<body>
    <!-- Spinner Start -->

    <!-- Spinner End -->



    <?php
    include 'components/navbar.php'
    ?>



    <!-- Carousel End -->


    <!-- Features Start -->
    <?php
    include "koneksi.php";
    $sql = "
    SELECT f.id, f.nama_film, f.poster, f.usia, COUNT(t.id) AS jumlah_transaksi
    FROM film f
    LEFT JOIN transactions t ON f.nama_film = t.nama_film
    GROUP BY f.id, f.nama_film, f.poster, f.usia
    ORDER BY jumlah_transaksi DESC
    LIMIT 10
";
    $result = $conn->query($sql);
    ?>
    <!-- Features End -->




    <?php
    include 'koneksi.php'; // Menghubungkan ke database

    // Query untuk mengambil data dari tabel akun_mall
    $sql = "SELECT * FROM akun_mall ORDER BY id ASC";
    $result = $conn->query($sql);

    // Memulai output HTML
    ?>
    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="fw-medium text-uppercase mb-2" style="color:rgb(233, 221, 57);">Riwayat Transaksi</p>
                <h1 class="display-5 mb-4">Catatan Pembelian Anda</h1>


            </div>
            <div class="card">
                <div class="card-body">
                    <?php
                    // Mengambil username dari URL
                    $username = isset($_GET['username']) ? $_GET['username'] : '';

                    // Query untuk mengambil data transaksi berdasarkan username
                    $sql = "SELECT * FROM transactions WHERE username = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $username);  // Pastikan tipe parameter sesuai dengan jenis data (string untuk username)
                    $stmt->execute();
                    $result = $stmt->get_result();
                    ?>

                    <div class="table table-responsive">
                        <table id="transactionTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Transaksi</th>
                                    <th>Email</th>
                                    <th>Nama Film</th>
                                    <th>Nomer Kursi</th>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Jenis Pembayaran</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1; // Nomor urut untuk tabel
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['order_id']}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['nama_film']}</td>
                                    <td>{$row['seat_number']}</td>
                                    <td>{$row['transaction_time']}</td>
                                    <td>{$row['payment_type']}</td>
                                    <td>Rp.{$row['amount']}</td>   
                                    <td>";

                                    // Menggunakan if untuk mengecek status
                                    if ($row['status'] == 'settlement') {
                                        echo 'Selesai';
                                    } elseif ($row['status'] == 'pending') {
                                        echo 'Menunggu Pembayaran';
                                    } else {
                                        echo $row['status']; // Jika status selain 'settlement' atau 'Pending'
                                    }

                                    echo "</td>
                                </tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->




    <?php
    include 'components/footer.php'
    ?>





    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="bi bi-arrow-up"></i></a>


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
</body>

</html>