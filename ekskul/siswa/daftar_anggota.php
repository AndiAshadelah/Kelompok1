<?php
include '../koneksi.php';

// Pastikan ID ekskul diterima
if (!isset($_GET['id_ekskul'])) {
    echo "<script>alert('ID ekskul tidak ditemukan!'); window.location.href='../dashboard.php';</script>";
    exit;
}

$id_ekskul = mysqli_real_escape_string($conn, $_GET['id_ekskul']);

// Ambil nama ekskul berdasarkan id_ekskul
$query_ekskul = "SELECT nama_ekskul FROM ekskul WHERE id_ekskul = '$id_ekskul'";
$result_ekskul = mysqli_query($conn, $query_ekskul);
if (mysqli_num_rows($result_ekskul) > 0) {
    $data_ekskul = mysqli_fetch_assoc($result_ekskul);
    $nama_ekskul = $data_ekskul['nama_ekskul'];
} else {
    echo "<script>alert('Ekskul tidak ditemukan!'); window.location.href='../dashboard.php';</script>";
    exit;
}

// Ambil kata kunci pencarian jika ada
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";

// Query untuk menampilkan siswa berdasarkan ekskul dan pencarian
$sql = "
    SELECT siswa.nis, siswa.nama, siswa.kelas
    FROM detail_ekskul
    INNER JOIN siswa ON siswa.id_siswa = detail_ekskul.id_siswa
    WHERE detail_ekskul.id_ekskul = '$id_ekskul'
";
if ($search) {
    $sql .= " AND siswa.nama LIKE '%$search%'";
}
$sql .= " ORDER BY siswa.nis ASC";

$result = mysqli_query($conn, $sql);

// Periksa apakah query berhasil
if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa Ekskul - <?php echo htmlspecialchars($nama_ekskul); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #a18cd1, #fbc2eb);
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1200px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #a18cd1;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        input[type="text"], button {
            padding: 10px;
            margin-right: 10px;
        }
        input[type="text"] {
            width: 70%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #a18cd1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #8e78c4;
        }
        .not-found {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Siswa Ekskul: <?php echo htmlspecialchars($nama_ekskul); ?></h2>

        <!-- Form Pencarian -->
        <form method="GET" action="">
            <input type="hidden" name="id_ekskul" value="<?php echo htmlspecialchars($id_ekskul); ?>">
            <input type="text" name="search" placeholder="Cari nama siswa..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Cari</button>
        </form>

        <!-- Tabel Data Siswa -->
        <table>
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nis']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['kelas']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='not-found'>Data tidak ditemukan</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div style="margin-top: 20px; text-align: center;">
            <a href="../daftar_ekskul.php">Kembali</a>
        </div>
    </div>
</body>
</html>
