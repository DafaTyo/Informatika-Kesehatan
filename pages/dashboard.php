<?php
require_once '../config/database.php';
include '../includes/header.php';

// Hitung statistik
$total_dokter = $conn->query("SELECT COUNT(*) as total FROM dokter")->fetch_assoc()['total'];
$total_pasien = $conn->query("SELECT COUNT(*) as total FROM pasien")->fetch_assoc()['total'];
$total_obat = $conn->query("SELECT COUNT(*) as total FROM obat")->fetch_assoc()['total'];
$total_rekam = $conn->query("SELECT COUNT(*) as total FROM rekam_medis")->fetch_assoc()['total'];
?>

<div class="container mx-auto px-4 py-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-700 rounded-lg shadow-xl p-8 mb-8 text-white">
        <h1 class="text-4xl font-bold mb-4">Selamat Datang di RS Sehat Sejahtera</h1>
        <p class="text-xl">Sistem Informasi Manajemen Rumah Sakit Terpadu</p>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card Dokter -->
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Total Dokter</p>
                    <h3 class="text-3xl font-bold text-blue-600"><?= $total_dokter ?></h3>
                </div>
                <div class="bg-blue-100 p-4 rounded-full">
                    <i class="fas fa-user-md text-3xl text-blue-600"></i>
                </div>
            </div>
            <a href="../pages/dokter/index.php" class="text-blue-600 text-sm mt-4 inline-block hover:underline">
                Lihat Detail <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Card Pasien -->
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Total Pasien</p>
                    <h3 class="text-3xl font-bold text-green-600"><?= $total_pasien ?></h3>
                </div>
                <div class="bg-green-100 p-4 rounded-full">
                    <i class="fas fa-users text-3xl text-green-600"></i>
                </div>
            </div>
            <a href="../pages/pasien/index.php" class="text-green-600 text-sm mt-4 inline-block hover:underline">
                Lihat Detail <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Card Obat -->
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Total Obat</p>
                    <h3 class="text-3xl font-bold text-purple-600"><?= $total_obat ?></h3>
                </div>
                <div class="bg-purple-100 p-4 rounded-full">
                    <i class="fas fa-pills text-3xl text-purple-600"></i>
                </div>
            </div>
            <a href="../pages/obat/index.php" class="text-purple-600 text-sm mt-4 inline-block hover:underline">
                Lihat Detail <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Card Rekam Medis -->
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Total Rekam Medis</p>
                    <h3 class="text-3xl font-bold text-red-600"><?= $total_rekam ?></h3>
                </div>
                <div class="bg-red-100 p-4 rounded-full">
                    <i class="fas fa-file-medical text-3xl text-red-600"></i>
                </div>
            </div>
            <a href="../pages/rekam_medis/index.php" class="text-red-600 text-sm mt-4 inline-block hover:underline">
                Lihat Detail <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Menu Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Fitur Utama -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">
                <i class="fas fa-star text-yellow-500"></i> Fitur Utama
            </h2>
            <ul class="space-y-3">
                <li class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span>Manajemen Data Dokter</span>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span>Manajemen Data Pasien</span>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span>Inventori Obat</span>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span>Rekam Medis Elektronik</span>
                </li>
            </ul>
        </div>

        <!-- Quick Links -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">
                <i class="fas fa-link text-blue-500"></i> Quick Links
            </h2>
            <div class="space-y-3">
                <a href="../pages/dokter/tambah.php" class="block bg-blue-50 hover:bg-blue-100 p-3 rounded transition">
                    <i class="fas fa-plus-circle text-blue-600"></i> Tambah Dokter Baru
                </a>
                <a href="../pages/pasien/tambah.php" class="block bg-green-50 hover:bg-green-100 p-3 rounded transition">
                    <i class="fas fa-plus-circle text-green-600"></i> Tambah Pasien Baru
                </a>
                <a href="../pages/obat/tambah.php" class="block bg-purple-50 hover:bg-purple-100 p-3 rounded transition">
                    <i class="fas fa-plus-circle text-purple-600"></i> Tambah Obat Baru
                </a>
                <a href="../pages/rekam_medis/tambah.php" class="block bg-red-50 hover:bg-red-100 p-3 rounded transition">
                    <i class="fas fa-plus-circle text-red-600"></i> Tambah Rekam Medis
                </a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>