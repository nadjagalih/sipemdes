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
            $QDesa = mysqli_query($db, "SELECT * FROM master_desa");
            $Count = mysqli_num_rows($QDesa);
            if ($Count <> 0) {
                $TempId = $Count + 1;
                $IdDesa = $ViewTanggal . "" . $TempId;
            } else {
                $TempId = 1;
                $IdDesa = $ViewTanggal . "" . $TempId;
            }

            $KodeDesa = sql_injeksi($_POST['KodeDesa']);
            $Desa = sql_injeksi($_POST['Desa']);
            $IdKecamatan = sql_injeksi($_POST['IdKecamatan']);
            $IdKabupaten = sql_injeksi($_POST['IdKabupaten']);


            $Save = mysqli_query($db, "INSERT INTO master_desa(IdDesa, KodeDesa, NamaDesa, IdKecamatanFK, IdKabupatenFK)
            VALUE('$IdDesa','$KodeDesa','$Desa','$IdKecamatan','$IdKabupaten')");

            if ($Save) {
                header("location:../../View/v?pg=DesaView&alert=Save");
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Edit') {
        if (isset($_POST['Edit'])) {
            $IdDesa = sql_injeksi($_POST['IdDesa']);
            $KodeDesa = sql_injeksi($_POST['KodeDesa']);
            $Desa = sql_injeksi($_POST['Desa']);
            $IdKecamatanEdit = sql_injeksi($_POST['IdKecamatan']);
            $IdKabupatenEdit = sql_injeksi($_POST['IdKabupaten']);


            $Edit = mysqli_query($db, "UPDATE master_desa SET KodeDesa = '$KodeDesa',
            NamaDesa = '$Desa',
            IdKecamatanFK = '$IdKecamatanEdit',
            IdKabupatenFk = '$IdKabupatenEdit'
            WHERE IdDesa = '$IdDesa' ");

            if ($Edit) {
                header("location:../../View/v?pg=DesaView&alert=Edit");
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdDesa = sql_injeksi(($_GET['Kode']));

            $Cek = mysqli_query($db, "SELECT * FROM master_pegawai WHERE IdDesaFK = '$IdDesa' ");
            $CountCek = mysqli_num_rows($Cek);
            if ($CountCek <> 0) {
                header("location:../../View/v?pg=DesaView&alert=Cek");
            } else {
                $Delete = mysqli_query($db, "DELETE FROM master_desa WHERE IdDesa = '$IdDesa' ");
                if ($Delete) {
                    header("location:../../View/v?pg=DesaView&alert=Delete");
                }
            }
        }
    }
}
