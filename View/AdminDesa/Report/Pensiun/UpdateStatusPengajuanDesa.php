<?php
session_start();
include '../../../../Module/Config/Env.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['IdPegawaiFK'])) {
    $IdPegawai = mysqli_real_escape_string($db, $_POST['IdPegawaiFK']);

    if (isset($_POST['setujui'])) {
        $status = 1;
    } elseif (isset($_POST['tolak'])) {
        $status = 0;
    }

    $update = mysqli_query($db, "UPDATE master_pegawai SET StatusPensiunDesa = $status WHERE IdPegawaiFK = '$IdPegawai'");

    if ($update) {
        header("Location: ../../../v?pg=Admin&alert=Sukses");
        exit();
    } else {
        header("Location: ../../../v?pg=Admin&alert=Sukses");
    }
} else {
    echo "Akses tidak valid.";
}
?>