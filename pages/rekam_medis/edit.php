<?php
require_once '../../config/database.php';
include '../../includes/header.php';

$error = '';
$success = '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data rekam medis
$query = "SELECT * FROM rekam_medis WHERE id_rekam = $id";
$result = $conn->query($query);
$rekam = $result->fetch_assoc();

if(!$rekam) {
    header("Location: index.php");
    exit();
}

// Ambil data untuk dropdown
$pasien_query = $conn->query("SELECT id_pasien, nama_pasien FROM pasien ORDER BY nama_pasien");
$dokter_query = $conn->query("SELECT id_dokter, nama_dokter FROM dokter ORDER BY nama_dokter");
$obat_query = $conn->query("SELECT id_obat, nama_obat, harga FROM obat ORDER BY nama_obat");

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pasien = (int)$_POST['id_pasien'];
    $id_dokter = (int)$_POST['id_dokter'];
    $tanggal = $conn->real_escape_string($_POST['tanggal_periksa']);
    $jenis_perawatan = $conn->real_escape_string($_POST['jenis_perawatan']);
    $keluhan = $conn->real_escape_string($_POST['keluhan']);
    $diagnosa = $conn->real_escape_string($_POST['diagnosa']);
    $tindakan = $conn->real_escape_string($_POST['tindakan']);
    $catatan_dokter = $conn->real_escape_string($_POST['catatan_dokter']);
    $id_obat = !empty($_POST['id_obat']) ? (int)$_POST['id_obat'] : 'NULL';
    $jumlah_obat = !empty($_POST['jumlah_obat']) ? (int)$_POST['jumlah_obat'] : 0;
    $status_pembayaran = $conn->real_escape_string($_POST['status_pembayaran']);
    
    // Data rawat inap
    $tanggal_masuk = ($jenis_perawatan == 'Rawat Inap') ? $conn->real_escape_string($_POST['tanggal_masuk']) : 'NULL';
    $tanggal_keluar = ($jenis_perawatan == 'Rawat Inap' && !empty($_POST['tanggal_keluar'])) ? $conn->real_escape_string($_POST['tanggal_keluar']) : 'NULL';
    
    // Hitung lama rawat
    $lama_rawat = 0;
    if($jenis_perawatan == 'Rawat Inap' && $tanggal_masuk != 'NULL' && $tanggal_keluar != 'NULL') {
        $date1 = new DateTime($_POST['tanggal_masuk']);
        $date2 = new DateTime($_POST['tanggal_keluar']);
        $lama_rawat = $date2->diff($date1)->days;
    }
    
    // Hitung biaya
    $biaya_konsultasi = 150000;
    $biaya_rawat_inap = ($jenis_perawatan == 'Rawat Inap') ? ($lama_rawat * 300000) : 0;
    
    $biaya_obat = 0;
    if($id_obat != 'NULL' && $jumlah_obat > 0) {
        $obat_data = $conn->query("SELECT harga FROM obat WHERE id_obat = $id_obat")->fetch_assoc();
        $biaya_obat = $obat_data['harga'] * $jumlah_obat;
    }
    $biaya_total = $biaya_konsultasi + $biaya_rawat_inap + $biaya_obat;
    
    if(empty($id_pasien) || empty($id_dokter) || empty($tanggal) || empty($keluhan) || empty($diagnosa)) {
        $error = "Pasien, dokter, tanggal, keluhan, dan diagnosa harus diisi!";
    } else {
        // Kembalikan stok obat lama jika ada
        if($rekam['id_obat'] && $rekam['jumlah_obat'] > 0) {
            $conn->query("UPDATE obat SET stok = stok + {$rekam['jumlah_obat']} WHERE id_obat = {$rekam['id_obat']}");
        }
        
        // Update rekam medis
        $query = "UPDATE rekam_medis SET 
                  id_pasien = $id_pasien,
                  id_dokter = $id_dokter,
                  tanggal_periksa = '$tanggal',
                  jenis_perawatan = '$jenis_perawatan',
                  tanggal_masuk = " . ($tanggal_masuk == 'NULL' ? 'NULL' : "'$tanggal_masuk'") . ",
                  tanggal_keluar = " . ($tanggal_keluar == 'NULL' ? 'NULL' : "'$tanggal_keluar'") . ",
                  lama_rawat = $lama_rawat,
                  keluhan = '$keluhan',
                  diagnosa = '$diagnosa',
                  tindakan = '$tindakan',
                  id_obat = " . ($id_obat == 'NULL' ? 'NULL' : $id_obat) . ",
                  jumlah_obat = $jumlah_obat,
                  biaya_konsultasi = $biaya_konsultasi,
                  biaya_rawat_inap = $biaya_rawat_inap,
                  biaya_obat = $biaya_obat,
                  biaya_total = $biaya_total,
                  status_pembayaran = '$status_pembayaran',
                  catatan_dokter = '$catatan_dokter'
                  WHERE id_rekam = $id";
        
        if($conn->query($query)) {
            // Kurangi stok obat baru jika ada
            if($id_obat != 'NULL' && $jumlah_obat > 0) {
                $conn->query("UPDATE obat SET stok = stok - $jumlah_obat WHERE id_obat = $id_obat");
            }
            
            $success = "Rekam medis berhasil diupdate!";
            header("refresh:2;url=index.php");
        } else {
            $error = "Gagal mengupdate data: " . $conn->error;
        }
    }
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-edit text-yellow-600"></i> Edit Rekam Medis
            </h1>
            <p class="text-gray-600">Perbarui informasi rekam medis pasien</p>
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
            <!-- Pasien & Dokter -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Pasien <span class="text-red-500">*</span>
                    </label>
                    <select name="id_pasien" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="">Pilih Pasien</option>
                        <?php while($p = $pasien_query->fetch_assoc()): ?>
                        <option value="<?= $p['id_pasien'] ?>" <?= $rekam['id_pasien'] == $p['id_pasien'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['nama_pasien']) ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Dokter <span class="text-red-500">*</span>
                    </label>
                    <select name="id_dokter" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="">Pilih Dokter</option>
                        <?php while($d = $dokter_query->fetch_assoc()): ?>
                        <option value="<?= $d['id_dokter'] ?>" <?= $rekam['id_dokter'] == $d['id_dokter'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($d['nama_dokter']) ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <!-- Tanggal Periksa & Jenis Perawatan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Tanggal Periksa <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_periksa" required 
                           value="<?= $rekam['tanggal_periksa'] ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Jenis Perawatan <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis_perawatan" id="jenisPerawatan" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="Rawat Jalan" <?= $rekam['jenis_perawatan'] == 'Rawat Jalan' ? 'selected' : '' ?>>Rawat Jalan</option>
                        <option value="Rawat Inap" <?= $rekam['jenis_perawatan'] == 'Rawat Inap' ? 'selected' : '' ?>>Rawat Inap</option>
                    </select>
                </div>
            </div>

            <!-- Section Rawat Inap -->
            <div id="rawatInapSection" class="<?= $rekam['jenis_perawatan'] != 'Rawat Inap' ? 'hidden' : '' ?> mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <h3 class="font-bold text-gray-800 mb-3">
                    <i class="fas fa-bed text-blue-600"></i> Informasi Rawat Inap
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Tanggal Masuk <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_masuk" id="tanggalMasuk" 
                               value="<?= $rekam['tanggal_masuk'] ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Tanggal Keluar
                        </label>
                        <input type="date" name="tanggal_keluar" id="tanggalKeluar"
                               value="<?= $rekam['tanggal_keluar'] ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Lama Rawat
                        </label>
                        <input type="text" id="lamaRawat" readonly
                               value="<?= $rekam['lama_rawat'] > 0 ? $rekam['lama_rawat'] . ' hari' : '' ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100"
                               placeholder="Auto calculated">
                    </div>
                </div>
            </div>

            <!-- Keluhan & Diagnosa -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Keluhan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="keluhan" rows="4" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"><?= htmlspecialchars($rekam['keluhan']) ?></textarea>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Diagnosa <span class="text-red-500">*</span>
                    </label>
                    <textarea name="diagnosa" rows="4" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"><?= htmlspecialchars($rekam['diagnosa']) ?></textarea>
                </div>
            </div>

            <!-- Tindakan & Catatan Dokter -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Tindakan
                    </label>
                    <textarea name="tindakan" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"><?= htmlspecialchars($rekam['tindakan']) ?></textarea>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Catatan Dokter
                    </label>
                    <textarea name="catatan_dokter" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"><?= htmlspecialchars($rekam['catatan_dokter']) ?></textarea>
                </div>
            </div>

            <!-- Obat -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Obat (Opsional)
                    </label>
                    <select name="id_obat" id="obatSelect"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="">Pilih Obat (jika ada)</option>
                        <?php while($o = $obat_query->fetch_assoc()): ?>
                        <option value="<?= $o['id_obat'] ?>" 
                                data-harga="<?= $o['harga'] ?>"
                                <?= $rekam['id_obat'] == $o['id_obat'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($o['nama_obat']) ?> - Rp <?= number_format($o['harga'], 0, ',', '.') ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Jumlah Obat
                    </label>
                    <input type="number" name="jumlah_obat" id="jumlahObat" min="0" 
                           value="<?= $rekam['jumlah_obat'] ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>
            </div>

            <!-- Status Pembayaran -->
            <div class="mt-4">
                <label class="block text-gray-700 font-medium mb-2">
                    Status Pembayaran <span class="text-red-500">*</span>
                </label>
                <select name="status_pembayaran" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    <option value="Belum Lunas" <?= $rekam['status_pembayaran'] == 'Belum Lunas' ? 'selected' : '' ?>>Belum Lunas</option>
                    <option value="Lunas" <?= $rekam['status_pembayaran'] == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                </select>
            </div>

            <!-- Rincian Biaya -->
            <div class="mt-4 p-4 bg-green-50 rounded-lg border border-green-200">
                <div class="text-sm text-gray-700 mb-3">
                    <strong class="text-lg"><i class="fas fa-calculator"></i> Rincian Biaya:</strong>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span>Biaya Konsultasi Dokter:</span>
                        <span class="font-semibold">Rp 150.000</span>
                    </div>
                    <div class="flex justify-between text-sm" id="biayaRawatRow" style="<?= $rekam['jenis_perawatan'] != 'Rawat Inap' ? 'display:none;' : '' ?>">
                        <span>Biaya Rawat Inap (<span id="hariRawat"><?= $rekam['lama_rawat'] ?></span> hari × Rp 300.000):</span>
                        <span class="font-semibold" id="biayaRawat">Rp <?= number_format($rekam['biaya_rawat_inap'], 0, ',', '.') ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Biaya Obat:</span>
                        <span class="font-semibold" id="biayaObat">Rp <?= number_format($rekam['biaya_obat'], 0, ',', '.') ?></span>
                    </div>
                    <hr class="my-2 border-green-300">
                    <div class="flex justify-between font-bold text-lg text-green-700">
                        <span>Total Biaya:</span>
                        <span id="totalBiaya">Rp <?= number_format($rekam['biaya_total'], 0, ',', '.') ?></span>
                    </div>
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

<script>
const jenisPerawatan = document.getElementById('jenisPerawatan');
const rawatInapSection = document.getElementById('rawatInapSection');
const tanggalMasuk = document.getElementById('tanggalMasuk');
const tanggalKeluar = document.getElementById('tanggalKeluar');
const lamaRawat = document.getElementById('lamaRawat');
const obatSelect = document.getElementById('obatSelect');
const jumlahObat = document.getElementById('jumlahObat');
const biayaObatEl = document.getElementById('biayaObat');
const totalBiayaEl = document.getElementById('totalBiaya');
const biayaRawatEl = document.getElementById('biayaRawat');
const biayaRawatRow = document.getElementById('biayaRawatRow');
const hariRawat = document.getElementById('hariRawat');

const biayaKonsultasi = 150000;
const biayaPerHari = 300000;

// Toggle Rawat Inap Section
jenisPerawatan.addEventListener('change', function() {
    if(this.value === 'Rawat Inap') {
        rawatInapSection.classList.remove('hidden');
        tanggalMasuk.required = true;
    } else {
        rawatInapSection.classList.add('hidden');
        tanggalMasuk.required = false;
        tanggalKeluar.value = '';
        lamaRawat.value = '';
    }
    hitungTotal();
});

// Hitung Lama Rawat
function hitungLamaRawat() {
    if(tanggalMasuk.value && tanggalKeluar.value) {
        const date1 = new Date(tanggalMasuk.value);
        const date2 = new Date(tanggalKeluar.value);
        const diffTime = Math.abs(date2 - date1);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        lamaRawat.value = diffDays + ' hari';
        return diffDays;
    }
    return 0;
}

function hitungTotal() {
    let total = biayaKonsultasi;
    
    // Biaya Rawat Inap
    let biayaRawatInap = 0;
    if(jenisPerawatan.value === 'Rawat Inap') {
        const hari = hitungLamaRawat();
        biayaRawatInap = hari * biayaPerHari;
        biayaRawatEl.textContent = 'Rp ' + biayaRawatInap.toLocaleString('id-ID');
        hariRawat.textContent = hari;
        biayaRawatRow.style.display = 'flex';
        total += biayaRawatInap;
    } else {
        biayaRawatRow.style.display = 'none';
    }
    
    // Biaya Obat
    const selectedOption = obatSelect.options[obatSelect.selectedIndex];
    const hargaObat = selectedOption.dataset.harga || 0;
    const jumlah = parseInt(jumlahObat.value) || 0;
    const biayaObat = hargaObat * jumlah;
    
    biayaObatEl.textContent = 'Rp ' + biayaObat.toLocaleString('id-ID');
    total += biayaObat;
    
    totalBiayaEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
}

tanggalMasuk.addEventListener('change', hitungTotal);
tanggalKeluar.addEventListener('change', hitungTotal);
obatSelect.addEventListener('change', hitungTotal);
jumlahObat.addEventListener('input', hitungTotal);

// Hitung saat load pertama kali
hitungTotal();
</script>

<?php include '../../includes/footer.php'; ?>