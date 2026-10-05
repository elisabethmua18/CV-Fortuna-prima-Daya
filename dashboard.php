<?php
include 'auth.php';
include 'proses.php';

// Proses Update Status Lead menggunakan Prepared Statement
if (isset($_POST['update_status'])) {
    $id_data = intval($_POST['id']);
    $status_baru = $_POST['status_lead'];
    
    $stmt_upd = mysqli_prepare($koneksi, "UPDATE kontak_penawaran SET status_lead = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt_upd, "si", $status_baru, $id_data);
    mysqli_stmt_execute($stmt_upd);
    mysqli_stmt_close($stmt_upd);
    
    header("Location: dashboard.php");
    exit();
}

$cari = $_GET['cari'] ?? '';
$filter_produk = $_GET['produk'] ?? '';

$sql = "SELECT id, nama_lengkap, whatsapp, layanan_diminati, pesan, status_lead, tanggal_kirim 
        FROM kontak_penawaran WHERE 1=1";
$params = [];
$types = "";

if (!empty($cari)) {
    $sql .= " AND (nama_lengkap LIKE ? OR whatsapp LIKE ?)";
    $like_cari = "%" . $cari . "%";
    $params[] = $like_cari;
    $params[] = $like_cari;
    $types .= "ss";
}

if (!empty($filter_produk)) {
    $sql .= " AND layanan_diminati = ?";
    $params[] = $filter_produk;
    $types .= "s";
}

$sql .= " ORDER BY tanggal_kirim DESC";

$stmt = mysqli_prepare($koneksi, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$total_pesanan = mysqli_num_rows($result);

$query_status = mysqli_query($koneksi, "SELECT status_lead, COUNT(*) as jumlah FROM kontak_penawaran GROUP BY status_lead");
$jumlah_status = ['Baru' => 0, 'Diproses' => 0, 'Selesai' => 0, 'Dibatalkan' => 0];
while($row_st = mysqli_fetch_assoc($query_status)) {
    if(isset($jumlah_status[$row_st['status_lead']])) {
        $jumlah_status[$row_st['status_lead']] = $row_st['jumlah'];
    }
}

$query_produk = mysqli_query($koneksi, "SELECT DISTINCT layanan_diminati FROM kontak_penawaran");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - CV Fortuna Prima Daya</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php">Kelola Penawaran</a></li>
                    <li class="nav-item"><a class="nav-link" href="formulirpesanan.php">Tambah Pesanan</a></li>
                    <li class="nav-item text-white-50 small border-start ps-3 d-none d-lg-block">
                        Login: <strong class="text-white"><?= htmlspecialchars($_SESSION['admin_nama'] ?? 'Administrator'); ?></strong>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="btn btn-outline-danger btn-sm px-3">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container py-5">
        
        <!-- BAGIAN HEADER UTAMA TANPA SIDEBAR -->
        <div class="row align-items-center bg-primary text-white p-4 rounded-4 shadow-sm mb-4 g-3">
            <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h2 class="fw-bold text-white mb-1">Dashboard Admin CV Fortuna Prima Daya</h2>
                    <p class="text-white-50 small mb-0">Pantau dan kelola seluruh data masuk layanan outsourcing perusahaan dengan mudah.</p>
                </div>
                <div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fw-semibold">
                        <i class="fa-solid fa-circle text-success me-1" style="font-size: 8px;"></i> Server Status: Online
                    </span>
                </div>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="row g-3 mb-4">
            <div class="col">
                <div class="card border-0 shadow-sm border-start border-primary border-4 h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1 small fw-bold">TOTAL PESANAN</p>
                        <h3 class="fw-bold text-primary mb-0"><?= $total_pesanan; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow-sm border-start border-info border-4 h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1 small fw-bold">STATUS: BARU</p>
                        <h3 class="fw-bold text-info mb-0"><?= $jumlah_status['Baru']; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow-sm border-start border-warning border-4 h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1 small fw-bold">STATUS: DIPROSES</p>
                        <h3 class="fw-bold text-warning mb-0"><?= $jumlah_status['Diproses']; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow-sm border-start border-success border-4 h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1 small fw-bold">STATUS: SELESAI</p>
                        <h3 class="fw-bold text-success mb-0"><?= $jumlah_status['Selesai']; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow-sm border-start border-danger border-4 h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1 small fw-bold">STATUS: DIBATALKAN</p>
                        <h3 class="fw-bold text-danger mb-0"><?= $jumlah_status['Dibatalkan']; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Filter & Pencarian -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="dashboard.php" class="row g-3 align-items-center">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="cari" placeholder="Cari berdasarkan nama pelanggan..." value="<?= htmlspecialchars($cari); ?>">
                    </div>
                    <div class="col-md-4">
                        <select name="produk" class="form-select">
                            <option value="">-- Semua Layanan / Produk --</option>
                            <?php while($p = mysqli_fetch_assoc($query_produk)): ?>
                                <option value="<?= htmlspecialchars($p['layanan_diminati']); ?>" <?= ($filter_produk == $p['layanan_diminati']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($p['layanan_diminati']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-filter me-1"></i> Filter</button>
                        <a href="dashboard.php" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Daftar Permintaan Layanan</h5>
                <a href="formulirpesanan.php" class="btn btn-dark btn-sm"><i class="fa-solid fa-plus me-1"></i> Tambah Pesanan</a>
            </div>
            <div class="card-body">
                <?php if ($total_pesanan > 0) : ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Nama Pelanggan</th>
                                <th>WhatsApp</th>
                                <th>Layanan Diminati</th>
                                <th>Status Lead</th>
                                <th>Tanggal Kirim</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; ?>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="fw-semibold"><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                                <td>
                                    <a href="https://wa.me/<?= preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $row['whatsapp'])); ?>" target="_blank" class="text-success text-decoration-none fw-medium">
                                        <i class="fa-brands fa-whatsapp me-1"></i> <?= htmlspecialchars($row['whatsapp']); ?>
                                    </a>
                                </td>
                                <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($row['layanan_diminati']); ?></span></td>
                                <td>
                                    <form method="POST" action="" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                        <select name="status_lead" onchange="this.form.submit()" 
                                            class="form-select form-select-sm fw-semibold 
                                            <?php 
                                                if($row['status_lead'] == 'Baru') echo 'text-primary bg-primary-subtle';
                                                elseif($row['status_lead'] == 'Diproses') echo 'text-warning bg-warning-subtle';
                                                elseif($row['status_lead'] == 'Selesai') echo 'text-success bg-success-subtle';
                                                else echo 'text-danger bg-danger-subtle';
                                            ?>">
                                            <option value="Baru" <?= ($row['status_lead'] == 'Baru') ? 'selected' : ''; ?>>Baru</option>
                                            <option value="Diproses" <?= ($row['status_lead'] == 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                                            <option value="Selesai" <?= ($row['status_lead'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                                            <option value="Dibatalkan" <?= ($row['status_lead'] == 'Dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option>
                                        </select>
                                        <input type="hidden" name="update_status" value="1">
                                    </form>
                                </td>
                                <td><small class="text-muted"><?= htmlspecialchars($row['tanggal_kirim']); ?></small></td>
                                <td class="text-center">
                                    <a href="detail.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-info text-white me-1" title="Detail"><i class="fa-solid fa-eye"></i></a>
                                    <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php else : ?>
                    <div class="alert alert-info mb-0 text-center py-4">Tidak ada data pesanan ditemukan.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php 
if (isset($stmt)) mysqli_stmt_close($stmt); 
mysqli_close($koneksi); 
?>