<?php
session_start();

include "../../Module/Config/Env.php";

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    header("location: ../../Auth/SignIn?alert=SignOutTime");
    exit();
}

if (isset($_GET['Act']) && $_GET['Act'] == 'Edit' && isset($_POST['Edit'])) {
    // Get and sanitize form data
    $IdUser = sql_injeksi($_POST['IdUser']);
    $UserNama = sql_injeksi($_POST['UserNama']);
    $Akses = sql_injeksi($_POST['Akses']);
    $Nama = sql_injeksi($_POST['Nama']);
    $UnitKerja = sql_injeksi($_POST['UnitKerja']);
    $Status = sql_injeksi($_POST['Status']);
    
    // Update main_user table
    $query1 = "UPDATE main_user SET NameAkses = '$UserNama', IdLevelUserFK = '$Akses', StatusLogin = '$Status' WHERE IdUser = '$IdUser'";
    $result1 = mysqli_query($db, $query1);
    
    // Update master_pegawai table
    $query2 = "UPDATE master_pegawai SET IdDesaFK = '$UnitKerja', Nama = '$Nama' WHERE IdPegawaiFK = '$IdUser'";
    $result2 = mysqli_query($db, $query2);
    
    if ($result1 && $result2) {
        // Success - redirect langsung tanpa halaman debug
        header("Location: ../../View/v?pg=UserView&success=edit");
        exit();
    } else {
        // Error - redirect back dengan pesan error
        header("Location: ../../View/v?pg=UserEdit&Kode=$IdUser&error=1");
        exit();
    }
}
?>