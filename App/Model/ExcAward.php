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
            $ViewTanggal = date('YmdHis');
            $QAward = mysqli_query($db, "SELECT * FROM master_award_desa");
            $Count = mysqli_num_rows($QAward);
            if ($Count <> 0) {
                $TempId = $Count + 1;
                $IdAward = $ViewTanggal . "" . $TempId;
            } else {
                $TempId = 1;
                $IdAward = $ViewTanggal . "" . $TempId;
            }
            $JenisPenghargaan = sql_injeksi($_POST['JenisPenghargaan']);
            $TahunPenghargaan = sql_injeksi($_POST['TahunPenghargaan']);
            $MasaAktifMulai = sql_injeksi($_POST['MasaAktifMulai']);
            $MasaAktifSelesai = sql_injeksi($_POST['MasaAktifSelesai']);
            $Deskripsi = sql_injeksi($_POST['Deskripsi']);
            
            // Cek apakah kolom masa penjurian sudah ada
            $checkColumns = mysqli_query($db, "SHOW COLUMNS FROM master_award_desa LIKE 'MasaPenjurianMulai'");
            $hasJuryColumns = mysqli_num_rows($checkColumns) > 0;
            
            if ($hasJuryColumns) {
                $MasaPenjurianMulai = !empty($_POST['MasaPenjurianMulai']) ? "'" . sql_injeksi($_POST['MasaPenjurianMulai']) . "'" : 'NULL';
                $MasaPenjurianSelesai = !empty($_POST['MasaPenjurianSelesai']) ? "'" . sql_injeksi($_POST['MasaPenjurianSelesai']) . "'" : 'NULL';
            }
            
            // Tentukan status otomatis berdasarkan masa aktif
            $today = date('Y-m-d');
            $StatusAktif = 'Non-Aktif'; // default
            
            if (!empty($MasaAktifMulai) && !empty($MasaAktifSelesai)) {
                if ($today >= $MasaAktifMulai && $today <= $MasaAktifSelesai) {
                    $StatusAktif = 'Aktif';
                }
            }

            if ($hasJuryColumns) {
                $Save = mysqli_query($db, "INSERT INTO master_award_desa 
                    (IdAward, JenisPenghargaan, TahunPenghargaan, StatusAktif, Deskripsi, MasaAktifMulai, MasaAktifSelesai, MasaPenjurianMulai, MasaPenjurianSelesai)
                    VALUES ('$IdAward', '$JenisPenghargaan', '$TahunPenghargaan', '$StatusAktif', '$Deskripsi', '$MasaAktifMulai', '$MasaAktifSelesai', $MasaPenjurianMulai, $MasaPenjurianSelesai)");
            } else {
                $Save = mysqli_query($db, "INSERT INTO master_award_desa 
                    (IdAward, JenisPenghargaan, TahunPenghargaan, StatusAktif, Deskripsi, MasaAktifMulai, MasaAktifSelesai)
                    VALUES ('$IdAward', '$JenisPenghargaan', '$TahunPenghargaan', '$StatusAktif', '$Deskripsi', '$MasaAktifMulai', '$MasaAktifSelesai')");
            }

            if ($Save) {
                header("location:../../View/v?pg=AwardView&alert=Save");
            }
        }
    } elseif ($_GET['Act'] == 'Edit') {
        if (isset($_POST['Edit'])) {
            $IdAward = sql_injeksi($_POST['IdAward']);
            $JenisPenghargaan = sql_injeksi($_POST['JenisPenghargaan']);
            $TahunPenghargaan = sql_injeksi($_POST['TahunPenghargaan']);
            $MasaAktifMulai = sql_injeksi($_POST['MasaAktifMulai']);
            $MasaAktifSelesai = sql_injeksi($_POST['MasaAktifSelesai']);
            $Deskripsi = sql_injeksi($_POST['Deskripsi']);
            
            // Cek apakah kolom masa penjurian sudah ada
            $checkColumns = mysqli_query($db, "SHOW COLUMNS FROM master_award_desa LIKE 'MasaPenjurianMulai'");
            $hasJuryColumns = mysqli_num_rows($checkColumns) > 0;
            
            if ($hasJuryColumns) {
                $MasaPenjurianMulai = !empty($_POST['MasaPenjurianMulai']) ? "'" . sql_injeksi($_POST['MasaPenjurianMulai']) . "'" : 'NULL';
                $MasaPenjurianSelesai = !empty($_POST['MasaPenjurianSelesai']) ? "'" . sql_injeksi($_POST['MasaPenjurianSelesai']) . "'" : 'NULL';
            }
            
            // Tentukan status otomatis berdasarkan masa aktif
            $today = date('Y-m-d');
            $StatusAktif = 'Non-Aktif'; // default
            
            if (!empty($MasaAktifMulai) && !empty($MasaAktifSelesai)) {
                if ($today >= $MasaAktifMulai && $today <= $MasaAktifSelesai) {
                    $StatusAktif = 'Aktif';
                }
            }

            if ($hasJuryColumns) {
                $Update = mysqli_query($db, "UPDATE master_award_desa SET 
                    JenisPenghargaan = '$JenisPenghargaan',
                    TahunPenghargaan = '$TahunPenghargaan',
                    StatusAktif = '$StatusAktif',
                    Deskripsi = '$Deskripsi',
                    MasaAktifMulai = '$MasaAktifMulai',
                    MasaAktifSelesai = '$MasaAktifSelesai',
                    MasaPenjurianMulai = $MasaPenjurianMulai,
                    MasaPenjurianSelesai = $MasaPenjurianSelesai
                    WHERE IdAward = '$IdAward'");
            } else {
                $Update = mysqli_query($db, "UPDATE master_award_desa SET 
                    JenisPenghargaan = '$JenisPenghargaan',
                    TahunPenghargaan = '$TahunPenghargaan',
                    StatusAktif = '$StatusAktif',
                    Deskripsi = '$Deskripsi',
                    MasaAktifMulai = '$MasaAktifMulai',
                    MasaAktifSelesai = '$MasaAktifSelesai'
                    WHERE IdAward = '$IdAward'");
            }

            if ($Update) {
                header("location:../../View/v?pg=AwardDetail&Kode=$IdAward&alert=Edit");
            }
        }
    } elseif ($_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdAward = sql_url($_GET['Kode']);
            
            // Delete related data first (foreign key constraints)
            // Delete peserta award
            mysqli_query($db, "DELETE FROM desa_award WHERE IdKategoriAwardFK IN (SELECT IdKategoriAward FROM master_kategori_award WHERE IdAwardFK = '$IdAward')");
            // Delete kategori award
            mysqli_query($db, "DELETE FROM master_kategori_award WHERE IdAwardFK = '$IdAward'");
            // Delete master award
            $Delete = mysqli_query($db, "DELETE FROM master_award_desa WHERE IdAward = '$IdAward'");
            
            if ($Delete) {
                header("location:../../View/v?pg=AwardView&alert=Delete");
            }
        }
    }
}
?>