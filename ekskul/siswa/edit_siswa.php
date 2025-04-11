<?php
include '../koneksi.php';

// Ambil NIS dari URL
if (isset($_GET['nis'])) {
    $nis = $_GET['nis'];

    // Ambil data siswa berdasarkan NIS
    $query = "SELECT * FROM siswa WHERE nis='$nis'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "Data siswa tidak ditemukan.";
        exit;
    }
}

// Jika form disubmit
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $ekskul = $_POST['ekskul'];
    $kelas = $_POST['kelas'];

    // Update data siswa
    $updateQuery = "UPDATE siswa SET nama='$nama', ekskul='$ekskul', kelas='$kelas' WHERE nis='$nis'";
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='daftar_siswa.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Ambil daftar ekskul dari tabel ekskul
$ekskulQuery = "SELECT * FROM ekskul";
$ekskulResult = mysqli_query($conn, $ekskulQuery);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
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
            width: 80%;
            max-width: 500px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            font-weight: bold;
            text-align: left;
            margin-bottom: 5px;
        }
        select, input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            padding: 10px 15px;
            border: none;
            background: #a18cd1;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }
        button:hover {
            background: #8e78c4;
        }
        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #4a4a4a;
            font-weight: bold;
        }
        a:hover {
            color: #a18cd1;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Data Siswa</h2>
        <form method="POST">
            <label>NIS:</label>
            <input type="text" name="nis" value="<?= htmlspecialchars($row['NIS']) ?>" readonly>
            
            <label>Nama:</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($row['nama']) ?>" required>
            
            <label>Ekskul:</label>
            <select name="ekskul" required>
                <option value="">Pilih Ekskul</option>
                <?php while ($ekskul = mysqli_fetch_assoc($ekskulResult)) : ?>
    <?php if (!isset($ekskul['id_ekskul'])) { continue; } // Lewati jika id_ekskul tidak ada ?>
    <option value="<?= htmlspecialchars($ekskul['nama_ekskul']); ?>" 
    <?= ($row['ekskul'] == $ekskul['nama_ekskul']) ? 'selected' : ''; ?>>
    <?= htmlspecialchars($ekskul['nama_ekskul']); ?>
                </option>
<?php endwhile; ?>

            </select>

            <label for="kelas">Kelas:</label>
            <select id="kelas" name="kelas" required>
                <option value="">Pilih Kelas</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
            </select>
            
            <button type="submit" name="submit">Simpan</button>
            <a href="daftar_siswa.php">Batal</a>
        </form>
    </div>

</body>
</html>
