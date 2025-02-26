<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Chameleon Admin is a modern Bootstrap 4 webapp &amp; admin dashboard html template with a large number of components, elegant design, clean and organized code.">
    <meta name="keywords"
        content="admin template, Chameleon admin template, dashboard template, gradient admin template, responsive admin template, webapp, eCommerce dashboard, analytic dashboard">
    <meta name="author" content="ThemeSelect">
    <title>Dashboard Admin </title>
    <link rel="apple-touch-icon" href="theme-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="theme-assets/images/ico/favicon.ico">
    <link
        href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700"
        rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="theme-assets/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/vendors/css/charts/chartist.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN CHAMELEON  CSS-->
    <link rel="stylesheet" type="text/css" href="theme-assets/css/app-lite.css">
    <!-- END CHAMELEON  CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="theme-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/pages/dashboard-ecommerce.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <!-- Tambahkan CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Bootstrap CSS --> 


    <!-- Bootstrap JS (Popper.js sudah termasuk) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <!-- END Custom CSS-->
</head>

<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click"
    data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">


    <!-- fixed-top-->
    <?php
    include 'components/navbar.php'
    ?>

    <div class="app-content content" style="margin-top: 20px;">
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Menu Akun Admin -->
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Jadwal Film</h4>
                        <!-- Tombol untuk membuka modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal">
                            Tambah Jadwal Film
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="filmTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>Nama Mall</th>
                                        <th>Poster</th>
                                        <th>Nama Film</th>
                                        <th>Total Menit</th>
                                        <th>Tanggal Tayang</th>
                                        <th>Tanggal Akhir Tayang</th>
                                        <th>Jam Tayang 1</th>
                                        <th>Jam Tayang 2</th>
                                        <th>Jam Tayang 3</th>
                                        <th>Studio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include '../koneksi.php'; // Menghubungkan ke database

                                    // Query untuk mengambil data film, nama mall, dan poster
                                    $sql = "SELECT
                                    jadwal_film.id,
                                    akun_mall.nama_mall,
                                    film.nama_film,
                                    film.poster,
                                    jadwal_film.total_menit,
                                    jadwal_film.tanggal_tayang,
                                    jadwal_film.tanggal_akhir_tayang,
                                    jadwal_film.jam_tayang_1,
                                    jadwal_film.jam_tayang_2,
                                    jadwal_film.jam_tayang_3,
                                    jadwal_film.studio
                                FROM jadwal_film
                                JOIN akun_mall ON jadwal_film.mall_id = akun_mall.id
                                JOIN film ON jadwal_film.film_id = film.id
                                ORDER BY akun_mall.nama_mall ASC, jadwal_film.id ASC";

                                    $result = $conn->query($sql);
                                    if (!$result) {
                                        die("Query Error: " . $conn->error);
                                    }

                                    // Array untuk menyimpan data film berdasarkan mall
                                    $filmsByMall = [];

                                    // Memasukkan data film ke dalam array berdasarkan mall
                                    while ($row = $result->fetch_assoc()) {
                                        $filmsByMall[$row['nama_mall']][] = $row;
                                    }
                                    ?>
                                    <?php
                                    $no = 1;
                                    foreach ($filmsByMall as $mallName => $films) {
                                        foreach ($films as $film) {
                                            // Konversi tanggal ke format DateTime
                                            $expired_date = new DateTime($film['tanggal_akhir_tayang']);
                                            $current_date = new DateTime();
                                            // Cek apakah sudah kadaluarsa
                                            $is_expired = $expired_date < $current_date;
                                            echo "<tr " . ($is_expired ? "style='background-color: red !important;'" : "") . ">
                                            <td " . ($is_expired ? "style='background-color: red !important;'" : "") . ">{$no}</td>
                                            <td " . ($is_expired ? "style='background-color: red !important;'" : "") . ">{$film['nama_mall']}</td>
                                            <td " . ($is_expired ? "style='background-color: red !important;'" : "") . "><img src='../{$film['poster']}' alt='Poster' width='100'></td>
                                            <td " . ($is_expired ? "style='background-color: red !important;'" : "") . ">{$film['nama_film']}</td>
                                            <td " . ($is_expired ? "style='background-color: red !important;'" : "") . ">{$film['total_menit']}</td>
                                            <td " . ($is_expired ? "style='background-color: red !important;'" : "") . ">{$film['tanggal_tayang']}</td>
                                            <td " . ($is_expired ? "style='background-color: red !important;'" : "") . ">{$film['tanggal_akhir_tayang']}</td>
                                            <td " . ($is_expired ? "style='background-color: red !important;'" : "") . ">{$film['jam_tayang_1']}</td>
                                            <td " . ($is_expired ? "style='background-color: red !important;'" : "") . ">{$film['jam_tayang_2']}</td>
                                            <td " . ($is_expired ? "style='background-color: red !important;'" : "") . ">{$film['jam_tayang_3']}</td>
                                            <td " . ($is_expired ? "style='background-color: red !important;'" : "") . ">{$film['studio']}</td>
                                        </tr>";
                                            $no++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal Tambah Film -->
    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <?php
    include 'components/footer.php'
    ?>

    <!-- BEGIN VENDOR JS-->
    <script src="theme-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="theme-assets/vendors/js/charts/chartist.min.js" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN CHAMELEON  JS-->
    <script src="theme-assets/js/core/app-menu-lite.js" type="text/javascript"></script>
    <script src="theme-assets/js/core/app-lite.js" type="text/javascript"></script>
    <!-- END CHAMELEON  JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="theme-assets/js/scripts/pages/dashboard-lite.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->
    <!-- Tambahkan jQuery dan DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Tambahkan Script untuk DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Fetch mall data
            $.ajax({
                url: 'api.php?endpoint=mall',
                method: 'GET',
                success: function(data) {
                    data.forEach(function(mall) {
                        $('#namaMall').append(`<option 
value="${mall.id}">${mall.nama_mall}</option>`);
                    });
                },
            });
            // Fetch film data
            $.ajax({
                url: 'api.php?endpoint=film',
                method: 'GET',
                success: function(data) {
                    data.forEach(function(film) {
                        $('#namaFilm').append(`<option 
value="${film.id}">${film.nama_film}</option>`);
                    });
                },
            });
            // Handle film selection
            $('#namaFilm').change(function() {
                const filmId = $(this).val();
                if (filmId) {
                    $.ajax({
                        url: `api.php?endpoint=film_detail&id=${filmId}`,
                        method: 'GET',
                        success: function(film) {
                            $('#posterFilm').attr('src', `../${film.poster}`).show();
                            $('#totalMenit').val(film.total_menit);
                        },
                        error: function() {
                            $('#posterFilm').hide().attr('src', '');
                            $('#totalMenit').val('');
                        },
                    });
                } else {
                    $('#posterFilm').hide().attr('src', '');
                    $('#totalMenit').val('');
                }
            });
            // Handle form submission
            $('#formTambahJadwal').submit(function(e) {
                e.preventDefault();
                // Get form data
                const formData = $(this).serialize();
                // Send data to server
                $.ajax({
                    url: 'api.php?endpoint=tambah_jadwal',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Show SweetAlert2 on success
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Jadwal Film berhasil disimpan!',
                                icon: 'success',
                                confirmButtonText: 'OK',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Redirect to jadwal.php
                                    window.location.href = 'jadwal_film.php';
                                }
                            });
                        } else {
                            // Show SweetAlert2 on failure
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Gagal menyimpan jadwal film.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Terjadi kesalahan!',
                            text: 'Tidak dapat menyimpan jadwal film.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    },
                });
            });
        });
    </script>
