<?php
// Function untuk Setting Profile Admin Desa
// File: App/Control/FunctionSettingProfileAdminDesa.php

// Function untuk mengambil data profile desa dari master_desa
function getCurrentProfileDesa($db, $idDesa) {
    $query = "SELECT 
        md.IdDesa,
        md.KodeDesa,
        md.NamaDesa,
        md.NoTelepon,
        md.alamatDesa,
        md.Latitude,
        md.Longitude,
        mk.Kecamatan,
        mspdin.Kabupaten
        FROM master_desa md
        INNER JOIN master_kecamatan mk ON md.IdKecamatanFK = mk.IdKecamatan
        INNER JOIN master_setting_profile_dinas mspdin ON md.IdKabupatenFK = mspdin.IdKabupatenProfile
        WHERE md.IdDesa = '$idDesa'";
        
    $result = mysqli_query($db, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return false;
}

// Function untuk validasi koordinat
function validateKoordinat($latitude, $longitude) {
    // Validasi format koordinat
    if (!is_numeric($latitude) || !is_numeric($longitude)) {
        return false;
    }
    
    // Validasi range koordinat Indonesia
    // Latitude: -11 sampai 6 (Indonesia)
    // Longitude: 95 sampai 141 (Indonesia)
    if ($latitude < -11 || $latitude > 6) {
        return false;
    }
    
    if ($longitude < 95 || $longitude > 141) {
        return false;
    }
    
    return true;
}

// Function untuk format nomor telepon
function formatNoTelepon($noTelepon) {
    // Hapus karakter yang tidak perlu
    $cleaned = preg_replace('/[^0-9\-\+\(\)\s]/', '', $noTelepon);
    return trim($cleaned);
}

// Function untuk validasi nomor telepon
function validateNoTelepon($noTelepon) {
    $cleaned = preg_replace('/[^0-9]/', '', $noTelepon);
    
    // Minimal 8 digit, maksimal 15 digit
    if (strlen($cleaned) < 8 || strlen($cleaned) > 15) {
        return false;
    }
    
    // Harus dimulai dengan 0 atau +62
    if (!preg_match('/^(0|62)/', $cleaned)) {
        return false;
    }
    
    return true;
}

// Ambil data dari session
$IdDesa = $_SESSION['IdDesa'] ?? null;
$IdPegawai = $_SESSION['IdPegawai'] ?? null;
$NamaDesa = $_SESSION['NamaDesa'] ?? '';

// Ambil data profile desa saat ini
$currentData = getCurrentProfileDesa($db, $IdDesa);

if ($currentData) {
    $currentNoTelepon = $currentData['NoTelepon'] ?? '';
    $currentLatitude = $currentData['Latitude'] ?? '';
    $currentLongitude = $currentData['Longitude'] ?? '';
    $namaDesa = $currentData['NamaDesa'] ?? 'Desa';
    $alamatDesa = $currentData['alamatDesa'] ?? '';
    $kecamatan = $currentData['Kecamatan'] ?? '';
    $kabupaten = $currentData['Kabupaten'] ?? '';
} else {
    $currentNoTelepon = '';
    $currentLatitude = '';
    $currentLongitude = '';
    $namaDesa = $NamaDesa ?: 'Desa';
    $alamatDesa = '';
    $kecamatan = '';
    $kabupaten = '';
}

// Handle alert messages dari parameter URL
$alert = $_GET['alert'] ?? '';
$message = $_GET['message'] ?? '';

// Tentukan tipe alert
$alertType = '';
if ($alert == 'success') {
    $alertType = 'success';
    $message = $message ?: 'Data berhasil disimpan';
} elseif ($alert == 'error') {
    $alertType = 'error';
    $message = $message ?: 'Terjadi kesalahan';
} elseif ($alert == 'warning') {
    $alertType = 'warning';
    $message = $message ?: 'Peringatan';
}
?>