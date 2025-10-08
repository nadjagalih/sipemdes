<?php
// Pagination setup
$limit = 50; // Record per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk menghitung total data
$queryCount = mysqli_query($db, "SELECT COUNT(*) as total
FROM
master_pegawai
LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
INNER JOIN main_user ON master_pegawai.IdPegawaiFK = main_user.IdPegawai
WHERE main_user.IdLevelUserFK <> 1 and main_user.IdLevelUserFK <> 2");

$countResult = mysqli_fetch_assoc($queryCount);
$totalRecords = $countResult['total'];
$totalPages = ceil($totalRecords / $limit);

$Nomor = $offset + 1;
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
master_desa.NamaDesa ASC
LIMIT $limit OFFSET $offset");
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
            $Id = 1;
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
                        WHERE IdPegawaiFK = '$IdPegawaiFK'
                        ORDER BY history_mutasi.IdMutasi DESC,
                        history_mutasi.TanggalMutasi DESC");
            while ($DataMutasi = mysqli_fetch_assoc($QMutasi)) {
                $JenjangMutasi = $DataMutasi['Mutasi'];
                $SettingMutasi = $DataMutasi['Setting'];
            ?>
                <br>
                <?php if ($SettingMutasi == 0) { ?>
                    <?php echo $JenjangMutasi; ?>
                <?php } elseif ($SettingMutasi == 1) { ?>
                    <span class="label label-success float-left"><?php echo $JenjangMutasi; ?></span>
                <?php } ?>
            <?php $Id++;
            } ?>
        </td>
        <td>

            <?php
            $Id = 1;
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
                    WHERE IdPegawaiFK = '$IdPegawaiFK'
                    ORDER BY history_mutasi.IdMutasi DESC,
                    history_mutasi.TanggalMutasi DESC");
            while ($DataJabatan = mysqli_fetch_assoc($QJabatan)) {
                $JenjangJabatan = $DataJabatan['Jabatan'];
                $SettingJabatan = $DataJabatan['Setting'];
            ?>
                <br>
                <?php if ($SettingJabatan == 0) { ?>
                    <?php echo $Id; ?>. <?php echo $JenjangJabatan; ?>
                <?php } elseif ($SettingJabatan == 1) { ?>
                    <span class="label label-success float-left"><?php echo $Id; ?>. <?php echo $JenjangJabatan; ?></span>
                <?php } ?>
            <?php $Id++;
            } ?>
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

<!-- Pagination -->
<tr>
    <td colspan="7">
        <div class="row">
            <div class="col-md-6">
                <div class="dataTables_info">
                    Menampilkan <?php echo $offset + 1; ?> sampai <?php echo min($offset + $limit, $totalRecords); ?> dari <?php echo $totalRecords; ?> data
                </div>
            </div>
            <div class="col-md-6">
                <div class="dataTables_paginate">
                    <ul class="pagination justify-content-end">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?pg=ViewMutasi&page=<?php echo $page - 1; ?>">Previous</a>
                            </li>
                        <?php endif; ?>

                        <?php
                        $start = max(1, $page - 2);
                        $end = min($totalPages, $page + 2);
                        
                        for ($i = $start; $i <= $end; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?pg=ViewMutasi&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?pg=ViewMutasi&page=<?php echo $page + 1; ?>">Next</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </td>
</tr>