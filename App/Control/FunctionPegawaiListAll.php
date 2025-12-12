<?php
// Pagination setup
$limit = 50; // Record per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk menghitung total data
$queryCount = mysqli_query($db, "SELECT COUNT(*) as total
FROM master_pegawai
LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
WHERE master_pegawai.Setting <> 0");

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
    $Alamat = $DataPegawai['Alamat'];
    $RT = $DataPegawai['RT'];
    $RW = $DataPegawai['RW'];

    $Lingkungan = $DataPegawai['Lingkungan'];
    $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
    $LingkunganPeg = mysqli_fetch_assoc($AmbilDesa);
    $Komunitas = ($LingkunganPeg && isset($LingkunganPeg['NamaDesa'])) ? $LingkunganPeg['NamaDesa'] : 'Data Tidak Ditemukan';

    $KecamatanPeg = $DataPegawai['Kec'];
    $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanPeg' ");
    $KecamatanPegData = mysqli_fetch_assoc($AmbilKecamatan);
    $KomunitasKec = ($KecamatanPegData && isset($KecamatanPegData['Kecamatan'])) ? $KecamatanPegData['Kecamatan'] : 'Data Tidak Ditemukan';

    $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
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
            $JenisKelamin = ($DataJenKel && isset($DataJenKel['Keterangan'])) ? $DataJenKel['Keterangan'] : 'Tidak Diset';
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
                $DetailLevel = ($DataCekPegawaiLevel && isset($DataCekPegawaiLevel['IdLevelUserFK'])) ? $DataCekPegawaiLevel['IdLevelUserFK'] : 0;
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

<!-- Pagination -->
<tr>
    <td colspan="9">
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
                                <a class="page-link" href="?pg=PegawaiViewAll&page=<?php echo $page - 1; ?>">Previous</a>
                            </li>
                        <?php endif; ?>

                        <?php
                        $start = max(1, $page - 2);
                        $end = min($totalPages, $page + 2);
                        
                        for ($i = $start; $i <= $end; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?pg=PegawaiViewAll&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?pg=PegawaiViewAll&page=<?php echo $page + 1; ?>">Next</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </td>
</tr>