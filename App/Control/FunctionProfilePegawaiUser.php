<?php
$IdTemp = $_SESSION['IdUser'];

$QueryPegawaiDetail = mysqli_query($db, "SELECT * FROM master_pegawai WHERE IdPegawaiFK = '$IdTemp' ");
$DataPegawaiDetail = mysqli_fetch_assoc($QueryPegawaiDetail);
$IdPegawaiFK =  $DataPegawaiDetail['IdPegawaiFK'];
$NIK =  $DataPegawaiDetail['NIK'];
$Nama =  $DataPegawaiDetail['Nama'];
$TempatLahir =  $DataPegawaiDetail['Tempat'];
$TanggalLahirAmbil =  $DataPegawaiDetail['TanggalLahir'];
$exp = explode('-', $TanggalLahirAmbil);
$TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
$Alamat =  $DataPegawaiDetail['Alamat'];
$RT =  $DataPegawaiDetail['RT'];
$RW =  $DataPegawaiDetail['RW'];
$Siltap =  number_format($DataPegawaiDetail['Siltap'], 0, ",", ".");
$Foto =  $DataPegawaiDetail['Foto'];

$Lingkungan =  $DataPegawaiDetail['Lingkungan'];
$QueryDesaDetail = mysqli_query($db, "SELECT
    master_kecamatan.IdKecamatan,
    master_desa.IdKecamatanFK,
    master_desa.IdDesa,
    master_desa.NamaDesa,
    master_kecamatan.Kecamatan
    FROM master_desa
    INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
    WHERE master_desa.IdDesa = '$Lingkungan' ");
$DataDesaDetail = mysqli_fetch_assoc($QueryDesaDetail);
$DetailIdDesa =  $DataDesaDetail['IdDesa'];
$DetailNamaDesa =  $DataDesaDetail['NamaDesa'];
$DetailNamaKecamatan =  $DataDesaDetail['Kecamatan'];

$DetailIdKecamatan =  $DataPegawaiDetail['Kecamatan'];
$QueryKecamatanDetail = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$DetailIdKecamatan' ");
$DataKecamatanDetail = mysqli_fetch_assoc($QueryKecamatanDetail);
// $DetailKecamatan =  $DataKecamatanDetail['Kecamatan'];

$DetailIdKabupaten =  $DataPegawaiDetail['Kabupaten'];
$QueryKabupatenDetail = mysqli_query($db, "SELECT * FROM master_setting_profile_dinas WHERE IdKAbupatenProfile = '$DetailIdKabupaten' ");
$DataKabupatenDetail = mysqli_fetch_assoc($QueryKabupatenDetail);
$DetailKabupaten =  $DataKabupatenDetail['Kabupaten'];

$JenKel =  $DataPegawaiDetail['JenKel'];
$QueryJenKelDetail = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
$DataJenKelDetail = mysqli_fetch_assoc($QueryJenKelDetail);
$DetailNamaJenKel =  $DataJenKelDetail['Keterangan'];

$Agama =  $DataPegawaiDetail['Agama'];
$QueryAgamaDetail = mysqli_query($db, "SELECT * FROM master_agama WHERE IdAgama = '$Agama' ");
$DataAgamaDetail = mysqli_fetch_assoc($QueryAgamaDetail);
$DetailNamaAgama =  $DataAgamaDetail['Agama'];

$GolDarah =  $DataPegawaiDetail['GolDarah'];
$QueryGolDarahDetail = mysqli_query($db, "SELECT * FROM master_golongan_darah WHERE IdGolDarah = '$GolDarah' ");
$DataGolDarahDetail = mysqli_fetch_assoc($QueryGolDarahDetail);
$DetailNamaGolDarah =  $DataGolDarahDetail['Golongan'];

$Pernikahan =  $DataPegawaiDetail['StatusPernikahan'];
$QuerySTNikahDetail = mysqli_query($db, "SELECT * FROM master_status_pernikahan WHERE IdPernikahan = '$Pernikahan' ");
$DataSTNikahDetail = mysqli_fetch_assoc($QuerySTNikahDetail);
$DetailNamaSTNikah =  $DataSTNikahDetail['Status'];

$StatusPegawai =  $DataPegawaiDetail['StatusKepegawaian'];
$QuerySTPegawaiDetail = mysqli_query($db, "SELECT * FROM master_status_kepegawaian WHERE IdStatusPegawai = '$StatusPegawai' ");
$DataSTPegawaiDetail = mysqli_fetch_assoc($QuerySTPegawaiDetail);
$DetailNamaSTPegawai =  $DataSTPegawaiDetail['StatusPegawai'];

$UnitKerja =  $DataPegawaiDetail['IdDesaFK'];
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
$DetailIdUnitKerja =  $DataUnitKerja['IdDesa'];
$DetailNamaUnitKerja =  $DataUnitKerja['NamaDesa'];
$DetailNamaKecamatanUnitKerja =  $DataUnitKerja['Kecamatan'];

$Telp =  $DataPegawaiDetail['NoTelp'];
$Email =  $DataPegawaiDetail['Email'];
$FotoUpload =  $DataPegawaiDetail['Foto'];
