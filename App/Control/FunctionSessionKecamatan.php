<?php
$IdUser = $_SESSION['IdUser'];
$QueryNamaPegawai = mysqli_query($db, "SELECT * FROM main_user_kecamatan WHERE  IdUser = '$IdUser' ");
$GetNamaPegawai = mysqli_fetch_assoc($QueryNamaPegawai);
$NamaPegawai = $GetNamaPegawai['Nama'];
