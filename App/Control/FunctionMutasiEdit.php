<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);

    $QueryMutasi = mysqli_query($db, "SELECT * FROM master_mutasi WHERE IdMutasi = '$IdTemp'");
    $DataMutasi = mysqli_fetch_assoc($QueryMutasi);

    $IdMutasi = $DataMutasi['IdMutasi'];
    $Mutasi = $DataMutasi['Mutasi'];
}
