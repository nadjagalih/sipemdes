<?php

require_once "../../Module/Config/Env.php";

if (isset($_GET['idkecamatan'])) {
    $$id = isset($_GET['idkecamatan']) ? sql_injeksi($_GET['idkecamatan']) : '';
    $q = mysqli_query($db, "SELECT * FROM master_desa WHERE IdKecamatanFK = '$id'");
    echo "<option value=''>Pilih Desa</option>";
    while ($row = mysqli_fetch_assoc($q)) {
        echo "<option value='{$row['IdDesa']}'>{$row['NamaDesa']}</option>";
    }
}
?>
