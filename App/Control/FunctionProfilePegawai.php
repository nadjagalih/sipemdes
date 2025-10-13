<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);

    $QueryPegawaiDetail = mysqli_query($db, "SELECT * FROM master_pegawai WHERE IdPegawaiFK = '$IdTemp' ");
    $DataPegawaiDetail = mysqli_fetch_assoc($QueryPegawaiDetail);
    
    // Cek apakah data ditemukan
    if (!$DataPegawaiDetail) {
        echo "<script>
            alert('Data pegawai tidak ditemukan!');
            window.location.href = '?pg=ViewMutasi';
        </script>";
        exit;
    }
    
    $IdPegawaiFK = isset($DataPegawaiDetail['IdPegawaiFK']) ? $DataPegawaiDetail['IdPegawaiFK'] : '';
    $NIK = isset($DataPegawaiDetail['NIK']) ? $DataPegawaiDetail['NIK'] : '';
    $Nama = isset($DataPegawaiDetail['Nama']) ? $DataPegawaiDetail['Nama'] : '';
    $TempatLahir = isset($DataPegawaiDetail['Tempat']) ? $DataPegawaiDetail['Tempat'] : '';
    $TanggalLahirAmbil = isset($DataPegawaiDetail['TanggalLahir']) ? $DataPegawaiDetail['TanggalLahir'] : '';
    
    // Safe date parsing
    if (!empty($TanggalLahirAmbil) && $TanggalLahirAmbil != '0000-00-00') {
        $exp = explode('-', $TanggalLahirAmbil);
        if (count($exp) >= 3) {
            $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
        } else {
            $TanggalLahir = $TanggalLahirAmbil;
        }
    } else {
        $TanggalLahir = "";
    }
    
    $Alamat = isset($DataPegawaiDetail['Alamat']) ? $DataPegawaiDetail['Alamat'] : '';
    $RT = isset($DataPegawaiDetail['RT']) ? $DataPegawaiDetail['RT'] : '';
    $RW = isset($DataPegawaiDetail['RW']) ? $DataPegawaiDetail['RW'] : '';
    $SiltapValue = isset($DataPegawaiDetail['Siltap']) ? $DataPegawaiDetail['Siltap'] : 0;
    $Siltap = number_format($SiltapValue, 0, ",", ".");
    $Foto = isset($DataPegawaiDetail['Foto']) ? $DataPegawaiDetail['Foto'] : '';

    $Lingkungan = isset($DataPegawaiDetail['Lingkungan']) ? $DataPegawaiDetail['Lingkungan'] : '';
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
    
    $DetailIdDesa = ($DataDesaDetail && isset($DataDesaDetail['IdDesa'])) ? $DataDesaDetail['IdDesa'] : '';
    $DetailNamaDesa = ($DataDesaDetail && isset($DataDesaDetail['NamaDesa'])) ? $DataDesaDetail['NamaDesa'] : '';
    $DetailNamaKecamatan = ($DataDesaDetail && isset($DataDesaDetail['Kecamatan'])) ? $DataDesaDetail['Kecamatan'] : '';

    $DetailIdKecamatan = isset($DataPegawaiDetail['Kecamatan']) ? $DataPegawaiDetail['Kecamatan'] : '';
    $QueryKecamatanDetail = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$DetailIdKecamatan' ");
    $DataKecamatanDetail = mysqli_fetch_assoc($QueryKecamatanDetail);
    // $DetailKecamatan = ($DataKecamatanDetail && isset($DataKecamatanDetail['Kecamatan'])) ? $DataKecamatanDetail['Kecamatan'] : '';

    $DetailIdKabupaten = isset($DataPegawaiDetail['Kabupaten']) ? $DataPegawaiDetail['Kabupaten'] : '';
    $QueryKabupatenDetail = mysqli_query($db, "SELECT * FROM master_setting_profile_dinas WHERE IdKAbupatenProfile = '$DetailIdKabupaten' ");
    $DataKabupatenDetail = mysqli_fetch_assoc($QueryKabupatenDetail);
    $DetailKabupaten = ($DataKabupatenDetail && isset($DataKabupatenDetail['Kabupaten'])) ? $DataKabupatenDetail['Kabupaten'] : '';

    $JenKel = isset($DataPegawaiDetail['JenKel']) ? $DataPegawaiDetail['JenKel'] : '';
    $QueryJenKelDetail = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
    $DataJenKelDetail = mysqli_fetch_assoc($QueryJenKelDetail);
    $DetailNamaJenKel = ($DataJenKelDetail && isset($DataJenKelDetail['Keterangan'])) ? $DataJenKelDetail['Keterangan'] : '';

    $Agama = isset($DataPegawaiDetail['Agama']) ? $DataPegawaiDetail['Agama'] : '';
    $QueryAgamaDetail = mysqli_query($db, "SELECT * FROM master_agama WHERE IdAgama = '$Agama' ");
    $DataAgamaDetail = mysqli_fetch_assoc($QueryAgamaDetail);
    $DetailNamaAgama = ($DataAgamaDetail && isset($DataAgamaDetail['Agama'])) ? $DataAgamaDetail['Agama'] : '';

    $GolDarah = isset($DataPegawaiDetail['GolDarah']) ? $DataPegawaiDetail['GolDarah'] : '';
    $QueryGolDarahDetail = mysqli_query($db, "SELECT * FROM master_golongan_darah WHERE IdGolDarah = '$GolDarah' ");
    $DataGolDarahDetail = mysqli_fetch_assoc($QueryGolDarahDetail);
    $DetailNamaGolDarah = ($DataGolDarahDetail && isset($DataGolDarahDetail['Golongan'])) ? $DataGolDarahDetail['Golongan'] : '';

    $Pernikahan = isset($DataPegawaiDetail['StatusPernikahan']) ? $DataPegawaiDetail['StatusPernikahan'] : '';
    $QuerySTNikahDetail = mysqli_query($db, "SELECT * FROM master_status_pernikahan WHERE IdPernikahan = '$Pernikahan' ");
    $DataSTNikahDetail = mysqli_fetch_assoc($QuerySTNikahDetail);
    $DetailNamaSTNikah = ($DataSTNikahDetail && isset($DataSTNikahDetail['Status'])) ? $DataSTNikahDetail['Status'] : '';

    $StatusPegawai = isset($DataPegawaiDetail['StatusKepegawaian']) ? $DataPegawaiDetail['StatusKepegawaian'] : '';
    $QuerySTPegawaiDetail = mysqli_query($db, "SELECT * FROM master_status_kepegawaian WHERE IdStatusPegawai = '$StatusPegawai' ");
    $DataSTPegawaiDetail = mysqli_fetch_assoc($QuerySTPegawaiDetail);
    $DetailNamaSTPegawai = ($DataSTPegawaiDetail && isset($DataSTPegawaiDetail['StatusPegawai'])) ? $DataSTPegawaiDetail['StatusPegawai'] : '';

    $UnitKerja = isset($DataPegawaiDetail['IdDesaFK']) ? $DataPegawaiDetail['IdDesaFK'] : '';
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
    $DetailIdUnitKerja = ($DataUnitKerja && isset($DataUnitKerja['IdDesa'])) ? $DataUnitKerja['IdDesa'] : '';
    $DetailNamaUnitKerja = ($DataUnitKerja && isset($DataUnitKerja['NamaDesa'])) ? $DataUnitKerja['NamaDesa'] : '';
    $DetailNamaKecamatanUnitKerja = ($DataUnitKerja && isset($DataUnitKerja['Kecamatan'])) ? $DataUnitKerja['Kecamatan'] : '';

    $Telp = isset($DataPegawaiDetail['NoTelp']) ? $DataPegawaiDetail['NoTelp'] : '';
    $Email = isset($DataPegawaiDetail['Email']) ? $DataPegawaiDetail['Email'] : '';
    $FotoUpload = isset($DataPegawaiDetail['Foto']) ? $DataPegawaiDetail['Foto'] : '';


}
