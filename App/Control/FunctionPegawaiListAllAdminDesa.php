<?php
$IdDesa = $_SESSION['IdDesa'];
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
master_desa.IdDesa,
master_desa.NamaDesa,
master_desa.IdKecamatanFK,
master_kecamatan.IdKecamatan,
master_kecamatan.Kecamatan,
master_kecamatan.IdKabupatenFK,
master_setting_profile_dinas.IdKabupatenProfile,
master_setting_profile_dinas.Kabupaten
FROM master_pegawai
LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
WHERE
master_pegawai.Setting <> 0 AND
master_desa.IdDesa = '$IdDesa'
ORDER BY
master_kecamatan.IdKecamatan ASC,
master_desa.NamaDesa ASC");

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
    $exp = explode('-', $TanggalLahir);
    $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
    $JenKel = $DataPegawai['JenKel'];
    $NamaDesa = $DataPegawai['NamaDesa'];
    $Kecamatan = $DataPegawai['Kecamatan'];
    $Kabupaten = $DataPegawai['Kabupaten'];
    $Alamat = $DataPegawai['Alamat'];
    $RT = $DataPegawai['RT'];
    $RW = $DataPegawai['RW'];
    // Ambil jabatan aktif terakhir dari history_mutasi yang join master_jabatan
    $QueryJabatan = mysqli_query($db, "SELECT master_jabatan.Jabatan FROM history_mutasi INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan WHERE history_mutasi.IdPegawaiFK = '$IdPegawaiFK' AND history_mutasi.Setting = 1 ORDER BY history_mutasi.TanggalMutasi DESC, history_mutasi.IdHistoryMutasi DESC LIMIT 1");
    if ($QueryJabatan && mysqli_num_rows($QueryJabatan) > 0) {
        $DataJabatan = mysqli_fetch_assoc($QueryJabatan);
        $Jabatan = $DataJabatan['Jabatan'];
    } else {
        $Jabatan = '-';
    }

    $Lingkungan = $DataPegawai['Lingkungan'];
    $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
    $LingkunganPeg = mysqli_fetch_assoc($AmbilDesa);
    $Komunitas = $LingkunganPeg['NamaDesa'];

    $KecamatanPeg = $DataPegawai['Kec'];
    $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanPeg' ");
    $KecamatanPeg = mysqli_fetch_assoc($AmbilKecamatan);
    $KomunitasKec = $KecamatanPeg['Kecamatan'];

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
            $JenisKelamin = $DataJenKel['Keterangan'];
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
            <?php echo $Jabatan; ?>
        </td>
        <td>
            <?php if ($IdPegawaiFK == $_SESSION['IdUser']) { ?>
                <div class="btn-group">
                    <a href="?pg=PegawaiEditAdminAplikasi&Kode=<?php echo $IdPegawaiFK; ?>">
                        <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Edit Data"><i class="fa fa-edit"></i></button>
                    </a>
                </div>
            <?php } else { ?>
                <div class="btn-group" role="group">
                    <a href="?pg=PegawaiEditAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>">
                        <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Edit Data"><i class="fa fa-edit"></i></button>
                    </a>
                    <a href="../App/Model/ExcPegawaiAdminDesa?Act=Delete&Kode=<?php echo $IdPegawaiFK; ?>" onclick="return confirm('Anda yakin ingin menghapus : <?php echo $Nama; ?> ?');">
                        <button class="btn btn-outline btn-danger btn-xs" data-toggle="tooltip" title="Hapus Data"><i class="fa fa-eraser"></i></button>
                    </a>
                    <a href="?pg=PegawaiDetailAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>">
                        <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip"><i class="fa fa-folder-open-o"></i></button>
                    </a>
                </div>
            <?php } ?>
        </td>
    </tr>
<?php $Nomor++;
}
?>