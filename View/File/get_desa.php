<?php
// Simple and robust version
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../Module/Config/Env.php";

// Check database connection
if (!isset($db) || !$db) {
    echo "<option value=''>Database connection failed</option>";
    exit;
}

if (isset($_GET['idkecamatan']) && !empty($_GET['idkecamatan'])) {
    $idKecamatan = intval($_GET['idkecamatan']); // Convert to integer for safety
    
    if ($idKecamatan > 0) {
        // Simple direct query first for testing
        $query = "SELECT IdDesa, NamaDesa FROM master_desa WHERE IdKecamatanFK = $idKecamatan ORDER BY NamaDesa ASC";
        $result = mysqli_query($db, $query);
        
        if ($result) {
            $count = mysqli_num_rows($result);
            
            echo "<option value=''>Pilih Desa</option>";
            
            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $idDesa = htmlspecialchars($row['IdDesa'], ENT_QUOTES, 'UTF-8');
                    $namaDesa = htmlspecialchars($row['NamaDesa'], ENT_QUOTES, 'UTF-8');
                    echo "<option value='{$idDesa}'>{$namaDesa}</option>";
                }
            } else {
                echo "<option value=''>Tidak ada desa di kecamatan ini</option>";
            }
        } else {
            echo "<option value=''>Error: " . mysqli_error($db) . "</option>";
        }
    } else {
        echo "<option value=''>ID Kecamatan tidak valid</option>";
    }
} else {
    echo "<option value=''>Pilih Desa</option>";
}
?>
