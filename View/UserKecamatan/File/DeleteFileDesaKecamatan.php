<?php
// Start output buffering to prevent headers already sent error
ob_start();

// Include security and config
require_once '../../../Module/Security/Security.php';
require_once '../../../Module/Config/Env.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Validate if user is logged in and is UserKecamatan
if (empty($_SESSION['NameUser']) || empty($_SESSION['PassUser']) || empty($_SESSION['IdKecamatan'])) {
    ob_end_clean();
    header("Location: ../../../index.php");
    exit();
}

// Only allow POST requests for security
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ob_end_clean();
    header("Location: ../../v.php?pg=FileViewKecamatan&alert=InvalidRequest");
    exit();
}

// Validate CSRF token
if (!CSRFProtection::validateToken()) {
    ob_end_clean();
    header("Location: ../../v.php?pg=FileViewKecamatan&alert=CSRFError");
    exit();
}

// Validate and get file ID
if (!isset($_POST['id']) || empty($_POST['id']) || !is_numeric($_POST['id'])) {
    ob_end_clean();
    header("Location: ../../v.php?pg=FileViewKecamatan&alert=InvalidID");
    exit();
}

// Convert to integer for additional safety
$fileId = intval($_POST['id']);
$userKecamatanId = intval($_SESSION['IdKecamatan']);

try {
    // Get file information and verify it belongs to a desa under this kecamatan using prepared statement
    // Join with master_desa to ensure the file belongs to desa under this kecamatan
    $stmt = SQLProtection::prepare($db, 
        "SELECT f.IdFile, f.Nama, f.IdDesaFK, d.NamaDesa, d.IdKecamatanFK 
         FROM file f
         JOIN master_desa d ON f.IdDesaFK = d.IdDesa
         WHERE f.IdFile = ? AND d.IdKecamatanFK = ? AND f.IdLevelFileFK = 3", 
        [$fileId, $userKecamatanId]
    );
    
    $result = SQLProtection::execute($stmt);
    $resultSet = mysqli_stmt_get_result($stmt);
    $fileData = mysqli_fetch_assoc($resultSet);
    
    if (!$fileData) {
        ob_end_clean();
        header("Location: ../../v.php?pg=FileViewKecamatan&alert=FileNotFound");
        exit();
    }
    
    // Delete the file from database using prepared statement
    // Additional security: verify again that the desa belongs to this kecamatan
    $deleteStmt = SQLProtection::prepare($db, 
        "DELETE f FROM file f
         JOIN master_desa d ON f.IdDesaFK = d.IdDesa
         WHERE f.IdFile = ? AND d.IdKecamatanFK = ? AND f.IdLevelFileFK = 3", 
        [$fileId, $userKecamatanId]
    );
    
    $deleteResult = SQLProtection::execute($deleteStmt);
    
    if ($deleteResult) {
        // Log the deletion for audit trail
        error_log("Desa file deleted by UserKecamatan: ID={$fileId}, Name={$fileData['Nama']}, Desa={$fileData['NamaDesa']}, User={$_SESSION['NameUser']}, KecamatanID={$userKecamatanId}");
        
        ob_end_clean();
        header("Location: ../../v.php?pg=FileViewKecamatan&alert=DeleteSuccess");
        exit();
    } else {
        throw new Exception("Failed to delete file from database");
    }
    
} catch (Exception $e) {
    // Log error securely without exposing sensitive information
    error_log("DeleteFileDesaKecamatan Error: " . $e->getMessage() . " - User: {$_SESSION['NameUser']}, FileID: {$fileId}");
    
    ob_end_clean();
    header("Location: ../../v.php?pg=FileViewKecamatan&alert=SystemError");
    exit();
}
?>