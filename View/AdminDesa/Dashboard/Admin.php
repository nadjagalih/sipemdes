<?php
// Include security handler for CSP nonce
require_once "../Module/Security/CSPHandler.php";

// Use CSPHandler nonce for script tags
$nonce = CSPHandler::getNonce();

$alertScript = '';
if (!empty($_GET['alert'])) {
    if ($_GET['alert'] == 'Sukses') {
        $alertScript = "
            setTimeout(function () {
                swal({
                    title: 'Sukses Ajukan SK Pensiun',
                    text: 'SK Pensiun telah berhasil diajukan.',
                    type: 'success'
                });
            }, 100);
        ";
    } elseif ($_GET['alert'] == 'Gagal') {
        $alertScript = "
            setTimeout(function () {
                swal({
                    title: 'Gagal Ajukan SK Pensiun',
                    text: 'SK Pensiun telah gagal diajukan.',
                    type: 'warning'
                });
            }, 100);
        ";
    }
}

include "../App/Control/FunctionProfileDinasView.php";
include "../App/Control/FunctionProfilePegawaiUser.php";
include "../App/Control/FunctionNotifikasiAward.php";

$IdDesa = $_SESSION['IdDesa'];

$QHeader = mysqli_query($db, "SELECT
main_user.IdPegawai,
master_pegawai.IdPegawaiFK,
master_pegawai.IdDesaFK,
master_desa.IdDesa,
master_desa.NamaDesa,
master_desa.NoTelepon,
master_desa.alamatDesa,
master_desa.Latitude,
master_desa.Longitude,
master_desa.IdKecamatanFK,
master_kecamatan.IdKecamatan,
master_kecamatan.Kecamatan,
master_setting_profile_dinas.Kabupaten
FROM
main_user
INNER JOIN master_pegawai ON main_user.IdPegawai = master_pegawai.IdPegawaiFK
INNER JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
WHERE master_pegawai.IdDesaFK = '$IdDesa' ");
if ($QHeader && mysqli_num_rows($QHeader) > 0) {
    $DataHeader = mysqli_fetch_assoc($QHeader);
    $NamaDesaHeader = $DataHeader['NamaDesa'];
    $NamaKecamatanHeader = $DataHeader['Kecamatan'];
    $IdDesaHeader = $DataHeader['IdDesaFK'];
    $NoTelepon = $DataHeader['NoTelepon'];
    $alamatDesa = $DataHeader['alamatDesa'];
    $Latitude = $DataHeader['Latitude'];
    $Longitude = $DataHeader['Longitude'];
    $Kabupaten = $DataHeader['Kabupaten'] ?? "Data Tidak Ditemukan";
} else {
    $NamaDesaHeader = "Data Tidak Ditemukan";
    $NamaKecamatanHeader = "Data Tidak Ditemukan";
    $IdDesaHeader = $IdDesa; // fallback ke session ID
    $NoTelepon = "Data Tidak Ditemukan";
    $alamatDesa = "Data Tidak Ditemukan";
    $Latitude = null;
    $Longitude = null;
    $Kabupaten = "Data Tidak Ditemukan";
}

$QueryPerangkat = mysqli_query($db, "SELECT
                    master_kecamatan.Kecamatan,
                    Count(master_pegawai.IdPegawaiFK) AS JmlPerangkat,
                    master_pegawai.IdPegawaiFK,
                    master_pegawai.IdDesaFK,
                    master_pegawai.Setting,
                    master_desa.IdDesa,
                    master_desa.NamaDesa,
                    master_desa.IdKecamatanFK,
                    master_kecamatan.IdKecamatan,
                    main_user.IdPegawai,
                    main_user.IdLevelUserFK,
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
                    master_pegawai.IdDesaFK = '$IdDesaHeader' AND
                    history_mutasi.Setting = 1");

if ($QueryPerangkat && mysqli_num_rows($QueryPerangkat) > 0) {
    $DataPerangkat = mysqli_fetch_assoc($QueryPerangkat);
    $Jumlah = $DataPerangkat['JmlPerangkat'];
} else {
    $Jumlah = 0;
}
$TglSaatIni = date('d-m-Y');

// Gender Statistics
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
            master_pegawai.IdDesaFK = '$IdDesaHeader' AND
            history_mutasi.Setting = 1
            GROUP BY master_pegawai.JenKel");
if ($QJK && mysqli_num_rows($QJK) > 0) {
    $DataJK = mysqli_fetch_assoc($QJK);
    $LakiLaki = $DataJK['JumlahJKL'] ?? 0;
} else {
    $LakiLaki = 0;
}

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
            master_pegawai.IdDesaFK = '$IdDesaHeader' AND
            history_mutasi.Setting = 1
            GROUP BY master_pegawai.JenKel");
if ($QJKP && mysqli_num_rows($QJKP) > 0) {
    $DataJKP = mysqli_fetch_assoc($QJKP);
    $Perempuan = $DataJKP['JumlahJKP'] ?? 0;
} else {
    $Perempuan = 0;
}

// Query untuk mengambil data Kepala Desa berdasarkan jabatan
$kepdes_sql = "SELECT 
            master_pegawai.IdPegawaiFK,
            master_pegawai.Nama AS NamaPegawai,
            master_pegawai.Foto,
            master_pegawai.JenKel,
            master_jabatan.Jabatan
            FROM master_pegawai 
            INNER JOIN history_mutasi ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
            INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
            WHERE master_pegawai.IdDesaFK = '$IdDesaHeader' 
            AND master_pegawai.Setting = 1 
            AND history_mutasi.Setting = 1
            AND master_jabatan.Jabatan = 'Kepala Desa'
            ORDER BY history_mutasi.TanggalMutasi DESC
            LIMIT 1";

$QKepDesa = mysqli_query($db, $kepdes_sql);

// Handle query errors
if (!$QKepDesa) {
    error_log("Kepala Desa Query Error: " . mysqli_error($db));
}

// Log query hasil - debug code removed for production

// Cek apakah query berhasil dan ada hasil
if($QKepDesa && mysqli_num_rows($QKepDesa) > 0) {
    $DataKepDesa = mysqli_fetch_assoc($QKepDesa);
    
    // Data kepala desa ditemukan di database
    
    // Set foto kepala desa atau default
    if($DataKepDesa && !empty($DataKepDesa['Foto']) && file_exists("../Vendor/Media/Pegawai/" . $DataKepDesa['Foto'])) {
        $FotoKepDesa = "../Vendor/Media/Pegawai/" . $DataKepDesa['Foto'];
        $NamaKepDesa = $DataKepDesa['NamaPegawai'];
        $StatusFoto = "Foto Kepala Desa";
        echo "<!-- Using database photo -->";
    } else {
        // Foto tidak ditemukan di file system
        
        // Jika ada nama tapi tidak ada foto
        if($DataKepDesa && !empty($DataKepDesa['NamaPegawai'])) {
            $NamaKepDesa = $DataKepDesa['NamaPegawai'];
        } else {
            $NamaKepDesa = "Kepala Desa " . $NamaDesaHeader;
        }
        // Gunakan foto default berdasarkan gender jika ada
        if($DataKepDesa && isset($DataKepDesa['JenKel'])) {
            if($DataKepDesa['JenKel'] == 1) {
                $FotoKepDesa = "../Vendor/Media/Logo/Pria.png";
            } else {
                $FotoKepDesa = "../Vendor/Media/Logo/Perempuan.png";
            }
        } else {
            $FotoKepDesa = "../Vendor/Media/Logo/Pria.png"; // Default pria
        }
        $StatusFoto = "Foto Default";
        echo "<!-- Using gender-based default -->";
    }
} else {
    // Jika tidak ada data kepala desa, gunakan default
    $FotoKepDesa = "../Vendor/Media/Logo/Pria.png";
    $NamaKepDesa = "Kepala Desa " . $NamaDesaHeader;
    $StatusFoto = "Foto Default";
    echo "<!-- Using final fallback default -->";
}
?>

<!-- Purple Theme Assets -->
<link href="../Assets/argon/argon.css" rel="stylesheet">
<link href="../Assets/css/local-fonts.css" rel="stylesheet">
<link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

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
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
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
        background: rgba(255,255,255,0.1);
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
        font-size: 0.9rem;
    }
    
    .breadcrumb a {
        color: rgba(255,255,255,0.8);
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
        background: linear-gradient(45deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
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
    
    .mb-0 { margin-bottom: 0 !important; }
    .mb-1 { margin-bottom: 0.25rem !important; }
    .mb-2 { margin-bottom: 0.5rem !important; }
    .mb-3 { margin-bottom: 1rem !important; }
    .mb-4 { margin-bottom: 1.5rem !important; }
    .mb-5 { margin-bottom: 3rem !important; }
    
    .mt-0 { margin-top: 0 !important; }
    .mt-1 { margin-top: 0.25rem !important; }
    .mt-2 { margin-top: 0.5rem !important; }
    .mt-3 { margin-top: 1rem !important; }
    .mt-4 { margin-top: 1.5rem !important; }
    .mt-5 { margin-top: 3rem !important; }
    
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
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .card-header .btn-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    /* Award Notification Styles */
    .notification-item {
        transition: all 0.3s ease;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .notification-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        background: #ffffff !important;
    }
    
    .stat-card.success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        transition: all 0.3s ease;
    }
    
    .stat-card.warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        color: white;
        transition: all 0.3s ease;
    }
    
    .stat-card.purple {
        background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);
        color: white;
        transition: all 0.3s ease;
    }
    
    .stat-card.info {
        background: linear-gradient(135deg, #17a2b8 0%, #007bff 100%);
        color: white;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.8;
        margin-bottom: 10px;
    }
    
    .stat-number {
        font-size: 2.8rem;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 8px;
        opacity: 0.9;
    }
    
    .stat-change {
        font-size: 0.85rem;
        opacity: 0.8;
    }
    
    .notification-footer {
        border-top: 1px solid #dee2e6;
        padding-top: 15px;
        margin-top: 10px;
    }
    
    .badge-sm {
        padding: 0.25em 0.4em;
        font-size: 0.65em;
        font-weight: 600;
    }

        /* Animation untuk notification bar */
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        @keyframes slideUp {
            from {
                transform: translateY(0);
                opacity: 1;
            }
            to {
                transform: translateY(-100%);
                opacity: 0;
            }
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            }
            50% {
                transform: scale(1.02);
                box-shadow: 0 8px 20px rgba(255, 215, 0, 0.3);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            }
        }
        
    /* Responsive untuk notification bar */
    @media (max-width: 768px) {
        .notification-bar {
            padding: 8px 15px !important;
            font-size: 12px !important;
            min-height: 40px !important;
        }
        
        .notification-content {
            gap: 10px !important;
        }
        
        .notification-icon {
            padding: 5px 6px !important;
        }
        
        .notification-icon i {
            font-size: 14px !important;
        }
        
        .notification-actions a {
            font-size: 11px !important;
            padding: 5px 10px !important;
        }
        
        .notification-text {
            font-size: 12px !important;
        }
    }
    
    @media (max-width: 480px) {
        .notification-bar {
            padding: 6px 12px !important;
            min-height: 35px !important;
        }
        
        .notification-content {
            flex: 1;
            min-width: 0;
        }
        
        .notification-text {
            font-size: 11px !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .notification-actions {
            flex-shrink: 0;
            gap: 5px !important;
        }
        
        .notification-actions a {
            display: none; /* Hide pada mobile sangat kecil */
        }
    }
    
    /* Pulse animation untuk notification icon */
    .notification-icon {
        animation: pulse 2s infinite;
    }
    
    /* Close notification button hover effect */
    .close-notification-btn:hover {
        background: rgba(255,255,255,0.2) !important;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
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
    });
