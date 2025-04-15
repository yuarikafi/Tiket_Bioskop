<?php
require 'vendor/autoload.php'; // Pastikan path benar
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
$alert_message = "";
$alert_type = "";
if (isset($_POST['send_otp'])) {
    $email = $_POST['email'];
    $_SESSION['email'] = $email;
    $conn = new mysqli("localhost", "root", "", "db_bioskop_kafi");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_sent_time'] = time();
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'yuarichoirulkafikafi@gmail.com';
            $mail->Password = 'tupf xche sfat jdzm';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->setFrom('yuarichoirulkafikafi@gmail.com', 'Tiket Bioskop');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'OTP Reset Password';
            $mail->Body = "Kode OTP Anda: <b>$otp</b>. Berlaku selama 15
menit.";
            $mail->send();
            $alert_message = "Kode OTP telah dikirim ke email Anda.";
            $alert_type = "success";
        } catch (Exception $e) {
            $alert_message = "Gagal mengirim email: {$mail->ErrorInfo}";
            $alert_type = "error";
        }
    } else {
        $alert_message = "Email tidak ditemukan.";
        $alert_type = "error";
    }
}
if (isset($_POST['verify_otp'])) {
    $otp_input = $_POST['otp'];
    if ($otp_input == $_SESSION['otp'] && (time() - $_SESSION['otp_sent_time']
        < 900)) {
        $_SESSION['otp_verified'] = true;
    } else {
        $alert_message = "OTP salah atau kadaluarsa.";
        $alert_type = "error";
    }
}
if (isset($_POST['reset_password']) && isset($_SESSION['otp_verified'])) {
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $email = $_SESSION['email'];
    $conn = new mysqli("localhost", "root", "", "db_bioskop_kafi");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $new_password, $email);
    if ($stmt->execute()) {
        $alert_message = "Password berhasil direset.";
        $alert_type = "success";
        session_destroy();
    } else {
        $alert_message = "Gagal mereset password.";
        $alert_type = "error";
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
    <link rel="icon" type="image/png" href="img/logo_cinema.png" sizes="256x256">
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

        .login-nav__item+.login-nav__item {
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

        .login__input+.login__label {
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
    <!-- Tetap tampilkan menu Forget Password -->
    <ul class="login-nav" style="position: relative; z-index: 1;">
        <li class="login-nav__item">
            <a href="forget.php">Forget Password</a>
        </li>
    </ul>

    <!-- Form Kirim OTP -->
    <?php if (!isset($_SESSION['otp']) && !isset($_SESSION['otp_verified'])): ?>
        <form method="POST" id="emailForm" class="form-login">
            <label class="login__label">Email:</label>
            <input type="email" class="login__input" name="email" placeholder="Masukkan Email Anda" required>
            <button type="submit" name="send_otp" class="login__submit">Kirim OTP</button>
        </form>
    <?php endif; ?>

    <!-- Form Verifikasi OTP -->
    <?php if (isset($_SESSION['otp']) && !isset($_SESSION['otp_verified'])): ?>
        <form method="POST" class="form-login mt-3" id="otpForm">
            <label class="login__label">Masukkan OTP:</label>
            <input type="text" class="login__input" name="otp" required>
            <button type="submit" name="verify_otp" class="login__submit">Verifikasi OTP</button>
        </form>
    <?php endif; ?>

    <!-- Form Reset Password -->
    <?php if (isset($_SESSION['otp_verified'])): ?>
        <form method="POST" class="form-login mt-3" id="passwordForm">
            <label class="login__label">Password Baru:</label>
            <input type="password" class="login__input" name="new_password" required>
            <button type="submit" name="reset_password" class="login__submit">Reset Password</button>
        </form>
    <?php endif; ?>
     <!-- Tampilkan link login di bagian atas card -->
     <div class="text-center mb-4" style="position: relative; z-index: 1;">
        <p class="mb-0 text-white">Sudah punya akun? <a href="login.php" class="text-primary fw-bold">Login</a></p>
    </div>
</div>


    <!-- Script -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        <?php if (!empty($alert_message)): ?>
            Swal.fire({
                title: "<?= $alert_type == 'success' ? 'Berhasil' : 'Gagal' ?>",
                text: "<?= $alert_message ?>",
                icon: "<?= $alert_type ?>",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = 'forget.php';
            });
        <?php endif; ?>
    </script>

</body>

</html>