</body>
<div class="modal fade" id="modalTambahJadwal" tabindex="-1" arialabelledby="modalTambahJadwalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahJadwalLabel">Tambah Jadwal
                    Film</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" arialabel="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahJadwal">
                    <!-- Nama Mall -->
                    <div class="mb-3">
                        <label for="namaMall" class="form-label">Nama Mall</label>
                        <select class="form-select" id="namaMall" name="namaMall"
                            required>
                            <option value="">Pilih Mall</option>
                        </select>
                    </div>
                    <!-- Nama Film -->
                    <div class="mb-3">
                        <label for="namaFilm" class="form-label">Nama Film</label>
                        <select class="form-select" id="namaFilm" name="namaFilm"
                            required>
                            <option value="">Pilih Film</option>
                        </select>
                    </div>
                    <!-- Poster -->
                    <div class="mb-3">
                        <label for="posterFilm" class="form-label">Poster</label>
                        <img id="posterFilm" src="" alt="Poster Film" class="imgthumbnail" style="display: none; max-height: 200px;">
                    </div>
                    <!-- Total Menit -->
                    <div class="mb-3">
                        <label for="totalMenit" class="form-label">Total Menit</label>
                        <input type="text" class="form-control" id="totalMenit"
                            name="totalMenit" readonly>
                    </div>
                    <!-- Tanggal Tayang -->
                    <div class="mb-3">
                        <label for="tanggalTayang" class="form-label">Tanggal
                            Tayang</label>
                        <input type="date" class="form-control" id="tanggalTayang"
                            name="tanggalTayang" required>
                    </div>
                    <!-- Tanggal Akhir Tayang -->
                    <div class="mb-3">
                        <label for="tanggalAkhirTayang" class="form-label">Tanggal Akhir
                            Tayang</label>
                        <input type="date" class="form-control" id="tanggalAkhirTayang"
                            name="tanggalAkhirTayang" required>
                    </div>
                    <!-- Jam Tayang 1 -->
                    <div class="mb-3">
                        <label for="jamTayang1" class="form-label">Jam Tayang 1</label>
                        <input type="time" class="form-control" id="jamTayang1"
                            name="jamTayang1" required>
                    </div>
                    <!-- Jam Tayang 2 -->
                    <div class="mb-3">
                        <label for="jamTayang2" class="form-label">Jam Tayang 2</label>
                        <input type="time" class="form-control" id="jamTayang2"
                            name="jamTayang2">
                    </div>
                    <!-- Jam Tayang 3 -->
                    <div class="mb-3">
                        <label for="jamTayang3" class="form-label">Jam Tayang 3</label>
                        <input type="time" class="form-control" id="jamTayang3"
                            name="jamTayang3">
                    </div>
                    <!-- Pilih Studio -->
                    <div class="mb-3">
                        <label for="studio" class="form-label">Pilih Studio</label>
                        <select class="form-select" id="studio" name="studio" required>
                            <option value="">Pilih Studio</option>
                            <option value="Studio 1">Studio 1</option>
                            <option value="Studio 2">Studio 2</option>
                            <option value="Studio 3">Studio 3</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"
                        id="submitBtn">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

</html>