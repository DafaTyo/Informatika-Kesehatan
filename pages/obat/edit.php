<?php
require_once '../../config/database.php';
include '../../includes/header.php';

$error = '';
$success = '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data obat
$query = "SELECT * FROM obat WHERE id_obat = $id";
$result = $conn->query($query);
$obat = $result->fetch_assoc();

if(!$obat) {
    header("Location: index.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $conn->real_escape_string($_POST['nama_obat']);
    $jenis = $conn->real_escape_string($_POST['jenis_obat']);
    $stok = (int)$_POST['stok'];
    $harga = (float)$_POST['harga'];
    
    if(empty($nama) || empty($jenis)) {
        $error = "Nama obat dan jenis harus diisi!";
    } else {
        $query = "UPDATE obat SET 
                  nama_obat = '$nama',
                  jenis_obat = '$jenis',
                  stok = $stok,
                  harga = $harga
                  WHERE id_obat = $id";
        
        if($conn->query($query)) {
            $success = "Data obat berhasil diupdate!";
            header("refresh:2;url=index.php");
        } else {
            $error = "Gagal mengupdate data: " . $conn->error;
        }
    }
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-edit text-yellow-600"></i> Edit Data Obat
            </h1>
            <p class="text-gray-600">Perbarui informasi obat</p>
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
                        Nama Obat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_obat" required
                           value="<?= htmlspecialchars($obat['nama_obat']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Jenis Obat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="jenis_obat" required
                           value="<?= htmlspecialchars($obat['jenis_obat']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stok" required min="0"
                           value="<?= $obat['stok'] ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="harga" required min="0" step="0.01"
                           value="<?= $obat['harga'] ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-save mr-2"></i> Update
                </button>
                <a href="index.php" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>