<?php
include 'koneksi.php';

// Ambil kata kunci pencarian jika ada
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";

// Query untuk menampilkan daftar ekskul dengan nama siswa yang sesuai
$sql = "SELECT ekskul.id_ekskul, ekskul.nama_ekskul, ekskul.singkatan, ekskul.desk_umum, 
               siswa.id_siswa, siswa.nama AS nama_siswa
        FROM ekskul
        LEFT JOIN siswa ON ekskul.id_siswa = siswa.id_siswa";
// Tambahkan kondisi pencarian jika ada input dari user
if (!empty($search)) {
    $sql .= " WHERE ekskul.nama_ekskul LIKE '%$search%' 
              OR ekskul.singkatan LIKE '%$search%' 
              OR siswa.nama LIKE '%$search%'";
}

$sql .= " ORDER BY ekskul.nama_ekskul ASC";

// Jalankan query
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
    <title>Daftar Ekskul</title>
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
            width: 80%;
            margin: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #a18cd1;
            color: white;
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
        .btn-edit { background: #28a745; }
        .btn-edit:hover { background: #218838; }
        .btn-hapus { background: #dc3545; }
        .btn-hapus:hover { background: #c82333; }
        .btn-daftar { background: #007bff; }
        .btn-daftar:hover { background: #0056b3; }
        .btn-detail { background: #17a2b8; }
        .btn-detail:hover { background: #138496; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Ekskul</h2>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Cari ekskul..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Cari</button>
            <a href="tambah_ekskul.php" class="btn btn-daftar">Daftar Ekskul</a>
        </form>
        <table>
            <tr>
                <th>Nama Ekskul</th>
                <th>Aksi</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nama_ekskul']) . "</td>";
                    echo "<td>
                        <a href='siswa/daftar_detail.php?id_ekskul=" . urlencode($row['id_ekskul']) . "' class='btn btn-detail'>Detail</a>
                        <a href='edit_ekskul.php?id_ekskul=" . urlencode($row['id_ekskul']) . "' class='btn btn-edit'>Edit</a>
                        <a href='hapus_ekskul.php?id_ekskul=" . urlencode($row['id_ekskul']) . "' class='btn btn-hapus' onclick=\"return confirm('Yakin ingin menghapus ekskul ini?')\">Hapus</a>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Data tidak ditemukan</td></tr>";
            }
            ?>
        </table>

        <a href="dashboard.php">Kembali</a>
    </div>
</body>
</html>
