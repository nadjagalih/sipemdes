<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include "../../Module/Config/Env.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
} else {
    if ($_GET['Act'] == 'Save') {
        if (isset($_POST['Save'])) {

            $ViewTanggal   = date('YmdHis');
            $QAnak = mysqli_query($db, "SELECT * FROM hiskel_anak");
            $Count = mysqli_num_rows($QAnak);
            if ($Count <> 0) {
                $TempId = $Count + 1;
                $IdAnak = $ViewTanggal . "" . $TempId;
            } else {
                $TempId = 1;
                $IdAnak = $ViewTanggal . "" . $TempId;
            }

            $IdPegawaiFK = sql_injeksi($_POST['IdPegawaiFK']);
            $NIKAnak = sql_injeksi($_POST['NIKAnak']);
            $NamaAnak = sql_injeksi($_POST['NamaAnak']);
            $TempatLahir = sql_injeksi($_POST['TempatLahir']);

            $TanggalLahir = sql_injeksi($_POST['TanggalLahir']);
            $exp = explode('-', $TanggalLahir);
            $TglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            $JenKel = sql_injeksi($_POST['JenKel']);
            $StatusHubungan = sql_injeksi($_POST['StatusHubungan']);

            $Pendidikan = sql_injeksi($_POST['Pendidikan']);
            $Pekerjaan = sql_injeksi($_POST['Pekerjaan']);


            $Save = mysqli_query($db, "INSERT INTO hiskel_anak(IdAnak, NIK, Nama, Tempat, TanggalLahir, JenKel, IdPendidikanFK, Pekerjaan, StatusHubungan, IdPegawaiFK)
            VALUE('$IdAnak','$NIKAnak','$NamaAnak','$TempatLahir','$TglLahir','$JenKel','$Pendidikan','$Pekerjaan','$StatusHubungan','$IdPegawaiFK')");

            if ($Save) {
                header("location:../../View/v?pg=PegawaiViewAnak&alert=Save");
            }
        }
    } elseif ($_GET['Act'] == 'Edit') {
        if (isset($_POST['Edit'])) {
            $IdAnak = sql_injeksi($_POST['IdAnak']);
            $NIKAnak = sql_injeksi($_POST['NIKAnak']);
            $NamaAnak = sql_injeksi($_POST['NamaAnak']);
            $TempatLahir = sql_injeksi($_POST['TempatLahir']);

            $TanggalLahir = sql_injeksi($_POST['TanggalLahir']);
            $exp = explode('-', $TanggalLahir);
            $TglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            $JenKel = sql_injeksi($_POST['JenKel']);
            $StatusHubungan = sql_injeksi($_POST['StatusHubungan']);

            $Pendidikan = sql_injeksi($_POST['Pendidikan']);
            $Pekerjaan = sql_injeksi($_POST['Pekerjaan']);


            $Edit = mysqli_query($db, "UPDATE hiskel_anak SET NIK = '$NIKAnak',
            Nama = '$NamaAnak',
            Tempat = '$TempatLahir',
            TanggalLahir = '$TglLahir',
            JenKel = '$JenKel',
            IdPendidikanFK = '$Pendidikan',
            Pekerjaan = '$Pekerjaan',
            StatusHubungan = '$StatusHubungan'
            WHERE IdAnak = '$IdAnak' ");

            if ($Edit) {
                header("location:../../View/v?pg=PegawaiViewAnak&alert=Edit");
            }
        }
    } elseif ($_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdTemp = sql_injeksi(($_GET['Kode']));

            $Delete = mysqli_query($db, "DELETE FROM hiskel_anak WHERE IdAnak = '$IdTemp' ");

            if ($Delete) {
                header("location:../../View/v?pg=PegawaiViewAnak&alert=Delete");
            }
        }
    }
}
