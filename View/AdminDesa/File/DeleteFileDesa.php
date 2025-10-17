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

// Validate if user is logged in and is AdminDesa
if (empty($_SESSION['NameUser']) || empty($_SESSION['PassUser']) || empty($_SESSION['IdDesa'])) {
    ob_end_clean();
    header("Location: ../../../index.php");
    exit();
}

// Only allow POST requests for security
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ob_end_clean();
    header("Location: ../../v.php?pg=FileViewDesa&alert=InvalidRequest");
    exit();
}

// Validate CSRF token
if (!CSRFProtection::validateToken()) {
    ob_end_clean();
    header("Location: ../../v.php?pg=FileViewDesa&alert=CSRFError");
    exit();
}

// Validate and get file ID
if (!isset($_POST['id']) || empty($_POST['id']) || !is_numeric($_POST['id'])) {
    ob_end_clean();
    header("Location: ../../v.php?pg=FileViewDesa&alert=InvalidID");
    exit();
}

// Convert to integer for additional safety
$fileId = intval($_POST['id']);
$userDesaId = intval($_SESSION['IdDesa']);

try {
    // Get file information and verify it belongs to the user's desa using prepared statement
    $stmt = SQLProtection::prepare($db, 
        "SELECT IdFile, Nama, IdDesaFK FROM file WHERE IdFile = ? AND IdDesaFK = ?", 
        [$fileId, $userDesaId]
    );
    
    $result = SQLProtection::execute($stmt);
    $resultSet = mysqli_stmt_get_result($stmt);
    $fileData = mysqli_fetch_assoc($resultSet);
    
    if (!$fileData) {
        ob_end_clean();
        header("Location: ../../v.php?pg=FileViewDesa&alert=FileNotFound");
        exit();
    }
    
    // Delete the file from database using prepared statement
    $deleteStmt = SQLProtection::prepare($db, 
        "DELETE FROM file WHERE IdFile = ? AND IdDesaFK = ?", 
        [$fileId, $userDesaId]
    );
    
    $deleteResult = SQLProtection::execute($deleteStmt);
    
    if ($deleteResult) {
        // Log the deletion for audit trail
        error_log("File deleted by AdminDesa: ID={$fileId}, Name={$fileData['Nama']}, User={$_SESSION['NameUser']}, DesaID={$userDesaId}");
        
        ob_end_clean();
        header("Location: ../../v.php?pg=FileViewDesa&alert=DeleteSuccess");
        exit();
    } else {
        throw new Exception("Failed to delete file from database");
    }
    
} catch (Exception $e) {
    // Log error securely without exposing sensitive information
    error_log("DeleteFileDesa Error: " . $e->getMessage() . " - User: {$_SESSION['NameUser']}, FileID: {$fileId}");
    
    ob_end_clean();
    header("Location: ../../v.php?pg=FileViewDesa&alert=SystemError");
    exit();
}
?>