<?php
ob_start(); // Start output buffering to prevent any output before PDF generation
session_start();
error_reporting(0); // Disable all error reporting for PDF generation

include '../../../Module/Config/Env.php';

$Tanggal_Cetak = date('d-m-Y');
$Waktu_Cetak = date('H:i:s');
$DateCetak = $Tanggal_Cetak . "_" . $Waktu_Cetak;

$IdKec = $_SESSION['IdKecamatan'];

// Get filter parameter if exists
$filterDesa = isset($_GET['desa']) ? sql_injeksi($_GET['desa']) : '';

$QueryKecamatan = mysqli_query($db, "SELECT 
    master_kecamatan.*,
    master_setting_profile_dinas.Kabupaten
    FROM master_kecamatan 
    LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
    WHERE master_kecamatan.IdKecamatan = '$IdKec' ");
$DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
$NamaKecamatan = $DataKecamatan['Kecamatan'];
$NamaKabupaten = $DataKecamatan['Kabupaten'];

// Determine title based on filter
if (!empty($filterDesa)) {
    $QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE NamaDesa = '$filterDesa' AND IdKecamatanFK = '$IdKec' ");
    $DataDesa = mysqli_fetch_assoc($QueryDesa);
    $title = 'Data BPD ' . $filterDesa . ' Kecamatan ' . $NamaKecamatan;
    $filename = 'Data BPD Desa ' . $filterDesa . ' Kecamatan ' . $NamaKecamatan . '_' . $DateCetak;
} else {
    $title = 'Data BPD Kecamatan ' . $NamaKecamatan;
    $filename = 'Data BPD Kecamatan ' . $NamaKecamatan . '_' . $DateCetak;
}

$content = 
    '<html>
        <body>
        <h4>' . $title . '<br>Pertanggal ' . $Tanggal_Cetak . ' Pukul ' . $Waktu_Cetak . ' WIB</h4>
            <table border="0.3" cellpadding="2" cellspacing="0" width="100%">
                <thead>
                    <tr align="center">
                        <th><strong>No</strong></th>
                        <th><strong>Foto</strong></th>
                        <th><strong>NIK</strong></th>
                        <th><strong>Nama<br>Alamat</strong></th>
                        <th><strong>Tgl Lahir<br>Jenis Kelamin</strong></th>
                        <th><strong>Unit Kerja<br>Kecamatan<br>Kabupaten</strong></th>
                    </tr>
                </thead>
                <tbody>';

$Nomor = 1;

// Build query with optional filter
$whereClause = "master_kecamatan.IdKecamatan = '$IdKec'";

if (!empty($filterDesa)) {
    $whereClause .= " AND master_desa.NamaDesa = '$filterDesa'";
}

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
                    WHERE $whereClause
                    ORDER BY
                    master_kecamatan.IdKecamatan ASC,
                    master_desa.NamaDesa ASC");

while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
    $IdPegawaiFK = isset($DataPegawai['IdPegawaiFK']) ? $DataPegawai['IdPegawaiFK'] : '';
    $Foto = isset($DataPegawai['Foto']) ? $DataPegawai['Foto'] : '';
    $NIK = isset($DataPegawai['NIK']) ? $DataPegawai['NIK'] : '';
    $Nama = isset($DataPegawai['Nama']) ? $DataPegawai['Nama'] : '';

    // Date formatting
    $TanggalLahir = isset($DataPegawai['TanggalLahir']) ? $DataPegawai['TanggalLahir'] : '';
    $ViewTglLahir = !empty($TanggalLahir) ? date('d-m-Y', strtotime($TanggalLahir)) : '';

    $JenKel = isset($DataPegawai['JenKel']) ? $DataPegawai['JenKel'] : '';
    $NamaDesa = isset($DataPegawai['NamaDesa']) ? $DataPegawai['NamaDesa'] : '';
    $KecamatanData = isset($DataPegawai['Kecamatan']) ? $DataPegawai['Kecamatan'] : '';
    $KabupatenData = isset($DataPegawai['Kabupaten']) ? $DataPegawai['Kabupaten'] : '';
    $Alamat = isset($DataPegawai['Alamat']) ? $DataPegawai['Alamat'] : '';
    $RT = isset($DataPegawai['RT']) ? $DataPegawai['RT'] : '';
    $RW = isset($DataPegawai['RW']) ? $DataPegawai['RW'] : '';

    $Lingkungan = isset($DataPegawai['Lingkungan']) ? $DataPegawai['Lingkungan'] : '';
    $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
    $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
    $Komunitas = isset($LingkunganBPD['NamaDesa']) ? $LingkunganBPD['NamaDesa'] : '';

    $KecamatanBPD = isset($DataPegawai['Kec']) ? $DataPegawai['Kec'] : '';
    $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
    $KecamatanBPDData = mysqli_fetch_assoc($AmbilKecamatan);
    $KomunitasKec = isset($KecamatanBPDData['Kecamatan']) ? $KecamatanBPDData['Kecamatan'] : '';

    $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;

    $content .= '<tr>
                <td width="40" align="center">' . $Nomor . '</td>';
    
    // Handle foto dengan fallback yang sama
    if (empty($Foto)) {
        $content .= '<td width="80" align="center">
                        <img src="../../../Vendor/Media/Pegawai/no-image.jpg" width="65" height="auto" align="center">
                    </td>';
    } else {
        // Cek apakah file foto benar-benar ada
        $fotoPath = __DIR__ . '/../../../Vendor/Media/Pegawai/' . $Foto;
        if (file_exists($fotoPath)) {
            $content .= '<td width="80" align="center">
                        <img src="../../../Vendor/Media/Pegawai/' . htmlspecialchars($Foto) . '" width="65" height="auto" align="center">
                    </td>';
        } else {
            // Jika file tidak ada, gunakan no-image.jpg
            $content .= '<td width="80" align="center">
                        <img src="../../../Vendor/Media/Pegawai/no-image.jpg" width="65" height="auto" align="center">
                    </td>';
        }
    }
    
    $content .= '<td width="130">' . $NIK . '</td>
            <td width="280"><strong><span style="font-size:14">' . $Nama . '</span></strong><br><br>' . $Address . '</td>
            <td width="110">' . $ViewTglLahir;
    
    // Get jenis kelamin
    $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
    $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
    if ($DataJenKel && isset($DataJenKel['Keterangan'])) {
        $JenisKelamin = $DataJenKel['Keterangan'];
    } else {
        $JenisKelamin = '-';
    }

    $content .= '<br>' . $JenisKelamin . '</td>
            <td width="150">' . $NamaDesa . '<br>' . $KecamatanData . '<br>' . $KabupatenData . '</td>
        </tr>';
    $Nomor++;
}

$content .= '</tbody>
            </table>
            </body>
            </html>';

require_once('../../../Vendor/html2pdf/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;

try {
    $content2pdf = new Html2Pdf('L', 'F4', 'fr');
    $content2pdf->writeHTML($content);

    // Clean output buffer before generating PDF
    ob_clean();

    // Set proper headers for PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . $filename . '.pdf"');
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');

    $content2pdf->Output($filename . '.pdf', 'I'); //NAMA FILE, I untuk display di browser
    
} catch (Exception $e) {
    // If PDF generation fails, show error
    ob_clean();
    echo "<h3>Error generating PDF:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p>Please check if Html2Pdf library is properly installed.</p>";
}
?>
