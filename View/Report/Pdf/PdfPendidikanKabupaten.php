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

$content =
    '<html>
            <body>
            <h4>Rekap Pendidikan Pemerintah Desa Kabupaten' . " " . $Kabupaten . '<br>Pertanggal ' . $Tanggal_Cetak . ' Pukul ' . $Waktu_Cetak . ' WIB</h4>
                <table  border="0.3" cellpadding="2" cellspacing="0" width="100%">
                    <thead>
                    <tr align="center">
                        <th width="40">No</th>
                        <th width="120">Pendidikan</th>
                        <th width="50">Jumlah</th>
                    </tr>
                    </thead>
                    <tbody>';
$Nomor = 1;
$QueryPendidikan = mysqli_query($db, "SELECT
                    history_pendidikan.IdPendidikanFK,
                    history_pendidikan.Setting,
                    master_pendidikan.IdPendidikan,
                    master_pendidikan.JenisPendidikan,
                    history_pendidikan.IdPegawaiFK,
                    master_pegawai.Setting,
                    master_pegawai.IdPegawaiFK,
                    Count(history_pendidikan.IdPegawaiFK) AS JmlPendidikan,
                    history_mutasi.Setting AS SettingMut
                    FROM
                    history_pendidikan
                    INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
                    INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = history_pendidikan.IdPegawaiFK
                    INNER JOIN history_mutasi ON history_pendidikan.IdPegawaiFK = history_mutasi.IdPegawaiFK
                    WHERE
                    history_pendidikan.Setting = 1 AND
                    master_pegawai.Setting = 1 AND
                    history_mutasi.Setting = 1
                    GROUP BY
                    history_pendidikan.IdPendidikanFK
                    ORDER BY
                    master_pendidikan.IdPendidikan ASC");
while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
    $IdPendidikan = $DataPendidikan['IdPendidikanFK'];
    $Pendidikan = $DataPendidikan['JenisPendidikan'];
    $Jumlah = $DataPendidikan['JmlPendidikan'];

    $content .=
        '<tr>
            <td align="center">' . $Nomor . '</td>
            <td>' . $Pendidikan . '</td>
            <td align="center"><strong>' . $Jumlah . '</strong><br><br></td>

        </tr>';
    $Nomor++;
}
$content .= '
          </tbody>
          </table>
          </body>
          </html>';

require_once('../../../Vendor/html2pdf/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;

$content2pdf = new Html2Pdf('L', 'F4', 'fr', true, 'UTF-8', array(15, 15, 15, 15), false);
$content2pdf->writeHTML($content);
// $html2pdf->output();
$content2pdf->Output('Rekap Pendidikan Perangkat Desa Kabupaten ' . " " . $Kabupaten . '_' . $DateCetak . '.pdf', 'I'); //NAMA FILE, I/D/F/S
?>

<!--  KETERANGAN OUTPUT
 “I” mengirim file untuk ditampilkan di browser.
 “D” mengirim file ke browser dan memaksa download file.
 “F” simpan ke file server lokal.
 “S” mengembalikan dokumen sebagai string. -->