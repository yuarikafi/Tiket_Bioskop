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
    <style>
         body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        #manual-input {
            margin-top: 20px;
            text-align: center;
        }

        input[type="text"] {
            padding: 10px;
            width: 250px;
            font-size: 16px;
        }

        button {
            padding: 10px 15px;
            font-size: 16px;
            margin-left: 5px;
        }
    </style>
</head>

<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">

    <!-- fixed-top-->
    <?php
    include 'components/navbar.php'
    ?>

    <div class="app-content content" style="margin-top: 20px;">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <h2 style="text-align: center;">Scan Ticket</h2>
    <!-- QR Reader -->
    <div id="reader" style="width: 100%; max-width: 500px; margin: 0 
auto;"></div>
    <!-- Manual Input -->
    <div id="manual-input">
        <p>Atau masukkan Order ID secara manual:</p>
        <input type="text" id="manualOrderId" placeholder="Masukkan Order ID">
        <button onclick="goToPrint()">Cari Tiket</button>
    </div>
    <script>
        // Start QR scan on page load
        window.onload = function() {
            const html5QrCode = new Html5Qrcode("reader");
            const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                html5QrCode.stop().then(() => {
                    window.location.href =
                        `print.php?order_id=${encodeURIComponent(decodedText)}`;
                }).catch(err => console.log("Stop failed", err));
            };
            const config = {
                fps: 10,
                qrbox: 250
            };
            html5QrCode.start({
                    facingMode: "environment"
                },
                config,
                qrCodeSuccessCallback
            ).catch(err => {
                console.error("Camera start error", err);
            });
        };
        // Manual input function
        function goToPrint() {
            const orderId = document.getElementById("manualOrderId").value.trim();
            if (orderId !== "") {
                window.location.href =
                    `print.php?order_id=${encodeURIComponent(orderId)}`;
            } else {
                alert("Masukkan Order ID terlebih dahulu.");
            }
        }
        // Trigger enter key in input
        document.getElementById("manualOrderId").addEventListener("keydown",
            function(e) {
                if (e.key === "Enter") {
                    goToPrint();
                }
            });
    </script>
    </div>

    

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