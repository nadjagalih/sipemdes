<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../Config/Env.php";

$Id = mysqli_real_escape_string($db, $_GET['id']);
$query = mysqli_query($db, "SELECT FileSKMutasiBlob, FileSKMutasi FROM history_mutasi WHERE IdMutasi = '$Id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("File tidak ditemukan");
}

$filename = $data['FileSKMutasi'];
$fileBlob = $data['FileSKMutasiBlob'];

// Coba baca dari file fisik terlebih dahulu
$physicalFilePath = "../../Vendor/Media/FileSK/" . $filename;
if (file_exists($physicalFilePath)) {
    // Baca dari file fisik
    $filedata = file_get_contents($physicalFilePath);
    $mime = mime_content_type($physicalFilePath);
} elseif (!empty($fileBlob)) {
    // Fallback ke BLOB jika file fisik tidak ada
    $filedata = $fileBlob;
    $finfo = finfo_open();
    $mime = finfo_buffer($finfo, $filedata, FILEINFO_MIME_TYPE);
    finfo_close($finfo);
} else {
    die("File tidak tersedia");
}

// Force download with correct headers
header("Content-Type: $mime");
header("Content-Disposition: inline; filename=\"" . basename($filename) . "\"");
header("Content-Length: " . strlen($filedata));
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
echo $filedata;
exit();
