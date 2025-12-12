<?php
session_start();
include '../../../../Module/Config/Env.php'; // or adjust path to your DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['IdPegawaiFK'])) {
    $IdPegawai = mysqli_real_escape_string($db, $_POST['IdPegawaiFK']);

    // Deteksi halaman asal untuk redirect yang tepat
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    $redirectPage = 'ViewMasaPensiun'; // default
    
    if (strpos($referer, 'ViewMasaPensiunKades') !== false) {
        $redirectPage = 'ViewMasaPensiunKades';
    }

    if (isset($_POST['setujui'])) {
        $status = 1;
    } elseif (isset($_POST['tolak'])) {
        $status = 0;
    }

    // Jika ditolak, hapus file pengajuan dari database
    if ($status == 0) {
        // Ambil IdFilePengajuanPensiunFK terlebih dahulu
        $queryGetFile = mysqli_query($db, "SELECT IdFilePengajuanPensiunFK FROM master_pegawai WHERE IdPegawaiFK = '$IdPegawai'");
        $dataFile = mysqli_fetch_assoc($queryGetFile);
        $idFile = $dataFile['IdFilePengajuanPensiunFK'];
        
        // Hapus file dari tabel file jika ada
        if (!is_null($idFile) && $idFile != '') {
            mysqli_query($db, "DELETE FROM file WHERE IdFile = '$idFile'");
        }
        
        // Update status dan set IdFilePengajuanPensiunFK menjadi NULL
        $update = mysqli_query($db, "UPDATE master_pegawai SET StatusPensiunKecamatan = $status, IdFilePengajuanPensiunFK = NULL WHERE IdPegawaiFK = '$IdPegawai'");
    } else {
        // Jika disetujui, hanya update status
        $update = mysqli_query($db, "UPDATE master_pegawai SET StatusPensiunKecamatan = $status WHERE IdPegawaiFK = '$IdPegawai'");
    }

    if ($update) {
        if($status === 1) {
            // Cek apakah pegawai ini adalah Kades berdasarkan history_mutasi yang aktif
            $queryJabatan = mysqli_query($db, "SELECT IdJabatanFK FROM history_mutasi 
                                               WHERE IdPegawaiFK = '$IdPegawai' AND Setting = 1 
                                               ORDER BY TanggalMutasi DESC LIMIT 1");
            
            if ($queryJabatan && mysqli_num_rows($queryJabatan) > 0) {
                $dataJabatan = mysqli_fetch_assoc($queryJabatan);
                $jabatan = $dataJabatan['IdJabatanFK'];
                
                if($jabatan == 1) {
                    // Jika Kades (IdJabatanFK = 1), redirect ke halaman Kades
                    header("Location: ../../../v?pg=ViewMasaPensiunKadesKec&alert=Sukses");
                } else {
                    // Jika bukan Kades, redirect ke halaman biasa
                    header("Location: ../../../v?pg=ViewMasaPensiunKec&alert=Sukses");
                }
            } else {
                // Jika tidak ada history mutasi, redirect ke halaman biasa
                header("Location: ../../../v?pg=ViewMasaPensiunKec&alert=Sukses");
            }
        } else {
            header("Location: ../../../v?pg=ViewMasaPensiunKec&alert=Ditolak");
        }
        exit();
    } else {
        header("Location: ../../../v?pg=ViewMasaPensiunKec&alert=Gagal");
        exit();
    }
} else {
    echo "Akses tidak valid.";
}
?>