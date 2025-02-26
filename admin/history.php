<?php 
include '../koneksi.php';

//Query untuk mengambil data //
$sql = "SELECT * FROM transaction ORDER BY id ASC";
$result = $conn->query($sql); 

?>