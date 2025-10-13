<?php
// Include CSP Handler for nonce
require_once "../Module/Security/CSPHandler.php";

// ===============================================
// ALERT NOTIFICATIONS
// ===============================================
if (empty($_GET['alert'])) {
    echo "";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'Sukses') {
    echo "<script type='text/javascript' " . CSPHandler::scriptNonce() . ">
            setTimeout(function () {
                swal({
                    title: 'Sukses Ajukan SK Pensiun',
                    text: 'SK Pensiun telah berhasil diajukan.',
                    type: 'success'
                });
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'Gagal') {
    echo "<script type='text/javascript' " . CSPHandler::scriptNonce() . ">
            setTimeout(function () {
                swal({
                    title: 'Gagal Ajukan SK Pensiun',
                    text: 'SK Pensiun telah gagal diajukan.',
                    type: 'warning'
                });
            }, 100);
          </script>";
}

include "../App/Control/FunctionProfileDinasView.php";
include "../App/Control/FunctionProfilePegawaiUser.php";

$IdKecamatan = $_SESSION['IdKecamatan'];
$TglSaatIni = date('d-m-Y');

// ===============================================
// DATABASE QUERIES
// ===============================================

// Query 1: Data Header Kecamatan dengan join ke kabupaten
$QHeader = mysqli_query($db, "SELECT 
    master_kecamatan.*, 
    master_setting_profile_dinas.Kabupaten 
    FROM master_kecamatan 
    LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile 
    WHERE master_kecamatan.IdKecamatan = '$IdKecamatan'");

if ($QHeader && mysqli_num_rows($QHeader) > 0) {
    $DataHeader = mysqli_fetch_assoc($QHeader);
    $NamaKecamatanHeader = $DataHeader['Kecamatan'];
    $IdKecamatanHeader = $DataHeader['IdKecamatan'];
    $NoTelepon = $DataHeader['NoTelepon'] ?? '';
    $AlamatKecamatan = $DataHeader['AlamatKecamatan'] ?? '';
    $Latitude = $DataHeader['Latitude'] ?? '';
    $Longitude = $DataHeader['Longitude'] ?? '';
    $Kabupaten = $DataHeader['Kabupaten'] ?? 'Trenggalek';
} else {
    // Fallback jika query gagal
    $NamaKecamatanHeader = 'Trenggalek';
    $IdKecamatanHeader = $IdKecamatan;
    $NoTelepon = '';
    $AlamatKecamatan = '';
    $Latitude = '';
    $Longitude = '';
    $Kabupaten = 'Trenggalek';
}

// Query 2: Total Perangkat Desa per Kecamatan
$QueryPerangkat = mysqli_query($db, "SELECT
                            master_kecamatan.Kecamatan,
                            Count(master_pegawai.IdPegawaiFK) AS JmlPerangkat,
                            master_pegawai.IdPegawaiFK,
                            master_pegawai.Setting,
                            master_desa.IdDesa,
                            master_desa.NamaDesa,
                            master_desa.IdKecamatanFK,
                            master_kecamatan.IdKecamatan,
                            main_user.IdPegawai,
                            main_user.IdLevelUserFK,
                            history_mutasi.IdPegawaiFK,
                            history_mutasi.Setting AS SettingMutasi
                        FROM
                            master_pegawai
                            LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                            LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                            INNER JOIN main_user ON master_pegawai.IdPegawaiFK = main_user.IdPegawai
                            INNER JOIN history_mutasi ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                        WHERE
                            master_pegawai.Setting = 1 AND
                            main_user.IdLevelUserFK <> 1 AND
                            main_user.IdLevelUserFK <> 2 AND
                            master_desa.IdKecamatanFK = '$IdKecamatan' AND
                            history_mutasi.Setting = 1");

if ($QueryPerangkat && mysqli_num_rows($QueryPerangkat) > 0) {
    $DataPerangkat = mysqli_fetch_assoc($QueryPerangkat);
    $Jumlah = $DataPerangkat['JmlPerangkat'];
} else {
    $Jumlah = 0;
}

// Query 3: Data Pegawai Laki-laki
$QJK = mysqli_query($db, "SELECT
                master_jenkel.Keterangan,
                Count(master_pegawai.IdPegawaiFK) AS JumlahJKL,
                master_pegawai.JenKel,
                master_pegawai.IdDesaFK,
                master_pegawai.Setting,
                master_desa.IdDesa,
                master_desa.NamaDesa,
                master_desa.IdKecamatanFK,
                master_kecamatan.IdKecamatan,
                master_kecamatan.Kecamatan,
                main_user.IdPegawai,
                main_user.IdLevelUserFK,
                master_jenkel.IdJenKel,
                history_mutasi.IdPegawaiFK,
                history_mutasi.Setting AS SettingMutasi
                FROM
                master_pegawai
                LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                INNER JOIN main_user ON main_user.IdPegawai = master_pegawai.IdPegawaiFK
                INNER JOIN master_jenkel ON master_pegawai.JenKel = master_jenkel.IdJenKel
                INNER JOIN history_mutasi ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                WHERE master_pegawai.Setting = 1 AND
                main_user.IdLevelUserFK <> 1 AND
                main_user.IdLevelUserFK <> 2 AND
                master_pegawai.JenKel = 1 AND
                master_desa.IdKecamatanFK = '$IdKecamatan' AND
                history_mutasi.Setting = 1
                GROUP BY master_pegawai.JenKel");
if ($QJK && mysqli_num_rows($QJK) > 0) {
    $DataJK = mysqli_fetch_assoc($QJK);
    $LakiLaki = $DataJK['JumlahJKL'] ?? 0;
} else {
    $LakiLaki = 0;
}

// Query 4: Data Pegawai Perempuan
$QJKP = mysqli_query($db, "SELECT
                master_jenkel.Keterangan,
                Count(master_pegawai.IdPegawaiFK) AS JumlahJKP,
                master_pegawai.JenKel,
                master_pegawai.IdDesaFK,
                master_pegawai.Setting,
                master_desa.IdDesa,
                master_desa.NamaDesa,
                master_desa.IdKecamatanFK,
                master_kecamatan.IdKecamatan,
                master_kecamatan.Kecamatan,
                main_user.IdPegawai,
                main_user.IdLevelUserFK,
                master_jenkel.IdJenKel,
                history_mutasi.Setting AS SettingMutasi
                FROM
                master_pegawai
                LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                INNER JOIN main_user ON main_user.IdPegawai = master_pegawai.IdPegawaiFK
                INNER JOIN master_jenkel ON master_pegawai.JenKel = master_jenkel.IdJenKel
                INNER JOIN history_mutasi ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                WHERE master_pegawai.Setting = 1 AND
                main_user.IdLevelUserFK <> 1 AND
                main_user.IdLevelUserFK <> 2 AND
                master_pegawai.JenKel = 2 AND
                master_desa.IdKecamatanFK = '$IdKecamatan' AND
                history_mutasi.Setting = 1
                GROUP BY master_pegawai.JenKel");
if ($QJKP && mysqli_num_rows($QJKP) > 0) {
    $DataJKP = mysqli_fetch_assoc($QJKP);
    $Perempuan = $DataJKP['JumlahJKP'] ?? 0;
} else {
    $Perempuan = 0;
}

?>

<!-- Purple Theme Assets -->
<link href="../Assets/argon/argon.css" rel="stylesheet">
<link href="../Assets/css/local-fonts.css" rel="stylesheet">
<link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">

<!-- Leaflet CSS for Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script <?php echo CSPHandler::scriptNonce(); ?> src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    :root {
        --purple-primary: #6f42c1;
        --purple-secondary: #e8e2ff;
        --purple-light: #f8f7ff;
        --purple-dark: #5a32a3;
        --text-dark: #2c2c54;
        --text-muted: #8e8e93;
        --success: #1bcfb4;
        --warning: #ffb822;
        --danger: #fd397a;
        --info: #0084ff;
        --light-bg: #f8f9fa;
        --white: #ffffff;
        --border-color: #edf2f7;
        --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        --shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        --shadow-lg: 0 1rem 3rem rgba(0, 0, 0, 0.175);
    }

    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Ubuntu', sans-serif;
        background-color: var(--light-bg);
        color: var(--text-dark);
        line-height: 1.6;
        margin: 0;
        padding: 0;
    }

    .main-content {
        min-height: 100vh;
        background-color: var(--light-bg);
        margin: 0;
        padding: 0;
        width: 100%;
    }

    .page-header {
        background: linear-gradient(87deg, #11cdef 0, #1171ef 100%);
        padding: 2rem 0;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="1000,0 1000,100 0,100"/></svg>');
        background-size: cover;
    }

    .page-header-content {
        position: relative;
        z-index: 2;
    }

    .welcome-section {
        text-align: center;
        margin-bottom: 1rem;
    }

    .welcome-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .welcome-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        font-weight: 300;
    }

    .breadcrumb-section {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 1.5rem;
    }

    .breadcrumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
        font-size: 0.9rem;
    }

    .breadcrumb a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
    }

    .breadcrumb .active {
        color: white;
        font-weight: 500;
    }

    .content-wrapper {
        padding: 2rem;
        margin-top: -1rem;
        position: relative;
        z-index: 3;
    }

    .card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .card:hover {
        box-shadow: var(--shadow);
        transform: translateY(-2px);
    }

    .stat-card {
        position: relative;
        overflow: hidden;
    }

    .stat-card .card-body {
        padding: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
        border-radius: 50%;
        transform: translate(30px, -30px);
    }

    .stat-card.purple {
        background: linear-gradient(135deg, var(--purple-primary), var(--purple-dark));
        color: white;
    }

    .stat-card.success {
        background: linear-gradient(135deg, var(--success), #17a2b8);
        color: white;
    }

    .stat-card.warning {
        background: linear-gradient(135deg, var(--warning), #fd7e14);
        color: white;
    }

    .stat-card.danger {
        background: linear-gradient(135deg, var(--danger), #dc3545);
        color: white;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 1rem;
        font-weight: 400;
    }

    .stat-change {
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .stat-icon {
        position: absolute;
        top: 1rem;
        right: 1rem;
        font-size: 2rem;
        opacity: 0.3;
    }

    .chart-card {
        background: var(--white);
        border-radius: 0.5rem;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .chart-card .card-header {
        background: var(--white);
        border-bottom: 1px solid var(--border-color);
        padding: 1.5rem;
        border-radius: 0;
    }

    .chart-card .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
    }

    .chart-card .card-subtitle {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0.25rem 0 0 0;
    }

    .chart-card .card-body {
        padding: 1.5rem;
    }

    /* Chart Container Centering */
    .chart-container,
    #GrafikDesaV,
    #StatistikPendidikan,
    #StatistikJabatan,
    #GrafikDesaVBPD {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        min-height: 350px;
    }

    /* Responsive chart heights */
    #GrafikDesaV {
        min-height: 400px;
    }

    #StatistikPendidikan {
        min-height: 380px;
    }

    #StatistikJabatan {
        min-height: 380px;
    }

    #GrafikDesaVBPD {
        min-height: 400px;
    }

    .grid-margin {
        margin-bottom: 1.5rem;
    }

    .stretch-card {
        display: flex;
        align-items: stretch;
        justify-content: stretch;
    }

    .stretch-card .card {
        width: 100%;
    }

    .icon-lg {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.5rem;
    }

    .text-purple {
        color: var(--purple-primary) !important;
    }

    .text-success {
        color: var(--success) !important;
    }

    .text-warning {
        color: var(--warning) !important;
    }

    .text-danger {
        color: var(--danger) !important;
    }

    .text-muted {
        color: var(--text-muted) !important;
    }

    .font-weight-bold {
        font-weight: 700 !important;
    }

    .font-weight-medium {
        font-weight: 500 !important;
    }

    .font-weight-normal {
        font-weight: 400 !important;
    }

    .mb-0 {
        margin-bottom: 0 !important;
    }

    .mb-1 {
        margin-bottom: 0.25rem !important;
    }

    .mb-2 {
        margin-bottom: 0.5rem !important;
    }

    .mb-3 {
        margin-bottom: 1rem !important;
    }

    .mb-4 {
        margin-bottom: 1.5rem !important;
    }

    .mb-5 {
        margin-bottom: 3rem !important;
    }

    .mt-0 {
        margin-top: 0 !important;
    }

    .mt-1 {
        margin-top: 0.25rem !important;
    }

    .mt-2 {
        margin-top: 0.5rem !important;
    }

    .mt-3 {
        margin-top: 1rem !important;
    }

    .mt-4 {
        margin-top: 1.5rem !important;
    }

    .mt-5 {
        margin-top: 3rem !important;
    }

    /* Chart Responsive Design */
    @media (max-width: 992px) {

        #GrafikDesaV,
        #GrafikDesaVBPD {
            min-height: 350px;
        }

        #StatistikPendidikan,
        #StatistikJabatan {
            min-height: 320px;
        }
    }

    @media (max-width: 768px) {
        .welcome-title {
            font-size: 1.8rem;
        }

        .content-wrapper {
            padding: 1rem;
        }

        .stat-number {
            font-size: 2rem;
        }

        .breadcrumb-section {
            margin-top: 1rem;
        }

        /* Chart mobile adjustments */
        #GrafikDesaV,
        #GrafikDesaVBPD {
            min-height: 300px;
        }

        #StatistikPendidikan,
        #StatistikJabatan {
            min-height: 280px;
        }

        .chart-card .card-body {
            padding: 1rem;
        }
    }

    @media (max-width: 576px) {
        .welcome-title {
            font-size: 1.5rem;
        }

        .stat-number {
            font-size: 1.8rem;
        }

        .stat-icon {
            font-size: 1.5rem;
        }

        /* Small mobile chart adjustments */
        #GrafikDesaV,
        #GrafikDesaVBPD {
            min-height: 250px;
        }

        #StatistikPendidikan,
        #StatistikJabatan {
            min-height: 230px;
        }
    }

    /* Map Styles */
    .map-container {
        height: 300px;
        border-radius: 0.5rem;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    #desaMap {
        height: 100% !important;
        width: 100% !important;
    }

    /* Card fixes */
    .stretch-card .card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .stretch-card .card .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .leaflet-popup-content {
        font-family: 'Ubuntu', sans-serif !important;
        font-size: 14px;
        line-height: 1.4;
    }

    .leaflet-popup-content-wrapper {
        background: white;
        color: var(--text-dark);
        border-radius: 8px;
        box-shadow: var(--shadow);
    }

    .leaflet-popup-tip {
        background: white;
    }

    /* Map button styling */
    .card-header .btn-sm {
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-header .btn-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
</style>

<script <?php echo CSPHandler::scriptNonce(); ?>>
    document.addEventListener('DOMContentLoaded', function() {
        // Add mini-navbar class by default
        document.body.classList.add('mini-navbar');

        // Handle dropdown menu clicks
        document.querySelectorAll('.nav > li > a[href="#"]').forEach(function(menuItem) {
            menuItem.addEventListener('click', function(e) {
                // Remove mini-navbar class to expand the menu
                document.body.classList.remove('mini-navbar');
            });
        });

        // Store menu state in session storage
        window.addEventListener('beforeunload', function() {
            sessionStorage.setItem('menuExpanded', !document.body.classList.contains('mini-navbar'));
        });

        // Restore menu state if it was expanded
        if (sessionStorage.getItem('menuExpanded') === 'true') {
            document.body.classList.remove('mini-navbar');
        }

        // Chart responsive handler
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                // Resize all Highcharts instances
                Highcharts.charts.forEach(function(chart) {
                    if (chart) {
                        chart.reflow();
                    }
                });
            }, 250);
        });
    });
