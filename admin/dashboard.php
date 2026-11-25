<?php
session_start();

require_once __DIR__ . '/../config/koneksi.php';

// Proteksi halaman admin
if (!isset($_SESSION['id_admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Mengambil statistik
$totalMenu = $koneksi->query(
    "SELECT COUNT(*) FROM menu"
)->fetchColumn();

$totalKategori = $koneksi->query(
    "SELECT COUNT(*) FROM kategori"
)->fetchColumn();

$totalReservasi = $koneksi->query(
    "SELECT COUNT(*) FROM reservasi"
)->fetchColumn();

$totalKunjungan = $koneksi->query(
    "SELECT COUNT(*) FROM kunjungan WHERE tanggal = CURDATE()"
)->fetchColumn();

// Mengambil reservasi terbaru
$reservasi = $koneksi->query(
    "SELECT * FROM reservasi ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard Admin - Meteor Garden</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f5f0e8;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background: #49352b;
            color: white;
            padding: 25px 15px;
        }

        .sidebar a {
            display: block;
            color: #f5eadd;
            text-decoration: none;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #8b674e;
            color: white;
        }

        .main-content {
            padding: 30px;
        }

        .stat-card {
            background: white;
            border: none;
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 3px 12px rgba(0,0,0,.05);
        }

        .stat-card h3 {
            color: #76543d;
            font-weight: bold;
        }

        .table-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
        }

        .judul {
            color: #49352b;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-2 sidebar">
            <h5 class="mb-4">Meteor Garden</h5>

            <a href="dashboard.php" class="active">Dashboard</a>
            <a href="menu/index.php">Menu</a>
            <a href="kategori/index.php">Kategori</a>
            <a href="galeri/index.php">Galeri</a>
            <a href="artikel/index.php">Artikel & Promosi</a>
            <a href="reservasi/index.php">Reservasi</a>
            <a href="informasi/index.php">Informasi Restoran</a>
            <a href="laporan/index.php">Laporan</a>

            <hr>

            <a href="logout.php">Logout</a>
        </div>

        <!-- KONTEN -->
        <div class="col-md-10 main-content">

            <h3 class="judul">Dashboard</h3>
            <p>Selamat datang di halaman administrator.</p>

            <!-- STATISTIK -->
            <div class="row g-3 mt-3">

                <div class="col-md-3">
                    <div class="stat-card">
                        <p>Total Menu</p>
                        <h3><?= $totalMenu ?></h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card">
                        <p>Total Kategori</p>
                        <h3><?= $totalKategori ?></h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card">
                        <p>Total Reservasi</p>
                        <h3><?= $totalReservasi ?></h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card">
                        <p>Kunjungan Hari Ini</p>
                        <h3><?= $totalKunjungan ?></h3>
                    </div>
                </div>

            </div>

            <!-- RESERVASI TERBARU -->
            <div class="table-card mt-4">

                <h5 class="judul mb-3">Reservasi Terbaru</h5>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Jumlah Orang</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($reservasi as $r): ?>
                                <tr>
                                    <td><?= htmlspecialchars($r['kode_reservasi']) ?></td>
                                    <td><?= htmlspecialchars($r['nama_pelanggan']) ?></td>
                                    <td><?= htmlspecialchars($r['tanggal']) ?></td>
                                    <td><?= htmlspecialchars($r['jam']) ?></td>
                                    <td><?= htmlspecialchars($r['jumlah_orang']) ?></td>
                                    <td><?= htmlspecialchars($r['status']) ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (empty($reservasi)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">
                                        Belum ada reservasi.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>

</body>
</html>