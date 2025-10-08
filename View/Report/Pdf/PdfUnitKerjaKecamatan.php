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

if (isset($_GET['Proses'])) {
    $Kecamatan = sql_injeksi($_GET['Kecamatan']);

    $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$Kecamatan' ");
    $DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
    $IdKecamatan = $DataKecamatan['IdKecamatan'];
    $NamaKecamatan = $DataKecamatan['Kecamatan'];

    $content = '<html><body>
        <h4><strong>Rekap Data Pemerintah Desa Kecamatan ' . $NamaKecamatan . '<br>Pertanggal ' . $Tanggal_Cetak . ' Pukul ' . $Waktu_Cetak . ' WIB</strong></h4>
        <table  border="0.3" cellpadding="2" cellspacing="0" width="100%">
            <thead>
                <tr align="center">
                    <th width="40">No</th>
                    <th width="200">Unit Kerja/Desa</th>
                    <th width="50">Jumlah</th>
                </tr>
            </thead>
            <tbody>';

    $Nomor = 1;
    $QueryPerangkat = mysqli_query($db, "SELECT
                            master_kecamatan.Kecamatan,
                            Count(master_pegawai.IdPegawaiFK) AS JmlPerangkat,
                            master_pegawai.IdPegawaiFK,
                            master_pegawai.Setting,
                            master_desa.IdDesa,
                            master_desa.NamaDesa,
                            master_desa.IdKecamatanFK,
                            master_kecamatan.IdKecamatan,
                            main_user.IdPegawai,
                            main_user.IdLevelUserFK,
                            history_mutasi.IdPegawaiFK,
                            history_mutasi.Setting AS SettingMutasi
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
                            INNER JOIN
                            main_user
                            ON
                                master_pegawai.IdPegawaiFK = main_user.IdPegawai
                            INNER JOIN
                            history_mutasi
                            ON
                                master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                        WHERE
                            master_pegawai.Setting = 1 AND
                            main_user.IdLevelUserFK <> 1 AND
                            main_user.IdLevelUserFK <> 2 AND
                            history_mutasi.Setting = 1 AND
                            master_desa.IdKecamatanFK = '$IdKecamatan'
                        GROUP BY
                        master_desa.NamaDesa
                        ORDER BY
                        master_desa.NamaDesa ASC");
    while ($DataPerangkat = mysqli_fetch_assoc($QueryPerangkat)) {
        $IdKecamatan = $DataPerangkat['IdKecamatanFK'];
        $NamaDesa = $DataPerangkat['NamaDesa'];
        $Jumlah = $DataPerangkat['JmlPerangkat'];

        $content .= '<tr>
                    <td align="center">' . $Nomor . '</td>
                    <td>' . $NamaDesa . '</td>
                    <td align="center"><strong>' . $Jumlah . '</strong>
                    </td>
                </tr>';
        $Nomor++;
    }
    $content .= '</tbody>
                </table>
                </body>
                </html>';
}

require_once('../../../Vendor/html2pdf/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;

$content2pdf = new Html2Pdf('L', 'F4', 'fr', true, 'UTF-8', array(15, 15, 15, 15), false);
$content2pdf->writeHTML($content);
// $html2pdf->output();
$content2pdf->Output('Rekap Jumlah Perangkat Desa Kecamatan ' . " " . $NamaKecamatan . '_' . $DateCetak . '.pdf', 'I'); //NAMA FILE, I/D/F/S
?>

<!--  KETERANGAN OUTPUT
 “I” mengirim file untuk ditampilkan di browser.
 “D” mengirim file ke browser dan memaksa download file.
 “F” simpan ke file server lokal.
 “S” mengembalikan dokumen sebagai string. -->