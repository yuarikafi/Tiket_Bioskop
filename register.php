<?php
// Menyertakan autoloader Composer
require 'vendor/autoload.php'; // Pastikan pathnya sesuai dengan struktur project Anda
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
// Inisialisasi variabel untuk menyimpan input
$name = '';
$email = '';
$password = '';
if (isset($_POST['send_otp'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Simpan password di session
    $_SESSION['password'] = $password;
    // Generate OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $name;
    $_SESSION['otp_sent_time'] = time(); // Store the time OTP was sent
    // Kirim email OTP
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'yuarichoirulkafikafi@gmail.com';
        $mail->Password = 'tupf xche sfat jdzm'; // Gunakan App Password jika 2FA aktif
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Untuk port 465
        $mail->Port = 465; // Port untuk SSL
        $mail->setFrom('yuarichoirulkafikafi@gmail.com', 'Tiket Bioskop');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verifikasi Akun';
        $mail->Body = "Hai $name, <br> Berikut adalah kode OTP Anda:
<b>$otp</b>.<br>Kode ini berlaku selama 15 menit.";
        $mail->send();
        $otp_sent = true; // Set flag untuk menampilkan SweetAlert
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
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        $password = password_hash($_SESSION['password'], PASSWORD_DEFAULT); //Hash password
        // Koneksi ke database dan insert data pengguna
        $conn = new mysqli("localhost", "root", "", "db_bioskop_kafi");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Use prepared statement
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES
(?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        if ($stmt->execute()) {
            $registration_success = true; // Set flag untuk menampilkan SweetAlert
            // Hapus session setelah verifikasi
            unset($_SESSION['otp']);
            unset($_SESSION['otp_sent_time']);
            unset($_SESSION['password']); // Hapus password dari session
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "OTP salah atau kadaluarsa.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #e9e9e9;
            font-family: 'Montserrat', sans-serif;
            font-size: 16px;
            line-height: 1.25;
            letter-spacing: 1px;
        }

        * {
            box-sizing: border-box;
            transition: .25s all ease;
        }

        .login-container {
            display: block;
            position: absolute;
            z-index: 0;
            margin: auto;
            /* Pusatkan secara horizontal */
            padding: 5rem 4rem 0 4rem;
            width: 100%;
            max-width: 450px;
            /* Lebih kecil dari sebelumnya */
            min-height: 550px;
            /* Kurangi tinggi */
            background-image: url("img/logo10000.png");
            box-shadow: 0 50px 70px -20px rgba(0, 0, 0, 0.85);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /* Pusatkan secara vertikal */
        }

        .login-container:after {
            content: '';
            display: inline-block;
            position: absolute;
            z-index: 0;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-image: radial-gradient(ellipse at left bottom, rgba(22, 24, 47, 1) 0%, rgba(38, 20, 72, .9) 59%, rgba(17, 27, 75, .9) 100%);
            box-shadow: 0 -20px 150px -20px rgba(0, 0, 0, 0.5);
        }

        .form-login {
            position: relative;
            z-index: 1;
            padding-bottom: 4.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.25);
        }

        .login-nav {
            position: relative;
            padding: 0;
            margin: 0 0 6em 1rem;
        }

        .login-nav__item {
            list-style: none;
            display: inline-block;
        }

        .login-nav_item+.login-nav_item {
            margin-left: 2.25rem;
        }

        .login-nav__item a {
            position: relative;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            text-transform: uppercase;
            font-weight: 500;
            font-size: 1.25rem;
            padding-bottom: .5rem;
            transition: .20s all ease;
        }

        .login-nav__item.active a,
        .login-nav__item a:hover {
            color: #ffffff;
            transition: .15s all ease;
        }

        .login-nav__item a:after {
            content: '';
            display: inline-block;
            height: 10px;
            background-color: rgb(255, 255, 255);
            position: absolute;
            right: 100%;
            bottom: -1px;
            left: 0;
            border-radius: 50%;
            transition: .15s all ease;
        }

        .login-nav__item a:hover:after,
        .login-nav__item.active a:after {
            background-color: rgb(17, 97, 237);
            height: 2px;
            right: 0;
            bottom: 2px;
            border-radius: 0;
            transition: .20s all ease;
        }

        .login__label {
            display: block;
            padding-left: 1rem;
        }

        .login__label,
        .login__label--checkbox {
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            font-size: .75rem;
            margin-bottom: 1rem;
        }

        .login__label--checkbox {
            display: inline-block;
            position: relative;
            padding-left: 1.5rem;
            margin-top: 2rem;
            margin-left: 1rem;
            color: #ffffff;
            font-size: .75rem;
            text-transform: inherit;
        }

        .login__input {
            color: white;
            font-size: 1.15rem;
            width: 100%;
            padding: .5rem 1rem;
            border: 2px solid transparent;
            outline: none;
            border-radius: 1.5rem;
            background-color: rgba(255, 255, 255, 0.25);
            letter-spacing: 1px;
        }

        .login__input:hover,
        .login__input:focus {
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.5);
            background-color: transparent;
        }

        .login_input+.login_label {
            margin-top: 1.5rem;
        }

        .login__input--checkbox {
            position: absolute;
            top: .1rem;
            left: 0;
            margin: 0;
        }

        .login__submit {
            color: #ffffff;
            font-size: 1rem;
            font-family: 'Montserrat', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 1rem;
            padding: .75rem;
            border-radius: 2rem;
            display: block;
            width: 100%;
            background-color: rgba(17, 97, 237, .75);
            border: none;
            cursor: pointer;
        }

        .login__submit:hover {
            background-color: rgba(17, 97, 237, 1);
        }

        .login__forgot {
            display: block;
            margin-top: 3rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.75);
            font-size: .75rem;
            text-decoration: none;
            position: relative;
            z-index: 1;
        }

        .login__forgot:hover {
            color: rgb(17, 97, 237);
        }
    </style>
</head>

<body>
    <div class="login-container">
        <form action="register.php" method="post" class="form-login">
            <ul class="login-nav">
                <li class="login-nav__item ">
                    <a href="login.php">Sign In</a>
                </li>
                <li class="login-nav__item active">
                    <a href="register.php">Sign Up</a>
                </li>
            </ul>
            <label for="login-input-user" class="login__label">
                Username
            </label>
            <input id="login-input-user" class="login__input" type="text " name="name"
                value="<?php echo htmlspecialchars($name); ?>" />

            <label for="login-input-email" class="login__label">
                Email
            </label>
            <input id="login-input-email" class="login__input" type="text " name="email"
                value="<?php echo htmlspecialchars($email); ?>" />


            <label for="login-input-password" class="login__label">
                Password
            </label>
            <input id="login-input-password" class="login__input" type="password" name="password" />
            <button class="login__submit" type="submit" name="send_otp">Kirim OTP</button>
        </form>
        <?php if (isset($_SESSION['otp'])): ?>
            <form action="register.php" method="POST" class="form-login">
                <label for="otp" class="login__label">Masukan OTP</label>
                <input type="text" class="login__input" name="otp"
                    required>
                <button type="submit" name="verify_otp" class="login__submit">Verifikasi OTP</button>
            </form>
        <?php endif; ?>
    </div>
    <script>
        // Menampilkan SweetAlert setelah mengirim OTP
        <?php if (isset($otp_sent) && $otp_sent): ?>
            Swal.fire({
                title: 'OTP Terkirim!',
                text: 'Kode OTP telah dikirim ke email Anda.',
                icon: 'success',
                confirmButtonText: 'OK'
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
                // // Mengarahkan pengguna ke register.php setelah menekan OK
                window.location.href = 'login.php'; // Ganti dengan path yang sesuai
            });
        <?php endif; ?>
    </script>
</body>

</html>