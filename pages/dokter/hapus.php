<?php
require_once '../../config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($id > 0) {
    $query = "DELETE FROM dokter WHERE id_dokter = $id";
    
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