<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);
    
    $QueryEditAward = mysqli_query($db, "SELECT * FROM master_award_desa WHERE IdAward = '$IdTemp'");
    $DataEditAward = mysqli_fetch_assoc($QueryEditAward);
    
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
        mysqli_query($db, "UPDATE master_award_desa SET StatusAktif = '$statusOtomatis' WHERE IdAward = '$IdAward'");
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