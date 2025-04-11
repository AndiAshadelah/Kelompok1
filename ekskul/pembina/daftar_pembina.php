<?php
require '../koneksi.php';

// Ambil kata kunci pencarian jika ada
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";

// Query untuk mengambil data pembina beserta ekskulnya, termasuk pencarian
$query = "
    SELECT p.id_pembina, p.nama, p.kompetensi, 
           GROUP_CONCAT(e.nama_ekskul SEPARATOR ', ') AS ekskul
    FROM pembina p
    LEFT JOIN pembina_ekskul pe ON p.id_pembina = pe.id_pembina
    LEFT JOIN ekskul e ON pe.id_ekskul = e.id_ekskul
";

if ($search) {
    $query .= " WHERE p.nama LIKE '%$search%' OR e.nama_ekskul LIKE '%$search%'";
}

$query .= " GROUP BY p.id_pembina ORDER BY p.id_pembina ASC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembina</title>
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
    </style>
</head>
<body>
<div class="container">
    <h2>Daftar Pembina</h2>
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Cari pembina..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Cari</button>
        <a href="tambah_pembina.php" class="btn btn-daftar">Daftar Pembina</a>
    </form>

    <table border="1">
        <tr>
            <th>Nama Pembina</th>
            <th>Kompetensi</th>
            <th>Ekskul</th>
            <th>Aksi</th>
        </tr>
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['nama']); ?></td>
                    <td><?= htmlspecialchars($row['kompetensi']); ?></td>
                    <td><?= $row['ekskul'] ? htmlspecialchars($row['ekskul']) : '-'; ?></td>
                    <td>
                        <a href="edit_pembina.php?id_pembina=<?= $row['id_pembina']; ?>" class="btn btn-edit">Edit</a>
                        <a href="hapus_pembina.php?id_pembina=<?= $row['id_pembina']; ?>" class="btn btn-hapus" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="4">Data tidak ditemukan</td>
            </tr>
        <?php } ?>
    </table>

    <a href="../dashboard.php">Kembali</a>
</div>
</body>
</html>
