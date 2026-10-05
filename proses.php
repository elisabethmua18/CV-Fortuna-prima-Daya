<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_outsourcing";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

$nama_sukses = "";
$berhasil = false;

if (isset($_POST['submit'])) {
    $nama_lengkap     = $_POST['nama_lengkap'];
    $whatsapp         = $_POST['whatsapp'];
    $layanan_diminati = $_POST['layanan_diminati'];
    $pesan            = $_POST['pesan'];

    // Menggunakan Prepared Statement untuk proses INSERT (Tambah Data)
    $stmt = mysqli_prepare($koneksi, "INSERT INTO kontak_penawaran (nama_lengkap, whatsapp, layanan_diminati, pesan) VALUES (?, ?, ?, ?)");
    
    // "ssss" berarti keempat parameter bertipe string
    mysqli_stmt_bind_param($stmt, "ssss", $nama_lengkap, $whatsapp, $layanan_diminati, $pesan);

    if (mysqli_stmt_execute($stmt)) {
        $nama_sukses = $nama_lengkap;
        $berhasil = true;
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memproses Pesanan...</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-50 font-sans min-h-screen flex items-center justify-center p-4">

<?php if ($berhasil): ?>
    <!-- POP-UP MODAL SUKSES YANG MUNCUL OTOMATIS SAAT BERHASIL -->
    <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs p-4">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full text-center relative shadow-2xl animate-fade-in">
            
            <!-- Ikon Centang Sukses -->
            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold shadow-inner">
                ✓
            </div>
            
            <!-- Judul & Keterangan Pop-up -->
            <h3 class="text-2xl font-bold text-slate-800 mb-2">Penawaran Berhasil Dikirim!</h3>
            <p class="text-slate-600 text-sm mb-6 leading-relaxed">
                Terima kasih, <span class="font-semibold text-slate-800"><?php echo htmlspecialchars($nama_sukses); ?></span>. Tim konsultan kami akan segera menghubungi Anda melalui WhatsApp dalam waktu kurang dari <strong class="text-blue-600">3 jam</strong>.
            </p>
            
            <!-- Tombol Alternatif: Chat WhatsApp Langsung -->
            <a href="https://wa.me/6285713944289?text=Halo%2C%20saya%20sudah%20mengisi%20form%20penawaran%20di%20website" target="_blank" 
               class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-xl mb-3 transition duration-200 text-sm shadow-md shadow-emerald-600/20">
               💬 Chat WhatsApp Admin Langsung
            </a>
            
            <!-- Tombol Kembali ke Halaman Utama -->
            <a href="landingpagePT.php" 
               class="block w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-2.5 px-4 rounded-xl transition duration-200 text-sm cursor-pointer text-center">
               Kembali ke Beranda
            </a>
            
        </div>
    </div>
<?php endif; ?>

</body>
</html>