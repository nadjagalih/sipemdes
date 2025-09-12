<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);

    $QueryEditKecamatan = mysqli_query($db, "SELECT
    master_kecamatan.IdKecamatan,
    master_kecamatan.KodeKecamatan,
    master_kecamatan.Kecamatan,
    master_kecamatan.IdKabupatenFK,
    master_setting_profile_dinas.IdKabupatenProfile,
    master_setting_profile_dinas.Kabupaten
    FROM master_kecamatan
    INNER JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
    WHERE master_kecamatan.IdKecamatan = '$IdTemp' ");
    $EditKecamatan = mysqli_fetch_assoc($QueryEditKecamatan);

    $EditIdKabupaten = $EditKecamatan['IdKabupatenFK'];
    $EditKabupaten = $EditKecamatan['Kabupaten'];
    $EditIdKecamatan = $EditKecamatan['IdKecamatan'];
    $EditKodeKecamatan = $EditKecamatan['KodeKecamatan'];
    $EditKecamatan = $EditKecamatan['Kecamatan'];
}
