<?php
ob_start(); // Start output buffering
session_start();
error_reporting(0); // Disable error reporting to prevent output before redirect

include "../../Module/Config/Env.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
} else {
    if ($_GET['Act'] == 'Save') {
        if (isset($_POST['Save'])) {

            $ViewTanggal   = date('YmdHis');
            $QPendidikan = mysqli_query($db, "SELECT * FROM history_pendidikan");
            // $Count = mysqli_num_rows($QPendidikan);
            // if ($Count <> 0) {
            //     $TempId = $Count + 1;
            //     $IdPendidikanPegawai = $ViewTanggal . "" . $TempId;
            // } else {
            //     $TempId = 1;
            //     $IdPendidikanPegawai = $ViewTanggal . "" . $TempId;
            // }

            $tanggal        = date('Ymd');
            $waktuid        = date('His');
            $Acak           = rand(1, 99);
            $IdPendidikanPegawai = $tanggal . "" . $waktuid . "" . $Acak;

            $TahunMasuk = sql_injeksi($_POST['TahunMasuk']);
            $TahunKeluar = sql_injeksi($_POST['TahunKeluar']);
            $NamaSekolah = sql_injeksi($_POST['NamaSekolah']);
            $Jurusan = sql_injeksi($_POST['Jurusan']);
            $NomerIjazah = sql_injeksi($_POST['NomerIjazah']);

            $TanggalIjazah = sql_injeksi($_POST['TanggalIjazah']);
            $exp = explode('-', $TanggalIjazah);
            $TglIjazah = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
            $IdPegawaiFK = sql_injeksi($_POST['IdPegawaiFK']);
            $IdPendidikan = sql_injeksi($_POST['Pendidikan']);
            $Setting = 0;

            $Save = mysqli_query($db, "INSERT INTO history_pendidikan(IdPendidikanPegawai, TahunMasuk, TahunLulus, NamaSekolah, Jurusan, NomorIjasah, TanggalIjasah, IdPegawaiFK, IdPendidikanFK, Setting)
            VALUE('$IdPendidikanPegawai','$TahunMasuk','$TahunKeluar','$NamaSekolah','$Jurusan','$NomerIjazah','$TglIjazah','$IdPegawaiFK','$IdPendidikan','$Setting')");

            if ($Save) {
                // Redirect back to detail page with pegawai ID
                ob_end_clean(); // Clear output buffer
                header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawaiFK) . "&alert=Save&tab=tab-1");
                exit();
            }
        }
    } elseif ($_GET['Act'] == 'Edit') {
        if (isset($_POST['Edit'])) {
            $IdPendidikanV = sql_injeksi($_POST['IdPendidikanV']);
            $TahunMasuk = sql_injeksi($_POST['TahunMasuk']);
            $TahunKeluar = sql_injeksi($_POST['TahunKeluar']);
            $NamaSekolah = sql_injeksi($_POST['NamaSekolah']);
            $Jurusan = sql_injeksi($_POST['Jurusan']);
            $NomerIjazah = sql_injeksi($_POST['NomerIjazah']);
            $TanggalIjazah = sql_injeksi($_POST['TanggalIjazah']);
            $exp = explode('-', $TanggalIjazah);
            $TglIjazah = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
            $IdPendidikan = sql_injeksi($_POST['Pendidikan']);

            // Get IdPegawaiFK before update for redirect
            $getPegawaiId = mysqli_query($db, "SELECT IdPegawaiFK FROM history_pendidikan WHERE IdPendidikanPegawai = '$IdPendidikanV'");
            $pegawaiData = mysqli_fetch_assoc($getPegawaiId);
            $IdPegawaiFK = $pegawaiData['IdPegawaiFK'];

            $Edit = mysqli_query($db, "UPDATE history_pendidikan SET TahunMasuk = '$TahunMasuk',
            TahunLulus = '$TahunKeluar',
            NamaSekolah = '$NamaSekolah',
            Jurusan = '$Jurusan',
            NomorIjasah = '$NomerIjazah',
            TanggalIjasah = '$TglIjazah',
            IdPendidikanFK = '$IdPendidikan'
            WHERE IdPendidikanPegawai = '$IdPendidikanV' ");

            if ($Edit) {
                // Redirect back to detail page with pegawai ID
                ob_end_clean(); // Clear output buffer
                header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawaiFK) . "&alert=Edit&tab=tab-1");
                exit();
            }
        }
    } elseif ($_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdTemp = sql_injeksi(($_GET['Kode']));

            $Delete = mysqli_query($db, "DELETE FROM history_pendidikan WHERE IdPendidikanPegawai = '$IdTemp' ");

            if ($Delete) {
                // Check if IdPegawai parameter exists for redirect back to detail page
                if (isset($_GET['IdPegawai'])) {
                    $IdPegawai = sql_injeksi($_GET['IdPegawai']);
                    $tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab-1';
                    ob_end_clean(); // Clear output buffer
                    header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawai) . "&alert=Delete&tab=" . $tab);
                    exit();
                } else {
                    ob_end_clean(); // Clear output buffer
                    header("location:../../View/v?pg=PegawaiDetailAdminDesa&alert=Delete");
                    exit();
                }
            }
        }
    } elseif ($_GET['Act'] == 'SettingOn') {
        if (isset($_GET['Kode'])) {
            $IdTemp = sql_injeksi(($_GET['Kode']));

            $Filter = mysqli_query($db, "SELECT * FROM history_pendidikan WHERE IdPendidikanPegawai = '$IdTemp' ");
            $DataFilter = mysqli_fetch_assoc($Filter);
            $FilterPegawai = $DataFilter['IdPegawaiFK'];
            $AmbilPegawai = mysqli_query($db, "SELECT * FROM history_pendidikan");
            while ($DapatPegawai = mysqli_fetch_assoc($AmbilPegawai)) {
                $Koreksi = mysqli_query($db, "UPDATE history_pendidikan SET Setting = 0 WHERE IdPegawaiFK = '$FilterPegawai' ");
            }

            $SettingOn = 1;
            $SettingAktif = mysqli_query($db, "UPDATE history_pendidikan SET Setting = '$SettingOn'
            WHERE IdPendidikanPegawai = '$IdTemp' ");

            if ($SettingAktif) {
                // Check if IdPegawai parameter exists for redirect back to detail page
                if (isset($_GET['IdPegawai'])) {
                    $IdPegawai = sql_injeksi($_GET['IdPegawai']);
                    ob_end_clean(); // Clear output buffer
                    header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawai) . "&alert=Setting");
                    exit();
                } else {
                    // Redirect back to detail page with pegawai ID from database
                    ob_end_clean(); // Clear output buffer
                    header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($FilterPegawai) . "&alert=Setting");
                    exit();
                }
            }
        }
    }
}
