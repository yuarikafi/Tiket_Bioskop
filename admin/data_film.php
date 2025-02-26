


<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Chameleon Admin is a modern Bootstrap 4 webapp &amp; admin dashboard html template with a large number of components, elegant design, clean and organized code.">
    <meta name="keywords" content="admin template, Chameleon admin template, dashboard template, gradient admin template, responsive admin template, webapp, eCommerce dashboard, analytic dashboard">
    <meta name="author" content="ThemeSelect">
    <title>Dashboard - Chameleon Admin - Modern Bootstrap 4 WebApp & Dashboard HTML Template + UI Kit</title>
    <link rel="apple-touch-icon" href="theme-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="theme-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
     <!-- Bootstrap JS (Popper.js sudah termasuk) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- END Custom CSS-->
</head>

<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">


<script>
        const selectedGenres = new Set(); // Menggunakan Set untuk mencegahduplikasi

        function addGenre() {
            const genreSelect = document.getElementById('genreSelect');
            const selectedValue = genreSelect.value;

            if (selectedValue && !selectedGenres.has(selectedValue)) {
                selectedGenres.add(selectedValue);

                // menambahkan genre ke daftar tampilan 
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                listItem.textContent = selectedValue;

                //tombol untuk menghapus genre
                const removeBtn = document.createElement('button');
                removeBtn.className = 'btn btn-sm btn-danger'
                removeBtn.textContent = 'Hapus';
                removeBtn.onclick = () => {
                    selectedGenres.delete(selectedValue);
                    listItem.remove();
                    updateHiddenInput();
                };

                listItem.appendChild(removeBtn);
                document.getElementById('selectedGenres').appendChild(listItem);

                //memperbarui input tersembunyi
                updateHiddenInput();
            }

            //reset pilihan dropdown
            genreSelect.value = '';

        }

        function updateHiddenInput() {
            document.getElementById('genreInput').value = Array.from(selectedGenres).join(',');
        }
    </script>
    <!-- fixed-top-->
    <?php
    include 'components/navbar.php'
    ?>
    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <div class="app-content content" style="margin-top: 20px;">
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Menu Akun Admin -->
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Data Film</h4>
                        <!-- Tombol untuk membuka modal -->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahFilmModal">
                            Tambah Film
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="filmTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>Poster</th>
                                        <th>Nama Film</th>
                                        <th>Deskripsi</th>
                                        <th>Genre</th>
                                        <th>Total Menit</th>
                                        <th>Usia</th>
                                        <th>Dimensi</th>
                                        <th>Producer</th>
                                        <th>Director</th>
                                        <th>Writer</th>
                                        <th>Cast</th>
                                        <th>Distributor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include '../koneksi.php';
                                    // Mengambil data film dari database
                                    $sql = "SELECT * FROM film";
                                    $result = mysqli_query($conn, $sql);
                                    $no = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>
                                        <td>{$no}</td>
                                        <td><img src='../{$row['poster']}' alt='Poster' width='100'></td>
                                        <td>{$row['nama_film']}</td>
                                        <td>{$row['judul']}</td>
                                        <td>{$row['genre']}</td>
                                        <td>{$row['total_menit']}</td>
                                        <td>{$row['usia']}</td>
                                        <td>{$row['dimensi']}</td>
                                        <td>{$row['Producer']}</td>
                                        <td>{$row['Director']}</td>
                                        <td>{$row['Writer']}</td>
                                        <td>{$row['Cast']}</td>
                                        <td>{$row['Distributor']}</td>
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
    </div>
    <!-- Modal Tambah Film -->
    <div class="modal fade" id="tambahFilmModal" tabindex="-1" aria-labelledby="tambahFilmLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahFilmLabel">Tambah Data Film</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../proses_input.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Upload Poster -->
                                <div class="mb-3">
                                    <label for="poster" class="form-label">Upload Poster</label>
                                    <input type="file" id="poster" name="poster" accept="image/*" class="form-control" required>
                                </div>

                                <!-- Nama Film -->
                                <div class="mb-3">
                                    <label for="nama_film" class="form-label">Nama Film</label>
                                    <input type="text" id="nama_film" name="nama_film" class="form-control" required>
                                </div>

                                <!-- Genre -->
                                <div class="mb-3">
                                    <label for="genre" class="form-label">Genre</label>
                                    <select id="genreSelect" class="form-select">
                                        <option value="" disabled selected>Pilih Genre</option>
                                        <option value="Action">Action</option>
                                        <option value="Adventure">Adventure</option>
                                        <option value="Drama">Drama</option>
                                        <option value="Horror">Horror</option>
                                        <option value="Sci-Fi">Sci-Fi</option>
                                        <option value="Thriller">Thriller</option>
                                    </select>
                                    <button type="button" class="btn btn-secondary mt-2" onclick="addGenre()">Tambah Genre</button>
                                    <ul id="selectedGenres" class="list-group mt-2"></ul>
                                    <input type="hidden" id="genreInput" name="genre">
                                </div>

                                <!-- Upload Banner -->
                                <div class="mb-3">
                                    <label for="banner" class="form-label">Upload Banner</label>
                                    <input type="file" id="banner" name="banner" accept="image/*" class="form-control" required>
                                </div>

                                <!-- Total Menit -->
                                 <div class="mb-3">
                                    <label for="menit" class="form-label">Total Menit</label>
                                    <input type="number" id="menit" name="menit" class="form-control" required>
                                </div>

                                <!-- Usia -->
                                <div class="mb-3">
                                    <label for="usia" class="form-label">Usia</label>
                                    <select id="usia" name="usia" class="form-select" required>
                                        <option value="" disabled selected>Pilih Usia</option>
                                        <option value="13">13</option>
                                        <option value="17">17</option>
                                        <option value="SU">SU</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Upload Trailer -->
                                <div class="mb-3">
                                    <label for="trailer" class="form-label">Upload Trailer</label>
                                    <input type="file" id="trailer" name="trailer" accept="video/*" class="form-control">
                                </div>

                                <!-- Deskripsi -->
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Deskripsi</label>
                                    <textarea id="judul" name="judul" class="form-control" required></textarea>
                                </div>

                                <!-- Dimensi -->
                                <div class="mb-3">
                                    <label for="dimensi" class="form-label">Berapa Dimensi</label>
                                    <select id="dimensi" name="dimensi" class="form-select" required>
                                        <option value="" disabled selected>Pilih Dimensi</option>
                                        <option value="2D">2D</option>
                                        <option value="3D">3D</option>
                                    </select>
                                </div>

                                <!-- Producer -->
                                <div class="mb-3">
                                    <label for="producer" class="form-label">Producer</label>
                                    <input type="text" id="producer" name="producer" class="form-control" required>
                                </div>

                                <!-- Director -->
                                <div class="mb-3">
                                    <label for="director" class="form-label">Director</label>
                                    <input type="text" id="director" name="director" class="form-control" required>
                                </div>

                                <!-- Writer -->
                                <div class="mb-3">
                                    <label for="writer" class="form-label">Writer</label>
                                    <input type="text" id="writer" name="writer" class="form-control" required>
                                </div>

                                <!-- Cast -->
                                <div class="mb-3">
                                    <label for="cast" class="form-label">Cast</label>
                                    <input type="text" id="cast" name="cast" class="form-control" required>
                                </div>

                                <!-- Distributor -->
                                <div class="mb-3">
                                    <label for="distributor" class="form-label">Distributor</label>
                                    <input type="text" id="distributor" name="distributor" class="form-control" required>
                                </div>

                                <!-- Harga -->
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga Per Tiket</label>
                                    <input type="number" id="harga" name="harga" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <?php
    include 'components/footer.php'
    ?>

    <!-- BEGIN VENDOR JS-->
    <script src="theme-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
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
</body>

</html>