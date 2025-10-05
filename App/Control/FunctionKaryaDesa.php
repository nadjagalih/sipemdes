<?php
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

// Initialize variables
$totalKarya = 0;
$totalMenang = 0;
$totalProses = 0;
$totalAktif = 0;
$QueryKarya = false;

// Check if desa_award table exists
$checkTable = mysqli_query($db, "SHOW TABLES LIKE 'desa_award'");

if ($checkTable && mysqli_num_rows($checkTable) > 0) {
    // Query untuk mendapatkan karya yang sudah didaftarkan oleh desa ini
    $QueryKarya = mysqli_query($db, "SELECT 
        da.IdPesertaAward as IdDesaAward,
        da.NamaKarya as JudulKarya,
        da.LinkKarya,
        da.Posisi,
        da.TanggalInput as TanggalDaftar,
        'Aktif' as Status,
        da.DeskripsiKarya as Keterangan,
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
        WHERE da.IdDesaFK = '$IdDesa'
        ORDER BY da.TanggalInput DESC");

    if ($QueryKarya) {
        // Statistik karya
        $totalKarya = mysqli_num_rows($QueryKarya);

        // Count karya yang menang (ada posisi menang)
        $QueryMenang = mysqli_query($db, "SELECT COUNT(*) as total FROM desa_award 
            WHERE IdDesaFK = '$IdDesa' 
            AND Posisi IS NOT NULL AND Posisi > 0");
        if ($QueryMenang) {
            $DataMenang = mysqli_fetch_assoc($QueryMenang);
            $totalMenang = $DataMenang['total'];
        }

        // Count karya yang masih dalam proses penjurian
        $checkPenjurianColumns = mysqli_query($db, "SHOW COLUMNS FROM master_award_desa LIKE 'MasaPenjurianMulai'");
        if ($checkPenjurianColumns && mysqli_num_rows($checkPenjurianColumns) > 0) {
            $QueryProses = mysqli_query($db, "SELECT COUNT(*) as total FROM desa_award da
                JOIN master_kategori_award mk ON da.IdKategoriAwardFK = mk.IdKategoriAward
                JOIN master_award_desa ma ON mk.IdAwardFK = ma.IdAward
                WHERE da.IdDesaFK = '$IdDesa' 
                AND ma.StatusAktif = 'Aktif'
                AND ma.MasaPenjurianMulai IS NOT NULL 
                AND ma.MasaPenjurianSelesai IS NOT NULL
                AND CURDATE() BETWEEN ma.MasaPenjurianMulai AND ma.MasaPenjurianSelesai
                AND (da.Posisi IS NULL OR da.Posisi = 0)");
            if ($QueryProses) {
                $DataProses = mysqli_fetch_assoc($QueryProses);
                $totalProses = $DataProses['total'];
            }
        }

        // Count karya pada award yang masih aktif
        $QueryAktif = mysqli_query($db, "SELECT COUNT(*) as total FROM desa_award da
            JOIN master_kategori_award mk ON da.IdKategoriAwardFK = mk.IdKategoriAward
            JOIN master_award_desa ma ON mk.IdAwardFK = ma.IdAward
            WHERE da.IdDesaFK = '$IdDesa' AND ma.StatusAktif = 'Aktif'");
        if ($QueryAktif) {
            $DataAktif = mysqli_fetch_assoc($QueryAktif);
            $totalAktif = $DataAktif['total'];
        }
    }
}

// Count award yang masih bisa didaftarkan (aktif dan dalam masa aktif)
$QueryAwardTersedia = mysqli_query($db, "SELECT COUNT(*) as total FROM master_award_desa 
    WHERE StatusAktif = 'Aktif' 
    AND (MasaAktifMulai IS NULL OR MasaAktifMulai <= CURDATE()) 
    AND (MasaAktifSelesai IS NULL OR MasaAktifSelesai >= CURDATE())");

$totalAwardTersedia = 0;
if ($QueryAwardTersedia) {
    $DataAwardTersedia = mysqli_fetch_assoc($QueryAwardTersedia);
    $totalAwardTersedia = $DataAwardTersedia['total'];
}
?>