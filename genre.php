<?php

include 'koneksi.php';

// Tangkap parameter usia dari URL
$genre = isset($_GET['genre']) ? $_GET['genre'] : '';

// Query dengan filter genre jika dipilih
if (!empty($genre)) {
    $sql = "SELECT * FROM film WHERE genre LIKE '%$genre%' ORDER BY id ASC";
} else {
    $sql = "SELECT * FROM film ORDER BY id ASC";
}
$result = $conn->query($sql);
// Memulai output HTML
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Industro - Industrial HTML Template</title>
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
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <?php
    include 'components/navbar.php'
    ?>
    <!-- Navbar End -->

    <!-- Service Start -->
    <?php
    include 'koneksi.php';

    $result = $conn->query($sql);
    ?>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="fw-medium text-uppercase mb-2" style="color: #757575;">Now Playing</p>
                <h1 class="display-5 mb-4">Film Teratas</h1>
            </div>
            <div class="row gy-5 gx-4">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item">
                            <img class="img-fluid" src="<?php echo $row['poster']; ?>" alt=""
                                style="width: 100%; height: 500px; object-fit: cover; border-radius: 5px;">
                            <div class="service-img" style="background-color: transparent;">
                                <img class="img-fluid" src="<?php echo $row['poster']; ?>" alt="">
                            </div>
                            <div class="service-detail">
                                <div class="service-title">
                                    <hr class="w-25">
                                    <h4 class="mb-0" style="padding-top: 125px;"><?php echo $row['nama_film']; ?></h3>
                                        <hr class="w-25">
                                </div>
                                <div class="service-text">
                                    <p class="text-white mb-0"><?php echo $row['nama_film']; ?></p>
                                    <p class="text-white mb-0"><?php echo $row['usia']; ?>+</p>
                                </div>
                            </div>
                            <a class="btn btn-light" href="film.php?id=<?php echo $row['id']; ?>">Read More</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- footer -->
    <?php
    include 'components/footer.php'
    ?>

    <!-- Copyright Start -->

    <!-- Copyright End -->


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