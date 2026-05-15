<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role     = mysqli_real_escape_string($conn, $_POST['role']);
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='$role'");
    
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['user'] = $data;
        $_SESSION['status'] = "login";

        if ($data['role'] == 'admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: pasien.php");
        }
        exit();
    } else {
        echo "<script>alert('Login Gagal! Pastikan Username, Password, dan Role Anda benar.'); window.location='index.php';</script>";
    }
}
?>