</script>

<!-- =============================================== -->
<!-- HTML LAYOUT & CONTENT -->
<!-- =============================================== -->

<div class="main-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Profile Kecamatan Card -->
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card" style="height: 350px;">
                        <div class="card-header" style="padding: 18px;">
                            <h4 class="card-title" style="font-size: 1.2rem; margin: 0; font-weight: 600;">Sistem Informasi Pemerintahan Desa</h4>
                        </div>
                       <div class="card-body" style="padding: 18px; height: calc(100% - 70px);">
                            <!-- Profil Header Style -->
                            <div class="profil-header" style="display: flex; align-items: flex-start; gap: 18px; margin-bottom: 18px;">
                                <div class="profil-avatar" style="width: 85px; height: 85px; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); flex-shrink: 0;">
                                    <img src="../Vendor/Media/Logo/Pria.png" alt="Foto Default Kecamatan"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                </div>

                                <div class="profil-info" style="flex-grow: 1; min-width: 0;">
                                    <h1 style="margin: 0 0 8px 0; font-size: 1.5em; color: var(--purple-primary); font-weight: 700; line-height: 1.3;">KECAMATAN <?php echo strtoupper($NamaKecamatanHeader); ?></h1>
                                    <p style="margin: 0 0 12px 0; font-size: 1em; color: #6c757d; font-weight: 500;">Admin Kecamatan</p>
                                </div>
                            </div>

                            <!-- Detail Area Style with 2 Column Layout -->
                            <div class="detail-area" style="border-top: 1px solid #dee2e6; padding-top: 18px;">
                                <div style="display: flex; gap: 25px;">
                                    <!-- Kolom Kiri: Wilayah -->
                                    <div style="min-width: 0;">
                                        <div class="detail-baris" style="display: flex; padding: 2px 0; align-items: center;">
                                            <span class="detail-label" style="width: 85px; color: #6c757d; font-weight: 600; font-size: 0.8rem; flex-shrink: 0;">Provinsi</span>
                                            <span class="detail-nilai" style="flex-grow: 1; color: #343a40; font-weight: 500; font-size: 0.8rem;">Jawa Timur</span>
                                        </div>
                                        <div class="detail-baris" style="display: flex; padding: 2px 0; align-items: center;">
                                            <span class="detail-label" style="width: 85px; color: #6c757d; font-weight: 600; font-size: 0.8rem; flex-shrink: 0;">Kabupaten</span>
                                            <?php 
                                            $isKabupatenEmpty = ($Kabupaten == 'Data Tidak Ditemukan' || empty($Kabupaten));
                                            $kabupatenColor = $isKabupatenEmpty ? 'red' : '#343a40';
                                            $kabupatenStyle = $isKabupatenEmpty ? 'font-style: italic;' : '';
                                            $kabupatenText = $isKabupatenEmpty ? 'Belum di set' : $Kabupaten;
                                            ?>
                                            <span class="detail-nilai" style="flex-grow: 1; color: <?php echo $kabupatenColor; ?>; font-weight: 500; font-size: 0.8rem; <?php echo $kabupatenStyle; ?>">
                                                <?php echo $kabupatenText; ?>
                                            </span>
                                        </div>
                                        <div class="detail-baris" style="display: flex; padding: 2px 0; align-items: center;">
                                            <span class="detail-label" style="width: 85px; color: #6c757d; font-weight: 600; font-size: 0.8rem; flex-shrink: 0;">Kecamatan</span>
                                            <?php 
                                            $isKecamatanEmpty = ($NamaKecamatanHeader == 'Data Tidak Ditemukan' || empty($NamaKecamatanHeader));
                                            $kecamatanColor = $isKecamatanEmpty ? 'red' : '#343a40';
                                            $kecamatanStyle = $isKecamatanEmpty ? 'font-style: italic;' : '';
                                            $kecamatanText = $isKecamatanEmpty ? 'Belum di set' : $NamaKecamatanHeader;
                                            ?>
                                            <span class="detail-nilai" style="flex-grow: 1; color: <?php echo $kecamatanColor; ?>; font-weight: 500; font-size: 0.8rem; <?php echo $kecamatanStyle; ?>">
                                                <?php echo $kecamatanText; ?>
                                            </span>
                                        </div>
                                        <div class="detail-baris" style="display: flex; padding: 2px 0; align-items: center;">
                                            <span class="detail-label" style="width: 75px; color: #6c757d; font-weight: 600; font-size: 0.8rem; flex-shrink: 0;">Telepon</span>
                                            <?php 
                                            $isTeleponEmpty = ($NoTelepon == 'Data Tidak Ditemukan' || empty($NoTelepon));
                                            $teleponColor = $isTeleponEmpty ? 'red' : '#343a40';
                                            $teleponStyle = $isTeleponEmpty ? 'font-style: italic;' : '';
                                            $teleponText = $isTeleponEmpty ? 'Belum di set' : $NoTelepon;
                                            ?>
                                            <span class="detail-nilai" style="flex-grow: 1; color: <?php echo $teleponColor; ?>; font-weight: 500; font-size: 0.8rem; <?php echo $teleponStyle; ?>">
                                                <?php echo $teleponText; ?>
                                            </span>
                                        </div>
                                        <div class="detail-baris" style="display: flex; padding: 2px 0; align-items: flex-start;">
                                            <span class="detail-label" style="width: 75px; color: #6c757d; font-weight: 600; font-size: 0.8rem; flex-shrink: 0; margin-top: 2px;">Alamat</span>
                                            <?php 
                                            $isAlamatEmpty = ($AlamatKecamatan == 'Data Tidak Ditemukan' || empty($AlamatKecamatan));
                                            $alamatColor = $isAlamatEmpty ? 'red' : '#343a40';
                                            $alamatStyle = $isAlamatEmpty ? 'font-style: italic;' : '';
                                            $alamatTitle = $isAlamatEmpty ? 'Belum di set' : $AlamatKecamatan;
                                            $alamatText = $isAlamatEmpty ? 'Belum di set' : $AlamatKecamatan;
                                            ?>
                                            <span class="detail-nilai" 
                                                  style="flex-grow: 1; color: <?php echo $alamatColor; ?>; font-weight: 500; font-size: 0.8rem; line-height: 1.5; <?php echo $alamatStyle; ?>" 
                                                  title="<?php echo $alamatTitle; ?>">
                                                <?php echo $alamatText; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Card - Updated to match AdminDesa -->
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card" style="height: 350px;">
                        <div class="card-header" style="padding: 15px; display: flex; justify-content: space-between; align-items: center;">
                            <div style="flex-grow: 1;">
                                <h4 class="card-title" style="font-size: 1.1rem; margin: 0;">Peta Wilayah Kecamatan</h4>
                            </div>
                            <div style="flex-grow: 1;">
                                <p class="card-subtitle" style="font-size: 0.85rem; color: #666; margin: 5px 0 0 0;">
                                    <?php if (empty($Latitude) || empty($Longitude)): ?>
                                    <span style="color: red; font-weight: 500;"> | Alamat Kecamatan belum diset</span>
                                    <?php else: ?>
                                    <span style="color: #28a745; font-weight: 500;"> | Lokasi geografis <?php echo $NamaKecamatanHeader; ?></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <?php if (empty($Latitude) || empty($Longitude)): ?>
                            <a href="v?pg=SettingProfileKecamatan" 
                               class="btn btn-warning btn-sm" 
                               style="border-radius: 20px; padding: 6px 15px; font-size: 11px; font-weight: 600;"
                               title="Atur koordinat kecamatan">
                                <i class="fas fa-cog"></i> Set Alamat
                            </a>
                            <?php endif; ?>
                        </div>
                        <div class="card-body" style="padding: 0; height: calc(100% - 80px);">
                            <div class="map-container" style="height: 100%; border-radius: 0;">
                                <div id="desaMap"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Statistik Pegawai</h4>
                            <p class="card-subtitle">Data perangkat desa dan BPD aktif</p>
                        </div>
                        <div class="card-body">
                            <div class="row grid-margin">
                                <!-- Total Active Village Government Card -->
                                <div class="col-xl-3 col-md-6 stretch-card">
                                    <div class="card stat-card purple">
                                        <div class="card-body">
                                            <div class="stat-icon">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <div class="stat-number"><?php echo $Jumlah; ?></div>
                                            <div class="stat-label">Pemerintah Desa Aktif</div>
                                            <div class="stat-change">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                <span>Per Tanggal <?php echo $TglSaatIni; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Male Staff Card -->
                                <div class="col-xl-3 col-md-6 stretch-card">
                                    <div class="card stat-card success">
                                        <div class="card-body">
                                            <div class="stat-icon">
                                                <i class="fas fa-male"></i>
                                            </div>
                                            <div class="stat-number"><?php echo $LakiLaki; ?></div>
                                            <div class="stat-label">Laki-Laki</div>
                                            <div class="stat-change">
                                                <i class="fas fa-arrow-up mr-1"></i>
                                                <span>Perangkat Aktif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Female Staff Card -->
                                <div class="col-xl-3 col-md-6 stretch-card">
                                    <div class="card stat-card danger">
                                        <div class="card-body">
                                            <div class="stat-icon">
                                                <i class="fas fa-female"></i>
                                            </div>
                                            <div class="stat-number"><?php echo $Perempuan; ?></div>
                                            <div class="stat-label">Perempuan</div>
                                            <div class="stat-change">
                                                <i class="fas fa-arrow-up mr-1"></i>
                                                <span>Perangkat Aktif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6 stretch-card">
                                    <div class="card stat-card warning">
                                        <div class="card-body">
                                            <div class="stat-icon">
                                                <i class="fas fa-users-cog"></i>
                                            </div>
                                            <?php
                                            $QueryBPDTotal = mysqli_query($db, "SELECT count(master_pegawai_bpd.IdPegawaiFK) AS JmlBPDTotal FROM master_pegawai_bpd INNER JOIN master_desa ON master_pegawai_bpd.IdDesaFK = master_desa.IdDesa WHERE master_desa.IdKecamatanFK = '$IdKecamatan'");
                                            
                                            if ($QueryBPDTotal && mysqli_num_rows($QueryBPDTotal) > 0) {
                                                $DataBPDTotal = mysqli_fetch_assoc($QueryBPDTotal);
                                                $BPDTotal = $DataBPDTotal['JmlBPDTotal'] ?? 0;
                                            } else {
                                                $BPDTotal = 0;
                                            }
                                            ?>
                                            <div class="stat-number"><?php echo $BPDTotal; ?></div>
                                            <div class="stat-label">Anggota BPD</div>
                                            <div class="stat-change">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                <span>Total Anggota</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ============= -->
        <?php
        $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$IdKecamatan' ");
        if ($QueryKecamatan && mysqli_num_rows($QueryKecamatan) > 0) {
            $DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
            $IdKecamatan = $DataKecamatan['IdKecamatan'];
            $NamaKecamatan = $DataKecamatan['Kecamatan'];
        } else {
            $NamaKecamatan = 'Trenggalek';
        }

        ?>

        <!-- =============================================== -->
        <!-- TABEL DATA PERANGKAT DESA -->
        <!-- =============================================== -->
        <div class="ibox-content">
            <h2><strong>Data Kecamatan <?php echo $NamaKecamatan; ?></strong></h2>
            <div class="row">
                <div class="col-lg-6">
                    <h4><strong>Data Kades & Perangkat Desa</strong></h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                            <thead>
                                <tr align="center">
                                    <th>No</th>
                                    <th>Unit Kerja/Desa</th>
                                    <th>Jml Perangkat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $Nomor = 1;
                                // Query untuk tabel perangkat desa
                                $QueryPerangkat = mysqli_query($db, "SELECT
                            master_kecamatan.Kecamatan,
                            Count(master_pegawai.IdPegawaiFK) AS JmlPerangkat,
                            master_pegawai.IdPegawaiFK,
                            master_pegawai.Setting,
                            master_desa.IdDesa,
                            master_desa.NamaDesa,
                            master_desa.IdKecamatanFK,
                            master_kecamatan.IdKecamatan,
                            main_user.IdPegawai,
                            main_user.IdLevelUserFK,
                            history_mutasi.IdPegawaiFK,
                            history_mutasi.Setting AS SettingMutasi,
                            history_mutasi.IdPegawaiFK
                        FROM
                            master_pegawai
                            LEFT JOIN
                            master_desa
                            ON
                                master_pegawai.IdDesaFK = master_desa.IdDesa
                            LEFT JOIN
                            master_kecamatan
                            ON
                                master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                            INNER JOIN
                            main_user
                            ON
                                master_pegawai.IdPegawaiFK = main_user.IdPegawai
                            INNER JOIN
                            history_mutasi
                            ON
                            master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                        WHERE
                            master_pegawai.Setting = 1 AND
                            main_user.IdLevelUserFK <> 1 AND
                            main_user.IdLevelUserFK <> 2 AND
                            master_desa.IdKecamatanFK = '$IdKecamatan' AND
                            history_mutasi.Setting = 1
                        GROUP BY
                                        master_desa.NamaDesa
                                        ORDER BY
                                       master_desa.NamaDesa ASC");

                                while ($DataPerangkat = mysqli_fetch_assoc($QueryPerangkat)) {
                                    $IdKecamatan = $DataPerangkat['IdKecamatanFK'];
                                    $NamaDesa = $DataPerangkat['NamaDesa'];
                                    $JumlahPerangkat = $DataPerangkat['JmlPerangkat'];
                                ?>
                                    <tr class="gradeX">
                                        <td align="center">
                                            <?php echo $Nomor; ?>
                                        </td>
                                        <td>
                                            <?php echo $NamaDesa; ?>
                                        </td>

                                        <td align="right">
                                            <strong><?php echo $JumlahPerangkat; ?></strong>
                                        </td>
                                    </tr>
                                <?php $Nomor++;
                                }
                                ?>
                            </tbody>

                            <?php
                            $QueryJumlah = mysqli_query($db, "SELECT
                                master_kecamatan.Kecamatan,
                                Count(master_pegawai.IdPegawaiFK) AS JmlPerangkat,
                                master_pegawai.IdPegawaiFK,
                                        master_pegawai.Setting,
                                        master_desa.IdDesa,
                                        master_desa.NamaDesa,
                                        master_desa.IdKecamatanFK,
                                        master_kecamatan.IdKecamatan,
                                        main_user.IdPegawai,
                                        main_user.IdLevelUserFK,
                                        history_mutasi.IdPegawaiFK,
                                        history_mutasi.Setting AS SettingMutasi
                                    FROM
                                        master_pegawai
                                        LEFT JOIN
                                        master_desa
                                        ON
                                            master_pegawai.IdDesaFK = master_desa.IdDesa
                                        LEFT JOIN
                                        master_kecamatan
                                        ON
                                            master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                                        INNER JOIN
                                        main_user
                                        ON
                                            master_pegawai.IdPegawaiFK = main_user.IdPegawai
                                        INNER JOIN
                                        history_mutasi
                                        ON
                                            master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                                    WHERE
                                        master_pegawai.Setting = 1 AND
                                        main_user.IdLevelUserFK <> 1 AND
                                        main_user.IdLevelUserFK <> 2 AND
                                        history_mutasi.Setting = 1 AND
                                        master_desa.IdKecamatanFK = '$IdKecamatan'
                                    GROUP BY
                                        master_kecamatan.IdKecamatan
                                    ORDER BY
                                        master_kecamatan.Kecamatan ASC");
                            if ($QueryJumlah && mysqli_num_rows($QueryJumlah) > 0) {
                                $DataJumlah = mysqli_fetch_assoc($QueryJumlah);
                                $IdKecamatan = $DataJumlah['IdKecamatanFK'];
                            } else {
                                $IdKecamatan = $_SESSION['IdKecamatan'];
                            }
                            $Kecamatan = $DataJumlah['Kecamatan'];
                            $Jumlah = $DataJumlah['JmlPerangkat'];
                            ?>
                            <tr class="gradeX">
                                <td></td>
                                <td align="right"><strong>Total</strong></td>
                                <td align="right">
                                    <strong><?php echo $Jumlah; ?></strong>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>

                <div class="col-lg-6">
                    <h4><strong>Data BPD</strong></h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                            <thead>
                                <tr align="center">
                                    <th>No</th>
                                    <th>Unit Kerja/Desa</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $Nomor = 1;
                                $QueryBPDDesa = mysqli_query($db, "SELECT
                            master_kecamatan.Kecamatan,
                            Count(master_pegawai_bpd.IdPegawaiFK) AS JmlBPD,
                            master_pegawai_bpd.IdPegawaiFK,
                            master_pegawai_bpd.Setting,
                            master_desa.IdDesa,
                            master_desa.NamaDesa,
                            master_desa.IdKecamatanFK,
                            master_kecamatan.IdKecamatan
                        FROM
                            master_pegawai_bpd
                            RIGHT JOIN
                            master_desa
                            ON
                                master_pegawai_bpd.IdDesaFK = master_desa.IdDesa
                            LEFT JOIN
                            master_kecamatan
                            ON
                                master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                        WHERE
                            master_desa.IdKecamatanFK = '$IdKecamatan'
                        GROUP BY
                            master_desa.NamaDesa
                        ORDER BY
                            master_desa.NamaDesa ASC");

                                while ($DataBPDDesa = mysqli_fetch_assoc($QueryBPDDesa)) {
                                    $IdKecamatanBPD = $DataBPDDesa['IdKecamatanFK'];
                                    $NamaDesaBPD = $DataBPDDesa['NamaDesa'];
                                    $JumlahBPD = $DataBPDDesa['JmlBPD'];
                                ?>
                                    <tr class="gradeX">
                                        <td align="center">
                                            <?php echo $Nomor; ?>
                                        </td>
                                        <td>
                                            <?php echo $NamaDesaBPD; ?>
                                        </td>
                                        <td align="right">
                                            <strong><?php echo $JumlahBPD; ?></strong>
                                        </td>
                                    </tr>
                                <?php $Nomor++;
                                }
                                ?>
                            </tbody>
                            <?php
                            $QueryJumlahBPD = mysqli_query($db, "SELECT
                        master_pegawai_bpd.*,
                        master_desa.*,
                        count(master_pegawai_bpd.IdPegawaiFK) AS JmlBPD
                    FROM
                        master_pegawai_bpd
                        INNER JOIN
                        master_desa
                        ON
                            master_pegawai_bpd.IdDesaFK = master_desa.IdDesa
                    WHERE
                        master_desa.IdKecamatanFK = '$IdKecamatan'");

                            if ($QueryJumlahBPD && mysqli_num_rows($QueryJumlahBPD) > 0) {
                                $DataJmlTotalBPD = mysqli_fetch_assoc($QueryJumlahBPD);
                                $TotalBPDKab = $DataJmlTotalBPD['JmlBPD'];
                            } else {
                                $TotalBPDKab = 0;
                            }
                            ?>
                            <tfoot>
                                <tr align="right">
                                    <td></td>
                                    <td align="right"><strong>Total</strong></td>
                                    <td align="right">
                                        <strong><?php echo $TotalBPDKab; ?></strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="card chart-card">
                    <div class="card-header">
                        <h4 class="card-title">Statistik Desa</h4>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="GrafikDesaV"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <!-- Education Chart -->
            <div class="col-lg-8 grid-margin stretch-card">
                <div class="card chart-card">
                    <div class="card-header">
                        <h4 class="card-title">Statistik Pendidikan Pegawai</h4>
                        <p class="card-subtitle">Distribusi tingkat pendidikan pegawai pemerintahan desa di Kecamatan <?php echo $NamaKecamatan; ?></p>
                    </div>
                    <div class="card-body">
                        <div id="StatistikPendidikan"></div>
                    </div>
                </div>
            </div>

            <!-- Position Chart -->
            <div class="col-lg-4 grid-margin stretch-card">
                <div class="card chart-card">
                    <div class="card-header">
                        <h4 class="card-title">Statistik Jabatan</h4>
                        <p class="card-subtitle">Distribusi jabatan pegawai</p>
                    </div>
                    <div class="card-body">
                        <div id="StatistikJabatan"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BPD Statistics Row -->
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card chart-card">
                    <div class="card-header">
                        <h4 class="card-title">Statistik BPD per Desa</h4>
                        <p class="card-subtitle">Distribusi jumlah anggota BPD di setiap desa dalam Kecamatan <?php echo $NamaKecamatan; ?></p>
                    </div>
                    <div class="card-body">
                        <div id="GrafikDesaVBPD"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =============================================== -->
<!-- JAVASCRIPT CHARTS -->
<!-- =============================================== -->

<!-- Chart 1: Grafik Perangkat Desa per Kecamatan -->
<script type="text/javascript" <?php echo CSPHandler::scriptNonce(); ?>>
    Highcharts.chart('GrafikDesaV', {
        chart: {
            type: 'column',
            backgroundColor: 'transparent', // warna background chart
            borderRadius: 10,
            style: {
                fontFamily: 'Tahoma'
            },
            height: null,
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        plotOptions: {
                            column: {
                                dataLabels: {
                                    style: {
                                        fontSize: '9px'
                                    }
                                }
                            }
                        }
                    }
                }]
            }
        },
        title: {
            text: '<strong>Grafik Data Kades & Perangkat Desa Kecamatan <?php echo addslashes(htmlspecialchars($NamaKecamatan, ENT_QUOTES, 'UTF-8')); ?></strong>',
            style: {
                color: '#111827',
                fontSize: '16px'
            }
        },
        xAxis: {
            categories: ['Desa '],
            crosshair: false,
            labels: {
                style: {
                    fontSize: '12px',
                    color: '#374151'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Pegawai',
                style: {
                    color: '#374151'
                }
            },
            gridLineColor: '#e5e7eb'
        },
        colors: [
            '#3b82f6', // biru
            '#10b981', // hijau
            '#f59e0b', // kuning
            '#ef4444', // merah
            '#8b5cf6', // ungu
            '#14b8a6', // teal
            '#d946ef', // pink
            '#64748b' // abu
        ],
        plotOptions: {
            column: {
                borderRadius: 5,
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '11px',
                        fontWeight: 'bold',
                        color: '#111827'
                    }
                }
            }
        },
        tooltip: {
            backgroundColor: '#ffffff',
            borderColor: '#d1d5db',
            borderRadius: 6,
            style: {
                color: '#111827'
            },
            formatter: function() {
                return '<b>' + this.series.name + '</b><br/>' +
                    'Jumlah: <b>' + this.y + '</b> orang';
            }
        },
        credits: {
            enabled: false
        },
        series: [
            <?php
            $QueryPerangkat = mysqli_query($db, "SELECT
                        master_kecamatan.Kecamatan,
                        Count(master_pegawai.IdPegawaiFK) AS JmlPerangkat,
                        master_pegawai.IdPegawaiFK,
                        master_pegawai.Setting,
                        master_desa.IdDesa,
                        master_desa.NamaDesa,
                        master_desa.IdKecamatanFK,
                        master_kecamatan.IdKecamatan,
                        main_user.IdPegawai,
                        main_user.IdLevelUserFK,
                        history_mutasi.IdPegawaiFK,
                        history_mutasi.Setting AS SettingMutasi
                    FROM
                        master_pegawai
                        LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                        LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                        INNER JOIN main_user ON master_pegawai.IdPegawaiFK = main_user.IdPegawai
                        INNER JOIN history_mutasi ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                    WHERE
                        master_pegawai.Setting = 1 AND
                        main_user.IdLevelUserFK <> 1 AND
                        main_user.IdLevelUserFK <> 2 AND
                        master_desa.IdKecamatanFK = '$IdKecamatan' AND
                        history_mutasi.Setting = 1
                    GROUP BY master_desa.NamaDesa
                    ORDER BY master_desa.NamaDesa ASC");
            while ($DataPerangkat = mysqli_fetch_assoc($QueryPerangkat)) {
                $IdKecamatan = $DataPerangkat['IdKecamatanFK'];
                $NamaDesa = $DataPerangkat['NamaDesa'];
                $Jumlah = $DataPerangkat['JmlPerangkat'];
            ?> {
                    name: '<?php echo addslashes(htmlspecialchars($NamaDesa, ENT_QUOTES, 'UTF-8')); ?>',
                    data: [<?php echo $Jumlah; ?>]
                },
            <?php } ?>
        ]
    });
