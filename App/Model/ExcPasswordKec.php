<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include "../../Module/Config/Env.php";
include "../../Module/Variabel/FileUpload.php";
// Tidak include Security.php untuk menghindari redeclare error

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../AuthKecamatan/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
    exit();
} else {

    if (isset($_GET['Act']) && $_GET['Act'] == 'Pass') {
        if (isset($_POST['Save'])) {
            // Simple CSRF validation tanpa class
            if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || 
                $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                header("location:../../View/v?pg=PassKecamatan&alert=CSRFError");
                exit();
            }
            
            if (isset($_POST['IdUser'])) {
                $PasswordBaru = isset($_POST['PasswordBaru']) ? sql_injeksi($_POST['PasswordBaru']) : '';

                if (strlen($PasswordBaru) >= 5) {
                    $IdUser = sql_injeksi($_POST['IdUser']);
                    $PasswordBaruHashed = password_hash($PasswordBaru, PASSWORD_DEFAULT);

                    $Koreksi = mysqli_query($db, "UPDATE main_user_kecamatan SET NamePassword = '$PasswordBaruHashed'
                           WHERE IdUser = '$IdUser'");
                    
                    if ($Koreksi) {
                        // Regenerate CSRF token untuk keamanan
                        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                        header("location:../../View/v?pg=PassKecamatan&alert=Sukses");
                    } else {
                        header("location:../../View/v?pg=PassKecamatan&alert=Gagal memperbarui password");
                    }
                } else {
                    header("location:../../View/v?pg=PassKecamatan&alert=Panjang");
                }
            } else {
                header("location:../../View/v?pg=PassKecamatan&alert=Data tidak lengkap");
            }
        } else {
            header("location:../../View/v?pg=PassKecamatan&alert=Akses tidak valid");
        }
    } else {
        header("location:../../View/v?pg=PassKecamatan&alert=Action tidak valid");
    }
}
?>
