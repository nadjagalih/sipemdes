<?php
include '../../../Module/Config/Env.php';

$Kecamatan = isset($_POST['Kecamatan']) ? sql_injeksi($_POST['Kecamatan']) : '';

echo "<option value=''>--Pilih Desa--</option>";

if (!empty($Kecamatan)) {
    $QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdKecamatanFK = '$Kecamatan' ORDER BY NamaDesa ASC");
    if ($QueryDesa) {
        while ($RowDesa = mysqli_fetch_assoc($QueryDesa)) {
            $IdDesa = htmlspecialchars($RowDesa['IdDesa']);
            $NamaDesa = htmlspecialchars($RowDesa['NamaDesa']);
            echo "<option value=\"$IdDesa\">$NamaDesa</option>";
        }
    } else {
        echo "<option value=''>Error: " . mysqli_error($db) . "</option>";
    }
} else {
    echo "<option value=''>Please select Kecamatan first</option>";
}
?>