</script>

<!-- Chart 2: Statistik Pendidikan (Pie Chart) -->
<script type="text/javascript" <?php echo CSPHandler::scriptNonce(); ?>>
    // Purple theme color palette
    const purpleColors = ['#6f42c1', '#1bcfb4', '#fd397a', '#ffb822', '#0084ff', '#17a2b8', '#28a745'];

    Highcharts.chart('StatistikPendidikan', {
        chart: {
            type: 'pie',
            backgroundColor: 'transparent',
            style: {
                fontFamily: 'Ubuntu, sans-serif'
            },
            height: null,
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        },
                        plotOptions: {
                            pie: {
                                dataLabels: {
                                    style: {
                                        fontSize: '9px'
                                    }
                                }
                            }
                        }
                    }
                }]
            }
        },
        exporting: {
            buttons: {
                contextButton: {
                    menuItems: ['viewFullscreen', 'separator', 'downloadPNG', 'downloadJPEG', 'downloadPDF', 'downloadSVG']
                }
            }
        },
        title: {
            text: null
        },
        subtitle: {
            text: null
        },
        colors: purpleColors,
        plotOptions: {
            pie: {
                innerSize: '60%',
                borderWidth: 0,
                borderRadius: 5,
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}',
                    style: {
                        color: '#2c2c54',
                        fontWeight: '500',
                        fontSize: '11px',
                        fontFamily: 'Ubuntu, sans-serif'
                    },
                    distance: 20
                },
                showInLegend: true,
                states: {
                    hover: {
                        halo: {
                            size: 10
                        }
                    }
                }
            }
        },
        tooltip: {
            backgroundColor: 'rgba(44, 44, 84, 0.95)',
            style: {
                color: '#fff',
                fontFamily: 'Ubuntu, sans-serif'
            },
            headerFormat: '<b style="font-size: 13px;">{point.key}</b><br>',
            pointFormat: 'Jumlah: <b>{point.y} Orang</b><br>Persentase: <b>{point.percentage:.1f}%</b>',
            borderRadius: 8,
            borderWidth: 0,
            shadow: true
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            itemStyle: {
                color: '#2c2c54',
                fontWeight: '500',
                fontSize: '11px',
                fontFamily: 'Ubuntu, sans-serif'
            },
            itemHoverStyle: {
                color: '#6f42c1'
            },
            itemMarginTop: 4,
            itemMarginBottom: 4
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Pendidikan',
            colorByPoint: true,
            data: [
                <?php
                $QueryPendidikan = mysqli_query($db, "SELECT
            master_pendidikan.JenisPendidikan,
            Count(history_pendidikan.IdPegawaiFK) AS JmlPendidikan
        FROM history_pendidikan
            INNER JOIN master_pendidikan
            ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
            INNER JOIN master_pegawai
            ON master_pegawai.IdPegawaiFK = history_pendidikan.IdPegawaiFK
            INNER JOIN master_desa
            ON master_desa.IdDesa = master_pegawai.IdDesaFK
            INNER JOIN history_mutasi
            ON history_pendidikan.IdPegawaiFK = history_mutasi.IdPegawaiFK
        WHERE history_pendidikan.Setting = 1 
          AND master_pegawai.Setting = 1 
          AND master_desa.IdKecamatanFK = '$IdKecamatan' 
          AND history_mutasi.Setting = 1
        GROUP BY history_pendidikan.IdPendidikanFK
        ORDER BY master_pendidikan.IdPendidikan ASC");

                while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
                    $Pendidikan = $DataPendidikan['JenisPendidikan'];
                    $JumlahPendidikan = $DataPendidikan['JmlPendidikan'];
                ?> {
                        name: '<?php echo addslashes(htmlspecialchars($Pendidikan, ENT_QUOTES, 'UTF-8')); ?>',
                        y: <?php echo $JumlahPendidikan; ?>,
                        sliced: false,
                        selected: false
                    },
                <?php } ?>
            ]
        }]
    });
