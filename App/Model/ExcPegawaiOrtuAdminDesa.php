<?php
ob_start(); // Start output buffering
session_start();
error_reporting(0); // Disable error reporting to prevent output before redirect

include "../../Module/Config/Env.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
} else {
    if (isset($_GET['Act']) && $_GET['Act'] == 'Save') {
        if (isset($_POST['Save'])) {

            $ViewTanggal   = date('YmdHis');
            $QOrtu = mysqli_query($db, "SELECT * FROM hiskel_ortu");
            // $Count = mysqli_num_rows($QOrtu);
            // if ($Count <> 0) {
            //     $TempId = $Count + 1;
            //     $IdOrtu = $ViewTanggal . "" . $TempId;
            // } else {
            //     $TempId = 1;
            //     $IdOrtu = $ViewTanggal . "" . $TempId;
            // }
            $tanggal        = date('Ymd');
            $waktuid        = date('His');
            $Acak           = rand(1, 99);
            $IdOrtu         = $tanggal . "" . $waktuid . "" . $Acak;

            $IdPegawaiFK = sql_injeksi($_POST['IdPegawaiFK']);
            $NIKOrtu = sql_injeksi($_POST['NIKOrtu']);
            $NamaOrtu = sql_injeksi($_POST['NamaOrtu']);
            $TempatLahir = sql_injeksi($_POST['TempatLahir']);

            $TanggalLahir = sql_injeksi($_POST['TanggalLahir']);
            $exp = explode('-', $TanggalLahir);
            $TglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            $JenKel = sql_injeksi($_POST['JenKel']);
            $StatusHubungan = sql_injeksi($_POST['StatusHubungan']);

            $Pendidikan = sql_injeksi($_POST['Pendidikan']);
            $Pekerjaan = sql_injeksi($_POST['Pekerjaan']);


            $Save = mysqli_query($db, "INSERT INTO hiskel_ortu(IdOrtu, NIK, Nama, Tempat, TanggalLahir, JenKel, IdPendidikanFK, Pekerjaan, StatusHubungan, IdPegawaiFK)
            VALUE('$IdOrtu','$NIKOrtu','$NamaOrtu','$TempatLahir','$TglLahir','$JenKel','$Pendidikan','$Pekerjaan','$StatusHubungan','$IdPegawaiFK')");

            if ($Save) {
                // Redirect back to detail page with pegawai ID and tab parameter
                ob_end_clean(); // Clear output buffer
                header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawaiFK) . "&alert=SaveOrtu&tab=tab-4");
                exit();
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Edit') {
        if (isset($_POST['Edit'])) {
            $IdOrtu = sql_injeksi($_POST['IdOrtu']);
            $NIKOrtu = sql_injeksi($_POST['NIKOrtu']);
            $NamaOrtu = sql_injeksi($_POST['NamaOrtu']);
            $TempatLahir = sql_injeksi($_POST['TempatLahir']);

            $TanggalLahir = sql_injeksi($_POST['TanggalLahir']);
            $exp = explode('-', $TanggalLahir);
            $TglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            $JenKel = sql_injeksi($_POST['JenKel']);
            $StatusHubungan = sql_injeksi($_POST['StatusHubungan']);

            $Pendidikan = sql_injeksi($_POST['Pendidikan']);
            $Pekerjaan = sql_injeksi($_POST['Pekerjaan']);


            $Edit = mysqli_query($db, "UPDATE hiskel_ortu SET NIK = '$NIKOrtu',
            Nama = '$NamaOrtu',
            Tempat = '$TempatLahir',
            TanggalLahir = '$TglLahir',
            JenKel = '$JenKel',
            IdPendidikanFK = '$Pendidikan',
            Pekerjaan = '$Pekerjaan',
            StatusHubungan = '$StatusHubungan'
            WHERE IdOrtu = '$IdOrtu' ");

            if ($Edit) {
                // Get IdPegawaiFK from database before redirect
                $getOrtu = mysqli_query($db, "SELECT IdPegawaiFK FROM hiskel_ortu WHERE IdOrtu = '$IdOrtu'");
                $ortuData = mysqli_fetch_assoc($getOrtu);
                $IdPegawaiFK = $ortuData['IdPegawaiFK'];
                
                // Redirect back to detail page with pegawai ID and tab parameter
                ob_end_clean(); // Clear output buffer
                header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawaiFK) . "&alert=EditOrtu&tab=tab-4");
                exit();
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdTemp = sql_injeksi(($_GET['Kode']));

            // Get IdPegawaiFK before delete for redirect
            $getOrtu = mysqli_query($db, "SELECT IdPegawaiFK FROM hiskel_ortu WHERE IdOrtu = '$IdTemp'");
            $ortuData = mysqli_fetch_assoc($getOrtu);
            $IdPegawaiFromDB = $ortuData['IdPegawaiFK'];

            $Delete = mysqli_query($db, "DELETE FROM hiskel_ortu WHERE IdOrtu = '$IdTemp' ");

            if ($Delete) {
                // Get tab parameter
                $tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab-4';
                
                // Check if IdPegawai parameter exists for redirect back to detail page
                if (isset($_GET['IdPegawai'])) {
                    $IdPegawai = sql_injeksi($_GET['IdPegawai']);
                    ob_end_clean(); // Clear output buffer
                    header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawai) . "&alert=DeleteOrtu&tab=" . $tab);
                    exit();
                } else {
                    // Use IdPegawai from database
                    ob_end_clean(); // Clear output buffer
                    header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawaiFromDB) . "&alert=DeleteOrtu&tab=" . $tab);
                    exit();
                }
            }
        }
    }
}
