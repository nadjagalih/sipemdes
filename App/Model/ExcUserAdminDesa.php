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
            $UserNama = sql_injeksi($_POST['UserNama']);
            $Pass  = sql_injeksi(password_hash($_POST['Pass'], PASSWORD_DEFAULT));
            $Akses = sql_injeksi($_POST['Akses']);
            // $NIK = sql_injeksi($_POST['NIK']);
            $Nama = sql_injeksi($_POST['Nama']);
            $UnitKerja = sql_injeksi($_POST['UnitKerja']);
            $StatusLogin = sql_injeksi($_POST['Status']);
            $Setting = 1;

            $CekUser = mysqli_query($db, "SELECT NameAkses FROM main_user WHERE NameAkses='$UserNama' ");
            $Row = mysqli_num_rows($CekUser);
            if ($Row <> 0) {
                header("location:../../View/v?pg=UserViewAdminDesa&alert=CekUser");
            } else {
                $CekPassword = sql_injeksi($_POST['Pass']);
                if (strlen($CekPassword) >= 5) {

                    $tanggal        = date('Ymd');
                    $waktuid        = date('His');
                    $Acak           = rand(1, 99);
                    $IdUser = $tanggal . "" . $waktuid . "" . $Acak;

                    // $QUser = mysqli_query($db, "SELECT * FROM main_user");
                    // $Count = mysqli_num_rows($QUser);
                    // if ($Count <> 0) {
                    //     $TempId = $Count + 1;
                    //     $IdUser = $ViewTanggal . "" . $TempId;
                    // } else {
                    //     $TempId = 1;
                    //     $IdUser = $ViewTanggal . "" . $TempId;
                    // }
                    $Save = mysqli_query($db, "INSERT INTO main_user(IdUser, NameAkses, NamePassword, IdLevelUserFK, Status, IdPegawai, StatusLogin)
                    VALUE('$IdUser','$UserNama','$Pass','$Akses','$Setting','$IdUser','$StatusLogin')");

                    $SavePegawai = mysqli_query($db, "INSERT INTO master_pegawai(IdPegawaiFK, Nama, IdDesaFK, Setting)
                    VALUE('$IdUser','$Nama','$UnitKerja','$Setting')");

                    if ($Save) {
                        header("location:../../View/v?pg=UserViewAdminDesa&alert=Save");
                    }
                } elseif (strlen($CekPassword) < 5) {
                    header("location:../../View/v?pg=UserViewAdminDesa&alert=Karakter");
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
                header("location:../../View/v?pg=UserViewAdminDesa&alert=Edit");
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdUser = sql_injeksi(($_GET['Kode']));

            // Check if user has history records
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

            // Cascade delete: Delete all related history records first
            if ($CountMutasi > 0) {
                mysqli_query($db, "DELETE FROM history_mutasi WHERE IdPegawaiFK = '$IdUser'");
            }
            if ($CountAnak > 0) {
                mysqli_query($db, "DELETE FROM hiskel_anak WHERE IdPegawaiFK = '$IdUser'");
            }
            if ($CountOrtu > 0) {
                mysqli_query($db, "DELETE FROM hiskel_ortu WHERE IdPegawaiFK = '$IdUser'");
            }
            if ($CountSuamiIstri > 0) {
                mysqli_query($db, "DELETE FROM hiskel_suami_istri WHERE IdPegawaiFK = '$IdUser'");
            }
            if ($CountPendidikan > 0) {
                mysqli_query($db, "DELETE FROM history_pendidikan WHERE IdPegawaiFK = '$IdUser'");
            }

            // Now delete user and pegawai records
            $Delete = mysqli_query($db, "DELETE FROM main_user WHERE IdUser = '$IdUser' ");
            $Delete1 = mysqli_query($db, "DELETE FROM master_pegawai WHERE IdPegawaiFK = '$IdUser' ");

            if ($Delete && $Delete1) {
                header("location:../../View/v?pg=UserViewAdminDesa&alert=Delete");
            } else {
                header("location:../../View/v?pg=UserViewAdminDesa&alert=ErrorDelete");
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Reset') {
        if (isset($_POST['Reset'])) {

            $IdUser = sql_injeksi($_POST['IdUser']);
            $Pass = sql_injeksi($_POST['Pass']);
            
            // Debug: Check if we received the data
            error_log("Reset Password Debug - IdUser: " . $IdUser);
            error_log("Reset Password Debug - Password: " . $Pass);
            
            // Check if password is empty
            if (empty($Pass)) {
                error_log("Reset Password Debug - Password is empty, no update needed");
                header("location:../../View/v?pg=UserViewAdminDesa&alert=NoPasswordChange");
                return;
            }
            
            // Always hash the password for security
            $HashedPass = password_hash($Pass, PASSWORD_DEFAULT);
            
            // Debug: Check the hashed password
            error_log("Reset Password Debug - Hashed: " . $HashedPass);
            
            $EditReset = mysqli_query($db, "UPDATE main_user SET NamePassword = '$HashedPass'
            WHERE IdUser = '$IdUser' ");

            // Debug: Check if query executed
            if ($EditReset) {
                error_log("Reset Password Debug - Query successful");
                // Check how many rows were affected
                $affected_rows = mysqli_affected_rows($db);
                error_log("Reset Password Debug - Affected rows: " . $affected_rows);
                
                if ($affected_rows > 0) {
                    header("location:../../View/v?pg=UserViewAdminDesa&alert=Reset");
                } else {
                    header("location:../../View/v?pg=UserViewAdminDesa&alert=NoRowsAffected");
                }
            } else {
                error_log("Reset Password Debug - Query failed: " . mysqli_error($db));
                header("location:../../View/v?pg=UserViewAdminDesa&alert=QueryError");
            }
        }
    }
}