</script>

<!-- Chart 3: Statistik Jabatan (Column Chart) -->
<script type="text/javascript" <?php echo CSPHandler::scriptNonce(); ?>>
    Highcharts.chart('StatistikJabatan', {
        chart: {
            type: 'column',
            style: {
                fontFamily: 'Ubuntu, sans-serif'
            },
            backgroundColor: 'transparent',
            height: null,
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        plotOptions: {
                            column: {
                                dataLabels: {
                                    style: {
                                        fontSize: '9px'
                                    }
                                }
                            }
                        }
                    }
                }]
            }
        },
        exporting: {
            buttons: {
                contextButton: {
                    menuItems: ['viewFullscreen', 'separator', 'downloadPNG', 'downloadJPEG', 'downloadPDF', 'downloadSVG']
                }
            }
        },
        title: {
            text: null
        },
        subtitle: {
            text: null
        },
        xAxis: {
            categories: ['Jabatan'],
            labels: {
                style: {
                    color: '#2c2c54',
                    fontWeight: '500',
                    fontSize: '11px',
                    fontFamily: 'Ubuntu, sans-serif'
                }
            },
            lineWidth: 0,
            tickWidth: 0,
            gridLineWidth: 0
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Pegawai',
                style: {
                    color: '#2c2c54',
                    fontWeight: '500',
                    fontSize: '12px',
                    fontFamily: 'Ubuntu, sans-serif'
                }
            },
            labels: {
                style: {
                    color: '#2c2c54',
                    fontSize: '11px'
                }
            },
            gridLineColor: '#edf2f7',
            gridLineWidth: 1
        },
        plotOptions: {
            column: {
                borderRadius: 6,
                borderWidth: 0,
                pointPadding: 0.2,
                groupPadding: 0.1,
                dataLabels: {
                    enabled: true,
                    style: {
                        color: '#2c2c54',
                        fontWeight: 'bold',
                        fontSize: '10px',
                        fontFamily: 'Ubuntu, sans-serif'
                    },
                    y: -8
                },
                states: {
                    hover: {
                        brightness: 0.1
                    }
                }
            }
        },
        colors: purpleColors,
        legend: {
            itemStyle: {
                color: '#2c2c54',
                fontWeight: '500',
                fontSize: '11px',
                fontFamily: 'Ubuntu, sans-serif'
            },
            itemHoverStyle: {
                color: '#6f42c1'
            }
        },
        tooltip: {
            backgroundColor: 'rgba(44, 44, 84, 0.95)',
            style: {
                color: '#fff',
                fontFamily: 'Ubuntu, sans-serif'
            },
            headerFormat: '<b style="font-size: 13px;">{series.name}</b><br>',
            pointFormat: 'Jumlah: <b>{point.y} Orang</b>',
            borderRadius: 8,
            borderWidth: 0,
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [
            <?php
            $QJabatan = mysqli_query($db, "SELECT
            master_jabatan.IdJabatan,
            master_jabatan.Jabatan,
            history_mutasi.IdJabatanFK,
            Count(history_mutasi.IdPegawaiFK) AS JmlJabatan,
            history_mutasi.Setting,
            history_mutasi.JenisMutasi,
            master_pegawai.IdPegawaiFK,
            master_pegawai.IdDesaFK,
            master_desa.IdKecamatanFK,
            master_desa.IdDesa
        FROM master_jabatan
            INNER JOIN history_mutasi ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
            INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
            INNER JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
            INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
        WHERE history_mutasi.Setting = 1 
          AND history_mutasi.JenisMutasi NOT IN (3,4,5) 
          AND master_desa.IdKecamatanFK = '$IdKecamatan'
        GROUP BY history_mutasi.IdJabatanFK");

            while ($DataJabatan = mysqli_fetch_assoc($QJabatan)) {
                $Jabatan = $DataJabatan['Jabatan'];
                $JmlJabatan = $DataJabatan['JmlJabatan'];
            ?> {
                    name: '<?php echo addslashes(htmlspecialchars($Jabatan, ENT_QUOTES, 'UTF-8')); ?>',
                    data: [<?php echo $JmlJabatan; ?>]
                },
            <?php } ?>
        ]
    });
