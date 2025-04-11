<?php
session_start(); // Memulai session
include '../koneksi.php';

if (isset($_GET['id_ekskul'])) {
    $id_ekskul = mysqli_real_escape_string($conn, $_GET['id_ekskul']);
    
    // Simpan id_ekskul ke dalam session
    $_SESSION['id_ekskul'] = $id_ekskul;

    // Query JOIN untuk mendapatkan maksimal 2 pembina dari ekskul
   // Query JOIN untuk mendapatkan maksimal 2 pembina dari ekskul
$query = "SELECT ekskul.nama_ekskul, ekskul.gambar, ekskul.desk_umum, pembina.nama AS nama_pembina
FROM ekskul
LEFT JOIN (
    SELECT pembina_ekskul.id_ekskul, pembina.nama
    FROM pembina_ekskul
    JOIN pembina ON pembina_ekskul.id_pembina = pembina.id_pembina
    WHERE pembina_ekskul.id_ekskul = '$id_ekskul'
    LIMIT 2
) AS pembina ON ekskul.id_ekskul = pembina.id_ekskul
WHERE ekskul.id_ekskul = '$id_ekskul';
";


    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query Error: " . mysqli_error($conn));
    }

    // Ambil semua data pembina
    $data_pembina = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data_pembina[] = $row;
    }

    // Jika data ekskul tidak ditemukan
    if (empty($data_pembina)) {
        die("Ekskul tidak ditemukan!");
    }

    // Ambil data ekskul dari hasil pertama
    $ekskul = $data_pembina[0];
} else {
    die("ID ekskul tidak valid!");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Ekskul</title>
    <style>
        body {
            background: linear-gradient(to right, #667eea, #764ba2);
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
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 600px;
            text-align: center;
        }
        img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #667eea;
        }
        h2 {
            color: #333;
            margin-top: 15px;
        }
        p {
            font-size: 18px;
            color: #555;
            margin: 10px 0;
        }
        .desc {
            text-align: center;
            font-size: 16px;
            color: #444;
            margin-top: 15px;
            line-height: 1.8;
            padding: 0 20px;
        }
        .btn-container {
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            text-decoration: none;
            background: #667eea;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            transition: 0.3s;
            font-size: 16px;
            font-weight: bold;
            margin: 5px;
        }
        .btn:hover {
            background: #5555cc;
        }
        .back-btn {
            background: #ff4b5c;
        }
        .back-btn:hover {
            background: #cc3a4a;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="../img/<?php echo htmlspecialchars($ekskul['gambar']); ?>" alt="Logo Ekskul">
        <h2><?php echo htmlspecialchars($ekskul['nama_ekskul']); ?></h2>
        
        <!-- Tampilkan Semua Pembina -->
        <p><strong>Pembina:</strong><br>
            <?php
            if (count($data_pembina) > 0) {
                foreach ($data_pembina as $pembina) {
                    echo htmlspecialchars($pembina['nama_pembina']) . "<br>";
                }
            } else {
                echo "Tidak Ada Pembina";
            }
            ?>
        </p>

        <!-- Menampilkan deskripsi ekskul -->
        <p class="desc"><?php echo nl2br(htmlspecialchars($ekskul['desk_umum'])); ?></p>

        <!-- Tombol untuk melihat daftar anggota ekskul dan kembali -->
        <div class="btn-container">
            <a href="daftar_anggota.php?id_ekskul=<?php echo $_SESSION['id_ekskul']; ?>" class="btn">Lihat Daftar Anggota</a>
            <a href="../daftar_ekskul.php" class="btn back-btn">Kembali</a>
        </div>
    </div>
</body>
</html>
