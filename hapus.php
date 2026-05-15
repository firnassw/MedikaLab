<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin'){
    header("Location: index.php");
    exit();
}

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    $cek_file = mysqli_query($conn, "SELECT file_pdf FROM lab WHERE id='$id'");
    $data_file = mysqli_fetch_assoc($cek_file);
    if($data_file['file_pdf'] != "" && file_exists("uploads/".$data_file['file_pdf'])){
        unlink("uploads/".$data_file['file_pdf']);
    }

    mysqli_query($conn, "DELETE FROM lab WHERE id='$id'");
}

header("Location: dashboard.php");
exit();
?>