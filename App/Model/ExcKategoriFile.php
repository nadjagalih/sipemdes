<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../Module/Config/Env.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
} else {
    if ($_GET['Act'] == 'Save') {
        if (isset($_POST['Save'])) {
            $KategoriFile = sql_injeksi($_POST['KategoriFile']);

            $Save = mysqli_query($db, "INSERT INTO master_file_kategori(KategoriFile) VALUES('$KategoriFile')");

            if ($Save) {
                header("location:../../View/v?pg=FileKategoriView&alert=Save");
            }
        }
    } elseif ($_GET['Act'] == 'Edit') {
        if (isset($_POST['Edit'])) {
            $IdFileKategori = sql_injeksi($_POST['IdFileKategori']);
            $KategoriFile = sql_injeksi($_POST['KategoriFile']);


            $Edit = mysqli_query($db, "UPDATE master_file_kategori SET KategoriFile = '$KategoriFile'
            WHERE IdFileKategori = '$IdFileKategori' ");

            if ($Edit) {
                header("location:../../View/v?pg=FileKategoriView&alert=Edit");
            }
        }
    } elseif ($_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdFileKategori = sql_injeksi(($_GET['Kode']));

            $Cek = mysqli_query($db, "SELECT * FROM file WHERE IdFileKategoriFK = '$IdFileKategori' ");
            $CountCek = mysqli_num_rows($Cek);
            if ($CountCek <> 0) {
                header("location:../../View/v?pg=FileKategoriView&alert=Cek");
            } else {
                $Delete = mysqli_query($db, "DELETE FROM master_file_kategori WHERE IdFileKategori = '$IdFileKategori' ");

                if ($Delete) {
                    header("location:../../View/v?pg=FileKategoriView&alert=Delete");
                }
            }
        }
    }
}
