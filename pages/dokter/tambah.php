<?php
require_once '../../config/database.php';
include '../../includes/header.php';

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $conn->real_escape_string($_POST['nama_dokter']);
    $spesialisasi = $conn->real_escape_string($_POST['spesialisasi']);
    $no_telp = $conn->real_escape_string($_POST['no_telp']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    
    if(empty($nama) || empty($spesialisasi)) {
        $error = "Nama dokter dan spesialisasi harus diisi!";
    } else {
        $query = "INSERT INTO dokter (nama_dokter, spesialisasi, no_telp, alamat) 
                  VALUES ('$nama', '$spesialisasi', '$no_telp', '$alamat')";
        
        if($conn->query($query)) {
            $success = "Data dokter berhasil ditambahkan!";
            header("refresh:2;url=index.php");
        } else {
            $error = "Gagal menambahkan data: " . $conn->error;
        }
    }
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-user-md text-blue-600"></i> Tambah Dokter Baru
            </h1>
            <p class="text-gray-600">Isi form di bawah untuk menambah data dokter</p>
        </div>

        <?php if($error): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <i class="fas fa-exclamation-circle"></i> <?= $error ?>
        </div>
        <?php endif; ?>

        <?php if($success): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <i class="fas fa-check-circle"></i> <?= $success ?>
        </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST" action="">
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Nama Dokter <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_dokter" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: Dr. Ahmad Wijaya, Sp.PD">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Spesialisasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="spesialisasi" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: Penyakit Dalam">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        No. Telepon
                    </label>
                    <input type="text" name="no_telp"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: 081234567890">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Alamat
                    </label>
                    <textarea name="alamat" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Masukkan alamat lengkap"></textarea>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
                <a href="index.php" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>