<?php
// index.php
$target_dir = "uploads/";
$uploaded_files = array_diff(scandir($target_dir), array('..', '.'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Upload Project</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: auto; }
        .upload-section, .file-list { border: 1px solid #ccc; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .preview-img { max-width: 200px; max-height: 200px; margin-top: 10px; display: none; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        .btn { padding: 5px 10px; text-decoration: none; color: white; border-radius: 4px; cursor: pointer; border: none; }
        .btn-download { background-color: #28a745; }
        .btn-delete { background-color: #dc3545; }
        .thumbnail { max-width: 100px; max-height: 100px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Project Web Upload</h2>

    <!-- Upload Section -->
    <div class="upload-section">
        <h3>Form Unggah File</h3>
        <?php
        if (isset($_GET['msg'])) {
            echo "<p style='color: green;'>".htmlspecialchars($_GET['msg'])."</p>";
        }
        if (isset($_GET['err'])) {
            echo "<p style='color: red;'>".htmlspecialchars($_GET['err'])."</p>";
        }
        ?>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="fileToUpload">Pilih file untuk diunggah:</label><br><br>
            <input type="file" name="fileToUpload" id="fileToUpload" onchange="previewFile()"><br>
            <img id="preview" class="preview-img" alt="Preview Gambar" />
            <br><br>
            <input type="submit" value="Unggah File" name="submit" class="btn" style="background-color: #007bff;">
        </form>
    </div>

    <!-- Uploaded Files Section -->
    <div class="file-list">
        <h3>Daftar File yang Diunggah</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama File</th>
                    <th>Preview</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($uploaded_files) > 0): ?>
                    <?php $i = 1; foreach ($uploaded_files as $file): ?>
                        <?php 
                            $filePath = $target_dir . htmlspecialchars($file); 
                            $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
                        ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($file); ?></td>
                            <td>
                                <?php if ($isImage): ?>
                                    <img src="<?= $filePath ?>" class="thumbnail" alt="<?= htmlspecialchars($file) ?>">
                                <?php else: ?>
                                    File <?= strtoupper($ext) ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= $filePath ?>" download class="btn btn-download">Unduh</a>
                                <form action="delete.php" method="post" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?');">
                                    <input type="hidden" name="fileToDelete" value="<?= htmlspecialchars($file) ?>">
                                    <button type="submit" class="btn btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Belum ada file yang diunggah.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function previewFile() {
        const preview = document.getElementById('preview');
        const file = document.getElementById('fileToUpload').files[0];
        const reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.src = reader.result;
            preview.style.display = 'block';
        }, false);

        if (file) {
            // Check if file is image
            if(file.type.startsWith('image/')){
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                preview.src = "";
            }
        }
    }
</script>

</body>
</html>
