<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include "../../Module/Config/Env.php";
include "../../Module/Variabel/FileUpload.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    $logout_redirect_url = "../../Auth/SignIn?alert=SignOutTime";
    header("location: $logout_redirect_url");
} else {
    if (isset($_GET['Act']) && $_GET['Act'] == 'Save') {
        if (isset($_POST['Save'])) {

            $ViewTanggal = date('YmdHis');
            $QMutasi = mysqli_query($db, "SELECT * FROM history_mutasi");
            // $Count = mysqli_num_rows($QMutasi);
            // if ($Count <> 0) {
            //     $TempId = $Count + 1;
            //     $IdMutasi = $ViewTanggal . "" . $TempId;
            // } else {
            //     $TempId = 1;
            //     $IdMutasi = $ViewTanggal . "" . $TempId;
            // }

            $tanggal = date('Ymd');
            $waktuid = date('His');
            $Acak = rand(1, 99);
            $IdMutasi = $tanggal . "" . $waktuid . "" . $Acak;

            $IdPegawaiFK = sql_injeksi($_POST['IdPegawaiFK']);

            $TglMutasi = sql_injeksi($_POST['TanggalMutasi']);
            $exp = explode('-', $TglMutasi);
            $TanggalMutasi = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            $JenisMutasi = sql_injeksi($_POST['JenisMutasi']);
            $Jabatan = sql_injeksi($_POST['Jabatan']);

            // $TglTMT = sql_injeksi($_POST['TanggalTMT']);
            // $exp1 = explode('-', $TglTMT);
            // $TanggalTMT = $exp1[2] . "-" . $exp1[1] . "-" . $exp1[0];

            $NomerSK = sql_injeksi($_POST['NomerSK']);
            $Keterangan = sql_injeksi($_POST['Keterangan']);
            // $Jabatan = sql_injeksi($_POST['Jabatan']);
            $Setting = 1;

            //Atribut Upload File
            $FileMaxUpload = 2 * 1024 * 1024;
            $FileSize = $_FILES['FUpload']['size'];

            $TanggalAcak = date('Ymd');
            $LokasiFile = $_FILES['FUpload']['tmp_name'];
            $TipeFile = $_FILES['FUpload']['type'];
            $NamaFile = $_FILES['FUpload']['name'];
            $AllowExtention = array('pdf');
            $FileExtention = strtolower(end(explode('.', $NamaFile)));
            $Acak = rand(1, 99);
            $FileUpload = "afs_" . $TanggalAcak . "_" . $Acak . $NamaFile;

            if ($FileSize <= $FileMaxUpload) {
                if (in_array($FileExtention, $AllowExtention) == true) {
                    // OLD File Upload
                    // FileSK($FileUpload);

                    // NEW BLOB
                    $FileContent = addslashes(file_get_contents($LokasiFile));

                    //CARI ID PEGAWAI DENGAN SETTING 1
                    $Cek = mysqli_query($db, "SELECT IdPegawaiFK, Setting FROM history_mutasi WHERE IdPegawaiFK = '$IdPegawaiFK' AND Setting = 1 ");
                    $DataCek = mysqli_fetch_assoc($Cek);
                    $IdPegawaiFKCek = $DataCek['IdPegawaiFK'];

                    $Koreksi = mysqli_query($db, "UPDATE history_mutasi SET Setting = 0
                    WHERE IdPegawaiFK = '$IdPegawaiFKCek' ");

                    // OLD File Upload
                    // $Save = mysqli_query($db, "INSERT INTO history_mutasi(IdMutasi,IdPegawaiFK,JenisMutasi,NomorSK,TanggalMutasi,FileSKMutasi,IdJabatanFK,KeteranganJabatan,Setting)
                    // VALUE('$IdMutasi','$IdPegawaiFK','$JenisMutasi','$NomerSK','$TanggalMutasi','$FileUpload','$Jabatan','$Keterangan','$Setting')");

                    // NEW BLOB
                    $Save = mysqli_query($db, "INSERT INTO history_mutasi (IdMutasi, IdPegawaiFK, JenisMutasi, NomorSK, TanggalMutasi, FileSKMutasi, FileSKMutasiBlob, IdJabatanFK, KeteranganJabatan, Setting)
                    VALUE ('$IdMutasi', '$IdPegawaiFK', '$JenisMutasi', '$NomerSK', '$TanggalMutasi', '$FileUpload', '$FileContent', '$Jabatan', '$Keterangan', '$Setting')");

                    //OFF KAN PEGAWAI DAN USER JIKA MUTASI KELUAR PENSIUN MENINGGAL KODE 3 4 5
                    if ($JenisMutasi == 3 or $JenisMutasi == 4 or $JenisMutasi == 5) {
                        $CekPegawai = mysqli_query($db, "SELECT IdPegawaiFK, Setting FROM master_pegawai WHERE IdPegawaiFK = '$IdPegawaiFK' AND Setting = 1 ");
                        $DataCekPegawai = mysqli_fetch_assoc($CekPegawai);
                        $IdPegawaiFKCekPeg = $DataCekPegawai['IdPegawaiFK'];

                        $KoreksiPegawai = mysqli_query($db, "UPDATE master_pegawai SET Setting = 0
                        WHERE IdPegawaiFK = '$IdPegawaiFKCekPeg' ");

                        $CekUser = mysqli_query($db, "SELECT IdPegawai, Status FROM main_user WHERE IdPegawai = '$IdPegawaiFK' AND Status = 1 ");
                        $DataCekUser = mysqli_fetch_assoc($CekUser);
                        $IdPegawaiFKCekUser = $DataCekUser['IdPegawai'];

                        $KoreksiUser = mysqli_query($db, "UPDATE main_user SET Status = 0,
                        StatusLogin = 0
                        WHERE IdPegawai = '$IdPegawaiFKCekUser' ");
                    }

                    if ($Jabatan == 1) {
                        $TanggalMutasiPensiun = sql_injeksi($_POST['TanggalMutasi']);
                        $exp = explode('-', $TanggalMutasiPensiun);
                        $TglMutasiPensiun = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                        $TahunSekarang = date('Y');
                        $TetapanPensiun = 6;
                        $SisaTahunPensiun = $TahunSekarang + $TetapanPensiun;
                        $TempTanggalPensiun = date_format(date_create($TanggalMutasiPensiun), 'd-m');
                        $exp = explode('-', $TempTanggalPensiun);
                        $TanggalPensiun = $SisaTahunPensiun . "-" . $exp[1] . "-" . $exp[0];

                        $KoreksiTglPensiun = mysqli_query($db, "UPDATE master_pegawai SET TanggalPensiun = '$TanggalPensiun'
                        WHERE IdPegawaiFK = '$IdPegawaiFK' ");
                    } else {
                        $QueryPegawai = mysqli_query($db, "SELECT TanggalLahir, IdPegawaiFK FROM master_pegawai WHERE IdPegawaiFK = '$IdPegawaiFK' ");
                        $DataTempPegawai = mysqli_fetch_assoc($QueryPegawai);
                        $TglLahirPegawai = $DataTempPegawai['TanggalLahir'];

                        //HITUNG TANGGAL PENSIUN DATA DASAR TAHUN
                        $exp = explode('-', $TglLahirPegawai);
                        $TglLahirAmbil = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                        $TahunLahir = date_format(date_create($TglLahirPegawai), 'Y');
                        $TahunSekarang = date('Y');
                        $SelisihTahun = $TahunSekarang - $TahunLahir;
                        $TetapanPensiun = 60;
                        $SisaTahunPensiun = $TetapanPensiun - $SelisihTahun;
                        $TahunPensiun = $TahunSekarang + $SisaTahunPensiun;
                        $TempTanggalPensiun = date_format(date_create($TglLahirPegawai), 'd-m');
                        $exp = explode('-', $TempTanggalPensiun);
                        $TanggalPensiun = $TahunPensiun . "-" . $exp[1] . "-" . $exp[0];
                        //SELESAI HITUNG TAHUN
                        $KoreksiTglPensiun = mysqli_query($db, "UPDATE master_pegawai SET TanggalPensiun = '$TanggalPensiun'
                        WHERE IdPegawaiFK = '$IdPegawaiFK' ");
                    }

                    if ($Save) {
                        // Check if IdPegawai parameter exists for redirect back to detail page
                        if (isset($_GET['IdPegawai'])) {
                            $IdPegawai = sql_injeksi($_GET['IdPegawai']);
                            $tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab-5';
                            ob_end_clean(); // Clear output buffer
                            header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawai) . "&alert=Save&tab=" . $tab);
                            exit();
                        } else {
                            header("location:../../View/v?pg=ViewMutasiAdminDesa&alert=Save");
                        }
                    }
                } elseif (in_array($FileExtention, $AllowExtention) == false) {
                    if (isset($_GET['IdPegawai'])) {
                        $IdPegawai = sql_injeksi($_GET['IdPegawai']);
                        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab-5';
                        ob_end_clean();
                        header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawai) . "&alert=Cek&tab=" . $tab);
                        exit();
                    } else {
                        header("location:../../View/v?pg=ViewMutasiAdminDesa&alert=Cek");
                    }
                }
            } else {
                if (isset($_GET['IdPegawai'])) {
                    $IdPegawai = sql_injeksi($_GET['IdPegawai']);
                    $tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab-5';
                    ob_end_clean();
                    header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawai) . "&alert=FileMax&tab=" . $tab);
                    exit();
                } else {
                    header("location:../../View/v?pg=ViewMutasiAdminDesa&alert=FileMax");
                }
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Edit') {
        if (isset($_POST['Edit'])) {

            $IdPegawaiFK = sql_injeksi($_POST['IdPegawaiFK']);
            $IdMutasi = sql_injeksi($_POST['IdMutasi']);

            $TglMutasi = sql_injeksi($_POST['TanggalMutasi']);
            $exp = explode('-', $TglMutasi);
            $TanggalMutasi = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            $JenisMutasi = sql_injeksi($_POST['JenisMutasi']);
            $Jabatan = sql_injeksi($_POST['Jabatan']);

            // $TglTMT = sql_injeksi($_POST['TanggalTMT']);
            // $exp1 = explode('-', $TglTMT);
            // $TanggalTMT = $exp1[2] . "-" . $exp1[1] . "-" . $exp1[0];

            $NomerSK = sql_injeksi($_POST['NomerSK']);
            $Keterangan = sql_injeksi($_POST['Keterangan']);
            $Jabatan = sql_injeksi($_POST['Jabatan']);
            $StatusMutasi = sql_injeksi($_POST['StatusMutasi']);

            // Jika StatusMutasi diubah menjadi AKTIF (1), nonaktifkan mutasi lain untuk pegawai yang sama
            if ($StatusMutasi == 1) {
                // Nonaktifkan semua mutasi pegawai ini terlebih dahulu
                $KoreksiMutasi = mysqli_query($db, "UPDATE history_mutasi SET Setting = 0 WHERE IdPegawaiFK = '$IdPegawaiFK'");
            }

            $Edit = mysqli_query($db, "UPDATE history_mutasi SET JenisMutasi = '$JenisMutasi',
                        NomorSK = '$NomerSK',
                        TanggalMutasi = '$TanggalMutasi',
                        IdJabatanFK = '$Jabatan',
                        KeteranganJabatan = '$Keterangan',
                        Setting = '$StatusMutasi'
                        WHERE IdMutasi ='$IdMutasi' ");


            //OFF KAN PEGAWAI DAN USER JIKA MUTASI KELUAR PENSIUN MENINGGAL KODE 3 4 5
            if ($JenisMutasi == 3 or $JenisMutasi == 4 or $JenisMutasi == 5) {
                $CekPegawai = mysqli_query($db, "SELECT IdPegawaiFK, Setting FROM master_pegawai WHERE IdPegawaiFK = '$IdPegawaiFK' AND Setting = 1 ");
                $DataCekPegawai = mysqli_fetch_assoc($CekPegawai);
                $IdPegawaiFKCekPeg = $DataCekPegawai['IdPegawaiFK'];

                $KoreksiPegawai = mysqli_query($db, "UPDATE master_pegawai SET Setting = 0
                WHERE IdPegawaiFK = '$IdPegawaiFKCekPeg' ");

                $CekUser = mysqli_query($db, "SELECT IdPegawai, Status FROM main_user WHERE IdPegawai = '$IdPegawaiFK' AND Status = 1 ");
                $DataCekUser = mysqli_fetch_assoc($CekUser);
                $IdPegawaiFKCekUser = $DataCekUser['IdPegawai'];

                $KoreksiUser = mysqli_query($db, "UPDATE main_user SET Status = 0,
                StatusLogin = 0
                WHERE IdPegawai = '$IdPegawaiFKCekUser' ");
            } elseif ($JenisMutasi == 1 or $JenisMutasi == 2) {
                $CekPegawai = mysqli_query($db, "SELECT IdPegawaiFK, Setting FROM master_pegawai WHERE IdPegawaiFK = '$IdPegawaiFK' AND Setting = 0 ");
                $DataCekPegawai = mysqli_fetch_assoc($CekPegawai);
                $IdPegawaiFKCekPeg = $DataCekPegawai['IdPegawaiFK'];

                $KoreksiPegawai = mysqli_query($db, "UPDATE master_pegawai SET Setting = 1
                WHERE IdPegawaiFK = '$IdPegawaiFKCekPeg' ");

                $CekUser = mysqli_query($db, "SELECT IdPegawai, Status FROM main_user WHERE IdPegawai = '$IdPegawaiFK' AND Status = 0 ");
                $DataCekUser = mysqli_fetch_assoc($CekUser);
                $IdPegawaiFKCekUser = $DataCekUser['IdPegawai'];

                $KoreksiUser = mysqli_query($db, "UPDATE main_user SET Status = 1,
                StatusLogin = 1
                WHERE IdPegawai = '$IdPegawaiFKCekUser' ");
            }


            if ($Jabatan == 1) {
                $TanggalMutasiPensiun = sql_injeksi($_POST['TanggalMutasi']);
                $exp = explode('-', $TanggalMutasiPensiun);
                $TglMutasiPensiun = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                $TahunSekarang = date('Y');
                $TetapanPensiun = 6;
                $SisaTahunPensiun = $TahunSekarang + $TetapanPensiun;
                $TempTanggalPensiun = date_format(date_create($TanggalMutasiPensiun), 'd-m');
                $exp = explode('-', $TempTanggalPensiun);
                $TanggalPensiun = $SisaTahunPensiun . "-" . $exp[1] . "-" . $exp[0];

                $KoreksiTglPensiun = mysqli_query($db, "UPDATE master_pegawai SET TanggalPensiun = '$TanggalPensiun'
                        WHERE IdPegawaiFK = '$IdPegawaiFK' ");
            } else {
                $QueryPegawai = mysqli_query($db, "SELECT TanggalLahir, IdPegawaiFK FROM master_pegawai WHERE IdPegawaiFK = '$IdPegawaiFK' ");
                $DataTempPegawai = mysqli_fetch_assoc($QueryPegawai);
                $TglLahirPegawai = $DataTempPegawai['TanggalLahir'];

                //HITUNG TANGGAL PENSIUN DATA DASAR TAHUN
                $exp = explode('-', $TglLahirPegawai);
                $TglLahirAmbil = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                $TahunLahir = date_format(date_create($TglLahirPegawai), 'Y');
                $TahunSekarang = date('Y');
                $SelisihTahun = $TahunSekarang - $TahunLahir;
                $TetapanPensiun = 60;
                $SisaTahunPensiun = $TetapanPensiun - $SelisihTahun;
                $TahunPensiun = $TahunSekarang + $SisaTahunPensiun;
                $TempTanggalPensiun = date_format(date_create($TglLahirPegawai), 'd-m');
                $exp = explode('-', $TempTanggalPensiun);
                $TanggalPensiun = $TahunPensiun . "-" . $exp[1] . "-" . $exp[0];
                //SELESAI HITUNG TAHUN
                $KoreksiTglPensiun = mysqli_query($db, "UPDATE master_pegawai SET TanggalPensiun = '$TanggalPensiun'
                        WHERE IdPegawaiFK = '$IdPegawaiFK' ");
            }

            if ($Edit) {
                // Check if IdPegawai parameter exists for redirect back to detail page
                if (isset($_GET['IdPegawai'])) {
                    $IdPegawai = sql_injeksi($_GET['IdPegawai']);
                    $tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab-5';
                    ob_end_clean(); // Clear output buffer
                    header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawai) . "&alert=Edit&tab=" . $tab);
                    exit();
                } else {
                    header("location:../../View/v?pg=ViewMutasiAdminDesa&alert=Edit");
                }
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'EditSK') {
        if (isset($_POST['EditSK'])) {
            $IdMutasi = sql_injeksi($_POST['IdMutasi']);

            //Atribut Upload File
            $FileMaxUpload = 2 * 1024 * 1024;
            $FileSize = $_FILES['FUpload']['size'];

            $TanggalAcak = date('Ymd');
            $LokasiFile = $_FILES['FUpload']['tmp_name'];
            $TipeFile = $_FILES['FUpload']['type'];
            $NamaFile = $_FILES['FUpload']['name'];
            $AllowExtention = array('pdf');
            $FileExtention = strtolower(end(explode('.', $NamaFile)));
            $Acak = rand(1, 99);
            $FileUpload = "afs_" . $TanggalAcak . "_" . $Acak . $NamaFile;
            $NamaFileLama = sql_injeksi($_POST['FileLama']);

            if ($FileSize <= $FileMaxUpload) {
                if (in_array($FileExtention, $AllowExtention) == true) {
                    // FileSK($FileUpload);
                    // $Edit = mysqli_query($db, "UPDATE history_mutasi SET FileSKMutasi = '$FileUpload'
                    //     WHERE IdMutasi ='$IdMutasi' ");

                    // NEW BLOB FILE
                    $FileContent = file_get_contents($_FILES['FUpload']['tmp_name']);
                    $FileContentEscaped = mysqli_real_escape_string($db, $FileContent);
                    $Edit = mysqli_query($db, "UPDATE history_mutasi SET FileSKMutasi = '$FileUpload',
                        FileSKMutasiBlob = '$FileContentEscaped'
                        WHERE IdMutasi ='$IdMutasi' ");

                    // unlink("../../Vendor/Media/FileSK/" . $NamaFileLama);

                    if (!empty($NamaFileLama) && file_exists("../../Vendor/Media/FileSK/" . $NamaFileLama)) {
                        unlink("../../Vendor/Media/FileSK/" . $NamaFileLama);
                    }

                    if ($Edit) {
                        header("location:../../View/v?pg=ViewMutasiAdminDesa&alert=Edit");
                    }
                } elseif (in_array($FileExtention, $AllowExtention) == false) {
                    header("location:../../View/v?pg=ViewMutasiAdminDesa&alert=Cek");
                }
            } else {
                header("location:../../View/v?pg=ViewMutasiAdminDesa&alert=FileMax");
            }
        }
    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'Delete') {
        if (isset($_GET['Kode'])) {
            $IdMutasi = sql_injeksi(($_GET['Kode']));

            // Langkah 1: Ambil data mutasi untuk mendapatkan ID Pegawai
            $PilihData = mysqli_query($db, "SELECT * FROM history_mutasi WHERE IdMutasi = '$IdMutasi' ");
            $DataPilih = mysqli_fetch_assoc($PilihData);
            $NamaFileLama = $DataPilih['FileSKMutasi'];
            
            // Asumsi nama kolom foreign key adalah IdPegawaiFK
            $IdPegawaiUntukKembali = $DataPilih['IdPegawaiFK']; 

            // Langkah 2: Proses hapus data
            $Delete = mysqli_query($db, "DELETE FROM history_mutasi WHERE IdMutasi = '$IdMutasi' ");
            
            // Hapus file jika ada
            if (!empty($NamaFileLama) && file_exists("../../Vendor/Media/FileSK/" . $NamaFileLama)) {
                unlink("../../Vendor/Media/FileSK/" . $NamaFileLama);
            }

            if ($Delete) {
                // Check if IdPegawai parameter exists for redirect back to detail page
                if (isset($_GET['IdPegawai'])) {
                    $IdPegawai = sql_injeksi($_GET['IdPegawai']);
                    $tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab-5';
                    ob_end_clean(); // Clear output buffer
                    header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawai) . "&alert=Delete&tab=" . $tab);
                    exit();
                } else {
                    // Langkah 3: Redirect kembali ke halaman DETAIL PEGAWAI
                    ob_end_clean(); // Clear output buffer
                    header("location:../../View/v?pg=PegawaiDetailAdminDesa&Kode=" . sql_url($IdPegawaiUntukKembali) . "&alert=Delete&tab=tab-5");
                    exit(); // PENTING: Tambahkan exit() untuk menghentikan skrip
                }
            }
        }

    } elseif (isset($_GET['Act']) && $_GET['Act'] == 'SettingOn') {
        if (isset($_GET['Kode'])) {
            $IdTemp = sql_injeksi(($_GET['Kode']));

            $Filter = mysqli_query($db, "SELECT * FROM history_mutasi WHERE IdMutasi = '$IdTemp' ");
            $DataFilter = mysqli_fetch_assoc($Filter);
            $FilterPegawai = $DataFilter['IdPegawaiFK'];

            $AmbilPegawai = mysqli_query($db, "SELECT * FROM history_mutasi");
            while ($DapatPegawai = mysqli_fetch_assoc($AmbilPegawai)) {
                $Koreksi = mysqli_query($db, "UPDATE history_mutasi SET Setting = 0 WHERE IdPegawaiFK = '$FilterPegawai' ");
            }

            $SettingOn = 1;
            $SettingAktif = mysqli_query($db, "UPDATE history_mutasi SET Setting = '$SettingOn'
            WHERE IdMutasi = '$IdTemp' ");

            $StatusAktif = mysqli_query($db, "UPDATE main_user SET Status = '$SettingOn',
            StatusLogin = '$SettingOn'
            WHERE IdPegawai = '$FilterPegawai' ");

            $StatusAktifPegawai = mysqli_query($db, "UPDATE master_pegawai SET Setting = '$SettingOn'
            WHERE IdPegawaiFK = '$FilterPegawai' ");

            if ($SettingAktif) {
                header("location:../../View/v?pg=ViewMutasiAdminDesa&alert=Setting");
            }
        }
    }
}
