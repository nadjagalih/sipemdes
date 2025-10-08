<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include '../../../../Module/Config/Env.php';

// Setting tanggal dalam format Bahasa Indonesia
setlocale(LC_TIME, 'id_ID.UTF-8');
$tanggalTTD = strftime('%d %B %Y');

$IdDesa = $_SESSION['IdDesa'];

$QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa ='$IdDesa' ");
$DataDesa = mysqli_fetch_assoc($QueryDesa);
$NamaDesa = $DataDesa['NamaDesa'];
$KecamatanId = $DataDesa['IdKecamatanFK'];

$QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$KecamatanId' ");
$DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
$NamaKecamatan = $DataKecamatan['Kecamatan'];

$QProfile = mysqli_query($db, "SELECT * FROM master_setting_profile_dinas");
$DataProfile = mysqli_fetch_assoc($QProfile);
$Kabupaten = $DataProfile['Kabupaten'];

$content =
    '<html>
    <body>
    <h4 style="text-align: center;">Data Masa Pensiun Kepala Desa dan Perangkat Desa ' . " " . $NamaDesa . " " . 'Kecamatan' . " " . $NamaKecamatan . ' Kabupaten ' . " " . $Kabupaten . '</h4>

    <table border="1" style="border-collapse:collapse; width: 100%;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="width: 3%; text-align: center;">No</th>
                <th style="width: 8%;">Foto</th>
                <th style="width: 10%;">NIK</th>
                <th style="width: 17%;">Nama<br>Jabatan<br>Alamat</th>
                <th style="width: 10%;">Tgl Lahir<br>Jenis Kelamin</th>
                <th style="width: 8%;">Tgl Mutasi</th>
                <th style="width: 12%;">Tgl Pensiun<br>Sisa Pensiun</th>
                <th style="width: 14%;">Keterangan</th>
                <th style="width: 18%;">Unit Kerja<br>Kecamatan<br>Kabupaten</th>
            </tr>
        </thead>
        <tbody>';

