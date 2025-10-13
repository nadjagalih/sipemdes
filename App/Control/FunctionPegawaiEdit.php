<?php
// Include safe helpers
require_once __DIR__ . '/../../helpers/safe_helpers.php';

if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);

    $QueryPegawaiEdit = mysqli_query($db, "SELECT * FROM master_pegawai WHERE IdPegawaiFK = '$IdTemp' ");
    $DataPegawaiEdit = mysqli_fetch_assoc($QueryPegawaiEdit);
    
    // Safe array access with fallback values
    $IdPegawaiFK = safeGet($DataPegawaiEdit, 'IdPegawaiFK', '');
    $NIK = safeGet($DataPegawaiEdit, 'NIK', '');
    $Nama = safeGet($DataPegawaiEdit, 'Nama', '');
    $TempatLahir = safeGet($DataPegawaiEdit, 'Tempat', '');
    
    // Safe date parsing
    $TanggalLahirAmbil = safeGet($DataPegawaiEdit, 'TanggalLahir', '');
    if (!empty($TanggalLahirAmbil)) {
        $exp = explode('-', $TanggalLahirAmbil);
        if (count($exp) >= 3) {
            $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
        } else {
            $TanggalLahir = $TanggalLahirAmbil;
        }
    } else {
        $TanggalLahir = '';
    }
    
    $Alamat = safeGet($DataPegawaiEdit, 'Alamat', '');
    $RT = safeGet($DataPegawaiEdit, 'RT', '');
    $RW = safeGet($DataPegawaiEdit, 'RW', '');
    
    // Safe number formatting
    $AmbilSiltap = safeGet($DataPegawaiEdit, 'Siltap', 0);
    $AmbilSiltap = number_format($AmbilSiltap, 0, ",", ".");
    if ($AmbilSiltap == 0) {
        $Siltap = "";
    } else {
        $Siltap = $AmbilSiltap;
    }
    $Foto = safeGet($DataPegawaiEdit, 'Foto', '');

    $Lingkungan = safeGet($DataPegawaiEdit, 'Lingkungan', '');
    
    // Safe query for Desa
    $QueryDesaEdit = mysqli_query($db, "SELECT
    master_kecamatan.IdKecamatan,
    master_desa.IdKecamatanFK,
    master_desa.IdDesa,
    master_desa.NamaDesa,
    master_kecamatan.Kecamatan
    FROM master_desa
    INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
    WHERE master_desa.IdDesa = '$Lingkungan' ");
    $DataDesaEdit = mysqli_fetch_assoc($QueryDesaEdit);
    $EditIdDesa = safeGet($DataDesaEdit, 'IdDesa', '');
    $EditNamaDesa = safeGet($DataDesaEdit, 'NamaDesa', '');
    $EditNamaKecamatan = safeGet($DataDesaEdit, 'Kecamatan', '');

    $EditIdKecamatan = safeGet($DataPegawaiEdit, 'Kecamatan', '');
    $QueryKecamatanEdit = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$EditIdKecamatan' ");
    $DataKecamatanEdit = mysqli_fetch_assoc($QueryKecamatanEdit);
    // $EditKecamatan = safeGet($DataKecamatanEdit, 'Kecamatan', '');

    $EditIdKabupaten = safeGet($DataPegawaiEdit, 'Kabupaten', '');
    $QueryKabupatenEdit = mysqli_query($db, "SELECT * FROM master_setting_profile_dinas WHERE IdKAbupatenProfile = '$EditIdKabupaten' ");
    $DataKabupatenEdit = mysqli_fetch_assoc($QueryKabupatenEdit);
    $EditKabupaten = safeGet($DataKabupatenEdit, 'Kabupaten', '');

    $JenKel = safeGet($DataPegawaiEdit, 'JenKel', '');
    $QueryJenKelEdit = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
    $DataJenKelEdit = mysqli_fetch_assoc($QueryJenKelEdit);
    $EditNamaJenKel = safeGet($DataJenKelEdit, 'Keterangan', '');

    $Agama = safeGet($DataPegawaiEdit, 'Agama', '');
    $QueryAgamaEdit = mysqli_query($db, "SELECT * FROM master_agama WHERE IdAgama = '$Agama' ");
    $DataAgamaEdit = mysqli_fetch_assoc($QueryAgamaEdit);
    $EditNamaAgama = safeGet($DataAgamaEdit, 'Agama', '');

    $GolDarah = safeGet($DataPegawaiEdit, 'GolDarah', '');
    $QueryGolDarahEdit = mysqli_query($db, "SELECT * FROM master_golongan_darah WHERE IdGolDarah = '$GolDarah' ");
    $DataGolDarahEdit = mysqli_fetch_assoc($QueryGolDarahEdit);
    $EditNamaGolDarah = safeGet($DataGolDarahEdit, 'Golongan', '');

    $Pernikahan = safeGet($DataPegawaiEdit, 'StatusPernikahan', '');
    $QuerySTNikahEdit = mysqli_query($db, "SELECT * FROM master_status_pernikahan WHERE IdPernikahan = '$Pernikahan' ");
    $DataSTNikahEdit = mysqli_fetch_assoc($QuerySTNikahEdit);
    $EditNamaSTNikah = safeGet($DataSTNikahEdit, 'Status', '');

    $StatusPegawai = safeGet($DataPegawaiEdit, 'StatusKepegawaian', '');
    $QuerySTPegawaiEdit = mysqli_query($db, "SELECT * FROM master_status_kepegawaian WHERE IdStatusPegawai = '$StatusPegawai' ");
    $DataSTPegawaiEdit = mysqli_fetch_assoc($QuerySTPegawaiEdit);
    $EditNamaSTPegawai = safeGet($DataSTPegawaiEdit, 'StatusPegawai', '');

    $UnitKerja = safeGet($DataPegawaiEdit, 'IdDesaFK', '');
    $QueryUnitKerja = mysqli_query($db, "SELECT
    master_kecamatan.IdKecamatan,
    master_desa.IdKecamatanFK,
    master_desa.IdDesa,
    master_desa.NamaDesa,
    master_kecamatan.Kecamatan
    FROM master_desa
    INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
    WHERE master_desa.IdDesa = '$UnitKerja' ");
    $DataUnitKerja = mysqli_fetch_assoc($QueryUnitKerja);
    $EditIdUnitKerja = safeGet($DataUnitKerja, 'IdDesa', '');
    $EditNamaUnitKerja = safeGet($DataUnitKerja, 'NamaDesa', '');
    $EditNamaKecamatanUnitKerja = safeGet($DataUnitKerja, 'Kecamatan', '');

    $Telp = safeGet($DataPegawaiEdit, 'NoTelp', '');
    $Email = safeGet($DataPegawaiEdit, 'Email', '');
    $FotoUpload = safeGet($DataPegawaiEdit, 'Foto', '');
} else {
    // Initialize empty values if no Kode parameter
    $IdPegawaiFK = '';
    $NIK = '';
    $Nama = '';
    $TempatLahir = '';
    $TanggalLahir = '';
    $Alamat = '';
    $RT = '';
    $RW = '';
    $Siltap = '';
    $Foto = '';
    $Lingkungan = '';
    $EditIdDesa = '';
    $EditNamaDesa = '';
    $EditNamaKecamatan = '';
    $EditIdKecamatan = '';
    $EditIdKabupaten = '';
    $EditKabupaten = '';
    $EditNamaJenKel = '';
    $EditNamaAgama = '';
    $EditNamaGolDarah = '';
    $EditNamaSTNikah = '';
    $EditNamaSTPegawai = '';
    $EditIdUnitKerja = '';
    $EditNamaUnitKerja = '';
    $EditNamaKecamatanUnitKerja = '';
    $Telp = '';
    $Email = '';
    $FotoUpload = '';
}
?>
