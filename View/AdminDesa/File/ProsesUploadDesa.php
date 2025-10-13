<?php
include '../../../Module/Config/Env.php';
session_start();

// Validasi input POST
if (!isset($_POST['upload']) || empty($_POST['kategori']) || empty($_POST['namafile']) || empty($_POST['iddesa'])) {
    header("Location: ../../v?pg=FileUploadDesa&alert=EmptyField");
    exit();
}

$kategori = isset($_POST['kategori']) ? sql_injeksi($_POST['kategori']) : '';   // idfilekategorifk
$nama = isset($_POST['namafile']) ? sql_injeksi($_POST['namafile']) : '';   // nama (user input)
$iddesa = isset($_POST['iddesa']) ? sql_injeksi($_POST['iddesa']) : '';     // iddesafk

// Validasi file upload
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    header("Location: ../../v?pg=FileUploadDesa&alert=FileError");
    exit();
}

$file = $_FILES['file'];

// Validate file type
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$allowed = ['pdf'];
if (!in_array(strtolower($ext), $allowed)) {
    header("Location: ../../v?pg=FileUploadDesa&alert=FileExt");
    exit();
}

// Validate file size
$maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
if ($file['size'] > $maxFileSize) {
    header("Location: ../../v?pg=FileUploadDesa&alert=FileMax");
    exit();
}

// Get desa name and kecamatan ID
$q = mysqli_query($db, "SELECT NamaDesa, IdKecamatanFK FROM master_desa WHERE IdDesa='$iddesa'");
if (!$q || mysqli_num_rows($q) == 0) {
    header("Location: ../../v?pg=FileUploadDesa&alert=DesaNotFound");
    exit();
}
$d = mysqli_fetch_assoc($q);
$idkecamatan = $d['IdKecamatanFK'];

// Read file contents
$tmpPath = $file['tmp_name'];
$binaryData = file_get_contents($tmpPath);
if ($binaryData === false) {
    header("Location: ../../v?pg=FileUploadDesa&alert=FileReadError");
    exit();
}
$binaryData = mysqli_real_escape_string($db, $binaryData);

$sql = "INSERT INTO file (Nama, Ekstensi, FileBlob, IdFileKategoriFK, IdDesaFK, IdLevelFileFK)
        VALUES ('$nama', '$ext', '$binaryData', '$kategori', '$iddesa', 3)";

if (mysqli_query($db, $sql)) {
    header("Location: ../../v?pg=FileViewDesa&alert=UploadSukses");
    exit();
} else {
    error_log("Database error in file upload: " . mysqli_error($db));
    header("Location: ../../v?pg=FileUploadDesa&alert=DatabaseError");
    exit();
}
?>