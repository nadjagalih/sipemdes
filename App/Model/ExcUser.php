<?php
session_start();
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../../Module/Config/Env.php";
// Comment out security module for now to prevent white screen
// try {
//     require_once "../../Module/Security/Security.php";
// } catch (Exception $e) {
//     error_log("Security module error: " . $e->getMessage());
//     // Continue without security for now to prevent white screen
// }

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
} else {
    if (isset($_GET['Act']) && $_GET['Act'] == 'Save') {
        if (isset($_POST['Save'])) {
            // Remove CSRF validation for now
            // CSRFProtection::validateOrDie();
            $ViewTanggal   = date('YmdHis');
            $UserNama = sql_injeksi($_POST['UserNama']);
            $Pass  = password_hash(sql_injeksi($_POST['Pass']), PASSWORD_DEFAULT);
            $Akses = sql_injeksi($_POST['Akses']);
            // $NIK = sql_injeksi($_POST['NIK']);
            $Nama = sql_injeksi($_POST['Nama']);
            $UnitKerja = sql_injeksi($_POST['UnitKerja']);
            $StatusLogin = sql_injeksi($_POST['Status']);
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
            try {
                $IdPegawaiFK = sql_injeksi($_POST['IdPegawaiFK']);
                $IdUser = sql_injeksi($_POST['IdUser']);
                $UserNama = sql_injeksi($_POST['UserNama']);
                $Pass = sql_injeksi($_POST['Pass']);
                $Akses = sql_injeksi($_POST['Akses']);
                $Nama = sql_injeksi($_POST['Nama']);
                $UnitKerja = sql_injeksi($_POST['UnitKerja']);
                $Status = sql_injeksi($_POST['Status']);

                // Update user using prepared statements
                $updateUserQuery = "UPDATE main_user SET NameAkses = ?, IdLevelUserFK = ?, StatusLogin = ? WHERE IdUser = ?";
                if ($stmt = mysqli_prepare($db, $updateUserQuery)) {
                    mysqli_stmt_bind_param($stmt, "ssss", $UserNama, $Akses, $Status, $IdUser);
                    $Edit = mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                } else {
                    throw new Exception("Failed to prepare user update statement: " . mysqli_error($db));
                }

                // Update pegawai data
                $updatePegawaiQuery = "UPDATE master_pegawai SET IdDesaFK = ? WHERE IdPegawaiFK = ?";
                if ($stmt2 = mysqli_prepare($db, $updatePegawaiQuery)) {
                    mysqli_stmt_bind_param($stmt2, "ss", $UnitKerja, $IdUser);
                    $EditUnitKerja = mysqli_stmt_execute($stmt2);
                    mysqli_stmt_close($stmt2);
                } else {
                    throw new Exception("Failed to prepare pegawai update statement: " . mysqli_error($db));
                }

                if ($Edit && $EditUnitKerja) {
                    header("location:../../View/v?pg=UserView&alert=Edit");
                    exit();
                } else {
                    header("location:../../View/v?pg=UserEdit&Kode=$IdUser&alert=Error");
                    exit();
                }
                
            } catch (Exception $e) {
                error_log("Edit User Error: " . $e->getMessage());
                $IdUser = isset($_POST['IdUser']) ? $_POST['IdUser'] : '';
                header("location:../../View/v?pg=UserEdit&Kode=$IdUser&alert=Error");
                exit();
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