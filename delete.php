<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fileToDelete'])) {
    $fileToDelete = basename($_POST['fileToDelete']); // prevent directory traversal
    $target_dir = "uploads/";
    $filePath = $target_dir . $fileToDelete;

    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            header("Location: index.php?msg=" . urlencode("Berkas berhasil dihapus."));
        } else {
            header("Location: index.php?err=" . urlencode("Gagal menghapus berkas."));
        }
    } else {
        header("Location: index.php?err=" . urlencode("Berkas tidak ditemukan."));
    }
} else {
    header("Location: index.php");
}
exit;
?>
