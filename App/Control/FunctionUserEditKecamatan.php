<?php
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

    $EditIdUser = $EditUser['IdUser'];
    $EditNameAkses = $EditUser['NameAkses'];
    $EditNamePassword = $EditUser['NamePassword'];
    $EditIdLevelUserFK = $EditUser['IdLevelUserFK'];
    $EditUserLevel = $EditUser['UserLevel'];
    $EditStatus = $EditUser['Status'];
    $EditStatusLogin = $EditUser['StatusLogin'];
    $EditSetting = $EditUser['Setting'];
    $EditIdKecamatanFK = $EditUser['IdKecamatanFK'];
    $EditNamaKecamatan = $EditUser['Kecamatan'];
    $EditNama = $EditUser['Nama'];
}
