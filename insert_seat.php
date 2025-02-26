<?php 
require "koneksi.php";

// Pastikan semua input tersedia
$seat_numbers = explode(",", $_POST['seat_number'] ?? ""); 
$mall_name = $_POST['mall_name'] ?? null;
$film_name = $_POST['film_name'] ?? null;

if (empty($seat_numbers) || empty($mall_name) || empty($film_name)) {
    echo json_encode(["success" => false, "error" => "Data tidak lengkap"]);
    exit;
}

$success = true;

foreach ($seat_numbers as $seat_number) {
    // Cek apakah kursi sudah dipesan
    $stmtCheck = $conn->prepare("SELECT id FROM seats WHERE seat_number = ? AND mall_name = ? AND film_name = ?");
    $stmtCheck->bind_param("sss", $seat_number, $mall_name, $film_name);
    
    if (!$stmtCheck->execute()) {
        $success = false;
        error_log("Error saat cek kursi: " . $stmtCheck->error);
        continue;
    }
    
    $resultCheck = $stmtCheck->get_result();
    if ($resultCheck->num_rows > 0) { 
        // Kursi sudah diambil, lanjutkan ke kursi berikutnya
        error_log("Kursi $seat_number sudah dipesan.");
        $success = false;
        continue;
    }

    // Masukkan kursi ke database
    $stmtInsert = $conn->prepare("INSERT INTO seats (seat_number, mall_name, film_name, status) VALUES (?, ?, ?, 'occupied')");
    $stmtInsert->bind_param("sss", $seat_number, $mall_name, $film_name);

    if (!$stmtInsert->execute()) {
        $success = false;
        error_log("Error saat insert kursi: " . $stmtInsert->error);
        continue;
    }

    error_log("Kursi $seat_number berhasil dipesan.");
}

echo json_encode(["success" => $success]);
?>