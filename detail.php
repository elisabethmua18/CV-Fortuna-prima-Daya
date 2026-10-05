<?php
include 'auth.php';
include 'proses.php';

$id = $_GET['id'] ?? '';
if (empty($id)) {
    header("Location: dashboard.php");
    exit;
}

// Mengambil detail data menggunakan prepared statement
$stmt = mysqli_prepare($koneksi, "SELECT * FROM kontak_penawaran WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - PT Fortuna Prima Daya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<div class="container py-5" style="max-width: 700px;">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-circle-info me-2"></i>Detail Pesanan Pelanggan</h5>
            <a href="dashboard.php" class="btn btn-outline-light btn-sm">Kembali</a>
        </div>
        <div class="card-body p-4">
            <table class="table table-borderless">
                <tr>
                    <td class="fw-bold text-muted" style="width: 35%;">ID Pesanan</td>
                    <td>: #<?= $data['id']; ?></td>
                </tr>
                <tr>
                    <td class="fw-bold text-muted">Nama Pelanggan</td>
                    <td>: <?= htmlspecialchars($data['nama_lengkap']); ?></td>
                </tr>
                <tr>
                    <td class="fw-bold text-muted">WhatsApp</td>
                    <td>: <a href="https://wa.me/<?= htmlspecialchars($data['whatsapp']); ?>" target="_blank" class="text-decoration-none"><i class="fa-brands fa-whatsapp text-success me-1"></i> <?= htmlspecialchars($data['whatsapp']); ?></a></td>
                </tr>
                <tr>
                    <td class="fw-bold text-muted">Layanan Diminati</td>
                    <td>: <span class="badge bg-secondary"><?= htmlspecialchars($data['layanan_diminati']); ?></span></td>
                </tr>
                <tr>
                    <td class="fw-bold text-muted">Status Pesanan</td>
                    <td>: 
                        <?php 
                            $status = $data['status_lead'];
                            $badgeBg = 'bg-secondary';
                            if($status == 'Baru') $badgeBg = 'bg-primary';
                            elseif($status == 'Diproses') $badgeBg = 'bg-warning text-dark';
                            elseif($status == 'Selesai') $badgeBg = 'bg-success';
                            elseif($status == 'Dibatalkan') $badgeBg = 'bg-danger';
                        ?>
                        <span class="badge <?= $badgeBg; ?>"><?= htmlspecialchars($status); ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold text-muted">Tanggal Kirim</td>
                    <td>: <?= htmlspecialchars($data['tanggal_kirim']); ?></td>
                </tr>
                <tr>
                    <td class="fw-bold text-muted">Pesan / Catatan</td>
                    <td>: 
                        <div class="p-3 bg-light rounded mt-1 border">
                            <?= nl2br(htmlspecialchars($data['pesan'])); ?>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="d-flex justify-content-end mt-4">
                <a href="dashboard.php" class="btn btn-secondary">Tutup</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>