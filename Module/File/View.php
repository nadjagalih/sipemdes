<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../Config/Env.php';

if (!isset($_GET['id'])) {
    die("Missing file ID.");
}

$id = intval($_GET['id']);
$q = mysqli_query($db, "SELECT Nama, Ekstensi, FileBlob FROM file WHERE IdFile = $id");

if (!$q || mysqli_num_rows($q) === 0) {
    die("File not found.");
}

$row = mysqli_fetch_assoc($q);
$filename = $row['Nama'] . '.' . $row['Ekstensi'];
$extension = strtolower($row['Ekstensi']);

// Set headers untuk preview/view file tanpa download
if ($extension === 'pdf') {
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=\"" . $filename . "\"");
} elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
    header("Content-Type: image/" . $extension);
    header("Content-Disposition: inline; filename=\"" . $filename . "\"");
} elseif (in_array($extension, ['txt', 'html', 'htm'])) {
    header("Content-Type: text/plain");
    header("Content-Disposition: inline; filename=\"" . $filename . "\"");
} else {
    // For other file types, still show inline but with generic content type
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: inline; filename=\"" . $filename . "\"");
}

header("Cache-Control: public");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + 3600) . " GMT");

// Output file content
echo $row['FileBlob'];
exit;
?>