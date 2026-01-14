<?php
// Proses upload dijalankan saat form disubmit
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $targetDir = "uploads/";

    // Buat folder jika belum ada
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileTmp  = $_FILES["file"]["tmp_name"];
    $fileSize = $_FILES["file"]["size"];
    $fileExt  = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));

    // Ekstensi yang diizinkan
    $allowedExt = ["jpg", "jpeg", "png", "pdf"];

    // Validasi
    if (!in_array($fileExt, $allowedExt)) {
        $message = "❌ Format file tidak diizinkan!";
    } elseif ($fileSize > 2 * 1024 * 1024) {
        $message = "❌ Ukuran file maksimal 2MB!";
    } else {
        // Rename file agar aman
        $newFileName = uniqid() . "." . $fileExt;
        $targetFile = $targetDir . $newFileName;

        if (move_uploaded_file($fileTmp, $targetFile)) {
            $message = "✅ File berhasil diupload!";
        } else {
            $message = "❌ Upload gagal!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
</head>
<body>

<h2>Upload File</h2>

<?php if ($message != ""): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="file" required>
    <br><br>
    <button type="submit">Upload</button>
</form>

</body>
</html>
