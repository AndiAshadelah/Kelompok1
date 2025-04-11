<?php
include 'koneksi.php'; // Pastikan file koneksi.php sudah ada

// Ambil daftar siswa untuk dropdown
$querySiswa = "SELECT * FROM siswa";
$resultSiswa = mysqli_query($conn, $querySiswa);

// Jika tombol submit ditekan
if (isset($_POST['submit'])) {
    $nama_ekskul = mysqli_real_escape_string($conn, $_POST['nama_ekskul']);
    $desk_umum = mysqli_real_escape_string($conn, $_POST['desk_umum']);
    $singkatan = mysqli_real_escape_string($conn, $_POST['singkatan']);
    $id_siswa = mysqli_real_escape_string($conn, $_POST['id_siswa']);

    // Cek apakah ekskul sudah ada
    $cekQuery = "SELECT * FROM ekskul WHERE nama_ekskul = '$nama_ekskul'";
    $cekResult = mysqli_query($conn, $cekQuery);

    if (mysqli_num_rows($cekResult) > 0) {
        echo "<script>alert('Ekskul sudah ada!'); window.location='tambah_ekskul.php';</script>";
    } else {
        // Insert ekskul ke database
        $queryTambahAnggota = "INSERT INTO anggota_ekskul (id_siswa, id_ekskul) VALUES ('$id_siswa', '$id_ekskul')";
        if (mysqli_query($conn, $query)) {
            $id_ekskul = mysqli_insert_id($conn); // Ambil ID ekskul yang baru ditambahkan

            // Tambahkan siswa ke ekskul yang baru ditambahkan
            $queryTambahAnggota = "INSERT INTO anggota_ekskul (id_siswa, id_ekskul) VALUES ('$id_siswa', '$id_ekskul')";
            if (mysqli_query($conn, $queryTambahAnggota)) {
                echo "<script>alert('Ekskul dan anggota berhasil ditambahkan!'); window.location='daftar_ekskul.php';</script>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Ekskul & Anggota</title>
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
        <h2>Tambah Ekskul & Anggota</h2>
        <form method="POST">
            <label>Nama Ekskul:</label>
            <input type="text" name="nama_ekskul" required>

            <label>Deskripsi:</label>
            <textarea name="desk_umum" required></textarea>

            <label>Singkatan:</label>
            <input type="text" name="singkatan" required>

            <label>Pilih Siswa:</label>
            <select name="id_siswa" required>
                <option value="" disabled selected>Pilih Siswa</option>
                <?php while ($siswa = mysqli_fetch_assoc($resultSiswa)) { ?>
                    <option value="<?= htmlspecialchars($siswa['id_siswa']); ?>">
                        <?= htmlspecialchars($siswa['nama']); ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit" name="submit">Tambah Ekskul & Anggota</button>
            <a href="daftar_ekskul.php" class="back-link">Kembali</a>
        </form>
    </div>
</body>
</html>
