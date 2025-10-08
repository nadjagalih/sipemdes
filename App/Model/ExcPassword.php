<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include "../../Module/Config/Env.php";
include "../../Module/Variabel/FileUpload.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
} else {

    if (isset($_GET['Act']) && $_GET['Act'] == 'Pass') {
        if (isset($_POST['Save'])) {
            if (isset($_POST['IdUser'])) {
                $$PasswordBaru = isset($_POST['PasswordBaru']) ? sql_injeksi($_POST['PasswordBaru']) : '';

                if (strlen($PasswordBaru) >= 5) {
                    $IdUser = sql_injeksi($_POST['IdUser']);
                    $PasswordBaru = sql_injeksi(password_hash($_POST['PasswordBaru'], PASSWORD_DEFAULT));

                    $Koreksi = mysqli_query($db, "UPDATE main_user SET NamePassword = '$PasswordBaru'
                           WHERE IdUser = '$IdUser'");
                    header("location:../../View/v?pg=Pass&alert=Sukses");
                } elseif (strlen($PasswordBaru) <= 5) {
                    header("location:../../View/v?pg=Pass&alert=Panjang");
                }
            }
        }
    }
}
