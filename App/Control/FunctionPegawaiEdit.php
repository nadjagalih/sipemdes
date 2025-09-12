<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);

    $QueryPegawaiEdit = mysqli_query($db, "SELECT * FROM master_pegawai WHERE IdPegawaiFK = '$IdTemp' ");
    $DataPegawaiEdit = mysqli_fetch_assoc($QueryPegawaiEdit);
    $IdPegawaiFK =  $DataPegawaiEdit['IdPegawaiFK'];
    $NIK =  $DataPegawaiEdit['NIK'];
    $Nama =  $DataPegawaiEdit['Nama'];
    $TempatLahir =  $DataPegawaiEdit['Tempat'];
    $TanggalLahirAmbil =  $DataPegawaiEdit['TanggalLahir'];
    $exp = explode('-', $TanggalLahirAmbil);
    $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
    $Alamat =  $DataPegawaiEdit['Alamat'];
    $RT =  $DataPegawaiEdit['RT'];
    $RW =  $DataPegawaiEdit['RW'];
    // $Siltap =  number_format($DataPegawaiEdit['Siltap'], 0, ",", ".");
    $AmbilSiltap =  number_format($DataPegawaiEdit['Siltap'], 0, ",", ".");
    if ($AmbilSiltap == 0) {
        $Siltap = "";
    } else {
        $Siltap = $AmbilSiltap;
    }
    $Foto =  $DataPegawaiEdit['Foto'];

    $Lingkungan =  $DataPegawaiEdit['Lingkungan'];
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
    $EditIdDesa =  $DataDesaEdit['IdDesa'];
    $EditNamaDesa =  $DataDesaEdit['NamaDesa'];
    $EditNamaKecamatan =  $DataDesaEdit['Kecamatan'];

    $EditIdKecamatan =  $DataPegawaiEdit['Kecamatan'];
    $QueryKecamatanEdit = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$EditIdKecamatan' ");
    $DataKecamatanEdit = mysqli_fetch_assoc($QueryKecamatanEdit);
    // $EditKecamatan =  $DataKecamatanEdit['Kecamatan'];

    $EditIdKabupaten =  $DataPegawaiEdit['Kabupaten'];
    $QueryKabupatenEdit = mysqli_query($db, "SELECT * FROM master_setting_profile_dinas WHERE IdKAbupatenProfile = '$EditIdKabupaten' ");
    $DataKabupatenEdit = mysqli_fetch_assoc($QueryKabupatenEdit);
    $EditKabupaten =  $DataKabupatenEdit['Kabupaten'];

    $JenKel =  $DataPegawaiEdit['JenKel'];
    $QueryJenKelEdit = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
    $DataJenKelEdit = mysqli_fetch_assoc($QueryJenKelEdit);
    $EditNamaJenKel =  $DataJenKelEdit['Keterangan'];

    $Agama =  $DataPegawaiEdit['Agama'];
    $QueryAgamaEdit = mysqli_query($db, "SELECT * FROM master_agama WHERE IdAgama = '$Agama' ");
    $DataAgamaEdit = mysqli_fetch_assoc($QueryAgamaEdit);
    $EditNamaAgama =  $DataAgamaEdit['Agama'];

    $GolDarah =  $DataPegawaiEdit['GolDarah'];
    $QueryGolDarahEdit = mysqli_query($db, "SELECT * FROM master_golongan_darah WHERE IdGolDarah = '$GolDarah' ");
    $DataGolDarahEdit = mysqli_fetch_assoc($QueryGolDarahEdit);
    $EditNamaGolDarah =  $DataGolDarahEdit['Golongan'];

    $Pernikahan =  $DataPegawaiEdit['StatusPernikahan'];
    $QuerySTNikahEdit = mysqli_query($db, "SELECT * FROM master_status_pernikahan WHERE IdPernikahan = '$Pernikahan' ");
    $DataSTNikahEdit = mysqli_fetch_assoc($QuerySTNikahEdit);
    $EditNamaSTNikah =  $DataSTNikahEdit['Status'];

    $StatusPegawai =  $DataPegawaiEdit['StatusKepegawaian'];
    $QuerySTPegawaiEdit = mysqli_query($db, "SELECT * FROM master_status_kepegawaian WHERE IdStatusPegawai = '$StatusPegawai' ");
    $DataSTPegawaiEdit = mysqli_fetch_assoc($QuerySTPegawaiEdit);
    $EditNamaSTPegawai =  $DataSTPegawaiEdit['StatusPegawai'];

    $UnitKerja =  $DataPegawaiEdit['IdDesaFK'];
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
    $EditIdUnitKerja =  $DataUnitKerja['IdDesa'];
    $EditNamaUnitKerja =  $DataUnitKerja['NamaDesa'];
    $EditNamaKecamatanUnitKerja =  $DataUnitKerja['Kecamatan'];

    $Telp =  $DataPegawaiEdit['NoTelp'];
    $Email =  $DataPegawaiEdit['Email'];
    $FotoUpload =  $DataPegawaiEdit['Foto'];
}
