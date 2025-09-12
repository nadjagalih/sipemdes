<?php
include '../../../Module/Config/Env.php';

$kategori = $_POST['kategori'];   // idfilekategorifk
$nama = $_POST['namafile'];   // nama (user input)
$iddesa = $_POST['iddesa'];     // iddesafk
$file = $_FILES['file'];

// Get desa name and kecamatan ID
$q = mysqli_query($db, "SELECT NamaDesa, IdKecamatanFK FROM master_desa WHERE IdDesa='$iddesa'");
$d = mysqli_fetch_assoc($q);
$idkecamatan = $d['IdKecamatanFK'];

// Validate file type
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$allowed = ['pdf'];
if (!in_array(strtolower($ext), $allowed)) {
    header("Location: ../../v?pg=FileViewDesa&alert=FileExt");
}

// Read file contents
$tmpPath = $file['tmp_name'];
$binaryData = file_get_contents($tmpPath);
$binaryData = mysqli_real_escape_string($db, $binaryData);

$sql = "INSERT INTO file (Nama, Ekstensi, FileBlob, IdFileKategoriFK, IdDesaFK, IdLevelFileFK)
        VALUES ('$nama', '$ext', '$binaryData', '$kategori', '$iddesa', 3)";

$maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
if ($file['size'] <= $maxFileSize) {
    if (mysqli_query($db, $sql)) {
        header("Location: ../../v?pg=FileViewDesa&alert=UploadSukses");
        exit();
    } else {
        echo "Database error: " . mysqli_error($db);
    }
} else {
    header("Location: ../../v?pg=FileViewDesa&alert=FileMax");
}
?>