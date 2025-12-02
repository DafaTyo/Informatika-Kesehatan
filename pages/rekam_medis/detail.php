<?php
require_once '../../config/database.php';
include '../../includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT rm.*, 
          p.nama_pasien, p.tanggal_lahir, p.jenis_kelamin, p.no_telp as telp_pasien, p.alamat as alamat_pasien,
          d.nama_dokter, d.spesialisasi, d.no_telp as telp_dokter,
          o.nama_obat, o.jenis_obat
          FROM rekam_medis rm
          LEFT JOIN pasien p ON rm.id_pasien = p.id_pasien
          LEFT JOIN dokter d ON rm.id_dokter = d.id_dokter
          LEFT JOIN obat o ON rm.id_obat = o.id_obat
          WHERE rm.id_rekam = $id";
$result = $conn->query($query);
$data = $result->fetch_assoc();

if(!$data) {
    header("Location: index.php");
    exit();
}

// Hitung umur pasien
$umur = date_diff(date_create($data['tanggal_lahir']), date_create('today'))->y;
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-file-medical-alt text-red-600"></i> Detail Rekam Medis
                    </h1>
                    <p class="text-gray-600">No. Rekam: <span class="font-bold text-blue-600">RM-<?= str_pad($data['id_rekam'], 6, '0', STR_PAD_LEFT) ?></span></p>
                </div>
                <div class="text-right">
                    <div class="mb-2">
                        <?php if($data['status_pembayaran'] == 'Lunas'): ?>
                        <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-check-circle"></i> LUNAS
                        </span>
                        <?php else: ?>
                        <span class="bg-red-100 text-red-800 px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-times-circle"></i> BELUM LUNAS
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="text-sm text-gray-600">
                        Dibuat: <?= date('d/m/Y H:i', strtotime($data['created_at'])) ?>
                    </div>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="index.php" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <a href="surat.php?id=<?= $id ?>" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-print mr-2"></i> Cetak Surat Dokter
                </a>
                <a href="edit.php?id=<?= $id ?>" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            
            <!-- Data Pasien -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-user text-blue-600"></i> Data Pasien
                </h2>
                <div class="space-y-3">
                    <div class="flex">
                        <span class="text-gray-600 w-32">Nama</span>
                        <span class="font-semibold">: <?= htmlspecialchars($data['nama_pasien']) ?></span>
                    </div>
                    <div class="flex">
                        <span class="text-gray-600 w-32">Jenis Kelamin</span>
                        <span class="font-semibold">: <?= $data['jenis_kelamin'] ?></span>
                    </div>
                    <div class="flex">
                        <span class="text-gray-600 w-32">Tanggal Lahir</span>
                        <span class="font-semibold">: <?= date('d/m/Y', strtotime($data['tanggal_lahir'])) ?> (<?= $umur ?> tahun)</span>
                    </div>
                    <div class="flex">
                        <span class="text-gray-600 w-32">No. Telepon</span>
                        <span class="font-semibold">: <?= htmlspecialchars($data['telp_pasien']) ?></span>
                    </div>
                    <div class="flex">
                        <span class="text-gray-600 w-32">Alamat</span>
                        <span class="font-semibold">: <?= htmlspecialchars($data['alamat_pasien']) ?></span>
                    </div>
                </div>
            </div>

            <!-- Data Dokter -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-user-md text-green-600"></i> Dokter Pemeriksa
                </h2>
                <div class="space-y-3">
                    <div class="flex">
                        <span class="text-gray-600 w-32">Nama Dokter</span>
                        <span class="font-semibold">: <?= htmlspecialchars($data['nama_dokter']) ?></span>
                    </div>
                    <div class="flex">
                        <span class="text-gray-600 w-32">Spesialisasi</span>
                        <span class="font-semibold">: <?= htmlspecialchars($data['spesialisasi']) ?></span>
                    </div>
                    <div class="flex">
                        <span class="text-gray-600 w-32">No. Telepon</span>
                        <span class="font-semibold">: <?= htmlspecialchars($data['telp_dokter']) ?></span>
                    </div>
                    <div class="flex">
                        <span class="text-gray-600 w-32">Tanggal Periksa</span>
                        <span class="font-semibold">: <?= date('d F Y', strtotime($data['tanggal_periksa'])) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Perawatan -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                <i class="fas fa-procedures text-purple-600"></i> Informasi Perawatan
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-3">
                        <span class="text-gray-600 block mb-1">Jenis Perawatan:</span>
                        <?php if($data['jenis_perawatan'] == 'Rawat Inap'): ?>
                        <span class="bg-orange-100 text-orange-800 px-4 py-2 rounded-lg text-sm font-semibold inline-block">
                            <i class="fas fa-bed"></i> Rawat Inap
                        </span>
                        <?php else: ?>
                        <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg text-sm font-semibold inline-block">
                            <i class="fas fa-procedures"></i> Rawat Jalan
                        </span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if($data['jenis_perawatan'] == 'Rawat Inap'): ?>
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-700">Tanggal Masuk:</span>
                                <span class="font-semibold"><?= date('d/m/Y', strtotime($data['tanggal_masuk'])) ?></span>
                            </div>
                            <?php if($data['tanggal_keluar']): ?>
                            <div class="flex justify-between">
                                <span class="text-gray-700">Tanggal Keluar:</span>
                                <span class="font-semibold"><?= date('d/m/Y', strtotime($data['tanggal_keluar'])) ?></span>
                            </div>
                            <div class="flex justify-between border-t pt-2">
                                <span class="text-gray-700 font-bold">Lama Rawat:</span>
                                <span class="font-bold text-orange-600"><?= $data['lama_rawat'] ?> Hari</span>
                            </div>
                            <?php else: ?>
                            <div class="text-orange-600 font-semibold">
                                <i class="fas fa-info-circle"></i> Pasien masih dirawat
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div>
                    <div class="mb-2">
                        <span class="text-gray-600 block mb-2">Keluhan:</span>
                        <div class="bg-gray-50 p-3 rounded-lg text-sm">
                            <?= nl2br(htmlspecialchars($data['keluhan'])) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diagnosa & Tindakan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-stethoscope text-red-600"></i> Diagnosa
                </h2>
                <div class="bg-red-50 p-4 rounded-lg">
                    <p class="text-gray-800"><?= nl2br(htmlspecialchars($data['diagnosa'])) ?></p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-hand-holding-medical text-blue-600"></i> Tindakan
                </h2>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-gray-800"><?= $data['tindakan'] ? nl2br(htmlspecialchars($data['tindakan'])) : '<span class="text-gray-500">-</span>' ?></p>
                </div>
            </div>
        </div>

        <!-- Obat & Catatan Dokter -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-pills text-purple-600"></i> Obat yang Diberikan
                </h2>
                <?php if($data['nama_obat']): ?>
                <div class="space-y-2">
                    <div class="flex justify-between items-center bg-purple-50 p-3 rounded-lg">
                        <div>
                            <div class="font-semibold text-gray-800"><?= htmlspecialchars($data['nama_obat']) ?></div>
                            <div class="text-sm text-gray-600"><?= htmlspecialchars($data['jenis_obat']) ?></div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-purple-600"><?= $data['jumlah_obat'] ?>x</div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <p class="text-gray-500 text-center py-4">Tidak ada obat yang diresepkan</p>
                <?php endif; ?>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-notes-medical text-green-600"></i> Catatan Dokter
                </h2>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-gray-800"><?= $data['catatan_dokter'] ? nl2br(htmlspecialchars($data['catatan_dokter'])) : '<span class="text-gray-500">-</span>' ?></p>
                </div>
            </div>
        </div>

        <!-- Rincian Biaya -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                <i class="fas fa-money-bill-wave text-green-600"></i> Rincian Biaya
            </h2>
            <div class="bg-green-50 p-4 rounded-lg">
                <table class="w-full">
                    <tr class="border-b">
                        <td class="py-2 text-gray-700">Biaya Konsultasi Dokter</td>
                        <td class="py-2 text-right font-semibold">Rp <?= number_format($data['biaya_konsultasi'], 0, ',', '.') ?></td>
                    </tr>
                    <?php if($data['jenis_perawatan'] == 'Rawat Inap' && $data['biaya_rawat_inap'] > 0): ?>
                    <tr class="border-b">
                        <td class="py-2 text-gray-700">Biaya Rawat Inap (<?= $data['lama_rawat'] ?> hari)</td>
                        <td class="py-2 text-right font-semibold">Rp <?= number_format($data['biaya_rawat_inap'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if($data['biaya_obat'] > 0): ?>
                    <tr class="border-b">
                        <td class="py-2 text-gray-700">Biaya Obat</td>
                        <td class="py-2 text-right font-semibold">Rp <?= number_format($data['biaya_obat'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr class="border-t-2 border-green-300">
                        <td class="py-3 text-gray-900 font-bold text-lg">TOTAL BIAYA</td>
                        <td class="py-3 text-right font-bold text-xl text-green-600">Rp <?= number_format($data['biaya_total'], 0, ',', '.') ?></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</div>

<?php include '../../includes/footer.php'; ?>