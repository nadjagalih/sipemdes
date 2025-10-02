<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);
    
    // Cek apakah kolom masa penjurian sudah ada
    $checkColumns = mysqli_query($db, "SHOW COLUMNS FROM master_award_desa LIKE 'MasaPenjurianMulai'");
    $hasJuryColumns = mysqli_num_rows($checkColumns) > 0;
    
    if ($hasJuryColumns) {
        $QueryDetailAward = mysqli_query($db, "SELECT 
            ma.IdAward,
            ma.JenisPenghargaan,
            ma.TahunPenghargaan,
            ma.StatusAktif,
            ma.Deskripsi,
            ma.TanggalInput,
            ma.MasaAktifMulai,
            ma.MasaAktifSelesai,
            ma.MasaPenjurianMulai,
            ma.MasaPenjurianSelesai
            FROM master_award_desa ma
            WHERE ma.IdAward = '$IdTemp'");
    } else {
        $QueryDetailAward = mysqli_query($db, "SELECT 
            ma.IdAward,
            ma.JenisPenghargaan,
            ma.TahunPenghargaan,
            ma.StatusAktif,
            ma.Deskripsi,
            ma.TanggalInput,
            ma.MasaAktifMulai,
            ma.MasaAktifSelesai
            FROM master_award_desa ma
            WHERE ma.IdAward = '$IdTemp'");
    }
    
    if (!$QueryDetailAward) {
        echo "<script>
            console.log('SQL Error: " . mysqli_error($db) . "');
            alert('Terjadi kesalahan database! Kolom masa penjurian mungkin belum ditambahkan.');
            window.location.href = '?pg=AwardView';
        </script>";
        exit;
    }
    
    $DataDetailAward = mysqli_fetch_assoc($QueryDetailAward);
    
    $IdAward = $DataDetailAward['IdAward'];
    $JenisPenghargaan = $DataDetailAward['JenisPenghargaan'];
    $TahunPenghargaan = $DataDetailAward['TahunPenghargaan'];
    $StatusAktif = $DataDetailAward['StatusAktif'];
    $Deskripsi = $DataDetailAward['Deskripsi'];
    $TanggalInput = $DataDetailAward['TanggalInput'];
    $MasaAktifMulai = $DataDetailAward['MasaAktifMulai'];
    $MasaAktifSelesai = $DataDetailAward['MasaAktifSelesai'];
    
    // Handle masa penjurian columns jika ada
    if ($hasJuryColumns) {
        $MasaPenjurianMulai = $DataDetailAward['MasaPenjurianMulai'];
        $MasaPenjurianSelesai = $DataDetailAward['MasaPenjurianSelesai'];
    } else {
        $MasaPenjurianMulai = null;
        $MasaPenjurianSelesai = null;
    }
    
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