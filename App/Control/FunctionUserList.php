<?php
// Pagination setup
$limit = 50; // Record per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk menghitung total data
$queryCount = mysqli_query($db, "SELECT COUNT(*) as total
FROM
master_pegawai
INNER JOIN main_user ON master_pegawai.IdPegawaiFK = main_user.IdPegawai
INNER JOIN leveling_user ON main_user.IdLevelUserFK = leveling_user.IdLevelUser");

$countResult = mysqli_fetch_assoc($queryCount);
$totalRecords = $countResult['total'];
$totalPages = ceil($totalRecords / $limit);

$Nomor = $offset + 1;
$QueryUser = mysqli_query($db, "SELECT
main_user.IdUser,
main_user.NameAkses,
main_user.NamePassword,
main_user.IdLevelUserFK,
main_user.Status,
main_user.StatusLogin,
main_user.IdPegawai,
master_pegawai.IdPegawaiFK,
master_pegawai.NIK,
master_pegawai.Nama,
master_pegawai.IdDesaFK,
master_pegawai.Setting,
leveling_user.IdLevelUser,
leveling_user.UserLevel
FROM
master_pegawai
INNER JOIN main_user ON master_pegawai.IdPegawaiFK = main_user.IdPegawai
INNER JOIN leveling_user ON main_user.IdLevelUserFK = leveling_user.IdLevelUser

ORDER BY leveling_user.IdLevelUser ASC
LIMIT $limit OFFSET $offset");
while ($DataUser = mysqli_fetch_assoc($QueryUser)) {
    $IdUser = $DataUser['IdUser'];
    $NameAkses = $DataUser['NameAkses'];
    $Level = $DataUser['UserLevel'];
    $Status = $DataUser['Status'];
    $StatusLogin = $DataUser['StatusLogin'];
    $Setting = $DataUser['Setting'];
    $NIK = $DataUser['NIK'];
    $Nama = $DataUser['Nama'];
    $IdDesa = $DataUser['IdDesaFK'];


?>
    <tr class="gradeX">
        <td>
            <?php echo $Nomor; ?>
        </td>
        <td>
            <?php echo $Nama; ?>
        </td>
        <td>
            <?php echo $NameAkses; ?>
        </td>
        <td>
            <?php echo '**********'; ?>
            <span>
                <a href="?pg=UserReset&Kode=<?php echo $IdUser; ?>">
                    <button class="btn btn-warning btn-xs" data-toggle="tooltip" title="Reset Password">Reset</button>
                </a>
            </span>
        </td>
        <td>
            <?php $QueryDesa = mysqli_query($db, "SELECT
            master_desa.IdDesa,
            master_desa.NamaDesa,
            master_kecamatan.Kecamatan,
            master_desa.IdKecamatanFK,
            master_kecamatan.IdKecamatan
            FROM master_desa
            INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
            WHERE master_desa.IdDesa = '$IdDesa' ");
            $DataDesa = mysqli_fetch_assoc($QueryDesa);
            
            if ($DataDesa) {
                $Desa = $DataDesa['NamaDesa'] ?? 'Data Tidak Ditemukan';
                $Kecamatan = $DataDesa['Kecamatan'] ?? 'Data Tidak Ditemukan';
                echo $Desa . " - " . $Kecamatan;
            } else {
                echo "Data Tidak Ditemukan";
            }
            ?>
        </td>
        <td>
            <?php echo $Level; ?>
        </td>
        <td>
            <?php
            if ($StatusLogin == 0) {
            ?>
                <button class="btn btn-danger btn-xs" type="button">NON AKTIF</button>
            <?php } elseif ($StatusLogin == 1) {
            ?>
                <button class="btn btn-success btn-xs" type="button">AKTIF</button>
            <?php } ?>
        </td>
        <td>
            <?php
            if ($IdUser == $_SESSION['IdUser']) {
            ?>
            <?php } else { ?>
                <a href="?pg=UserEdit&Kode=<?php echo $IdUser; ?>">
                    <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>
                </a>
                <a href="../App/Model/ExcUser?Act=Delete&Kode=<?php echo $IdUser; ?>" onclick="return confirm('Anda yakin ingin menghapus : <?php echo $NameAkses; ?> ?');">
                    <button class="btn btn-outline btn-danger  btn-xs " data-toggle="tooltip" title="Delete"><i class="fa fa-eraser"></i></button>
                </a>
            <?php } ?>
        </td>
    </tr>
<?php $Nomor++;
}
?>

<!-- Pagination -->
<tr>
    <td colspan="8">
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
                                <a class="page-link" href="?pg=UserView&page=<?php echo $page - 1; ?>">Previous</a>
                            </li>
                        <?php endif; ?>

                        <?php
                        $start = max(1, $page - 2);
                        $end = min($totalPages, $page + 2);
                        
                        for ($i = $start; $i <= $end; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?pg=UserView&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?pg=UserView&page=<?php echo $page + 1; ?>">Next</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </td>
</tr>