<?php
session_start();
include 'proses.php';
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
if ($username === '' || $password === '') {
    header("Location: login.php?error=gagal");
    exit;
}
$sql = "SELECT id, nama_lengkap, username, password
        FROM tbl_admin WHERE username = ? LIMIT 1";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($result);
if ($admin && password_verify($password, $admin['password'])) {
    session_regenerate_id(true);
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_nama'] = $admin['nama_lengkap'];
    $_SESSION['admin_username'] = $admin['username'];
    header("Location: dashboard.php");
    exit;
}
header("Location: login.php?error=gagal");
exit;
?>