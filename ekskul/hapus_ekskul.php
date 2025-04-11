<?php
include 'koneksi.php'; // Pastikan koneksi ke database

// Periksa apakah ada parameter id_ekskul yang dikirimkan
if (isset($_GET['id_ekskul'])) {
    $id_ekskul = $_GET['id_ekskul'];

    // Query untuk menghapus data
    $query = "DELETE FROM ekskul WHERE id_ekskul = '$id_ekskul'";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Ekskul berhasil dihapus!'); window.location='daftar_ekskul.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus ekskul: " . mysqli_error($conn) . "');</script>";
    }
} else {
    echo "<script>alert('ID Ekskul tidak ditemukan!'); window.location='daftar_ekskul.php';</script>";
}
?>
