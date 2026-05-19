<?php
$target_dir = "uploads/";
// create uploads folder if not exists
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file is selected
if(empty($_FILES["fileToUpload"]["name"])) {
    header("Location: index.php?err=" . urlencode("Pilih file terlebih dahulu."));
    exit;
}

// Check if file already exists
if (file_exists($target_file)) {
    header("Location: index.php?err=" . urlencode("Maaf, berkas sudah ada."));
    exit;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) { // 5MB limit
    header("Location: index.php?err=" . urlencode("Maaf, berkas Anda terlalu besar."));
    exit;
}

// if everything is ok, try to upload file
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    header("Location: index.php?msg=" . urlencode("Berkas ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " telah diunggah."));
    exit;
} else {
    header("Location: index.php?err=" . urlencode("Maaf, terjadi kesalahan saat mengunggah berkas Anda."));
    exit;
}
?>