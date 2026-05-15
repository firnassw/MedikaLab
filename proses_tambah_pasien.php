<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin'){
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_rm    = mysqli_real_escape_string($conn, $_POST['no_rm']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $jk       = mysqli_real_escape_string($conn, $_POST['jk']);

    $cek = mysqli_query($conn, "SELECT id FROM users WHERE username='$no_rm'");
    if(mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Gagal: No RM sudah terdaftar!'); window.location='dashboard.php';</script>";
        exit();
    }

    mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$no_rm', '$password', 'pasien')");
    $user_id = mysqli_insert_id($conn);

    mysqli_query($conn, "INSERT INTO pasien (user_id, no_rm, nama, jk) VALUES ('$user_id', '$no_rm', '$nama', '$jk')");

    header("Location: dashboard.php");
}
?>