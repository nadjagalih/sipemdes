<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);

    $QueryEditUser = mysqli_query($db, "SELECT
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
    master_pegawai.Setting,
    leveling_user.IdLevelUser,
    leveling_user.UserLevel
    FROM
    master_pegawai
    INNER JOIN main_user ON master_pegawai.IdPegawaiFK = main_user.IdPegawai
    INNER JOIN leveling_user ON main_user.IdLevelUserFK = leveling_user.IdLevelUser
    WHERE main_user.IdUser = '$IdTemp'");
    $EditUser = mysqli_fetch_assoc($QueryEditUser);

    $EditIdUser = $EditUser['IdUser'];
    $EditNameAkses = $EditUser['NameAkses'];
    $EditNamePassword = $EditUser['NamePassword'];
    $EditIdLevelUserFK = $EditUser['IdLevelUserFK'];
    $EditUserLevel = $EditUser['UserLevel'];
    $EditStatus = $EditUser['Status'];
    $EditStatusLogin = $EditUser['StatusLogin'];
    $EditSetting = $EditUser['Setting'];
    $EditNIK = $EditUser['NIK'];
    $EditNama = $EditUser['Nama'];
}
