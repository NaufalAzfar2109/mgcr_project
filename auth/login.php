<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Meteor Garden Cafe & Resto</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
    <div class="d-flex flex-row vh-100 justify-content-center align-items-center">
        <form method="POST" action="#" class="col-md-4 border p-3 rounded-3">
            <h4 class="text-center">Login Admin</h4>
            <h5 class="text-center">Meteor Garden Cafe & Resto</h5>
            <label class="form-label"><span class="text-danger">*</span> Username</label>
            <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
            <label class="form-label"><span class="text-danger">*</span> Password</label>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button class="btn btn-success w-100" name="login">Login</button>
        </form>
    </div>
</body>
</html>
<?php
if(isset($_POST['login'])){
    require_once __DIR__ . "/../config/koneksi.php";
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM admin WHERE username = ? AND password = ?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($result){
        $data = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['id_admin'] = $data['id_admin'];
        $_SESSION['nama_admin'] = $data['nama_admin'];
        $_SESSION['username'] = $data['username'];
        header("Location: ../admin/dashboard.php");
    }else {
        echo "<script>alert('Username / Password Salah!'); window.location.assign('login.php')</script>";
    }
}
?>