<?php
include "../App/Control/FunctionSessionKecamatan.php";
include "../App/Control/FunctionProfilePegawaiUserKecamatan.php";

if (isset($_GET['pg']) && $_GET['pg'] == 'ViewMasaPensiunKec') {
    $_SESSION['visited_pensiun_kecamatan'] = true;
}

// Get all desa under this kecamatan
$IdKecamatan = $_SESSION['IdKecamatan'];
$desaIds = [];
$qDesa = mysqli_query($db, "SELECT IdDesa FROM master_desa WHERE IdKecamatanFK='$IdKecamatan'");
while ($d = mysqli_fetch_assoc($qDesa))
    $desaIds[] = $d['IdDesa'];
$desaList = implode(',', $desaIds);

// Count pegawai pensiun in next 3 months for all desa in this kecamatan
$notifPensiun = 0;
if ($desaList) {
    $qPensiun = mysqli_query($db, "SELECT COUNT(*) as jumlah
        FROM master_pegawai
        WHERE Setting = 1
          AND IdDesaFK IN ($desaList)
          AND TanggalPensiun IS NOT NULL
          AND TanggalPensiun BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 MONTH)
    ");
    if ($row = mysqli_fetch_assoc($qPensiun)) {
        $notifPensiun = $row['jumlah'];
    }
}
$showNotif = ($notifPensiun > 0 && empty($_SESSION['visited_pensiun_kecamatan']));
?>
<div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
        <li class="nav-header">
            <div class="dropdown profile-element">

                <img style="width:80px; height:auto" alt="image" class="rounded-circle"
                    src="../Vendor/Media/Logo/Kabupaten.png">


                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="block m-t-xs font-bold">
                        <?php echo $NamaPegawai; ?></span>
                    <span class="text-muted text-xs block"><?php echo $Level; ?></span>
                </a>
            </div>
            <div class="logo-element"></div>
        </li>
        <li class="<?php echo ($_GET['pg'] == 'Kecamatan') ? 'active' : ''; ?>">
            <a href="?pg=Kecamatan"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span></a>
        </li>

        <li class="<?php echo ($_GET['pg'] == 'ViewPegawaiReportKec') ? 'active' : ''; ?>">
            <a href="?pg=ViewPegawaiReportKec"><i class="fa fa-th-large"></i> <span class="nav-label">Laporan</span></a>
        </li>

        <li class="<?php echo ($_GET['pg'] == 'ReportBPDKec') ? 'active' : ''; ?>">
            <a href="?pg=ReportBPDKec"><i class="fa fa-th-large"></i> <span class="nav-label">Laporan BPD</span></a>
        </li>

        <li>
            <a href="#">
                <i class="fa fa-print"></i>
                <span class="nav-label">Laporan Pensiun</span>
                <?php if ($showNotif): ?>
                    <span class="badge-notif"><?php echo $notifPensiun > 9 ? '9+' : $notifPensiun; ?></span>
                <?php endif; ?>
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse">
                <li><a href="?pg=ViewMasaPensiunKadesKec">Waktu Pensiun Kades</a></li>
                <li>
                    <a href="?pg=ViewMasaPensiunKec">
                        Waktu Pensiun Perangkat Desa
                        <?php if ($notifPensiun > 0): ?>
                            <span class="badge-notif"
                                style="font-size:10px;"><?php echo $notifPensiun > 9 ? '9+' : $notifPensiun; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li><a href="?pg=ViewPensiunKec">Data Pensiun</a></li>
            </ul>
        </li>

        <li class="<?php echo ($_GET['pg'] == 'FileViewKecamatan') ? 'active' : ''; ?>">
            <a href="?pg=FileViewKecamatan"><i class="fa fa-upload"></i> <span class="nav-label">Upload File</span></a>
        </li>

        <li class="<?php echo ($_GET['pg'] == 'PassKecamatan') ? 'active' : ''; ?>">
            <a href="?pg=PassKecamatan"><i class="fa fa-terminal"></i> <span class="nav-label">Ganti Password</span></a>
        </li>
        <li class="special_link">
            <a href="../Auth/SignOut"><i class="fa fa-power-off"></i> <span class="nav-label">Keluar</span></a>
        </li>
    </ul>

</div>