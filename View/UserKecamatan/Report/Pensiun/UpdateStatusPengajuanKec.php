<?php
session_start();
include '../../../../Module/Config/Env.php'; // or adjust path to your DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['IdPegawaiFK'])) {
    $IdPegawai = mysqli_real_escape_string($db, $_POST['IdPegawaiFK']);

    if (isset($_POST['setujui'])) {
        $status = 1;
    } elseif (isset($_POST['tolak'])) {
        $status = 0;
    }

    $update = mysqli_query($db, "UPDATE master_pegawai SET StatusPensiunKecamatan = $status WHERE IdPegawaiFK = '$IdPegawai'");

    if ($update) {
        header("Location: ../../../v?pg=Kecamatan&alert=Sukses");
        exit();
    } else {
        header("Location: ../../../v?pg=Kecamatan&alert=Sukses");
    }
} else {
    echo "Akses tidak valid.";
}
?>