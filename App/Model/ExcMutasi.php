<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include "../../Module/Config/Env.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
} else {
    if ($_GET['Act'] == 'Save') {
        if (isset($_POST['Save'])) {

            $ViewTanggal   = date('YmdHis');
            $QMutasi = mysqli_query($db, "SELECT * FROM master_mutasi");
            $Count = mysqli_num_rows($QMutasi);
            if ($Count <> 0) {
                $TempId = $Count + 1;
                $IdMutasi = $ViewTanggal . "" . $TempId;
            } else {
                $TempId = 1;
                $IdMutasi = $ViewTanggal . "" . $TempId;
            }

            $Mutasi = sql_injeksi($_POST['Mutasi']);


            $Save = mysqli_query($db, "INSERT INTO master_Mutasi(IdMutasi, Mutasi)
            VALUE('$IdMutasi','$Mutasi')");

            if ($Save) {
                header("location:../../View/v?pg=MutasiView&alert=Save");
            }
        }
    } elseif ($_GET['Act'] == 'Edit') {
        if (isset($_POST['Edit'])) {
            $IdMutasi = sql_injeksi($_POST['IdMutasi']);
            $Mutasi = sql_injeksi($_POST['Mutasi']);


            $Edit = mysqli_query($db, "UPDATE master_Mutasi SET Mutasi = '$Mutasi'
            WHERE IdMutasi = '$IdMutasi' ");

            if ($Edit) {
                header("location:../../View/v?pg=MutasiView&alert=Edit");
            }
        }
    } elseif ($_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdMutasi = sql_injeksi(($_GET['Kode']));

            $Delete = mysqli_query($db, "DELETE FROM master_Mutasi WHERE IdMutasi = '$IdMutasi' ");

            if ($Delete) {
                header("location:../../View/v?pg=MutasiView&alert=Delete");
            }
        }
    }
}
