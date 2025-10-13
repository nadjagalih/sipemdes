<?php
// Include safe helpers and database connection
require_once __DIR__ . '/../../helpers/safe_helpers.php';
require_once __DIR__ . '/../../Module/Config/Env.php';

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
    master_kecamatan.KodeKecamatan,
    master_kecamatan.Kecamatan,
    master_setting_profile_dinas.IdKabupatenProfile,
    master_setting_profile_dinas.Kabupaten
    FROM
    master_setting_profile_dinas
    INNER JOIN master_desa ON master_setting_profile_dinas.IdKabupatenProfile = master_desa.IdKabupatenFK
    INNER JOIN master_kecamatan ON master_kecamatan.IdKecamatan = master_desa.IdKecamatanFK
    WHERE master_desa.IdDesa = '$IdTemp' ");
    $EditDesa = mysqli_fetch_assoc($QueryEditDesa);

    // Safe array access with fallback values
    $EditIdKabupaten = safeGet($EditDesa, 'IdKabupatenFK', '');
    $EditKabupaten = safeGet($EditDesa, 'Kabupaten', '');
    $EditIdKecamatan = safeGet($EditDesa, 'IdKecamatan', '');
    $EditKodeKecamatan = safeGet($EditDesa, 'KodeKecamatan', '');
    $EditNamaKecamatan = safeGet($EditDesa, 'Kecamatan', '');
    $EditIdDesa = safeGet($EditDesa, 'IdDesa', '');
    $EditKodeDesa = safeGet($EditDesa, 'KodeDesa', '');
    $EditNamaDesa = safeGet($EditDesa, 'NamaDesa', '');
    $EditAlamatDesa = safeGet($EditDesa, 'AlamatDesa', '');
    $EditNoTelepon = safeGet($EditDesa, 'NoTelepon', '');
    $EditLatitude = safeGet($EditDesa, 'Latitude', '');
    $EditLongitude = safeGet($EditDesa, 'Longitude', '');
} else {
    // Initialize empty values if no Kode parameter
    $EditIdKabupaten = '';
    $EditKabupaten = '';
    $EditIdKecamatan = '';
    $EditKodeKecamatan = '';
    $EditNamaKecamatan = '';
    $EditIdDesa = '';
    $EditKodeDesa = '';
    $EditNamaDesa = '';
    $EditAlamatDesa = '';
    $EditNoTelepon = '';
    $EditLatitude = '';
    $EditLongitude = '';
}
?>
