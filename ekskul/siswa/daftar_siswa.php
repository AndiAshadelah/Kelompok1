<?php
include '../koneksi.php';

// Hapus data jika ada permintaan hapus
if (isset($_GET['hapus'])) {
    $nis = $_GET['hapus'];
    $query_hapus = "DELETE FROM siswa WHERE nis = '$nis'";
    if (mysqli_query($conn, $query_hapus)) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='daftar_siswa.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!');</script>";
    }
}

// Ambil kata kunci pencarian jika ada
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";

// Query pencarian jika ada input
if ($search) {
    $sql = "SELECT nis, nama, ekskul, kelas FROM siswa WHERE nama LIKE '%$search%' ORDER BY nis ASC";
} else {
    $sql = "SELECT nis, nama, ekskul, kelas FROM siswa ORDER BY nis ASC";
}

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
    <title>Daftar Siswa</title>
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
            max-width: 1200px;
            text-align: center;
            height: 80vh;
            overflow-y: auto;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        form {
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        input[type="text"] {
            width: 60%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            padding: 8px 15px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #a18cd1;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .not-found {
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }
        .btn-daftar, .btn-edit, .btn-hapus {
            display: inline-block;
            padding: 8px 12px;
            margin: 2px;
            border: none;
            color: white;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
            text-decoration: none;
        }
        .btn-daftar {
            background: #a18cd1;
        }
        .btn-daftar:hover {
            background: #8e78c4;
        }
        .btn-edit {
            background: #28a745;
        }
        .btn-edit:hover {
            background: #218838;
        }
        .btn-hapus {
            background: #dc3545;
        }
        .btn-hapus:hover {
            background: #c82333;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Daftar Siswa</h2>

        <!-- Form Pencarian -->
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Cari nama siswa..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Cari</button>
            <a href="pendaftaran.php" class="btn-daftar">Daftar</a>
        </form>

        <table>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Ekskul</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nis']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ekskul']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['kelas']) . "</td>";
                    echo "<td>
                            <a href='edit_siswa.php?nis={$row['nis']}' class='btn-edit'>Edit</a>
                            <a href='daftar_siswa.php?hapus={$row['nis']}' class='btn-hapus' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='not-found'>Data tidak ditemukan</td></tr>";
            }
            ?>
        </table>

        <a href="../dashboard.php">Kembali</a>
    </div>

</body>
</html>
