<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Ekstrakurikuler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f4f9;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 30px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Profil Ekstrakurikuler</h2>
    <div class="row">
        <?php
        $query = "SELECT * FROM ekskul";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='col-md-4'>";
            echo "<div class='card p-3 mb-4'>";
            echo "<h5>{$row['nama_ekskul']}</h5>";
            echo "<p>{$row['desk_umum']}</p>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>

</body>
</html>
