<?php
require '../koneksi.php';

if (isset($_GET['id_pembina'])) {
    $id_pembina = $_GET['id_pembina'];

    $query = "DELETE FROM pembina WHERE id_pembina = '$id_pembina'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='daftar_pembina.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location='daftar_pembina.php';</script>";
}
?>