</script>

<!-- Chart 4: Statistik BPD per Desa (Column Chart) -->
<script type="text/javascript" <?php echo CSPHandler::scriptNonce(); ?>>
    Highcharts.chart('GrafikDesaVBPD', {
        chart: {
            type: 'column',
            style: {
                fontFamily: 'Ubuntu, sans-serif'
            },
            backgroundColor: 'transparent',
            height: null,
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        plotOptions: {
                            column: {
                                dataLabels: {
                                    style: {
                                        fontSize: '9px'
                                    }
                                }
                            }
                        }
                    }
                }]
            }
        },
        exporting: {
            buttons: {
                contextButton: {
                    menuItems: ['viewFullscreen', 'separator', 'downloadPNG', 'downloadJPEG', 'downloadPDF', 'downloadSVG']
                }
            }
        },
        title: {
            text: null
        },
        subtitle: {
            text: null
        },
        xAxis: {
            categories: ['Desa'],
            labels: {
                style: {
                    color: '#2c2c54',
                    fontWeight: '500',
                    fontSize: '11px',
                    fontFamily: 'Ubuntu, sans-serif'
                }
            },
            lineWidth: 0,
            tickWidth: 0,
            gridLineWidth: 0
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Anggota BPD',
                style: {
                    color: '#2c2c54',
                    fontWeight: '500',
                    fontSize: '12px',
                    fontFamily: 'Ubuntu, sans-serif'
                }
            },
            labels: {
                style: {
                    color: '#2c2c54',
                    fontSize: '11px'
                }
            },
            gridLineColor: '#edf2f7',
            gridLineWidth: 1
        },
        plotOptions: {
            column: {
                borderRadius: 6,
                borderWidth: 0,
                pointPadding: 0.2,
                groupPadding: 0.1,
                dataLabels: {
                    enabled: true,
                    style: {
                        color: '#2c2c54',
                        fontWeight: 'bold',
                        fontSize: '10px',
                        fontFamily: 'Ubuntu, sans-serif'
                    },
                    y: -8
                },
                states: {
                    hover: {
                        brightness: 0.1
                    }
                }
            }
        },
        colors: purpleColors,
        legend: {
            itemStyle: {
                color: '#2c2c54',
                fontWeight: '500',
                fontSize: '11px',
                fontFamily: 'Ubuntu, sans-serif'
            },
            itemHoverStyle: {
                color: '#6f42c1'
            }
        },
        tooltip: {
            backgroundColor: 'rgba(44, 44, 84, 0.95)',
            style: {
                color: '#fff',
                fontFamily: 'Ubuntu, sans-serif'
            },
            headerFormat: '<b style="font-size: 13px;">{series.name}</b><br>',
            pointFormat: 'Jumlah Anggota: <b>{point.y} Orang</b>',
            borderRadius: 8,
            borderWidth: 0,
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [
            <?php
            $QueryBPDDesa = mysqli_query($db, "SELECT
                        master_kecamatan.Kecamatan,
                        Count(master_pegawai_bpd.IdPegawaiFK) AS JmlBPD,
                        master_pegawai_bpd.IdPegawaiFK,
                        master_pegawai_bpd.Setting,
                        master_desa.IdDesa,
                        master_desa.NamaDesa,
                        master_desa.IdKecamatanFK,
                        master_kecamatan.IdKecamatan
                    FROM master_pegawai_bpd
                        RIGHT JOIN master_desa ON master_pegawai_bpd.IdDesaFK = master_desa.IdDesa
                        LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                    WHERE master_desa.IdKecamatanFK = '$IdKecamatan'
                    GROUP BY master_desa.NamaDesa
                    ORDER BY master_desa.NamaDesa ASC");

            while ($DataBPDDesa = mysqli_fetch_assoc($QueryBPDDesa)) {
                $NamaDesaBPD = $DataBPDDesa['NamaDesa'];
                $JumlahBPD = $DataBPDDesa['JmlBPD'];
            ?> {
                    name: '<?php echo addslashes(htmlspecialchars($NamaDesaBPD, ENT_QUOTES, 'UTF-8')); ?>',
                    data: [<?php echo $JumlahBPD; ?>]
                },
            <?php } ?>
        ]
    });
