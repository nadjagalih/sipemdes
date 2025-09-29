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
    
    if ($_GET['Act'] == 'Save') {
        if (isset($_POST['Save'])) {

            // Ambil data dari POST
            $NoTelepon = sql_injeksi($_POST['NoTelepon']);
            $AlamatDesa = sql_injeksi($_POST['AlamatDesa']);
            $Latitude = sql_injeksi($_POST['Latitude']);
            $Longitude = sql_injeksi($_POST['Longitude']);
            $IdDesa = $_SESSION['IdDesa'];

            // Debug log data
            file_put_contents('debug_log.txt', "Data: NoTelepon=$NoTelepon, AlamatDesa=$AlamatDesa, Lat=$Latitude, Lng=$Longitude, IdDesa=$IdDesa\n", FILE_APPEND);

            // Validasi input
            if (empty($NoTelepon)) {
                header("location:../../View/v?pg=SettingProfileDesa&alert=ErrorTelepon");
                exit;
            }

            if (empty($Latitude) || empty($Longitude)) {
                header("location:../../View/v?pg=SettingProfileDesa&alert=ErrorKoordinat");
                exit;
            }

            // Update data langsung ke tabel master_desa
            $Update = mysqli_query($db, "UPDATE master_desa SET 
                NoTelepon = '$NoTelepon',
                alamatDesa = '$AlamatDesa',
                Latitude = '$Latitude',
                Longitude = '$Longitude'
                WHERE IdDesa = '$IdDesa'");

            if ($Update) {
                header("location:../../View/v?pg=SettingProfileDesa&alert=Edit");
            } else {
                header("location:../../View/v?pg=SettingProfileDesa&alert=Gagal");
            }
        }
    }
}
?>