<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'pasien'){
    header("Location: index.php");
    exit();
}

$user = $_SESSION['user'];
$username_pasien = $user['username'];

$query = mysqli_query($conn, "
    SELECT p.*, l.parameter, l.hasil, l.catatan_dokter, l.tanggal, l.status, l.id as lab_id, l.file_pdf
    FROM pasien p
    LEFT JOIN lab l ON p.id = l.pasien_id
    WHERE p.no_rm = '$username_pasien'
    ORDER BY l.tanggal DESC
");

$data_pasien = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Pasien - MedikaLab</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="sidebar">
    <div class="sidebar-header">MedikaLab Portal</div>
    <div class="menu-label">MENU PASIEN</div>
    <a href="pasien.php" class="menu-item active">Riwayat Pemeriksaan</a>
    <div class="menu-label">PENGATURAN</div>
    <a href="logout.php" class="menu-item">Keluar Sistem</a>
</div>

<div class="main">
    <div class="topbar">
        <div>Selamat Datang, <b><?= htmlspecialchars($data_pasien['nama']) ?></b></div>
        <div class="topbar-right">
            <div><b>RM: <?= htmlspecialchars($username_pasien) ?></b></div>
            <div class="avatar">P</div>
        </div>
    </div>

    <div class="content">
        <div class="header-row">
            <h1>Data Diri & Hasil Laboratorium</h1>
        </div>

        <div class="widget-row">
            <div class="widget" style="flex:1;">
                <small style="color: #718096;">NAMA LENGKAP</small>
                <h3><?= htmlspecialchars($data_pasien['nama']) ?></h3>
            </div>
            <div class="widget" style="flex:1;">
                <small style="color: #718096;">JENIS KELAMIN</small>
                <h3><?= ($data_pasien['jk'] == 'L') ? 'Laki-laki' : 'Perempuan' ?></h3>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Riwayat Uji Lab & Catatan Dokter</div>
            <table>
                <thead>
                    <tr>
                        <th>TANGGAL</th>
                        <th>PARAMETER</th>
                        <th>HASIL</th>
                        <th>CATATAN</th>
                        <th>STATUS</th>
                        <th style="text-align:right;">DOKUMEN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    mysqli_data_seek($query, 0); 
                    while($row = mysqli_fetch_assoc($query)) { 
                        if(!$row['parameter']) continue; 
                    ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                        <td><b><?= htmlspecialchars($row['parameter']) ?></b></td>
                        <td style="color: #0f4c81; font-weight: bold;"><?= htmlspecialchars($row['hasil']) ?: '-' ?></td>
                        <td>
                            <?php if($row['catatan_dokter']){ ?>
                                <div style="background: #f8fafc; padding: 8px; border-radius: 6px; border-left: 3px solid #0ea5e9; font-size: 13px;">
                                    <?= htmlspecialchars($row['catatan_dokter']) ?>
                                </div>
                            <?php } else { echo "-"; } ?>
                        </td>
                        <td>
                            <?php if($row['status'] == "SELESAI"){ ?>
                                <span class="badge success">TERVALIDASI</span>
                            <?php } else { ?>
                                <span class="badge warning">PROSES</span>
                            <?php } ?>
                        </td>
                        <td style="text-align:right;">
                            <?php if($row['status'] == "SELESAI" && !empty($row['file_pdf'])){ ?>
                                <a href="uploads/<?= htmlspecialchars($row['file_pdf']) ?>" target="_blank" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">Unduh PDF</a>
                            <?php } else { ?>
                                <small style="color: #9ca3af;">Belum Tersedia</small>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>