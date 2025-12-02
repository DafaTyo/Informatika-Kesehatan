<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RS Sehat Sejahtera - Sistem Informasi Rumah Sakit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 1s ease-out;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .hero-pattern {
            background-color: #667eea;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Navbar -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-600 p-2 rounded-lg">
                        <i class="fas fa-hospital text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">RS Sehat Sejahtera</h1>
                        <p class="text-xs text-gray-600">Healthcare Management System</p>
                    </div>
                </div>
                <div class="hidden md:flex space-x-6">
                    <a href="#home" class="text-gray-700 hover:text-blue-600 transition">Home</a>
                    <a href="#features" class="text-gray-700 hover:text-blue-600 transition">Fitur</a>
                    <a href="#about" class="text-gray-700 hover:text-blue-600 transition">Tentang</a>
                    <a href="#contact" class="text-gray-700 hover:text-blue-600 transition">Kontak</a>
                </div>
                <a href="pages/dashboard.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition font-semibold">
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk Sistem
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-pattern pt-32 pb-20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="text-white animate-fadeInUp">
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                        Sistem Informasi Rumah Sakit Modern
                    </h1>
                    <p class="text-xl mb-8 text-blue-100">
                        Kelola data pasien, dokter, obat, dan rekam medis dengan mudah dan efisien dalam satu platform terintegrasi.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="index.php" class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg font-bold text-lg transition shadow-lg">
                            <i class="fas fa-rocket mr-2"></i>Mulai Sekarang
                        </a>
                        <a href="#features" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-4 rounded-lg font-bold text-lg transition">
                            <i class="fas fa-info-circle mr-2"></i>Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="hidden md:block animate-float">
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4 bg-blue-50 p-4 rounded-lg">
                                <div class="bg-blue-600 p-3 rounded-full">
                                    <i class="fas fa-user-md text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">Manajemen Dokter</h3>
                                    <p class="text-sm text-gray-600">Kelola data dokter & spesialisasi</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4 bg-green-50 p-4 rounded-lg">
                                <div class="bg-green-600 p-3 rounded-full">
                                    <i class="fas fa-users text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">Data Pasien</h3>
                                    <p class="text-sm text-gray-600">Database pasien terintegrasi</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4 bg-purple-50 p-4 rounded-lg">
                                <div class="bg-purple-600 p-3 rounded-full">
                                    <i class="fas fa-pills text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">Inventori Obat</h3>
                                    <p class="text-sm text-gray-600">Manajemen stok & harga obat</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4 bg-red-50 p-4 rounded-lg">
                                <div class="bg-red-600 p-3 rounded-full">
                                    <i class="fas fa-file-medical text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">Rekam Medis</h3>
                                    <p class="text-sm text-gray-600">Rekam medis elektronik lengkap</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Fitur Unggulan</h2>
                <p class="text-xl text-gray-600">Solusi lengkap untuk manajemen rumah sakit Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="bg-blue-600 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-user-md text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Manajemen Dokter</h3>
                    <p class="text-gray-600">Kelola data dokter, spesialisasi, dan jadwal praktik dengan mudah</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="bg-green-600 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Database Pasien</h3>
                    <p class="text-gray-600">Simpan dan akses data pasien dengan cepat dan aman</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="bg-purple-600 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-pills text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Inventori Obat</h3>
                    <p class="text-gray-600">Pantau stok obat dan harga secara real-time</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="bg-red-600 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-file-medical text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Rekam Medis</h3>
                    <p class="text-gray-600">Rekam medis elektronik terintegrasi dengan billing otomatis</p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-xl hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="bg-yellow-600 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Dashboard Real-time</h3>
                    <p class="text-gray-600">Statistik dan laporan visual yang mudah dipahami</p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-xl hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="bg-indigo-600 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Responsive Design</h3>
                    <p class="text-gray-600">Akses dari desktop, tablet, atau smartphone</p>
                </div>

                <!-- Feature 7 -->
                <div class="bg-gradient-to-br from-pink-50 to-pink-100 p-6 rounded-xl hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="bg-pink-600 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Keamanan Data</h3>
                    <p class="text-gray-600">Sistem keamanan berlapis untuk melindungi data sensitif</p>
                </div>

                <!-- Feature 8 -->
                <div class="bg-gradient-to-br from-teal-50 to-teal-100 p-6 rounded-xl hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="bg-teal-600 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-cog text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Mudah Digunakan</h3>
                    <p class="text-gray-600">Interface intuitif yang mudah dipelajari</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">Tentang Sistem</h2>
                    <p class="text-lg text-gray-600 mb-4">
                        RS Sehat Sejahtera Management System adalah solusi digital komprehensif untuk manajemen rumah sakit modern. Dikembangkan dengan teknologi web terkini untuk memberikan pengalaman terbaik.
                    </p>
                    <p class="text-lg text-gray-600 mb-6">
                        Sistem ini dirancang untuk mempermudah administrasi rumah sakit, meningkatkan efisiensi pelayanan, dan memberikan data akurat untuk pengambilan keputusan.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            <span class="text-gray-700">Database relasional MySQL</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            <span class="text-gray-700">Interface modern dengan Tailwind CSS</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            <span class="text-gray-700">PHP backend yang robust</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            <span class="text-gray-700">CRUD lengkap untuk semua modul</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                        <i class="fas fa-database text-4xl text-blue-600 mb-3"></i>
                        <h3 class="text-3xl font-bold text-gray-800 mb-1">4</h3>
                        <p class="text-gray-600">Tabel Database</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                        <i class="fas fa-th-large text-4xl text-green-600 mb-3"></i>
                        <h3 class="text-3xl font-bold text-gray-800 mb-1">16</h3>
                        <p class="text-gray-600">Modul CRUD</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                        <i class="fas fa-code text-4xl text-purple-600 mb-3"></i>
                        <h3 class="text-3xl font-bold text-gray-800 mb-1">PHP</h3>
                        <p class="text-gray-600">Backend</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                        <i class="fas fa-paint-brush text-4xl text-red-600 mb-3"></i>
                        <h3 class="text-3xl font-bold text-gray-800 mb-1">Tailwind</h3>
                        <p class="text-gray-600">CSS Framework</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Hubungi Kami</h2>
                <p class="text-xl text-gray-600">Ada pertanyaan? Kami siap membantu Anda</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="text-center p-6 bg-blue-50 rounded-xl">
                    <div class="bg-blue-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Telepon</h3>
                    <p class="text-gray-600">(021) 1234-5678</p>
                </div>
                
                <div class="text-center p-6 bg-green-50 rounded-xl">
                    <div class="bg-green-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Email</h3>
                    <p class="text-gray-600">info@rssehatsejahtera.com</p>
                </div>
                
                <div class="text-center p-6 bg-purple-50 rounded-xl">
                    <div class="bg-purple-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Alamat</h3>
                    <p class="text-gray-600">Jl. Kesehatan No. 123, Jakarta</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="gradient-bg py-20">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Siap Meningkatkan Efisiensi Rumah Sakit Anda?
            </h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan sistem manajemen rumah sakit modern dan tingkatkan kualitas pelayanan Anda
            </p>
            
            <a href="index.php" class="bg-white text-blue-600 hover:bg-gray-100 px-10 py-4 rounded-lg font-bold text-xl transition shadow-xl inline-block">
                <i class="fas fa-rocket mr-2"></i>Mulai Sekarang - Gratis!
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-hospital text-2xl text-blue-500"></i>
                        <span class="text-xl font-bold">RS Sehat Sejahtera</span>
                    </div>
                    <p class="text-gray-400">Sistem Informasi Manajemen Rumah Sakit Modern & Terpadu</p>
                </div>
                
                <div>
                    <h3 class="font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="#features" class="text-gray-400 hover:text-white transition">Fitur</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition">Tentang</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition">Kontak</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-bold mb-4">Modul</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-white transition">Dashboard</a></li>
                        <li><a href="pages/dokter/index.php" class="text-gray-400 hover:text-white transition">Data Dokter</a></li>
                        <li><a href="pages/pasien/index.php" class="text-gray-400 hover:text-white transition">Data Pasien</a></li>
                        <li><a href="pages/obat/index.php" class="text-gray-400 hover:text-white transition">Data Obat</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-bold mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-gray-800 hover:bg-blue-600 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-gray-800 hover:bg-blue-400 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="bg-gray-800 hover:bg-pink-600 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="bg-gray-800 hover:bg-red-600 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <hr class="border-gray-800 my-8">
            
            <div class="text-center text-gray-400">
                <p>&copy; 2024 RS Sehat Sejahtera. All Rights Reserved. Made with <i class="fas fa-heart text-red-500"></i> in Indonesia</p>
            </div>
        </div>
    </footer>

    <!-- Smooth Scroll Script -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if(target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>