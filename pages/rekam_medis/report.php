<?php
require_once '../../config/database.php';
include '../../includes/header.php';

// safe cast & escape
$bulan = isset($_GET['bulan']) ? intval($_GET['bulan']) : intval(date('m'));
$tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : intval(date('Y'));
$jenis = isset($_GET['jenis']) ? $conn->real_escape_string($_GET['jenis']) : '';

// buat kondisi tanpa duplikasi alias problem
$where = "WHERE MONTH(rm.tanggal_periksa) = $bulan AND YEAR(rm.tanggal_periksa) = $tahun";
if($jenis) {
    $where .= " AND rm.jenis_perawatan = '$jenis'";
}

// main query (pakai alias rm)
$query = "SELECT rm.*, 
          p.nama_pasien,
          d.nama_dokter
          FROM rekam_medis rm
          LEFT JOIN pasien p ON rm.id_pasien = p.id_pasien
          LEFT JOIN dokter d ON rm.id_dokter = d.id_dokter
          $where
          ORDER BY rm.tanggal_periksa DESC";
$result = $conn->query($query);

// stats query: gunakan alias rm juga (sama $where)
$stats_query = "SELECT 
                COUNT(*) as total_rekam,
                SUM(CASE WHEN rm.jenis_perawatan = 'Rawat Jalan' THEN 1 ELSE 0 END) as rawat_jalan,
                SUM(CASE WHEN rm.jenis_perawatan = 'Rawat Inap' THEN 1 ELSE 0 END) as rawat_inap,
                SUM(rm.biaya_total) as total_pendapatan,
                SUM(CASE WHEN rm.status_pembayaran = 'Lunas' THEN rm.biaya_total ELSE 0 END) as pendapatan_lunas,
                SUM(CASE WHEN rm.status_pembayaran = 'Belum Lunas' THEN rm.biaya_total ELSE 0 END) as pendapatan_pending
                FROM rekam_medis rm
                $where";
$stats = $conn->query($stats_query)->fetch_assoc();


// Nama bulan
$nama_bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
?>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-chart-bar text-purple-600"></i> Laporan Rekam Medis
            </h1>
            <div class="flex gap-2">
                <button onclick="window.print()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition no-print">
                    <i class="fas fa-print mr-2"></i> Cetak Laporan
                </button>
                <a href="index.php" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition no-print">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Filter -->
        <form method="GET" class="bg-gray-50 p-4 rounded-lg mb-6 no-print">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Bulan</label>
                    <select name="bulan" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <?php for($i=1; $i<=12; $i++): ?>
                        <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>" <?= $bulan == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' ?>>
                            <?= $nama_bulan[$i] ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Tahun</label>
                    <select name="tahun" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <?php for($y=date('Y'); $y>=2020; $y--): ?>
                        <option value="<?= $y ?>" <?= $tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Jenis Perawatan</label>
                    <select name="jenis" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">Semua</option>
                        <option value="Rawat Jalan" <?= $jenis == 'Rawat Jalan' ? 'selected' : '' ?>>Rawat Jalan</option>
                        <option value="Rawat Inap" <?= $jenis == 'Rawat Inap' ? 'selected' : '' ?>>Rawat Inap</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        <!-- Info Periode -->
        <div class="bg-purple-50 p-4 rounded-lg mb-6">
            <h2 class="text-xl font-bold text-purple-800 mb-2">
                Periode: <?= $nama_bulan[(int)$bulan] ?> <?= $tahun ?>
            </h2>
            <p class="text-purple-700">
                <?= $jenis ? "Jenis Perawatan: $jenis" : "Semua Jenis Perawatan" ?>
            </p>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm mb-1">Total Rekam Medis</p>
                        <h3 class="text-3xl font-bold"><?= $stats['total_rekam'] ?></h3>
                    </div>
                    <div class="bg-blue-400 p-4 rounded-full">
                        <i class="fas fa-file-medical text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm mb-1">Rawat Jalan</p>
                        <h3 class="text-3xl font-bold"><?= $stats['rawat_jalan'] ?? 0 ?></h3>
                    </div>
                    <div class="bg-green-400 p-4 rounded-full">
                        <i class="fas fa-procedures text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm mb-1">Rawat Inap</p>
                        <h3 class="text-3xl font-bold"><?= $stats['rawat_inap'] ?? 0 ?></h3>
                    </div>
                    <div class="bg-orange-400 p-4 rounded-full">
                        <i class="fas fa-bed text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm mb-1">Total Pendapatan</p>
                        <h3 class="text-2xl font-bold">Rp <?= number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.') ?></h3>
                    </div>
                    <div class="bg-purple-400 p-4 rounded-full">
                        <i class="fas fa-money-bill-wave text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Pendapatan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-700 mb-1">Pendapatan Lunas</p>
                        <h3 class="text-2xl font-bold text-green-600">Rp <?= number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.') ?></h3>
                    </div>
                    <i class="fas fa-check-circle text-4xl text-green-500"></i>
                </div>
            </div>

            <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-700 mb-1">Pendapatan Pending</p>
                        <h3 class="text-2xl font-bold text-red-600">Rp <?= number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.') ?></h3>
                    </div>
                    <i class="fas fa-clock text-4xl text-red-500"></i>
                </div>
            </div>
        </div>

        <!-- Tabel Detail -->
        <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Rekam Medis</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-3 text-left text-gray-700">No</th>
                        <th class="px-3 py-3 text-left text-gray-700">Tanggal</th>
                        <th class="px-3 py-3 text-left text-gray-700">Pasien</th>
                        <th class="px-3 py-3 text-left text-gray-700">Dokter</th>
                        <th class="px-3 py-3 text-left text-gray-700">Jenis</th>
                        <th class="px-3 py-3 text-left text-gray-700">Diagnosa</th>
                        <th class="px-3 py-3 text-right text-gray-700">Biaya</th>
                        <th class="px-3 py-3 text-center text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php 
                    $no = 1;
                    $total = 0;
                    while($row = $result->fetch_assoc()): 
                    $total += $row['biaya_total'];
                    ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-3"><?= $no++ ?></td>
                        <td class="px-3 py-3"><?= date('d/m/Y', strtotime($row['tanggal_periksa'])) ?></td>
                        <td class="px-3 py-3 font-medium"><?= htmlspecialchars($row['nama_pasien']) ?></td>
                        <td class="px-3 py-3 text-xs"><?= htmlspecialchars($row['nama_dokter']) ?></td>
                        <td class="px-3 py-3">
                            <?php if($row['jenis_perawatan'] == 'Rawat Inap'): ?>
                            <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs">Inap</span>
                            <?php else: ?>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Jalan</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-3 text-xs"><?= substr(htmlspecialchars($row['diagnosa']), 0, 30) ?>...</td>
                        <td class="px-3 py-3 text-right font-semibold text-green-600">Rp <?= number_format($row['biaya_total'], 0, ',', '.') ?></td>
                        <td class="px-3 py-3 text-center">
                            <?php if($row['status_pembayaran'] == 'Lunas'): ?>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">✓</span>
                            <?php else: ?>
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">✗</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    
                    <?php if($result->num_rows > 0): ?>
                    <tr class="bg-gray-100 font-bold">
                        <td colspan="6" class="px-3 py-3 text-right">TOTAL:</td>
                        <td class="px-3 py-3 text-right text-green-600">Rp <?= number_format($total, 0, ',', '.') ?></td>
                        <td></td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p>Tidak ada data untuk periode ini</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print { display: none !important; }
    body { background: white; }
    .container { max-width: 100%; }
}
</style>

<?php include '../../includes/footer.php'; ?>