<?php
require_once '../../config/database.php';
include '../../includes/header.php';

$query = "SELECT rm.*, 
          p.nama_pasien, p.tanggal_lahir, p.jenis_kelamin,
          d.nama_dokter, d.spesialisasi,
          o.nama_obat
          FROM rekam_medis rm
          LEFT JOIN pasien p ON rm.id_pasien = p.id_pasien
          LEFT JOIN dokter d ON rm.id_dokter = d.id_dokter
          LEFT JOIN obat o ON rm.id_obat = o.id_obat
          ORDER BY rm.id_rekam DESC";
$result = $conn->query($query);
?>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-file-medical text-red-600"></i> Rekam Medis
            </h1>
            <div class="flex gap-2">
                <a href="report.php" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i> Laporan
                </a>
                <a href="tambah.php" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-plus mr-2"></i> Tambah Rekam Medis
                </a>
            </div>
        </div>

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
                        <th class="px-3 py-3 text-left text-gray-700">Biaya</th>
                        <th class="px-3 py-3 text-left text-gray-700">Status</th>
                        <th class="px-3 py-3 text-center text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php 
                    $no = 1;
                    while($row = $result->fetch_assoc()): 
                    ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-3"><?= $no++ ?></td>
                        <td class="px-3 py-3">
                            <div class="text-xs">
                                <?= date('d/m/Y', strtotime($row['tanggal_periksa'])) ?>
                            </div>
                        </td>
                        <td class="px-3 py-3">
                            <div class="font-medium"><?= htmlspecialchars($row['nama_pasien']) ?></div>
                        </td>
                        <td class="px-3 py-3">
                            <div class="text-xs"><?= htmlspecialchars($row['nama_dokter']) ?></div>
                        </td>
                        <td class="px-3 py-3">
                            <?php if($row['jenis_perawatan'] == 'Rawat Inap'): ?>
                            <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs font-semibold">
                                <i class="fas fa-bed"></i> Inap
                            </span>
                            <?php if($row['lama_rawat'] > 0): ?>
                            <div class="text-xs text-gray-600 mt-1"><?= $row['lama_rawat'] ?> hari</div>
                            <?php endif; ?>
                            <?php else: ?>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">
                                <i class="fas fa-procedures"></i> Jalan
                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-3">
                            <div class="text-xs"><?= substr(htmlspecialchars($row['diagnosa']), 0, 40) ?>...</div>
                        </td>
                        <td class="px-3 py-3">
                            <div class="font-semibold text-green-600 text-xs">
                                Rp <?= number_format($row['biaya_total'], 0, ',', '.') ?>
                            </div>
                        </td>
                        <td class="px-3 py-3">
                            <?php if($row['status_pembayaran'] == 'Lunas'): ?>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">
                                <i class="fas fa-check-circle"></i> Lunas
                            </span>
                            <?php else: ?>
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold">
                                <i class="fas fa-times-circle"></i> Belum
                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-3 text-center">
                            <div class="flex gap-1 justify-center">
                                <a href="detail.php?id=<?= $row['id_rekam'] ?>" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded inline-block transition text-xs"
                                   title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="surat.php?id=<?= $row['id_rekam'] ?>" 
                                   target="_blank"
                                   class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded inline-block transition text-xs"
                                   title="Cetak Surat">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <a href="edit.php?id=<?= $row['id_rekam'] ?>" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded inline-block transition text-xs"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="hapus.php?id=<?= $row['id_rekam'] ?>" 
                                   onclick="return confirm('Yakin ingin menghapus data ini?')" 
                                   class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded inline-block transition text-xs"
                                   title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    
                    <?php if($result->num_rows == 0): ?>
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p>Belum ada data rekam medis</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>