<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}
$pesan_error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - StartupKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-primary d-flex align-items-center justify-content-center"
      style="min-height:100vh">
    <div class="card shadow-lg border-0" style="max-width:420px;width:100%">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <div style="font-size:56px">
🔐
</div>
                <h3 class="fw-bold mt-3">Login Admin</h3>
                <p class="text-muted">Masuk untuk mengakses data pesanan</p>
            </div>
            <?php if ($pesan_error == 'gagal') : ?>
                <div class="alert alert-danger">
                    Username atau password salah.
                </div>
            <?php endif; ?>
            <?php if ($pesan_error == 'akses') : ?>
                <div class="alert alert-warning">
                    Silakan login terlebih dahulu.
                </div>
            <?php endif; ?>
            <form action="proses-login.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username"
                           name="username" required autofocus>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                     <input type="password" class="form-control" id="password"
                           name="password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>