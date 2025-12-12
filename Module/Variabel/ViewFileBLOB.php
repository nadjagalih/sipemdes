<?php
session_start();
include "../Config/Env.php";

// Validasi session
if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    http_response_code(403);
    echo "<h1>Access Denied</h1><p>Silakan login terlebih dahulu.</p>";
    exit();
}

// Validasi parameter
if (!isset($_GET['File']) || empty($_GET['File'])) {
    http_response_code(400);
    echo "<h1>Bad Request</h1><p>Parameter file tidak ditemukan.</p>";
    exit();
}

$fileName = $_GET['File'];

// Debug info
error_log("ViewFileBLOB - Requested file: " . $fileName);

// Query untuk mendapatkan file dari BLOB
$query = "SELECT FileSKMutasi, FileSKMutasiBlob FROM history_mutasi WHERE FileSKMutasi = ?";
$stmt = mysqli_prepare($db, $query);

if (!$stmt) {
    error_log("ViewFileBLOB - Prepare failed: " . mysqli_error($db));
    http_response_code(500);
    echo "<h1>Database Error</h1><p>Gagal mempersiapkan query.</p>";
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $fileName);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    error_log("ViewFileBLOB - File not found in database: " . $fileName);
    http_response_code(404);
    echo "<h1>File Not Found</h1>";
    echo "<p>File <strong>" . htmlspecialchars($fileName) . "</strong> tidak ditemukan di database.</p>";
    echo "<p><a href='javascript:history.back()'>Kembali</a></p>";
    exit();
}

$row = mysqli_fetch_assoc($result);
$fileContent = $row['FileSKMutasiBlob'];

mysqli_stmt_close($stmt);

// Validasi content
if (empty($fileContent)) {
    error_log("ViewFileBLOB - Empty file content for: " . $fileName);
    http_response_code(404);
    echo "<h1>File Content Empty</h1>";
    echo "<p>Konten file <strong>" . htmlspecialchars($fileName) . "</strong> kosong.</p>";
    echo "<p><a href='javascript:history.back()'>Kembali</a></p>";
    exit();
}

// Get file extension
$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

// Set content type based on file extension
switch ($fileExt) {
    case 'pdf':
        $contentType = 'application/pdf';
        break;
    case 'jpg':
    case 'jpeg':
        $contentType = 'image/jpeg';
        break;
    case 'png':
        $contentType = 'image/png';
        break;
    case 'gif':
        $contentType = 'image/gif';
        break;
    case 'doc':
        $contentType = 'application/msword';
        break;
    case 'docx':
        $contentType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        break;
    default:
        $contentType = 'application/octet-stream';
}

// Security check - prevent access to dangerous files
$dangerousExtensions = ['php', 'py', 'exe', 'bat', 'cmd', 'sh'];
if (in_array($fileExt, $dangerousExtensions)) {
    http_response_code(403);
    echo "<h1>Access Forbidden</h1><p>Tipe file ini tidak diizinkan untuk diakses.</p>";
    exit();
}

// Clear any previous output
if (ob_get_level()) {
    ob_end_clean();
}

// Set headers for file display
header('Content-Type: ' . $contentType);
header('Content-Length: ' . strlen($fileContent));
header('Content-Disposition: inline; filename="' . basename($fileName) . '"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

// Output file content from BLOB
echo $fileContent;
exit();
?>
