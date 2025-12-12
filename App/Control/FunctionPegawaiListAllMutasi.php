<?php
// DataTables will handle pagination, so we load all data
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
main_user.IdLevelUserFK
FROM
master_pegawai
LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
INNER JOIN main_user ON master_pegawai.IdPegawaiFK = main_user.IdPegawai
WHERE main_user.IdLevelUserFK <> 1 and main_user.IdLevelUserFK <> 2
ORDER BY
master_kecamatan.IdKecamatan ASC,
master_desa.NamaDesa ASC");
while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
    $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
    $Foto = $DataPegawai['Foto'];
    $NIK = $DataPegawai['NIK'];
    $Nama = $DataPegawai['Nama'];
    $TanggalLahir = $DataPegawai['TanggalLahir'];
    
    // Cek dan format tanggal lahir
    if (!empty($TanggalLahir) && $TanggalLahir != '0000-00-00') {
        $exp = explode('-', $TanggalLahir);
        if (count($exp) >= 3) {
            $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
        } else {
            $ViewTglLahir = $TanggalLahir; // Gunakan format asli jika tidak bisa di-parse
        }
    } else {
        $ViewTglLahir = "Tidak Diset";
    }
    
    $JenKel = $DataPegawai['JenKel'];
    $NamaDesa = $DataPegawai['NamaDesa'];
    $Kecamatan = $DataPegawai['Kecamatan'];
    $Kabupaten = $DataPegawai['Kabupaten'];
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
            <a href="?pg=DetailMutasi&Kode=<?php echo $IdPegawaiFK; ?>" class=" float-center" data-toggle="tooltip" title="Detail Data"><span style="font-size:1">'</span><?php echo $NIK; ?></a>
        </td>

        <td>
            <strong><?php echo $Nama; ?></strong><br><br>
            <?php echo $ViewTglLahir; ?><br>
            <?php
            $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
            $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
            $JenisKelamin = ($DataJenKel && isset($DataJenKel['Keterangan'])) ? $DataJenKel['Keterangan'] : 'Tidak Diset';
            echo $JenisKelamin;
            ?>
        </td>
        <td>
            <?php
            // Hanya tampilkan jenis mutasi yang aktif (Setting = 1)
            $QMutasi = mysqli_query($db, "SELECT
                        history_mutasi.JenisMutasi,
                        master_mutasi.IdMutasi,
                        master_mutasi.Mutasi,
                        history_mutasi.TanggalMutasi,
                        history_mutasi.IdMutasi,
                        history_mutasi.Setting
                        FROM
                        history_mutasi
                        INNER JOIN master_mutasi ON history_mutasi.JenisMutasi = master_mutasi.IdMutasi
                        WHERE IdPegawaiFK = '$IdPegawaiFK' AND history_mutasi.Setting = 1
                        ORDER BY history_mutasi.IdMutasi DESC,
                        history_mutasi.TanggalMutasi DESC");
            
            if (mysqli_num_rows($QMutasi) > 0) {
                while ($DataMutasi = mysqli_fetch_assoc($QMutasi)) {
                    $JenjangMutasi = $DataMutasi['Mutasi'];
                ?>
                    <span class="label label-success float-left"><?php echo $JenjangMutasi; ?></span>
                <?php 
                }
            } else {
                echo "<span class='text-muted'>Tidak ada mutasi aktif</span>";
            }
            ?>
        </td>
        <td>

            <?php
            // Hanya tampilkan jabatan yang aktif (Setting = 1)
            $QJabatan = mysqli_query($db, "SELECT
                    history_mutasi.IdJabatanFK,
                    master_jabatan.IdJabatan,
                    master_jabatan.Jabatan,
                    history_mutasi.TanggalMutasi,
                    history_mutasi.IdMutasi,
                    history_mutasi.JenisMutasi,
                    history_mutasi.Setting
                    FROM history_mutasi
                    INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                    WHERE IdPegawaiFK = '$IdPegawaiFK' AND history_mutasi.Setting = 1
                    ORDER BY history_mutasi.IdMutasi DESC,
                    history_mutasi.TanggalMutasi DESC");
            
            if (mysqli_num_rows($QJabatan) > 0) {
                while ($DataJabatan = mysqli_fetch_assoc($QJabatan)) {
                    $JenjangJabatan = $DataJabatan['Jabatan'];
                ?>
                    <span class="label label-success float-left"><?php echo $JenjangJabatan; ?></span>
                <?php 
                }
            } else {
                echo "<span class='text-muted'>Tidak ada jabatan aktif</span>";
            }
            ?>
        </td>
        <td>
            <?php echo $NamaDesa; ?><br>
            <?php echo $Kecamatan; ?><br>
            <?php echo $Kabupaten; ?>
        </td>
        <td>
            <?php
            if ($NIK == "") {
                echo "Data Master Kepala Desa & Perangkat Desa Belum Lengkap";
            } else {
            ?>
                <a href="?pg=AddMutasi&Kode=<?php echo $IdPegawaiFK; ?>">
                    <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Tambah Data"><i class="fa fa-folder-open-o"></i></button>
                </a>
            <?php } ?>
        </td>
    </tr>
<?php $Nomor++;
}
?>