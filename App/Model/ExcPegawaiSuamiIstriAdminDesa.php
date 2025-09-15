<?php
ob_start(); // Start output buffering
session_start();
error_reporting(0); // Disable error reporting to prevent output before redirect

include "../../Module/Config/Env.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
} else {
    if ($_GET['Act'] == 'Save') {
        if (isset($_POST['Save'])) {

            $ViewTanggal   = date('YmdHis');
            $QSuamiIstri = mysqli_query($db, "SELECT * FROM hiskel_suami_istri");
            // $Count = mysqli_num_rows($QSuamiIstri);
            // if ($Count <> 0) {
            //     $TempId = $Count + 1;
            //     $IdSuamiIstri = $ViewTanggal . "" . $TempId;
            // } else {
            //     $TempId = 1;
            //     $IdSuamiIstri = $ViewTanggal . "" . $TempId;
            // }

            $tanggal        = date('Ymd');
            $waktuid        = date('His');
            $Acak           = rand(1, 99);
            $IdSuamiIstri = $tanggal . "" . $waktuid . "" . $Acak;

            $IdPegawaiFK = sql_injeksi($_POST['IdPegawaiFK']);
            $NIKSuamiIstri = sql_injeksi($_POST['NIKSuamiIstri']);
            $NamaSuamiIstri = sql_injeksi($_POST['NamaSuamiIstri']);
            $TempatLahir = sql_injeksi($_POST['TempatLahir']);

            $TanggalLahir = sql_injeksi($_POST['TanggalLahir']);
            $exp = explode('-', $TanggalLahir);
            $TglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            $StatusHubungan = sql_injeksi($_POST['StatusHubungan']);

            $TanggalNikah = sql_injeksi($_POST['TanggalNikah']);
            $exp = explode('-', $TanggalNikah);
            $TglNikah = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            $Pendidikan = sql_injeksi($_POST['Pendidikan']);
            $Pekerjaan = sql_injeksi($_POST['Pekerjaan']);


            $Save = mysqli_query($db, "INSERT INTO hiskel_suami_istri(IdSuamiIstri, NIK, Nama, Tempat, TanggalLahir, StatusHubungan, TanggalNikah, IdPendidikanFK, Pekerjaan, IdPegawaiFK)
            VALUE('$IdSuamiIstri','$NIKSuamiIstri','$NamaSuamiIstri','$TempatLahir','$TglLahir','$StatusHubungan','$TglNikah','$Pendidikan','$Pekerjaan','$IdPegawaiFK')");

            if ($Save) {
                // Redirect back to detail page with pegawai ID
                ob_end_clean(); // Clear output buffer
                header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawaiFK) . "&alert=Save&tab=tab-2");
                exit();
            }
        }
    } elseif ($_GET['Act'] == 'Edit') {
        if (isset($_POST['Edit'])) {
            $IdSuamiIstri = sql_injeksi($_POST['IdSuamiIstri']);
            $NIKSuamiIstri = sql_injeksi($_POST['NIKSuamiIstri']);
            $NamaSuamiIstri = sql_injeksi($_POST['NamaSuamiIstri']);
            $TempatLahir = sql_injeksi($_POST['TempatLahir']);

            $TanggalLahir = sql_injeksi($_POST['TanggalLahir']);
            $exp = explode('-', $TanggalLahir);
            $TglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            $StatusHubungan = sql_injeksi($_POST['StatusHubungan']);

            $TanggalNikah = sql_injeksi($_POST['TanggalNikah']);
            $exp = explode('-', $TanggalNikah);
            $TglNikah = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            $Pendidikan = sql_injeksi($_POST['Pendidikan']);
            $Pekerjaan = sql_injeksi($_POST['Pekerjaan']);


            $Edit = mysqli_query($db, "UPDATE hiskel_suami_istri SET NIK = '$NIKSuamiIstri',
            Nama = '$NamaSuamiIstri',
            Tempat = '$TempatLahir',
            TanggalLahir = '$TglLahir',
            StatusHubungan = '$StatusHubungan',
            TanggalNikah = '$TglNikah',
            IdPendidikanFK = '$Pendidikan',
            Pekerjaan = '$Pekerjaan'
            WHERE IdSuamiIstri = '$IdSuamiIstri' ");

            if ($Edit) {
                // Get IdPegawaiFK from database before redirect
                $getSuamiIstri = mysqli_query($db, "SELECT IdPegawaiFK FROM hiskel_suami_istri WHERE IdSuamiIstri = '$IdSuamiIstri'");
                $suamiIstriData = mysqli_fetch_assoc($getSuamiIstri);
                $IdPegawaiFK = $suamiIstriData['IdPegawaiFK'];
                
                // Redirect back to detail page with pegawai ID
                ob_end_clean(); // Clear output buffer
                header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawaiFK) . "&alert=Edit&tab=tab-2");
                exit();
            }
        }
    } elseif ($_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdTemp = sql_injeksi(($_GET['Kode']));

            // Get IdPegawaiFK before delete for redirect
            $getSuamiIstri = mysqli_query($db, "SELECT IdPegawaiFK FROM hiskel_suami_istri WHERE IdSuamiIstri = '$IdTemp'");
            $suamiIstriData = mysqli_fetch_assoc($getSuamiIstri);
            $IdPegawaiFromDB = $suamiIstriData['IdPegawaiFK'];

            $Delete = mysqli_query($db, "DELETE FROM hiskel_suami_istri WHERE IdSuamiIstri = '$IdTemp' ");

            if ($Delete) {
                // Check if IdPegawai parameter exists for redirect back to detail page
                if (isset($_GET['IdPegawai'])) {
                    $IdPegawai = sql_injeksi($_GET['IdPegawai']);
                    $tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab-2';
                    ob_end_clean(); // Clear output buffer
                    header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawai) . "&alert=Delete&tab=" . $tab);
                    exit();
                } else {
                    // Use IdPegawai from database
                    ob_end_clean(); // Clear output buffer
                    header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawaiFromDB) . "&alert=Delete&tab=tab-2");
                    exit();
                }
            }
        }
    }
}
