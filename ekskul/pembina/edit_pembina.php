<?php
require '../koneksi.php';

// Ambil daftar ekskul untuk dropdown
$queryEkskul = "SELECT * FROM ekskul";
$resultEkskul = mysqli_query($conn, $queryEkskul);

// Proses tambah data
if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $kompetensi = mysqli_real_escape_string($conn, trim($_POST['kompetensi']));
    $ekskul = isset($_POST['ekskul']) ? $_POST['ekskul'] : []; // Cek apakah ekskul dipilih

    if (!empty($nama) && !empty($kompetensi) && !empty($ekskul)) {
        // Tambahkan data pembina
        $queryInsertPembina = "INSERT INTO pembina (nama, kompetensi) VALUES ('$nama', '$kompetensi')";
        if (mysqli_query($conn, $queryInsertPembina)) {
            $id_pembina = mysqli_insert_id($conn); // Ambil ID pembina yang baru

            // Tambahkan ke tabel pivot pembina_ekskul
            foreach ($ekskul as $id_ekskul) {
                $queryInsertPivot = "INSERT INTO pembina_ekskul (id_pembina, id_ekskul) VALUES ('$id_pembina', '$id_ekskul')";
                mysqli_query($conn, $queryInsertPivot);
            }

            echo "<script>alert('Data pembina berhasil ditambahkan!'); window.location='daftar_pembina.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan pembina!');</script>";
        }
    } else {
        echo "<script>alert('Harap isi semua data dan pilih setidaknya satu ekskul!');</script>";
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
            font-weight: bold;
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
            background: #937BCB;
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
            color: rgb(85, 60, 146);
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
            <select name="ekskul[]" multiple required>
                <?php while ($row = mysqli_fetch_assoc($resultEkskul)) { ?>
                    <option value="<?= $row['id_ekskul']; ?>"><?= $row['nama_ekskul']; ?></option>
                <?php } ?>
            </select>
            <p>* Gunakan Ctrl + Klik untuk memilih lebih dari satu ekskul</p>

            <button type="submit" name="submit">Simpan</button>
        </form>
        <a href="daftar_pembina.php" class="back-link">Kembali</a>
    </div>
</body>
</html>
