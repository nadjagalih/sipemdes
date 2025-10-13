<?php
// Include safe helpers
require_once __DIR__ . '/../../helpers/safe_helpers.php';

if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);

    $QueryEditUser = mysqli_query($db, "SELECT
	main_user_kecamatan.*,
	master_kecamatan.*,
	leveling_user.*
FROM
	main_user_kecamatan
	INNER JOIN
	leveling_user
	ON
		main_user_kecamatan.IdLevelUserFK = leveling_user.IdLevelUser
	INNER JOIN
	master_kecamatan
	ON
		main_user_kecamatan.IdKecamatanFK = master_kecamatan.IdKecamatan
WHERE
	main_user_kecamatan.IdUser = '$IdTemp'");
    $EditUser = mysqli_fetch_assoc($QueryEditUser);

    // Safe array access with fallback values
    $EditIdUser = safeGet($EditUser, 'IdUser', '');
    $EditNameAkses = safeGet($EditUser, 'NameAkses', '');
    $EditNamePassword = safeGet($EditUser, 'NamePassword', '');
    $EditIdLevelUserFK = safeGet($EditUser, 'IdLevelUserFK', '');
    $EditUserLevel = safeGet($EditUser, 'UserLevel', '');
    $EditStatus = safeGet($EditUser, 'Status', '');
    $EditStatusLogin = safeGet($EditUser, 'StatusLogin', '');
    $EditSetting = safeGet($EditUser, 'Setting', '');
    $EditIdKecamatanFK = safeGet($EditUser, 'IdKecamatanFK', '');
    $EditNamaKecamatan = safeGet($EditUser, 'Kecamatan', '');
    $EditNama = safeGet($EditUser, 'Nama', '');
} else {
    // Initialize empty values if no Kode parameter
    $EditIdUser = '';
    $EditNameAkses = '';
    $EditNamePassword = '';
    $EditIdLevelUserFK = '';
    $EditUserLevel = '';
    $EditStatus = '';
    $EditStatusLogin = '';
    $EditSetting = '';
    $EditIdKecamatanFK = '';
    $EditNamaKecamatan = '';
    $EditNama = '';
}
?>
