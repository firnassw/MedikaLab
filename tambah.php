<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin'){
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pasien_id = mysqli_real_escape_string($conn, $_POST['pasien_id']);
    $parameter = mysqli_real_escape_string($conn, $_POST['parameter']);
    $tanggal   = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $hasil     = mysqli_real_escape_string($conn, $_POST['hasil']);
    $catatan   = mysqli_real_escape_string($conn, $_POST['catatan_dokter']);
    $status    = mysqli_real_escape_string($conn, $_POST['status']);

    $nama_file_baru = "";

    if (isset($_FILES['file_pdf']) && $_FILES['file_pdf']['error'] === 0) {
        $nama_file = $_FILES['file_pdf']['name'];
        $tmp_name = $_FILES['file_pdf']['tmp_name'];
        $ekstensi_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        
        if ($ekstensi_file === 'pdf') {
            $nama_file_baru = uniqid() . ".pdf";
            if (!is_dir('uploads')) mkdir('uploads', 0777, true);
            move_uploaded_file($tmp_name, 'uploads/' . $nama_file_baru);
        } else {
            echo "<script>alert('Gagal! File harus berformat PDF.'); window.location='dashboard.php';</script>";
            exit();
        }
    }

    mysqli_query($conn, "INSERT INTO lab (pasien_id, parameter, hasil, catatan_dokter, tanggal, status, file_pdf) 
                         VALUES ('$pasien_id', '$parameter', '$hasil', '$catatan', '$tanggal', '$status', '$nama_file_baru')");

    header("Location: dashboard.php");
    exit();
}
?>