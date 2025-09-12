<?php
include "../App/Control/FunctionSession.php";
include "../App/Control/FunctionProfilePegawaiUser.php";

$pg = isset($_GET['pg']) ? $_GET['pg'] : '';
$activePagesRekapitulasi = [
        "JabatanPegawaiTerkini",
        "ReportPendidikan",
        "ReportUnitKerja"
    ];

// Set session when visiting the page
if (isset($_GET['pg']) && ($_GET['pg'] == 'ViewMasaPensiun' || $_GET['pg'] == 'ViewMasaPensiunKades')) {
    $_SESSION['visited_pensiun_sadmin'] = true;
}

// Count pegawai pensiun in next 5 years (all desa, all kecamatan)
$notifPensiun = 0;
$qPensiun = mysqli_query($db, "SELECT COUNT(*) as jumlah
    FROM master_pegawai
    WHERE Setting = 1
      AND TanggalPensiun IS NOT NULL
      AND TanggalPensiun BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 MONTH)
");
if ($row = mysqli_fetch_assoc($qPensiun)) {
    $notifPensiun = $row['jumlah'];
}
$showNotif = ($notifPensiun > 0 && empty($_SESSION['visited_pensiun_sadmin']));
?>
<div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
        <li class="nav-header">
            <div class="dropdown profile-element">
                <?php
                if (empty($Foto)) {
                    ?>
                    <img style="width:80px; height:auto" alt="image" class="rounded-circle"
                        src="../Vendor/Media/Pegawai/no-image.jpg">
                <?php } else { ?>
                    <img style="width:80px; height:auto" alt="image" class="rounded-circle"
                        src="../Vendor/Media/Pegawai/<?php echo $Foto; ?>" />
                <?php } ?>

                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="block m-t-xs font-bold">
                        <?php echo $NamaPegawai; ?></span>
                    <span class="text-muted text-xs block"><?php echo $Level; ?></span>
                </a>
            </div>
            <div class="logo-element"></div>
        </li>
        <li class="active">
            <a href="?pg=SAdmin"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span></a>
        </li>

        <li>
            <a href="#"><i class="fa fa-database"></i> <span class="nav-label">Data Master</span><span
                    class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                <li><a href="?pg=ProfileDinasView">Profile Dinas</a></li>
                <li><a href="?pg=KecamatanView">Kecamatan</a></li>
                <li><a href="?pg=DesaView">Desa</a></li>
                <li><a href="?pg=JabatanView">Jabatan</a></li>
                <li><a href="?pg=UserView">User</a></li>
                <li><a href="?pg=UserViewKecamatan">User Kecamatan</a></li>
                <li><a href="?pg=PegawaiViewAll">Entry Kepala Desa & Perangkat Desa</a></li>
                <li><a href="?pg=PegawaiBPDViewAll">Entry BPD</a></li>
                <!-- <li><a href="?pg=MutasiView">Jenis Mutasi</a></li> -->
                <li><a href="?pg=FileKategoriView">Kategori File</a></li>
            </ul>
        </li>
        <li>
            <a href="?pg=PegawaiViewPendidikan"><i class="fa fa-graduation-cap"></i> <span class="nav-label">Data
                    Pendidikan</span></a>
            <!-- <ul class="nav nav-second-level collapse">
                <li><a href="">Pendidikan</a></li>
            </ul> -->
        </li>
        <li>
            <a href="?pg=ViewMutasi"><i class="fa fa-exchange"></i> <span class="nav-label">Data Mutasi</span></a>
            <!-- <ul class="nav nav-second-level collapse">
                <li><a href="">Mutasi</a></li>
            </ul> -->
        </li>
        <li>
            <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Data Keluarga</span><span
                    class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                <li><a href="?pg=PegawaiViewSuamiIstri">Suami/Istri</a></li>
                <li><a href="?pg=PegawaiViewAnak">Anak</a></li>
                <li><a href="?pg=PegawaiViewOrtu">Orang Tua</a></li>
            </ul>
        </li>
        <li>
            <a href="?pg=ViewPegawaiReport"><i class="fa fa-print"></i> <span class="nav-label">Laporan</span></a>
            <!-- <ul class="nav nav-second-level collapse">
                <li><a href="">Semua Data</a></li>
            </ul> -->
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
                <li><a href="?pg=ViewMasaPensiunKades">Waktu Pensiun Kades</a></li>
                <li>
                    <a href="?pg=ViewMasaPensiun">
                        Waktu Pensiun Perangkat Desa
                        <?php if ($showNotif): ?>
                            <span class="badge-notif"
                                style="font-size:10px;"><?php echo $notifPensiun > 9 ? '9+' : $notifPensiun; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li><a href="?pg=ViewPensiun">Data Pensiun</a></li>
            </ul>
        </li>
        <li>
            <a href="?pg=ReportBPD"><i class="fa fa-print"></i> <span class="nav-label">Laporan BPD</span></a>
            <!-- <ul class="nav nav-second-level collapse">
                <li><a href="">BPD</a></li>
            </ul> -->
        </li>
        <li>
            <a href="#"><i class="fa fa-print"></i> <span class="nav-label">Laporan Tambahan</span><span
                    class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                <li><a href="?pg=ViewAdminAplikasi">Admin Desa</a></li>
                <li><a href="?pg=ViewCustomUmur">Berdasarkan Umur</a></li>
                <li><a href="?pg=ViewCustomSiltap">Berdasarkan Siltap</a></li>
                <li><a href="?pg=ViewCustomGender">Berdasarkan Gender</a></li>
            </ul>
        </li>
        <li class="<?= $isActiveRekapitulasi ? 'active' : '' ?>">
            <a href="#"><i class="fa fa-tasks"></i> 
                <span class="nav-label">Rekapitulasi</span><span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse <?= $isActiveRekapitulasi ? 'in' : '' ?>">
                <li class="<?= ($_GET['pg'] ?? '') == 'JabatanPegawaiTerkini' ? 'active' : '' ?>">
                    <a href="?pg=JabatanPegawaiTerkini">Jabatan</a>
                </li>
                <li class="<?= ($_GET['pg'] ?? '') == 'ReportPendidikan' ? 'active' : '' ?>">
                    <a href="?pg=ReportPendidikan">Pendidikan</a>
                </li>
                <li class="<?= ($_GET['pg'] ?? '') == 'ReportUnitKerja' ? 'active' : '' ?>">
                    <a href="?pg=ReportUnitKerja">Unit Kerja</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="?pg=FileViewAdmin"><i class="fa fa-upload"></i> <span class="nav-label">Upload File</span></a>
        </li>
        <li>
            <a href="?pg=Pass"><i class="fa fa-terminal"></i> <span class="nav-label">Ganti Password</span></a>
        </li>
        <li class="special_link">
            <a href="../Auth/SignOut"><i class="fa fa-power-off"></i> <span class="nav-label">Keluar</span></a>
        </li>

        <li>
            <a href="?pg=ViewPegawaiReportExcel"><i class="fa fa-print"></i> <span class="nav-label">Laporan
                    Excel</span></a>
            <!-- <ul class="nav nav-second-level collapse">
                <li><a href="">Semua Data</a></li>
            </ul> -->
        </li>

    </ul>

</div>