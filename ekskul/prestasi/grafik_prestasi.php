<?php
include '../koneksi.php';

// Ambil data jumlah prestasi per ekskul
$query_prestasi = "SELECT ekskul.id_ekskul, ekskul.nama_ekskul, COUNT(prestasi.id_prestasi) AS total_prestasi 
                   FROM ekskul
                   LEFT JOIN prestasi ON ekskul.id_ekskul = prestasi.id_ekskul
                   GROUP BY ekskul.id_ekskul";
$result_prestasi = mysqli_query($conn, $query_prestasi);

// Ambil data jumlah siswa per ekskul
$query_siswa = "SELECT ekskul.id_ekskul, ekskul.nama_ekskul, COUNT(siswa.id_siswa) AS total_siswa 
                FROM ekskul
                LEFT JOIN siswa ON ekskul.nama_ekskul = siswa.ekskul
                GROUP BY ekskul.id_ekskul";
$result_siswa = mysqli_query($conn, $query_siswa);

// Ambil data jumlah pembina per ekskul
$query_pembina = "SELECT ekskul.id_ekskul, ekskul.nama_ekskul, COUNT(pembina.id_pembina) AS total_pembina 
                  FROM ekskul
                  LEFT JOIN pembina ON ekskul.id_ekskul = pembina.id_ekskul
                  GROUP BY ekskul.id_ekskul";
$result_pembina = mysqli_query($conn, $query_pembina);

$labels = [];
$data_prestasi = [];
$data_siswa = [];
$data_pembina = [];

$siswa_data = [];
while ($row = mysqli_fetch_assoc($result_siswa)) {
    $siswa_data[$row['id_ekskul']] = $row['total_siswa'];
}

$pembina_data = [];
while ($row = mysqli_fetch_assoc($result_pembina)) {
    $pembina_data[$row['id_ekskul']] = $row['total_pembina'];
}

while ($row = mysqli_fetch_assoc($result_prestasi)) {
    $labels[] = $row['nama_ekskul'];
    $data_prestasi[] = $row['total_prestasi'];
    $data_siswa[] = $siswa_data[$row['id_ekskul']] ?? 0;
    $data_pembina[] = $pembina_data[$row['id_ekskul']] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Ekskul</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .chart-container {
            width: 80%;
            max-width: 1000px;
            height: 500px;
        }
    </style>
</head>
<body>

<h2>Grafik Prestasi, Siswa, & Pembina per Ekskul</h2>
<div class="chart-container">
    <canvas id="eksulChart"></canvas>
</div>

<script>
    const ctx = document.getElementById('eksulChart').getContext('2d');
    const eksulChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels); ?>,
            datasets: [
                {
                    label: 'Jumlah Prestasi',
                    data: <?= json_encode($data_prestasi, JSON_NUMERIC_CHECK); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Jumlah Siswa',
                    data: <?= json_encode($data_siswa, JSON_NUMERIC_CHECK); ?>,
                    backgroundColor: 'rgba(255, 206, 86, 0.7)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Jumlah Pembina',
                    data: <?= json_encode($data_pembina, JSON_NUMERIC_CHECK); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
</script>

</body>
</html>