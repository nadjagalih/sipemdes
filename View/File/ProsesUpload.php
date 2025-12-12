<?php
// Start output buffering to prevent headers already sent error
ob_start();

// Include security and config
require_once '../../Module/Security/Security.php';
require_once '../../Module/Config/Env.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Validate and sanitize POST data
$kategori = isset($_POST['kategori']) ? sql_injeksi($_POST['kategori']) : '';
$nama = isset($_POST['namafile']) ? sql_injeksi($_POST['namafile']) : '';
$iddesa = isset($_POST['iddesa']) ? sql_injeksi($_POST['iddesa']) : '';
$idkecamatan = isset($_POST['idkecamatan']) ? sql_injeksi($_POST['idkecamatan']) : '';

// Validate required fields
if (empty($kategori) || empty($nama)) {
    ob_end_clean();
    header("Location: ../v?pg=FileUploadAdmin&alert=EmptyFields");
    exit();
}

// Validate file upload
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    ob_end_clean();
    header("Location: ../v?pg=FileUploadAdmin&alert=FileError");
    exit();
}

$file = $_FILES['file'];

// Validate file size (5MB max)
$maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
if ($file['size'] > $maxFileSize) {
    ob_end_clean();
    header("Location: ../v?pg=FileUploadAdmin&alert=FileMax");
    exit();
}

// Validate file type
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$allowed = ['pdf'];
if (!in_array(strtolower($ext), $allowed)) {
    ob_end_clean();
    header("Location: ../v?pg=FileUploadAdmin&alert=FileExt");
    exit();
}

// Get desa name and kecamatan id if iddesa is provided
$desaData = null;
if (!empty($iddesa) && is_numeric($iddesa)) {
    $stmt = SQLProtection::prepare($db, "SELECT NamaDesa, IdKecamatanFK FROM master_desa WHERE IdDesa = ?", [$iddesa]);
    $result = SQLProtection::execute($stmt);
    $desaData = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

// Read and prepare file contents
$tmpPath = $file['tmp_name'];
$binaryData = file_get_contents($tmpPath);

if ($binaryData === false) {
    ob_end_clean();
    header("Location: ../v?pg=FileUploadAdmin&alert=FileReadError");
    exit();
}

// Prepare SQL query based on level
try {
    if (!empty($iddesa) && is_numeric($iddesa)) {
        // Insert for Desa level
        $stmt = SQLProtection::prepare($db, 
            "INSERT INTO file (Nama, Ekstensi, FileBlob, IdFileKategoriFK, IdDesaFK, IdLevelFileFK) VALUES (?, ?, ?, ?, ?, 3)",
            [$nama, $ext, $binaryData, $kategori, $iddesa]
        );
    } else if (!empty($idkecamatan) && is_numeric($idkecamatan)) {
        // Insert for Kecamatan level
        $stmt = SQLProtection::prepare($db,
            "INSERT INTO file (Nama, Ekstensi, FileBlob, IdFileKategoriFK, IdKecamatanFK, IdLevelFileFK) VALUES (?, ?, ?, ?, ?, 2)",
            [$nama, $ext, $binaryData, $kategori, $idkecamatan]
        );
    } else {
        // Insert for Admin level
        $stmt = SQLProtection::prepare($db,
            "INSERT INTO file (Nama, Ekstensi, FileBlob, IdFileKategoriFK, IdLevelFileFK) VALUES (?, ?, ?, ?, 1)",
            [$nama, $ext, $binaryData, $kategori]
        );
    }

    // Execute the query
    $result = SQLProtection::execute($stmt);
    
    if ($result) {
        ob_end_clean();
        header("Location: ../v?pg=FileUploadAdmin&alert=UploadSukses");
        exit();
    } else {
        throw new Exception("Failed to insert file data");
    }

} catch (Exception $e) {
    error_log("File upload error: " . $e->getMessage());
    ob_end_clean();
    header("Location: ../v?pg=FileUploadAdmin&alert=DatabaseError");
    exit();
}
?>