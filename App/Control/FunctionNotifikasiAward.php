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
    
    // 1. Award Baru (Belum mendaftar) - Hanya tampilkan jika award masih aktif
    $QueryAwardBaru = mysqli_query($db, "SELECT 
        ma.IdAward,
        ma.JenisPenghargaan,
        ma.TahunPenghargaan,
        ma.MasaAktifMulai,
        ma.MasaAktifSelesai,
        ma.MasaPenjurianSelesai,
        ma.StatusAktif,
        COUNT(da.IdPesertaAward) as SudahDaftar
        FROM master_award_desa ma
        LEFT JOIN master_kategori_award mk ON ma.IdAward = mk.IdAwardFK
        LEFT JOIN desa_award da ON mk.IdKategoriAward = da.IdKategoriAwardFK AND da.IdDesaFK = '$IdDesa'
        WHERE ma.StatusAktif = 'Aktif'
        AND (ma.MasaAktifMulai IS NULL OR ma.MasaAktifMulai <= '$currentDate')
        AND (ma.MasaAktifSelesai IS NULL OR ma.MasaAktifSelesai >= '$currentDate')
        AND (ma.MasaPenjurianSelesai IS NULL OR ma.MasaPenjurianSelesai >= '$currentDate')
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
    
    // 2. Sudah Daftar - Menunggu Penjurian (Semua karya yang sudah disubmit tapi belum ada hasil)
    $QueryMenungguPenjurian = mysqli_query($db, "SELECT 
        da.IdPesertaAward,
        da.NamaKarya,
        da.TanggalInput,
        mk.NamaKategori,
        ma.JenisPenghargaan,
        ma.TahunPenghargaan,
        ma.MasaPenjurianMulai,
        ma.MasaPenjurianSelesai,
        ma.MasaAktifSelesai,
        ma.StatusAktif
        FROM desa_award da
        JOIN master_kategori_award mk ON da.IdKategoriAwardFK = mk.IdKategoriAward
        JOIN master_award_desa ma ON mk.IdAwardFK = ma.IdAward
        WHERE da.IdDesaFK = '$IdDesa'
        AND (da.Posisi IS NULL OR da.Posisi = 0)
        AND (
            -- Tampilkan jika award masih aktif dan belum ada hasil
            (ma.StatusAktif = 'Aktif' AND (ma.MasaPenjurianSelesai IS NULL OR ma.MasaPenjurianSelesai >= '$currentDate'))
            OR
            -- Tampilkan jika masa penjurian sedang berlangsung
            (ma.MasaPenjurianMulai IS NOT NULL AND ma.MasaPenjurianSelesai IS NOT NULL 
             AND '$currentDate' >= ma.MasaPenjurianMulai AND '$currentDate' <= ma.MasaPenjurianSelesai)
            OR
            -- Tampilkan jika sudah submit tapi penjurian belum dimulai
            (ma.MasaPenjurianMulai IS NOT NULL AND '$currentDate' < ma.MasaPenjurianMulai)
        )
        ORDER BY da.TanggalInput DESC");
    
    if ($QueryMenungguPenjurian && mysqli_num_rows($QueryMenungguPenjurian) > 0) {
        while ($karya = mysqli_fetch_assoc($QueryMenungguPenjurian)) {
            $status = '';
            $iconText = '';
            if (!empty($karya['MasaPenjurianMulai']) && $currentDate < $karya['MasaPenjurianMulai']) {
                $status = 'Menunggu Penjurian Dimulai';
                $iconText = '⏳';
            } elseif (!empty($karya['MasaPenjurianMulai']) && !empty($karya['MasaPenjurianSelesai']) 
                     && $currentDate >= $karya['MasaPenjurianMulai'] && $currentDate <= $karya['MasaPenjurianSelesai']) {
                $status = 'Sedang Dinilai Juri';
                $iconText = '⚖️';
            } else {
                $status = 'Menunggu Hasil Penjurian';
                $iconText = '🕐';
            }
            
            $notifications[] = [
                'type' => 'menunggu_penjurian',
                'icon' => 'fa-clock-o',
                'color' => 'text-warning',
                'badge' => 'badge-warning',
                'title' => $iconText . ' ' . $status,
                'message' => 'Penghargaan: ' . $karya['JenisPenghargaan'] . ' ' . $karya['TahunPenghargaan'] . ' - Kategori: ' . $karya['NamaKategori'] . ' - Karya: ' . $karya['NamaKarya'],
                'action' => "window.location.href='?pg=KaryaDesa'",
                'action_text' => 'Lihat Karya',
                'time' => time_elapsed_string($karya['TanggalInput']),
                'data' => $karya
            ];
        }
    }
    
    // 3. Menang (Posisi 1-3) - Tampilkan lebih lama jika award sudah selesai
    $QueryMenang = mysqli_query($db, "SELECT 
        da.IdPesertaAward,
        da.NamaKarya,
        da.Posisi,
        da.TanggalInput,
        da.IdKategoriAwardFK,
        mk.NamaKategori,
        ma.JenisPenghargaan,
        ma.TahunPenghargaan,
        ma.MasaPenjurianSelesai,
        ma.MasaAktifSelesai,
        ma.StatusAktif
        FROM desa_award da
        JOIN master_kategori_award mk ON da.IdKategoriAwardFK = mk.IdKategoriAward
        JOIN master_award_desa ma ON mk.IdAwardFK = ma.IdAward
        WHERE da.IdDesaFK = '$IdDesa'
        AND da.Posisi IS NOT NULL 
        AND da.Posisi > 0 
        AND da.Posisi <= 3
        AND (
            -- Jika award masih aktif: tampilkan dalam 30 hari
            (ma.StatusAktif = 'Aktif' AND da.TanggalInput >= DATE_SUB('$currentDate', INTERVAL 30 DAY))
            OR
            -- Jika award sudah selesai: tampilkan dalam 90 hari (lebih lama)
            (ma.StatusAktif = 'Non-Aktif' AND da.TanggalInput >= DATE_SUB('$currentDate', INTERVAL 90 DAY))
            OR
            -- Jika masa aktif sudah berakhir: tampilkan dalam 90 hari
            (ma.MasaAktifSelesai IS NOT NULL AND ma.MasaAktifSelesai < '$currentDate' 
             AND da.TanggalInput >= DATE_SUB('$currentDate', INTERVAL 90 DAY))
        )
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
                'title' => 'Selamat Desa anda mendapatkan ' . $posisiText . ' di Award ' . $karya['JenisPenghargaan'] . ' ' . $karya['TahunPenghargaan'],
                'message' => 'silahkan cek di sini',
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
        ma.MasaAktifSelesai,
        ma.StatusAktif
        FROM desa_award da
        JOIN master_kategori_award mk ON da.IdKategoriAwardFK = mk.IdKategoriAward
        JOIN master_award_desa ma ON mk.IdAwardFK = ma.IdAward
        WHERE da.IdDesaFK = '$IdDesa'
        AND (
            -- Tidak menang: posisi lebih dari 3 atau posisi 0 (tidak lolos)
            (da.Posisi IS NOT NULL AND (da.Posisi > 3 OR da.Posisi = 0))
            OR
            -- Tidak ada posisi dan penjurian sudah selesai
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
            
            $statusText = '';
            $iconText = '';
            if (empty($karya['Posisi'])) {
                $statusText = 'Tidak Lolos Seleksi';
                $iconText = '📋';
            } else {
                $statusText = 'Peringkat ' . $karya['Posisi'];
                $iconText = '🏅';
            }
            
            $notifications[] = [
                'type' => 'tidak_menang',
                'icon' => 'fa-info-circle',
                'color' => 'text-muted',
                'badge' => 'badge-secondary',
                'title' => $iconText . ' ' . $statusText,
                'message' => 'Penghargaan: ' . $karya['JenisPenghargaan'] . ' ' . $karya['TahunPenghargaan'] . ' - Kategori: ' . $karya['NamaKategori'] . ' - Karya: ' . $karya['NamaKarya'],
                'action' => "window.location.href='?pg=KaryaDesa'",
                'action_text' => 'Lihat Detail',
                'time' => time_elapsed_string($karya['TanggalInput']),
                'data' => $karya
            ];
        }
    }
    
    // Filter notifikasi: Jika ada notifikasi menang dari award yang sudah selesai,
    // sembunyikan notifikasi award_baru dan menunggu_penjurian dari award yang sama
    $awardSelesaiDenganJuara = [];
    $filteredNotifications = [];
    
    // Identifikasi award yang sudah selesai dan ada pemenangnya
    foreach ($notifications as $notif) {
        if ($notif['type'] == 'menang') {
            $awardId = $notif['data']['JenisPenghargaan'] . '_' . $notif['data']['TahunPenghargaan'];
            $isAwardSelesai = false;
            
            // Cek apakah award sudah selesai berdasarkan berbagai kondisi
            if (isset($notif['data']['StatusAktif']) && $notif['data']['StatusAktif'] == 'Non-Aktif') {
                $isAwardSelesai = true;
            } elseif (!empty($notif['data']['MasaAktifSelesai']) && $notif['data']['MasaAktifSelesai'] < $currentDate) {
                $isAwardSelesai = true;
            } elseif (!empty($notif['data']['MasaPenjurianSelesai']) && $notif['data']['MasaPenjurianSelesai'] < $currentDate) {
                $isAwardSelesai = true;
            }
            
            if ($isAwardSelesai) {
                $awardSelesaiDenganJuara[] = $awardId;
            }
        }
    }
    
    // Filter notifikasi berdasarkan award yang sudah selesai
    foreach ($notifications as $notif) {
        $awardId = $notif['data']['JenisPenghargaan'] . '_' . $notif['data']['TahunPenghargaan'];
        
        // Jika award sudah selesai dan ada pemenangnya, hanya tampilkan notifikasi menang dan tidak_menang
        if (in_array($awardId, $awardSelesaiDenganJuara)) {
            if ($notif['type'] == 'menang' || $notif['type'] == 'tidak_menang') {
                $filteredNotifications[] = $notif;
            }
            // Skip notifikasi award_baru dan menunggu_penjurian untuk award yang sudah selesai
        } else {
            // Tampilkan semua notifikasi untuk award yang masih aktif
            $filteredNotifications[] = $notif;
        }
    }
    
    return $filteredNotifications;
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

// Get notifications (sudah terfilter di dalam function)
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