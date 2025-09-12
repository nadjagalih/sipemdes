<?php
$IdTemp = $_SESSION['IdUser'];

$QueryPegawaiDetail = mysqli_query($db, "SELECT * FROM main_user_kecamatan WHERE IdUser = '$IdTemp' ");
$DataPegawaiDetail = mysqli_fetch_assoc($QueryPegawaiDetail);
$NamaPegawai = $DataPegawaiDetail['Nama'];
