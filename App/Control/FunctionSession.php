<?php
$IdPegawai = $_SESSION['IdPegawai'];
$QueryNamaPegawai = mysqli_query($db, "SELECT
master_pegawai.IdPegawaiFK,
master_pegawai.Nama,
main_user.IdPegawai,
main_user.IdLevelUserFK,
leveling_user.IdLevelUser,
leveling_user.UserLevel
FROM
master_pegawai
INNER JOIN main_user ON main_user.IdPegawai = master_pegawai.IdPegawaiFK
INNER JOIN leveling_user ON main_user.IdLevelUserFK = leveling_user.IdLevelUser
WHERE master_pegawai.IdPegawaiFK = '$IdPegawai' ");
$GetNamaPegawai = mysqli_fetch_assoc($QueryNamaPegawai);
$NamaPegawai = $GetNamaPegawai['Nama'];
$Level = $GetNamaPegawai['UserLevel'];
