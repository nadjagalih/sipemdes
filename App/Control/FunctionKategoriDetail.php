<?php
if (isset($_GET['Kode']) && !empty($_GET['Kode'])) {
    $IdKategoriTemp = sql_url($_GET['Kode']);
    
    // Query untuk mendapatkan data kategori terlebih dahulu
    $sqlKategori = "SELECT 
        IdKategoriAward,
        IdAwardFK,
        NamaKategori,
        DeskripsiKategori,
        TanggalInput
        FROM master_kategori_award 
        WHERE IdKategoriAward = '$IdKategoriTemp'";
    
    $QueryDetailKategori = mysqli_query($db, $sqlKategori);
    
    if (!$QueryDetailKategori) {
        echo "<script>
            console.log('SQL Error: " . mysqli_error($db) . "');
            alert('Terjadi kesalahan database pada query kategori!');
            window.location.href = '?pg=AwardView';
        </script>";
        exit;
    }
    
    if (mysqli_num_rows($QueryDetailKategori) > 0) {
        $DataDetailKategori = mysqli_fetch_assoc($QueryDetailKategori);
        
        $IdKategoriAward = $DataDetailKategori['IdKategoriAward'];
        $IdAward = $DataDetailKategori['IdAwardFK'];
        $NamaKategori = $DataDetailKategori['NamaKategori'];
        $DeskripsiKategori = $DataDetailKategori['DeskripsiKategori'];
        $TanggalInput = $DataDetailKategori['TanggalInput'];
        
        // Cek apakah kolom masa penjurian sudah ada
        $checkColumns = mysqli_query($db, "SHOW COLUMNS FROM master_award_desa LIKE 'MasaPenjurianMulai'");
        $hasJuryColumns = mysqli_num_rows($checkColumns) > 0;
        
        // Query terpisah untuk data award
        if ($hasJuryColumns) {
            $sqlAward = "SELECT JenisPenghargaan, TahunPenghargaan, StatusAktif, MasaPenjurianMulai, MasaPenjurianSelesai
                         FROM master_award_desa 
                         WHERE IdAward = '$IdAward'";
        } else {
            $sqlAward = "SELECT JenisPenghargaan, TahunPenghargaan, StatusAktif
                         FROM master_award_desa 
                         WHERE IdAward = '$IdAward'";
        }
        $QueryAward = mysqli_query($db, $sqlAward);
        
        if ($QueryAward && mysqli_num_rows($QueryAward) > 0) {
            $DataAward = mysqli_fetch_assoc($QueryAward);
            $JenisPenghargaan = $DataAward['JenisPenghargaan'];
            $TahunPenghargaan = $DataAward['TahunPenghargaan'];
            $StatusAward = $DataAward['StatusAktif'];
            
            // Handle masa penjurian columns jika ada
            if ($hasJuryColumns) {
                $MasaPenjurianMulai = $DataAward['MasaPenjurianMulai'];
                $MasaPenjurianSelesai = $DataAward['MasaPenjurianSelesai'];
            } else {
                $MasaPenjurianMulai = null;
                $MasaPenjurianSelesai = null;
            }
        } else {
            $JenisPenghargaan = 'N/A';
            $TahunPenghargaan = 'N/A';
            $StatusAward = 'N/A';
            $MasaPenjurianMulai = null;
            $MasaPenjurianSelesai = null;
        }
        
        // Cek status masa penjurian
        $today = date('Y-m-d');
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
            // Jika masa penjurian belum diatur, izinkan update (backward compatibility)
            $isMasaPenjurian = true;
            $statusPenjurian = 'Masa Penjurian Belum Ditentukan (Update Diizinkan)';
        }
        
        // Query untuk mendapatkan daftar peserta dalam kategori ini dengan nama desa dari master_desa
        $QueryPeserta = mysqli_query($db, "SELECT 
            da.IdPesertaAward,
            COALESCE(md.NamaDesa, da.NamaPeserta, 'Desa Tidak Dikenal') as NamaPeserta,
            da.NamaKarya,
            da.LinkKarya,
            da.Posisi,
            da.TanggalInput as TanggalSubmit,
            da.IdDesaFK
            FROM desa_award da
            LEFT JOIN master_desa md ON da.IdDesaFK = md.IdDesa
            WHERE da.IdKategoriAwardFK = '$IdKategoriAward'
            ORDER BY 
                CASE 
                    WHEN da.Posisi IS NOT NULL AND da.Posisi != '' THEN da.Posisi 
                    ELSE 999 
                END ASC,
                da.TanggalInput ASC");
        
        // Hitung statistik peserta
        $totalPeserta = $QueryPeserta ? mysqli_num_rows($QueryPeserta) : 0;
        
        $QueryPesertaBerposisi = mysqli_query($db, "SELECT COUNT(*) as jumlah 
            FROM desa_award da
            WHERE da.IdKategoriAwardFK = '$IdKategoriAward' 
            AND da.Posisi IS NOT NULL AND da.Posisi != ''");
        $DataPesertaBerposisi = mysqli_fetch_assoc($QueryPesertaBerposisi);
        $pesertaBerposisi = $DataPesertaBerposisi ? $DataPesertaBerposisi['jumlah'] : 0;
        
    } else {
        // Redirect jika kategori tidak ditemukan
        echo "<script>
            alert('Kategori tidak ditemukan!');
            window.location.href = '?pg=AwardView';
        </script>";
        exit;
    }
} else {
    // Redirect jika tidak ada kode kategori
    echo "<script>
        alert('Akses tidak valid!');
        window.location.href = '?pg=AwardView';
    </script>";
    exit;
}
?>
