<?php
// Function untuk notifikasi award di dashboard admin desa
if (!isset($db)) {
    include __DIR__ . "/../../Module/Config/Env.php";
}

// Start session jika belum
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get info desa dari session
$IdDesa = $_SESSION['IdDesa'] ?? '';

if (empty($IdDesa)) {
    return;
}

// Function untuk mendapatkan notifikasi award
function getAwardNotifications($db, $IdDesa) {
    $notifications = [];
    
    // Check if desa_award table exists
    $checkTable = mysqli_query($db, "SHOW TABLES LIKE 'desa_award'");
    if (!$checkTable || mysqli_num_rows($checkTable) == 0) {
        return $notifications;
    }
    
    $currentDate = date('Y-m-d');
    
    // 1. Award Baru (Belum mendaftar)
    $QueryAwardBaru = mysqli_query($db, "SELECT 
        ma.IdAward,
        ma.JenisPenghargaan,
        ma.TahunPenghargaan,
        ma.MasaAktifMulai,
        ma.MasaAktifSelesai,
        COUNT(da.IdPesertaAward) as SudahDaftar
        FROM master_award_desa ma
        LEFT JOIN master_kategori_award mk ON ma.IdAward = mk.IdAwardFK
        LEFT JOIN desa_award da ON mk.IdKategoriAward = da.IdKategoriAwardFK AND da.IdDesaFK = '$IdDesa'
        WHERE ma.StatusAktif = 'Aktif'
        AND (ma.MasaAktifMulai IS NULL OR ma.MasaAktifMulai <= '$currentDate')
        AND (ma.MasaAktifSelesai IS NULL OR ma.MasaAktifSelesai >= '$currentDate')
        GROUP BY ma.IdAward
        HAVING SudahDaftar = 0
        ORDER BY ma.TanggalInput DESC");
    
    if ($QueryAwardBaru && mysqli_num_rows($QueryAwardBaru) > 0) {
        while ($award = mysqli_fetch_assoc($QueryAwardBaru)) {
            $notifications[] = [
                'type' => 'award_baru',
                'icon' => 'fa-trophy',
                'color' => 'text-success',
                'badge' => 'badge-success',
                'title' => 'Award Baru Tersedia!',
                'message' => $award['JenisPenghargaan'] . ' ' . $award['TahunPenghargaan'],
                'action' => "window.location.href='?pg=AwardViewAdminDesa'",
                'action_text' => 'Daftar Sekarang',
                'time' => 'Baru',
                'data' => $award
            ];
        }
    }
    
    // 2. Sudah Daftar - Menunggu Penjurian
    $QueryMenungguPenjurian = mysqli_query($db, "SELECT 
        da.IdPesertaAward,
        da.NamaKarya,
        da.TanggalInput,
        mk.NamaKategori,
        ma.JenisPenghargaan,
        ma.TahunPenghargaan,
        ma.MasaPenjurianMulai,
        ma.MasaPenjurianSelesai
        FROM desa_award da
        JOIN master_kategori_award mk ON da.IdKategoriAwardFK = mk.IdKategoriAward
        JOIN master_award_desa ma ON mk.IdAwardFK = ma.IdAward
        WHERE da.IdDesaFK = '$IdDesa'
        AND ma.StatusAktif = 'Aktif'
        AND (da.Posisi IS NULL OR da.Posisi = 0)
        AND (
            (ma.MasaPenjurianMulai IS NOT NULL AND '$currentDate' < ma.MasaPenjurianMulai) OR
            (ma.MasaPenjurianMulai IS NOT NULL AND ma.MasaPenjurianSelesai IS NOT NULL 
             AND '$currentDate' >= ma.MasaPenjurianMulai AND '$currentDate' <= ma.MasaPenjurianSelesai)
        )
        ORDER BY da.TanggalInput DESC");
    
    if ($QueryMenungguPenjurian && mysqli_num_rows($QueryMenungguPenjurian) > 0) {
        while ($karya = mysqli_fetch_assoc($QueryMenungguPenjurian)) {
            $status = '';
            if (!empty($karya['MasaPenjurianMulai']) && $currentDate < $karya['MasaPenjurianMulai']) {
                $status = 'Menunggu Dimulai';
            } else {
                $status = 'Sedang Dinilai';
            }
            
            $notifications[] = [
                'type' => 'menunggu_penjurian',
                'icon' => 'fa-clock-o',
                'color' => 'text-warning',
                'badge' => 'badge-warning',
                'title' => $status,
                'message' => $karya['NamaKarya'] . ' (' . $karya['NamaKategori'] . ')',
                'action' => "window.location.href='?pg=KaryaDesa'",
                'action_text' => 'Lihat Karya',
                'time' => time_elapsed_string($karya['TanggalInput']),
                'data' => $karya
            ];
        }
    }
    
    // 3. Menang (Posisi 1-3) - Tampilkan dalam 30 hari terakhir
    $QueryMenang = mysqli_query($db, "SELECT 
        da.IdPesertaAward,
        da.NamaKarya,
        da.Posisi,
        da.TanggalInput,
        mk.NamaKategori,
        ma.JenisPenghargaan,
        ma.TahunPenghargaan,
        ma.MasaPenjurianSelesai
        FROM desa_award da
        JOIN master_kategori_award mk ON da.IdKategoriAwardFK = mk.IdKategoriAward
        JOIN master_award_desa ma ON mk.IdAwardFK = ma.IdAward
        WHERE da.IdDesaFK = '$IdDesa'
        AND da.Posisi IS NOT NULL 
        AND da.Posisi > 0 
        AND da.Posisi <= 3
        AND da.TanggalInput >= DATE_SUB('$currentDate', INTERVAL 30 DAY)
        ORDER BY da.Posisi ASC, da.TanggalInput DESC");
    
    if ($QueryMenang && mysqli_num_rows($QueryMenang) > 0) {
        while ($karya = mysqli_fetch_assoc($QueryMenang)) {
            $posisiText = '';
            $iconText = '';
            switch($karya['Posisi']) {
                case 1: 
                    $posisiText = 'Juara 1'; 
                    $iconText = '🥇';
                    break;
                case 2: 
                    $posisiText = 'Juara 2'; 
                    $iconText = '🥈';
                    break;
                case 3: 
                    $posisiText = 'Juara 3'; 
                    $iconText = '🥉';
                    break;
                default: 
                    $posisiText = 'Peringkat ' . $karya['Posisi']; 
                    $iconText = '🏆';
                    break;
            }
            
            $notifications[] = [
                'type' => 'menang',
                'icon' => 'fa-trophy',
                'color' => 'text-success',
                'badge' => 'badge-success',
                'title' => $iconText . ' Selamat! ' . $posisiText,
                'message' => 'Award: ' . $karya['JenisPenghargaan'] . ' ' . $karya['TahunPenghargaan'] . ' - Karya: ' . $karya['NamaKarya'],
                'action' => "window.location.href='?pg=KaryaDesa'",
                'action_text' => 'Lihat Detail',
                'time' => time_elapsed_string($karya['TanggalInput']),
                'data' => $karya
            ];
        }
    }
    
    // 4. Tidak Menang - Hanya tampilkan dalam 7 hari setelah input, dan sembunyikan jika award sudah berakhir lama
    $QueryTidakMenang = mysqli_query($db, "SELECT 
        da.IdPesertaAward,
        da.NamaKarya,
        da.Posisi,
        da.TanggalInput,
        mk.NamaKategori,
        ma.JenisPenghargaan,
        ma.TahunPenghargaan,
        ma.MasaPenjurianSelesai,
        ma.MasaAktifSelesai
        FROM desa_award da
        JOIN master_kategori_award mk ON da.IdKategoriAwardFK = mk.IdKategoriAward
        JOIN master_award_desa ma ON mk.IdAwardFK = ma.IdAward
        WHERE da.IdDesaFK = '$IdDesa'
        AND (
            (da.Posisi IS NOT NULL AND da.Posisi > 3) OR
            (da.Posisi IS NULL AND ma.MasaPenjurianSelesai IS NOT NULL AND '$currentDate' > ma.MasaPenjurianSelesai)
        )
        AND (
            -- Hanya tampilkan jika award belum berakhir atau baru berakhir dalam 7 hari
            (ma.MasaAktifSelesai IS NULL) OR
            (ma.MasaAktifSelesai >= DATE_SUB('$currentDate', INTERVAL 7 DAY))
        )
        AND da.TanggalInput >= DATE_SUB('$currentDate', INTERVAL 7 DAY)
        ORDER BY da.TanggalInput DESC");
    
    if ($QueryTidakMenang && mysqli_num_rows($QueryTidakMenang) > 0) {
        while ($karya = mysqli_fetch_assoc($QueryTidakMenang)) {
            // Skip jika award sudah berakhir lebih dari 7 hari
            if (!empty($karya['MasaAktifSelesai']) && strtotime($karya['MasaAktifSelesai']) < strtotime('-7 days')) {
                continue;
            }
            
            $statusText = empty($karya['Posisi']) ? 'Tidak Lolos Seleksi' : 'Peringkat ' . $karya['Posisi'];
            
            $notifications[] = [
                'type' => 'tidak_menang',
                'icon' => 'fa-info-circle',
                'color' => 'text-muted',
                'badge' => 'badge-secondary',
                'title' => '📋 ' . $statusText,
                'message' => 'Award: ' . $karya['JenisPenghargaan'] . ' ' . $karya['TahunPenghargaan'] . ' - Karya: ' . $karya['NamaKarya'],
                'action' => "window.location.href='?pg=KaryaDesa'",
                'action_text' => 'Lihat Detail',
                'time' => time_elapsed_string($karya['TanggalInput']),
                'data' => $karya
            ];
        }
    }
    
    return $notifications;
}

// Function untuk menghitung waktu yang lalu
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    if ($diff->y > 0) return $diff->y . ' tahun lalu';
    if ($diff->m > 0) return $diff->m . ' bulan lalu';
    if ($diff->d > 0) return $diff->d . ' hari lalu';
    if ($diff->h > 0) return $diff->h . ' jam lalu';
    if ($diff->i > 0) return $diff->i . ' menit lalu';
    
    return 'baru saja';
}

// Get notifications
$awardNotifications = getAwardNotifications($db, $IdDesa);
$totalNotifications = count($awardNotifications);

// Group notifications by type untuk statistik
$notifStats = [
    'award_baru' => 0,
    'menunggu_penjurian' => 0,  
    'menang' => 0,
    'tidak_menang' => 0
];

foreach ($awardNotifications as $notif) {
    if (isset($notifStats[$notif['type']])) {
        $notifStats[$notif['type']]++;
    }
}
?>