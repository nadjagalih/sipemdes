<?php
require_once "../Module/Security/Security.php";

if (isset($_GET['Kode'])) {
    $IdTemp = XSSProtection::sanitizeInput($_GET['Kode']);
    
    // Use prepared statement for SQL protection
    $stmt = SQLProtection::prepare($db, "SELECT * FROM master_award_desa WHERE IdAward = ?", [$IdTemp]);
    $result = SQLProtection::execute($stmt);
    $DataEditAward = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    
    $IdAward = $DataEditAward['IdAward'];
    $JenisPenghargaan = $DataEditAward['JenisPenghargaan'];
    $TahunPenghargaan = $DataEditAward['TahunPenghargaan'];
    $StatusAktif = $DataEditAward['StatusAktif'];
    $Deskripsi = $DataEditAward['Deskripsi'];
    $MasaAktifMulai = $DataEditAward['MasaAktifMulai'];
    $MasaAktifSelesai = $DataEditAward['MasaAktifSelesai'];
    
    // Handle masa penjurian columns jika ada
    $MasaPenjurianMulai = isset($DataEditAward['MasaPenjurianMulai']) ? $DataEditAward['MasaPenjurianMulai'] : '';
    $MasaPenjurianSelesai = isset($DataEditAward['MasaPenjurianSelesai']) ? $DataEditAward['MasaPenjurianSelesai'] : '';
    
    // Auto-update status berdasarkan masa aktif
    $today = date('Y-m-d');
    $statusOtomatis = 'Non-Aktif'; // default
    
    if (!empty($MasaAktifMulai) && !empty($MasaAktifSelesai)) {
        if ($today >= $MasaAktifMulai && $today <= $MasaAktifSelesai) {
            $statusOtomatis = 'Aktif';
        }
    }
    
    // Update status di database jika berbeda
    if ($StatusAktif !== $statusOtomatis) {
        $updateStmt = SQLProtection::prepare($db, "UPDATE master_award_desa SET StatusAktif = ? WHERE IdAward = ?", [$statusOtomatis, $IdAward]);
        SQLProtection::execute($updateStmt);
        $StatusAktif = $statusOtomatis; // Update variabel lokal
    }
    
    // Cek status masa penjurian
    $isMasaPenjurian = false;
    $statusPenjurian = 'Belum Masa Penjurian';
    
    if (!empty($MasaPenjurianMulai) && !empty($MasaPenjurianSelesai)) {
        if ($today >= $MasaPenjurianMulai && $today <= $MasaPenjurianSelesai) {
            $isMasaPenjurian = true;
            $statusPenjurian = 'Sedang Masa Penjurian';
        } elseif ($today > $MasaPenjurianSelesai) {
            $statusPenjurian = 'Masa Penjurian Selesai';
        } else {
            $statusPenjurian = 'Belum Masa Penjurian';
        }
    } else {
        $statusPenjurian = 'Masa Penjurian Belum Ditentukan';
    }
}
?>