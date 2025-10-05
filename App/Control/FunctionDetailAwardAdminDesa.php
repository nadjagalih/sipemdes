<?php
// Function untuk detail award admin desa
if (!isset($db)) {
    include __DIR__ . "/../../Module/Config/Env.php";
}

// Start session jika belum
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include model
include __DIR__ . "/../Model/ExcAwardAdminDesa.php";

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

// Get ID award dari parameter
$IdAward = $_GET['id'] ?? '';

if (empty($IdAward)) {
    echo "<script>
        alert('ID Award tidak ditemukan.');
        window.location.href = '?pg=AwardViewAdminDesa';
    </script>";
    exit;
}

// Initialize model
$awardModel = new ExcAwardAdminDesa($db);

// Get award detail
$DataAward = $awardModel->getAwardDetail($IdAward);

if (!$DataAward) {
    echo "<script>
        alert('Award tidak ditemukan.');
        window.location.href = '?pg=AwardViewAdminDesa';
    </script>";
    exit;
}

// Get status info
$statusInfo = $awardModel->getAwardStatus($DataAward);

// Check apakah desa sudah daftar
$SudahDaftar = $awardModel->cekDesaSudahDaftar($IdDesa, $IdAward);

// Get kategori list
$KategoriList = $awardModel->getKategoriByAward($IdAward);

// Initialize karya variables
$QueryKaryaAward = false;
$jumlahKaryaAward = 0;

// Check if desa_award table exists (menggunakan logika dari FunctionKaryaDesa)
$checkTable = mysqli_query($db, "SHOW TABLES LIKE 'desa_award'");

if ($checkTable && mysqli_num_rows($checkTable) > 0) {
    // Get karya desa yang terdaftar untuk award ini dengan logika yang diperbaiki
    $QueryKaryaAward = mysqli_query($db, "SELECT 
        da.IdPesertaAward,
        da.NamaKarya as JudulKarya,
        da.LinkKarya,
        da.Posisi,
        da.TanggalInput as TanggalDaftar,
        da.DeskripsiKarya as Keterangan,
        da.NamaPeserta,
        mk.NamaKategori,
        mk.DeskripsiKategori,
        ma.JenisPenghargaan,
        ma.TahunPenghargaan,
        ma.StatusAktif as StatusAward,
        ma.MasaPenjurianMulai,
        ma.MasaPenjurianSelesai
        FROM desa_award da
        JOIN master_kategori_award mk ON da.IdKategoriAwardFK = mk.IdKategoriAward
        JOIN master_award_desa ma ON mk.IdAwardFK = ma.IdAward
        WHERE ma.IdAward = '$IdAward' AND da.IdDesaFK = '$IdDesa'
        ORDER BY da.TanggalInput DESC");

    // Simpan hasil untuk reset pointer nanti
    $jumlahKaryaAward = $QueryKaryaAward ? mysqli_num_rows($QueryKaryaAward) : 0;
} else {
    // Table tidak ada
    $jumlahKaryaAward = 0;
}

// Debug: Log query result
if (!$QueryKaryaAward && $checkTable && mysqli_num_rows($checkTable) > 0) {
    error_log("FunctionDetailAwardAdminDesa - Query karya failed: " . mysqli_error($db));
}
?>