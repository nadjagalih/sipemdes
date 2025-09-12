<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include '../../../../Module/Config/Env.php';

$Tanggal_Cetak = date('d-m-Y');
$Waktu_Cetak = date('H:i:s');
$DateCetak = $Tanggal_Cetak . "_" . $Waktu_Cetak;

$IdDesa = $_SESSION['IdDesa'];

$QueryDesa = mysqli_query($db, "SELECT
master_kecamatan.IdKecamatan,
master_desa.IdKecamatanFK,
master_desa.IdDesa,
master_desa.NamaDesa,
master_kecamatan.Kecamatan
FROM
master_desa
INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
WHERE master_desa.IdDesa ='$IdDesa' ");
$DataDesa = mysqli_fetch_assoc($QueryDesa);
$NamaDesa = $DataDesa['NamaDesa'];
$IdKec = $DataDesa['IdKecamatan'];
$NamaKecamatan = $DataDesa['Kecamatan'];

$QProfile = mysqli_query($db, "SELECT * FROM master_setting_profile_dinas");
$DataProfile = mysqli_fetch_assoc($QProfile);
$Kabupaten = $DataProfile['Kabupaten'];

$content = '<html>
                <body>
                <h4>Data Terkini Pemerintah Desa ' . $NamaDesa . ' Kecamatan' . " " . $NamaKecamatan . ' Kabupaten ' . $Kabupaten . '<br>Pertanggal ' . $Tanggal_Cetak . ' Pukul ' . $Waktu_Cetak . ' WIB</h4>
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

    $QMutasi = mysqli_query($db, "SELECT
                            history_mutasi.IdPegawaiFK,
                            Count(history_mutasi.IdPegawaiFK) AS JmlJbatan,
                            master_pegawai.IdPegawaiFK,
                            history_mutasi.JenisMutasi,
                            history_mutasi.Setting,
                            master_pegawai.Setting,
                            master_pegawai.IdDesaFK,
                            master_desa.IdDesa,
                            master_desa.IdKecamatanFK,
                            master_kecamatan.IdKecamatan,
                            master_desa.NamaDesa,
                            master_kecamatan.Kecamatan,
                            history_mutasi.IdJabatanFK
                            FROM history_mutasi
                            INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                            INNER JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                            INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                            WHERE
                            history_mutasi.IdJabatanFK = '$IdJabatan' AND
                            history_mutasi.JenisMutasi <> 3 AND
                            history_mutasi.JenisMutasi <> 4 AND
                            history_mutasi.JenisMutasi <> 5 AND
                            history_mutasi.Setting = 1 AND
                            master_pegawai.Setting = 1 AND
                            master_desa.IdKecamatanFK = '$IdKec' AND
                            master_desa.IdDesa = '$IdDesa' AND
                            master_pegawai.Setting = 1
                            GROUP BY
                            history_mutasi.IdPegawaiFK");
    while ($Mutasi = mysqli_fetch_assoc($QMutasi)) {
        $Jumlah = $Mutasi['JmlJbatan'];
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


require_once('../../../../Vendor/html2pdf/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;

$content2pdf = new Html2Pdf('L', 'F4', 'fr', true, 'UTF-8', array(15, 15, 15, 15), false);
$content2pdf->writeHTML($content);
// $html2pdf->output();
$content2pdf->Output('Data Terkini Perangkat Desa ' . $NamaDesa . ' Kecamatan ' . " " . $NamaKecamatan . '_' . $DateCetak . '.pdf', 'I'); //NAMA FILE, I/D/F/S
?>

<!--  KETERANGAN OUTPUT
 “I” mengirim file untuk ditampilkan di browser.
 “D” mengirim file ke browser dan memaksa download file.
 “F” simpan ke file server lokal.
 “S” mengembalikan dokumen sebagai string. -->