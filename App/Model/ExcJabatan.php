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
            $QJabatan = mysqli_query($db, "SELECT * FROM master_jabatan");
            $Count = mysqli_num_rows($QJabatan);
            if ($Count <> 0) {
                $TempId = $Count + 1;
                $IdJabatan = $ViewTanggal . "" . $TempId;
            } else {
                $TempId = 1;
                $IdJabatan = $ViewTanggal . "" . $TempId;
            }

            $Jabatan = sql_injeksi($_POST['Jabatan']);


            $Save = mysqli_query($db, "INSERT INTO master_jabatan(IdJabatan, Jabatan)
            VALUE('$IdJabatan','$Jabatan')");

            if ($Save) {
                header("location:../../View/v?pg=JabatanView&alert=Save");
            }
        }
    } elseif ($_GET['Act'] == 'Edit') {
        if (isset($_POST['Edit'])) {
            $IdJabatan = sql_injeksi($_POST['IdJabatan']);
            $Jabatan = sql_injeksi($_POST['Jabatan']);


            $Edit = mysqli_query($db, "UPDATE master_jabatan SET Jabatan = '$Jabatan'
            WHERE IdJabatan = '$IdJabatan' ");

            if ($Edit) {
                header("location:../../View/v?pg=JabatanView&alert=Edit");
            }
        }
    } elseif ($_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdJabatan = sql_injeksi(($_GET['Kode']));

            $Cek = mysqli_query($db, "SELECT * FROM history_mutasi WHERE IdJabatanFK = '$IdJabatan' ");
            $CountCek = mysqli_num_rows($Cek);
            if ($CountCek <> 0) {
                header("location:../../View/v?pg=JabatanView&alert=Cek");
            } else {
                $Delete = mysqli_query($db, "DELETE FROM master_jabatan WHERE IdJabatan = '$IdJabatan' ");

                if ($Delete) {
                    header("location:../../View/v?pg=JabatanView&alert=Delete");
                }
            }
        }
    }
}
