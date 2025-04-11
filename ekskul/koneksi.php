<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "ekskul"; // Ganti dengan nama database Anda

$conn = new mysqli($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>
