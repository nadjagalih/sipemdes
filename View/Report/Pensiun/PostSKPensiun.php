<?php
// IIRC THIS FILE IS DEAD SINCE THE PENSIUN STUFF IS HANDLED BY MUTASI STUFF.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../../../Module/Config/Env.php";

if (isset($_POST['upload'])) {
    $idPegawai = $_POST['idpegawai'];
    $nama = $_POST['namapegawai'];
    $nik = $_POST['nik'];
    $unitKerja = $_POST['unitkerja'];
    $idDesa = $_POST['iddesa'];

    $file = $_FILES['file'];
    $filename = $file['name'];
    $tmp_name = $file['tmp_name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if ($file['error'] !== 0 || $ext !== 'pdf') {
        die('File error or not a PDF');
    }
    
    $binaryData = file_get_contents($tmp_name);
    $binaryData = mysqli_real_escape_string($db, $binaryData);

    $randomStr = substr(md5(uniqid(rand(), true)), 0, 5);
    $safeNama = preg_replace("/[^a-zA-Z0-9]/", "_", $nama);
    $safeUnitKerja = preg_replace("/[^a-zA-Z0-9_]/", "_", $unitKerja);
    $newFileName = "SK_Pensiun_{$safeNama}_{$nik}_{$safeUnitKerja}_{$randomStr}.pdf";


    $qInsertFile = mysqli_query($db, "INSERT INTO file
        (Nama, Ekstensi, FileBlob, IdDesaFK, IdFileKategoriFK, IdLevelFileFK) 
        VALUES ('$newFileName', '$ext', '$binaryData', '$idDesa', 0, 3)");

    if ($qInsertFile) {
        $idFile = mysqli_insert_id($db);

        $qUpdate = mysqli_query($db, "UPDATE master_pegawai 
            SET IdFileSKPensiunFK = '$idFile',
                Setting = '0'
            WHERE IdPegawaiFK = '$idPegawai' AND IdDesaFK = '$idDesa'");

        if ($qUpdate) {
            header("Location: ../../v?pg=ViewPensiun&alert=UploadSukses");
            exit();
        } else {
            header("Location: ../../v?pg=ViewMasaPensiunKades&alert=UploadGagalPegawai");
            exit();
        }
    } else {
        header("Location: ../../v?pg=ViewMasaPensiunKades&alert=UploadGagalDB");
        exit();
    }

}
?>