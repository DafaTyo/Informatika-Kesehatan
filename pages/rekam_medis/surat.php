<?php
require_once '../../config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT rm.*, 
          p.nama_pasien, p.tanggal_lahir, p.jenis_kelamin, p.alamat as alamat_pasien,
          d.nama_dokter, d.spesialisasi
          FROM rekam_medis rm
          LEFT JOIN pasien p ON rm.id_pasien = p.id_pasien
          LEFT JOIN dokter d ON rm.id_dokter = d.id_dokter
          WHERE rm.id_rekam = $id";
$result = $conn->query($query);
$data = $result->fetch_assoc();

if(!$data) {
    die("Data tidak ditemukan");
}

$umur = date_diff(date_create($data['tanggal_lahir']), date_create('today'))->y;
$no_surat = 'SKD/' . date('Y') . '/' . str_pad($id, 5, '0', STR_PAD_LEFT);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Dokter - <?= htmlspecialchars($data['nama_pasien']) ?></title>
    <style>
        @media print {
            .no-print { display: none; }
            @page { margin: 2cm; }
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
            color: #333;
            max-width: 21cm;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2563eb;
        }
        
        .header h2 {
            margin: 5px 0;
            font-size: 18px;
            font-weight: normal;
        }
        
        .header p {
            margin: 3px 0;
            font-size: 12px;
        }
        
        .kop-logo {
            width: 80px;
            height: 80px;
            background: #2563eb;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin: 0 auto 10px;
        }
        
        .title {
            text-align: center;
            margin: 30px 0;
        }
        
        .title h3 {
            margin: 0;
            font-size: 18px;
            text-decoration: underline;
        }
        
        .nomor {
            text-align: center;
            font-size: 14px;
            margin-bottom: 30px;
        }
        
        .content {
            text-align: justify;
            font-size: 14px;
            margin: 20px 0;
        }
        
        .data-pasien {
            margin: 20px 0 20px 40px;
        }
        
        .data-pasien table {
            width: 100%;
            max-width: 500px;
        }
        
        .data-pasien td {
            padding: 5px 0;
        }
        
        .data-pasien td:first-child {
            width: 150px;
        }
        
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        
        .signature-box {
            display: inline-block;
            min-width: 200px;
        }
        
        .signature-line {
            margin-top: 80px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        
        .stamp {
            width: 150px;
            height: 150px;
            border: 2px solid #2563eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: absolute;
            right: 100px;
            margin-top: 20px;
            transform: rotate(-15deg);
            opacity: 0.5;
            font-size: 12px;
            color: #2563eb;
            font-weight: bold;
        }
        
        .footer-note {
            margin-top: 30px;
            font-size: 12px;
            font-style: italic;
            color: #666;
        }
        
        .diagnosa-box {
            background: #f3f4f6;
            padding: 15px;
            border-left: 4px solid #2563eb;
            margin: 20px 0;
        }
        
        .button-print {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2563eb;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        
        .button-print:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="button-print no-print">
        🖨️ Cetak Surat
    </button>

    <!-- KOP SURAT -->
    <div class="header">
        <h1>RUMAH SAKIT SEHAT SEJAHTERA</h1>
        <h2>Healthcare Management System</h2>
        <p>Jl. Kesehatan No. 123, Jakarta Pusat 10110</p>
        <p>Telp: (021) 1234-5678 | Email: info@rssehatsejahtera.com</p>
    </div>

    <!-- JUDUL SURAT -->
    <div class="title">
        <h3>SURAT KETERANGAN DOKTER</h3>
    </div>
    
    <div class="nomor">
        Nomor: <?= $no_surat ?>
    </div>

    <!-- ISI SURAT -->
    <div class="content">
        <p>Yang bertanda tangan di bawah ini:</p>
        
        <div class="data-pasien">
            <table>
                <tr>
                    <td>Nama Dokter</td>
                    <td>: <?= htmlspecialchars($data['nama_dokter']) ?></td>
                </tr>
                <tr>
                    <td>Spesialisasi</td>
                    <td>: <?= htmlspecialchars($data['spesialisasi']) ?></td>
                </tr>
            </table>
        </div>
        
        <p>Dengan ini menerangkan bahwa:</p>
        
        <div class="data-pasien">
            <table>
                <tr>
                    <td>Nama Pasien</td>
                    <td>: <strong><?= htmlspecialchars($data['nama_pasien']) ?></strong></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>: <?= $data['jenis_kelamin'] ?></td>
                </tr>
                <tr>
                    <td>Tanggal Lahir / Umur</td>
                    <td>: <?= date('d F Y', strtotime($data['tanggal_lahir'])) ?> / <?= $umur ?> tahun</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: <?= htmlspecialchars($data['alamat_pasien']) ?></td>
                </tr>
            </table>
        </div>
        
        <p>Telah diperiksa pada tanggal <strong><?= date('d F Y', strtotime($data['tanggal_periksa'])) ?></strong> dengan hasil pemeriksaan sebagai berikut:</p>
        
        <div class="diagnosa-box">
            <p><strong>Keluhan:</strong><br>
            <?= nl2br(htmlspecialchars($data['keluhan'])) ?></p>
            
            <p style="margin-top: 10px;"><strong>Diagnosa:</strong><br>
            <?= nl2br(htmlspecialchars($data['diagnosa'])) ?></p>
            
            <?php if($data['tindakan']): ?>
            <p style="margin-top: 10px;"><strong>Tindakan:</strong><br>
            <?= nl2br(htmlspecialchars($data['tindakan'])) ?></p>
            <?php endif; ?>
        </div>
        
        <?php if($data['jenis_perawatan'] == 'Rawat Inap'): ?>
        <p>Pasien menjalani <strong>RAWAT INAP</strong> dari tanggal <strong><?= date('d F Y', strtotime($data['tanggal_masuk'])) ?></strong> 
        <?php if($data['tanggal_keluar']): ?>
        sampai tanggal <strong><?= date('d F Y', strtotime($data['tanggal_keluar'])) ?></strong> 
        (<?= $data['lama_rawat'] ?> hari).
        <?php else: ?>
        dan masih dalam perawatan.
        <?php endif; ?>
        </p>
        <?php else: ?>
        <p>Pasien menjalani <strong>RAWAT JALAN</strong>.</p>
        <?php endif; ?>
        
        <?php if($data['catatan_dokter']): ?>
        <p><strong>Catatan:</strong><br>
        <?= nl2br(htmlspecialchars($data['catatan_dokter'])) ?></p>
        <?php endif; ?>
        
        <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- FOOTER NOTE -->
    <div class="footer-note">
        * Surat ini dibuat secara elektronik dan sah tanpa tanda tangan basah
    </div>

    <!-- TTD -->
    <div class="signature">
        <div class="signature-box">
            <p style="margin: 0;">Jakarta, <?= date('d F Y') ?></p>
            <p style="margin: 5px 0 0 0;">Dokter Pemeriksa,</p>
            
            <div style="position: relative;">
                <div class="stamp no-print">
                    RS SEHAT<br>SEJAHTERA
                </div>
                
                <div class="signature-line">
                    <strong><?= htmlspecialchars($data['nama_dokter']) ?></strong><br>
                    <?= htmlspecialchars($data['spesialisasi']) ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto print ketika halaman dimuat (opsional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>