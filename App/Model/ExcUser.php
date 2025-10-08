<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include "../../Module/Config/Env.php";
require_once "../../Module/Security/Security.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
} else {
    if (isset($_GET['Act']) && $_GET['Act'] == 'Save') {
        if (isset($_POST['Save'])) {
            // Validate CSRF token
            CSRFProtection::validateOrDie();
            $ViewTanggal   = date('YmdHis');
            $UserNama = XSSProtection::sanitizeInput($_POST['UserNama']);
            $Pass  = password_hash(XSSProtection::sanitizeInput($_POST['Pass']), PASSWORD_DEFAULT);
            $Akses = XSSProtection::sanitizeInput($_POST['Akses']);
            // $NIK = XSSProtection::sanitizeInput($_POST['NIK']);
            $Nama = XSSProtection::sanitizeInput($_POST['Nama']);
            $UnitKerja = XSSProtection::sanitizeInput($_POST['UnitKerja']);
            $StatusLogin = XSSProtection::sanitizeInput($_POST['Status']);
            $Setting = 1;

            // Check if user exists using prepared statement
            $checkQuery = "SELECT NameAkses FROM main_user WHERE NameAkses = ?";
            if ($checkStmt = mysqli_prepare($db, $checkQuery)) {
                mysqli_stmt_bind_param($checkStmt, "s", $UserNama);
                mysqli_stmt_execute($checkStmt);
                $checkResult = mysqli_stmt_get_result($checkStmt);
                $Row = mysqli_num_rows($checkResult);
                mysqli_stmt_close($checkStmt);
                
                if ($Row <> 0) {
                    header("location:../../View/v?pg=UserView&alert=CekUser");
                } else {
                    $CekPassword = $_POST['Pass'];
                    if (strlen($CekPassword) >= 5) {

                    // $QUser = mysqli_query($db, "SELECT * FROM main_user");
                    // $Count = mysqli_num_rows($QUser);
                    // if ($Count <> 0) {
                    //     $TempId = $Count + 1;
                    //     $IdUser = $ViewTanggal . "" . $TempId;
                    // } else {
                    //     $TempId = 1;
                    //     $IdUser = $ViewTanggal . "" . $TempId;
                    // }

                        $tanggal        = date('Ymd');
                        $waktuid        = date('His');
                        $IdUser = $tanggal . "" . $waktuid . "" . substr($UserNama, -3);

                        // Insert user using prepared statement
                        $insertUserQuery = "INSERT INTO main_user(IdUser, NameAkses, NamePassword, IdLevelUserFK, Status, IdPegawai, StatusLogin) VALUES (?, ?, ?, ?, ?, ?, ?)";
                        if ($insertUserStmt = mysqli_prepare($db, $insertUserQuery)) {
                            mysqli_stmt_bind_param($insertUserStmt, "sssssss", $IdUser, $UserNama, $Pass, $Akses, $Setting, $IdUser, $StatusLogin);
                            $Save = mysqli_stmt_execute($insertUserStmt);
                            mysqli_stmt_close($insertUserStmt);
                        }

                        // Insert pegawai using prepared statement
                        $insertPegawaiQuery = "INSERT INTO master_pegawai(IdPegawaiFK, Nama, IdDesaFK, Setting) VALUES (?, ?, ?, ?)";
                        if ($insertPegawaiStmt = mysqli_prepare($db, $insertPegawaiQuery)) {
                            mysqli_stmt_bind_param($insertPegawaiStmt, "ssss", $IdUser, $Nama, $UnitKerja, $Setting);
                            $SavePegawai = mysqli_stmt_execute($insertPegawaiStmt);
                            mysqli_stmt_close($insertPegawaiStmt);
                        }

                        if ($Save) {
                            header("location:../../View/v?pg=UserView&alert=Save");
                        }
                } elseif (strlen($CekPassword) < 5) {
                    header("location:../../View/v?pg=UserView&alert=Karakter");
                }
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Edit') {
        if (isset($_POST['Edit'])) {

            $IdPegawaiFK = sql_injeksi($_POST['IdPegawaiFK']);
            $IdUser = sql_injeksi($_POST['IdUser']);
            $UserNama = sql_injeksi($_POST['UserNama']);
            $Pass = sql_injeksi($_POST['Pass']);
            $Akses = sql_injeksi($_POST['Akses']);
            // $NIK = sql_injeksi($_POST['NIK']);
            $Nama = sql_injeksi($_POST['Nama']);
            $UnitKerja = sql_injeksi($_POST['UnitKerja']);
            $Status = sql_injeksi($_POST['Status']);

            $Edit = mysqli_query($db, "UPDATE main_user SET NameAkses = '$UserNama',
            IdLevelUserFK = '$Akses',
            StatusLogin = '$Status'
            WHERE IdUser = '$IdUser' ");

            $EditUnitKerja = mysqli_query($db, "UPDATE master_pegawai SET IdDesaFK = '$UnitKerja'
            WHERE IdPegawaiFK = '$IdUser' ");

            // if ($Status == 0) {
            //     $EditStatusPegawai = mysqli_query($db, "UPDATE master_pegawai SET Setting = '$Status'
            // WHERE IdPegawaiFK = '$IdPegawaiFK' ");
            // } elseif ($Status == 1) {
            //     $EditStatusPegawai = mysqli_query($db, "UPDATE master_pegawai SET Setting = '$Status'
            // WHERE IdPegawaiFK = '$IdPegawaiFK' ");
            // }

            if ($Edit) {
                header("location:../../View/v?pg=UserView&alert=Edit");
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdUser = sql_injeksi(($_GET['Kode']));

            $QMutasi = mysqli_query($db, "SELECT IdPegawaiFK FROM history_mutasi WHERE IdPegawaiFK = '$IdUser' ");
            $CountMutasi = mysqli_num_rows($QMutasi);

            $QAnak = mysqli_query($db, "SELECT IdPegawaiFK FROM hiskel_anak WHERE IdPegawaiFK = '$IdUser' ");
            $CountAnak = mysqli_num_rows($QAnak);

            $QOrtu = mysqli_query($db, "SELECT IdPegawaiFK FROM hiskel_ortu WHERE IdPegawaiFK = '$IdUser' ");
            $CountOrtu = mysqli_num_rows($QOrtu);

            $QSuamiIstri = mysqli_query($db, "SELECT IdPegawaiFK FROM hiskel_suami_istri WHERE IdPegawaiFK = '$IdUser' ");
            $CountSuamiIstri = mysqli_num_rows($QSuamiIstri);

            $QPendidikan = mysqli_query($db, "SELECT IdPegawaiFK FROM history_pendidikan WHERE IdPegawaiFK = '$IdUser' ");
            $CountPendidikan = mysqli_num_rows($QPendidikan);

            if ($CountMutasi <> 0 or $CountAnak <> 0 or $CountOrtu <> 0 or $CountSuamiIstri <> 0 or $CountPendidikan <> 0) {
                header("location:../../View/v?pg=UserView&alert=CekDelete");
            } else {
                $Delete = mysqli_query($db, "DELETE FROM main_user WHERE IdUser = '$IdUser' ");
                $Delete1 = mysqli_query($db, "DELETE FROM master_pegawai WHERE IdPegawaiFK = '$IdUser' ");

                if ($Delete) {
                    header("location:../../View/v?pg=UserView&alert=Delete");
                }
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Reset') {
        if (isset($_POST['Reset'])) {

            $IdUser = sql_injeksi($_POST['IdUser']);
            $Pass = sql_injeksi(password_hash($_POST['Pass'], PASSWORD_DEFAULT));
            $EditReset = mysqli_query($db, "UPDATE main_user SET NamePassword = '$Pass'
            WHERE IdUser = '$IdUser' ");

            if ($EditReset) {
                header("location:../../View/v?pg=UserView&alert=Reset");
            }
        }
    }
}
}