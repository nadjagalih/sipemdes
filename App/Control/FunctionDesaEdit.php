<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);

    $QueryEditDesa = mysqli_query($db, "SELECT
    master_desa.IdDesa,
    master_desa.KodeDesa,
    master_desa.NamaDesa,
    master_desa.IdKecamatanFK,
    master_desa.IdKabupatenFK,
    master_desa.AlamatDesa,
    master_desa.NoTelepon,
    master_desa.Latitude,
    master_desa.Longitude,
    master_kecamatan.IdKecamatan,
    master_kecamatan.Kecamatan,
    master_setting_profile_dinas.IdKabupatenProfile,
    master_setting_profile_dinas.Kabupaten
    FROM
    master_setting_profile_dinas
    INNER JOIN master_desa ON master_setting_profile_dinas.IdKabupatenProfile = master_desa.IdKabupatenFK
    INNER JOIN master_kecamatan ON master_kecamatan.IdKecamatan = master_desa.IdKecamatanFK
    WHERE master_desa.IdDesa = '$IdTemp' ");
    $EditDesa = mysqli_fetch_assoc($QueryEditDesa);

    $EditIdKabupaten = $EditDesa['IdKabupatenFK'];
    $EditKabupaten = $EditDesa['Kabupaten'];
    $EditIdKecamatan = $EditDesa['IdKecamatan'];
    $EditKodeKecamatan = $EditDesa['KodeKecamatan'];
    $EditNamaKecamatan = $EditDesa['Kecamatan'];
    $EditIdDesa = $EditDesa['IdDesa'];
    $EditKodeDesa = $EditDesa['KodeDesa'];
    $EditNamaDesa = $EditDesa['NamaDesa'];
    $EditAlamatDesa = $EditDesa['AlamatDesa'];
    $EditNoTelepon = $EditDesa['NoTelepon'];
    $EditLatitude = $EditDesa['Latitude'];
    $EditLongitude = $EditDesa['Longitude'];
}
