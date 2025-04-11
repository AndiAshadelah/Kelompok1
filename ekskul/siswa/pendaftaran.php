<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama  = mysqli_real_escape_string($conn, $_POST['nama']);
    $nis   = mysqli_real_escape_string($conn, $_POST['nis']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);
    $ekskul = mysqli_real_escape_string($conn, $_POST['ekskul']); // Menyimpan ekskul yang dipilih

    // Cek apakah NIS sudah terdaftar
    $cekNIS = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$nis'");
    if (mysqli_num_rows($cekNIS) > 0) {
        echo "<script>alert('NIS sudah terdaftar!'); window.location='daftar_siswa.php';</script>";
        exit();
    }

    // Simpan ke database
    $sql = "INSERT INTO siswa (nama, nis, kelas, ekskul) VALUES ('$nama', '$nis', '$kelas', '$ekskul')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Pendaftaran berhasil!'); window.location='daftar_siswa.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Ambil daftar ekskul dari database
$ekskulQuery = mysqli_query($conn, "SELECT * FROM ekskul");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Siswa</title>
    <style>
        /* Reset default margin and padding */
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
            margin-bottom: 40px;
            color: #333;
        }

        label {
            display: block;
            text-align: left;
            font-weight: 600;
            margin: 10px 0 5px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input:focus, select:focus {
            border-color: #a18cd1;
            outline: none;
            box-shadow: 0 0 5px rgba(79, 172, 254, 0.5);
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background: rgb(147, 123, 203);
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background:#a18cd1;
        }

        .back-link {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            font-weight: bold;
            color: rgb(85, 60, 146);
        }

        .back-link:hover {
            color: #a18cd1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pendaftaran Siswa</h2>
        <form action="" method="POST">
            <label for="nama">Nama Lengkap:</label>
            <input type="text" id="nama" name="nama" required>

            <label for="nis">NIS:</label>
            <input type="number" id="nis" name="nis" required>

            <label for="kelas">Kelas:</label>
            <select id="kelas" name="kelas" required>
                <option value="">Pilih Kelas</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
            </select>

            <label for="ekskul">Pilih Ekstrakurikuler:</label>
            <select id="ekskul" name="ekskul" required>
                <option value="">Pilih Ekstrakurikuler</option>
                <?php while ($row = mysqli_fetch_assoc($ekskulQuery)) : ?>
                    <option value="<?= $row['nama_ekskul']; ?>"><?= $row['nama_ekskul']; ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Daftar</button>
        </form>

        <a href="daftar_siswa.php" class="back-link">Kembali</a>
    </div>
</body>
</html>
