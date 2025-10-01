<?php
$IdTemp = $_SESSION['IdUser'];

// Single Query Optimized - gabungkan semua lookup dalam satu query
$QueryPegawaiOptimized = mysqli_query($db, "SELECT 
    mp.*,
    md_lingkungan.NamaDesa as DetailNamaDesa,
    mk_lingkungan.Kecamatan as DetailNamaKecamatan,
    md_unit.NamaDesa as DetailNamaUnitKerja,
    mk_unit.Kecamatan as DetailNamaKecamatanUnitKerja,
    mj.Keterangan as DetailNamaJenKel,
    ma.Agama as DetailNamaAgama,
    mgd.Golongan as DetailNamaGolDarah,
    msp.Status as DetailNamaSTNikah,
    msk.StatusPegawai as DetailNamaSTPegawai,
    mspd.Kabupaten as DetailKabupaten
FROM master_pegawai mp
LEFT JOIN master_desa md_lingkungan ON mp.Lingkungan = md_lingkungan.IdDesa
LEFT JOIN master_kecamatan mk_lingkungan ON md_lingkungan.IdKecamatanFK = mk_lingkungan.IdKecamatan
LEFT JOIN master_desa md_unit ON mp.IdDesaFK = md_unit.IdDesa
LEFT JOIN master_kecamatan mk_unit ON md_unit.IdKecamatanFK = mk_unit.IdKecamatan
LEFT JOIN master_jenkel mj ON mp.JenKel = mj.IdJenKel
LEFT JOIN master_agama ma ON mp.Agama = ma.IdAgama
LEFT JOIN master_golongan_darah mgd ON mp.GolDarah = mgd.IdGolDarah
LEFT JOIN master_status_pernikahan msp ON mp.StatusPernikahan = msp.IdPernikahan
LEFT JOIN master_status_kepegawaian msk ON mp.StatusKepegawaian = msk.IdStatusPegawai
LEFT JOIN master_setting_profile_dinas mspd ON mp.Kabupaten = mspd.IdKabupatenProfile
WHERE mp.IdPegawaiFK = '$IdTemp'");

$DataPegawaiDetail = mysqli_fetch_assoc($QueryPegawaiOptimized);

// Assign variables dari single query result
if ($DataPegawaiDetail) {
    $IdPegawaiFK = $DataPegawaiDetail['IdPegawaiFK'];
    $NIK = $DataPegawaiDetail['NIK'];
    $Nama = $DataPegawaiDetail['Nama'];
    $TempatLahir = $DataPegawaiDetail['Tempat'];
    
    // Format tanggal
    $TanggalLahirAmbil = $DataPegawaiDetail['TanggalLahir'];
    if ($TanggalLahirAmbil) {
        $exp = explode('-', $TanggalLahirAmbil);
        if (count($exp) == 3) {
            $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
        } else {
            $TanggalLahir = $TanggalLahirAmbil;
        }
    } else {
        $TanggalLahir = '';
    }
    
    $Alamat = $DataPegawaiDetail['Alamat'];
    $RT = $DataPegawaiDetail['RT'];
    $RW = $DataPegawaiDetail['RW'];
    $Siltap = number_format($DataPegawaiDetail['Siltap'], 0, ",", ".");
    $Foto = $DataPegawaiDetail['Foto'];
    $Telp = $DataPegawaiDetail['NoTelp'];
    $Email = $DataPegawaiDetail['Email'];
    $FotoUpload = $DataPegawaiDetail['Foto'];
    
    // Data dari JOIN - langsung tersedia
    $DetailIdDesa = $DataPegawaiDetail['Lingkungan'];
    $DetailNamaDesa = $DataPegawaiDetail['DetailNamaDesa'];
    $DetailNamaKecamatan = $DataPegawaiDetail['DetailNamaKecamatan'];
    $DetailIdUnitKerja = $DataPegawaiDetail['IdDesaFK'];
    $DetailNamaUnitKerja = $DataPegawaiDetail['DetailNamaUnitKerja'];
    $DetailNamaKecamatanUnitKerja = $DataPegawaiDetail['DetailNamaKecamatanUnitKerja'];
    $DetailNamaJenKel = $DataPegawaiDetail['DetailNamaJenKel'];
    $DetailNamaAgama = $DataPegawaiDetail['DetailNamaAgama'];
    $DetailNamaGolDarah = $DataPegawaiDetail['DetailNamaGolDarah'];
    $DetailNamaSTNikah = $DataPegawaiDetail['DetailNamaSTNikah'];
    $DetailNamaSTPegawai = $DataPegawaiDetail['DetailNamaSTPegawai'];
    $DetailKabupaten = $DataPegawaiDetail['DetailKabupaten'];
} else {
    // Set default values jika data tidak ditemukan
    $IdPegawaiFK = $NIK = $Nama = $TempatLahir = $TanggalLahir = '';
    $Alamat = $RT = $RW = $Siltap = $Foto = $Telp = $Email = $FotoUpload = '';
    $DetailIdDesa = $DetailNamaDesa = $DetailNamaKecamatan = '';
    $DetailIdUnitKerja = $DetailNamaUnitKerja = $DetailNamaKecamatanUnitKerja = '';
    $DetailNamaJenKel = $DetailNamaAgama = $DetailNamaGolDarah = '';
    $DetailNamaSTNikah = $DetailNamaSTPegawai = $DetailKabupaten = '';
}
