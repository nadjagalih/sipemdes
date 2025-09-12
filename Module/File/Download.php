<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../Config/Env.php';

if (!isset($_GET['id'])) {
    die("Missing file ID.");
}

$id = intval($_GET['id']);
$q = mysqli_query($db, "SELECT nama, ekstensi, fileblob FROM file WHERE idfile = $id");

if (!$q || mysqli_num_rows($q) === 0) {
    die("File not found.");
}

$row = mysqli_fetch_assoc($q);

// Set proper headers
header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . $row['nama'] . '.' . $row['ekstensi'] . "\"");
header("Content-Transfer-Encoding: binary");
header("Expires: 0");
header("Cache-Control: must-revalidate");
header("Pragma: public");

echo $row['filedata'];
exit;
?>
