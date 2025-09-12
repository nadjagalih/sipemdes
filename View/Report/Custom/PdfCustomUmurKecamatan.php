<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include '../../../Module/Config/Env.php';
$Tanggal_Cetak = date('d-m-Y');
$Waktu_Cetak = date('H:i:s');
$DateCetak = $Tanggal_Cetak . "_" . $Waktu_Cetak;


$QProfile = mysqli_query($db, "SELECT * FROM master_Setting_profile_dinas");
$DataProfile = mysqli_fetch_assoc($QProfile);
$Kabupaten = $DataProfile['Kabupaten'];

if (isset($_GET['ExportPDF'])) {
    $AmbilJabatan = sql_injeksi($_GET['Jabatan']);
    $UmurAwal = sql_injeksi($_GET['UmurAwal']);
    $UmurAkhir = sql_injeksi($_GET['UmurAkhir']);

    $Kecamatan = sql_injeksi($_GET['Kecamatan']);

    $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$Kecamatan' ");
    $DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
    $NamaKecamatan = $DataKecamatan['Kecamatan'];

    if ($AmbilJabatan == 1) {
        $Jabatan = "Kepala Desa";
        $content =
            '<html>
            <body>
                <h5>Filter Data Kecamatan ' . $NamaKecamatan . ' Jabatan ' . $Jabatan . ' Dari Umur ' . $UmurAwal . ' Sampai ' . $UmurAkhir . ' Tahun <br>Kabupaten ' . $Kabupaten . ' <br>Pertanggal ' . $Tanggal_Cetak . ' Pukul ' . $Waktu_Cetak . ' WIB</h5>
                <table  border="0.3" cellpadding="2" cellspacing="0" width="100%">
                    <thead>
                        <tr align="center">
                            <th><strong>No</strong></th>
                            <th><strong>Foto</strong></th>
                            <th><strong>NIK</strong></th>
                            <th><strong>Nama<br>Jabatan<br>Alamat</strong></th>
                            <th><strong>Tanggal Lahir<br>Jenis Kelamin</strong></th>
                            <th><strong>Umur</strong></th>
                            <th><strong>Tanggal <br>Pensiun</strong></th>
                            <th><strong>Pendidikan <br>Terakhir</strong></th>
                            <th><strong>Tanggal/SK Mutasi</strong></th>
                            <th><strong>Unit Kerja<br>Kecamatan<br>Kabupaten</strong></th>
                        </tr>
                    </thead>
                    <tbody>';
        $Nomor = 1;
        $QueryPegawai = mysqli_query($db, "SELECT
                                                master_pegawai.IdPegawaiFK,
                                                master_pegawai.Foto,
                                                master_pegawai.NIK,
                                                master_pegawai.Nama,
                                                master_pegawai.TanggalLahir,
                                                TIMESTAMPDIFF(YEAR, master_pegawai.TanggalLahir, CURDATE()) AS UmurPeg,
                                                master_pegawai.JenKel,
                                                master_pegawai.IdDesaFK,
                                                master_pegawai.Alamat,
                                                master_pegawai.RT,
                                                master_pegawai.RW,
                                                master_pegawai.Lingkungan,
                                                master_pegawai.Kecamatan AS Kec,
                                                master_pegawai.Kabupaten,
                                                master_pegawai.Setting,
                                                master_pegawai.TanggalPensiun,
                                                master_desa.IdDesa,
                                                master_desa.NamaDesa,
                                                master_desa.IdKecamatanFK,
                                                master_kecamatan.IdKecamatan,
                                                master_kecamatan.Kecamatan,
                                                master_kecamatan.IdKabupatenFK,
                                                master_setting_profile_dinas.IdKabupatenProfile,
                                                master_setting_profile_dinas.Kabupaten,
                                                main_user.IdPegawai,
                                                main_user.IdLevelUserFK,
                                                history_mutasi.IdPegawaiFK,
                                                history_mutasi.Setting,
                                                master_jabatan.IdJabatan,
                                                history_mutasi.IdJabatanFK,
                                                master_jabatan.Jabatan,
                                                history_mutasi.NomorSK,
                                                history_mutasi.TanggalMutasi,
                                                master_pegawai.Siltap
                                            FROM
                                                master_pegawai
                                                LEFT JOIN
                                                master_desa
                                                ON
                                                    master_pegawai.IdDesaFK = master_desa.IdDesa
                                                LEFT JOIN
                                                master_kecamatan
                                                ON
                                                    master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                                                LEFT JOIN
                                                master_setting_profile_dinas
                                                ON
                                                    master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
                                                INNER JOIN
                                                main_user
                                                ON
                                                    main_user.IdPegawai = master_pegawai.IdPegawaiFK
                                                INNER JOIN
                                                history_mutasi
                                                ON
                                                    master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                                                INNER JOIN
                                                master_jabatan
                                                ON
                                                    history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                                            WHERE
                                                master_pegawai.Setting = 1 AND
                                                main_user.IdLevelUserFK <> 1 AND
                                                main_user.IdLevelUserFK <> 2 AND
                                                history_mutasi.Setting = 1 AND
                                                history_mutasi.IdJabatanFK = 1 AND
                                                TIMESTAMPDIFF(YEAR, master_pegawai.TanggalLahir, CURDATE()) BETWEEN '$UmurAwal' AND '$UmurAkhir' AND
                                                master_kecamatan.IdKecamatan = '$Kecamatan'
                                            ORDER BY
                                                master_pegawai.TanggalPensiun ASC");
        while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
            $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
            $Foto = $DataPegawai['Foto'];
            $NIK = $DataPegawai['NIK'];
            $Nama = $DataPegawai['Nama'];
            $Jabatan = $DataPegawai['Jabatan'];
            $AmbilTanggalSK = $DataPegawai['TanggalMutasi'];
            $expSK = explode('-', $AmbilTanggalSK);
            $TanggalSK = $expSK[2] . "-" . $expSK[1] . "-" . $expSK[0];
            $NomerSK = $DataPegawai['NomorSK'];

            $TanggalLahir = $DataPegawai['TanggalLahir'];
            $exp = explode('-', $TanggalLahir);
            $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            $UmurSekarang = $DataPegawai['UmurPeg'];

            $TanggalPensiun = $DataPegawai['TanggalPensiun'];
            $exp1 = explode('-', $TanggalPensiun);
            $ViewTglPensiun = $exp1[2] . "-" . $exp1[1] . "-" . $exp1[0];

            //HITUNG DETAIL TANGGAL PENSIUN
            $TglPensiun = date_create($TanggalPensiun);
            $TglSekarang = date_create();
            $Temp = date_diff($TglSekarang, $TglPensiun);

            //CEK TANGGAL ASLI SAAT INI
            $TglSekarang1 = Date('Y-m-d');

            if ($TglSekarang1 >= $TanggalPensiun) {
                $HasilTahun = 0 . ' Tahun ';
                $HasilBulan = 0 . ' Bulan ';
                $HasilHari = 0 . ' Hari ';
            } elseif ($TglSekarang1 < $TanggalPensiun) {
                $HasilTahun = $Temp->y . ' Tahun ';
                $HasilBulan = $Temp->m . ' Bulan ';
                $HasilHari = $Temp->d + 1 . ' Hari ';
            }
            //SELESAI

            $JenKel = $DataPegawai['JenKel'];
            $NamaDesa = $DataPegawai['NamaDesa'];
            $Kecamatan = $DataPegawai['Kecamatan'];
            $Kabupaten = $DataPegawai['Kabupaten'];
            $Alamat = $DataPegawai['Alamat'];
            $RT = $DataPegawai['RT'];
            $RW = $DataPegawai['RW'];

            $Lingkungan = $DataPegawai['Lingkungan'];
            $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
            $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
            $Komunitas = $LingkunganBPD['NamaDesa'];

            $KecamatanBPD = $DataPegawai['Kec'];
            $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
            $KecamatanBPD = mysqli_fetch_assoc($AmbilKecamatan);
            $KomunitasKec = $KecamatanBPD['Kecamatan'];

            $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
            $Setting = $DataPegawai['Setting'];
            $content .= '<tr>
                            <td width="40" align="center">' . $Nomor . '</td>';
            if (empty($Foto)) {
                $content .=
                    '<td width="80" align="center">
                            <img src="../../../Vendor/Media/Pegawai/no-image.jpg" width="65" height="auto" align="center">
                        </td>';
            } else {
                $content .=
                    '<td width="80" align="center">
                            <img src="../../../Vendor/Media/Pegawai/' . $Foto . '" width="65" height="auto" align="center">
                     </td>';
            }
            $content .= '<td width="130">' . $NIK . '</td>
                        <td width="280">
                            <strong>' . $Nama . '</strong><br>
                            <strong>' . $Jabatan . '</strong><br><br>' . $Address .
                '</td>
                <td width="100" align="center">' . $ViewTglLahir;
            $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
            $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
            $JenisKelamin = $DataJenKel['Keterangan'];
            $content .= '<br>' . $JenisKelamin .
                '</td>
                <td width="40" align="center">' . $UmurSekarang . '</td>
                <td width="70">' . $ViewTglPensiun . '<br><br>'
                . $HasilTahun . '<br>'
                . $HasilBulan . '<br>'
                . $HasilHari .
                '</td>';
            $QPendidikan = mysqli_query($db, "SELECT
                    history_pendidikan.IdPegawaiFK,
                    history_pendidikan.IdPendidikanFK,
                    master_pendidikan.IdPendidikan,
                    master_pendidikan.JenisPendidikan,
                    history_pendidikan.Setting
                    FROM
                    history_pendidikan
                    INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
                    WHERE history_pendidikan.IdPegawaiFK = '$IdPegawaiFK' AND  history_pendidikan.Setting=1 ");
            $DataPendidikan = mysqli_fetch_assoc($QPendidikan);
            $Pendidikan = $DataPendidikan['JenisPendidikan'];
            $content .= '<td align="center">' . $Pendidikan . '</td>
            <td><span style="color:blue">' . $TanggalSK . '</span><br>
                <strong>' . $NomerSK .
                '</strong>
            </td>
            <td width="100">' . $NamaDesa . '<br>'
                . $Kecamatan . '<br>'
                . $Kabupaten .
                '</td>';

            $content .= '</tr>';
            $Nomor++;
        }
        $content .= '</tbody>
                </table>
                </body>
                </html>';
    } elseif ($AmbilJabatan == 2) {
        $Jabatan = "Perangkat Desa";
        $content =
            '<html>
            <body>
            <h5>Filter Data Kecamatan ' . $NamaKecamatan . ' Jabatan ' . $Jabatan . ' Dari Umur ' . $UmurAwal . ' Sampai ' . $UmurAkhir . ' Tahun <br>Kabupaten ' . $Kabupaten . ' <br>Pertanggal ' . $Tanggal_Cetak . ' Pukul ' . $Waktu_Cetak . ' WIB</h5>
                <table  border="0.3" cellpadding="2" cellspacing="0" width="100%">
                    <thead>
                        <tr align="center">
                            <th><strong>No</strong></th>
                            <th><strong>Foto</strong></th>
                            <th><strong>NIK</strong></th>
                            <th><strong>Nama<br>Jabatan<br>Alamat</strong></th>
                            <th><strong>Tanggal Lahir<br>Jenis Kelamin</strong></th>
                            <th><strong>Umur</strong></th>
                            <th><strong>Tanggal <br>Pensiun</strong></th>
                            <th><strong>Pendidikan <br>Terakhir</strong></th>
                            <th><strong>Tanggal/SK Mutasi</strong></th>
                            <th><strong>Unit Kerja<br>Kecamatan<br>Kabupaten</strong></th>
                        </tr>
                    </thead>
                    <tbody>';
        $Nomor = 1;
        $QueryPegawai = mysqli_query($db, "SELECT
                                                master_pegawai.IdPegawaiFK,
                                                master_pegawai.Foto,
                                                master_pegawai.NIK,
                                                master_pegawai.Nama,
                                                master_pegawai.TanggalLahir,
                                                TIMESTAMPDIFF(YEAR, master_pegawai.TanggalLahir, CURDATE()) AS UmurPeg,
                                                master_pegawai.JenKel,
                                                master_pegawai.IdDesaFK,
                                                master_pegawai.Alamat,
                                                master_pegawai.RT,
                                                master_pegawai.RW,
                                                master_pegawai.Lingkungan,
                                                master_pegawai.Kecamatan AS Kec,
                                                master_pegawai.Kabupaten,
                                                master_pegawai.Setting,
                                                master_pegawai.TanggalPensiun,
                                                master_desa.IdDesa,
                                                master_desa.NamaDesa,
                                                master_desa.IdKecamatanFK,
                                                master_kecamatan.IdKecamatan,
                                                master_kecamatan.Kecamatan,
                                                master_kecamatan.IdKabupatenFK,
                                                master_setting_profile_dinas.IdKabupatenProfile,
                                                master_setting_profile_dinas.Kabupaten,
                                                main_user.IdPegawai,
                                                main_user.IdLevelUserFK,
                                                history_mutasi.IdPegawaiFK,
                                                history_mutasi.Setting,
                                                master_jabatan.IdJabatan,
                                                history_mutasi.IdJabatanFK,
                                                master_jabatan.Jabatan,
                                                history_mutasi.NomorSK,
                                                history_mutasi.TanggalMutasi,
                                                master_pegawai.Siltap
                                            FROM
                                                master_pegawai
                                                LEFT JOIN
                                                master_desa
                                                ON
                                                    master_pegawai.IdDesaFK = master_desa.IdDesa
                                                LEFT JOIN
                                                master_kecamatan
                                                ON
                                                    master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                                                LEFT JOIN
                                                master_setting_profile_dinas
                                                ON
                                                    master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
                                                INNER JOIN
                                                main_user
                                                ON
                                                    main_user.IdPegawai = master_pegawai.IdPegawaiFK
                                                INNER JOIN
                                                history_mutasi
                                                ON
                                                    master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                                                INNER JOIN
                                                master_jabatan
                                                ON
                                                    history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                                            WHERE
                                                master_pegawai.Setting = 1 AND
                                                main_user.IdLevelUserFK <> 1 AND
                                                main_user.IdLevelUserFK <> 2 AND
                                                history_mutasi.Setting = 1 AND
                                                history_mutasi.IdJabatanFK <> 1 AND
                                                TIMESTAMPDIFF(YEAR, master_pegawai.TanggalLahir, CURDATE()) BETWEEN '$UmurAwal' AND '$UmurAkhir' AND
                                                master_kecamatan.IdKecamatan = '$Kecamatan'
                                            ORDER BY
                                                master_pegawai.TanggalPensiun ASC");
        while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
            $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
            $Foto = $DataPegawai['Foto'];
            $NIK = $DataPegawai['NIK'];
            $Nama = $DataPegawai['Nama'];
            $Jabatan = $DataPegawai['Jabatan'];
            $AmbilTanggalSK = $DataPegawai['TanggalMutasi'];
            $expSK = explode('-', $AmbilTanggalSK);
            $TanggalSK = $expSK[2] . "-" . $expSK[1] . "-" . $expSK[0];
            $NomerSK = $DataPegawai['NomorSK'];

            $TanggalLahir = $DataPegawai['TanggalLahir'];
            $exp = explode('-', $TanggalLahir);
            $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            $UmurSekarang = $DataPegawai['UmurPeg'];

            $TanggalPensiun = $DataPegawai['TanggalPensiun'];
            $exp1 = explode('-', $TanggalPensiun);
            $ViewTglPensiun = $exp1[2] . "-" . $exp1[1] . "-" . $exp1[0];

            //HITUNG DETAIL TANGGAL PENSIUN
            $TglPensiun = date_create($TanggalPensiun);
            $TglSekarang = date_create();
            $Temp = date_diff($TglSekarang, $TglPensiun);

            //CEK TANGGAL ASLI SAAT INI
            $TglSekarang1 = Date('Y-m-d');

            if ($TglSekarang1 >= $TanggalPensiun) {
                $HasilTahun = 0 . ' Tahun ';
                $HasilBulan = 0 . ' Bulan ';
                $HasilHari = 0 . ' Hari ';
            } elseif ($TglSekarang1 < $TanggalPensiun) {
                $HasilTahun = $Temp->y . ' Tahun ';
                $HasilBulan = $Temp->m . ' Bulan ';
                $HasilHari = $Temp->d + 1 . ' Hari ';
            }
            //SELESAI

            $JenKel = $DataPegawai['JenKel'];
            $NamaDesa = $DataPegawai['NamaDesa'];
            $Kecamatan = $DataPegawai['Kecamatan'];
            $Kabupaten = $DataPegawai['Kabupaten'];
            $Alamat = $DataPegawai['Alamat'];
            $RT = $DataPegawai['RT'];
            $RW = $DataPegawai['RW'];

            $Lingkungan = $DataPegawai['Lingkungan'];
            $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
            $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
            $Komunitas = $LingkunganBPD['NamaDesa'];

            $KecamatanBPD = $DataPegawai['Kec'];
            $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
            $KecamatanBPD = mysqli_fetch_assoc($AmbilKecamatan);
            $KomunitasKec = $KecamatanBPD['Kecamatan'];

            $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
            $Setting = $DataPegawai['Setting'];
            $content .= '<tr>
                            <td width="40" align="center">' . $Nomor . '</td>';
            if (empty($Foto)) {
                $content .=
                    '<td width="80" align="center">
                            <img src="../../../Vendor/Media/Pegawai/no-image.jpg" width="65" height="auto" align="center">
                        </td>';
            } else {
                $content .=
                    '<td width="80" align="center">
                            <img src="../../../Vendor/Media/Pegawai/' . $Foto . '" width="65" height="auto" align="center">
                     </td>';
            }
            $content .= '<td width="130">' . $NIK . '</td>
                        <td width="280">
                            <strong>' . $Nama . '</strong><br>
                            <strong>' . $Jabatan . '</strong><br><br>' . $Address .
                '</td>
                <td width="100" align="center">' . $ViewTglLahir;
            $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
            $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
            $JenisKelamin = $DataJenKel['Keterangan'];
            $content .= '<br>' . $JenisKelamin .
                '</td>
                <td width="40" align="center">' . $UmurSekarang . '</td>
                <td width="70">' . $ViewTglPensiun . '<br><br>'
                . $HasilTahun . '<br>'
                . $HasilBulan . '<br>'
                . $HasilHari .
                '</td>';
            $QPendidikan = mysqli_query($db, "SELECT
                    history_pendidikan.IdPegawaiFK,
                    history_pendidikan.IdPendidikanFK,
                    master_pendidikan.IdPendidikan,
                    master_pendidikan.JenisPendidikan,
                    history_pendidikan.Setting
                    FROM
                    history_pendidikan
                    INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
                    WHERE history_pendidikan.IdPegawaiFK = '$IdPegawaiFK' AND  history_pendidikan.Setting=1 ");
            $DataPendidikan = mysqli_fetch_assoc($QPendidikan);
            $Pendidikan = $DataPendidikan['JenisPendidikan'];
            $content .= '<td align="center">' . $Pendidikan . '</td>
            <td><span style="color:blue">' . $TanggalSK . '</span><br>
                <strong>' . $NomerSK .
                '</strong>
            </td>
            <td width="100">' . $NamaDesa . '<br>'
                . $Kecamatan . '<br>'
                . $Kabupaten .
                '</td>';

            $content .= '</tr>';
            $Nomor++;
        }
        $content .= '</tbody>
                </table>
                </body>
                </html>';
    }
}

require_once('../../../Vendor/html2pdf/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;

$content2pdf = new Html2Pdf('L', 'F4', 'fr', true, 'UTF-8', array(10, 15, 15, 15), false);
$content2pdf->writeHTML($content);
// $html2pdf->output();
$content2pdf->Output('Data Perangkat Desa Kecamatan ' . " " . $NamaKecamatan . '_' . $DateCetak . '.pdf', 'I'); //NAMA FILE, I/D/F/S
?>
<!--  KETERANGAN OUTPUT
 “I” mengirim file untuk ditampilkan di browser.
 “D” mengirim file ke browser dan memaksa download file.
 “F” simpan ke file server lokal.
 “S” mengembalikan dokumen sebagai string. -->