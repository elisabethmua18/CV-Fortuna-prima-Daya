<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulir Hubungi Kami - PT Outsourcing</title>
  <!-- Menggunakan Tailwind CSS untuk desain yang rapi dan responsif -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-50 font-sans min-h-screen flex items-center justify-center p-4">

  <!-- Container Utama Formulir -->
  <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-8 relative border border-slate-100">
    
    <!-- Header Form -->
    <div class="text-center mb-8">
      <span class="bg-blue-50 text-blue-600 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">Konsultasi Gratis</span>
      <h2 class="text-2xl font-bold text-slate-800 mt-2">Dapatkan Penawaran Outsourcing</h2>
      <p class="text-slate-500 text-sm mt-1">Isi data di bawah ini, tim konsultan kami di Semarang akan segera merespons Anda.</p>
    </div>

    <!-- Form Element -->
    <form action="proses.php" method="POST" class="space-y-4">
      
      <!-- Nama Lengkap / Perusahaan -->
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap / Perusahaan <span class="text-red-500">*</span></label>
        <input type="text" id="nama" name="nama_lengkap" required placeholder="Contoh: Budi Santoso / PT Maju Jaya" 
          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition">
      </div>

      <!-- Nomor WhatsApp -->
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Nomor WhatsApp (Aktif) <span class="text-red-500">*</span></label>
        <input type="tel" id="whatsapp" name="whatsapp" required placeholder="Contoh: 081234567890" 
          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition">
      </div>

      <!-- Layanan yang Diminati -->
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Pilihan Layanan <span class="text-red-500">*</span></label>
        <select id="layanan" name="layanan_diminati" required 
          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm bg-white transition">
          <option value="" disabled selected>Pilih layanan yang Anda butuhkan...</option>
          <option value="Cleaning Service Medis">Cleaning Service Medis</option>
          <option value="Home Care Profesional">Home Care Profesional</option>
          <option value="Digital Marketing">Digital Marketing</option>
          <option value="Lainnya">Lainnya / Konsultasi Kustom</option>
        </select>
      </div>

      <!-- Pesan / Catatan -->
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Detail Kebutuhan / Catatan (Opsional)</label>
        <textarea id="pesan" name="pesan" rows="3" placeholder="Contoh: Butuh 2 personel untuk klinik di Semarang..." 
          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition"></textarea>
      </div>

      <!-- Tombol Submit -->
      <button type="submit" name="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3.5 px-4 rounded-xl shadow-lg shadow-blue-600/20 transition duration-200 cursor-pointer text-sm mt-2">
        Dapatkan Penawaran Sekarang
      </button>
    </form>

      <p class="text-center text-xs text-slate-400 mt-3">🔒 Data Anda dijamin kerahasiaannya dan aman.</p>
    </form>
  </div>

  <!-- POP-UP MODAL SUKSES (Default Tersembunyi dengan class 'hidden') -->
  <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs hidden p-4">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full text-center relative shadow-2xl animate-fade-in">
      
      <!-- Tombol Close (X) -->
      <button onclick="closeModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 text-xl font-bold cursor-pointer">&times;</button>
      
      <!-- Ikon Centang Sukses -->
      <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold shadow-inner">
        ✓
      </div>
      
      <!-- Judul & Keterangan Pop-up -->
      <h3 class="text-2xl font-bold text-slate-800 mb-2">Penawaran Berhasil Dikirim!</h3>
      <p class="text-slate-600 text-sm mb-6 leading-relaxed">
        Terima kasih, <span id="clientName" class="font-semibold text-slate-800"></span>. Tim konsultan kami akan segera menghubungi Anda melalui WhatsApp dalam waktu kurang dari <strong class="text-blue-600">3 jam</strong>.
      </p>
      
      <!-- Tombol Alternatif: Chat WhatsApp Langsung -->
      <a href="https://wa.me/6281234567890?text=Halo%2C%20saya%20sudah%20mengisi%20form%20penawaran%20di%20website" target="_blank" 
         class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-xl mb-3 transition duration-200 text-sm shadow-md shadow-emerald-600/20">
        💬 Chat WhatsApp Admin Langsung
      </a>
      
      <!-- Tombol Kembali ke Halaman Utama -->
      <button onclick="closeModal()" 
        class="block w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-2.5 px-4 rounded-xl transition duration-200 text-sm cursor-pointer">
        Kembali ke Beranda
      </button>
      
    </div>
  </div>

  <!-- JavaScript untuk Menangani Aksi Form & Pop-up -->
  <script>
    function handleFormSubmit(event) {
      // Mencegah halaman melakukan reload default saat form disubmit
      event.preventDefault();

      // Ambil nama dari input untuk dipersonalisasi ke dalam pop-up
      const namaInput = document.getElementById('nama').value;
      document.getElementById('clientName').innerText = namaInput;

      // Tampilkan elemen pop-up (hapus class 'hidden')
      document.getElementById('successModal').classList.remove('hidden');
    }

    function closeModal() {
      // Sembunyikan kembali pop-up (tambahkan class 'hidden')
      document.getElementById('successModal').classList.add('hidden');
      
      // Opsional: Reset form setelah ditutup
      document.getElementById('outsourcingForm').reset();
    }
  </script>

</body>
</html>