<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include "../../Module/Config/Env.php";
include "../../Module/Variabel/FileUpload.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
} else {
    if ($_GET['Act'] == 'Add') {
        if (isset($_POST['Save'])) {

            // $ViewTanggal   = date('YmdHis');
            // $QBPD = mysqli_query($db, "SELECT * FROM master_pegawai_bpd");
            // $Count = mysqli_num_rows($QBPD);
            // if ($Count <> 0) {
            //     $TempId = $Count + 1;
            //     $IdPegawaiBPD = $ViewTanggal . "" . $TempId;
            // } else {
            //     $TempId = 1;
            //     $IdPegawaiBPD = $ViewTanggal . "" . $TempId;
            // }

            $NIK = sql_injeksi($_POST['NIK']);
            $Nama = sql_injeksi($_POST['Nama']);
            $TempatLahir = sql_injeksi($_POST['TempatLahir']);

            $TanggalLahir = sql_injeksi($_POST['TanggalLahir']);
            $exp = explode('-', $TanggalLahir);
            $TglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            $Alamat = sql_injeksi($_POST['Alamat']);
            $RT = sql_injeksi($_POST['RT']);
            $RW = sql_injeksi($_POST['RW']);
            $IdDesa = sql_injeksi($_POST['IdDesa']);
            $IdKecamatan = sql_injeksi($_POST['IdKecamatan']);
            $IdKabupaten = sql_injeksi($_POST['IdKabupaten']);

            $JenKel = sql_injeksi($_POST['JenKel']);
            $Agama = sql_injeksi($_POST['Agama']);
            $GolDarah = sql_injeksi($_POST['GolDarah']);
            $Pernikahan = sql_injeksi($_POST['Pernikahan']);
            $StatusKepegawaian = sql_injeksi($_POST['StatusPegawai']);
            $UnitKerja = sql_injeksi($_POST['UnitKerja']);
            $Email = sql_injeksi($_POST['Email']);
            $Telp = sql_injeksi($_POST['Telp']);

            $tanggal        = date('Ymd');
            $waktuid        = date('His');
            // $IdPegawaiBPD = $tanggal . "" . $waktuid . "" . substr($Nama, -3);
            $IdPegawaiBPD = $tanggal . "" . $waktuid;

            $Save = mysqli_query($db, "INSERT INTO master_pegawai_bpd (IdPegawaiFK, NIK, Nama, Alamat, RT, RW, Lingkungan, Kecamatan, Kabupaten, Tempat, TanggalLahir, Agama, JenKel, GolDarah, StatusPernikahan, StatusKepegawaian, NoTelp, Email, IdDesaFK)
            VALUES('$IdPegawaiBPD','$NIK','$Nama','$Alamat','$RT','$RW','$IdDesa','$IdKecamatan','$IdKabupaten','$TempatLahir','$TglLahir','$Agama','$JenKel','$GolDarah','$Pernikahan','$StatusKepegawaian','$Telp','$Email','$IdDesa') ");

            if ($Save) {
                header("location:../../View/v?pg=PegawaiBPDViewAll&alert=Save");
            }
        }
    } elseif ($_GET['Act'] == 'Edit') {
        if (isset($_POST['Edit'])) {

            $IdPegawaiFK = sql_injeksi($_POST['IdPegawaiFK']);
            $NIK = sql_injeksi($_POST['NIK']);
            $Nama = sql_injeksi($_POST['Nama']);
            $TempatLahir = sql_injeksi($_POST['TempatLahir']);

            $TanggalLahir = sql_injeksi($_POST['TanggalLahir']);
            $exp = explode('-', $TanggalLahir);
            $TglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            $Alamat = sql_injeksi($_POST['Alamat']);
            $RT = sql_injeksi($_POST['RT']);
            $RW = sql_injeksi($_POST['RW']);
            $IdDesa = sql_injeksi($_POST['IdDesa']);
            $IdKecamatan = sql_injeksi($_POST['IdKecamatan']);
            $IdKabupaten = sql_injeksi($_POST['IdKabupaten']);

            $JenKel = sql_injeksi($_POST['JenKel']);
            $Agama = sql_injeksi($_POST['Agama']);
            $GolDarah = sql_injeksi($_POST['GolDarah']);
            $Pernikahan = sql_injeksi($_POST['Pernikahan']);
            $StatusKepegawaian = sql_injeksi($_POST['StatusPegawai']);
            $UnitKerja = sql_injeksi($_POST['UnitKerja']);
            $Email = sql_injeksi($_POST['Email']);
            $Telp = sql_injeksi($_POST['Telp']);

            $Edit = mysqli_query($db, "UPDATE master_pegawai_bpd SET NIK = '$NIK',
                Nama = '$Nama',
                Alamat = '$Alamat',
                RT = '$RT',
                RW = '$RW',
                Lingkungan = '$IdDesa',
                Kecamatan = '$IdKecamatan',
                Kabupaten = '$IdKabupaten',
                Tempat = '$TempatLahir',
                TanggalLahir = '$TglLahir',
                Agama = '$Agama',
                JenKel = '$JenKel',
                GolDarah = '$GolDarah',
                StatusPernikahan = '$Pernikahan',
                StatusKepegawaian = '$StatusKepegawaian',
                NoTelp = '$Telp',
                Email = '$Email',
                IdDesaFK = '$UnitKerja'
                WHERE IdPegawaiFK = '$IdPegawaiFK' ");

            if ($Edit) {
                header("location:../../View/v?pg=PegawaiBPDViewAll&alert=Edit");
            }
        }
    } elseif ($_GET['Act'] == 'Foto') {
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
                header("location:../../View/v?pg=PegawaiBPDViewAll&alert=Kosong");
            } elseif (in_array($FileExtention, $AllowExtention) == true) {
                if ($FileSize <= $FileMaxUpload) {
                    FotoPegawai($FileUpload);

                    $Edit = mysqli_query($db, "UPDATE master_pegawai_bpd SET Foto = '$FileUpload'
                WHERE IdPegawaiFK = '$IdPegawaiFK' ");
                    unlink("../../Vendor/Media/Pegawai/" . $NamaFileLama);

                    if ($Edit) {
                        header("location:../../View/v?pg=PegawaiBPDViewAll&alert=Edit");
                    }
                } else {
                    header("location:../../View/v?pg=PegawaiBPDViewAll&alert=FileMax");
                }
            } elseif (in_array($FileExtention, $AllowExtention) == false) {
                header("location:../../View/v?pg=PegawaiBPDViewAll&alert=Cek");
            }
        }
    } elseif ($_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdPegawaiBPD = sql_injeksi(($_GET['Kode']));

            $Pilih = mysqli_query($db, "SELECT Foto FROM master_pegawai_bpd WHERE IdPegawaiFK = '$IdPegawaiBPD' ");
            $DataPilih = mysqli_fetch_assoc($Pilih);
            $Foto = $DataPilih['Foto'];
            unlink("../../Vendor/Media/Pegawai/" . $Foto);

            $Delete = mysqli_query($db, "DELETE FROM master_pegawai_bpd WHERE IdPegawaiFK = '$IdPegawaiBPD' ");

            if ($Delete) {
                header("location:../../View/v?pg=PegawaiBPDViewAll&alert=Delete");
            }
        }
    }
}
