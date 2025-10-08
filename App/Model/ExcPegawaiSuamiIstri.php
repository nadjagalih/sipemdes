<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include "../../Module/Config/Env.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
} else {
    if (isset($_GET['Act']) && $_GET['Act'] == 'Save') {
        if (isset($_POST['Save'])) {

            $ViewTanggal   = date('YmdHis');
            $QSuamiIstri = mysqli_query($db, "SELECT * FROM hiskel_suami_istri");
            $Count = mysqli_num_rows($QSuamiIstri);
            if ($Count <> 0) {
                $TempId = $Count + 1;
                $IdSuamiIstri = $ViewTanggal . "" . $TempId;
            } else {
                $TempId = 1;
                $IdSuamiIstri = $ViewTanggal . "" . $TempId;
            }

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
                header("location:../../View/v?pg=PegawaiViewSuamiIstri&alert=Save");
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Edit') {
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
                header("location:../../View/v?pg=PegawaiViewSuamiIstri&alert=Edit");
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdTemp = sql_injeksi(($_GET['Kode']));

            $Delete = mysqli_query($db, "DELETE FROM hiskel_suami_istri WHERE IdSuamiIstri = '$IdTemp' ");

            if ($Delete) {
                header("location:../../View/v?pg=PegawaiViewSuamiIstri&alert=Delete");
            }
        }
    }
}
