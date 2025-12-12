<?php
include '../../../Module/Config/Env.php';

echo "<option value=''>--Pilih Kecamatan--</option>";

$QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan ORDER BY Kecamatan ASC");
if ($QueryKecamatan) {
    while ($RowKecamatan = mysqli_fetch_assoc($QueryKecamatan)) {
        $IdKecamatan = htmlspecialchars($RowKecamatan['IdKecamatan']);
        $NamaKecamatan = htmlspecialchars($RowKecamatan['Kecamatan']);
        echo "<option value=\"$IdKecamatan\">$NamaKecamatan</option>";
    }
} else {
    echo "<option value=''>Error: " . mysqli_error($db) . "</option>";
}
?>