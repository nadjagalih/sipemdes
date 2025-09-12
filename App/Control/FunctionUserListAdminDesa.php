<?php
$IdDesa = $_SESSION['IdDesa'];
$Nomor = 1;
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
WHERE master_pegawai.IdDesaFK= '$IdDesa'
ORDER BY leveling_user.IdLevelUser ASC");
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
                <a href="?pg=UserResetAdminDesa&Kode=<?php echo $IdUser; ?>">
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
            $Desa = $DataDesa['NamaDesa'];
            $Kecamatan = $DataDesa['Kecamatan'];
            echo $Desa . " - " . $Kecamatan;
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
                <a href="?pg=UserEditAdminDesa&Kode=<?php echo $IdUser; ?>">
                    <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>
                </a>
                <a href="../App/Model/ExcUserAdminDesa?Act=Delete&Kode=<?php echo $IdUser; ?>" onclick="return confirm('Anda yakin ingin menghapus : <?php echo $NameAkses; ?> ?');">
                    <button class="btn btn-outline btn-danger  btn-xs " data-toggle="tooltip" title="Delete"><i class="fa fa-eraser"></i></button>
                </a>
            <?php } ?>
        </td>
    </tr>
<?php $Nomor++;
}
?>