<?php
session_start();
include '../../../../Module/Config/Env.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['IdPegawaiFK'])) {
    $IdPegawai = mysqli_real_escape_string($db, $_POST['IdPegawaiFK']);
    
    // Tentukan status berdasarkan tombol yang ditekan
    if (isset($_POST['setujui'])) {
        $status = 1;
        $action_type = 'setujui';
    } elseif (isset($_POST['tolak'])) {
        $status = 0;
        $action_type = 'tolak';
    } else {
        // Redirect jika tidak ada action yang valid
        header("Location: ../../../v?pg=ViewAllMasaPensiunAdminDesa&alert=Action tidak valid");
        exit();
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
        $update = mysqli_query($db, "UPDATE master_pegawai SET StatusPensiunDesa = $status, IdFilePengajuanPensiunFK = NULL WHERE IdPegawaiFK = '$IdPegawai'");
    } else {
        // Jika disetujui, hanya update status
        $update = mysqli_query($db, "UPDATE master_pegawai SET StatusPensiunDesa = $status WHERE IdPegawaiFK = '$IdPegawai'");
    }

    if ($update) {
        $action_message = ($action_type === 'setujui') ? 'disetujui' : 'ditolak';
        header("Location: ../../../v?pg=ViewAllMasaPensiunAdminDesa&alert=Pengajuan berhasil $action_message");
        exit();
    } else {
        $error_message = mysqli_error($db);
        header("Location: ../../../v?pg=ViewAllMasaPensiunAdminDesa&alert=Gagal memperbarui status: $error_message");
        exit();
    }
} else {
    // Redirect jika akses tidak valid
    header("Location: ../../../v?pg=ViewAllMasaPensiunAdminDesa&alert=Akses tidak valid");
    exit();
}
?>