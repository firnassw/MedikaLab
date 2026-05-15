<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin'){
    header("Location: index.php");
    exit();
}

$jml_pasien = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pasien"))['total'];
$jml_lab_proses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM lab WHERE status='PROSES'"))['total'];
$jml_lab_selesai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM lab WHERE status='SELESAI'"))['total'];

$query_data = mysqli_query($conn,"SELECT lab.*, pasien.nama, pasien.no_rm FROM lab JOIN pasien ON lab.pasien_id = pasien.id ORDER BY lab.tanggal DESC");

$data_proses = [];
$data_selesai = [];
while($row = mysqli_fetch_assoc($query_data)){
    if($row['status'] == 'PROSES'){
        $data_proses[] = $row;
    } else {
        $data_selesai[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - MedikaLab</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">MedikaLab Admin</div>
    
    <div class="menu-label">MENU ADMIN</div>
    <a href="dashboard.php" class="menu-item active">Pusat Kendali</a>
    
    <div class="menu-label">PENGATURAN</div>
    <a href="logout.php" class="menu-item" onclick="return confirm('Yakin ingin keluar dari sistem?')">Keluar Sistem</a>
</div>

<div class="main">
    <div class="topbar">
        <div class="workstation-info" style="display: flex; gap: 20px; align-items: center; width: 60%;">
            <span><i class="fa-solid fa-computer-mouse"></i> Workstation: <b>Petugas Lab</b></span>
            
            <form action="" method="GET" style="flex: 1; position: relative;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                <input type="text" name="cari" placeholder="Cari Nama / No. RM Pasien..." style="width: 100%; padding: 10px 15px 10px 40px; border-radius: 20px; border: 1px solid #e2e8f0; background: var(--bg-input); outline: none;">
            </form>
        </div>
        <div class="topbar-right">
            <div class="user-info">
                <b><?= htmlspecialchars($_SESSION['user']['username']) ?></b>
                <small>Administrator</small>
            </div>
            <div class="avatar">A</div>
        </div>
    </div>

    <div class="content">
        <div class="header-row">
            <div>
                <h1>Pusat Kendali Laboratorium</h1>
                <p style="color: var(--text-muted); font-size: 14px;">Kelola antrean spesimen dan validasi hasil uji.</p>
            </div>
            <div class="action-buttons">
                <a href="#modal-pasien" class="btn btn-outline">
                    <i class="fa-solid fa-user-plus"></i> Registrasi Pasien
                </a>
                <a href="#modal-lab" class="btn btn-primary">
                    <i class="fa-solid fa-vial-circle-check"></i> Input Hasil Uji Baru
                </a>
            </div>
        </div>

        <div class="widget-row">
            <div class="widget">
                <h3>Total Pasien</h3>
                <h2><?= $jml_pasien ?></h2>
                <small><i class="fa-solid fa-users"></i> Terdaftar</small>
            </div>
            <div class="widget">
                <h3>Antrean Diproses</h3>
                <h2 style="color: #b45309;"><?= $jml_lab_proses ?></h2>
                <small><i class="fa-solid fa-spinner fa-spin"></i> Butuh Tindakan</small>
            </div>
            <div class="widget">
                <h3>Uji Selesai</h3>
                <h2 style="color: #047857;"><?= $jml_lab_selesai ?></h2>
                <small><i class="fa-solid fa-circle-check"></i> Tervalidasi</small>
            </div>
        </div>

        <div class="card" style="margin-bottom: 30px; border-left: 4px solid #b45309;">
            <div class="card-header" style="background: #fffbeb; color: #b45309;">
                <i class="fa-solid fa-triangle-exclamation"></i> Spesimen Dalam Antrean (Butuh Tindakan)
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>IDENTITAS PASIEN</th>
                            <th>PARAMETER UJI</th>
                            <th>TANGGAL</th>
                            <th style="text-align: center;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($data_proses)): ?>
                        <tr><td colspan="4" style="text-align:center; color: var(--text-muted);">Tidak ada antrean saat ini.</td></tr>
                    <?php endif; ?>
                    
                    <?php foreach($data_proses as $row) { ?>
                    <tr>
                        <td>
                            <div style="font-weight: 600;"><?= htmlspecialchars($row['nama']) ?></div>
                            <div style="font-size: 12px; color: var(--text-muted);"><?= htmlspecialchars($row['no_rm']) ?></div>
                        </td>
                        <td><span style="font-weight: 500;"><?= htmlspecialchars($row['parameter']) ?></span></td>
                        <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                        <td style="text-align: center;">
                            <a href="#modal-edit-<?= $row['id'] ?>" class="btn btn-sm" style="background: #e0f2fe; color: #0ea5e9;">
                                <i class="fa-solid fa-pen-to-square"></i> Input Hasil
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" style="border-left: 4px solid #047857;">
            <div class="card-header" style="background: #ecfdf5; color: #047857;">
                <i class="fa-solid fa-list-check"></i> Riwayat Pemeriksaan Selesai
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>PASIEN</th>
                            <th>PARAMETER UJI</th>
                            <th>HASIL & CATATAN</th>
                            <th style="text-align: center;">DOKUMEN</th>
                            <th style="text-align: center;">KELOLA</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($data_selesai as $row) { ?>
                    <tr>
                        <td>
                            <div style="font-weight: 600;"><?= htmlspecialchars($row['nama']) ?></div>
                            <div style="font-size: 12px; color: var(--text-muted);"><?= htmlspecialchars($row['no_rm']) ?></div>
                        </td>
                        <td><?= htmlspecialchars($row['parameter']) ?></td>
                        <td>
                            <div style="margin-bottom: 5px;"><b><?= htmlspecialchars($row['hasil']) ?></b></div>
                            <div style="font-size: 12px; font-style: italic; color: var(--text-muted);">
                                "<?= htmlspecialchars($row['catatan_dokter']) ?>"
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <?php if(!empty($row['file_pdf'])): ?>
                                <a href="uploads/<?= htmlspecialchars($row['file_pdf']) ?>" target="_blank" style="color: #ef4444; text-decoration: none;">
                                    <i class="fa-solid fa-file-pdf fa-lg"></i>
                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="#modal-edit-<?= $row['id'] ?>" class="btn btn-sm" style="background: #f1f5f9; color: #64748b;" title="Edit Data">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-sm" style="background: #fee2e2; color: #ef4444;" onclick="return confirm('Hapus data ini?')" title="Hapus Data">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php foreach(array_merge($data_proses, $data_selesai) as $row) { ?>
<div id="modal-edit-<?= $row['id'] ?>" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fa-solid fa-pen-to-square"></i> Edit Hasil Lab</h3>
            <a href="#" class="close-btn">&times;</a>
        </div>
        <form action="edit.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <input type="hidden" name="file_lama" value="<?= $row['file_pdf'] ?>">
                
                <label>PASIEN</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($row['nama']) ?> (<?= htmlspecialchars($row['no_rm']) ?>)" readonly style="background: #f1f5f9; color: #64748b; margin-bottom:10px;">

                <div style="display:flex; gap:15px; margin-bottom: 10px;">
                    <div style="flex:1;">
                        <label>PARAMETER UJI</label>
                        <input type="text" name="parameter" class="form-control" value="<?= htmlspecialchars($row['parameter']) ?>" required>
                    </div>
                    <div style="flex:1;">
                        <label>TANGGAL</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= $row['tanggal'] ?>" required>
                    </div>
                </div>
                
                <label>HASIL PEMERIKSAAN</label>
                <input type="text" name="hasil" class="form-control" value="<?= htmlspecialchars($row['hasil']) ?>" style="margin-bottom:10px;">
                
                <label>GANTI PDF (Opsional)</label>
                <input type="file" name="file_pdf" class="form-control" accept="application/pdf" style="margin-bottom:10px;">
                
                <label>CATATAN DOKTER</label>
                <textarea name="catatan_dokter" class="form-control" rows="3" style="margin-bottom:10px;"><?= htmlspecialchars($row['catatan_dokter']) ?></textarea>
                
                <label>STATUS</label>
                <select name="status" class="form-control" style="margin-bottom:10px;">
                    <option value="PROSES" <?= $row['status'] == 'PROSES' ? 'selected' : '' ?>>Proses</option>
                    <option value="SELESAI" <?= $row['status'] == 'SELESAI' ? 'selected' : '' ?>>Selesai</option>
                </select>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<?php } ?>

<div id="modal-pasien" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fa-solid fa-user-plus"></i> Registrasi Pasien</h3>
            <a href="#" class="close-btn">&times;</a>
        </div>
        <form action="proses_tambah_pasien.php" method="POST">
            <div class="modal-body">
                <label>NO. REKAM MEDIS</label>
                <input type="text" name="no_rm" class="form-control" placeholder="RM-XXXX" required style="margin-bottom:10px;">
                <label>PASSWORD</label>
                <input type="password" name="password" class="form-control" required style="margin-bottom:10px;">
                <label>NAMA LENGKAP</label>
                <input type="text" name="nama" class="form-control" required style="margin-bottom:10px;">
                <label>JENIS KELAMIN</label>
                <select name="jk" class="form-control" style="margin-bottom:10px;">
                    <option value="L">Laki-Laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-lab" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fa-solid fa-vial"></i> Input Hasil Lab Baru</h3>
            <a href="#" class="close-btn">&times;</a>
        </div>
        <form action="tambah.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <label>PILIH PASIEN</label>
                <select name="pasien_id" class="form-control" required style="margin-bottom:10px;">
                    <option value="">-- Cari Pasien --</option>
                    <?php
                    $p = mysqli_query($conn,"SELECT * FROM pasien");
                    while($d = mysqli_fetch_assoc($p)){
                        echo "<option value='{$d['id']}'>{$d['no_rm']} - {$d['nama']}</option>";
                    }
                    ?>
                </select>
                <div style="display:flex; gap:15px; margin-bottom: 10px;">
                    <div style="flex:1;">
                        <label>PARAMETER</label>
                        <input type="text" name="parameter" class="form-control" required>
                    </div>
                    <div style="flex:1;">
                        <label>TANGGAL</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>
                <label>HASIL</label>
                <input type="text" name="hasil" class="form-control" style="margin-bottom:10px;">
                <label>FILE PDF (Opsional)</label>
                <input type="file" name="file_pdf" class="form-control" accept="application/pdf" style="margin-bottom:10px;">
                <label>CATATAN DOKTER</label>
                <textarea name="catatan_dokter" class="form-control" rows="3" style="margin-bottom:10px;"></textarea>
                <label>STATUS</label>
                <select name="status" class="form-control" style="margin-bottom:10px;">
                    <option value="PROSES">Proses</option>
                    <option value="SELESAI">Selesai</option>
                </select>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>