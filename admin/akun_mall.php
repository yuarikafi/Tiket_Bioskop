<?php
// menyertakan outloader Composer //
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;  


session_start();

//instalasi variabel untuk menyiapkan input //
$name = '';
$email = '';
$password = '';

if (isset($_POST['send_otp'])) {
    $name = $_POST['nik'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $id = $_POST['id'];

    // Simpan password di session //
    $_SESSION['id'] = $password;

    //Generate OTP //

    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;
    $_SESSION['nik'] = $name;
    $_SESSION['id'] = $id;
    $_SESSION['otp_sent_time'] = time(); //store the time otp was sent //

    // Kirim email otp //
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'yuarichoirulkafikafi@gmail.com';
        $mail->Password = 'tupf xche sfat jdzm';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;


        $mail->setFrom('yuarichoirulkafikafi@gmail.com', 'Tiket Bioskop');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verifikasi Akun';
        $mail->Body = "<br> Berikut adalah kode OTP Anda: <b>$otp</b>.<br>Kode ini berlaku selama 15 menit.";
        $mail->send();
        $otp_sent = true;
    } catch (Exception $e) {
        echo "Gagal mengirim email: {$mail->ErrorInfo}";
    }
}

if (isset($_POST['verify_otp'])) {
    $otp_input = $_POST['otp'];
    // Check if OTP is valid and not expired (15 minutes)
    if ($otp_input == $_SESSION['otp'] && (time() - $_SESSION['otp_sent_time'] <
        900)) {
        // OTP valid, simpan data pengguna ke database
        $name = $_SESSION['nik'];
        $email = $_SESSION['email'];
        $id = $_SESSION['id'];
        $password = password_hash($_SESSION['password'], PASSWORD_DEFAULT); // hash password //

        // Koneksi ke database dan insert data pengguna
        $conn = new mysqli("localhost", "root", "", "db_bioskop_kafi");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Use prepared statement
        $stmt = $conn->prepare("UPDATE akun_mall SET nik = ?, email = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $password, $id);

        if ($stmt->execute()) {
            $registration_success = true; // Set flag untuk menampilkan SweetAlert
            // Hapus session setelah verifikasi
            unset($_SESSION['otp']);
            unset($_SESSION['otp_sent_time']);
            unset($_SESSION['password']); // Hapus password dari session
        } else {
            echo "error! " . $stmt->error;
        }
    } else {
        echo "OTP salah atau kadaluarsa";
    }
}
?>


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
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <!-- END Custom CSS-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">

    <!-- fixed-top-->
    <?php
    include 'components/navbar.php'
    ?>

    <div class="app-content content" style="margin-top: 20px;">
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Menu Akun Mall -->
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Manajemen Akun Mall</h4>
                    </div>
                    <?php
                    // Periksa koneksi
                    include '../koneksi.php';
                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    // Ambil data dari tabel akun_mall
                    $sql = "SELECT id, email, password, nama_mall, nik FROM akun_mall";
                    $result = $conn->query($sql);
                    ?>

                    <div class="card-body">
                        <table id="akunMallTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Nama Mall</th>
                                    <th>NIK</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['email']}</td>
                                    <td>***</td>
                                    <td>{$row['nama_mall']}</td>
                                    <td>{$row['nik']}</td>
                                    <td>
                                    <button class='btn btn-warning btn-edit' 
                                            data-id='{$row['id']}' 
                                            data-nama='{$row['nama_mall']}' 
                                            data-nik='{$row['nik']}' 
                                            data-email='{$row['email']}' 
                                            data-password='{$row['password']}'
                                            data-toggle='modal' 
                                            data-target='#modalTambahJadwal'>
                                        Edit
                                    </button>
                                    </td>
                                </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>Tidak ada data</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <?php
                    // Tutup koneksi
                    $conn->close();
                    ?>
                </div>



                <!-- Modal Edit Akun -->

            </div>
        </div>
    </div>

    <script>
        // Menampilkan SweetAlert setelah mengirim OTP
        <?php if (isset($otp_sent) && $otp_sent): ?>
            Swal.fire({
                title: 'OTP Terkirim!',
                text: 'Kode OTP telah dikirim ke email Anda.',
                icon: 'success',
                confirmButtonText: 'OK'

            }).then((result) => {
                if (result.isConfirmed) {
                    var myModal = new bootstrap.Modal(document.getElementById('tambahAkunModal'));
                    myModal.show();
                }
            });
        <?php endif; ?>

        // // Menampilkan SweetAlert setelah pendaftaran berhasil
        <?php if (isset($registration_success) && $registration_success): ?>
            Swal.fire({
                title: 'Pendaftaran Berhasil!',
                text: 'Anda telah berhasil mendaftar. Silakan masuk.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Mengarahkan pengguna ke register.php setelah menekan OK
                window.location.href = 'akun_mall.php'; // Ganti dengan path yang sesuai
            });
        <?php endif; ?>
    </script>

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

    <script>
        $('.btn-edit').click(function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var nik = $(this).data('nik');
            var email = $(this).data('email');
            $('#edit-id').val(id);
            $('#edit-nama').val(nama);
            $('#edit-nik').val(nik);
            $('#edit-email').val(email);
        });
    </script>

    <script>
        // Menampilkan SweetAlert setelah mengirim OTP
        <?php if (isset($otp_sent) && $otp_sent): ?>
            Swal.fire({
                title: 'OTP Terkirim!',
                text: 'Kode OTP telah dikirim ke email Anda.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    var myModal = new
                    bootstrap.Modal(document.getElementById('modalTambahJadwal'));
                    myModal.show();
                }
            });
        <?php endif; ?>
        // // Menampilkan SweetAlert setelah pendaftaran berhasil
        <?php if (isset($registration_success) && $registration_success): ?>
            Swal.fire({
                title: 'Pendaftaran Berhasil!',
                text: 'Anda telah berhasil Mengupdate.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Mengarahkan pengguna ke register.php setelah menekan OK
                window.location.href = 'akun_mall.php'; // Ganti dengan path yang sesuai
            });
        <?php endif; ?>
    </script>
</body>

<div class="modal fade" id="modalTambahJadwal" tabindex="-1" aria-labelledby="modalTambahJadwalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahJadwalLabel">Edit Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="akun_mall.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Mall</label>
                        <input type="text" class="form-control" name="name" id="edit-nama" value="<?php echo isset($_SESSION['nama_mall']) ? htmlspecialchars($_SESSION['nama_mall']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">

                        <input type="hidden" class="form-control" name="id" id="edit-id" value="<?php echo isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" name="nik" id="edit-nik" value="<?php echo isset($_SESSION['nik']) ? htmlspecialchars($_SESSION['nik']) : ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" id="edit-email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" name="send_otp" class="btn btn-primary">Kirim OTP</button>
                </form>
                <?php if (isset($_SESSION['otp'])): ?>
                    <form action="akun_mall.php" method="POST">
                        <div class="mb-3">
                            <label for="otp" class="form-label">Masukan OTP</label>
                            <input type="text" class="form-control" name="otp" required>
                        </div>
                        <button type="submit" name="verify_otp" class="btn btn-success">Verifikasi OTP</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

</html>