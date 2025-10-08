<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include '../../../../Module/Config/Env.php';

$Tanggal_Cetak = date('d-m-Y');
$Waktu_Cetak = date('H:i:s');
$DateCetak = $Tanggal_Cetak . "_" . $Waktu_Cetak;

$IdDesa = $_SESSION['IdDesa'];

$QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa ='$IdDesa' ");
$DataDesa = mysqli_fetch_assoc($QueryDesa);
$NamaDesa = $DataDesa['NamaDesa'];
$Kecamatan = $DataDesa['IdKecamatanFK'];

$QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$Kecamatan' ");
$DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
$NamaKecamatan = $DataKecamatan['Kecamatan'];

$QProfile = mysqli_query($db, "SELECT * FROM master_setting_profile_dinas");
$DataProfile = mysqli_fetch_assoc($QProfile);
$Kabupaten = $DataProfile['Kabupaten'];

$content =
    '<html>
            <body>
            <h4>Data Pemerintah Desa ' . $NamaDesa . ' Kecamatan' . " " . $NamaKecamatan . ' <br>Kabupaten ' . $Kabupaten . '<br>Pertanggal ' . $Tanggal_Cetak . ' Pukul ' . $Waktu_Cetak . ' WIB</h4>
                <table  border="0.3" cellpadding="2" cellspacing="0" width="100%">
                    <thead>
                        <tr align="center">
                            <th><strong>No</strong></th>
                            <th><strong>Kecamatan<br>Desa<br>Kode Desa</strong></th>
                            <th><strong>Foto</strong></th>
                            <th><strong>Nama Pegawai<br>Alamat</strong></th>
                            <th><strong>Tgl Lahir<br>Jenis Kelamin</strong></th>
                            <th><strong>Pendidikan</strong></th>
                            <th><strong>SK Pengangkatan<br>Nomor<br>Tanggal</strong></th>
                            <th><strong>Jabatan<br>Keterangan Jabatan</strong></th>
                            <th><strong>Siltap (Rp.)</strong></th>
                            <th><strong>Telp</strong></th>
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
                            master_pegawai.JenKel,
                            master_pegawai.IdDesaFK,
                            master_pegawai.Alamat,
                            master_pegawai.RT,
                            master_pegawai.RW,
                            master_pegawai.Lingkungan,
                            master_pegawai.Kecamatan AS Kec,
                            master_pegawai.Kabupaten,
                            master_pegawai.Setting,
                            master_pegawai.Siltap,
                            master_pegawai.NoTelp,
                            master_desa.IdDesa,
                            master_desa.KodeDesa,
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
                            history_mutasi.NomorSK,
                            history_mutasi.TanggalMutasi,
                            history_mutasi.IdJabatanFK,
                            history_mutasi.KeteranganJabatan,
                            master_jabatan.IdJabatan,
                            master_jabatan.Jabatan
                            FROM
                            master_pegawai
                            LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                            LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                            LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
                            INNER JOIN main_user ON master_pegawai.IdPegawaiFK = main_user.IdPegawai
                            INNER JOIN history_mutasi ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                            INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                            WHERE
                            master_pegawai.Setting = 1 AND
                            main_user.IdLevelUserFK <> 1 AND
                            main_user.IdLevelUserFK <> 2 AND
                            master_pegawai.Kecamatan = '$Kecamatan' AND
                            master_pegawai.IdDesaFK = '$IdDesa'
                            GROUP BY
                            master_pegawai.IdPegawaiFK
                            ORDER BY
                            master_kecamatan.IdKecamatan ASC,
                            master_desa.NamaDesa ASC,
                            master_jabatan.IdJabatan ASC");
while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
    $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
    $Foto = $DataPegawai['Foto'];
    $NIK = $DataPegawai['NIK'];
    $Nama = $DataPegawai['Nama'];

    $TanggalLahir = $DataPegawai['TanggalLahir'];
    $exp = explode('-', $TanggalLahir);
    $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

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
    $KodeDesa = $DataPegawai['KodeDesa'];
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
    $JenisMutasi = $DataPegawai['JenisMutasi'];

    $TglSKMutasi = $DataPegawai['TanggalMutasi'];
    $exp2 = explode('-', $TglSKMutasi);
    $TanggalMutasi = $exp2[2] . "-" . $exp2[1] . "-" . $exp2[0];

    $NomorSK = $DataPegawai['NomorSK'];
    $SKMutasi = $DataPegawai['FileSKMutasi'];
    $Jabatan = $DataPegawai['Jabatan'];
    $KetJabatan = $DataPegawai['KeteranganJabatan'];
    $Siltap = number_Format($DataPegawai['Siltap'], 0, ",", ".");
    $Telp = $DataPegawai['NoTelp'];

    $content .=
        '<tr>
            <td width="40" align="center">' . $Nomor . '</td>';
    $content .=
        '<td width="110">' . $Kecamatan . '<br><strong>' . $NamaDesa . '</strong><br>' . $KodeDesa . '</td>';
    if (empty($Foto)) {
        $content .=
            '<td align="center">
                        <img src="../../../../Vendor/Media/Pegawai/no-image.jpg" width="65" height="auto" align="center">
                    </td>';
    } else {
        $content .=
            '<td align="center">
                    <img src="../../../../Vendor/Media/Pegawai/' . $Foto . '" width="65" height="auto" align="center">
                </td>';
    }
    $content .=
        '<td width="220"><strong><span style="font-size:14">' . $Nama . '</span></strong><br><br>' . $Address . '</td>
                    <td>' . $ViewTglLahir;
    $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
    $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
    $JenisKelamin = $DataJenKel['Keterangan'];

    $content .=
        '<br>' . $JenisKelamin . '</td>';
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
    $content .=
        '<td width="80">' . $Pendidikan . '</td>
                <td width="180"><span style="font-size:12">' . $NomorSK . '</span><br><br>' . $TanggalMutasi . '</td>
                <td width="140"><b>' . $Jabatan . '</b><br><br>' . $KetJabatan . '</td>
                <td width="80" align="right">' . $Siltap . '</td>
                <td width="110" align="left">' . $Telp . '</td>
            </tr>';
    $Nomor++;
}
$content .= '</tbody>
                </table>
                </body>
                </html>';

require_once('../../../../Vendor/html2pdf/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;

$content2pdf = new Html2Pdf('L', 'F4', 'fr', true, 'UTF-8', array(10, 15, 15, 15), false);
$content2pdf->writeHTML($content);
// $html2pdf->output();
$content2pdf->Output('Data Perangkat Desa ' . $NamaDesa . ' Kecamatan ' . " " . $NamaKecamatan . '_' . $DateCetak . '.pdf', 'I'); //NAMA FILE, I/D/F/S
?>

<!--  KETERANGAN OUTPUT
 “I” mengirim file untuk ditampilkan di browser.
 “D” mengirim file ke browser dan memaksa download file.
 “F” simpan ke file server lokal.
 “S” mengembalikan dokumen sebagai string. -->