<?php
// Total Award
$QueryTotalAward = mysqli_query($db, "SELECT COUNT(*) as total FROM master_award_desa WHERE Setting = 1");
$DataTotalAward = mysqli_fetch_assoc($QueryTotalAward);
$TotalAward = $DataTotalAward['total'];

// Award Aktif
$QueryAwardAktif = mysqli_query($db, "SELECT COUNT(*) as total FROM master_award_desa WHERE Setting = 1 AND StatusAktif = 'Aktif'");
$DataAwardAktif = mysqli_fetch_assoc($QueryAwardAktif);
$AwardAktif = $DataAwardAktif['total'];

// Award Nonaktif
$QueryAwardNonaktif = mysqli_query($db, "SELECT COUNT(*) as total FROM master_award_desa WHERE Setting = 1 AND StatusAktif = 'Nonaktif'");
$DataAwardNonaktif = mysqli_fetch_assoc($QueryAwardNonaktif);
$AwardNonaktif = $DataAwardNonaktif['total'];

// Award Tahun Ini
$TahunIni = date('Y');
$QueryAwardTahunIni = mysqli_query($db, "SELECT COUNT(*) as total FROM master_award_desa WHERE Setting = 1 AND TahunPenghargaan = '$TahunIni'");
$DataAwardTahunIni = mysqli_fetch_assoc($QueryAwardTahunIni);
$AwardTahunIni = $DataAwardTahunIni['total'];
?>