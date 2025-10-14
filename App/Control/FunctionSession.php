<?php
// Include database connection
if (!isset($db)) {
    include_once __DIR__ . "/../../Module/Config/Env.php";
}

// Pastikan session sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Prevent browser caching of protected pages - hanya jika headers belum dikirim
if (!headers_sent()) {
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
}

// Validasi session yang lebih ketat - support multiple session structures
$isKecamatanUser = isset($_SESSION['IdKecamatan']) && isset($_SESSION['IdUser']);
$isRegularUser = isset($_SESSION['IdPegawai']) && isset($_SESSION['NameUser']);

if (!$isKecamatanUser && !$isRegularUser) {
    // Session tidak valid, redirect ke login
    session_unset();
    session_destroy();
    
    // Tentukan redirect path berdasarkan URL saat ini
    $currentPath = $_SERVER['REQUEST_URI'] ?? '';
    $redirectPath = "../Auth/SignIn.php";
    
    // Jika di folder Kecamatan, redirect ke AuthKecamatan
    if (strpos($currentPath, '/Kecamatan') !== false || strpos($currentPath, 'Kecamatan') !== false) {
        $redirectPath = "../AuthKecamatan/SignIn.php";
    }
    
    // Gunakan JavaScript redirect yang lebih aman
    if (!headers_sent()) {
        header("Location: $redirectPath");
        exit();
    } else {
        // Jika headers sudah dikirim, gunakan JavaScript
        echo '<script>
            if (typeof(Storage) !== "undefined") {
                sessionStorage.clear();
                localStorage.clear();
            }
            history.pushState(null, null, location.href);
            window.onpopstate = function () {
                history.go(1);
            };
            window.location.replace("' . $redirectPath . '");
        </script>';
        exit();
    }
}

// Set IdPegawai based on session type
if ($isKecamatanUser) {
    $IdPegawai = $_SESSION['IdUser']; // Kecamatan uses IdUser instead of IdPegawai
} else {
    $IdPegawai = $_SESSION['IdPegawai']; // Regular users
}

// Sanitize input untuk mencegah SQL injection
$IdPegawai = mysqli_real_escape_string($db, $IdPegawai);

// Different query based on user type
if ($isKecamatanUser) {
    // Query for Kecamatan users
    $QueryNamaPegawai = mysqli_query($db, "SELECT
    main_user_kecamatan.IdUser as IdPegawaiFK,
    main_user_kecamatan.NameAkses as Nama,
    main_user_kecamatan.IdUser as IdPegawai,
    main_user_kecamatan.IdLevelUserFK,
    leveling_user.IdLevelUser,
    leveling_user.UserLevel
    FROM
    main_user_kecamatan
    INNER JOIN leveling_user ON main_user_kecamatan.IdLevelUserFK = leveling_user.IdLevelUser
    WHERE main_user_kecamatan.IdUser = '$IdPegawai' ");
} else {
    // Query for regular users (Desa/Admin)
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
}

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

?>
