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

// Validate if user is logged in
if (empty($_SESSION['NameUser']) || empty($_SESSION['PassUser'])) {
    ob_end_clean();
    header("Location: ../../index.php");
    exit();
}

// Validate and get file ID
if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    ob_end_clean();
    header("Location: ../v?pg=FileViewAdmin&alert=InvalidID");
    exit();
}

$fileId = intval($_GET['id']);

try {
    // First, get file information to verify it exists
    $stmt = SQLProtection::prepare($db, "SELECT IdFile, Nama FROM file WHERE IdFile = ?", [$fileId]);
    $result = SQLProtection::execute($stmt);
    $fileData = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    
    if (!$fileData) {
        throw new Exception("File not found");
    }
    
    // Delete the file from database
    $deleteStmt = SQLProtection::prepare($db, "DELETE FROM file WHERE IdFile = ?", [$fileId]);
    $deleteResult = SQLProtection::execute($deleteStmt);
    
    if ($deleteResult) {
        // Log the deletion for audit trail
        error_log("File deleted: ID={$fileId}, Name={$fileData['Nama']}, User={$_SESSION['NameUser']}");
        
        ob_end_clean();
        header("Location: ../v?pg=FileViewAdmin&alert=DeleteSuccess");
        exit();
    } else {
        throw new Exception("Failed to delete file from database");
    }
    
} catch (Exception $e) {
    error_log("File deletion error: " . $e->getMessage());
    ob_end_clean();
    header("Location: ../v?pg=FileViewAdmin&alert=DeleteError");
    exit();
}
?>