$Nomor = 1;
// Query GABUNGAN untuk Kades dan Perangkat Desa
$QueryPegawai = mysqli_query($db, "SELECT
                master_pegawai.*,
                master_desa.NamaDesa,
                master_kecamatan.Kecamatan,
                master_setting_profile_dinas.Kabupaten AS NamaKabupaten,
                history_mutasi.TanggalMutasi,
                history_mutasi.IdJabatanFK,
                master_jabatan.Jabatan
            FROM master_pegawai
            LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
            LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
            LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
            INNER JOIN main_user ON main_user.IdPegawai = master_pegawai.IdPegawaiFK
            INNER JOIN history_mutasi ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
            INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
            WHERE
                master_pegawai.Setting = 1 AND
                main_user.IdLevelUserFK NOT IN (1, 2) AND
                history_mutasi.Setting = 1 AND
                master_pegawai.IdDesaFK = '$IdDesa'
            ORDER BY
                CASE WHEN history_mutasi.IdJabatanFK = 1 THEN 0 ELSE 1 END,
                master_pegawai.TanggalPensiun ASC");

while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
    $IdJabatanFK = $DataPegawai['IdJabatanFK'];
    $Foto = $DataPegawai['Foto'];
    $NIK = $DataPegawai['NIK'];
    $Nama = $DataPegawai['Nama'];
    $Jabatan = $DataPegawai['Jabatan'];
    $TanggalLahir = $DataPegawai['TanggalLahir'];
    $ViewTglLahir = date("d-m-Y", strtotime($TanggalLahir));
    $JenKel = $DataPegawai['JenKel'];
    $Alamat = $DataPegawai['Alamat'];
    $RT = $DataPegawai['RT'];
    $RW = $DataPegawai['RW'];
    $Setting = $DataPegawai['Setting'];
    $Lingkungan = $DataPegawai['Lingkungan'];

    $ViewTglMutasi = '-';
    if ($IdJabatanFK == 1) { // Logika untuk Kepala Desa
        $TanggalMutasi = $DataPegawai['TanggalMutasi'];
        $ViewTglMutasi = date("d-m-Y", strtotime($TanggalMutasi));
        $TanggalPensiun = date('Y-m-d', strtotime('+6 year', strtotime($TanggalMutasi)));
    } else { // Logika untuk Perangkat Desa
        $TanggalPensiun = $DataPegawai['TanggalPensiun'];
    }
    
    $ViewTglPensiun = date("d-m-Y", strtotime($TanggalPensiun));
    
    $TglPensiun_dt = date_create($TanggalPensiun);
    $TglSekarang_dt = date_create();
    $TglSekarang1 = date('Y-m-d');
    
    if ($TglSekarang1 >= $TanggalPensiun) {
        $SisaPensiun = '0 Thn<br>0 Bln<br>0 Hr';
    } else {
        $Temp = date_diff($TglSekarang_dt, $TglPensiun_dt);
        $SisaPensiun = $Temp->y . ' Thn<br>' . $Temp->m . ' Bln<br>' . ($Temp->d + 1) . ' Hr';
    }

    $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan'");
    $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
    $Komunitas = $LingkunganBPD['NamaDesa'];

    $KecamatanBPD = $DataPegawai['Kecamatan'];
    $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
    $KecamatanBPD_data = mysqli_fetch_assoc($AmbilKecamatan);
    $KomunitasKec = $KecamatanBPD_data['Kecamatan'];
    $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kec. " . $KomunitasKec;
    
    // Path untuk foto
    $fotoPath = '../../../../Vendor/Media/Pegawai/' . (empty($Foto) ? 'no-image.jpg' : $Foto);

    $content .=
        '<tr>
            <td style="text-align: center;">' . $Nomor . '</td>
            <td style="text-align: center;"><img src="' . $fotoPath . '" style="width: 50px;"></td>
            <td>' . $NIK . '</td>
            <td>' . $Nama . '<br><strong>' . $Jabatan . '</strong><br>' . $Address . '</td>
            <td>' . $ViewTglLahir;

    $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
    $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
    $JenisKelamin = $DataJenKel['Keterangan'];

    $content .=
        '<br>' . $JenisKelamin . '</td>
            <td>' . $ViewTglMutasi . '</td>
            <td>' . $ViewTglPensiun . '<br>' . $SisaPensiun . '</td>';

    if ($TglSekarang1 >= $TanggalPensiun and $Setting == 1) {
        $content .=
            '<td>PENSIUN BELUM ADA SK</td>';
    } elseif ($TglSekarang1 < $TanggalPensiun) {
        $content .=
            '<td>BELUM PENSIUN</td>';
    }

    $content .=
        '<td>' . $DataPegawai['NamaDesa'] . '<br>' . $DataPegawai['Kecamatan'] . '<br>' . $DataPegawai['NamaKabupaten'] . '</td>
        </tr>';
    $Nomor++;
}
$content .= '</tbody>
        </table>';

$content .= '
    <br><br>
    <table style="width: 100%; border: none;">
        <tr>
            <td style="width: 60%; border: none;"></td>
            <td style="width: 40%; text-align: center; border: none;">
                Trenggalek, '.$tanggalTTD.'<br>
                Kepala Dinas
                <br><br><br><br>
                <strong style="text-decoration: underline;">Drs. EKO ANTORO</strong><br>
                NIP. 19680406 199003 1 013
            </td>
        </tr>
    </table>
';

$content .='
        </body>
        </html>';

require_once('../../../../Vendor/html2pdf/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;

$content2pdf = new Html2Pdf('L', 'F4', 'fr', true, 'UTF-8', array(15, 15, 15, 15));
$content2pdf->writeHTML($content);
$content2pdf->output('Data Pensiun Kepala Desa dan Perangkat Desa  ' . $NamaDesa . '.pdf');
?>
