<?php
// menyertakan outloader composer //
require '../vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

// inisialisasi variabel untuk menyiapkan input //
$name = '';
$email = '';
$password = '';

if (isset($_POST['send_otp'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // simpan password dalam session //
    $_SESSION['password'] = $password;

    // general otp //
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $name;
    $_SESSION['otp_sent_time'] = time();

    // kirim email otp //
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail-> Host = 'smtp.gmail.com';
        $mail-> SMTPAuth = true;
        $mail-> Username = 'yuarichoirulkafikafi@gmail.com';
        $mail-> Password = 'tupf xche sfat jdzm';
        $mail-> SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail-> Port = 465;

        $mail-> setFrom('yuarichoirulkafikafi@gmail.com', 'Tiket Bioskop');
        $mail-> addAddress($email);

        $mail-> isHTML(true);
        $mail-> Subject = 'otp Verifikasi Akun';
        $mail-> Body = "Hai $name <br> Berikut Adalah Kode OTP Anda : <b>$otp</b>.<br>Kode ini berkalu selama 15 menit.";

        $mail-> send();
        $otp_sent = true;
    } catch (Exception $e) {
        echo "Gagal mengirim email! {$mail->ErrorInfo}";
    }
}

if (isset($_POST['verify_otp'])) {
    $otp_input = $_POST['otp'];

    //validasi 15 menit//
    if ($otp_input == $_SESSION['otp'] && (time() - $_SESSION['otp_sent_time'] < 900)) {
        // otp valid, simpan data pengguna ke database //
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        $password = password_hash($_SESSION['password'], PASSWORD_DEFAULT);

        // koneksi ke database dan insert data pengguna //
        $conn = new mysqli("localhost", "root", "", "db_bioskop_kafi");
        if ($conn->connect_error) {
            die("Connecrion failed! " . $conn->connect_error);
        }

        // use prepared statment //
        $stmt = $conn->prepare("INSERT INTO admin (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            $registration_succes = true;
            // hapus session telah verifikasi //
            unset($_SESSION['otp']);
            unset($_SESSION['otp_sent_time']);
            unset($_SESSION['password']);
        } else {
            echo "Error! " . $stmt->error;
        }
    } else {
        echo "OTP salah atau kadaluarsa!. ";
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
                <!-- Menu Akun Admin -->
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Manajemen Akun Admin</h4>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahAkunModal">Tambah Akun</button>
                    </div>
                    <?php
                    // Periksa koneksi
                    include '../koneksi.php';
                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    // Ambil data dari tabel admin
                    $sql = "SELECT id, name, email FROM admin";
                    $result = $conn->query($sql);
                    ?>

                    <div class="card-body">
                        <table id="adminTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center'>Tidak ada data</td></tr>";
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

                <!-- Modal Tambah Akun -->
                <div class="modal fade" id="tambahAkunModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">Tambah Akun Admin</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="akun_admin.php" method="post" class="form-login">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="name" placeholder="Masukkan Nama" value="<?php echo htmlspecialchars($name); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" value="<?php echo htmlspecialchars($email); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password">
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" name="send_otp">Kirim OTP</button>
                                    </div>
                                </form>

                                <?php if (isset($_SESSION['otp'])): ?>
                                    <form action="akun_admin.php" method="POST" class="form-login">
                                        <div class="form-group">
                                            <label for="otp">Masukkan OTP</label>
                                            <input type="text" class="form-control" id="otp" name="otp" placeholder="Masukkan OTP" required>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="verify_otp" class="btn btn-success">Verifikasi OTP</button>
                                        </div>
                                    </form>
                                <?php endif; ?>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
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
      window.location.href = 'akun_admin.php'; // Ganti dengan path yang sesuai
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
</body>

</html>