-- Buat database
CREATE DATABASE IF NOT EXISTS rumahsakit_db;
USE rumahsakit_db;

-- Tabel Dokter
CREATE TABLE dokter (
    id_dokter INT PRIMARY KEY AUTO_INCREMENT,
    nama_dokter VARCHAR(100) NOT NULL,
    spesialisasi VARCHAR(100) NOT NULL,
    no_telp VARCHAR(15),
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Pasien
CREATE TABLE pasien (
    id_pasien INT PRIMARY KEY AUTO_INCREMENT,
    nama_pasien VARCHAR(100) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
    no_telp VARCHAR(15),
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Obat
CREATE TABLE obat (
    id_obat INT PRIMARY KEY AUTO_INCREMENT,
    nama_obat VARCHAR(100) NOT NULL,
    jenis_obat VARCHAR(50),
    stok INT NOT NULL DEFAULT 0,
    harga DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Rekam Medis (relasi antara dokter, pasien, dan obat)
CREATE TABLE rekam_medis (
    id_rekam INT PRIMARY KEY AUTO_INCREMENT,
    id_pasien INT NOT NULL,
    id_dokter INT NOT NULL,
    tanggal_periksa DATE NOT NULL,
    jenis_perawatan ENUM('Rawat Jalan', 'Rawat Inap') NOT NULL DEFAULT 'Rawat Jalan',
    tanggal_masuk DATE NULL,
    tanggal_keluar DATE NULL,
    lama_rawat INT DEFAULT 0,
    keluhan TEXT NOT NULL,
    diagnosa TEXT NOT NULL,
    tindakan TEXT,
    id_obat INT,
    jumlah_obat INT DEFAULT 0,
    biaya_konsultasi DECIMAL(10,2) DEFAULT 150000,
    biaya_rawat_inap DECIMAL(10,2) DEFAULT 0,
    biaya_obat DECIMAL(10,2) DEFAULT 0,
    biaya_total DECIMAL(10,2),
    status_pembayaran ENUM('Lunas', 'Belum Lunas') DEFAULT 'Belum Lunas',
    catatan_dokter TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pasien) REFERENCES pasien(id_pasien) ON DELETE CASCADE,
    FOREIGN KEY (id_dokter) REFERENCES dokter(id_dokter) ON DELETE CASCADE,
    FOREIGN KEY (id_obat) REFERENCES obat(id_obat) ON DELETE SET NULL
);

-- Insert data contoh
INSERT INTO dokter (nama_dokter, spesialisasi, no_telp, alamat) VALUES
('Dr. Ahmad Wijaya, Sp.PD', 'Penyakit Dalam', '081234567890', 'Jl. Merdeka No. 123'),
('Dr. Siti Nurhaliza, Sp.A', 'Anak', '081234567891', 'Jl. Sudirman No. 45'),
('Dr. Budi Santoso, Sp.OG', 'Kandungan', '081234567892', 'Jl. Gatot Subroto No. 78');

INSERT INTO pasien (nama_pasien, tanggal_lahir, jenis_kelamin, no_telp, alamat) VALUES
('Andi Pratama', '1990-05-15', 'Laki-laki', '082345678901', 'Jl. Anggrek No. 12'),
('Rina Wati', '1985-08-20', 'Perempuan', '082345678902', 'Jl. Melati No. 34'),
('Dedi Kurniawan', '2000-12-10', 'Laki-laki', '082345678903', 'Jl. Mawar No. 56');

INSERT INTO obat (nama_obat, jenis_obat, stok, harga) VALUES
('Paracetamol 500mg', 'Tablet', 100, 5000.00),
('Amoxicillin 500mg', 'Kapsul', 80, 15000.00),
('Vitamin C 1000mg', 'Tablet', 150, 8000.00),
('Antasida', 'Sirup', 50, 12000.00);

-- Data Rekam Medis yang Variatif
INSERT INTO rekam_medis (id_pasien, id_dokter, tanggal_periksa, jenis_perawatan, tanggal_masuk, tanggal_keluar, lama_rawat, keluhan, diagnosa, tindakan, id_obat, jumlah_obat, biaya_konsultasi, biaya_rawat_inap, biaya_obat, biaya_total, status_pembayaran, catatan_dokter) VALUES

-- Kasus 1: Rawat Jalan - Flu Biasa
(1, 1, '2024-11-15', 'Rawat Jalan', NULL, NULL, 0, 
'Demam tinggi 38°C, sakit kepala, badan terasa pegal-pegal, hidung tersumbat', 
'Influenza (Flu)', 
'Pemberian obat penurun panas, antihistamin, dan vitamin C', 
1, 10, 150000, 0, 50000, 200000.00, 'Lunas', 
'Istirahat yang cukup minimal 3 hari. Perbanyak minum air putih hangat. Hindari AC dan kipas angin. Konsumsi makanan bergizi. Kontrol kembali jika demam tidak turun dalam 3 hari.'),

-- Kasus 2: Rawat Inap - Pneumonia
(2, 2, '2024-11-16', 'Rawat Inap', '2024-11-16', '2024-11-20', 4, 
'Batuk berdahak disertai darah, sesak napas, demam tinggi mencapai 39°C, nyeri dada saat bernapas', 
'Pneumonia (Radang Paru-paru)', 
'Pemasangan infus (ringer laktat), terapi oksigen 3 liter/menit, pemberian antibiotik injeksi (Ceftriaxone 2x1gr IV), nebulizer, rontgen thorax', 
2, 15, 150000, 1200000, 225000, 1575000.00, 'Lunas', 
'Pasien menunjukkan perbaikan signifikan. Lanjutkan antibiotik oral selama 7 hari. Hindari asap rokok dan polusi. Kontrol poli paru 1 minggu lagi untuk evaluasi rontgen ulang.'),

-- Kasus 3: Rawat Jalan - Gastritis Akut
(3, 1, '2024-11-18', 'Rawat Jalan', NULL, NULL, 0, 
'Nyeri ulu hati seperti terbakar, mual muntah setelah makan, perut kembung, tidak nafsu makan', 
'Gastritis Akut (Maag Akut)', 
'Pemberian obat antasida, PPI (Proton Pump Inhibitor), dan antiemetik', 
4, 3, 150000, 0, 36000, 186000.00, 'Lunas', 
'Makan teratur 3x sehari dengan porsi kecil. Hindari makanan pedas, asam, dan berlemak. Kurangi kopi dan teh. Jangan telat makan. Makan 2 jam sebelum tidur.'),

-- Kasus 4: Rawat Inap - Demam Berdarah Dengue (DBD)
(1, 1, '2024-11-19', 'Rawat Inap', '2024-11-19', '2024-11-25', 6, 
'Demam tinggi mendadak 5 hari, sakit kepala hebat, nyeri otot dan sendi, muncul bintik merah di kulit, mimisan, gusi berdarah', 
'Dengue Hemorrhagic Fever (DHF) Grade II', 
'Pemasangan infus loading (RL 20 tetes/menit), monitoring tanda vital tiap 4 jam, pemeriksaan darah lengkap serial, transfusi trombosit 4 bag, bed rest total', 
3, 20, 150000, 1800000, 160000, 2110000.00, 'Lunas', 
'Trombosit sudah naik menjadi 165.000. Pasien boleh pulang dengan kondisi membaik. Perbanyak minum air putih, jus jambu, dan istirahat. Hindari aktivitas berat selama 2 minggu. Kontrol darah 1 minggu lagi.'),

-- Kasus 5: Rawat Jalan - Hipertensi
(2, 3, '2024-11-20', 'Rawat Jalan', NULL, NULL, 0, 
'Pusing berputar, tengkuk terasa tegang dan kaku, kadang pandangan kabur, TD: 170/100 mmHg', 
'Hipertensi Stage 2', 
'Pemberian obat antihipertensi (Amlodipine 10mg 1x1), edukasi diet rendah garam', 
NULL, 0, 150000, 0, 0, 150000.00, 'Lunas', 
'Konsumsi obat rutin setiap hari. Diet rendah garam maksimal 1 sendok teh/hari. Olahraga ringan teratur 30 menit/hari. Hindari stres berlebihan. Cek tekanan darah rutin setiap minggu. Kontrol 2 minggu lagi.'),

-- Kasus 6: Rawat Inap - Apendisitis Akut (Usus Buntu)
(3, 3, '2024-11-21', 'Rawat Inap', '2024-11-21', '2024-11-23', 2, 
'Nyeri perut kanan bawah sangat hebat sejak 12 jam yang lalu, mual muntah, demam, tidak bisa berjalan tegak', 
'Appendicitis Acute (Usus Buntu Akut)', 
'Operasi appendectomy (pengangkatan usus buntu) dengan teknik laparoskopi, pemasangan infus post operasi, pemberian antibiotik profilaksis, analgetik', 
2, 6, 150000, 600000, 90000, 840000.00, 'Belum Lunas', 
'Operasi berjalan lancar. Luka operasi harus dijaga tetap kering. Ganti verban 2 hari sekali. Hindari mengangkat beban berat selama 2 minggu. Boleh makan makanan lunak. Kontrol untuk buka jahitan 7 hari lagi.'),

-- Kasus 7: Rawat Jalan - Diabetes Mellitus
(1, 1, '2024-11-22', 'Rawat Jalan', NULL, NULL, 0, 
'Sering haus berlebihan, sering buang air kecil terutama malam hari, badan lemas, berat badan turun drastis, gula darah puasa: 245 mg/dL', 
'Diabetes Mellitus Tipe 2', 
'Pemberian obat antidiabetes oral (Metformin 500mg 3x1), edukasi diet diabetes, anjuran olahraga', 
3, 30, 150000, 0, 240000, 390000.00, 'Lunas', 
'Konsumsi obat teratur sebelum makan. Diet rendah gula dan karbohidrat. Olahraga teratur minimal 3x/minggu. Cek gula darah rutin. Jaga kebersihan kaki dan periksa luka sekecil apapun. Kontrol 1 bulan lagi dengan hasil lab gula darah puasa dan HbA1c.'),

-- Kasus 8: Rawat Inap - Stroke Iskemik
(2, 1, '2024-11-23', 'Rawat Inap', '2024-11-23', '2024-11-30', 7, 
'Mendadak tangan dan kaki kanan lemas tidak bisa digerakkan, bicara pelo, wajah mencong ke kiri, pusing berputar hebat', 
'Stroke Iskemik Hemisfer Kiri', 
'Pemasangan infus manitol untuk menurunkan tekanan intrakranial, pemberian antiplatelet, neuroprotektan, CT Scan kepala, fisioterapi pasif sejak hari ke-3', 
2, 21, 150000, 2100000, 315000, 2565000.00, 'Belum Lunas', 
'Kondisi pasien stabil. Kekuatan motorik mulai membaik dari 1/5 menjadi 3/5. Lanjutkan fisioterapi intensif. Kontrol faktor risiko (hipertensi, diabetes). Konsumsi obat antiplatelet seumur hidup. Kontrol rutin setiap 2 minggu.'),

-- Kasus 9: Rawat Jalan - ISPA (Infeksi Saluran Pernapasan Akut)
(3, 2, '2024-11-24', 'Rawat Jalan', NULL, NULL, 0, 
'Batuk kering terus-menerus, tenggorokan sakit dan gatal, demam ringan 37.5°C, pilek, bersin-bersin', 
'ISPA (Upper Respiratory Tract Infection)', 
'Pemberian antibiotik (Amoxicillin), obat batuk, dekongestan, dan vitamin', 
2, 9, 150000, 0, 135000, 285000.00, 'Lunas', 
'Minum obat teratur sampai habis. Perbanyak minum air hangat. Istirahat cukup. Gunakan masker jika keluar rumah. Hindari makanan dan minuman dingin. Jika dalam 3 hari tidak membaik segera kontrol kembali.'),

-- Kasus 10: Rawat Jalan - Migrain
(1, 1, '2024-11-25', 'Rawat Jalan', NULL, NULL, 0, 
'Sakit kepala sebelah kiri berdenyut-denyut sangat hebat, mual muntah, mata sensitif terhadap cahaya, telinga sensitif terhadap suara', 
'Migrain dengan Aura', 
'Pemberian analgetik kuat, antiemetik, dan obat profilaksis migrain', 
1, 5, 150000, 0, 25000, 175000.00, 'Lunas', 
'Hindari pemicu migrain (coklat, keju, MSG, cahaya terang, suara keras). Tidur teratur 7-8 jam. Kelola stres dengan baik. Minum air putih cukup. Catat diary migrain untuk mengetahui pola serangan. Konsumsi obat profilaksis rutin.'),

-- Kasus 11: Rawat Inap - Typhoid Fever (Tifus)
(2, 1, '2024-11-26', 'Rawat Inap', '2024-11-26', '2024-12-01', 5, 
'Demam tinggi naik turun terutama sore dan malam (39-40°C), sakit perut, mual, lidah kotor, lemas sekali', 
'Typhoid Fever (Demam Tifoid)', 
'Pemasangan infus (RL 20 tetes/menit), pemberian antibiotik injeksi (Ceftriaxone 1x2gr IV), antipiretik, vitamin, diet lunak rendah serat', 
2, 14, 150000, 1500000, 210000, 1860000.00, 'Lunas', 
'Demam sudah turun, kondisi membaik. Lanjutkan antibiotik oral 7 hari. Diet bertahap dari bubur → nasi lembek → nasi biasa. Hindari makanan berserat tinggi, pedas, dan asam selama 2 minggu. Istirahat total 2 minggu. Kontrol 1 minggu lagi.'),

-- Kasus 12: Rawat Jalan - Asam Urat (Gout)
(3, 1, '2024-11-27', 'Rawat Jalan', NULL, NULL, 0, 
'Nyeri hebat pada ibu jari kaki kanan, bengkak, kemerahan, panas saat disentuh, sulit berjalan, asam urat: 9.8 mg/dL', 
'Gout Arthritis (Artritis Gout Akut)', 
'Pemberian obat antiinflamasi (NSAID), allopurinol untuk menurunkan asam urat, edukasi diet rendah purin', 
1, 10, 150000, 0, 50000, 200000.00, 'Belum Lunas', 
'Hindari makanan tinggi purin (jeroan, seafood, daging merah, kacang-kacangan). Perbanyak minum air putih minimal 2 liter/hari. Hindari alkohol. Jaga berat badan ideal. Olahraga ringan teratur. Konsumsi obat penurun asam urat rutin seumur hidup. Kontrol asam urat 2 minggu lagi.'),

-- Kasus 13: Rawat Jalan - Alergi Kulit (Dermatitis)
(1, 2, '2024-11-28', 'Rawat Jalan', NULL, NULL, 0, 
'Gatal-gatal di seluruh badan terutama tangan dan kaki, kulit kemerahan, bentol-bentol, muncul setelah makan seafood', 
'Dermatitis Kontak Alergi / Urtikaria', 
'Pemberian antihistamin, kortikosteroid topikal (salep), edukasi menghindari alergen', 
NULL, 0, 150000, 0, 0, 150000.00, 'Lunas', 
'Hindari pemicu alergi (seafood, telur, kacang). Jangan menggaruk area yang gatal. Gunakan sabun dan lotion hypoallergenic. Kompres dingin jika gatal. Konsumsi antihistamin jika diperlukan. Jika muncul sesak napas segera ke IGD.'),

-- Kasus 14: Rawat Inap - Gagal Jantung
(2, 3, '2024-11-29', 'Rawat Inap', '2024-11-29', '2024-12-05', 6, 
'Sesak napas hebat tidak bisa tidur terlentang, kaki bengkak, cepat lelah, batuk-batuk terutama malam hari', 
'Congestive Heart Failure (CHF) NYHA Class III', 
'Pemasangan infus, pemberian diuretik (furosemide), ACE inhibitor, beta blocker, oksigen 2-3 liter/menit, monitoring ketat input output cairan, EKG, foto thorax, echocardiografi', 
NULL, 0, 150000, 1800000, 0, 1950000.00, 'Belum Lunas', 
'Kondisi pasien membaik, sesak berkurang, edema tungkai berkurang. Batasi asupan cairan maksimal 1.5 liter/hari. Diet rendah garam ketat. Timbang berat badan setiap hari. Hindari aktivitas berat. Konsumsi obat jantung seumur hidup. Kontrol rutin 1 minggu sekali.'),

-- Kasus 15: Rawat Jalan - Vertigo
(3, 1, '2024-11-30', 'Rawat Jalan', NULL, NULL, 0, 
'Pusing berputar-putar sangat hebat seperti dunia bergoyang, mual muntah, keringat dingin, telinga berdengung', 
'Benign Paroxysmal Positional Vertigo (BPPV)', 
'Pemberian obat antivertigo, antiemetik, manuver Epley untuk reposisi kanaliths', 
4, 3, 150000, 0, 36000, 186000.00, 'Lunas', 
'Hindari gerakan kepala mendadak. Bangkit dari tidur secara perlahan. Tidur dengan bantal tinggi. Hindari menengadah ke atas. Latihan Brandt-Daroff di rumah 2x sehari. Jika vertigo berulang atau bertambah parah segera kontrol.');