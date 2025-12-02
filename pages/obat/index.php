<?php
require_once '../../config/database.php';
include '../../includes/header.php';

$query = "SELECT * FROM obat ORDER BY id_obat DESC";
$result = $conn->query($query);
?>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-pills text-purple-600"></i> Data Obat
            </h1>
            <a href="tambah.php" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Obat
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-700">No</th>
                        <th class="px-4 py-3 text-left text-gray-700">Nama Obat</th>
                        <th class="px-4 py-3 text-left text-gray-700">Jenis</th>
                        <th class="px-4 py-3 text-left text-gray-700">Stok</th>
                        <th class="px-4 py-3 text-left text-gray-700">Harga</th>
                        <th class="px-4 py-3 text-center text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php 
                    $no = 1;
                    while($row = $result->fetch_assoc()): 
                    ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3"><?= $no++ ?></td>
                        <td class="px-4 py-3 font-medium"><?= htmlspecialchars($row['nama_obat']) ?></td>
                        <td class="px-4 py-3">
                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">
                                <?= htmlspecialchars($row['jenis_obat']) ?>
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="<?= $row['stok'] < 20 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' ?> px-3 py-1 rounded-full text-sm font-semibold">
                                <?= $row['stok'] ?> pcs
                            </span>
                        </td>
                        <td class="px-4 py-3 font-semibold text-green-600">
                            Rp <?= number_format($row['harga'], 0, ',', '.') ?>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="edit.php?id=<?= $row['id_obat'] ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded mr-1 inline-block transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="hapus.php?id=<?= $row['id_obat'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded inline-block transition">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    
                    <?php if($result->num_rows == 0): ?>
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p>Belum ada data obat</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>