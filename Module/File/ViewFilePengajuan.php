<?php
include "../Config/Env.php";

if (!isset($_GET['id'])) {
    die("File ID missing.");
}

$id = intval($_GET['id']);

$q = mysqli_query($db, "SELECT Nama, FileBlob FROM file WHERE IdFile = '$id' LIMIT 1");

if (!$q || mysqli_num_rows($q) === 0) {
    die("File not found.");
}

$file = mysqli_fetch_assoc($q);

// Proper headers to view PDF inline
header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename=\"" . $file['Nama'] . "\"");
header("Content-Length: " . strlen($file['FileBlob']));

// Output the file
echo $file['FileBlob'];
exit;
