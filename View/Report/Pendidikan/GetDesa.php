<?php
include '../../../Module/Config/Env.php';

// Debug output
error_log("GetDesa.php Pendidikan accessed");

$Kecamatan = isset($_POST['Kecamatan']) ? sql_injeksi($_POST['Kecamatan']) : '';

// Debug
error_log("Received Kecamatan ID: " . $Kecamatan);

echo "<option value=''>--Pilih Desa--</option>";

if (!empty($Kecamatan)) {
    $QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdKecamatanFK = '$Kecamatan' ORDER BY NamaDesa ASC");
    
    if (!$QueryDesa) {
        $error = mysqli_error($db);
        error_log("MySQL Error in GetDesa.php Pendidikan: " . $error);
        echo "<option value=''>Error: " . htmlspecialchars($error) . "</option>";
    } else {
        $count = 0;
        while ($RowDesa = mysqli_fetch_assoc($QueryDesa)) {
            $IdDesa = htmlspecialchars($RowDesa['IdDesa']);
            $NamaDesa = htmlspecialchars($RowDesa['NamaDesa']);
            echo "<option value=\"$IdDesa\">$NamaDesa</option>";
            $count++;
        }
        error_log("GetDesa.php Pendidikan returned $count records for Kecamatan $Kecamatan");
        
        if ($count == 0) {
            echo "<option value=''>Tidak ada desa untuk kecamatan ini</option>";
        }
    }
} else {
    error_log("GetDesa.php Pendidikan - No Kecamatan provided");
    echo "<option value=''>Pilih kecamatan terlebih dahulu</option>";
}
?>