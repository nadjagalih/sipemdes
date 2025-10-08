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
            $QKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan");
            $Count = mysqli_num_rows($QKecamatan);
            if ($Count <> 0) {
                $TempId = $Count + 1;
                $IdKecamatan = $ViewTanggal . "" . $TempId;
            } else {
                $TempId = 1;
                $IdKecamatan = $ViewTanggal . "" . $TempId;
            }

            $KodeKecamatan = sql_injeksi($_POST['KodeKecamatan']);
            $Kecamatan = sql_injeksi($_POST['Kecamatan']);
            $IdKabupaten = sql_injeksi($_POST['IdKabupaten']);


            $Save = mysqli_query($db, "INSERT INTO master_kecamatan(IdKecamatan, KodeKecamatan, Kecamatan, IdKabupatenFK)
            VALUE('$IdKecamatan','$KodeKecamatan','$Kecamatan','$IdKabupaten')");

            if ($Save) {
                header("location:../../View/v?pg=KecamatanView&alert=Save");
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Edit') {
        if (isset($_POST['Edit'])) {

            $IdKecamatanEdit = sql_injeksi($_POST['IdKecamatan']);
            $KodeKecamatanEdit = sql_injeksi($_POST['KodeKecamatan']);
            $KecamatanEdit = sql_injeksi($_POST['Kecamatan']);
            $IdKabupatenEdit = sql_injeksi($_POST['IdKabupaten']);


            $Edit = mysqli_query($db, "UPDATE master_kecamatan SET KodeKecamatan = '$KodeKecamatanEdit',
            Kecamatan = '$KecamatanEdit',
            IdKabupatenFk = '$IdKabupatenEdit'
            WHERE IdKecamatan = '$IdKecamatanEdit' ");

            if ($Edit) {
                header("location:../../View/v?pg=KecamatanView&alert=Edit");
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdKecamatan = sql_injeksi(($_GET['Kode']));

            $Cek = mysqli_query($db, "SELECT * FROM master_desa WHERE IdKecamatanFK = '$IdKecamatan' ");
            $CountCek = mysqli_num_rows($Cek);
            if ($CountCek <> 0) {
                header("location:../../View/v?pg=KecamatanView&alert=Cek");
            } else {
                $Delete = mysqli_query($db, "DELETE FROM master_kecamatan WHERE IdKecamatan = '$IdKecamatan' ");
                if ($Delete) {
                    header("location:../../View/v?pg=KecamatanView&alert=Delete");
                }
            }
        }
    }
}
