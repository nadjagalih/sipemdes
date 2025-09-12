<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);

    $QueryKategoriFile = mysqli_query($db, "SELECT * FROM master_file_kategori WHERE IdFileKategori = '$IdTemp'");
    $DataKategoriFile = mysqli_fetch_assoc($QueryKategoriFile);

    $IdFileKategori = $DataKategoriFile['IdFileKategori'];
    $KategoriFile = $DataKategoriFile['KategoriFile'];
}
