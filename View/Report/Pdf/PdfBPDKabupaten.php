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
    <h4>Data BPD Kabupaten' . " " . $Kabupaten . '<br>Pertanggal ' . $Tanggal_Cetak . ' Pukul ' . $Waktu_Cetak . ' WIB</h4>
        <table  border="0.3" cellpadding="2" cellspacing="0" width="100%">
            <thead>
                <tr align="center">
                    <th width="50">No</th>
                    <th width="80">Foto</th>
                    <th width="150">NIK</th>
                    <th width="280">Nama<br>Alamat</th>
                    <th width="100">Tanggal Lahir<br>Jenis Kelamin</th>
                    <th width="200">Unit Kerja<br>Kecamatan<br>Kabupaten</th>
                </tr>
            </thead>
            <tbody>';
$Nomor = 1;
$QueryPegawai = mysqli_query($db, "SELECT
                    master_pegawai_bpd.IdPegawaiFK,
                    master_pegawai_bpd.Foto,
                    master_pegawai_bpd.NIK,
                    master_pegawai_bpd.Nama,
                    master_pegawai_bpd.TanggalLahir,
                    master_pegawai_bpd.JenKel,
                    master_pegawai_bpd.IdDesaFK,
                    master_pegawai_bpd.Alamat,
                    master_pegawai_bpd.RT,
                    master_pegawai_bpd.RW,
                    master_pegawai_bpd.Lingkungan,
                    master_pegawai_bpd.Kecamatan AS Kec,
                    master_pegawai_bpd.Kabupaten,
                    master_desa.IdDesa,
                    master_desa.NamaDesa,
                    master_desa.IdKecamatanFK,
                    master_kecamatan.IdKecamatan,
                    master_kecamatan.Kecamatan,
                    master_kecamatan.IdKabupatenFK,
                    master_setting_profile_dinas.IdKabupatenProfile,
                    master_setting_profile_dinas.Kabupaten
                    FROM master_pegawai_bpd
                    LEFT JOIN master_desa ON master_pegawai_bpd.IdDesaFK = master_desa.IdDesa
                    LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                    LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
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

    $content .=
        '<tr>
            <td align="center">' . $Nomor . '</td>';
    if (empty($Foto)) {
        $content .=
            '<td align="center">
                <img src="../../../Vendor/Media/Pegawai/no-image.jpg" width="65" height="auto" align="center">
            </td>';
    } else {
        $content .=
            '<td align="center">
                <img src="../../../Vendor/Media/Pegawai/' . $Foto . '" width="65" height="auto" align="center">
            </td>';
    }
    $content .= '<td>' . $NIK . '</td>
                <td><strong>' . $Nama . '</strong><br><br>' . $Address . '</td>
                <td>' . $ViewTglLahir . '<br>';
    $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
    $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
    $JenisKelamin = $DataJenKel['Keterangan'];
    $content .= $JenisKelamin;
    $content .= '</td>
            <td>' . $NamaDesa . '<br>' . $Kecamatan . '<br>' . $Kabupaten . '</td>
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
$content2pdf->Output('Data BPD Desa Kabupaten ' . " " . $Kabupaten . '_' . $DateCetak . '.pdf', 'I');
?>
<!--  KETERANGAN OUTPUT
 “I” mengirim file untuk ditampilkan di browser.
 “D” mengirim file ke browser dan memaksa download file.
 “F” simpan ke file server lokal.
 “S” mengembalikan dokumen sebagai string. -->