</script>

<!-- Main content -->
<div class="main-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Notification Bar Tipis -->
            <?php if ($totalNotifications > 0): ?>
            <?php 
            // Cek apakah ada notifikasi award baru (persistent)
            $hasAwardBaru = $notifStats['award_baru'] > 0;
            $isPersistent = $hasAwardBaru ? 'true' : 'false';
            ?>
            <div class="notification-bar" 
                 data-persistent="<?= $isPersistent ?>" 
                 data-award-baru="<?= $hasAwardBaru ? 'true' : 'false' ?>"
                 style="
                background: linear-gradient(135deg, #0a0a37 0%, #1845b3 100%);
                background: linear-gradient(135deg, #0a0a37 0%, #1845b3 100%);
                color: white;
                padding: 6px 20px;
                margin: -15px -15px 15px -15px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                box-shadow: 0 1px 8px rgba(0,0,0,0.08);
                border-radius: 0 0 8px 8px;
                font-size: 13px;
                animation: slideDown 0.5s ease-out;
                min-height: 45px;
                position: relative;
                overflow: hidden;
            ">
                <!-- Background subtle pattern -->
                <div style="
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: repeating-linear-gradient(
                        90deg,
                        transparent,
                        transparent 2px,
                        rgba(255,255,255,0.03) 2px,
                        rgba(255,255,255,0.03) 4px
                    );
                    pointer-events: none;
                "></div>
                
                <div class="notification-content" style="display: flex; align-items: center; gap: 12px; position: relative; z-index: 1;">
                    <div class="notification-icon" style="
                        background: rgba(255,255,255,0.2);
                        padding: 6px 8px;
                        border-radius: 6px;
                        display: flex;
                        align-items: center;
                    ">
                        <i class="fas fa-bell" style="font-size: 16px;"></i>
                    </div>
                    <div class="notification-text">
                        <?php if ($notifStats['award_baru'] > 0): ?>
                            • <span style="color: #FFD700;">🏆 <?= $notifStats['award_baru'] ?> Notifikasi Award Baru | Buka di Menu Award Desa untuk Mendaftar</span>
                        <?php endif; ?>
                        <?php if ($notifStats['menunggu_penjurian'] > 0): ?>
                            • <span style="color: #87CEEB;">⏰ <?= $notifStats['menunggu_penjurian'] ?> Karya Menunggu Penjurian</span>
                        <?php endif; ?>
                        <?php if ($notifStats['menang'] > 0): ?>
                            <?php 
                            // Ambil ID award pertama yang dimenangkan untuk link
                            $firstWonAward = null;
                            foreach ($awardNotifications as $notif) {
                                if ($notif['type'] == 'menang') {
                                    $firstWonAward = $notif['data'];
                                    break;
                                }
                            }
                            
                            if ($firstWonAward) {
                                // Cari ID award untuk link detail
                                $IdAwardQuery = mysqli_query($db, "SELECT ma.IdAward FROM master_award_desa ma JOIN master_kategori_award mk ON ma.IdAward = mk.IdAwardFK WHERE mk.IdKategoriAward = '{$firstWonAward['IdKategoriAwardFK']}'");
                                $IdAwardData = mysqli_fetch_assoc($IdAwardQuery);
                                $IdAward = $IdAwardData['IdAward'] ?? '';
                            }
                            ?>
                            • <span style="color: #90EE90;">🎉 Selamat Desa anda mendapatkan Juara <?= $firstWonAward['Posisi'] ?? '' ?> di <?= $firstWonAward['JenisPenghargaan'] ?? '' ?> <?= $firstWonAward['TahunPenghargaan'] ?? '' ?>
                            <?php if (!empty($IdAward)): ?>
                                <a href="?pg=DetailAwardAdminDesa&kode=<?= $IdAward ?>" style="color: #FFD700; text-decoration: underline; cursor: pointer;">
                                    silahkan cek di sini <i class="fas fa-external-link-alt" style="font-size: 10px; margin-left: 3px;"></i>
                                </a>
                            <?php endif; ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($notifStats['tidak_menang'] > 0): ?>
                            • <span style="color: #FFB6C1;">📋 <?= $notifStats['tidak_menang'] ?> Terimakasih telah Berpartisipasi</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="notification-actions" style="display: flex; align-items: center; gap: 10px;">
                    <button class="close-notification-btn" style="
                        background: none;
                        border: none;
                        color: white;
                        font-size: 18px;
                        cursor: pointer;
                        padding: 4px;
                        border-radius: 50%;
                        width: 24px;
                        height: 24px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        transition: all 0.3s ease;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Organization Info Card - Moved to Top -->
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
                                    <img src="<?php echo $FotoKepDesa; ?>" alt="Foto Kepala Desa" 
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                
                                <div class="profil-info" style="flex-grow: 1; min-width: 0;">
                                    <h1 style="margin: 0 0 8px 0; font-size: 1.5em; color: var(--purple-primary); font-weight: 700; line-height: 1.3;"><?php echo $NamaKepDesa; ?></h1>
                                    <p style="margin: 0 0 12px 0; font-size: 1em; color: #6c757d; font-weight: 500;">Kepala Desa</p>
                                </div>
                            </div>

                            <!-- Detail Area Style with 2 Column Layout -->
                            <div class="detail-area" style="border-top: 1px solid #dee2e6; padding-top: 18px;">
                                <div style="display: flex; gap: 25px;">
                                    <!-- Kolom Kiri: Wilayah -->
                                    <div style="flex: 1; min-width: 0;">
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
                                            <span class="detail-label" style="width: 85px; color: #6c757d; font-weight: 600; font-size: 0.8rem; flex-shrink: 0;">Desa</span>
                                            <?php 
                                            $isDesaEmpty = ($NamaDesaHeader == 'Data Tidak Ditemukan' || empty($NamaDesaHeader));
                                            $desaColor = $isDesaEmpty ? 'red' : '#343a40';
                                            $desaStyle = $isDesaEmpty ? 'font-style: italic;' : '';
                                            $desaText = $isDesaEmpty ? 'Belum di set' : $NamaDesaHeader;
                                            ?>
                                            <span class="detail-nilai" style="flex-grow: 1; color: <?php echo $desaColor; ?>; font-weight: 500; font-size: 0.8rem; <?php echo $desaStyle; ?>">
                                                <?php echo $desaText; ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Kolom Kanan: Kontak -->
                                    <div style="flex: 1; min-width: 0;">
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
                                            $isAlamatEmpty = ($alamatDesa == 'Data Tidak Ditemukan' || empty($alamatDesa));
                                            $alamatColor = $isAlamatEmpty ? 'red' : '#343a40';
                                            $alamatStyle = $isAlamatEmpty ? 'font-style: italic;' : '';
                                            $alamatTitle = $isAlamatEmpty ? 'Belum di set' : $alamatDesa;
                                            $alamatText = $isAlamatEmpty ? 'Belum di set' : $alamatDesa;
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
                
                <!-- Map Card - Added next to Organization Info -->
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card" style="height: 350px;">
                        <div class="card-header" style="padding: 15px; display: flex; justify-content: space-between; align-items: center;">
                            <div style="flex-grow: 1;">
                                <h4 class="card-title" style="font-size: 1.1rem; margin: 0;">Peta Wilayah Desa</h4>
                            </div>
                            <div style="flex-grow: 1;">
                                <p class="card-subtitle" style="font-size: 0.85rem; color: #666; margin: 5px 0 0 0;">
                                    <?php if (empty($Latitude) || empty($Longitude)): ?>
                                    <span style="color: red; font-weight: 500;"> | Alamat Desa belum diset</span>
                                    <?php else: ?>
                                    <span style="color: #28a745; font-weight: 500;"> | Lokasi geografis <?php echo $NamaDesaHeader; ?></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <?php if (empty($Latitude) || empty($Longitude)): ?>
                            <a href="v?pg=SettingProfileDesa" 
                               class="btn btn-warning btn-sm" 
                               style="border-radius: 20px; padding: 6px 15px; font-size: 11px; font-weight: 600;"
                               title="Atur koordinat desa">
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
                        
            <!-- Statistics Cards Row -->
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

                                <!-- BPD Total Card -->
                                <div class="col-xl-3 col-md-6 stretch-card">
                                    <div class="card stat-card warning">
                                        <div class="card-body">
                                            <div class="stat-icon">
                                                <i class="fas fa-users-cog"></i>
                                            </div>
                                            <?php
                                            $IdDesa = $_SESSION['IdDesa'];
                                            $QueryBPDTotal = mysqli_query($db, "SELECT count(master_pegawai_bpd.IdPegawaiFK) AS JmlBPDTotal FROM master_pegawai_bpd WHERE master_pegawai_bpd.IdDesaFK = '$IdDesa'");
                                            $DataBPDTotal = mysqli_fetch_assoc($QueryBPDTotal);
                                            $BPDTotal = $DataBPDTotal['JmlBPDTotal'] ?? 0;
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
            
            <!-- Charts Row -->
            <div class="row">
                <!-- Education Chart -->
                <div class="col-lg-8 grid-margin stretch-card">
                    <div class="card chart-card">
                        <div class="card-header">
                            <h4 class="card-title">Statistik Pendidikan Perangkat Desa</h4>
                            <p class="card-subtitle">Distribusi tingkat pendidikan perangkat desa aktif</p>
                        </div>
                        <div class="card-body">
                            <div id="StatistikPendidikan" style="height: 350px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Position Chart -->
                <div class="col-lg-4 grid-margin stretch-card">
                    <div class="card chart-card">
                        <div class="card-header">
                            <h4 class="card-title">Jabatan Perangkat Desa</h4>
                            <p class="card-subtitle">Total jabatan yang ada</p>
                        </div>
                        <div class="card-body">
                            <div id="StatistikJabatan" style="height: 350px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" <?php echo CSPHandler::scriptNonce(); ?>>
    // Purple theme color palette
    const purpleColors = ['#6f42c1', '#1bcfb4', '#fd397a', '#ffb822', '#0084ff', '#17a2b8', '#28a745'];
    
    function createStatistikPendidikan() {
        if (typeof Highcharts === 'undefined') {
            console.error('Highcharts not loaded for StatistikPendidikan');
            return;
        }
        
        Highcharts.chart('StatistikPendidikan', {
        chart: {
            type: 'pie',
            backgroundColor: 'transparent',
            style: {
                fontFamily: 'Ubuntu, sans-serif'
            }
        },
        exporting: {
            buttons: {
                contextButton: {
                    symbolFill: '#6f42c1',
                    symbolStroke: '#6f42c1',
                    theme: {
                        fill: 'rgba(111, 66, 193, 0.1)',
                        stroke: 'none',
                        r: 6,
                        states: {
                            hover: {
                                fill: 'rgba(111, 66, 193, 0.2)',
                                stroke: 'none'
                            }
                        }
                    }
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
                    format: '<b>{point.name}</b><br>{point.y} Orang<br>({point.percentage:.1f}%)',
                    style: {
                        fontSize: '11px',
                        fontFamily: 'Ubuntu, sans-serif',
                        fontWeight: '500',
                        color: '#2c2c54',
                        textOutline: 'none'
                    },
                    connectorColor: '#8e8e93',
                    distance: 20
                },
                showInLegend: true,
                states: {
                    hover: {
                        brightness: 0.1,
                        halo: {
                            size: 5,
                            opacity: 0.25
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
            history_pendidikan.IdPendidikanFK,
            history_pendidikan.Setting,
            master_pendidikan.IdPendidikan,
            master_pendidikan.JenisPendidikan,
            history_pendidikan.IdPegawaiFK,
            master_pegawai.Setting,
            master_pegawai.IdPegawaiFK,
            master_pegawai.IdDesaFK,
            Count(history_pendidikan.IdPegawaiFK) AS JmlPendidikan,
            history_mutasi.Setting AS SettingMut
            FROM
            history_pendidikan
            INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
            INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = history_pendidikan.IdPegawaiFK
            INNER JOIN history_mutasi ON history_pendidikan.IdPegawaiFK = history_mutasi.IdPegawaiFK
            WHERE
            history_pendidikan.Setting = 1 AND
            master_pegawai.Setting = 1 AND
            master_pegawai.IdDesaFK = '$IdDesaHeader' AND
            history_mutasi.Setting = 1
            GROUP BY
            history_pendidikan.IdPendidikanFK
            ORDER BY
            master_pendidikan.IdPendidikan ASC");
            while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
                $IdPendidikan = $DataPendidikan['IdPendidikanFK'];
                $Pendidikan = $DataPendidikan['JenisPendidikan'];
                $Jumlah = $DataPendidikan['JmlPendidikan'];
            ?> {
                    name: '<?php echo $Pendidikan; ?>',
                    y: <?php echo $Jumlah; ?>,
                    sliced: false,
                    selected: false
                },
            <?php } ?>
        ]}]
    });
    }
    
    // Initialize chart when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(createStatistikPendidikan, 500);
    });
</script>

<script type="text/javascript" <?php echo CSPHandler::scriptNonce(); ?>>
    function createStatistikJabatan() {
        if (typeof Highcharts === 'undefined') {
            console.error('Highcharts not loaded for StatistikJabatan');
            return;
        }
        
        Highcharts.chart('StatistikJabatan', {
        chart: {
            type: 'column',
            style: {
                fontFamily: 'Ubuntu, sans-serif'
            },
            backgroundColor: 'transparent'
        },
        exporting: {
            buttons: {
                contextButton: {
                    symbolFill: '#6f42c1',
                    symbolStroke: '#6f42c1',
                    theme: {
                        fill: 'rgba(111, 66, 193, 0.1)',
                        stroke: 'none',
                        r: 6,
                        states: {
                            hover: {
                                fill: 'rgba(111, 66, 193, 0.2)',
                                stroke: 'none'
                            }
                        }
                    }
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
                    fontSize: '11px',
                    fontWeight: '500',
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
                    fontSize: '11px',
                    fontWeight: '500',
                    fontFamily: 'Ubuntu, sans-serif'
                }
            },
            labels: {
                style: {
                    color: '#8e8e93',
                    fontSize: '10px',
                    fontFamily: 'Ubuntu, sans-serif'
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
                    color: '#2c2c54',
                    style: {
                        fontSize: '11px',
                        fontFamily: 'Ubuntu, sans-serif',
                        fontWeight: '600'
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
            master_pegawai.IdDesaFK
            FROM
            master_jabatan
            INNER JOIN history_mutasi ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
            INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
            WHERE
            history_mutasi.Setting = 1 AND
            history_mutasi.JenisMutasi <> 3 AND
            history_mutasi.JenisMutasi <> 4 AND
            history_mutasi.JenisMutasi <> 5 AND
            master_pegawai.IdDesaFK = '$IdDesaHeader'
            GROUP BY
            history_mutasi.IdJabatanFK");
            while ($DataJabatan = mysqli_fetch_assoc($QJabatan)) {
                $Jabatan = $DataJabatan['Jabatan'];
                $JmlJabatan = $DataJabatan['JmlJabatan'];
            ?> {
                    name: '<?php echo $Jabatan; ?>',
                    data: [<?php echo $JmlJabatan; ?>]
                },
            <?php } ?>
        ]
    });
    }
    
    // Initialize chart when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(createStatistikJabatan, 1000);
    });
</script>

<script type="text/javascript" <?php echo CSPHandler::scriptNonce(); ?>>
    function createStatistikBPD() {
        if (typeof Highcharts === 'undefined') {
            console.error('Highcharts not loaded for StatistikBPD');
            return;
        }
        
        Highcharts.chart('StatistikBPD', {
        chart: {
            type: 'column',
            style: {
                fontFamily: 'Ubuntu, sans-serif'
            },
            backgroundColor: 'transparent'
        },
        exporting: {
            buttons: {
                contextButton: {
                    symbolFill: '#6f42c1',
                    symbolStroke: '#6f42c1',
                    theme: {
                        fill: 'rgba(111, 66, 193, 0.1)',
                        stroke: 'none',
                        r: 6,
                        states: {
                            hover: {
                                fill: 'rgba(111, 66, 193, 0.2)',
                                stroke: 'none'
                            }
                        }
                    }
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
                    fontSize: '11px',
                    fontWeight: '500',
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
                    fontSize: '11px',
                    fontWeight: '500',
                    fontFamily: 'Ubuntu, sans-serif'
                }
            },
            labels: {
                style: {
                    color: '#8e8e93',
                    fontSize: '10px',
                    fontFamily: 'Ubuntu, sans-serif'
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
                    color: '#2c2c54',
                    style: {
                        fontSize: '11px',
                        fontFamily: 'Ubuntu, sans-serif',
                        fontWeight: '600'
                    },
                    y: -8
                },
                states: {
                    hover: {
                        brightness: 0.1,
                        halo: {
                            size: 5,
                            opacity: 0.25
                        }
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
            $IdDesa = $_SESSION['IdDesa'];
            $QueryPegawai = mysqli_query($db, "SELECT
                count(master_pegawai_bpd.IdPegawaiFK) AS JmlBPD,
                master_pegawai_bpd.IdDesaFK,
                master_pegawai_bpd.Kecamatan AS Kec,
                master_pegawai_bpd.Kabupaten,
                master_desa.IdDesa,
                master_desa.NamaDesa,
                master_desa.IdKecamatanFK,
                master_kecamatan.IdKecamatan,
                master_kecamatan.Kecamatan,
                master_kecamatan.IdKabupatenFK,
                master_setting_profile_dinas.IdKabupatenProfile,
                master_setting_profile_dinas.Kabupaten
                FROM master_pegawai_bpd
                LEFT JOIN master_desa ON master_pegawai_bpd.IdDesaFK = master_desa.IdDesa
                LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
                WHERE master_pegawai_bpd.IdDesaFK = '$IdDesa'
                GROUP BY master_kecamatan.IdKecamatan
                ORDER BY
                master_kecamatan.Kecamatan ASC");
            while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                $Jumlah = $DataPegawai['JmlBPD'];
                $Desa = $DataPegawai['NamaDesa'];


            ?> {
                    name: '<?php echo $Desa; ?>',
                    data: [<?php echo $Jumlah; ?>]
                },
            <?php } ?>
        ]
    });
    }
    
    // Initialize chart when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(createStatistikBPD, 1500);
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
        var statusBadge = hasCoordinates 
            ? '<span style="background: #28a745; color: white; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;"><i class="fas fa-check-circle"></i> Koordinat Aktual</span>'
            : '<span style="background: #ffc107; color: #333; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;"><i class="fas fa-exclamation-triangle"></i> Koordinat Default</span>';
        
        // Info popup
        var popupContent = `
            <div style="text-align: center; min-width: 220px; font-family: 'Ubuntu', sans-serif;">
                <div style="background: linear-gradient(135deg, #6f42c1, #5a34a3); color: white; margin: 8px 10px 15px 8px; padding: 15px; border-radius: 8px 8px 0 0;">
                    <h5 style="margin: 0; font-weight: 600;"><i class="fas fa-home"></i> <?php echo htmlspecialchars($NamaDesaHeader); ?></h5>
                </div>
                
                <div style="padding: 0 5px;">
                    <p style="margin: 5px 0; font-size: 13px; color: #666;"><i class="fas fa-map"></i> Kec. <?php echo htmlspecialchars($NamaKecamatanHeader); ?></p>
                    <p style="margin: 5px 0; font-size: 13px; color: #666;"><i class="fas fa-building"></i> Kab. <?php echo htmlspecialchars($Kabupaten); ?></p>
                    
                    <?php if (!empty($alamatDesa)): ?>
                    <p style="margin: 8px 0; font-size: 12px; color: #555; font-style: italic; line-height: 1.4;">
                        <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($alamatDesa); ?>
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
    
    // Function untuk close notification bar dengan handling persistent notifications
    function closeNotificationBar() {
        const notifBar = document.querySelector('.notification-bar');
        if (notifBar) {
            const isPersistent = notifBar.getAttribute('data-persistent') === 'true';
            const hasAwardBaru = notifBar.getAttribute('data-award-baru') === 'true';
            
            notifBar.style.animation = 'slideUp 0.3s ease-out forwards';
            setTimeout(() => {
                notifBar.style.display = 'none';
                
                // Jika bukan persistent atau tidak ada award baru, simpan status close
                if (!isPersistent && !hasAwardBaru) {
                    const notifContent = notifBar.querySelector('.notification-text');
                    if (notifContent) {
                        const contentHash = btoa(notifContent.textContent.trim()).substring(0, 20);
                        const timestamp = Date.now();
                        
                        // Store dengan timestamp, akan expired dalam 1 jam
                        const closeData = {
                            hash: contentHash,
                            timestamp: timestamp,
                            expired: timestamp + (60 * 60 * 1000) // 1 jam
                        };
                        
                        localStorage.setItem('notifBarClosed_' + contentHash, JSON.stringify(closeData));
                    }
                } else {
                    // Untuk award baru, hanya hide sementara untuk session ini
                    // Akan muncul lagi saat refresh halaman jika masih ada award baru
                    sessionStorage.setItem('awardBarTempClosed', 'true');
                }
            }, 300);
        }
    }
    
    // Check apakah notification bar dengan konten yang sama sudah di-close dan belum expired
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listener for close notification button
        const closeBtn = document.querySelector('.close-notification-btn');
        if (closeBtn) {
            closeBtn.addEventListener('click', closeNotificationBar);
        }
        
        const notifBar = document.querySelector('.notification-bar');
        if (notifBar) {
            const isPersistent = notifBar.getAttribute('data-persistent') === 'true';
            const hasAwardBaru = notifBar.getAttribute('data-award-baru') === 'true';
            
            // Untuk award baru (persistent), cek session storage
            if (hasAwardBaru && sessionStorage.getItem('awardBarTempClosed') === 'true') {
                notifBar.style.display = 'none';
                return;
            }
            
            // Untuk notifikasi lain, cek localStorage
            if (!isPersistent) {
                const notifContent = notifBar.querySelector('.notification-text');
                if (notifContent) {
                    const contentHash = btoa(notifContent.textContent.trim()).substring(0, 20);
                    const storedData = localStorage.getItem('notifBarClosed_' + contentHash);
                    
                    if (storedData) {
                        try {
                            const closeData = JSON.parse(storedData);
                            const now = Date.now();
                            
                            // Cek apakah masih dalam periode yang di-close dan belum expired
                            if (closeData.timestamp && closeData.expired && now < closeData.expired) {
                                notifBar.style.display = 'none';
                            } else {
                                // Hapus data expired
                                localStorage.removeItem('notifBarClosed_' + contentHash);
                            }
                        } catch (e) {
                            // Hapus data yang corrupt
                            localStorage.removeItem('notifBarClosed_' + contentHash);
                        }
                    }
                }
            }
        }
        
        // Cleanup expired close data
        cleanupExpiredCloseData();
    });
    
    // Function untuk cleanup data close yang sudah expired
    function cleanupExpiredCloseData() {
        const now = Date.now();
        const keysToRemove = [];
        
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            if (key && key.startsWith('notifBarClosed_')) {
                try {
                    const data = JSON.parse(localStorage.getItem(key));
                    if (data.expired && now > data.expired) {
                        keysToRemove.push(key);
                    }
                } catch (e) {
                    keysToRemove.push(key);
                }
            }
        }
        
        keysToRemove.forEach(key => localStorage.removeItem(key));
    }
    
    // Clear session storage untuk award bar jika user navigasi ke halaman award
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && (link.href.includes('pg=AwardViewAdminDesa') || link.href.includes('Award'))) {
            sessionStorage.removeItem('awardBarTempClosed');
        }
    });
    
    // Clear session storage saat halaman di-unload (refresh atau navigasi)
    window.addEventListener('beforeunload', function() {
        // Hanya clear jika user sudah mengklik link award
        if (document.querySelector('a[href*="AwardViewAdminDesa"]:active')) {
            sessionStorage.removeItem('awardBarTempClosed');
        }
    });
    
    // Execute alert script if available
    <?php if (!empty($alertScript)): ?>
    <?php echo $alertScript; ?>
    <?php endif; ?>
</script>