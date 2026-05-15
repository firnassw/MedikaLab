<?php
session_start();
if(isset($_SESSION['status']) && $_SESSION['status'] == "login"){
    if($_SESSION['user']['role'] == 'admin') header("Location: dashboard.php");
    else header("Location: pasien.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MedikaLab</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-minimal">

<div class="login-wrapper">
    <div class="login-card">
        <div class="sidebar-header">
        <img src="logo.png" alt="Logo" style="height: 90px; width: auto;">       
     </div>
        <h2>MedikaLab</h2>
        <p>Silakan pilih akses dan masuk ke akun Anda</p>

        <form action="proses_login.php" method="POST">
            <div class="role-selector">
                <input type="radio" name="role" value="admin" id="role-admin" checked>
                <label for="role-admin">
                    <i class="fa-solid fa-user-shield"></i> Admin
                </label>

                <input type="radio" name="role" value="pasien" id="role-pasien">
                <label for="role-pasien">
                    <i class="fa-solid fa-user-injured"></i> Pasien
                </label>
                
                <div class="role-glider"></div>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-id-card"></i>
                <input type="text" name="username" placeholder="Username / No. RM" required autocomplete="off">
            </div>
            
            <div class="input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required autocomplete="off">
            </div>

            <button type="submit" class="btn-login">Masuk ke Sistem</button>
        </form>
        
        <div class="login-footer">
            <small>&copy; <?= date('Y') ?> MedikaLab. All Rights Reserved.</small>
        </div>
    </div>
</div>

</body>
</html>