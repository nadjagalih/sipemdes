<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../../Module/Config/Env.php'; // or adjust path to your DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['IdPegawaiFK'])) {
    $IdPegawai = mysqli_real_escape_string($db, $_POST['IdPegawaiFK']);

    if (isset($_POST['setujui'])) {
        $status = 1;
    } elseif (isset($_POST['tolak'])) {
        $status = 0;
    }

    $update = mysqli_query($db, "UPDATE master_pegawai SET StatusPensiunKabupaten = $status WHERE IdPegawaiFK = '$IdPegawai'");

    if ($update) {
        if($status === 1) {
            header("Location: ../../v?pg=AddMutasi&Kode=$IdPegawai&TipeMutasi=3");
        } else {
            header("Location: ../../v?pg=SAdmin&alert=Ditolak");
        }
        exit();
    } else {
        header("Location: ../../v?pg=SAdmin&alert=Gagal");
        exit();
    }
} else {
    echo "Akses tidak valid.";
}
?>