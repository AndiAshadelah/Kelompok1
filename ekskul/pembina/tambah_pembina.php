<?php
require '../koneksi.php';

// Ambil daftar ekskul untuk dropdown
$queryEkskul = "SELECT * FROM ekskul";
$resultEkskul = mysqli_query($conn, $queryEkskul);

// Proses tambah data
if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kompetensi = mysqli_real_escape_string($conn, $_POST['kompetensi']);
    $id_ekskul = isset($_POST['ekskul']) ? $_POST['ekskul'] : ''; // Ekskul hanya satu

    // Pastikan semua field terisi
    if (!empty($nama) && !empty($kompetensi) && !empty($id_ekskul)) {
        
        // Cek jumlah pembina pada ekskul yang dipilih
        $queryCount = "SELECT COUNT(*) AS jumlah_pembina FROM pembina_ekskul WHERE id_ekskul = '$id_ekskul'";
        $resultCount = mysqli_query($conn, $queryCount);
        $rowCount = mysqli_fetch_assoc($resultCount);

        // Jika pembina sudah mencapai 2, tampilkan pesan
        if ($rowCount['jumlah_pembina'] >= 2) {
            echo "<script>alert('Jumlah pembina untuk ekskul ini sudah mencapai maksimal (2).'); window.location='daftar_pembina.php';</script>";
        } else {
            // Tambahkan data pembina
            $queryInsertPembina = "INSERT INTO pembina (nama, kompetensi) VALUES ('$nama', '$kompetensi')";
            if (mysqli_query($conn, $queryInsertPembina)) {
                $id_pembina = mysqli_insert_id($conn); // Ambil ID pembina yang baru

                // Tambahkan ke tabel pembina_ekskul
                $queryInsertPivot = "INSERT INTO pembina_ekskul (id_pembina, id_ekskul) VALUES ('$id_pembina', '$id_ekskul')";
                if (mysqli_query($conn, $queryInsertPivot)) {
                    echo "<script>alert('Data pembina berhasil ditambahkan!'); window.location='daftar_pembina.php';</script>";
                } else {
                    echo "<script>alert('Gagal menambahkan pembina ke ekskul!');</script>";
                }
            } else {
                echo "<script>alert('Gagal menambahkan pembina!');</script>";
            }
        }
    } else {
        echo "<script>alert('Harap isi semua data dan pilih satu ekskul!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pembina</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #a18cd1, #fbc2eb);
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 25px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.15);
            width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            text-align: left;
            font-weight: 600;
            margin-top: 10px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #937bcb;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #a18cd1;
        }

        .back-link {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            font-weight: bold;
            color: #553c92;
        }

        .back-link:hover {
            color: #a18cd1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Pembina</h2>
        <form action="" method="post">
            <label>Nama Pembina:</label>
            <input type="text" name="nama" required>

            <label>Kompetensi:</label>
            <input type="text" name="kompetensi" required>

            <label>Pilih Ekskul:</label>
            <select name="ekskul" required>
                <option value="">-- Pilih Ekskul --</option>
                <?php while ($row = mysqli_fetch_assoc($resultEkskul)) { ?>
                    <option value="<?= htmlspecialchars($row['id_ekskul']); ?>">
                        <?= htmlspecialchars($row['nama_ekskul']); ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit" name="submit">Simpan</button>
        </form>
        <a href="daftar_pembina.php" class="back-link">Kembali</a>
    </div>
</body>
</html>
