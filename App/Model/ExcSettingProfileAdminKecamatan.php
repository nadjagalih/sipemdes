<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include "../../Module/Config/Env.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
} else {
    
    // Debug untuk melihat apakah file ini diakses
    // Uncomment baris berikut untuk debugging
    file_put_contents('debug_log.txt', date('Y-m-d H:i:s') . " - ExcSettingProfile accessed\n", FILE_APPEND);
    file_put_contents('debug_log.txt', "GET: " . print_r($_GET, true) . "\n", FILE_APPEND);
    file_put_contents('debug_log.txt', "POST: " . print_r($_POST, true) . "\n", FILE_APPEND);
    
    if (isset($_GET['Act']) && $_GET['Act'] == 'Save') {
        if (isset($_POST['Save'])) {

            // Ambil data dari POST
            $NoTelepon = sql_injeksi($_POST['NoTelepon']);
            $AlamatKecamatan = sql_injeksi($_POST['AlamatKantor']); // Sesuaikan dengan name di form
            $Latitude = sql_injeksi($_POST['Latitude']);
            $Longitude = sql_injeksi($_POST['Longitude']);
            $IdKecamatan = $_SESSION['IdKecamatan'];

            // Debug log data
            file_put_contents('debug_log.txt', "Data: NoTelepon=$NoTelepon, AlamatKecamatan=$AlamatKecamatan, Lat=$Latitude, Lng=$Longitude, IdKecamatan=$IdKecamatan\n", FILE_APPEND);

            // Validasi input
            if (empty($NoTelepon)) {
                header("location:../../View/v?pg=SettingProfileKecamatan&alert=ErrorTelepon");
                exit;
            }

            if (empty($Latitude) || empty($Longitude)) {
                header("location:../../View/v?pg=SettingProfileKecamatan&alert=ErrorKoordinat");
                exit;
            }

            // Update data langsung ke tabel master_kecamatan dengan nama kolom yang benar
            $Update = mysqli_query($db, "UPDATE master_kecamatan SET 
                NoTelepon = '$NoTelepon',
                AlamatKecamatan = '$AlamatKecamatan',
                Latitude = '$Latitude',
                Longitude = '$Longitude'
                WHERE IdKecamatan = '$IdKecamatan'");

            if ($Update) {
                header("location:../../View/v?pg=SettingProfileKecamatan&alert=Edit");
            } else {
                header("location:../../View/v?pg=SettingProfileKecamatan&alert=Gagal");
            }
        }
    }
}
?>