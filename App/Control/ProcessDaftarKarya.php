<?php
// Process untuk daftar karya dari modal popup
header('Content-Type: application/json');

// Include database connection
if (!isset($db)) {
    include "../../Module/Config/Env.php";
}

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get info desa dari session
$IdDesa = $_SESSION['IdDesa'] ?? '';
$NamaDesa = $_SESSION['NamaDesa'] ?? '';

if (empty($IdDesa)) {
    echo json_encode([
        'success' => false,
        'message' => 'Session desa tidak ditemukan. Silakan login kembali.'
    ]);
    exit;
}

// Validate POST data
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diperbolehkan.'
    ]);
    exit;
}

// Get form data
$IdAward = $_POST['IdAward'] ?? '';
$IdKategoriAward = $_POST['IdKategoriAward'] ?? '';
$JudulKarya = $_POST['JudulKarya'] ?? '';
$LinkKarya = $_POST['LinkKarya'] ?? '';
$Keterangan = $_POST['Keterangan'] ?? '';

// Validate required fields
if (empty($IdAward) || empty($IdKategoriAward) || empty($JudulKarya) || empty($LinkKarya)) {
    echo json_encode([
        'success' => false,
        'message' => 'Semua field yang wajib harus diisi.'
    ]);
    exit;
}

// Sanitize input
$IdAward = mysqli_real_escape_string($db, $IdAward);
$IdKategoriAward = mysqli_real_escape_string($db, $IdKategoriAward);
$JudulKarya = mysqli_real_escape_string($db, $JudulKarya);
$LinkKarya = mysqli_real_escape_string($db, $LinkKarya);
$Keterangan = mysqli_real_escape_string($db, $Keterangan);

try {
    // Check if desa_award table exists (table sudah ada, skip create)

    // Check if award exists and is active
    $QueryCheckAward = mysqli_query($db, "SELECT * FROM master_award_desa WHERE IdAward = '$IdAward' AND StatusAktif = 'Aktif'");
    if (!$QueryCheckAward || mysqli_num_rows($QueryCheckAward) == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Award tidak ditemukan atau tidak aktif.'
        ]);
        exit;
    }

    // Check if kategori exists and belongs to this award
    $QueryCheckKategori = mysqli_query($db, "SELECT * FROM master_kategori_award WHERE IdKategoriAward = '$IdKategoriAward' AND IdAwardFK = '$IdAward'");
    if (!$QueryCheckKategori || mysqli_num_rows($QueryCheckKategori) == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Kategori tidak ditemukan atau tidak valid untuk award ini.'
        ]);
        exit;
    }

    // Check if desa sudah mendaftar ke award ini (HANYA 1 KATEGORI PER AWARD)
    $QueryCheckExisting = mysqli_query($db, "SELECT da.* FROM desa_award da 
        JOIN master_kategori_award mk ON da.IdKategoriAwardFK = mk.IdKategoriAward 
        WHERE da.IdDesaFK = '$IdDesa' AND mk.IdAwardFK = '$IdAward'");
    if ($QueryCheckExisting && mysqli_num_rows($QueryCheckExisting) > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Anda sudah mendaftar ke penghargaan ini. Setiap desa hanya dapat mendaftar 1 kategori per penghargaan.'
        ]);
        exit;
    }

    // Generate ID untuk desa_award
    $IdPesertaAward = 'PA' . date('Ymd') . rand(1000, 9999);
    
    // Check if ID already exists
    $checkId = mysqli_query($db, "SELECT IdPesertaAward FROM desa_award WHERE IdPesertaAward = '$IdPesertaAward'");
    while ($checkId && mysqli_num_rows($checkId) > 0) {
        $IdPesertaAward = 'PA' . date('Ymd') . rand(1000, 9999);
        $checkId = mysqli_query($db, "SELECT IdPesertaAward FROM desa_award WHERE IdPesertaAward = '$IdPesertaAward'");
    }

    // Insert data berdasarkan struktur tabel yang benar
    $QueryInsert = "INSERT INTO desa_award (
        IdPesertaAward,
        IdKategoriAwardFK,
        IdDesaFK,
        NamaPeserta,
        NamaKarya,
        DeskripsiKarya,
        LinkKarya,
        TanggalInput
    ) VALUES (
        '$IdPesertaAward',
        '$IdKategoriAward',
        '$IdDesa',
        '$NamaDesa',
        '$JudulKarya',
        '$Keterangan',
        '$LinkKarya',
        NOW()
    )";

    if (mysqli_query($db, $QueryInsert)) {
        echo json_encode([
            'success' => true,
            'message' => 'Karya berhasil didaftarkan!',
            'data' => [
                'id' => $IdPesertaAward,
                'judul' => $JudulKarya
            ]
        ]);
    } else {
        throw new Exception('Gagal menyimpan data: ' . mysqli_error($db));
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>