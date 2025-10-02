<?php
include "../App/Control/FunctionSession.php";
include "../App/Control/FunctionProfilePegawaiUser.php";

$pg = isset($_GET['pg']) ? $_GET['pg'] : '';

echo '<style>
    /* Override semua warna hijau dengan prioritas tinggi */
    .nav > li.active,
    .nav > li.active > a,
    .sidebar-collapse .nav > li.active,
    .sidebar-collapse .nav > li.active > a,
    li.active,
    li.active > a {
        background-color: transparent !important;
        background: transparent !important;
        border-left: none !important;
        border-color: transparent !important;
    }
    
    .sidebar-collapse {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 220px;
        overflow-y: auto;
        background: #fff;
        z-index: 1000;
        box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);
        transition: all 0.3s ease;
    }

    body.mini-navbar .sidebar-collapse {
        width: 70px;
        overflow: visible;
    }

    body.mini-navbar .nav-header {
        padding: 0.5rem;
    }

    body.mini-navbar .profile-element {
        display: none;
    }

    body.mini-navbar .sidebar-collapse .logo-element {
        display: block !important;
    }

    body.mini-navbar .nav-label,
    body.mini-navbar .fa.arrow {
        display: none !important;
    }

    body.mini-navbar .nav > li > a {
        padding: 0.75rem;
        justify-content: center;
    }

    body.mini-navbar .nav > li > a i {
        margin-right: 0;
        font-size: 1.1rem;
    }

    body.mini-navbar .metismenu .collapse {
        position: absolute;
        left: 70px;
        top: 0;
        width: 220px;
        background: #fff;
        border-radius: 0.375rem;
        box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);
    }
    
    .nav-header {
        position: sticky;
        top: 0;
        padding: 1.5rem;
        text-align: center;
        background: linear-gradient(87deg, rgba(17, 205, 239, 0.1) 0, rgba(17, 113, 239, 0.1) 100%) !important;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        z-index: 1;
        transition: padding 0.3s ease;
    }

    .logo-element {
        text-align: center;
        font-size: 18px;
        font-weight: 600;
        color: #5e72e4;
        display: none;
        padding: 10px 0;
    }
    .nav-header img {
        width: 80px;
        height: 80px;
        border: 3px solid #fff;
        border-radius: 50%;
        box-shadow: 0 0 20px rgba(0,0,0,.08);
        transition: transform 0.3s ease;
    }
    .nav-header img:hover {
        transform: scale(1.05);
    }
    .profile-element {
        text-align: center;
    }
    .block {
        display: block;
        color: #32325d;
        margin-top: 0.75rem;
        font-weight: 600;
    }
    .nav.metismenu {
        background: #fff;
        padding: 0.5rem;
    }
    .nav > li {
        margin: 0.25rem 0;
        border-radius: 0.375rem;
        overflow: hidden;
    }
    .nav > li > a {
        padding: 0.75rem 1rem;
        color: #525f7f;
        display: flex;
        align-items: center;
        border-radius: 0.375rem;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.15s ease;
        position: relative;
        overflow: hidden;
    }
    .nav > li > a:hover, .nav > li > a:focus {
        color: #0d6efd !important;
        background: rgba(13, 110, 253, 0.1) !important;
    }
    .sidebar-collapse .nav > li.active > a,
    .nav > li.active > a {
        color: #fff !important;
        background: linear-gradient(87deg, #0d6efd 0, #0b5ed7 100%) !important;
        background-color: transparent !important;
        box-shadow: 0 4px 6px rgba(50,50,93,.11), 0 1px 3px rgba(0,0,0,.08) !important;
        border-left: none !important;
        border: none !important;
        border-radius: 0.5rem !important;
    }
    .nav > li > a i {
        margin-right: 0.75rem;
        width: 1.25rem;
        font-size: 1rem;
        text-align: center;
        opacity: 0.8;
        transition: all 0.15s ease;
    }
    
    .fa.arrow {
        float: right;
        font-size: 12px;
        margin-left: auto;
        transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        line-height: 1.5;
        opacity: 0.5;
        transform-origin: center;
        will-change: transform;
    }
    
    .nav > li.active > a .fa.arrow {
        transform: rotate(90deg);
        opacity: 1;
    }
    
    .nav-second-level {
        padding: 0.75rem 0;
        margin: 0.5rem 0.75rem;
        border-radius: 0.75rem;
        background: rgba(13, 110, 253, 0.1);
        border: 1px solid rgba(13, 110, 253, 0.2);
        box-shadow: 0 8px 25px rgba(13,110,253,0.1), 0 3px 10px rgba(13,110,253,0.05);
        visibility: hidden;
        opacity: 0;
        height: 0;
        transform: translateY(-15px) scale(0.95);
        transition: opacity 0.3s cubic-bezier(.4,0,.2,1), transform 0.3s cubic-bezier(.4,0,.2,1), visibility 0s linear 0.3s, height 0s linear 0.3s;
        will-change: transform, opacity;
        backdrop-filter: blur(15px);
        position: relative;
        overflow: hidden;
    }
    
    .nav-second-level.collapse.in {
        visibility: visible;
        opacity: 0.95;
        height: auto;
        transform: translateY(0) scale(1);
        transition: opacity 0.3s cubic-bezier(.4,0,.2,1), transform 0.3s cubic-bezier(.4,0,.2,1);
    }

    .nav-second-level li {
        position: relative;
        margin: 2px 8px;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .nav-second-level li:before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        opacity: 0.3;
        transition: opacity 0.3s ease;
        border-radius: 0 2px 2px 0;
    }

    .nav-second-level li:hover:before {
        opacity: 1;
    }

    .nav-second-level li a {
        padding: 0.75rem 1rem;
        color: #0d6efd;
        display: block;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(.4,0,.2,1);
        position: relative;
        border-radius: 0.5rem;
        margin: 2px 0;
    }

    .nav-second-level li a:before {
        display: none;
    }

    .nav-second-level li a:hover {
        color: #fff;
        background: rgba(13, 110, 253, 0.7);
        box-shadow: 0 4px 12px rgba(13,110,253,0.15);
        transform: translateX(4px);
    }



    .sidebar-collapse .nav-second-level li.active a,
    .nav-second-level li.active a {
        color: #fff !important;
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%) !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 15px rgba(13,110,253,0.3) !important;
        border-left: none !important;
        border: none !important;
        transform: translateX(4px) !important;
        border-radius: 0.5rem !important;
    }


    
    /* Reset all menu items to default state */
    .nav > li > a {
        background: transparent !important;
        color: #525f7f !important;
        border-radius: 0.375rem;
        margin: 2px 8px;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }
    
    /* Override for active items */
    .nav > li.active > a {
        color: #fff !important;
        background: linear-gradient(87deg, #0d6efd 0, #0b5ed7 100%) !important;
        box-shadow: 0 4px 6px rgba(50,50,93,.11), 0 1px 3px rgba(0,0,0,.08) !important;
    }
    
    .nav-second-level li a {
        background: transparent !important;
        color: #495057 !important;
    }
    
    .nav-second-level li.active a {
        color: #fff !important;
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%) !important;
    }
    
    /* Force reset all menu items */
    .nav li {
        background: transparent !important;
    }
    
    .nav > li > a:hover,
    .nav > li > a:focus {
        background: rgba(13, 110, 253, 0.6) !important;
        color: #fff !important;
    }
    
    /* Active state overrides */
    .nav > li.active > a,
    .nav > li.active > a:hover,
    .nav > li.active > a:focus {
        color: #fff !important;
        background: linear-gradient(87deg, #0d6efd 0, #0b5ed7 100%) !important;
        box-shadow: 0 4px 6px rgba(50,50,93,.11), 0 1px 3px rgba(0,0,0,.08) !important;
    }
    
    .nav-second-level li.active a,
    .nav-second-level li.active a:hover,
    .nav-second-level li.active a:focus {
        color: #fff !important;
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%) !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 15px rgba(13,110,253,0.3) !important;
        transform: translateX(4px) !important;
    }
    
    /* Auto expand parent menu when submenu is active */
    .nav > li.active > ul.nav-second-level {
        display: block !important;
    }
    
    .badge-notif {
        background: #f5365c;
        color: #fff;
        padding: 3px 6px;
        font-size: 11px;
        border-radius: 4px;
        margin-left: 5px;
    }

    .special_link a {
        background: #f5365c !important;
        color: #fff !important;
    }
    .special_link a i {
        color: #fff !important;
    }
    
    /* Override final untuk memastikan tidak ada warna hijau */
    * .nav > li.active,
    * .nav > li.active > a,
    * li.active,
    * li.active > a,
    .metismenu li.active,
    .metismenu li.active > a {
        background-color: transparent !important;
        background: transparent !important;
        border-left: none !important;
        border-color: transparent !important;
    }
    
    /* Paksa warna biru untuk menu aktif */
    .sidebar-collapse .nav > li.active > a,
    .sidebar-collapse .metismenu li.active > a,
    .nav.metismenu li.active > a {
        color: #fff !important;
        background: linear-gradient(135deg, #0a0a37 0%, #1845b3 100%) !important;
        background-color: transparent !important;
        box-shadow: 0 4px 6px rgba(50,50,93,.11), 0 1px 3px rgba(0,0,0,.08) !important;
        border: none !important;
    }
</style>';



// Set session when visiting the page
if (isset($_GET['pg']) && ($_GET['pg'] == 'ViewMasaPensiun' || $_GET['pg'] == 'ViewMasaPensiunKades')) {
    $_SESSION['visited_pensiun_sadmin'] = true;
}

// Fungsi untuk menentukan menu aktif
function isActive($page) {
    return (isset($_GET['pg']) && $_GET['pg'] == $page) ? 'active' : '';
}

function isActiveGroup($pages) {
    if (isset($_GET['pg'])) {
        return in_array($_GET['pg'], $pages) ? 'active' : '';
    }
    return '';
}

// Definisi grup menu
$dataMasterPages = [
    'ProfileDinasView', 'KecamatanView', 'DesaView', 'JabatanView', 
    'UserView', 'UserViewKecamatan', 'PegawaiViewAll', 'PegawaiBPDViewAll', 
    'MutasiView', 'FileKategoriView'
];

$dataKeluargaPages = [
    'PegawaiViewSuamiIstri', 'PegawaiViewAnak', 'PegawaiViewOrtu'
];

$laporanPensiunPages = [
    'ViewMasaPensiunKades', 'ViewMasaPensiun', 'ViewPensiun'
];

$laporanTambahanPages = [
    'ViewAdminAplikasi', 'ViewCustomUmur', 'ViewCustomSiltap', 'ViewCustomGender'
];

$rekapitulasiPages = [
    'JabatanPegawaiTerkini', 'ReportPendidikan', 'ReportUnitKerja'
];

//$dataAwardPages = [
//    'AwardView', 'AwardAdd', 'AwardEdit', 'AwardDetail'
//];

// Check if current page is in any group
$isDataMasterActive = isActiveGroup($dataMasterPages);
$isDataKeluargaActive = isActiveGroup($dataKeluargaPages);  
$isLaporanPensiunActive = isActiveGroup($laporanPensiunPages);
$isLaporanTambahanActive = isActiveGroup($laporanTambahanPages);
$isRekapitulasiActive = isActiveGroup($rekapitulasiPages);
//$isDataAwardActive = isActiveGroup($dataAwardPages);

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
        <li class="<?= isActive('SAdmin') ?>">
            <a href="?pg=SAdmin"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span></a>
        </li>

        <li class="<?= $isDataMasterActive ?>">
            <a href="#"><i class="fa fa-database"></i> <span class="nav-label">Data Master</span><span
                    class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse <?= $isDataMasterActive ? 'in' : '' ?>">
                <li class="<?= isActive('ProfileDinasView') ?>"><a href="?pg=ProfileDinasView">Profile Dinas</a></li>
                <li class="<?= isActive('KecamatanView') ?>"><a href="?pg=KecamatanView">Kecamatan</a></li>
                <li class="<?= isActive('DesaView') ?>"><a href="?pg=DesaView">Desa</a></li>
                <li class="<?= isActive('JabatanView') ?>"><a href="?pg=JabatanView">Jabatan</a></li>
                <li class="<?= isActive('UserView') ?>"><a href="?pg=UserView">User</a></li>
                <li class="<?= isActive('UserViewKecamatan') ?>"><a href="?pg=UserViewKecamatan">User Kecamatan</a></li>
                <li class="<?= isActive('PegawaiViewAll') ?>"><a href="?pg=PegawaiViewAll">Entry Kepala Desa & Perangkat Desa</a></li>
                <li class="<?= isActive('PegawaiBPDViewAll') ?>"><a href="?pg=PegawaiBPDViewAll">Entry BPD</a></li>
                <!-- <li><a href="?pg=MutasiView">Jenis Mutasi</a></li> -->
                <li class="<?= isActive('FileKategoriView') ?>"><a href="?pg=FileKategoriView">Kategori File</a></li>
            </ul>
        </li>
        <li class="<?= isActive('PegawaiViewPendidikan') ?>">
            <a href="?pg=PegawaiViewPendidikan"><i class="fa fa-graduation-cap"></i> <span class="nav-label">Data
                    Pendidikan</span></a>
            <!-- <ul class="nav nav-second-level collapse">
                <li><a href="">Pendidikan</a></li>
            </ul> -->
        </li>
        <li class="<?= isActive('ViewMutasi') ?>">
            <a href="?pg=ViewMutasi"><i class="fa fa-exchange"></i> <span class="nav-label">Data Mutasi</span></a>
            <!-- <ul class="nav nav-second-level collapse">
                <li><a href="">Mutasi</a></li>
            </ul> -->
        </li>
        <li class="<?= $isDataKeluargaActive ?>">
            <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Data Keluarga</span><span
                    class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse <?= $isDataKeluargaActive ? 'in' : '' ?>">
                <li class="<?= isActive('PegawaiViewSuamiIstri') ?>"><a href="?pg=PegawaiViewSuamiIstri">Suami/Istri</a></li>
                <li class="<?= isActive('PegawaiViewAnak') ?>"><a href="?pg=PegawaiViewAnak">Anak</a></li>
                <li class="<?= isActive('PegawaiViewOrtu') ?>"><a href="?pg=PegawaiViewOrtu">Orang Tua</a></li>
            </ul>
        </li>
        <li class="<?= isActive('AwardView') ?>">
            <a href="?pg=AwardView"><i class="fa fa-trophy"></i> <span class="nav-label">Daftar Award Desa</span></a>
        </li>
        <li class="<?= isActive('ViewPegawaiReport') ?>">
            <a href="?pg=ViewPegawaiReport"><i class="fa fa-print"></i> <span class="nav-label">Laporan</span></a>
            <!-- <ul class="nav nav-second-level collapse">
                <li><a href="">Semua Data</a></li>
            </ul> -->
        </li>
        <li class="<?= $isLaporanPensiunActive ?>">
            <a href="#">
                <i class="fa fa-print"></i>
                <span class="nav-label">Laporan Pensiun</span>
                <?php if ($showNotif): ?>
                    <span class="badge-notif"><?php echo $notifPensiun > 9 ? '9+' : $notifPensiun; ?></span>
                <?php endif; ?>
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse <?= $isLaporanPensiunActive ? 'in' : '' ?>">
                <li class="<?= isActive('ViewMasaPensiunKades') ?>"><a href="?pg=ViewMasaPensiunKades">Waktu Pensiun Kades</a></li>
                <li class="<?= isActive('ViewMasaPensiun') ?>">
                    <a href="?pg=ViewMasaPensiun">
                        Waktu Pensiun Perangkat Desa
                        <?php if ($showNotif): ?>
                            <span class="badge-notif"
                                style="font-size:10px;"><?php echo $notifPensiun > 9 ? '9+' : $notifPensiun; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="<?= isActive('ViewPensiun') ?>"><a href="?pg=ViewPensiun">Data Pensiun</a></li>
            </ul>
        </li>
        <li class="<?= isActive('ReportBPD') ?>">
            <a href="?pg=ReportBPD"><i class="fa fa-print"></i> <span class="nav-label">Laporan BPD</span></a>
            <!-- <ul class="nav nav-second-level collapse">
                <li><a href="">BPD</a></li>
            </ul> -->
        </li>
        <li class="<?= $isLaporanTambahanActive ?>">
            <a href="#"><i class="fa fa-print"></i> <span class="nav-label">Laporan Tambahan</span><span
                    class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse <?= $isLaporanTambahanActive ? 'in' : '' ?>">
                <li class="<?= isActive('ViewAdminAplikasi') ?>"><a href="?pg=ViewAdminAplikasi">Admin Desa</a></li>
                <li class="<?= isActive('ViewCustomUmur') ?>"><a href="?pg=ViewCustomUmur">Berdasarkan Umur</a></li>
                <li class="<?= isActive('ViewCustomSiltap') ?>"><a href="?pg=ViewCustomSiltap">Berdasarkan Siltap</a></li>
                <li class="<?= isActive('ViewCustomGender') ?>"><a href="?pg=ViewCustomGender">Berdasarkan Gender</a></li>
            </ul>
        </li>
        <li class="<?= $isRekapitulasiActive ?>">
            <a href="#"><i class="fa fa-tasks"></i> 
                <span class="nav-label">Rekapitulasi</span><span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse <?= $isRekapitulasiActive ? 'in' : '' ?>">
                <li class="<?= isActive('JabatanPegawaiTerkini') ?>">
                    <a href="?pg=JabatanPegawaiTerkini">Jabatan</a>
                </li>
                <li class="<?= isActive('ReportPendidikan') ?>">
                    <a href="?pg=ReportPendidikan">Pendidikan</a>
                </li>
                <li class="<?= isActive('ReportUnitKerja') ?>">
                    <a href="?pg=ReportUnitKerja">Unit Kerja</a>
                </li>
            </ul>
        </li>
        <li class="<?= isActive('FileViewAdmin') ?>">
            <a href="?pg=FileViewAdmin"><i class="fa fa-upload"></i> <span class="nav-label">Upload File</span></a>
        </li>
        <li class="<?= isActive('Pass') ?>">
            <a href="?pg=Pass"><i class="fa fa-terminal"></i> <span class="nav-label">Ganti Password</span></a>
        </li>
        <li class="special_link">
            <a href="../Auth/SignOut"><i class="fa fa-power-off"></i> <span class="nav-label">Keluar</span></a>
        </li>

        <li class="<?= isActive('ViewPegawaiReportExcel') ?>">
            <a href="?pg=ViewPegawaiReportExcel"><i class="fa fa-print"></i> <span class="nav-label">Laporan
                    Excel</span></a>
            <!-- <ul class="nav nav-second-level collapse">
                <li><a href="">Semua Data</a></li>
            </ul> -->
        </li>

    </ul>

</div>

<script>
$(document).ready(function() {
    // Auto expand menu yang memiliki submenu aktif
    $('.nav-second-level li.active').parents('.nav > li').addClass('active');
    $('.nav-second-level li.active').parents('.collapse').addClass('in');
    
    // Pastikan icon arrow berubah untuk menu yang expanded
    $('.nav > li.active > a').attr('aria-expanded', 'true');
    $('.nav > li.active > .nav-second-level').show();
});
</script>