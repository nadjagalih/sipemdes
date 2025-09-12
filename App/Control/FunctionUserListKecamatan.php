<?php
$Nomor = 1;
$QueryUser = mysqli_query($db, "SELECT
	main_user_kecamatan.*,
	master_kecamatan.*,
	leveling_user.*
FROM
	main_user_kecamatan
	INNER JOIN
	master_kecamatan
	ON
		main_user_kecamatan.IdKecamatanFK = master_kecamatan.IdKecamatan
	INNER JOIN
	leveling_user
	ON
		main_user_kecamatan.IdLevelUserFK = leveling_user.IdLevelUser
ORDER BY
	master_kecamatan.IdKecamatan ASC");
while ($DataUser = mysqli_fetch_assoc($QueryUser)) {
    $IdUser = $DataUser['IdUser'];
    $NameAkses = $DataUser['NameAkses'];
    $Level = $DataUser['UserLevel'];
    $Status = $DataUser['Status'];
    $StatusLogin = $DataUser['StatusLogin'];
    $Setting = $DataUser['Setting'];
    $Nama = $DataUser['Nama'];
    $IdKecamatan = $DataUser['IdKecamatanFK'];
    $Kecamatan = $DataUser['Kecamatan'];


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
                <a href="?pg=UserResetKecamatan&Kode=<?php echo $IdUser; ?>">
                    <button class="btn btn-warning btn-xs" data-toggle="tooltip" title="Reset Password">Reset</button>
                </a>
            </span>
        </td>
        <td>
            <?php echo $Kecamatan; ?>
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
                <a href="?pg=UserEditKecamatan&Kode=<?php echo $IdUser; ?>">
                    <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>
                </a>
                <a href="../App/Model/ExcUserKecamatan?Act=Delete&Kode=<?php echo $IdUser; ?>" onclick="return confirm('Anda yakin ingin menghapus : <?php echo $NameAkses; ?> ?');">
                    <button class="btn btn-outline btn-danger  btn-xs " data-toggle="tooltip" title="Delete"><i class="fa fa-eraser"></i></button>
                </a>
            <?php } ?>
        </td>
    </tr>
<?php $Nomor++;
}
?>