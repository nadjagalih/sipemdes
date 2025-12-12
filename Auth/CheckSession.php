<?php
session_start();
header('Content-Type: application/json');

// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$response = array('valid' => false);

// Check for different session types
$isKecamatanUser = isset($_SESSION['IdKecamatan']) && isset($_SESSION['IdUser']);
$isRegularUser = isset($_SESSION['IdPegawai']) && isset($_SESSION['NameUser']);

// Validate based on session type
if ($isKecamatanUser) {
    // Kecamatan user validation
    if (!empty($_SESSION['IdUser']) && 
        !empty($_SESSION['IdKecamatan']) &&
        isset($_SESSION['IdLevelUserFK']) && 
        $_SESSION['IdLevelUserFK'] >= 1 && 
        $_SESSION['IdLevelUserFK'] <= 4) {
        $response['valid'] = true;
    }
} elseif ($isRegularUser) {
    // Regular user validation (Desa/Admin)
    if (!empty($_SESSION['IdPegawai']) && 
        !empty($_SESSION['NameUser']) &&
        isset($_SESSION['IdLevelUserFK']) && 
        $_SESSION['IdLevelUserFK'] >= 1 && 
        $_SESSION['IdLevelUserFK'] <= 4) {
        $response['valid'] = true;
    }
}

echo json_encode($response);
exit();
?>