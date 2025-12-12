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

// Path dan filename
$fileName = basename($_GET['File']); // Sanitize filename
$filePath = __DIR__ . "/../../Vendor/Media/FileSK/" . $fileName;

// Debug info
error_log("ViewFile - Requested file: " . $fileName);
error_log("ViewFile - Full path: " . $filePath);
error_log("ViewFile - File exists: " . (file_exists($filePath) ? 'YES' : 'NO'));

// Check if file exists
if (!file_exists($filePath)) {
    http_response_code(404);
    echo "<h1>File Not Found</h1>";
    echo "<p>File <strong>" . htmlspecialchars($fileName) . "</strong> tidak ditemukan.</p>";
    echo "<p>Path: " . htmlspecialchars(dirname($filePath)) . "</p>";
    echo "<p><a href='javascript:history.back()'>Kembali</a></p>";
    exit();
}

// Get file info
$fileSize = filesize($filePath);
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
header('Content-Length: ' . $fileSize);
header('Content-Disposition: inline; filename="' . $fileName . '"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

// Output file
readfile($filePath);
exit();
?>
