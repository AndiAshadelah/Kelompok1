<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah ada ID ekskul yang dikirim
if (!isset($_GET['id_ekskul']) || empty($_GET['id_ekskul'])) {
    die("ID Ekskul tidak ditemukan!");
}

$id_ekskul = mysqli_real_escape_string($conn, $_GET['id_ekskul']);

// Query untuk mengambil detail ekskul dan pembina
$sql = "SELECT e.id_ekskul, e.nama_ekskul, e.desk_umum, e.singkatan, e.gambar,
               p.nama AS nama_pembina
        FROM ekskul e
        LEFT JOIN detail_pembina dp ON dp.id_ekskul = e.id_ekskul
        LEFT JOIN pembina p ON p.id_pembina = dp.id_pembina
        WHERE e.id_ekskul = '$id_ekskul'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}

// Mengumpulkan data hasil query
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Jika data ekskul tidak ditemukan
if (empty($data)) {
    die("Data ekskul tidak ditemukan!");
}

// Cek apakah ada gambar, jika tidak, gunakan gambar default
$gambar = !empty($data[0]['gambar']) ? 'img/' . $data[0]['gambar'] : 'uploads/default.jpg';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Ekskul</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 50%;
            margin: auto;
        }
        .btn {
            padding: 8px 12px;
            margin: 5px;
            border: none;
            color: white;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-kembali { background: #6c757d; }
        .btn-kembali:hover { background: #5a6268; }
        .btn-siswa { background: #007bff; }
        .btn-siswa:hover { background: #0056b3; }
        .ekskul-img {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Detail Ekskul</h2>
        <img src="<?php echo htmlspecialchars($gambar); ?>" alt="Gambar Ekskul" class="ekskul-img">
        <p><strong>Nama Ekskul:</strong> <?php echo htmlspecialchars($data[0]['nama_ekskul']); ?></p>
        
        <p><strong>Nama Pembina:</strong><br>
            <?php
            if (count($data) > 0) {
                foreach ($data as $row) {
                    echo htmlspecialchars($row['nama_pembina']) . "<br>";
                }
            } else {
                echo "Belum ada pembina";
            }
            ?>
        </p>

        <p><strong>Singkatan:</strong> <?php echo htmlspecialchars($data[0]['singkatan']); ?></p>
        <p><strong>Deskripsi:</strong> <?php echo htmlspecialchars($data[0]['desk_umum']); ?></p>
        
        <a href="siswa/daftar_detail.php?id_ekskul=<?php echo $id_ekskul; ?>" class="btn btn-siswa">
            <?php echo (!empty($data[0]['nama_siswa'])) ? "Lihat Siswa" : "Lihat Daftar Siswa"; ?>
        </a>
        
        <a href="daftar_ekskul.php" class="btn btn-kembali">Kembali</a>
    </div>
</body>
</html>
