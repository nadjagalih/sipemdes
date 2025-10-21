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
            // CSRF Protection
            if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || 
                $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                header("location:../../View/v?pg=Pass&alert=CSRFError");
                exit();
            }
            
            if (isset($_POST['IdUser'])) {
                $PasswordBaru = isset($_POST['PasswordBaru']) ? sql_injeksi($_POST['PasswordBaru']) : '';

                // Validasi panjang password
                if (strlen($PasswordBaru) < 8) {
                    header("location:../../View/v?pg=Pass&alert=Panjang");
                    exit();
                }
                
                // Validasi huruf kapital
                if (!preg_match('/[A-Z]/', $PasswordBaru)) {
                    header("location:../../View/v?pg=Pass&alert=FormatPassword");
                    exit();
                }
                
                // Validasi karakter khusus
                if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $PasswordBaru)) {
                    header("location:../../View/v?pg=Pass&alert=FormatPassword");
                    exit();
                }
                
                // Jika semua validasi lolos
                $IdUser = sql_injeksi($_POST['IdUser']);
                
                // Pastikan user ID sesuai dengan session untuk keamanan
                if ($IdUser !== $_SESSION['IdUser']) {
                    header("location:../../View/v?pg=Pass&alert=CSRFError");
                    exit();
                }
                
                $PasswordBaru_Hash = password_hash($_POST['PasswordBaru'], PASSWORD_DEFAULT);

                $Koreksi = mysqli_query($db, "UPDATE main_user SET NamePassword = '$PasswordBaru_Hash'
                       WHERE IdUser = '$IdUser'");
                
                if ($Koreksi) {
                    // Regenerate CSRF token after successful update
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                    header("location:../../View/v?pg=Pass&alert=Sukses");
                } else {
                    header("location:../../View/v?pg=Pass&alert=DatabaseError");
                }
            }
        }
    }
}
