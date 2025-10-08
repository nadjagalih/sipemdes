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
            $QAnak = mysqli_query($db, "SELECT * FROM hiskel_anak");
            // $Count = mysqli_num_rows($QAnak);
            // if ($Count <> 0) {
            //     $TempId = $Count + 1;
            //     $IdAnak = $ViewTanggal . "" . $TempId;
            // } else {
            //     $TempId = 1;
            //     $IdAnak = $ViewTanggal . "" . $TempId;
            // }

            $tanggal        = date('Ymd');
            $waktuid        = date('His');
            $Acak           = rand(1, 99);
            $IdAnak         = $tanggal . "" . $waktuid . "" . $Acak;

            $IdPegawaiFK = sql_injeksi($_POST['IdPegawaiFK']);
            $NIKAnak = sql_injeksi($_POST['NIKAnak']);
            $NamaAnak = sql_injeksi($_POST['NamaAnak']);
            $TempatLahir = sql_injeksi($_POST['TempatLahir']);

            $TanggalLahir = sql_injeksi($_POST['TanggalLahir']);
            $exp = explode('-', $TanggalLahir);
            $TglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            $JenKel = sql_injeksi($_POST['JenKel']);
            $StatusHubungan = sql_injeksi($_POST['StatusHubungan']);

            $Pendidikan = sql_injeksi($_POST['Pendidikan']);
            $Pekerjaan = sql_injeksi($_POST['Pekerjaan']);


            $Save = mysqli_query($db, "INSERT INTO hiskel_anak(IdAnak, NIK, Nama, Tempat, TanggalLahir, JenKel, IdPendidikanFK, Pekerjaan, StatusHubungan, IdPegawaiFK)
            VALUE('$IdAnak','$NIKAnak','$NamaAnak','$TempatLahir','$TglLahir','$JenKel','$Pendidikan','$Pekerjaan','$StatusHubungan','$IdPegawaiFK')");

            if ($Save) {
                // Redirect back to detail page with pegawai ID
                ob_end_clean(); // Clear output buffer
                header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawaiFK) . "&alert=Save&tab=tab-3");
                exit();
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Edit') {
        if (isset($_POST['Edit'])) {
            $IdAnak = sql_injeksi($_POST['IdAnak']);
            $NIKAnak = sql_injeksi($_POST['NIKAnak']);
            $NamaAnak = sql_injeksi($_POST['NamaAnak']);
            $TempatLahir = sql_injeksi($_POST['TempatLahir']);

            $TanggalLahir = sql_injeksi($_POST['TanggalLahir']);
            $exp = explode('-', $TanggalLahir);
            $TglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            $JenKel = sql_injeksi($_POST['JenKel']);
            $StatusHubungan = sql_injeksi($_POST['StatusHubungan']);

            $Pendidikan = sql_injeksi($_POST['Pendidikan']);
            $Pekerjaan = sql_injeksi($_POST['Pekerjaan']);


            $Edit = mysqli_query($db, "UPDATE hiskel_anak SET NIK = '$NIKAnak',
            Nama = '$NamaAnak',
            Tempat = '$TempatLahir',
            TanggalLahir = '$TglLahir',
            JenKel = '$JenKel',
            IdPendidikanFK = '$Pendidikan',
            Pekerjaan = '$Pekerjaan',
            StatusHubungan = '$StatusHubungan'
            WHERE IdAnak = '$IdAnak' ");

            if ($Edit) {
                // Get IdPegawaiFK from database before redirect
                $getAnak = mysqli_query($db, "SELECT IdPegawaiFK FROM hiskel_anak WHERE IdAnak = '$IdAnak'");
                $anakData = mysqli_fetch_assoc($getAnak);
                $IdPegawaiFK = $anakData['IdPegawaiFK'];
                
                // Redirect back to detail page with pegawai ID
                ob_end_clean(); // Clear output buffer
                header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawaiFK) . "&alert=Edit&tab=tab-3");
                exit();
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdTemp = sql_injeksi(($_GET['Kode']));

            // Get IdPegawaiFK before delete for redirect
            $getAnak = mysqli_query($db, "SELECT IdPegawaiFK FROM hiskel_anak WHERE IdAnak = '$IdTemp'");
            $anakData = mysqli_fetch_assoc($getAnak);
            $IdPegawaiFromDB = $anakData['IdPegawaiFK'];

            $Delete = mysqli_query($db, "DELETE FROM hiskel_anak WHERE IdAnak = '$IdTemp' ");

            if ($Delete) {
                // Check if IdPegawai parameter exists for redirect back to detail page
                if (isset($_GET['IdPegawai'])) {
                    $IdPegawai = sql_injeksi($_GET['IdPegawai']);
                    $tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab-3';
                    ob_end_clean(); // Clear output buffer
                    header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawai) . "&alert=Delete&tab=" . $tab);
                    exit();
                } else {
                    // Use IdPegawai from database
                    ob_end_clean(); // Clear output buffer
                    header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawaiFromDB) . "&alert=Delete&tab=tab-3");
                    exit();
                }
            }
        }
    }
}