</script>

<!-- Leaflet Map Script -->
<script <?php echo CSPHandler::scriptNonce(); ?>>
    // Initialize the map after the page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Koordinat dari database atau default jika belum diset
        var desaLat = <?php echo !empty($Latitude) ? $Latitude : '-8.055'; ?>;
        var desaLng = <?php echo !empty($Longitude) ? $Longitude : '111.715'; ?>;
        var hasCoordinates = <?php echo (!empty($Latitude) && !empty($Longitude)) ? 'true' : 'false'; ?>;

        // Center on desa coordinates or default
        var map = L.map('desaMap').setView([desaLat, desaLng], hasCoordinates ? 15 : 12);

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Tambahkan marker desa (menggunakan marker default seperti di SettingProfile.php)
        var desaMarker = L.marker([desaLat, desaLng], {
            draggable: false // Tidak bisa di-drag di dashboard
        }).addTo(map);

        // Status koordinat
        var statusBadge = hasCoordinates ?
            '<span style="background: #28a745; color: white; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;"><i class="fas fa-check-circle"></i> Koordinat Aktual</span>' :
            '<span style="background: #ffc107; color: #333; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;"><i class="fas fa-exclamation-triangle"></i> Koordinat Default</span>';

        // Info popup
        var popupContent = `
            <div style="text-align: center; min-width: 220px; font-family: 'Ubuntu', sans-serif;">
                <div style="background: linear-gradient(135deg, #6f42c1, #5a34a3); color: white; margin: 8px 10px 15px 8px; padding: 15px; border-radius: 8px 8px 0 0;">
                    <h5 style="margin: 0; font-weight: 600;"><i class="fas fa-home"></i> <?php echo htmlspecialchars($NamaKecamatanHeader); ?></h5>
                </div>
                
                <div style="padding: 0 5px;">
                    <p style="margin: 5px 0; font-size: 13px; color: #666;"><i class="fas fa-map"></i> Kec. <?php echo htmlspecialchars($NamaKecamatanHeader); ?></p>
                    <p style="margin: 5px 0; font-size: 13px; color: #666;"><i class="fas fa-building"></i> Kab. <?php echo htmlspecialchars($Kabupaten); ?></p>
                    
                    <?php if (!empty($AlamatKecamatan)): ?>
                    <p style="margin: 8px 0; font-size: 12px; color: #555; font-style: italic; line-height: 1.4;">
                        <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($AlamatKecamatan); ?>
                    </p>
                    <?php endif; ?>
                    
                    <?php if (!empty($NoTelepon)): ?>
                    <p style="margin: 5px 0; font-size: 12px; color: #555;">
                        <i class="fas fa-phone"></i> <?php echo htmlspecialchars($NoTelepon); ?>
                    </p>
                    <?php endif; ?>
                    
                    <hr style="margin: 12px 0; border: none; border-top: 1px solid #eee;">
                    
                    <div style="margin: 10px 0;">
                        ${statusBadge}
                    </div>
                    
                    <p style="margin: 8px 0; font-size: 11px; color: #888;">
                        Koordinat: ${desaLat.toFixed(6)}, ${desaLng.toFixed(6)}
                    </p>
                    
                    ${!hasCoordinates ? 
                        '<p style="margin: 10px 0; font-size: 11px; color: #dc3545; font-style: italic;"><i class="fas fa-info-circle"></i> Silakan set alamat desa di menu Setting</p>' : 
                        '<p style="margin: 10px 0; font-size: 11px; color: #28a745; font-style: italic;"><i class="fas fa-check"></i> Koordinat sudah diatur</p>'
                    }
                </div>
            </div>
        `;

        desaMarker.bindPopup(popupContent);

        // Auto buka popup jika koordinat belum diset
        if (!hasCoordinates) {
            desaMarker.openPopup();
        }

        // Optional: Add click event to map
        map.on('click', function(e) {
            console.log('Map clicked at: ' + e.latlng);
        });

        // Disable map interaction on mobile for better scrolling
        if (window.innerWidth < 768) {
            map.dragging.disable();
            map.touchZoom.disable();
            map.doubleClickZoom.disable();
            map.scrollWheelZoom.disable();
            map.boxZoom.disable();
            map.keyboard.disable();

            // Tambahkan pesan untuk mobile
            map.on('click', function(e) {
                if (!hasCoordinates) {
                    alert('Untuk mengatur koordinat desa, silakan buka Setting melalui menu.');
                }
            });
        }
    });
