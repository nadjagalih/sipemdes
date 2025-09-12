<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../Config/Env.php";

$Id = $_GET['id'];
$query = mysqli_query($db, "SELECT FileSKMutasiBlob, FileSKMutasi FROM history_mutasi WHERE IdMutasi = '$Id'");
$data = mysqli_fetch_assoc($query);

$filedata = $data['FileSKMutasiBlob'];
$filename = $data['FileSKMutasi'];

$finfo = finfo_open();
$mime = finfo_buffer($finfo, $filedata, FILEINFO_MIME_TYPE);
finfo_close($finfo);

// Force download with correct headers
header("Content-Type: $mime");
header("Content-Disposition: inline; filename=\"" . basename($filename) . "\"");
header("Content-Length: " . strlen($filedata));
echo $filedata;
exit();
