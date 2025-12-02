<?php
require_once '../../config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($id > 0) {
    // Ambil data rekam medis untuk kembalikan stok obat
    $rekam = $conn->query("SELECT id_obat, jumlah_obat FROM rekam_medis WHERE id_rekam = $id")->fetch_assoc();
    
    // Kembalikan stok obat jika ada
    if($rekam && $rekam['id_obat'] && $rekam['jumlah_obat'] > 0) {
        $conn->query("UPDATE obat SET stok = stok + {$rekam['jumlah_obat']} WHERE id_obat = {$rekam['id_obat']}");
    }
    
    // Hapus rekam medis
    $query = "DELETE FROM rekam_medis WHERE id_rekam = $id";
    
    if($conn->query($query)) {
        header("Location: index.php?msg=deleted");
    } else {
        header("Location: index.php?msg=error");
    }
} else {
    header("Location: index.php");
}

exit();
?>