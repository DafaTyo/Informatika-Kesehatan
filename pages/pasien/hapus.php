<?php
require_once '../../config/database.php';
include '../../includes/header.php';

$error = '';
$success = '';

// Ambil data untuk dropdown
$pasien_query = $conn->query("SELECT id_pasien, nama_pasien FROM pasien ORDER BY nama_pasien");
$dokter_query = $conn->query("SELECT id_dokter, nama_dokter FROM dokter ORDER BY nama_dokter");
$obat_query = $conn->query("SELECT id_obat, nama_obat, harga FROM obat ORDER BY nama_obat");

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pasien = (int)$_POST['id_pasien'];
    $id_dokter = (int)$_POST['id_dokter'];
    $tanggal = $conn->real_escape_string($_POST['tanggal_periksa']);
    $keluhan = $conn->real_escape_string($_POST['keluhan']);
    $diagnosa = $conn->real_escape_string($_POST['diagnosa']);
    $id_obat = !empty($_POST['id_obat']) ? (int)$_POST['id_obat'] : 'NULL';
    $jumlah_obat = !empty($_POST['jumlah_obat']) ? (int)$_POST['jumlah_obat'] : 0;
    $biaya_konsultasi = 150000; // Biaya konsultasi tetap
    
    // Hitung biaya total
    $biaya_obat = 0;
    if($id_obat != 'NULL' && $jumlah_obat > 0) {
        $obat_data = $conn->query("SELECT harga FROM obat WHERE id_obat = $id_obat")->fetch_assoc();
        $biaya_obat = $obat_data['harga'] * $jumlah_obat;
    }
    $biaya_total = $biaya_konsultasi + $biaya_obat;
    
    if(empty($id_pasien) || empty($id_dokter) || empty($tanggal) || empty($keluhan) || empty($diagnosa)) {
        $error = "Semua field kecuali obat harus diisi!";
    } else {
        $query = "INSERT INTO rekam_medis (id_pasien, id_dokter, tanggal_periksa, keluhan, diagnosa, id_obat, jumlah_obat, biaya_total) 
                  VALUES ($id_pasien, $id_dokter, '$tanggal', '$keluhan', '$diagnosa', " . ($id_obat == 'NULL' ? 'NULL' : $id_obat) . ", $jumlah_obat, $biaya_total)";
        
        if($conn->query($query)) {
            // Update stok obat jika ada
            if($id_obat != 'NULL' && $jumlah_obat > 0) {
                $conn->query("UPDATE obat SET stok = stok - $jumlah_obat WHERE id_obat = $id_obat");
            }
            
            $success = "Rekam medis berhasil ditambahkan!";
            header("refresh:2;url=index.php");
        } else {
            $error = "Gagal menambahkan data: " . $conn->error;
        }
    }
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-file-medical text-red-600"></i> Tambah Rekam Medis
            </h1>
            <p class="text-gray-600">Isi form di bawah untuk menambah rekam medis pasien</p>
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

        <form method="POST" action="" id="rekamForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Pasien <span class="text-red-500">*</span>
                    </label>
                    <select name="id_pasien" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <option value="">Pilih Pasien</option>
                        <?php while($p = $pasien_query->fetch_assoc()): ?>
                        <option value="<?= $p['id_pasien'] ?>"><?= htmlspecialchars($p['nama_pasien']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Dokter <span class="text-red-500">*</span>
                    </label>
                    <select name="id_dokter" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <option value="">Pilih Dokter</option>
                        <?php while($d = $dokter_query->fetch_assoc()): ?>
                        <option value="<?= $d['id_dokter'] ?>"><?= htmlspecialchars($d['nama_dokter']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-gray-700 font-medium mb-2">
                    Tanggal Periksa <span class="text-red-500">*</span>
                </label>
                <input type="date" name="tanggal_periksa" required value="<?= date('Y-m-d') ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
            </div>

            <div class="mt-4">
                <label class="block text-gray-700 font-medium mb-2">
                    Keluhan <span class="text-red-500">*</span>
                </label>
                <textarea name="keluhan" rows="3" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                          placeholder="Jelaskan keluhan pasien..."></textarea>
            </div>

            <div class="mt-4">
                <label class="block text-gray-700 font-medium mb-2">
                    Diagnosa <span class="text-red-500">*</span>
                </label>
                <textarea name="diagnosa" rows="3" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                          placeholder="Hasil diagnosa dokter..."></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Obat (Opsional)
                    </label>
                    <select name="id_obat" id="obatSelect"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <option value="">Pilih Obat (jika ada)</option>
                        <?php while($o = $obat_query->fetch_assoc()): ?>
                        <option value="<?= $o['id_obat'] ?>" data-harga="<?= $o['harga'] ?>">
                            <?= htmlspecialchars($o['nama_obat']) ?> - Rp <?= number_format($o['harga'], 0, ',', '.') ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Jumlah Obat
                    </label>
                    <input type="number" name="jumlah_obat" id="jumlahObat" min="0" value="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>
            </div>

            <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                <div class="text-sm text-gray-700 mb-2">
                    <strong>Rincian Biaya:</strong>
                </div>
                <div class="flex justify-between text-sm">
                    <span>Biaya Konsultasi:</span>
                    <span class="font-semibold">Rp 150.000</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span>Biaya Obat:</span>
                    <span class="font-semibold" id="biayaObat">Rp 0</span>
                </div>
                <hr class="my-2">
                <div class="flex justify-between font-bold text-lg text-green-600">
                    <span>Total Biaya:</span>
                    <span id="totalBiaya">Rp 150.000</span>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
                <a href="index.php" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
const obatSelect = document.getElementById('obatSelect');
const jumlahObat = document.getElementById('jumlahObat');
const biayaObatEl = document.getElementById('biayaObat');
const totalBiayaEl = document.getElementById('totalBiaya');
const biayaKonsultasi = 150000;

function hitungTotal() {
    const selectedOption = obatSelect.options[obatSelect.selectedIndex];
    const hargaObat = selectedOption.dataset.harga || 0;
    const jumlah = parseInt(jumlahObat.value) || 0;
    const biayaObat = hargaObat * jumlah;
    const total = biayaKonsultasi + biayaObat;
    
    biayaObatEl.textContent = 'Rp ' + biayaObat.toLocaleString('id-ID');
    totalBiayaEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
}

obatSelect.addEventListener('change', hitungTotal);
jumlahObat.addEventListener('input', hitungTotal);
</script>

<?php include '../../includes/footer.php'; ?>