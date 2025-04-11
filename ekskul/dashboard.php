<?php
include 'koneksi.php';

// Mengambil jumlah data dari setiap tabel
$jumlah_siswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM siswa"))['total'];
$jumlah_ekskul = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM ekskul"))['total'];
$jumlah_pembina = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pembina"))['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Ekstrakurikuler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #a18cd1, #fbc2eb);
            font-family: 'Poppins', sans-serif;
            color: white;
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 120vh;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.3);
            width: 450px;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: 0.3s;
            font-size: 25px;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .container {
            flex-grow: 1;
            margin: 50px;
            text-align: center;
            font-size: 25px;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }
        .glass-card:hover {
            transform: translateY(-5px);
        }
        .btn-custom {
            background: #8e78c4;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background: #8e78c4;
        }
        h2 {
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 30px;
        }
        .chart-container {
            width: 300px;
            height: 200px;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Ekskul</h2>
        <a href="#">Dashboard</a>
        <a href="siswa/daftar_siswa.php">Daftar Anggota</a>
        <a href="daftar_ekskul.php">Daftar Ekskul</a>
        <a href="pembina/daftar_pembina.php">Daftar Pembina</a>
    </div>
    
    <div class="container">
        <h2>🌟 Dashboard Ekstrakurikuler 🌟</h2>
        <p>Website ini dibuat untuk membantu dalam pengelolaan data ekstrakurikuler di sekolah. 
           Melalui dashboard ini, Anda dapat melakukan pendaftaran anggota, melihat daftar anggota, 
           mengecek daftar ekskul, serta mencari informasi tentang pembina ekstrakurikuler.</p>
           <canvas id="grafikEkskul" width="400" height="200"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ambil data dari PHP
    var jumlahSiswa = <?php echo $jumlah_siswa; ?>;
    var jumlahEkskul = <?php echo $jumlah_ekskul; ?>;
    var jumlahPembina = <?php echo $jumlah_pembina; ?>;

    var ctx = document.getElementById('grafikEkskul').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar', // Jenis grafik (bar chart)
        data: {
            labels: ['Siswa', 'Ekskul', 'Pembina'],
            datasets: [{
                label: 'Jumlah Data',
                data: [jumlahSiswa, jumlahEkskul, jumlahPembina],
                backgroundColor: ['#ff6384', '#36a2eb', '#ffce56'],
                borderColor: ['#ff6384', '#36a2eb', '#ffce56'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
