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

$Act = $_GET['Act'];

// Fungsi untuk generate ID
function generateKategoriAwardId($db) {
    $query = mysqli_query($db, "SELECT MAX(CAST(SUBSTRING(IdKategoriAward, 3) AS UNSIGNED)) as max_id FROM master_kategori_award");
    $data = mysqli_fetch_assoc($query);
    $nextId = $data['max_id'] ? $data['max_id'] + 1 : 1;
    return 'KA' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
}

switch ($Act) {
    case 'Add':
        if (isset($_POST['IdAward']) && isset($_POST['NamaKategori'])) {
            $IdKategoriAward = generateKategoriAwardId($db);
            $IdAwardFK = sql_injeksi($_POST['IdAward']);
            $NamaKategori = sql_injeksi($_POST['NamaKategori']);
            $DeskripsiKategori = sql_injeksi($_POST['DeskripsiKategori']);
            
            $query = "INSERT INTO master_kategori_award 
                     (IdKategoriAward, IdAwardFK, NamaKategori, DeskripsiKategori, TanggalInput) 
                     VALUES 
                     ('$IdKategoriAward', '$IdAwardFK', '$NamaKategori', '$DeskripsiKategori', NOW())";
            
            if (mysqli_query($db, $query)) {
                header("location:../../View/v?pg=AwardDetail&Kode=$IdAwardFK&alert=SaveKategori");
            } else {
                header("location:../../View/v?pg=AwardDetail&Kode=$IdAwardFK&alert=ErrorKategori");
            }
        }
        break;
        
    case 'Edit':
        if (isset($_POST['IdKategoriAward']) && isset($_POST['NamaKategori'])) {
            $IdKategoriAward = sql_injeksi($_POST['IdKategoriAward']);
            $NamaKategori = sql_injeksi($_POST['NamaKategori']);
            $DeskripsiKategori = sql_injeksi($_POST['DeskripsiKategori']);
            
            // Get IdAwardFK for redirect
            $getAwardId = mysqli_query($db, "SELECT IdAwardFK FROM master_kategori_award WHERE IdKategoriAward = '$IdKategoriAward'");
            $awardData = mysqli_fetch_assoc($getAwardId);
            $IdAwardFK = $awardData['IdAwardFK'];
            
            $query = "UPDATE master_kategori_award SET 
                     NamaKategori = '$NamaKategori',
                     DeskripsiKategori = '$DeskripsiKategori'
                     WHERE IdKategoriAward = '$IdKategoriAward'";
            
            if (mysqli_query($db, $query)) {
                // Check if coming from kategori detail page
                $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
                if (strpos($referer, 'KategoriDetail') !== false) {
                    header("location:../../View/v?pg=KategoriDetail&Kode=$IdKategoriAward&alert=EditKategori");
                } else {
                    header("location:../../View/v?pg=AwardDetail&Kode=$IdAwardFK&alert=EditKategori");
                }
            } else {
                // Check if coming from kategori detail page for error redirect too
                $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
                if (strpos($referer, 'KategoriDetail') !== false) {
                    header("location:../../View/v?pg=KategoriDetail&Kode=$IdKategoriAward&alert=ErrorKategori");
                } else {
                    header("location:../../View/v?pg=AwardDetail&Kode=$IdAwardFK&alert=ErrorKategori");
                }
            }
        }
        break;
        
    case 'Delete':
        if (isset($_GET['Kode'])) {
            $IdKategoriAward = sql_url($_GET['Kode']);
            
            // Get IdAwardFK for redirect
            $getAwardId = mysqli_query($db, "SELECT IdAwardFK FROM master_kategori_award WHERE IdKategoriAward = '$IdKategoriAward'");
            $awardData = mysqli_fetch_assoc($getAwardId);
            $IdAwardFK = $awardData['IdAwardFK'];
            
            // Delete related peserta first
            mysqli_query($db, "DELETE FROM desa_award WHERE IdKategoriAwardFK = '$IdKategoriAward'");
            // Delete kategori
            $query = "DELETE FROM master_kategori_award WHERE IdKategoriAward = '$IdKategoriAward'";
            
            if (mysqli_query($db, $query)) {
                header("location:../../View/v?pg=AwardDetail&Kode=$IdAwardFK&alert=DeleteKategori");
            } else {
                header("location:../../View/v?pg=AwardDetail&Kode=$IdAwardFK&alert=ErrorKategori");
            }
        }
        break;
        
    case 'GetKategoriData':
        if (isset($_GET['Kode'])) {
            $IdKategoriAward = sql_url($_GET['Kode']);
            $query = mysqli_query($db, "SELECT * FROM master_kategori_award WHERE IdKategoriAward = '$IdKategoriAward'");
            
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