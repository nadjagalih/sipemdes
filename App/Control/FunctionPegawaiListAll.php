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
WHERE master_pegawai.Setting <> 0
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
                <a href="?pg=ViewFoto&Kode=<?php echo $IdPegawaiFK; ?>" title="Edit Foto"><img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/no-image.jpg"></a>
            </td>
        <?php } else { ?>
            <td>
                <a href="?pg=ViewFoto&Kode=<?php echo $IdPegawaiFK; ?>" title="Edit Foto"><img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/<?php echo $Foto; ?>"></a>
            </td>
        <?php } ?>

        <td>
            <a href="?pg=PegawaiDetail&Kode=<?php echo $IdPegawaiFK; ?>" class=" float-center" data-toggle="tooltip" title="Detail Data"><?php echo $NIK; ?></a>
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
            <?php echo $NamaDesa; ?><br>
            <?php echo $Kecamatan; ?><br>
            <?php echo $Kabupaten; ?>
        </td>
        <td>
            <?php if ($IdPegawaiFK == $_SESSION['IdUser']) { ?>
            <?php } else { ?>
                <?php
                // $QCekLevel = mysqli_query($db, "SELECT * FROM main_user WHERE IdUser = '$IdPegawaiFK' ");
                // $DataCekLevel = mysqli_fetch_assoc($QCekLevel);
                // $IdLevel = $DataCekLevel['IdLevelUserFK'];

                $QCekPegawaiLevel = mysqli_query($db, "SELECT
                master_pegawai.IdPegawaiFK,
                main_user.IdLevelUserFK
                FROM
                master_pegawai
                INNER JOIN
                main_user
                ON
                    master_pegawai.IdPegawaiFK = main_user.IdPegawai
                WHERE master_pegawai.IdPegawaiFK = '$IdPegawaiFK' ");
                $DataCekPegawaiLevel = mysqli_fetch_assoc($QCekPegawaiLevel);
                $DetailLevel = $DataCekPegawaiLevel['IdLevelUserFK'];
                // $DetailLevelPeg = $DataCekPegawaiLevel['IdPegawaiFK'];

                if ($DetailLevel == 2) {
                    echo "<a href='?pg=PegawaiEditAdminAplikasiKab&Kode=$IdPegawaiFK'>
                    <button class='btn btn-outline btn-success btn-xs' data-toggle='tooltip' title='Edit Data'><i class='fa fa-edit'></i></button>
                </a>";
                } else {

                ?>
                    <a href="?pg=PegawaiEdit&Kode=<?php echo $IdPegawaiFK; ?>">
                        <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Edit Data"><i class="fa fa-edit"></i></button>
                    </a>
                    <a href="../App/Model/ExcPegawai?Act=Delete&Kode=<?php echo $IdPegawaiFK; ?>" onclick="return confirm('Anda yakin ingin menghapus : <?php echo $Nama; ?> ?');">
                        <button class="btn btn-outline btn-danger  btn-xs " data-toggle="tooltip" title="Hapus Data"><i class="fa fa-eraser"></i></button>
                    </a>
            <?php }
            } ?>
        </td>
    </tr>
<?php $Nomor++;
}
?>