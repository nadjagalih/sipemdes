<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Start output buffering to prevent premature output
ob_start();

include '../../../../Module/Config/Env.php';

$Tanggal_Cetak = date('d-m-Y');
$Waktu_Cetak = date('H:i:s');
$DateCetak = $Tanggal_Cetak . "_" . $Waktu_Cetak;

// if (isset($_GET['Kecamatan'])) {
if (isset($_GET['Desa'])) {
    $IdKec = $_SESSION['IdKecamatan'];
    // $Kecamatan = sql_injeksi($_GET['Kecamatan']);
    $Desa = sql_injeksi($_GET['Desa']);

    $QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa ='$Desa' ");
    $DataDesa = mysqli_fetch_assoc($QueryDesa);
    $NamaDesa = isset($DataDesa['NamaDesa']) ? $DataDesa['NamaDesa'] : '';

    $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$IdKec' ");
    $DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
    $NamaKecamatan = isset($DataKecamatan['Kecamatan']) ? $DataKecamatan['Kecamatan'] : '';

    $content =
        '<html>
            <body>
            <h4>Data Masa Pensiun Perangkat Desa' . " " . $NamaDesa . " " . 'Kecamatan' . " " . $NamaKecamatan . '<br>Pertanggal ' . $Tanggal_Cetak . ' Pukul ' . $Waktu_Cetak . ' WIB</h4>
                <table  border="0.3" cellpadding="2" cellspacing="0" width="100%">
                    <thead>
                        <tr align="center">
                            <th><strong><font size="12">No</font></strong></th>
                            <th><strong><font size="12">Foto</font></strong></th>
                            <th><strong><font size="12">NIK</font></strong></th>
                            <th><strong><font size="12">Nama<br>Jabatan<br>Alamat</font></strong></th>
                            <th><strong><font size="12">Tgl Lahir<br>Jenis Kelamin</font></strong></th>
                            <th><strong><font size="12">Tgl Pensiun</font></strong></th>
                            <th><strong><font size="12">Waktu <br>Pensiun</font></strong></th>
                            <th><strong><font size="12">Keterangan</font></strong></th>
                            <th><strong><font size="12">Unit Kerja<br>Kecamatan<br>Kabupaten</font></strong></th>
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
                                            master_jabatan.Jabatan
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
                                            master_pegawai.Kecamatan = '$IdKec' AND
                                            master_pegawai.IdDesaFK = '$Desa'
                                            ORDER BY master_pegawai.TanggalPensiun ASC");
    while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
        $IdPegawaiFK = isset($DataPegawai['IdPegawaiFK']) ? $DataPegawai['IdPegawaiFK'] : '';
        $Foto = isset($DataPegawai['Foto']) ? $DataPegawai['Foto'] : '';
        $NIK = isset($DataPegawai['NIK']) ? $DataPegawai['NIK'] : '';
        $Nama = isset($DataPegawai['Nama']) ? $DataPegawai['Nama'] : '';
        $Jabatan = isset($DataPegawai['Jabatan']) ? $DataPegawai['Jabatan'] : '';

        $TanggalLahir = isset($DataPegawai['TanggalLahir']) ? $DataPegawai['TanggalLahir'] : '';
        if (!empty($TanggalLahir)) {
            $exp = explode('-', $TanggalLahir);
            $ViewTglLahir = (isset($exp[2]) ? $exp[2] : '') . "-" . (isset($exp[1]) ? $exp[1] : '') . "-" . (isset($exp[0]) ? $exp[0] : '');
        } else {
            $ViewTglLahir = '';
        }

        $TanggalPensiun = isset($DataPegawai['TanggalPensiun']) ? $DataPegawai['TanggalPensiun'] : '';
        if (!empty($TanggalPensiun)) {
            $exp1 = explode('-', $TanggalPensiun);
            $ViewTglPensiun = (isset($exp1[2]) ? $exp1[2] : '') . "-" . (isset($exp1[1]) ? $exp1[1] : '') . "-" . (isset($exp1[0]) ? $exp1[0] : '');
        } else {
            $ViewTglPensiun = '';
        }

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

        $JenKel = isset($DataPegawai['JenKel']) ? $DataPegawai['JenKel'] : '';
        $NamaDesa = isset($DataPegawai['NamaDesa']) ? $DataPegawai['NamaDesa'] : '';
        $Kecamatan = isset($DataPegawai['Kecamatan']) ? $DataPegawai['Kecamatan'] : '';
        $Kabupaten = isset($DataPegawai['Kabupaten']) ? $DataPegawai['Kabupaten'] : '';
        $Alamat = isset($DataPegawai['Alamat']) ? $DataPegawai['Alamat'] : '';
        $RT = isset($DataPegawai['RT']) ? $DataPegawai['RT'] : '';
        $RW = isset($DataPegawai['RW']) ? $DataPegawai['RW'] : '';

        $Lingkungan = isset($DataPegawai['Lingkungan']) ? $DataPegawai['Lingkungan'] : '';
        $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
        $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
        $Komunitas = isset($LingkunganBPD['NamaDesa']) ? $LingkunganBPD['NamaDesa'] : '';

        $KecamatanBPD = $DataPegawai['Kec'];
        $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
        $KecamatanBPD = mysqli_fetch_assoc($AmbilKecamatan);
        $KomunitasKec = $KecamatanBPD['Kecamatan'];

        $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
        $Setting = $DataPegawai['Setting'];

        $content .=
            '<tr>
                    <td width="40" align="center">' . $Nomor . '</td>';
        
        // Cek apakah foto ada dan file benar-benar exist
        if (empty($Foto)) {
            $content .=
                '<td width="80" align="center">
                        <img src="../../../../Vendor/Media/Pegawai/no-image.jpg" width="65" height="auto" align="center">
                </td>';
        } else {
            // Cek apakah file foto benar-benar ada
            $fotoPath = __DIR__ . '/../../../../Vendor/Media/Pegawai/' . $Foto;
            if (file_exists($fotoPath)) {
                $content .=
                    '<td width="80" align="center">
                            <img src="../../../../Vendor/Media/Pegawai/' . htmlspecialchars($Foto) . '" width="65" height="auto" align="center">
                    </td>';
            } else {
                // Jika file tidak ada, gunakan no-image.jpg
                $content .=
                    '<td width="80" align="center">
                            <img src="../../../../Vendor/Media/Pegawai/no-image.jpg" width="65" height="auto" align="center">
                    </td>';
            }
        }
        $content .= '<td width="130">' . $NIK . '</td>
                      <td width="320"><strong><font size="12">' . $Nama . '</font></strong><br>' . $Jabatan . '<br><br>' . $Address . '</td>
                      <td width="90">' . $ViewTglLahir;
        $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
        $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
        $JenisKelamin = $DataJenKel['Keterangan'];

        $content .=
            '<br>' . $JenisKelamin . '</td>
                <td width="100">' . $ViewTglPensiun . '</td>
                <td width="100">' . $HasilTahun . '<br>' . $HasilBulan . '<br>' . $HasilHari . '</td>';

        if ($TglSekarang1 >= $TanggalPensiun and $Setting = 1) {
            $content .=
                '<td width="100">PENSIUN BELUM ADA SK</td>';
        } elseif ($TglSekarang1 < $TanggalPensiun) {
            $content .=
                '<td width="100">BELUM PENSIUN</td>';
        }

        $content .=
            '<td width="120">' . $NamaDesa . '<br>' . $Kecamatan . '<br>' . $Kabupaten . '</td>
            </tr>';
        $Nomor++;
    }
    $content .= '</tbody>
                </table>
                </body>
                </html>';
}
// }

require_once('../../../../Vendor/html2pdf/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;

// Clean any output buffer to prevent TCPDF errors
if (ob_get_level()) {
    ob_end_clean();
}

$content2pdf = new Html2Pdf('L', 'F4', 'fr');
$content2pdf->writeHTML($content);
// $html2pdf->output();
$content2pdf->Output('Data Masa Pensiun Perangkat Desa ' . $NamaDesa . ' Kecamatan ' . " " . $NamaKecamatan . '_' . $DateCetak . '.pdf', 'I');
?>

<!--  KETERANGAN OUTPUT
 “I” mengirim file untuk ditampilkan di browser.
 “D” mengirim file ke browser dan memaksa download file.
 “F” simpan ke file server lokal.
 “S” mengembalikan dokumen sebagai string. -->