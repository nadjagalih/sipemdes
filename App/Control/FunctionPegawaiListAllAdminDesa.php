<?php
$IdDesa = $_SESSION['IdDesa'];
$IdUserLogin = $_SESSION['IdUser']; // ID user yang sedang login (admin desa)
$Nomor = 1;
$QueryPegawai = mysqli_query($db, "SELECT
master_pegawai.*,
master_desa.IdDesa,
master_desa.NamaDesa,
master_desa.IdKecamatanFK,
master_kecamatan.IdKecamatan,
master_kecamatan.Kecamatan,
master_kecamatan.IdKabupatenFK,
master_setting_profile_dinas.IdKabupatenProfile,
master_setting_profile_dinas.Kabupaten,
history_mutasi.TanggalMutasi,
history_mutasi.IdJabatanFK,
master_jabatan.Jabatan
FROM master_pegawai
LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
LEFT JOIN history_mutasi ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK AND history_mutasi.Setting = 1
LEFT JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
WHERE
master_pegawai.Setting = 1 AND
master_pegawai.IdDesaFK = '$IdDesa' AND
master_pegawai.IdPegawaiFK != '$IdUserLogin'
ORDER BY
CASE WHEN history_mutasi.IdJabatanFK = 1 THEN 0 ELSE 1 END,
master_pegawai.Nama ASC");

while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
    $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
    $Foto = $DataPegawai['Foto'];
    $NIK = $DataPegawai['NIK'];
    $Nama = $DataPegawai['Nama'];
    $TanggalLahir = $DataPegawai['TanggalLahir'];
    
    // Ambil pendidikan terakhir dari history_pendidikan (Setting=1)
    $QueryPendidikan = mysqli_query($db, "SELECT master_pendidikan.JenisPendidikan FROM history_pendidikan INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan WHERE history_pendidikan.IdPegawaiFK = '$IdPegawaiFK' AND history_pendidikan.Setting = 1 ORDER BY master_pendidikan.IdPendidikan DESC, history_pendidikan.TahunLulus DESC LIMIT 1");
    if ($QueryPendidikan && mysqli_num_rows($QueryPendidikan) > 0) {
        $DataPendidikan = mysqli_fetch_assoc($QueryPendidikan);
        $Pendidikan = $DataPendidikan['JenisPendidikan'];
    } else {
        $Pendidikan = '-';
    }
    
    // Validasi dan format tanggal lahir
    if (!empty($TanggalLahir) && $TanggalLahir != '0000-00-00') {
        $exp = explode('-', $TanggalLahir);
        if (count($exp) == 3) {
            $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
        } else {
            $ViewTglLahir = '-';
        }
    } else {
        $ViewTglLahir = '-';
    }
    $JenKel = $DataPegawai['JenKel'];
    $NamaDesa = $DataPegawai['NamaDesa'];
    $Kecamatan = $DataPegawai['Kecamatan'];
    $Kabupaten = $DataPegawai['Kabupaten'];
    $Alamat = $DataPegawai['Alamat'];
    $RT = $DataPegawai['RT'];
    $RW = $DataPegawai['RW'];
    
    // Ambil jabatan langsung dari query utama (seperti di ViewMasaPensiunKades.php)
    $Jabatan = isset($DataPegawai['Jabatan']) && !empty($DataPegawai['Jabatan']) ? $DataPegawai['Jabatan'] : 'Belum Ada Jabatan';
    $IdJabatanFK = isset($DataPegawai['IdJabatanFK']) ? $DataPegawai['IdJabatanFK'] : 0;

    $Lingkungan = $DataPegawai['Lingkungan'];
    $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
    $LingkunganPeg = mysqli_fetch_assoc($AmbilDesa);
    $Komunitas = ($LingkunganPeg && isset($LingkunganPeg['NamaDesa'])) ? $LingkunganPeg['NamaDesa'] : 'Unknown';

    $KecamatanPeg = $DataPegawai['Kecamatan'];
    $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanPeg' ");
    $KecamatanPegData = mysqli_fetch_assoc($AmbilKecamatan);
    $KomunitasKec = ($KecamatanPegData && isset($KecamatanPegData['Kecamatan'])) ? $KecamatanPegData['Kecamatan'] : 'Unknown';

    $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec
?>
    <tr class="gradeX">
        <td>
            <?php echo $Nomor; ?>
        </td>

        <?php
        if (empty($Foto)) {
        ?>
            <td>
                <a href="?pg=ViewFotoAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>" title="Edit Foto"><img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/no-image.jpg"></a>
            </td>
        <?php } else { ?>
            <td>
                <a href="?pg=ViewFotoAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>" title="Edit Foto"><img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/<?php echo $Foto; ?>"></a>
            </td>
        <?php } ?>

        <td>
            <a class=" float-center" data-toggle="tooltip" title="Detail Data"><?php echo $NIK; ?></a>
        </td>
        <td>
            <strong><?php echo $Nama; ?></strong><br><br>
            <?php echo $Address; ?>
        </td>
        <td>
            <?php echo $ViewTglLahir; ?><br>
            <?php
            $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
            $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
            $JenisKelamin = ($DataJenKel && isset($DataJenKel['Keterangan'])) ? $DataJenKel['Keterangan'] : 'Unknown';
            echo $JenisKelamin;
            ?>
        </td>

        <td>
            <?php echo $Pendidikan; ?>
        </td>

        <td>
            <?php echo $NamaDesa; ?><br>
            <?php echo $Kecamatan; ?><br>
            <?php echo $Kabupaten; ?>
        </td>

        <td>
            <?php
            if ($Jabatan == 'Kepala Desa') {
                echo '<strong style="color: #006400;">' . $Jabatan . '</strong>';
            } else {
                echo '<strong>' . $Jabatan . '</strong>';
            }
            ?>
        </td>
        <td>
            <div class="btn-group" role="group">
                <a href="?pg=PegawaiEditAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>">
                    <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Edit Data"><i class="fa fa-edit"></i></button>
                </a>
                <button class="btn btn-outline btn-danger btn-xs delete-btn" data-toggle="tooltip" title="Hapus Data" data-id="<?php echo $IdPegawaiFK; ?>" data-nama="<?php echo htmlspecialchars($Nama, ENT_QUOTES); ?>">
                    <i class="fa fa-eraser"></i>
                </button>
                <a href="?pg=PegawaiDetailAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>">
                    <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Detail Data"><i class="fa fa-folder-open-o"></i></button>
                </a>
            </div>
        </td>
    </tr>
<?php $Nomor++;
}
?>