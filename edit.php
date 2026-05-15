<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin'){
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id        = mysqli_real_escape_string($conn, $_POST['id']);
    $parameter = mysqli_real_escape_string($conn, $_POST['parameter']);
    $tanggal   = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $hasil     = mysqli_real_escape_string($conn, $_POST['hasil']);
    $catatan   = mysqli_real_escape_string($conn, $_POST['catatan_dokter']);
    $status    = mysqli_real_escape_string($conn, $_POST['status']);
    
    $file_lama = $_POST['file_lama'];
    $nama_file_baru = $file_lama; 

    if (isset($_FILES['file_pdf']) && $_FILES['file_pdf']['error'] === 0) {
        $ekstensi_file = strtolower(pathinfo($_FILES['file_pdf']['name'], PATHINFO_EXTENSION));
        
        if ($ekstensi_file === 'pdf') {
            if($file_lama != "" && file_exists('uploads/' . $file_lama)){
                unlink('uploads/' . $file_lama);
            }
            $nama_file_baru = uniqid() . ".pdf";
            move_uploaded_file($_FILES['file_pdf']['tmp_name'], 'uploads/' . $nama_file_baru);
        } else {
            echo "<script>alert('Gagal! File harus berformat PDF.'); window.location='dashboard.php';</script>";
            exit();
        }
    }

    mysqli_query($conn, "UPDATE lab SET 
        parameter = '$parameter',
        tanggal = '$tanggal',
        hasil = '$hasil',
        catatan_dokter = '$catatan',
        status = '$status',
        file_pdf = '$nama_file_baru'
        WHERE id = '$id'");

    header("Location: dashboard.php");
    exit();
}
?>