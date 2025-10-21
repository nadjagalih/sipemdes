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

$QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$IdKec' ");
$DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
$NamaKecamatan = $DataKecamatan['Kecamatan'];

// Determine title based on filter
if (!empty($filterDesa)) {
    $QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE NamaDesa = '$filterDesa' AND IdKecamatanFK = '$IdKec' ");
    $DataDesa = mysqli_fetch_assoc($QueryDesa);
    $title = 'Data Kepala Desa & Perangkat Desa ' . $filterDesa . ' Kecamatan ' . $NamaKecamatan;
    $filename = 'Data Perangkat Desa ' . $filterDesa . ' Kecamatan ' . $NamaKecamatan . '_' . $DateCetak;
} else {
    $title = 'Data Kepala Desa & Perangkat Desa Kecamatan ' . $NamaKecamatan;
    $filename = 'Data Perangkat Kecamatan ' . $NamaKecamatan . '_' . $DateCetak;
}

$content = 
    '<html>
        <body>
        <h4>' . $title . '<br>Pertanggal ' . $Tanggal_Cetak . ' Pukul ' . $Waktu_Cetak . ' WIB</h4>
            <table border="0.3" cellpadding="2" cellspacing="0" width="100%">
                <thead>
                    <tr align="center">
                        <th><strong>No</strong></th>
                        <th><strong>Kecamatan<br>Desa<br>Kode Desa</strong></th>
                        <th><strong>Foto</strong></th>
                        <th><strong>Nama Perangkat<br>Alamat</strong></th>
                        <th><strong>Tgl Lahir<br>Jenis Kelamin</strong></th>
                        <th><strong>Pendidikan</strong></th>
                        <th><strong>SK Pengangkatan<br>Nomor<br>Tanggal</strong></th>
                        <th><strong>Jabatan</strong></th>
                        <th><strong>Telp</strong></th>
                    </tr>
                </thead>
                <tbody>';

$Nomor = 1;

// Build query with optional filter
$whereClause = "master_pegawai.Setting = 1 AND
                main_user.IdLevelUserFK <> 1 AND
                main_user.IdLevelUserFK <> 2 AND
                history_mutasi.Setting = 1 AND
                master_kecamatan.IdKecamatan = '$IdKec'";

if (!empty($filterDesa)) {
    $whereClause .= " AND master_desa.NamaDesa = '$filterDesa'";
}

$QueryPegawai = mysqli_query($db, "SELECT
                        master_pegawai.IdPegawaiFK,
                        master_pegawai.Foto,
                        master_pegawai.NIK,
                        master_pegawai.Nama,
                        master_pegawai.TanggalLahir,
                        master_pegawai.TanggalPensiun,
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
                        history_mutasi.JenisMutasi,
                        history_mutasi.FileSKMutasi,
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
                        WHERE $whereClause
                        GROUP BY
                        master_pegawai.IdPegawaiFK
                        ORDER BY
                        master_kecamatan.IdKecamatan ASC,
                        master_desa.NamaDesa ASC,
                        history_mutasi.IdJabatanFK ASC");

while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
    $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
    $Foto = $DataPegawai['Foto'];
    $NIK = $DataPegawai['NIK'];
    $Nama = $DataPegawai['Nama'];

    $TanggalLahir = $DataPegawai['TanggalLahir'];
    $exp = explode('-', $TanggalLahir);
    $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

    $JenKel = $DataPegawai['JenKel'];
    $KodeDesa = $DataPegawai['KodeDesa'];
    $NamaDesa = $DataPegawai['NamaDesa'];
    $Kecamatan = $DataPegawai['Kecamatan'];
    $Kabupaten = $DataPegawai['Kabupaten'];
    $Alamat = $DataPegawai['Alamat'];
    $RT = $DataPegawai['RT'];
    $RW = $DataPegawai['RW'];

    $Lingkungan = $DataPegawai['Lingkungan'];
    $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
    $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
    $Komunitas = ($LingkunganBPD && isset($LingkunganBPD['NamaDesa'])) ? $LingkunganBPD['NamaDesa'] : '-';

    $KecamatanBPD = $DataPegawai['Kec'];
    $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
    $KecamatanBPDData = mysqli_fetch_assoc($AmbilKecamatan);
    $KomunitasKec = ($KecamatanBPDData && isset($KecamatanBPDData['Kecamatan'])) ? $KecamatanBPDData['Kecamatan'] : '-';

    $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;

    $TglSKMutasi = $DataPegawai['TanggalMutasi'];
    $exp2 = explode('-', $TglSKMutasi);
    $TanggalMutasi = $exp2[2] . "-" . $exp2[1] . "-" . $exp2[0];

    $NomorSK = $DataPegawai['NomorSK'];
    $Jabatan = $DataPegawai['Jabatan'];
    $KetJabatan = $DataPegawai['KeteranganJabatan'];
    $Telp = $DataPegawai['NoTelp'];

    $content .= '<tr>
                <td width="40" align="center">' . $Nomor . '</td>';
    $content .= '<td width="110">' . $Kecamatan . '<br><strong>' . $NamaDesa . '</strong><br>' . $KodeDesa . '</td>';
    
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
    
    $content .= '<td width="280"><strong><span style="font-size:14">' . $Nama . '</span></strong><br><br>' . $Address . '</td>
            <td width="80">' . $ViewTglLahir;
    
    // Get jenis kelamin
    $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
    $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
    if ($DataJenKel && isset($DataJenKel['Keterangan'])) {
        $JenisKelamin = $DataJenKel['Keterangan'];
    } else {
        $JenisKelamin = '-';
    }

    $content .= '<br>' . $JenisKelamin . '</td>';
    
    // Get pendidikan
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
    if ($DataPendidikan && isset($DataPendidikan['JenisPendidikan'])) {
        $Pendidikan = $DataPendidikan['JenisPendidikan'];
    } else {
        $Pendidikan = '-';
    }
    
    $content .= '<td width="80">' . $Pendidikan . '</td>
            <td width="180"><span style="font-size:12">' . $NomorSK . '</span><br><br>' . $TanggalMutasi . '</td>
            <td width="170"><b>' . $Jabatan . '</b><br><br>' . $KetJabatan . '</td>
            <td width="100" align="left">' . $Telp . '</td>
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
