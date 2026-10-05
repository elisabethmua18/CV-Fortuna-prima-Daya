<?php
include 'auth.php';
include 'proses.php';

$id = $_GET['id'] ?? '';

if (!empty($id)) {
    // Menggunakan Prepared Statement untuk menghapus data secara aman
    $stmt = mysqli_prepare($koneksi, "DELETE FROM kontak_penawaran WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($koneksi);
        header("Location: dashboard.php?hapus=sukses");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    header("Location: dashboard.php");
    exit;
}
?>