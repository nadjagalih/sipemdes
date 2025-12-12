<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include '../../../Module/Config/Env.php';

$Tanggal_Cetak = date('d-m-Y');
$Waktu_Cetak = date('H:i:s');
$DateCetak = $Tanggal_Cetak . "_" . $Waktu_Cetak;

$QProfile = mysqli_query($db, "SELECT * FROM master_Setting_profile_dinas");
$DataProfile = mysqli_fetch_assoc($QProfile);
$Kabupaten = $DataProfile['Kabupaten'];



$content = '<html>
                <body>
                <h4>Data Pemerintah Desa Terkini Kabupaten ' . $Kabupaten . " " . '<br>Pertanggal ' . $Tanggal_Cetak . ' Pukul ' . $Waktu_Cetak . ' WIB</h4>
                <table  border="0.3" cellpadding="2" cellspacing="0" width="100%">
                    <thead>
                        <tr align="center">
                            <th width="40"><strong><font size="12">No</font></strong></th>
                            <th width="400"><strong><font size="12">Jabatan</font></strong></th>
                            <th width="50" align="center"><strong><font size="12">Jumlah</font></strong></th>
                        </tr>
                    </thead>
                    <tbody>';

$Nomor = 1;
$QJabatan = mysqli_query($db, "SELECT * FROM master_jabatan ORDER BY IdJabatan");
while ($DataJabatan = mysqli_fetch_assoc($QJabatan)) {
    $IdJabatan = $DataJabatan['IdJabatan'];
    $Jabatan = $DataJabatan['Jabatan'];
    $content .= '<tr>
                    <td align="center">' . $Nomor . '</td>
                    <td>' . $Jabatan . '</td>
                    <td align="center">';
    $QMutasi = mysqli_query($db, "SELECT count(IdPegawaiFK) AS Jumlah, IdJabatanFK, Setting FROM history_mutasi
                    WHERE
                    Setting = 1 AND
                    JenisMutasi <> 3 AND
                    JenisMutasi <> 4 AND
                    JenisMutasi <> 5 AND
                    IdJabatanFK = '$IdJabatan'
                    GROUP BY IdJabatanFK");
    while ($Mutasi = mysqli_fetch_assoc($QMutasi)) {
        $Jumlah = $Mutasi['Jumlah'];
        $content .= $Jumlah;
    };
    $content .= '</td>
                       </tr>';
    $Nomor++;
}
$content .= '</tbody>
            </table>
            </body>
            </html>';

require_once('../../../Vendor/html2pdf/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;

$content2pdf = new Html2Pdf('L', 'F4', 'fr', true, 'UTF-8', array(15, 15, 15, 15), false);
$content2pdf->writeHTML($content);
// $html2pdf->output();
$content2pdf->Output('Data Terkini Perangkat Desa Kabupaten ' . $Kabupaten . '_' . $DateCetak . '.pdf', 'I'); //NAMA FILE, I/D/F/S
?>

<!--  KETERANGAN OUTPUT
 “I” mengirim file untuk ditampilkan di browser.
 “D” mengirim file ke browser dan memaksa download file.
 “F” simpan ke file server lokal.
 “S” mengembalikan dokumen sebagai string. -->