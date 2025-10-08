<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include "../../Module/Config/Env.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
} else {

if (!isset($_GET['Act'])) {
    exit("Access Denied");
}

$$Act = isset($_GET['Act']) ? sql_injeksi($_GET['Act']) : '';

// Fungsi untuk generate ID
function generatePesertaAwardId($db) {
    $query = mysqli_query($db, "SELECT MAX(CAST(SUBSTRING(IdPesertaAward, 3) AS UNSIGNED)) as max_id FROM desa_award");
    $data = mysqli_fetch_assoc($query);
    $nextId = $data['max_id'] ? $data['max_id'] + 1 : 1;
    return 'PA' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
}

switch ($Act) {
    case 'UpdatePosisi':
        // Fungsi untuk update posisi/juara peserta (hanya admin yang bisa)
        if (isset($_POST['IdPesertaAward']) && isset($_POST['Posisi'])) {
            $IdPesertaAward = sql_injeksi($_POST['IdPesertaAward']);
            $Posisi = isset($_POST['Posisi']) && !empty($_POST['Posisi']) ? sql_injeksi($_POST['Posisi']) : 'NULL';
            
            // Cek apakah kolom masa penjurian sudah ada
            $checkColumns = mysqli_query($db, "SHOW COLUMNS FROM master_award_desa LIKE 'MasaPenjurianMulai'");
            $hasJuryColumns = mysqli_num_rows($checkColumns) > 0;
            
            // Get Award ID and Kategori ID for redirect dan cek masa penjurian
            if ($hasJuryColumns) {
                $getIds = mysqli_query($db, "SELECT mka.IdAwardFK, da.IdKategoriAwardFK, mad.MasaPenjurianMulai, mad.MasaPenjurianSelesai
                                            FROM desa_award da 
                                            JOIN master_kategori_award mka ON da.IdKategoriAwardFK = mka.IdKategoriAward
                                            JOIN master_award_desa mad ON mka.IdAwardFK = mad.IdAward
                                            WHERE da.IdPesertaAward = '$IdPesertaAward'");
            } else {
                $getIds = mysqli_query($db, "SELECT mka.IdAwardFK, da.IdKategoriAwardFK
                                            FROM desa_award da 
                                            JOIN master_kategori_award mka ON da.IdKategoriAwardFK = mka.IdKategoriAward
                                            WHERE da.IdPesertaAward = '$IdPesertaAward'");
            }
            $idsData = mysqli_fetch_assoc($getIds);
            $IdAwardFK = $idsData['IdAwardFK'];
            $IdKategoriAwardFK = $idsData['IdKategoriAwardFK'];
            
            // Handle masa penjurian columns jika ada
            if ($hasJuryColumns) {
                $MasaPenjurianMulai = $idsData['MasaPenjurianMulai'];
                $MasaPenjurianSelesai = $idsData['MasaPenjurianSelesai'];
            } else {
                $MasaPenjurianMulai = null;
                $MasaPenjurianSelesai = null;
            }
            
            // Cek apakah sedang dalam masa penjurian
            $today = date('Y-m-d');
            $isMasaPenjurian = false;
            
            if (!empty($MasaPenjurianMulai) && !empty($MasaPenjurianSelesai)) {
                if ($today >= $MasaPenjurianMulai && $today <= $MasaPenjurianSelesai) {
                    $isMasaPenjurian = true;
                }
            } else {
                // Jika masa penjurian belum diatur, izinkan update (backward compatibility)
                $isMasaPenjurian = true;
            }
            
            if (!$isMasaPenjurian) {
                // Tidak dalam masa penjurian, redirect dengan error
                $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
                if (strpos($referer, 'KategoriDetail') !== false) {
                    header("location:../../View/v?pg=KategoriDetail&Kode=$IdKategoriAwardFK&alert=ErrorMasaPenjurian");
                } else {
                    header("location:../../View/v?pg=AwardDetail&Kode=$IdAwardFK&alert=ErrorMasaPenjurian");
                }
                exit;
            }
            
            $query = "UPDATE desa_award SET Posisi = $Posisi WHERE IdPesertaAward = '$IdPesertaAward'";
            
            if (mysqli_query($db, $query)) {
                // Check if coming from kategori detail page
                $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
                if (strpos($referer, 'KategoriDetail') !== false) {
                    header("location:../../View/v?pg=KategoriDetail&Kode=$IdKategoriAwardFK&alert=UpdatePosisi");
                } else {
                    header("location:../../View/v?pg=AwardDetail&Kode=$IdAwardFK&alert=UpdatePosisi");
                }
            } else {
                // Check if coming from kategori detail page for error redirect too
                $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
                if (strpos($referer, 'KategoriDetail') !== false) {
                    header("location:../../View/v?pg=KategoriDetail&Kode=$IdKategoriAwardFK&alert=ErrorPeserta");
                } else {
                    header("location:../../View/v?pg=AwardDetail&Kode=$IdAwardFK&alert=ErrorPeserta");
                }
            }
        }
        break;
        
    case 'Delete':
        if (isset($_GET['Kode'])) {
            $IdPesertaAward = sql_url($_GET['Kode']);
            
            // Get Award ID for redirect
            $getAwardId = mysqli_query($db, "SELECT mka.IdAwardFK
                                           FROM desa_award da 
                                           JOIN master_kategori_award mka ON da.IdKategoriAwardFK = mka.IdKategoriAward
                                           WHERE da.IdPesertaAward = '$IdPesertaAward'");
            $awardData = mysqli_fetch_assoc($getAwardId);
            $IdAwardFK = $awardData['IdAwardFK'];
            
            // Delete peserta record
            $query = "DELETE FROM desa_award WHERE IdPesertaAward = '$IdPesertaAward'";
            
            if (mysqli_query($db, $query)) {
                header("location:../../View/v?pg=AwardDetail&Kode=$IdAwardFK&alert=DeletePeserta");
            } else {
                header("location:../../View/v?pg=AwardDetail&Kode=$IdAwardFK&alert=ErrorPeserta");
            }
        }
        break;
        
    case 'GetPesertaData':
        if (isset($_GET['Kode'])) {
            $IdPesertaAward = sql_url($_GET['Kode']);
            $query = mysqli_query($db, "SELECT da.*, md.NamaDesa 
                                       FROM desa_award da
                                       LEFT JOIN master_desa md ON da.IdDesaFK = md.IdDesa
                                       WHERE da.IdPesertaAward = '$IdPesertaAward'");
            
            if ($data = mysqli_fetch_assoc($query)) {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                echo json_encode(['error' => 'Data tidak ditemukan']);
            }
        }
        break;
        
    default:
        header("location:../../View/v?pg=AwardView&alert=ErrorAct");
        break;
}

}
?>