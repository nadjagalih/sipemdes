<?php
// Debug mode - aktifkan dengan parameter ?debug=1 di URL
$debugMode = isset($_GET['debug']) && $_GET['debug'] == '1';

if ($debugMode) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // Debug code removed for production
}

// Handle AJAX requests untuk get kategori
if (isset($_GET['ajax']) && $_GET['ajax'] == 'getKategori') {
    // Include database connection untuk AJAX
    if (!isset($db)) {
        include __DIR__ . "/../../Module/Config/Env.php";
    }
    
    // Start session jika belum
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if (isset($_GET['IdAward']) && !empty($_GET['IdAward'])) {
        $IdAward = mysqli_real_escape_string($db, $_GET['IdAward']);
        
        // Debug logging
        if ($debugMode) {
            error_log("AJAX Debug: IdAward = $IdAward");
        }
        
        $QueryKategori = mysqli_query($db, "SELECT 
            IdKategoriAward,
            NamaKategori,
            DeskripsiKategori
            FROM master_kategori_award 
            WHERE IdAwardFK = '$IdAward'
            ORDER BY NamaKategori ASC");
        
        if (!$QueryKategori) {
            // Debug error log removed for production
            echo '<option value="">Database error</option>';
        } elseif (mysqli_num_rows($QueryKategori) > 0) {
            echo '<option value="">-- Pilih Kategori --</option>';
            while ($DataKategori = mysqli_fetch_assoc($QueryKategori)) {
                echo "<option value='{$DataKategori['IdKategoriAward']}'>{$DataKategori['NamaKategori']}{$deskripsi}</option>";
            }
        } else {
            // Debug error log removed for production
            echo '<option value="">Tidak ada kategori tersedia</option>';
        }
    } else {
        // Debug error log removed for production
        echo '<option value="">Award tidak valid</option>';
    }
    exit; // Stop execution untuk AJAX request
}

if ($debugMode) // Debug code removed for production
// Query untuk mendapatkan award yang sedang aktif dan berlangsung
$QueryAwardAktif = mysqli_query($db, "SELECT 
    IdAward,
    JenisPenghargaan, 
    TahunPenghargaan,
    MasaAktifMulai,
    MasaAktifSelesai,
    StatusAktif
    FROM master_award_desa 
    WHERE StatusAktif = 'Aktif' 
    AND (MasaAktifMulai IS NULL OR MasaAktifMulai <= CURDATE()) 
    AND (MasaAktifSelesai IS NULL OR MasaAktifSelesai >= CURDATE())
    ORDER BY TahunPenghargaan DESC, JenisPenghargaan ASC");

if (!$QueryAwardAktif) {
    if ($debugMode) // Debug code removed for production
echo "Error: " . mysqli_error($db);
    exit;
}

if ($debugMode) // Debug code removed for production
// Get info desa dari session
$IdDesa = $_SESSION['IdDesa'] ?? '';
$NamaDesa = $_SESSION['NamaDesa'] ?? '';

if (empty($IdDesa)) {
    if ($debugMode) // Debug code removed for production
echo "<script>
        alert('Session desa tidak ditemukan. Silakan login kembali.');
        window.location.href = '../../Auth/SignIn.php';
    </script>";
    exit;
}

if ($debugMode) // Debug code removed for production
?>