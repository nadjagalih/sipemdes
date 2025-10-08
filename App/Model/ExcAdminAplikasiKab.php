<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include "../../Module/Config/Env.php";
include "../../Module/Variabel/FileUpload.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
} else {
    if (isset($_GET['Act']) && $_GET['Act'] == 'Edit') {
        if (isset($_POST['Edit'])) {

            $IdPegawaiFK = sql_injeksi($_POST['IdPegawaiFK']);
            $NIK = sql_injeksi($_POST['NIK']);
            $Nama = sql_injeksi($_POST['Nama']);
            $JabatanId = sql_injeksi($_POST['Jabatan']);
            $StatusKepegawaian = sql_injeksi($_POST['StatusPegawai']);
            $UnitKerja = sql_injeksi($_POST['UnitKerja']);
            $Telp = sql_injeksi($_POST['Telp']);

            $QAdminAplikasi = mysqli_query($db, "SELECT * FROM master_admin_aplikasi WHERE IdPegawaiFK = '$IdPegawaiFK' ");
            $DataCekAdmAplikasi = mysqli_fetch_assoc($QAdminAplikasi);
            $IdAplikasi  = $DataCekAdmAplikasi['IdPegawaiFK'];

            if ($IdAplikasi <> "") {
                $Edit = mysqli_query($db, "UPDATE master_pegawai SET NIK = '$NIK',
                Nama = '$Nama',
                StatusKepegawaian = '$StatusKepegawaian',
                NoTelp = '$Telp'
                WHERE IdPegawaiFK = '$IdPegawaiFK' ");

                $EditAplikasi = mysqli_query($db, "UPDATE master_admin_aplikasi SET IdJabatanFK = '$JabatanId'
                WHERE IdPegawaiFK = '$IdAplikasi' ");
            } else {
                $SaveAplikasi = mysqli_query($db, "INSERT INTO master_admin_aplikasi(IdPegawaiFK, IdJabatanFK)
            VALUE('$IdPegawaiFK','$JabatanId')");
            }

            if ($Edit) {
                header("location:../../View/v?pg=PegawaiViewAll&alert=Edit");
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Foto') {
        if (isset($_POST['Foto'])) {
            $IdPegawaiFK = sql_injeksi($_POST['IdPegawaiFK']);
            // $IdPegawaiFK = sql_injeksi($_POST['FUpload']);
            $FileMaxUpload     = 2000000;
            $FileSize          = $_FILES['FUpload']['size'];

            $TanggalAcak       = date('Ymd');
            $LokasiFile        = $_FILES['FUpload']['tmp_name'];
            $TipeFile          = $_FILES['FUpload']['type'];
            $NamaFile          = $_FILES['FUpload']['name'];
            $AllowExtention    = array('png', 'jpg', 'jpeg');
            $FileExtention     = strtolower(end(explode('.', $NamaFile)));
            $Acak              = rand(1, 99);
            $FileUpload        = "afs_" . $TanggalAcak . "_" . $Acak . $NamaFile;
            $NamaFileLama      = sql_injeksi($_POST['NamaLama']);

            if ($NamaFile == "") {
                header("location:../../View/v?pg=PegawaiViewAll&alert=Kosong");
            } elseif (in_array($FileExtention, $AllowExtention) == true) {
                if ($FileSize <= $FileMaxUpload) {
                    FotoPegawai($FileUpload);

                    $Edit = mysqli_query($db, "UPDATE master_pegawai SET Foto = '$FileUpload'
                WHERE IdPegawaiFK = '$IdPegawaiFK' ");
                    unlink("../../Vendor/Media/Pegawai/" . $NamaFileLama);

                    if ($Edit) {
                        header("location:../../View/v?pg=PegawaiViewAll&alert=Edit");
                    }
                } else {
                    header("location:../../View/v?pg=PegawaiViewAll&alert=FileMax");
                }
            } elseif (in_array($FileExtention, $AllowExtention) == false) {
                header("location:../../View/v?pg=PegawaiViewAll&alert=Cek");
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdPegawai = sql_injeksi(($_GET['Kode']));

            $Pilih = mysqli_query($db, "SELECT Foto FROM master_pegawai WHERE IdPegawaiFK = '$IdPegawai' ");
            $DataPilih = mysqli_fetch_assoc($Pilih);
            $Foto = $DataPilih['Foto'];
            unlink("../../Vendor/Media/Pegawai/" . $Foto);


            $QMutasi = mysqli_query($db, "SELECT IdPegawaiFK FROM history_mutasi WHERE IdPegawaiFK = '$IdPegawai' ");
            $CountMutasi = mysqli_num_rows($QMutasi);

            $QAnak = mysqli_query($db, "SELECT IdPegawaiFK FROM hiskel_anak WHERE IdPegawaiFK = '$IdPegawai' ");
            $CountAnak = mysqli_num_rows($QAnak);

            $QOrtu = mysqli_query($db, "SELECT IdPegawaiFK FROM hiskel_ortu WHERE IdPegawaiFK = '$IdPegawai' ");
            $CountOrtu = mysqli_num_rows($QOrtu);

            $QSuamiIstri = mysqli_query($db, "SELECT IdPegawaiFK FROM hiskel_suami_istri WHERE IdPegawaiFK = '$IdPegawai' ");
            $CountSuamiIstri = mysqli_num_rows($QSuamiIstri);

            $QPendidikan = mysqli_query($db, "SELECT IdPegawaiFK FROM history_pendidikan WHERE IdPegawaiFK = '$IdPegawai' ");
            $CountPendidikan = mysqli_num_rows($QPendidikan);

            if ($CountMutasi <> 0 or $CountAnak <> 0 or $CountOrtu <> 0 or $CountSuamiIstri <> 0 or $CountPendidikan <> 0) {
                header("location:../../View/v?pg=PegawaiViewAll&alert=CekDelete");
            } else {
                $Delete = mysqli_query($db, "DELETE FROM master_pegawai WHERE IdPegawaiFK = '$IdPegawai' ");
                $DeleteUser = mysqli_query($db, "DELETE FROM main_user WHERE IdPegawai = '$IdPegawai' ");
                $DeleteHiskelAnak = mysqli_query($db, "DELETE FROM hiskel_anak WHERE IdPegawaiFK = '$IdPegawai' ");
                $DeleteHiskelOrtu = mysqli_query($db, "DELETE FROM hiskel_ortu WHERE IdPegawaiFK = '$IdPegawai' ");
                $DeleteHiskelSuamiIstri = mysqli_query($db, "DELETE FROM hiskel_suami_istri WHERE IdPegawaiFK = '$IdPegawai' ");
                $DeleteHisMutasi = mysqli_query($db, "DELETE FROM history_mutasi WHERE IdPegawaiFK = '$IdPegawai' ");
                $DeleteHisPendidikan = mysqli_query($db, "DELETE FROM history_pendidikan WHERE IdPegawaiFK = '$IdPegawai' ");

                if ($Delete) {
                    header("location:../../View/v?pg=PegawaiViewAll&alert=Delete");
                }
            }

            // $Delete = mysqli_query($db, "DELETE FROM master_pegawai WHERE IdPegawaiFK = '$IdPegawai' ");
            // $DeleteUser = mysqli_query($db, "DELETE FROM main_user WHERE IdPegawai = '$IdPegawai' ");
            // $DeleteHiskelAnak = mysqli_query($db, "DELETE FROM hiskel_anak WHERE IdPegawaiFK = '$IdPegawai' ");
            // $DeleteHiskelOrtu = mysqli_query($db, "DELETE FROM hiskel_ortu WHERE IdPegawaiFK = '$IdPegawai' ");
            // $DeleteHiskelSuamiIstri = mysqli_query($db, "DELETE FROM hiskel_suami_istri WHERE IdPegawaiFK = '$IdPegawai' ");
            // $DeleteHisMutasi = mysqli_query($db, "DELETE FROM history_mutasi WHERE IdPegawaiFK = '$IdPegawai' ");
            // $DeleteHisPendidikan = mysqli_query($db, "DELETE FROM history_pendidikan WHERE IdPegawaiFK = '$IdPegawai' ");


        }
    }
}
