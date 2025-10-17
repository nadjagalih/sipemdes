<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include '../../../Module/Config/Env.php';
require_once('../../../Vendor/html2pdf/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;

$Tanggal_Cetak = date('d-m-Y');
$Waktu_Cetak = date('H:i:s');
$DateCetak = $Tanggal_Cetak . "_" . $Waktu_Cetak;

if (isset($_GET['Kecamatan']) && isset($_GET['Desa']) && !empty($_GET['Kecamatan']) && !empty($_GET['Desa'])) {
    $Kecamatan = sql_injeksi($_GET['Kecamatan']);
    $Desa = sql_injeksi($_GET['Desa']);

    $QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa ='$Desa' ");
    if ($QueryDesa && mysqli_num_rows($QueryDesa) > 0) {
        $DataDesa = mysqli_fetch_assoc($QueryDesa);
        $NamaDesa = isset($DataDesa['NamaDesa']) ? $DataDesa['NamaDesa'] : 'Tidak Diketahui';
    } else {
        $NamaDesa = 'Tidak Diketahui';
    }

    $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$Kecamatan' ");
    if ($QueryKecamatan && mysqli_num_rows($QueryKecamatan) > 0) {
        $DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
        $NamaKecamatan = isset($DataKecamatan['Kecamatan']) ? $DataKecamatan['Kecamatan'] : 'Tidak Diketahui';
    } else {
        $NamaKecamatan = 'Tidak Diketahui';
    }

        $content =
            '<html>
            <body>
            <h4>Data Kepala Desa & Perangkat Desa ' . $NamaDesa . ' Kecamatan' . " " . $NamaKecamatan . '<br>Pertanggal ' . $Tanggal_Cetak . ' Pukul ' . $Waktu_Cetak . ' WIB</h4>
                <table  border="0.3" cellpadding="2" cellspacing="0" width="100%">
                    <thead>
                        <tr align="center">
                            <th><strong>No</strong></th>
                            <th><strong>Kecamatan<br>Desa<br>Kode Desa</strong></th>
                            <th><strong>Foto</strong></th>
                            <th><strong>NIK</strong></th>
                            <th><strong>Nama Pegawai<br>Alamat</strong></th>
                            <th><strong>Tgl Lahir<br>Jenis Kelamin</strong></th>
                            <th><strong>Pendidikan</strong></th>
                            <th><strong>SK Pengangkatan<br>Nomor<br>Tanggal</strong></th>
                            <th><strong>Jabatan</strong></th>
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
                            history_mutasi.Setting,
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
                            history_mutasi.Setting = 1 AND
                            master_kecamatan.IdKecamatan = '$Kecamatan' AND
                            master_pegawai.IdDesaFK = '$Desa'
                            GROUP BY
                            master_pegawai.IdPegawaiFK
                            ORDER BY
                            master_kecamatan.IdKecamatan ASC,
                            master_desa.NamaDesa ASC,
                            history_mutasi.IdJabatanFK ASC");
        while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
            $IdPegawaiFK = isset($DataPegawai['IdPegawaiFK']) ? $DataPegawai['IdPegawaiFK'] : '';
            $Foto = isset($DataPegawai['Foto']) ? $DataPegawai['Foto'] : '';
            $NIK = isset($DataPegawai['NIK']) ? $DataPegawai['NIK'] : '';
            $Nama = isset($DataPegawai['Nama']) ? $DataPegawai['Nama'] : '';

            $TanggalLahir = isset($DataPegawai['TanggalLahir']) ? $DataPegawai['TanggalLahir'] : '';
            if (!empty($TanggalLahir)) {
                $exp = explode('-', $TanggalLahir);
                $ViewTglLahir = (isset($exp[2]) && isset($exp[1]) && isset($exp[0])) ? $exp[2] . "-" . $exp[1] . "-" . $exp[0] : $TanggalLahir;
            } else {
                $ViewTglLahir = '-';
            }

            $JenKel = isset($DataPegawai['JenKel']) ? $DataPegawai['JenKel'] : '';
            $KodeDesa = isset($DataPegawai['KodeDesa']) ? $DataPegawai['KodeDesa'] : '';
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

            $KecamatanBPD = isset($DataPegawai['Kec']) ? $DataPegawai['Kec'] : '';
            $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
            $KecamatanBPD = mysqli_fetch_assoc($AmbilKecamatan);
            $KomunitasKec = isset($KecamatanBPD['Kecamatan']) ? $KecamatanBPD['Kecamatan'] : '';

            $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
            $Setting = isset($DataPegawai['Setting']) ? $DataPegawai['Setting'] : '';

            $TglSKMutasi = isset($DataPegawai['TanggalMutasi']) ? $DataPegawai['TanggalMutasi'] : '';
            if (!empty($TglSKMutasi)) {
                $exp2 = explode('-', $TglSKMutasi);
                $TanggalMutasi = (isset($exp2[2]) && isset($exp2[1]) && isset($exp2[0])) ? $exp2[2] . "-" . $exp2[1] . "-" . $exp2[0] : $TglSKMutasi;
            } else {
                $TanggalMutasi = '-';
            }

            $NomorSK = isset($DataPegawai['NomorSK']) ? $DataPegawai['NomorSK'] : '';
            $Jabatan = isset($DataPegawai['Jabatan']) ? $DataPegawai['Jabatan'] : '';
            $KetJabatan = isset($DataPegawai['KeteranganJabatan']) ? $DataPegawai['KeteranganJabatan'] : '';
            $Siltap = isset($DataPegawai['Siltap']) ? number_format($DataPegawai['Siltap'], 0, ",", ".") : '0';
            $Telp = isset($DataPegawai['NoTelp']) ? $DataPegawai['NoTelp'] : '';

            $content .=
                '<tr>
                    <td width="40" align="center">' . $Nomor . '</td>';
            $content .=
                '<td width="90">' . $Kecamatan . '<br><strong>' . $NamaDesa . '</strong><br>' . $KodeDesa . '</td>';
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
            
            $content .=
                '<td width="130"><span style="font-size:1">' ."'" . '</span><span style="font-size:14">' . $NIK . '</span></td>';
            $content .=
                '<td width="170"><strong><span style="font-size:14">' . $Nama . '</span></strong><br><br>' . $Address . '</td>
                <td width="80">' . $ViewTglLahir;
            $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
            $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
            $JenisKelamin = isset($DataJenKel['Keterangan']) ? $DataJenKel['Keterangan'] : '-';

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
            $Pendidikan = isset($DataPendidikan['JenisPendidikan']) ? $DataPendidikan['JenisPendidikan'] : '-';
            $content .=
                '<td width="80">' . $Pendidikan . '</td>
                <td width="160"><span style="font-size:12">' . $NomorSK . '</span><br><br>' . $TanggalMutasi . '</td>
                <td width="130"><b>' . $Jabatan . '</b><br><br>' . $KetJabatan . '</td>
                <td width="60" align="right">' . $Siltap . '</td>
                <td width="100" align="left">' . $Telp . '</td>
            </tr>';
            $Nomor++;
        }
        $content .= '</tbody>
                </table>
                </body>
                </html>';

    try {
        $content2pdf = new Html2Pdf('L', 'F4', 'en');
        $content2pdf->writeHTML($content);
        $content2pdf->Output('Data Perangkat Desa ' . $NamaDesa . ' Kecamatan ' . " " . $NamaKecamatan . '_' . $DateCetak . '.pdf', 'I');
    } catch (Exception $e) {
        echo 'Error saat membuat PDF: ' . $e->getMessage();
    }
} else {
    echo 'Parameter tidak lengkap. Silakan pilih kecamatan dan desa terlebih dahulu.';
}
?>

<!--  KETERANGAN OUTPUT
 “I” mengirim file untuk ditampilkan di browser.
 “D” mengirim file ke browser dan memaksa download file.
 “F” simpan ke file server lokal.
 “S” mengembalikan dokumen sebagai string. -->