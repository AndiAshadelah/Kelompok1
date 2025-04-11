<?php
include '../koneksi.php';

// Periksa apakah NIS dikirim melalui URL
if (isset($_GET['nis'])) {
    $nis = $_GET['nis'];

    // Hapus data siswa
    $query = "DELETE FROM siswa WHERE nis='$nis'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='../index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "NIS tidak ditemukan.";
}
?>
