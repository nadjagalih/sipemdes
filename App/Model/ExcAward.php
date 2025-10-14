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
                // Set tanggal awal penjurian sama dengan tanggal awal penghargaan
                $MasaPenjurianMulai = !empty($MasaAktifMulai) ? "'" . $MasaAktifMulai . "'" : 'NULL';
                
                // Set tanggal akhir penjurian dari input, tapi minimal sama dengan tanggal akhir penghargaan
                $inputPenjurianSelesai = !empty($_POST['MasaPenjurianSelesai']) ? $_POST['MasaPenjurianSelesai'] : $MasaAktifSelesai;
                if (!empty($MasaAktifSelesai) && !empty($inputPenjurianSelesai)) {
                    if ($inputPenjurianSelesai < $MasaAktifSelesai) {
                        $MasaPenjurianSelesai = "'" . $MasaAktifSelesai . "'";
                    } else {
                        $MasaPenjurianSelesai = "'" . sql_injeksi($inputPenjurianSelesai) . "'";
                    }
                } else {
                    $MasaPenjurianSelesai = !empty($MasaAktifSelesai) ? "'" . $MasaAktifSelesai . "'" : 'NULL';
                }
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
                header("location:../../View/v?pg=AwardView&alert=SaveSuccess");
            } else {
                header("location:../../View/v?pg=AwardAdd&alert=SaveError");
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Edit') {
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
                // Set tanggal awal penjurian sama dengan tanggal awal penghargaan
                $MasaPenjurianMulai = !empty($MasaAktifMulai) ? "'" . $MasaAktifMulai . "'" : 'NULL';
                
                // Set tanggal akhir penjurian dari input, tapi minimal sama dengan tanggal akhir penghargaan
                $inputPenjurianSelesai = !empty($_POST['MasaPenjurianSelesai']) ? $_POST['MasaPenjurianSelesai'] : $MasaAktifSelesai;
                if (!empty($MasaAktifSelesai) && !empty($inputPenjurianSelesai)) {
                    if ($inputPenjurianSelesai < $MasaAktifSelesai) {
                        $MasaPenjurianSelesai = "'" . $MasaAktifSelesai . "'";
                    } else {
                        $MasaPenjurianSelesai = "'" . sql_injeksi($inputPenjurianSelesai) . "'";
                    }
                } else {
                    $MasaPenjurianSelesai = !empty($MasaAktifSelesai) ? "'" . $MasaAktifSelesai . "'" : 'NULL';
                }
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
                header("location:../../View/v?pg=AwardView&alert=EditSuccess");
            } else {
                header("location:../../View/v?pg=AwardEdit&Kode=$IdAward&alert=EditError");
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdAward = sql_url($_GET['Kode']);
            
            // Debug logging
            error_log("Delete Award Request - IdAward: " . $IdAward);
            
            // Check if award exists
            $checkAward = mysqli_query($db, "SELECT * FROM master_award_desa WHERE IdAward = '$IdAward'");
            if (!$checkAward || mysqli_num_rows($checkAward) == 0) {
                error_log("Award not found: " . $IdAward);
                header("location:../../View/v?pg=AwardView&alert=DeleteError");
                exit();
            }
            
            // Delete related data first (foreign key constraints)
            // Delete peserta award
            $deletePeserta = mysqli_query($db, "DELETE FROM desa_award WHERE IdKategoriAwardFK IN (SELECT IdKategoriAward FROM master_kategori_award WHERE IdAwardFK = '$IdAward')");
            if (!$deletePeserta) {
                error_log("Failed to delete peserta: " . mysqli_error($db));
            }
            
            // Delete kategori award
            $deleteKategori = mysqli_query($db, "DELETE FROM master_kategori_award WHERE IdAwardFK = '$IdAward'");
            if (!$deleteKategori) {
                error_log("Failed to delete kategori: " . mysqli_error($db));
            }
            
            // Delete master award
            $Delete = mysqli_query($db, "DELETE FROM master_award_desa WHERE IdAward = '$IdAward'");
            
            if ($Delete) {
                error_log("Award deleted successfully: " . $IdAward);
                header("location:../../View/v?pg=AwardView&alert=DeleteSuccess");
            } else {
                error_log("Failed to delete award: " . mysqli_error($db));
                header("location:../../View/v?pg=AwardView&alert=DeleteError");
            }
        } else {
            error_log("Delete Award - No Kode parameter");
            header("location:../../View/v?pg=AwardView&alert=DeleteError");
        }
    }
}
?>