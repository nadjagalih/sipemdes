<?php
include '../../../Module/Config/Env.php';

$idDesa = isset($_POST['iddesa']) ? sql_injeksi($_POST['iddesa']) : '';
$idPegawai = isset($_POST['idpegawai']) ? sql_injeksi($_POST['idpegawai']) : '';

$qNama = mysqli_query($db, "SELECT p.Nama, p.NIK, d.NamaDesa, d.IdKecamatanFK, k.Kecamatan 
FROM master_Pegawai p 
LEFT JOIN master_desa d ON d.IdDesa = p.IdDesaFK
LEFT JOIN master_kecamatan k on d.IdKecamatanFK = k.IdKecamatan 
WHERE p.IdPegawaiFK = '$idPegawai' AND p.IdDesaFK = '$idDesa'");

if (!$qNama) {
    die('Database query error: ' . mysqli_error($db));
}

$d = mysqli_fetch_assoc($qNama);

if (!$d) {
    die('Data pegawai tidak ditemukan');
}

$namaPegawai = isset($d['Nama']) ? $d['Nama'] : '';
$nik = isset($d['NIK']) ? $d['NIK'] : '';
$namaDesa = isset($d['NamaDesa']) ? $d['NamaDesa'] : '';
$kecamatan = isset($d['Kecamatan']) ? $d['Kecamatan'] : '';
$unitKerja = $namaDesa . ' - ' . $kecamatan;

$file = $_FILES['file'];

// Validate file upload
if (!isset($file) || !is_array($file)) {
    die('No file uploaded');
}

$filename = isset($file['name']) ? $file['name'] : '';
$tmp_name = isset($file['tmp_name']) ? $file['tmp_name'] : '';
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
    
    // Verify the file was inserted correctly
    if ($idFile <= 0) {
        header("Location: ../../v.php?pg=User&alert=UploadGagalDB");
        exit();
    }

    $qUpdate = mysqli_query($db, "UPDATE master_pegawai 
            SET IdFilePengajuanPensiunFK = '$idFile', 
                StatusPensiunDesa = NULL, 
                StatusPensiunKecamatan = NULL, 
                StatusPensiunKabupaten = NULL
            WHERE IdPegawaiFK = '$idPegawai' AND IdDesaFK = '$idDesa'");

    if ($qUpdate && mysqli_affected_rows($db) > 0) {
        // Success - redirect with success alert
        header("Location: ../../v.php?pg=User&alert=UploadSukses");
        exit();
    } else {
        // Failed to update employee record or no rows affected
        header("Location: ../../v.php?pg=User&alert=UploadGagalPegawai");
        exit();
    }
} else {
    // Failed to insert file to database
    $error = mysqli_error($db);
    // For debugging: log the error or display it
    error_log("Database error in file upload: " . $error);
    header("Location: ../../v.php?pg=User&alert=UploadGagalDB");
    exit();
}


?>