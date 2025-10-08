<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include '../../../Module/Config/Env.php';

$Tanggal_Cetak = date('d-m-Y');
$Waktu_Cetak = date('H:i:s');
$DateCetak = $Tanggal_Cetak . "_" . $Waktu_Cetak;

if (isset($_GET['Proses'])) {
    $Kecamatan = sql_injeksi($_GET['Kecamatan']);

    $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$Kecamatan' ");
    $DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
    $IdKecamatan = $DataKecamatan['IdKecamatan'];
    $NamaKecamatan = $DataKecamatan['Kecamatan'];

    $content = '<html>
                <body>
                <h4>Data Pemerintah Desa Terkini Kecamatan' . " " . $NamaKecamatan . '<br>Pertanggal ' . $Tanggal_Cetak . ' Pukul ' . $Waktu_Cetak . ' WIB</h4>
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
                            master_desa.IdKecamatanFK = '$Kecamatan'
                            GROUP BY
                            history_mutasi.IdJabatanFK");
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
}

require_once('../../../Vendor/html2pdf/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;

$content2pdf = new Html2Pdf('L', 'F4', 'fr', true, 'UTF-8', array(15, 15, 15, 15), false);
$content2pdf->writeHTML($content);
// $html2pdf->output();
$content2pdf->Output('Data Terkini Perangkat Desa Kecamatan ' . " " . $NamaKecamatan . '_' . $DateCetak . '.pdf', 'I'); //NAMA FILE, I/D/F/S
?>

<!--  KETERANGAN OUTPUT
 “I” mengirim file untuk ditampilkan di browser.
 “D” mengirim file ke browser dan memaksa download file.
 “F” simpan ke file server lokal.
 “S” mengembalikan dokumen sebagai string. -->