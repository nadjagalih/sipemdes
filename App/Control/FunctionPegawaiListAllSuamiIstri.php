<?php
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
main_user.IdLevelUserFK,
master_pegawai.StatusPernikahan,
master_status_pernikahan.IdPernikahan,
master_status_pernikahan.Status
FROM
master_pegawai
LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
INNER JOIN main_user ON master_pegawai.IdPegawaiFK = main_user.IdPegawai
LEFT JOIN master_status_pernikahan ON master_pegawai.StatusPernikahan = master_status_pernikahan.IdPernikahan
WHERE master_pegawai.Setting <> 0 AND main_user.IdLevelUserFK <> 1 and main_user.IdLevelUserFK <> 2
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
    $StatusPernikahan = $DataPegawai['Status'];

?>
    <tr class="gradeX">
        <td>
            <?php echo $Nomor; ?>
        </td>

        <?php
        if (empty($Foto)) {
        ?>
            <td>
                <img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/no-image.jpg">
            </td>
        <?php } else { ?>
            <td>
                <img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/<?php echo $Foto; ?>">
            </td>
        <?php } ?>

        <td>
            <a href="?pg=PegawaiDetailSuamiIstri&Kode=<?php echo $IdPegawaiFK; ?>" class=" float-center" data-toggle="tooltip" title="Detail Data"><?php echo $NIK; ?></a>
        </td>
        <td>
            <strong><?php echo $Nama; ?></strong><br><br>
            <?php echo $ViewTglLahir; ?><br>
            <?php
            $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
            $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
            $JenisKelamin = $DataJenKel['Keterangan'];
            echo $JenisKelamin;
            ?>
        </td>
        <td>
            <?php echo $StatusPernikahan; ?><br>
        </td>
        <td>
            <?php echo $NamaDesa; ?><br>
            <?php echo $Kecamatan; ?><br>
            <?php echo $Kabupaten; ?>
        </td>
        <td>
            <?php if ($IdPegawaiFK == $_SESSION['IdUser']) { ?>
                <?php } else {
                if ($NIK == "") {
                    echo "Data Master Kepala Desa & Perangkat Desa Belum Lengkap";
                } else {
                ?>
                    <a href="?pg=PegawaiAddSuamiIstri&Kode=<?php echo $IdPegawaiFK; ?>">
                        <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Tambah Data"><i class="fa fa-folder-open-o"></i></button>
                    </a>
                    <!-- <a href="../App/Model/ExcPegawaiSuamiIstri?Act=Delete&Kode=<?php echo $IdPegawaiFK; ?>" onclick="return confirm('Anda yakin ingin menghapus : <?php echo $Nama; ?> ?');">
                    <button class="btn btn-outline btn-danger  btn-xs " data-toggle="tooltip" title="Hapus Data"><i class="fa fa-eraser"></i></button>
                </a> -->
            <?php }
            } ?>
        </td>
    </tr>
<?php $Nomor++;
}
?>