<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);

    $QueryJabatan = mysqli_query($db, "SELECT * FROM master_jabatan WHERE IdJabatan = '$IdTemp'");
    $DataJabatan = mysqli_fetch_assoc($QueryJabatan);

    $IdJabatan = $DataJabatan['IdJabatan'];
    $Jabatan = $DataJabatan['Jabatan'];
}
