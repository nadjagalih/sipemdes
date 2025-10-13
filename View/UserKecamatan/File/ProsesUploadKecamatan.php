<?php
include '../../../Module/Config/Env.php'; // adjust as needed

// Input validation and sanitization
$kategori = isset($_POST['kategori']) ? sql_injeksi($_POST['kategori']) : '';
$nama = isset($_POST['namafile']) ? sql_injeksi($_POST['namafile']) : '';
$iddesa = isset($_POST['iddesa']) ? sql_injeksi($_POST['iddesa']) : '';
$idkecamatan = isset($_POST['idkecamatan']) ? sql_injeksi($_POST['idkecamatan']) : '';

// Validate required fields
if (empty($kategori) || empty($nama) || empty($idkecamatan)) {
    header("Location: ../../v?pg=FileViewKecamatan&alert=MissingFields");
    exit();
}

// Check if file is uploaded
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    header("Location: ../../v?pg=FileViewKecamatan&alert=UploadError");
    exit();
}

$file = $_FILES['file'];

// Get desa name and kecamatan id
$q = mysqli_query($db, "SELECT NamaDesa FROM master_desa WHERE IdDesa='$iddesa'");
$d = mysqli_fetch_assoc($q);
$desaName = $d ? preg_replace('/\s+/', '', $d['NamaDesa']) : '';

// Validate file size first (5MB max)
$maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
if ($file['size'] > $maxFileSize) {
    header("Location: ../../v?pg=FileViewKecamatan&alert=FileMax");
    exit();
}

// Validate file type and MIME type for security
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$allowed = ['pdf'];
$allowedMimes = ['application/pdf'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($ext, $allowed) || !in_array($mimeType, $allowedMimes)) {
    header("Location: ../../v?pg=FileViewKecamatan&alert=FileExt");
    exit();
}

// Read and escape file contents
$tmpPath = $file['tmp_name'];
$binaryData = file_get_contents($tmpPath);
if ($binaryData === false) {
    header("Location: ../../v?pg=FileViewKecamatan&alert=FileReadError");
    exit();
}
$binaryData = mysqli_real_escape_string($db, $binaryData);

// Prepare SQL query based on whether iddesa is provided
if (empty($iddesa)) {
    $sql = "INSERT INTO file (Nama, Ekstensi, FileBlob, IdFileKategoriFK, IdKecamatanFK, IdLevelFileFK)
            VALUES ('$nama', '$ext', '$binaryData', '$kategori', '$idkecamatan', 2)";
} else {
    $sql = "INSERT INTO file (Nama, Ekstensi, FileBlob, IdFileKategoriFK, IdDesaFK, IdLevelFileFK)
            VALUES ('$nama', '$ext', '$binaryData', '$kategori', '$iddesa', 3)";
}

// Execute query
if (mysqli_query($db, $sql)) {
    header("Location: ../../v?pg=FileViewKecamatan&alert=UploadSukses");
    exit();
} else {
    error_log("Database error in ProsesUploadKecamatan.php: " . mysqli_error($db));
    header("Location: ../../v?pg=FileViewKecamatan&alert=DatabaseError");
    exit();
}

?>