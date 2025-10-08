<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include "../../Module/Config/Env.php";

// Authentication check untuk admin desa
if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn.php?alert=SignOutTime";
    echo "<script>window.location.href = '$logout_redirect_url';</script>";
    exit;
}

if (!isset($_GET['Act'])) {
    echo "<script>
        alert('Action tidak ditemukan');
        window.location.href = '../../View/v.php?pg=DaftarKarya';
    </script>";
    exit;
}

$$Act = isset($_GET['Act']) ? sql_injeksi($_GET['Act']) : '';

// Fungsi untuk generate ID Karya Desa
function generateKaryaDesaId($db) {
    $ViewTanggal = date('YmdHis');
    $QKarya = mysqli_query($db, "SELECT * FROM desa_award ORDER BY IdPesertaAward DESC LIMIT 1");
    $Count = mysqli_num_rows($QKarya);
    
    if ($Count != 0) {
        $DataTerakhir = mysqli_fetch_assoc($QKarya);
        $IdTerakhir = $DataTerakhir['IdPesertaAward'];
        $TempId = (int)substr($IdTerakhir, -3) + 1;
        $TempId = sprintf("%03d", $TempId);
    } else {
        $TempId = "001";
    }
    
    return $ViewTanggal . $TempId;
}

if ($Act == 'Save') {
    if (isset($_POST['Save'])) {
        // Generate ID
        $IdPesertaAward = generateKaryaDesaId($db);
        
        // Sanitize input
        $IdAward = sql_injeksi($_POST['IdAward']);
        $IdKategori = sql_injeksi($_POST['IdKategori']);
        $JudulKarya = sql_injeksi($_POST['JudulKarya']);
        $LinkKarya = sql_injeksi($_POST['LinkKarya']);
        $DeskripsiKarya = sql_injeksi($_POST['DeskripsiKarya']);
        $IdDesa = $_SESSION['IdDesa'];
        
        // Validasi input
        if (empty($IdAward) || empty($IdKategori) || empty($JudulKarya) || empty($LinkKarya)) {
            echo "<script>
                alert('Semua field wajib harus diisi!');
                window.location.href = '../../View/v.php?pg=DaftarKarya';
            </script>";
            exit;
        }
        
        // Validasi URL format
        if (!filter_var($LinkKarya, FILTER_VALIDATE_URL)) {
            echo "<script>
                alert('Format URL tidak valid!');
                window.location.href = '../../View/v.php?pg=DaftarKarya';
            </script>";
            exit;
        }
        
        // Cek apakah desa sudah mendaftar di kategori yang sama
        $QueryCekDuplikat = mysqli_query($db, "SELECT * FROM desa_award 
            WHERE IdKategoriAwardFK = '$IdKategori' AND IdDesaFK = '$IdDesa'");
        
        if (mysqli_num_rows($QueryCekDuplikat) > 0) {
            echo "<script>
                alert('Desa Anda sudah terdaftar di kategori ini!');
                window.location.href = '../../View/v.php?pg=DaftarKarya';
            </script>";
            exit;
        }
        
        // Cek apakah award sedang dalam masa aktif
        $QueryCekAward = mysqli_query($db, "SELECT * FROM master_award_desa 
            WHERE IdAward = '$IdAward' AND StatusAktif = 'Aktif' 
            AND MasaAktifMulai <= CURDATE() AND MasaAktifSelesai >= CURDATE()");
        
        if (mysqli_num_rows($QueryCekAward) == 0) {
            echo "<script>
                alert('Award tidak aktif atau tidak dalam masa pendaftaran!');
                window.location.href = '../../View/v.php?pg=DaftarKarya';
            </script>";
            exit;
        }
        
        // Insert data
        $QueryInsert = mysqli_query($db, "INSERT INTO desa_award (
            IdPesertaAward,
            IdKategoriAwardFK,
            IdDesaFK,
            NamaKarya,
            LinkKarya,
            DeskripsiKarya,
            TanggalInput
        ) VALUES (
            '$IdPesertaAward',
            '$IdKategori',
            '$IdDesa',
            '$JudulKarya',
            '$LinkKarya',
            '$DeskripsiKarya',
            NOW()
        )");
        
        if ($QueryInsert) {
            echo "<script>
                alert('Karya berhasil didaftarkan!');
                window.location.href = '../../View/v.php?pg=KaryaDesa&alert=SaveSuccess';
            </script>";
        } else {
            echo "<script>
                alert('Gagal mendaftarkan karya: " . mysqli_error($db) . "');
                window.location.href = '../../View/v.php?pg=DaftarKarya&alert=SaveError';
            </script>";
        }
    }
} elseif ($Act == 'Update') {
    if (isset($_POST['Update'])) {
        // Sanitize input
        $IdPesertaAward = sql_injeksi($_POST['IdPesertaAward']);
        $JudulKarya = sql_injeksi($_POST['JudulKarya']);
        $LinkKarya = sql_injeksi($_POST['LinkKarya']);
        $DeskripsiKarya = sql_injeksi($_POST['DeskripsiKarya']);
        $IdDesa = $_SESSION['IdDesa'];
        
        // Validasi input
        if (empty($IdPesertaAward) || empty($JudulKarya) || empty($LinkKarya)) {
            echo "<script>
                alert('Field wajib harus diisi!');
                window.location.href = '../../View/v.php?pg=EditKarya&Kode=$IdPesertaAward';
            </script>";
            exit;
        }
        
        // Validasi URL format
        if (!filter_var($LinkKarya, FILTER_VALIDATE_URL)) {
            echo "<script>
                alert('Format URL tidak valid!');
                window.location.href = '../../View/v.php?pg=EditKarya&Kode=$IdPesertaAward';
            </script>";
            exit;
        }
        
        // Cek ownership
        $QueryCekOwner = mysqli_query($db, "SELECT * FROM desa_award 
            WHERE IdPesertaAward = '$IdPesertaAward' AND IdDesaFK = '$IdDesa'");
        
        if (mysqli_num_rows($QueryCekOwner) == 0) {
            echo "<script>
                alert('Anda tidak memiliki akses untuk mengedit karya ini!');
                window.location.href = '../../View/v.php?pg=KaryaDesa';
            </script>";
            exit;
        }
        
        // Update data
        $QueryUpdate = mysqli_query($db, "UPDATE desa_award SET 
            NamaKarya = '$JudulKarya',
            LinkKarya = '$LinkKarya',
            DeskripsiKarya = '$DeskripsiKarya'
            WHERE IdPesertaAward = '$IdPesertaAward' AND IdDesaFK = '$IdDesa'");
        
        if ($QueryUpdate) {
            echo "<script>
                alert('Karya berhasil diupdate!');
                window.location.href = '../../View/v.php?pg=KaryaDesa&alert=UpdateSuccess';
            </script>";
        } else {
            echo "<script>
                alert('Gagal mengupdate karya: " . mysqli_error($db) . "');
                window.location.href = '../../View/v.php?pg=EditKarya&Kode=$IdPesertaAward&alert=UpdateError';
            </script>";
        }
    }
} elseif ($Act == 'UpdateFromAward') {
    if (isset($_POST['Update'])) {
        $IdPesertaAward = sql_injeksi($_POST['IdPesertaAward']);
        $IdAward = sql_injeksi($_POST['IdAward']);
        $JudulKarya = sql_injeksi($_POST['JudulKarya']);
        $LinkKarya = sql_injeksi($_POST['LinkKarya']);
        $DeskripsiKarya = sql_injeksi($_POST['DeskripsiKarya']);
        $IdDesa = $_SESSION['IdDesa'];
        
        // Validasi URL
        if (!filter_var($LinkKarya, FILTER_VALIDATE_URL)) {
            echo "<script>
                window.location.href = '../../View/v.php?pg=EditKaryaAward&kode=$IdPesertaAward&award=$IdAward&alert=InvalidURL';
            </script>";
            exit;
        }
        
        // Cek ownership
        $QueryCekOwner = mysqli_query($db, "SELECT * FROM desa_award 
            WHERE IdPesertaAward = '$IdPesertaAward' AND IdDesaFK = '$IdDesa'");
        
        if (mysqli_num_rows($QueryCekOwner) == 0) {
            echo "<script>
                window.location.href = '../../View/v.php?pg=DetailAwardAdminDesa&id=$IdAward&alert=AccessDenied';
            </script>";
            exit;
        }
        
        // Update data
        $QueryUpdate = mysqli_query($db, "UPDATE desa_award SET 
            NamaKarya = '$JudulKarya',
            LinkKarya = '$LinkKarya',
            DeskripsiKarya = '$DeskripsiKarya'
            WHERE IdPesertaAward = '$IdPesertaAward' AND IdDesaFK = '$IdDesa'");
        
        if ($QueryUpdate) {
            echo "<script>
                window.location.href = '../../View/v.php?pg=DetailAwardAdminDesa&id=$IdAward&alert=UpdateSuccess';
            </script>";
        } else {
            echo "<script>
                window.location.href = '../../View/v.php?pg=EditKaryaAward&kode=$IdPesertaAward&award=$IdAward&alert=UpdateError';
            </script>";
        }
    }
} elseif ($Act == 'Delete') {
    if (isset($_GET['Kode'])) {
        $IdPesertaAward = sql_injeksi($_GET['Kode']);
        $IdDesa = $_SESSION['IdDesa'];
        
        // Get redirect parameter jika ada
        $redirect = $_GET['redirect'] ?? 'KaryaDesa';
        $IdAward = $_GET['award'] ?? '';
        
        // Cek apakah karya ada
        $QueryCekKarya = mysqli_query($db, "SELECT * FROM desa_award WHERE IdPesertaAward = '$IdPesertaAward'");
        
        if (mysqli_num_rows($QueryCekKarya) == 0) {
            echo "<script>
                alert('Karya tidak ditemukan di database!');
                if ('$redirect' == 'DetailAwardAdminDesa' && '$IdAward' != '') {
                    window.location.href = '../../View/v.php?pg=DetailAwardAdminDesa&id=$IdAward';
                } else {
                    window.location.href = '../../View/v.php?pg=KaryaDesa';
                }
            </script>";
            exit;
        }
        
        // Cek ownership
        $QueryCekOwner = mysqli_query($db, "SELECT * FROM desa_award 
            WHERE IdPesertaAward = '$IdPesertaAward' AND IdDesaFK = '$IdDesa'");
        
        if (mysqli_num_rows($QueryCekOwner) == 0) {
            $DataKarya = mysqli_fetch_assoc($QueryCekKarya);
            $KaryaOwner = $DataKarya['IdDesaFK'];
            
            echo "<script>
                alert('Anda tidak memiliki akses untuk menghapus karya ini!\\n\\nKarya ini milik desa lain.\\nSilakan hubungi administrator sistem.');
                if ('$redirect' == 'DetailAwardAdminDesa' && '$IdAward' != '') {
                    window.location.href = '../../View/v.php?pg=DetailAwardAdminDesa&id=$IdAward';
                } else {
                    window.location.href = '../../View/v.php?pg=KaryaDesa';
                }
            </script>";
            exit;
        }
        
        $DataOwner = mysqli_fetch_assoc($QueryCekOwner);
        $IdAwardFromData = $DataOwner['IdAwardFK'];
        
        // Delete data
        $QueryDelete = mysqli_query($db, "DELETE FROM desa_award 
            WHERE IdPesertaAward = '$IdPesertaAward' AND IdDesaFK = '$IdDesa'");
        
        if ($QueryDelete) {
            // Tentukan redirect berdasarkan parameter
            if ($redirect == 'DetailAwardAdminDesa' && !empty($IdAward)) {
                echo "<script>
                    window.location.href = '../../View/v.php?pg=DetailAwardAdminDesa&id=$IdAward&alert=DeleteSuccess';
                </script>";
            } else {
                echo "<script>
                    window.location.href = '../../View/v.php?pg=KaryaDesa&alert=DeleteSuccess';
                </script>";
            }
        } else {
            // Error redirect juga sesuai parameter
            if ($redirect == 'DetailAwardAdminDesa' && !empty($IdAward)) {
                echo "<script>
                    window.location.href = '../../View/v.php?pg=DetailAwardAdminDesa&id=$IdAward&alert=DeleteError';
                </script>";
            } else {
                echo "<script>
                    window.location.href = '../../View/v.php?pg=KaryaDesa&alert=DeleteError';
                </script>";
            }
        }
    }
} else {
    echo "<script>
        alert('Action tidak dikenali');
        window.location.href = '../../View/v.php?pg=DaftarKarya';
    </script>";
}
?>