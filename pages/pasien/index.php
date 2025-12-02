<?php
require_once '../../config/database.php';
include '../../includes/header.php';

$query = "SELECT * FROM pasien ORDER BY id_pasien DESC";
$result = $conn->query($query);
?>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-users text-green-600"></i> Data Pasien
            </h1>
            <a href="tambah.php" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Pasien
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-700">No</th>
                        <th class="px-4 py-3 text-left text-gray-700">Nama Pasien</th>
                        <th class="px-4 py-3 text-left text-gray-700">Tanggal Lahir</th>
                        <th class="px-4 py-3 text-left text-gray-700">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-left text-gray-700">No. Telp</th>
                        <th class="px-4 py-3 text-left text-gray-700">Alamat</th>
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
                        <td class="px-4 py-3 font-medium"><?= htmlspecialchars($row['nama_pasien']) ?></td>
                        <td class="px-4 py-3"><?= date('d/m/Y', strtotime($row['tanggal_lahir'])) ?></td>
                        <td class="px-4 py-3">
                            <span class="<?= $row['jenis_kelamin'] == 'Laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' ?> px-3 py-1 rounded-full text-sm">
                                <?= $row['jenis_kelamin'] ?>
                            </span>
                        </td>
                        <td class="px-4 py-3"><?= htmlspecialchars($row['no_telp']) ?></td>
                        <td class="px-4 py-3"><?= htmlspecialchars($row['alamat']) ?></td>
                        <td class="px-4 py-3 text-center">
                            <a href="edit.php?id=<?= $row['id_pasien'] ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded mr-1 inline-block transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="hapus.php?id=<?= $row['id_pasien'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded inline-block transition">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    
                    <?php if($result->num_rows == 0): ?>
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p>Belum ada data pasien</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>