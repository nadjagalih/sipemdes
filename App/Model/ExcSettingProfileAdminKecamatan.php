<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include "../../Module/Config/Env.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
    exit;
} else {
    
    // Debug untuk melihat apakah file ini diakses
    error_log(date('Y-m-d H:i:s') . " - ExcSettingProfile accessed");
    error_log("GET: " . print_r($_GET, true));
    error_log("POST: " . print_r($_POST, true));
    
    if (isset($_GET['Act']) && $_GET['Act'] == 'Save') {
        if (isset($_POST['Save'])) {

            // Ambil data dari POST dengan sanitasi
            $NoTelepon = sql_injeksi($_POST['NoTelepon']);
            $AlamatKecamatan = sql_injeksi($_POST['AlamatKantor']); // Sesuaikan dengan name di form
            $Latitude = sql_injeksi($_POST['Latitude']);
            $Longitude = sql_injeksi($_POST['Longitude']);
            $IdKecamatan = $_SESSION['IdKecamatan'];

            // Debug log data
            error_log("Data: NoTelepon=$NoTelepon, AlamatKecamatan=$AlamatKecamatan, Lat=$Latitude, Lng=$Longitude, IdKecamatan=$IdKecamatan");

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
                error_log("Profile kecamatan updated successfully for IdKecamatan: $IdKecamatan");
                header("location:../../View/v?pg=SettingProfileKecamatan&alert=Edit");
            } else {
                error_log("Failed to update profile kecamatan. MySQL Error: " . mysqli_error($db));
                header("location:../../View/v?pg=SettingProfileKecamatan&alert=Gagal");
            }
        }
    }
}
?>