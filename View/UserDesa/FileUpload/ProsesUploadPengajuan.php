<?php
include '../../../Module/Config/Env.php';

$$idDesa = isset($_POST['iddesa']) ? sql_injeksi($_POST['iddesa']) : '';
$$idPegawai = isset($_POST['idpegawai']) ? sql_injeksi($_POST['idpegawai']) : '';

$qNama = mysqli_query($db, "SELECT p.Nama, p.NIK, d.NamaDesa, d.IdKecamatanFK, k.Kecamatan 
FROM master_Pegawai p 
LEFT JOIN master_desa d ON d.IdDesa = p.IdDesaFK
LEFT JOIN master_kecamatan k on d.IdKecamatanFK = k.IdKecamatan 
WHERE p.IdPegawaiFK = '$idPegawai' AND p.IdDesaFK = '$idDesa'");
$d = mysqli_fetch_assoc($qNama);
$namaPegawai = $d['Nama'];
$nik = $d['NIK'];
$namaDesa = $d['NamaDesa'];
$kecamatan = $d['Kecamatan'];
$unitKerja = $namaDesa . ' - ' . $kecamatan;

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
$safeNama = preg_replace("/[^a-zA-Z0-9]/", "_", $namaPegawai);
$safeUnitKerja = preg_replace("/[^a-zA-Z0-9_]/", "_", $unitKerja);
$newFileName = "Pengajuan_Pensiun_{$safeNama}_{$nik}_{$safeUnitKerja}_{$randomStr}.pdf";

$qInsertFile = mysqli_query($db, "INSERT INTO file
        (Nama, Ekstensi, FileBlob, IdDesaFK, IdFileKategoriFK, IdLevelFileFK) 
        VALUES ('$newFileName', '$ext', '$binaryData', '$idDesa', 0, 3)");

if ($qInsertFile) {
    $idFile = mysqli_insert_id($db);

    $qUpdate = mysqli_query($db, "UPDATE master_pegawai 
            SET IdFilePengajuanPensiunFK = '$idFile', 
                StatusPensiunDesa = NULL, 
                StatusPensiunKecamatan = NULL, 
                StatusPensiunKabupaten = NULL
            WHERE IdPegawaiFK = '$idPegawai' AND IdDesaFK = '$idDesa'");

    if ($qUpdate) {
        header("Location: ../../v?pg=User&alert=UploadSukses");
        exit();
    } else {
        header("Location: ../../v?pg=User&alert=UploadGagalPegawai");
        exit();
    }
} else {
    header("Location: ../../v?pg=User&alert=UploadGagalDB");
    exit();
}


?>