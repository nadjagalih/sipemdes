<?php
// Function untuk menampilkan daftar award yang tersedia untuk admin desa
if (!isset($db)) {
    include "../Module/Config/Env.php";
}

// Start session jika belum
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get info desa dari session
$IdDesa = $_SESSION['IdDesa'] ?? '';
$NamaDesa = $_SESSION['NamaDesa'] ?? '';

if (empty($IdDesa)) {
    echo "<script>
        alert('Session desa tidak ditemukan. Silakan login kembali.');
        window.location.href = '../../Auth/SignIn.php';
    </script>";
    exit;
}

// Get filter parameters
$statusFilter = $_GET['status'] ?? '';
$tahunFilter = $_GET['tahun'] ?? '';
$searchFilter = $_GET['search'] ?? '';

// Check if MasaPenjurian columns exist
$checkColumns = mysqli_query($db, "SHOW COLUMNS FROM master_award_desa LIKE 'MasaPenjurianMulai'");
$hasPenjurianColumns = mysqli_num_rows($checkColumns) > 0;

// Build WHERE conditions
$whereConditions = [];
$whereConditions[] = "StatusAktif = 'Aktif'"; // Hanya tampilkan yang aktif untuk desa

// Add filters
if (!empty($statusFilter)) {
    if ($statusFilter == 'Berlangsung' && $hasPenjurianColumns) {
        $whereConditions[] = "MasaPenjurianMulai IS NOT NULL AND MasaPenjurianSelesai IS NOT NULL AND CURDATE() BETWEEN MasaPenjurianMulai AND MasaPenjurianSelesai";
    } else {
        $whereConditions[] = "StatusAktif = '" . mysqli_real_escape_string($db, $statusFilter) . "'";
    }
}

if (!empty($tahunFilter)) {
    $whereConditions[] = "TahunPenghargaan = '" . mysqli_real_escape_string($db, $tahunFilter) . "'";
}

if (!empty($searchFilter)) {
    $whereConditions[] = "JenisPenghargaan LIKE '%" . mysqli_real_escape_string($db, $searchFilter) . "%'";
}

$whereClause = implode(' AND ', $whereConditions);

// Build select query based on available columns
if ($hasPenjurianColumns) {
    $selectColumns = "IdAward, JenisPenghargaan, TahunPenghargaan, MasaAktifMulai, MasaAktifSelesai, MasaPenjurianMulai, MasaPenjurianSelesai, StatusAktif";
} else {
    $selectColumns = "IdAward, JenisPenghargaan, TahunPenghargaan, MasaAktifMulai, MasaAktifSelesai, StatusAktif";
}

// Query untuk mendapatkan daftar award
$QueryAwardList = mysqli_query($db, "SELECT $selectColumns
    FROM master_award_desa 
    WHERE $whereClause
    ORDER BY TahunPenghargaan DESC, JenisPenghargaan ASC");

if (!$QueryAwardList) {
    echo "Error: " . mysqli_error($db);
    exit;
}

// Statistik untuk cards
// Total award tersedia (aktif)
$QueryTotalTersedia = mysqli_query($db, "SELECT COUNT(*) as total FROM master_award_desa WHERE StatusAktif = 'Aktif'");
$TotalAwardTersedia = 0;
if ($QueryTotalTersedia) {
    $DataTotalTersedia = mysqli_fetch_assoc($QueryTotalTersedia);
    $TotalAwardTersedia = $DataTotalTersedia['total'];
}

// Total karya yang sudah didaftarkan desa ini
// Check if desa_award table exists first
$checkTable = mysqli_query($db, "SHOW TABLES LIKE 'desa_award'");
$TotalKaryaTerdaftar = 0;
if ($checkTable && mysqli_num_rows($checkTable) > 0) {
    $QueryTotalTerdaftar = mysqli_query($db, "SELECT COUNT(*) as total FROM desa_award WHERE IdDesaFK = '$IdDesa'");
    if ($QueryTotalTerdaftar) {
        $DataTotalTerdaftar = mysqli_fetch_assoc($QueryTotalTerdaftar);
        $TotalKaryaTerdaftar = $DataTotalTerdaftar['total'];
    }
}

// Award yang sedang berlangsung (masa penjurian)
if ($hasPenjurianColumns) {
    $QueryBerlangsung = mysqli_query($db, "SELECT COUNT(*) as total FROM master_award_desa 
        WHERE StatusAktif = 'Aktif' 
        AND MasaPenjurianMulai IS NOT NULL 
        AND MasaPenjurianSelesai IS NOT NULL 
        AND CURDATE() BETWEEN MasaPenjurianMulai AND MasaPenjurianSelesai");
    $AwardBerlangsung = 0;
    if ($QueryBerlangsung) {
        $DataBerlangsung = mysqli_fetch_assoc($QueryBerlangsung);
        $AwardBerlangsung = $DataBerlangsung['total'];
    }
} else {
    $AwardBerlangsung = 0;
}

// Award tahun ini
$tahunIni = date('Y');
$QueryTahunIni = mysqli_query($db, "SELECT COUNT(*) as total FROM master_award_desa 
    WHERE StatusAktif = 'Aktif' AND TahunPenghargaan = '$tahunIni'");
$AwardTahunIni = 0;
if ($QueryTahunIni) {
    $DataTahunIni = mysqli_fetch_assoc($QueryTahunIni);
    $AwardTahunIni = $DataTahunIni['total'];
}
?>