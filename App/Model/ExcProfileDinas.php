<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include "../../Module/Config/Env.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
} else {
    if ($_GET['Act'] == 'Edit') {
        if (isset($_POST['Edit'])) {

            $IdKabupatenEdit = sql_injeksi($_POST['IdKabupaten']);

            $Kabupaten = sql_injeksi($_POST['Kabupaten']);
            $Dinas = sql_injeksi($_POST['Dinas']);
            $Alamat = sql_injeksi($_POST['Alamat']);

            $Edit = mysqli_query($db, "UPDATE master_setting_profile_dinas SET Kabupaten = '$Kabupaten',
            PerangkatDaerah = '$Dinas',
            Alamat = '$Alamat'
            WHERE IdKabupatenProfile = '$IdKabupatenEdit' ");
            if ($Edit) {
                header("location:../../View/v?pg=ProfileDinasView&alert=Edit");
            }
        }
    }
}