</script>

<!-- Script untuk mengatasi masalah pace loading yang tidak selesai -->
<script <?php echo CSPHandler::scriptNonce(); ?>>
    // Force pace loading to complete after page is fully loaded
    window.addEventListener('load', function() {
        // Wait a bit for all scripts to finish
        setTimeout(function() {
            // Force pace to complete if it's still running
            if (typeof Pace !== 'undefined' && Pace.running) {
                Pace.stop();
            }
            // Add pace-done class to body if not already present
            if (!document.body.classList.contains('pace-done')) {
                document.body.classList.add('pace-done');
            }
            // Hide any remaining pace elements
            var paceElements = document.querySelectorAll('.pace');
            paceElements.forEach(function(el) {
                el.style.display = 'none';
            });
        }, 1000); // Wait 1 second after page load
    });

    // Fallback - force pace to complete after DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            if (typeof Pace !== 'undefined' && Pace.running) {
                Pace.stop();
            }
            document.body.classList.add('pace-done');
        }, 2000); // Wait 2 seconds after DOM ready
    });
    
    // Function untuk close notification bar
    function closeNotificationBar() {
        const notifBar = document.querySelector('.notification-bar');
        if (notifBar) {
            notifBar.style.animation = 'slideUp 0.3s ease-out forwards';
            setTimeout(() => {
                notifBar.style.display = 'none';
                // Store in localStorage untuk session ini
                localStorage.setItem('notifBarClosed', 'true');
            }, 300);
        }
    }
    
    // Check apakah notification bar sudah di-close sebelumnya
    document.addEventListener('DOMContentLoaded', function() {
        if (localStorage.getItem('notifBarClosed') === 'true') {
            const notifBar = document.querySelector('.notification-bar');
            if (notifBar) {
                notifBar.style.display = 'none';
            }
        }
    });
</script>