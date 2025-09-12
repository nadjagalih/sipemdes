<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include '../../../Module/Config/Env.php';

$Tanggal_Cetak = date('d-m-Y');
$Waktu_Cetak = date('H:i:s');
$DateCetak = $Tanggal_Cetak . "_" . $Waktu_Cetak;


if (isset($_GET['Proses'])) {
    $IdTemp = sql_url($_GET['Kode']);

    $content =
        '<html>
            <body>
            <h4 align="center">DATA PROFILE</h4>
            <table border="0" cellpadding="6" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th colspan="5"><strong>A. DATA PRIBADI</strong></th>
                        </tr>
                    </thead>
        <tbody>';
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

    $content .= '<tr>
                    <td style="height:10; colspan="5"></td>
                </tr>
                <tr>
                    <td width="25" align="center">1.</td>
                    <td width="150">NIK</td>
                    <td width="10" align="center">:</td>
                    <td height="20" width="120">' . $NIK . '</td>';
    if (empty($Foto)) {
        $content .= '<td rowspan="9"><img src="../../../Vendor/Media/Pegawai/no-image.jpg" style="width:150px; height:auto" alt="image" class="message-avatar"></td>';
    } else {
        $content .= '<td rowspan="9"><img src="../../../Vendor/Media/Pegawai/' . $Foto . '" style="width:150px; height:auto" alt="image" class="message-avatar"></td>';
    }
    $content .= '</tr>
                <tr>
                    <td width="25" align="center">2.</td>
                    <td width="150">Nama</td>
                    <td width="10" align="center">:</td>
                    <td height="20" width="120">' . $Nama . '</td>
                </tr>
                <tr>
                    <td width="25" align="center">3.</td>
                    <td width="150">Tempat/Tanggal Lahir</td>
                    <td width="10" align="center">:</td>
                    <td height="20" width="120">' . $TempatLahir . ', ' . $TanggalLahir . '</td>
                </tr>
                <tr>
                    <td width="25" align="center">4.</td>
                    <td width="150">Jenis Kelamin</td>
                    <td width="10" align="center">:</td>
                    <td height="20" width="120">' . $DetailNamaJenKel . '</td>
                </tr>
                <tr>
                    <td width="25" align="center">5.</td>
                    <td width="150">Agama</td>
                    <td width="10" align="center">:</td>
                    <td height="20" width="120">' . $DetailNamaAgama . '</td>
                </tr>
                <tr>
                    <td width="25" align="center">6.</td>
                    <td width="150">Golongan Darah</td>
                    <td width="10" align="center">:</td>
                    <td height="20" width="120">' . $DetailNamaGolDarah . '</td>
                </tr>
                <tr>
                    <td width="25" align="center">7.</td>
                    <td width="150">Golongan Darah</td>
                    <td width="10" align="center">:</td>
                    <td height="20" width="120">' . $DetailNamaSTNikah . '</td>
                </tr>
                <tr>
                    <td width="25" align="center">8.</td>
                    <td width="150">Status Pegawai</td>
                    <td width="10" align="center">:</td>
                    <td height="20" width="120">' . $DetailNamaSTPegawai . '</td>
                </tr>
                <tr>
                    <td width="25" align="center">9.</td>
                    <td width="150">Alamat</td>
                    <td width="10" align="center">:</td>
                    <td height="20" width="350">' . $Alamat . " RT " . $RT . " / RW " . $RW . " " . $DetailNamaDesa . " " . $DetailNamaKecamatan . '</td>
                </tr>
                <tr>
                    <td width="25" align="center">10.</td>
                    <td width="150">Telp</td>
                    <td width="10" align="center">:</td>
                    <td height="20" width="350">' . $Telp . '</td>
                </tr>
                <tr>
                    <td width="25" align="center">11.</td>
                    <td width="150">Email</td>
                    <td width="10" align="center">:</td>
                    <td height="20" width="350">' . $Email . '</td>
                </tr>
                <tr>
                    <td width="25" align="center">12.</td>
                    <td width="150">Unit Kerja</td>
                    <td width="10" align="center">:</td>
                    <td height="20" width="350"> Kelurahan/Desa ' . $DetailNamaUnitKerja . ' Kecamatan ' . $DetailNamaKecamatanUnitKerja . '</td>
                </tr>
        </tbody>
        </table>';

    $content .= '<br>
                    <strong>B. RIWAYAT PENDIDIKAN</strong>
            <br><br>
            <table border="0.1" cellpadding="6" cellspacing="0" width="100%">
                    <thead>
                        <tr align="center">
                            <th width="40">No</th>
                            <th width="60">Tingkat</th>
                            <th width="200">Nama Sekolah</th>
                            <th width="140">Jurusan</th>
                            <th width="80" align="center">Thn Masuk<br>Thn Lulus</th>
                            <th width="180">Nomor Ijasah<br>Tanggal Ijasah</th>
                        </tr>
                    </thead>
                    <tbody>';

    $Nomor = 1;
    $QueryPendidikan = mysqli_query($db, "SELECT
                master_pegawai.IdPegawaiFK,
                history_pendidikan.IdPegawaiFK,
                history_pendidikan.IdPendidikanFK,
                history_pendidikan.IdPendidikanPegawai,
                history_pendidikan.NamaSekolah,
                history_pendidikan.Jurusan,
                history_pendidikan.Setting,
                history_pendidikan.TahunMasuk,
                history_pendidikan.TahunLulus,
                history_pendidikan.NomorIjasah,
                history_pendidikan.TanggalIjasah,
                master_pendidikan.IdPendidikan,
                master_pegawai.NIK,
                master_pegawai.Nama,
                master_pendidikan.JenisPendidikan
                FROM
                master_pegawai
                INNER JOIN history_pendidikan ON master_pegawai.IdPegawaiFK = history_pendidikan.IdPegawaiFK
                INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
                WHERE history_pendidikan.IdPegawaiFK = '$IdTemp'
                ORDER BY
                master_pendidikan.IdPendidikan DESC");
    while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
        $IdPendidikanV = $DataPendidikan['IdPendidikanPegawai'];
        $NamaSekolah = $DataPendidikan['NamaSekolah'];
        $Jurusan = $DataPendidikan['Jurusan'];
        $JenjangPendidikan = $DataPendidikan['JenisPendidikan'];
        $Setting = $DataPendidikan['Setting'];
        $Masuk = $DataPendidikan['TahunMasuk'];
        $Lulus = $DataPendidikan['TahunLulus'];
        $NomorIjasah = $DataPendidikan['NomorIjasah'];
        $TglIjasah = $DataPendidikan['TanggalIjasah'];
        $exp = explode('-', $TglIjasah);
        $TanggalIjasah = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

        $content .=
            '<tr>
                <td width="40" align="center">' . $Nomor . '</td>
                <td>' . $JenjangPendidikan . '</td>
                <td>' . $NamaSekolah . '</td>
                <td>' . $Jurusan . '</td>
                <td align="center">' . $Masuk . '<br>' . $Lulus . '</td>
                <td>' . $NomorIjasah . '<br>' . $TanggalIjasah . '</td>
            </tr>';
        $Nomor++;
    }
    $content .= '</tbody>
                </table>';
    $content .= '<br>
                    <strong>C. RIWAYAT KELUARGA</strong>
            <br><br>
            <table border="0.1" cellpadding="6" cellspacing="0" width="100%">
                    <thead>
                        <tr align="center">
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tempat<br>Tanggal Lahir</th>
                            <th>Hubungan<br>Tanggal Nikah</th>
                            <th>Pendidikan</th>
                            <th>Pekerjaan</th>
                        </tr>
                    </thead>
                    <tbody>';
    $Nomor = 1;
    $QuerySuamiIstri = mysqli_query($db, "SELECT
                hiskel_suami_istri.IdPegawaiFK,
                master_pegawai.IdPegawaiFK,
                hiskel_suami_istri.IdPendidikanFK,
                master_pendidikan.IdPendidikan,
                hiskel_suami_istri.IdSuamiIstri,
                hiskel_suami_istri.NIK,
                hiskel_suami_istri.Nama,
                hiskel_suami_istri.Tempat,
                hiskel_suami_istri.TanggalLahir,
                hiskel_suami_istri.StatusHubungan,
                hiskel_suami_istri.TanggalNikah,
                master_pendidikan.JenisPendidikan,
                hiskel_suami_istri.Pekerjaan
                FROM
                hiskel_suami_istri
                INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = hiskel_suami_istri.IdPegawaiFK
                INNER JOIN master_pendidikan ON hiskel_suami_istri.IdPendidikanFK = master_pendidikan.IdPendidikan
                WHERE
                hiskel_suami_istri.IdPegawaiFK = '$IdTemp'");
    while ($DataSuamiIstri = mysqli_fetch_assoc($QuerySuamiIstri)) {
        $IdSuamiIstri = $DataSuamiIstri['IdSuamiIstri'];
        $NIK = $DataSuamiIstri['NIK'];
        $Nama = $DataSuamiIstri['Nama'];
        $Tempat = $DataSuamiIstri['Tempat'];

        $TglLahir = $DataSuamiIstri['TanggalLahir'];
        $exp = explode('-', $TglLahir);
        $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

        $Hubungan = $DataSuamiIstri['StatusHubungan'];

        $TglNikah = $DataSuamiIstri['TanggalNikah'];
        $exp = explode('-', $TglNikah);
        $TanggalNikah = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

        $Pendidikan = $DataSuamiIstri['JenisPendidikan'];
        $Pekerjaan = $DataSuamiIstri['Pekerjaan'];

        $content .= '<tr>
               <td width="40" align="center">' . $Nomor . '</td>
                <td width="130">' . $NIK . '</td>
                <td width="170">' . $Nama . '</td>
                <td>' . $Tempat . '<br>' . $TanggalLahir . '</td>
                <td>' . $Hubungan . '<br>' . $TanggalNikah . '</td>
                <td>' . $Pendidikan . '</td>
                <td width="120">' . $Pekerjaan . '</td>
            </tr>';
        $Nomor++;
    }
    $content .= '</tbody>
                </table>';
    $content .= '<br>
                <strong>ANAK</strong><br><br>
                <table border="0.1" cellpadding="6" cellspacing="0" width="100%">
                    <thead>
                        <tr align="center">
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tempat<br>Tanggal Lahir</th>
                            <th>Hubungan</th>
                            <th>Jenis Kelamin</th>
                            <th>Pendidikan</th>
                        </tr>
                    </thead>
                    <tbody>';
    $Nomor = 1;
    $QueryAnak = mysqli_query($db, "SELECT
                    hiskel_anak.IdPegawaiFK,
                    master_pegawai.IdPegawaiFK,
                    master_pegawai.Nama AS NamaPegawai,
                    hiskel_anak.IdPendidikanFK,
                    master_pendidikan.IdPendidikan,
                    hiskel_anak.IdAnak,
                    hiskel_anak.NIK,
                    hiskel_anak.Nama,
                    hiskel_anak.Tempat,
                    hiskel_anak.TanggalLahir,
                    hiskel_anak.StatusHubungan,
                    hiskel_anak.JenKel,
                    master_pendidikan.JenisPendidikan,
                    hiskel_anak.Pekerjaan
                    FROM hiskel_anak
                    INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = hiskel_anak.IdPegawaiFK
                    INNER JOIN master_pendidikan ON hiskel_anak.IdPendidikanFK = master_pendidikan.IdPendidikan
                    WHERE hiskel_anak.IdPegawaiFK = '$IdTemp'");
    while ($DataAnak = mysqli_fetch_assoc($QueryAnak)) {
        $IdAnak = $DataAnak['IdAnak'];
        $NamaPegawai = $DataAnak['NamaPegawai'];
        $NIK = $DataAnak['NIK'];
        $Nama = $DataAnak['Nama'];
        $Tempat = $DataAnak['Tempat'];

        $TglLahir = $DataAnak['TanggalLahir'];
        $exp = explode('-', $TglLahir);
        $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

        $Hubungan = $DataAnak['StatusHubungan'];
        $JenKel = $DataAnak['JenKel'];

        $QJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
        $DataJenKel = mysqli_fetch_assoc($QJenKel);
        $JenisKelamin = $DataJenKel['Keterangan'];

        $Pendidikan = $DataAnak['JenisPendidikan'];
        $Pekerjaan = $DataAnak['Pekerjaan'];
        $content .= '<tr>
               <td width="40" align="center">' . $Nomor . '</td>
                <td width="130">' . $NIK . '</td>
                <td width="170">' . $Nama . '</td>
                <td width="90" align="center">' . $Tempat . '<br>' . $TanggalLahir . '</td>
                <td width="100">' . $Hubungan . '</td>
                <td width="100">' . $JenisKelamin . '</td>
                <td>' . $Pendidikan . '</td>
            </tr>';
        $Nomor++;
    }
    $content .= '</tbody>
                </table>';
    $content .= '<br>
                <strong>ORANG TUA</strong><br><br>
                <table border="0.1" cellpadding="6" cellspacing="0" width="100%">
                    <thead>
                        <tr align="center">
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tempat<br>Tanggal Lahir</th>
                            <th>Hubungan</th>
                            <th>Pendidikan</th>
                        </tr>
                    </thead>
                    <tbody>';
    $Nomor = 1;
    $QueryOrtu = mysqli_query($db, "SELECT
                hiskel_ortu.IdPegawaiFK,
                master_pegawai.IdPegawaiFK,
                master_pegawai.Nama AS NamaPegawai,
                hiskel_ortu.IdPendidikanFK,
                master_pendidikan.IdPendidikan,
                hiskel_ortu.IdOrtu,
                hiskel_ortu.NIK,
                hiskel_ortu.Nama,
                hiskel_ortu.Tempat,
                hiskel_ortu.TanggalLahir,
                hiskel_ortu.StatusHubungan,
                hiskel_ortu.JenKel,
                master_pendidikan.JenisPendidikan,
                hiskel_ortu.Pekerjaan
                FROM
                hiskel_ortu
                INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = hiskel_ortu.IdPegawaiFK
                INNER JOIN master_pendidikan ON hiskel_ortu.IdPendidikanFK = master_pendidikan.IdPendidikan
                WHERE hiskel_ortu.IdPegawaiFK = '$IdTemp'");
    while ($DataOrtu = mysqli_fetch_assoc($QueryOrtu)) {
        $IdOrtu = $DataOrtu['IdOrtu'];
        $NamaPegawai = $DataOrtu['NamaPegawai'];
        $NIK = $DataOrtu['NIK'];
        $Nama = $DataOrtu['Nama'];
        $Tempat = $DataOrtu['Tempat'];

        $TglLahir = $DataOrtu['TanggalLahir'];
        $exp = explode('-', $TglLahir);
        $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

        $Hubungan = $DataOrtu['StatusHubungan'];
        $JenKel = $DataOrtu['JenKel'];

        $QJenKelOrtu = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
        $DataJenKelOrtu = mysqli_fetch_assoc($QJenKelOrtu);
        $JenisKelaminOrtu = $DataJenKelOrtu['Keterangan'];

        $Pendidikan = $DataOrtu['JenisPendidikan'];
        $Pekerjaan = $DataOrtu['Pekerjaan'];
        $content .= '<tr>
               <td width="40" align="center">' . $Nomor . '</td>
                <td width="130">' . $NIK . '</td>
                <td width="170">' . $Nama . '</td>
                <td width="90" align="center">' . $Tempat . '<br>' . $TanggalLahir . '</td>
                <td  width="100">' . $Hubungan . '</td>
                <td  width="100">' . $Pendidikan . '</td>
            </tr>';
        $Nomor++;
    }
    $content .= '</tbody>
                </table>';
    $content .=
        '<br>
                <strong>D. MUTASI</strong><br><br>
                <table border="0.1" cellpadding="6" cellspacing="0" width="100%">
                    <thead>
                        <tr align="center">
                            <th>No</th>
                            <th>Jenis Mutasi</th>
                            <th>Jabatan</th>
                            <th>Tanggal Mutasi</th>
                            <th>Nomer SK<br>Tanggal Mutasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>';
    $No = 1;
    $QMutasiView = mysqli_query($db, "SELECT
                                        history_mutasi.JenisMutasi,
                                        history_mutasi.IdMutasi,
                                        master_mutasi.Mutasi,
                                        history_mutasi.IdJabatanFK,
                                        master_jabatan.IdJabatan,
                                        master_jabatan.Jabatan,
                                        history_mutasi.NomorSK,
                                        history_mutasi.TanggalMutasi,
                                        history_mutasi.FileSKMutasi,
                                        history_mutasi.Setting,
                                        history_mutasi.KeteranganJabatan,
                                        master_mutasi.IdMutasi AS MasterId,
                                        history_mutasi.IdPegawaiFK
                                        FROM history_mutasi
                                        INNER JOIN master_mutasi ON history_mutasi.JenisMutasi = master_mutasi.IdMutasi
                                        INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                                        WHERE history_mutasi.IdPegawaiFK = '$IdTemp'
                                        ORDER BY history_mutasi.TanggalMutasi DESC");
    while ($DataView = mysqli_fetch_assoc($QMutasiView)) {
        $IdMutasi = $DataView['IdMutasi'];
        $JenisMutasi = $DataView['Mutasi'];
        $Jabatan = $DataView['Jabatan'];
        $TglMutasi = $DataView['TanggalMutasi'];
        $exp = explode('-', $TglMutasi);
        $TanggalMutasi = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
        $NomorSK = $DataView['NomorSK'];
        $SKMutasi = $DataView['FileSKMutasi'];
        $SetMutasi = $DataView['Setting'];
        $content .= '<tr>
                <td width="30" align="center">' . $No . '</td>
                <td width="95" align="center">' . $JenisMutasi . '</td>
                <td width="240">' . $Jabatan . '</td>
                <td width="100" align="center">' . $TanggalMutasi . '</td>
                <td width="180" align="center"><strong>' . $NomorSK . '</strong><br>' . $TanggalMutasi . '</td>
                <td align="center">' . $SetMutasi . '</td>
                </tr>';
        $No++;
    }

    $content .= '</tbody>
                </table>';
    $content .=
        '<br>';
    $content .= '<br><br><strong>E. Penghasilan Tetap Rp. ' . $Siltap . '</strong>';

    $content .= '</body>
                </html>';
}

require_once('../../../Vendor/html2pdf/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;

$content2pdf = new Html2Pdf('P', 'F4', 'fr', true, 'UTF-8', array(10, 15, 15, 15), false);
$content2pdf->writeHTML($content);
// $html2pdf->output();
$content2pdf->Output('Biodata ' . $Nama . '_' . $DateCetak . '.pdf', 'I'); //NAMA FILE, I/D/F/S
?>

<!--  KETERANGAN OUTPUT
 “I” mengirim file untuk ditampilkan di browser.
 “D” mengirim file ke browser dan memaksa download file.
 “F” simpan ke file server lokal.
 “S” mengembalikan dokumen sebagai string. -->

<!--  KETERANGAN OUTPUT
 “I” mengirim file untuk ditampilkan di browser.
 “D” mengirim file ke browser dan memaksa download file.
 “F” simpan ke file server lokal.
 “S” mengembalikan dokumen sebagai string. -->