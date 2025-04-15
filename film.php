<?php
include 'koneksi.php'; // Menghubungkan ke database

// Mengambil id film dari URL
$id_film = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query untuk mengambil data film
$sql = "SELECT * FROM film WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_film);
$stmt->execute();
$result = $stmt->get_result();

// Memeriksa apakah film ditemukan
if ($result->num_rows > 0) {
    $film = $result->fetch_assoc();
} else {
    echo "Film Tidak Ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>User | FILM</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap" rel="stylesheet">

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
            padding: 20px;
        }

        .movie-info {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
        }

        .movie-info img {
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
        }

        .movie-details {
            flex: 1;
        }

        .btn-costum {
            background-color: #00695c;
            color: white;
            margin-bottom: 10px;
        }

        .btn-costum:hover {
            background-color: #004d40;
        }

        @media (max-whidth: 768px) {
            .movie-info {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .movie-details {
                max-width: 100%;
            }
        }
    </style>

</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <?php include 'components/navbar.php'; ?>
    <!-- Navbar End -->

    <!-- ISI MATERI -->
    <div class="container">
        <div class="d-flex align-items-center mb-3">
            <div class="bg-success text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                <span class="fw-bold"><?php echo $film['usia']; ?>+</span>
            </div>
            <div class="ms-3">
                <h3 class="mb-0"><?php echo $film['nama_film']; ?></h3>
                <p class="text-muted mb-0"><?php echo $film['genre']; ?></p>
            </div>
        </div>

        <div class="row movie-info">
            <div class="col-md-4 text-center">
                <img class="img-fluid rounded" alt="poster" src="<?php echo $film['poster']; ?>" />
            </div>
            <div class="col-md-8 movie-details">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-clock me-2"></i>
                    <span><?php echo $film['total_menit']; ?> Minutes</span>
                </div>
                <div class="mb-3">
                    <button class="btn btn-outline-secondary me-2"><?php echo $film['dimensi']; ?></button>
                </div>

                <!-- Tombol dengan warna abu-abu -->
                <div class="mb-3">
                    <button class="btn w-100" style="background-color: #6c757d; color: white; border: none; transition: 0.3s;"
                        onmouseover="this.style.backgroundColor='#5a6268'"
                        onmouseout="this.style.backgroundColor='#6c757d'"
                        onclick="window.location.href='jadwal.php?id=<?php echo $film['id']; ?>'">
                        Buy Ticket
                    </button>
                    <button class="btn w-100 mt-2" style="background-color: #6c757d; color: white; border: none; transition: 0.3s;"
                        onmouseover="this.style.backgroundColor='#5a6268'"
                        onmouseout="this.style.backgroundColor='#6c757d'"
                        data-bs-toggle="modal" data-bs-target="#trailerModal">
                        Trailer
                    </button>
                </div>
                <p> <?php echo $film['judul']; ?></p>
                <p><strong>Producer :</strong> <?php echo $film['Producer']; ?></p>
                <p><strong>Director :</strong> <?php echo $film['Director']; ?></p>
                <p><strong>Writer :</strong> <?php echo $film['Writer']; ?></p>
                <p><strong>Cast :</strong> <?php echo $film['Cast']; ?></p>
                <p><strong>Distributor :</strong> <?php echo $film['Distributor']; ?></p>
            </div>
        </div>
    </div>

    <!-- modal untuk trailer -->
    <div class="modal fade" id="trailerModal" tabindex="-1" aria-labelledby="trailerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trailerModalLabel">Trailer: <?php echo $film['nama_film']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <video width="100%" controls>
                        <source src="<?php echo $film['trailer']; ?>" type="video/mp4">
                        Your browure does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>

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