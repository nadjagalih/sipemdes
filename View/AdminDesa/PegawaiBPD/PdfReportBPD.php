<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include '../../../Module/Config/Env.php';

$IdDesa = $_SESSION['IdDesa'];
$Tanggal_Cetak = date('d-m-Y');
$Waktu_Cetak = date('H:i:s');
$DateCetak = $Tanggal_Cetak . "_" . $Waktu_Cetak;

// Get Desa and Kecamatan information
$QueryDesa = mysqli_query($db, "SELECT 
    master_desa.NamaDesa,
    master_kecamatan.Kecamatan,
    master_setting_profile_dinas.Kabupaten
    FROM master_desa 
    LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
    LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
    WHERE master_desa.IdDesa = '$IdDesa'");
$DataDesa = mysqli_fetch_assoc($QueryDesa);
$NamaDesa = $DataDesa['NamaDesa'];
$NamaKecamatan = $DataDesa['Kecamatan'];
$NamaKabupaten = $DataDesa['Kabupaten'];

$content =
    '<html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; font-size: 12px; margin: 10px; }
                .table { width: 100%; border-collapse: collapse; }
                .table th { 
                    background-color: #337ab7; 
                    color: white; 
                    font-weight: bold; 
                    text-align: center; 
                    padding: 8px; 
                    border: 1px solid #ddd; 
                    font-size: 11px;
                }
                .table td { 
                    padding: 8px; 
                    border: 1px solid #ddd; 
                    vertical-align: top; 
                    font-size: 11px; 
                }
                .table-striped tbody tr:nth-of-type(odd) { background-color: #f9f9f9; }
                .text-center { text-align: center; }
                .foto { width: 40px; height: 50px; object-fit: cover; }
                h2 { text-align: center; font-size: 16px; margin-bottom: 10px; }
                .header-info { text-align: center; font-size: 12px; margin-bottom: 15px; }
            </style>
        </head>
        <body>
            <h2>Data BPD Desa ' . $NamaDesa . ' Kecamatan ' . $NamaKecamatan . '</h2>
            <div class="header-info">
                Kabupaten ' . $NamaKabupaten . '<br>
                Pertanggal ' . $Tanggal_Cetak . ' Pukul ' . $Waktu_Cetak . ' WIB
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 8%;">Foto</th>
                        <th style="width: 12%;">NIK</th>
                        <th style="width: 25%;">Nama<br>Alamat</th>
                        <th style="width: 15%;">Tanggal Lahir<br>Jenis Kelamin</th>
                        <th style="width: 10%;">No Telepon</th>
                        <th style="width: 15%;">Unit Kerja<br>Kecamatan<br>Kabupaten</th>
                        <th style="width: 10%;">Jabatan</th>
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
    master_pegawai_bpd.NoTelp,
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
    WHERE master_desa.IdDesa = '$IdDesa'
    ORDER BY master_kecamatan.IdKecamatan ASC, master_desa.NamaDesa ASC");

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
    $NoTelp = $DataPegawai['NoTelp'];
    $Lingkungan = $DataPegawai['Lingkungan'];

    // Query untuk mendapatkan data kecamatan BPD
    $KecamatanBPD = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '" . $DataPegawai['IdKecamatanFK'] . "'");
    $KecamatanBPD = mysqli_fetch_assoc($KecamatanBPD);
    $KomunitasKec = $KecamatanBPD['Kecamatan'];

    $Address = $Alamat . " RT." . $RT . "/RW." . $RW . "<br>Kecamatan " . $KomunitasKec;

    // Get gender
    $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
    $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
    $JenisKelamin = $DataJenKel['Keterangan'];

    // Default jabatan untuk BPD
    $Jabatan = 'Anggota BPD';

    // Foto path
    $FotoPath = '';
    if (empty($Foto)) {
        $FotoPath = '../../../Vendor/Media/Pegawai/no-image.jpg';
    } else {
        $FotoPath = '../../../Vendor/Media/Pegawai/' . $Foto;
    }

    $content .= '
        <tr>
            <td class="text-center">' . $Nomor . '</td>
            <td class="text-center">
                <img src="' . $FotoPath . '" class="foto">
            </td>
            <td class="text-center">' . $NIK . '</td>
            <td>
                <strong>' . $Nama . '</strong><br>
                ' . $Address . '
            </td>
            <td class="text-center">
                ' . $ViewTglLahir . '<br>
                ' . $JenisKelamin . '
            </td>
            <td class="text-center">' . (!empty($NoTelp) ? $NoTelp : '-') . '</td>
            <td class="text-center">
                ' . $NamaDesa . '<br>
                ' . $Kecamatan . '
            </td>
            <td class="text-center">' . $Jabatan . '</td>
        </tr>';

    $Nomor++;
}

$content .= '
                </tbody>
            </table>
        </body>
    </html>';

// Include TCPDF library
require_once('../../../Vendor/html2pdf/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
    $html2pdf = new Html2Pdf('L', 'A4', 'en');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->pdf->SetMargins(10, 10, 10);
    $html2pdf->writeHTML($content);
    $html2pdf->output('Data_BPD_' . $NamaDesa . '_' . $DateCetak . '.pdf');
} catch (Html2PdfException $e) {
    $html2pdf->clean();
    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
?>