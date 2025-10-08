<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include '../../../Module/Config/Env.php';

$Tanggal_Cetak = date('d-m-Y');
$Waktu_Cetak = date('H:i:s');
$DateCetak = $Tanggal_Cetak . "_" . $Waktu_Cetak;

if (isset($_GET['Proses'])) {
    $Kecamatan = sql_injeksi($_GET['Kecamatan']);
    $Desa = sql_injeksi($_GET['Desa']);

    $QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa ='$Desa' ");
    $DataDesa = mysqli_fetch_assoc($QueryDesa);
    $NamaDesa = $DataDesa['NamaDesa'];

    $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$Kecamatan' ");
    $DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
    $NamaKecamatan = $DataKecamatan['Kecamatan'];

    $content =
        '<html>
            <body>
            <h4>Data Mutasi Desa ' . $NamaDesa . ' Kecamatan' . " " . $NamaKecamatan . '<br>Pertanggal ' . $Tanggal_Cetak . ' Pukul ' . $Waktu_Cetak . ' WIB</h4>
                <table  border="0.3" cellpadding="2" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th align="center">No</th>
                            <th align="center">Foto</th>
                            <th align="center">NIK</th>
                            <th align="center">Nama</th>
                            <th align="center">Tanggal Lahir<br>Jenis Kelamin</th>
                            <th align="center">Jenis Mutasi</th>
                            <th align="center">Jabatan</th>
                            <th align="center">Unit Kerja<br>Kecamatan<br>Kabupaten</th>
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
                                    master_pegawai.Setting,
                                    master_desa.IdDesa,
                                    master_desa.NamaDesa,
                                    master_desa.IdKecamatanFK,
                                    master_kecamatan.IdKecamatan,
                                    master_kecamatan.Kecamatan,
                                    master_kecamatan.IdKabupatenFK,
                                    master_setting_profile_dinas.IdKabupatenProfile,
                                    master_setting_profile_dinas.Kabupaten,
                                    main_user.IdPegawai,
                                    main_user.IdLevelUserFK
                                    FROM
                                    master_pegawai
                                    LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                                    LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                                    LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
                                    INNER JOIN main_user ON master_pegawai.IdPegawaiFK = main_user.IdPegawai
                                    WHERE main_user.IdLevelUserFK <> 1 and
                                    main_user.IdLevelUserFK <> 2 and
                                    master_kecamatan.IdKecamatan = '$Kecamatan' AND
                                    master_pegawai.IdDesaFK = '$Desa'
                                    ORDER BY
                                    master_kecamatan.IdKecamatan ASC,
                                    master_desa.NamaDesa ASC");
    while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
        $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
        $Foto = $DataPegawai['Foto'];
        $NIK = $DataPegawai['NIK'];
        $Nama = $DataPegawai['Nama'];
        $TanggalLahir = $DataPegawai['TanggalLahir'];
        $exp = explode('-', $TanggalLahir);
        $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
        $JenKel = $DataPegawai['JenKel'];
        $NamaDesa = $DataPegawai['NamaDesa'];
        $Kecamatan = $DataPegawai['Kecamatan'];
        $Kabupaten = $DataPegawai['Kabupaten'];

        $content .=
            '<tr>
                <td width="60" align="center">' . $Nomor . '</td>';
        if (empty($Foto)) {
            $content .=
                '<td width="100" align="center">
                <img src="../../../Vendor/Media/Pegawai/no-image.jpg" width="65" height="auto" align="center">
            </td>';
        } else {
            $content .=
                '<td width="100" align="center">
                    <img src="../../../Vendor/Media/Pegawai/' . $Foto . '" width="65" height="auto" align="center">
                </td>';
        }
        $content .=
            '<td width="140"><strong>' . $NIK . '</strong></td>
            <td width="240">' . $Nama . '</td>';
        $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
        $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
        $JenisKelamin = $DataJenKel['Keterangan'];

        $content .= '<td width="100" align="center">' . $ViewTglLahir . '<br>' . $JenisKelamin . '</td>';

        $content .= '<td width="80" align="center">';

        $QMutasi = mysqli_query($db, "SELECT
        history_mutasi.JenisMutasi,
        master_mutasi.IdMutasi,
        master_mutasi.Mutasi,
        history_mutasi.TanggalMutasi,
        history_mutasi.IdMutasi,
        history_mutasi.Setting
        FROM
        history_mutasi
        INNER JOIN master_mutasi ON history_mutasi.JenisMutasi = master_mutasi.IdMutasi
        WHERE IdPegawaiFK = '$IdPegawaiFK'
        ORDER BY history_mutasi.IdMutasi DESC, history_mutasi.TanggalMutasi DESC");
        while ($DataMutasi = mysqli_fetch_assoc($QMutasi)) {
            $JenjangMutasi = $DataMutasi['Mutasi'];
            $SettingMutasi = $DataMutasi['Setting'];
            if ($SettingMutasi == 0) {
                $content .= $JenjangMutasi;
            } elseif ($SettingMutasi == 1) {
                $content .= '<span class="label label-success float-left" style="color:blue"><strong>' . $JenjangMutasi . '</strong></span>';
            }
        };
        $content .= '</td>';
        $content .= '<td width="280" align="left">';
        $Id = 1;
        $QJabatan = mysqli_query($db, "SELECT
            history_mutasi.IdJabatanFK,
            master_jabatan.IdJabatan,
            master_jabatan.Jabatan,
            history_mutasi.TanggalMutasi,
            history_mutasi.IdMutasi,
            history_mutasi.JenisMutasi,
            history_mutasi.Setting
            FROM history_mutasi
            INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
            WHERE IdPegawaiFK = '$IdPegawaiFK'
            ORDER BY history_mutasi.IdMutasi DESC, history_mutasi.TanggalMutasi DESC");
        while ($DataJabatan = mysqli_fetch_assoc($QJabatan)) {
            $JenjangJabatan = $DataJabatan['Jabatan'];
            $SettingJabatan = $DataJabatan['Setting'];
            if ($SettingJabatan == 0) {
                $content .= $Id . '.' . $JenjangJabatan;
            } elseif ($SettingJabatan == 1) {
                $content .= '<span class="label label-success float-left" style="color:blue"><strong>' . $Id . '.' . $JenjangJabatan . '</strong></span>';
            }
            $Id++;
            $content .= '<br>';
        };
        $content .= '</td>';

        $content .= '<td width="120">' . $NamaDesa . '<br>'
            . $Kecamatan . '<br>'
            . $Kabupaten . '
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

$content2pdf = new Html2Pdf('L', 'F4', 'fr', true, 'UTF-8', array(10, 15, 15, 15), false);
$content2pdf->writeHTML($content);
// $html2pdf->output();
$content2pdf->Output('Data Mutasi Kecamatan ' . " " . $NamaKecamatan . '_' . $DateCetak . '.pdf', 'I'); //NAMA FILE, I/D/F/S
?>
<!--  KETERANGAN OUTPUT
 “I” mengirim file untuk ditampilkan di browser.
 “D” mengirim file ke browser dan memaksa download file.
 “F” simpan ke file server lokal.
 “S” mengembalikan dokumen sebagai string. -->