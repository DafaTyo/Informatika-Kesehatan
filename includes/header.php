<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Rumah Sakit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tambahkan baris ini untuk custom CSS -->
    <link rel="stylesheet" href="/hospital-app/assets/css/style.css">
</head>
<style>
@media print {
    header,
    footer,
    nav,
    .navbar,
    .topbar,
    .sidebar,
    .app-header {
        display: none !important;
    }
}
</style>

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-hospital text-2xl"></i>
                    <span class="text-xl font-bold">RS Sehat Sejahtera</span>
                </div>
                <div class="hidden md:flex space-x-6">
                    <a href="/hospital-app/pages/dashboard.php" class="hover:text-blue-200 transition">
                        <i class="fas fa-home"></i> Home
                    </a>
                    <a href="/hospital-app/pages/dokter/index.php" class="hover:text-blue-200 transition">
                        <i class="fas fa-user-md"></i> Dokter
                    </a>
                    <a href="/hospital-app/pages/pasien/index.php" class="hover:text-blue-200 transition">
                        <i class="fas fa-users"></i> Pasien
                    </a>
                    <a href="/hospital-app/pages/obat/index.php" class="hover:text-blue-200 transition">
                        <i class="fas fa-pills"></i> Obat
                    </a>
                    <a href="/hospital-app/pages/rekam_medis/index.php" class="hover:text-blue-200 transition">
                        <i class="fas fa-file-medical"></i> Rekam Medis
                    </a>
                </div>
                <button class="md:hidden" id="menuBtn">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4 space-y-2">
                <a href="/hospital-app/index.php" class="block hover:bg-blue-700 px-4 py-2 rounded">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="/hospital-app/pages/dokter/index.php" class="block hover:bg-blue-700 px-4 py-2 rounded">
                    <i class="fas fa-user-md"></i> Dokter
                </a>
                <a href="/hospital-app/pages/pasien/index.php" class="block hover:bg-blue-700 px-4 py-2 rounded">
                    <i class="fas fa-users"></i> Pasien
                </a>
                <a href="/hospital-app/pages/obat/index.php" class="block hover:bg-blue-700 px-4 py-2 rounded">
                    <i class="fas fa-pills"></i> Obat
                </a>
                <a href="/hospital-app/pages/rekam_medis/index.php" class="block hover:bg-blue-700 px-4 py-2 rounded">
                    <i class="fas fa-file-medical"></i> Rekam Medis
                </a>
            </div>
        </div>
    </nav>

    <script>
        document.getElementById('menuBtn').addEventListener('click', function() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });
    </script>