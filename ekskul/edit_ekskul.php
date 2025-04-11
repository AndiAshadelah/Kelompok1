<?php
require 'koneksi.php'; // Pastikan koneksi database sudah benar

// Jika ada parameter id_ekskul di URL, ambil data ekskul
if (isset($_GET['id_ekskul'])) {
    $id_ekskul = $_GET['id_ekskul'];
    
    // Ambil data ekskul dari database
    $queryEkskul = "SELECT * FROM ekskul WHERE id_ekskul = '".mysqli_real_escape_string($conn, $id_ekskul)."' LIMIT 1";
    $resultEkskul = mysqli_query($conn, $queryEkskul);

    if (mysqli_num_rows($resultEkskul) > 0) {
        $rowEkskul = mysqli_fetch_assoc($resultEkskul);
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location='daftar_ekskul.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID ekskul tidak ditemukan!'); window.location='daftar_ekskul.php';</script>";
    exit();
}

// Ambil semua siswa dari database untuk dropdown
$querySiswa = "SELECT * FROM siswa";
$resultSiswa = mysqli_query($conn, $querySiswa);

// Proses update data jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_ekskul = mysqli_real_escape_string($conn, $_POST['nama_ekskul']);
    $nama_siswa  = mysqli_real_escape_string($conn, $_POST['nama_siswa']);
    $desk_umum   = mysqli_real_escape_string($conn, $_POST['desk_umum']);
    $singkatan   = mysqli_real_escape_string($conn, $_POST['singkatan']);

    // Query update data
    $queryUpdate = "UPDATE ekskul SET 
                nama_ekskul = '$nama_ekskul', 
                nama_siswa  = '$nama_siswa', 
                desk_umum   = '$desk_umum', 
                singkatan   = '$singkatan' 
              WHERE id_ekskul = '$id_ekskul'";

    if (mysqli_query($conn, $queryUpdate)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='daftar_ekskul.php';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal memperbarui data!'); window.history.back();</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ekskul</title>
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body {
            background: linear-gradient(to right, #a18cd1, #fbc2eb);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.15);
            width: 400px;
            text-align: center;
        }
        select, input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        button:hover { background: #218838; }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Ekskul</h2>
    <form action="" method="post">
        
        <label>Nama Ekskul:</label>
        <input type="text" name="nama_ekskul" value="<?= htmlspecialchars($rowEkskul['nama_ekskul']) ?>" required>

        <label>Pilih Siswa:</label>
            <select name="id_siswa" required>
                <option value="" disabled selected>Pilih Siswa</option>
                <?php while ($siswa = mysqli_fetch_assoc($resultSiswa)) { ?>
                    <option value="<?= htmlspecialchars($siswa['id_siswa']); ?>">
                        <?= htmlspecialchars($siswa['nama']); ?>
                    </option>
                <?php } ?>
            </select>

        <label>Deskripsi:</label>
        <textarea name="desk_umum" required><?= htmlspecialchars($rowEkskul['desk_umum']) ?></textarea>

        <label>Singkatan:</label>
        <input type="text" name="singkatan" value="<?= htmlspecialchars($rowEkskul['singkatan']) ?>" required>

        <button type="submit">Simpan Perubahan</button>
    </form>
</div>

</body>
</html>
