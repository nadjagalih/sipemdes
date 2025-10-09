<?php
// Include database connection
if (!isset($db)) {
    include_once __DIR__ . "/../../Module/Config/Env.php";
}

// Pastikan session sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Hanya validasi jika IdPegawai tidak ada - untuk mencegah error "Undefined index"
if (!isset($_SESSION['IdPegawai'])) {
    // Set nilai default untuk mencegah error
    $IdPegawai = '';
    $NamaPegawai = 'Guest';
    $Level = 'Unknown';
    return;
}

$IdPegawai = $_SESSION['IdPegawai'];

// Sanitize input untuk mencegah SQL injection
$IdPegawai = mysqli_real_escape_string($db, $IdPegawai);

$QueryNamaPegawai = mysqli_query($db, "SELECT
master_pegawai.IdPegawaiFK,
master_pegawai.Nama,
main_user.IdPegawai,
main_user.IdLevelUserFK,
leveling_user.IdLevelUser,
leveling_user.UserLevel
FROM
master_pegawai
INNER JOIN main_user ON main_user.IdPegawai = master_pegawai.IdPegawaiFK
INNER JOIN leveling_user ON main_user.IdLevelUserFK = leveling_user.IdLevelUser
WHERE master_pegawai.IdPegawaiFK = '$IdPegawai' ");

// Cek apakah query berhasil
if (!$QueryNamaPegawai) {
    die('Database query failed: ' . mysqli_error($db));
}

$GetNamaPegawai = mysqli_fetch_assoc($QueryNamaPegawai);

// Cek apakah data ditemukan dan tidak null
if ($GetNamaPegawai && is_array($GetNamaPegawai)) {
    $NamaPegawai = isset($GetNamaPegawai['Nama']) ? $GetNamaPegawai['Nama'] : 'Unknown User';
    $Level = isset($GetNamaPegawai['UserLevel']) ? $GetNamaPegawai['UserLevel'] : 'Unknown Level';
} else {
    // Jika data tidak ditemukan, set nilai default
    $NamaPegawai = 'Unknown User';
    $Level = 'Unknown Level';
}


