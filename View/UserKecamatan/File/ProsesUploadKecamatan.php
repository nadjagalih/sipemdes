<?php
include '../../../Module/Config/Env.php'; // adjust as needed

$kategori = $_POST['kategori'];
$nama = $_POST['namafile'];
$iddesa = $_POST['iddesa'];
$idkecamatan = $_POST['idkecamatan'];
$file = $_FILES['file'];

// Get desa name and kecamatan id
$q = mysqli_query($db, "SELECT NamaDesa FROM master_desa WHERE IdDesa='$iddesa'");
$d = mysqli_fetch_assoc($q);
$desaName = preg_replace('/\s+/', '', $d['NamaDesa']);

// Validate file type
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$allowed = ['pdf'];
if (!in_array(strtolower($ext), $allowed)) {
    header("Location: ../../v?pg=FileViewKecamatan&alert=FileExt");
}

// Read file contents
$tmpPath = $file['tmp_name'];
$binaryData = file_get_contents($tmpPath);
$binaryData = mysqli_real_escape_string($db, $binaryData);
if (empty($iddesa)) {
    $sql = "INSERT INTO file (Nama, Ekstensi, FileBlob, IdFileKategoriFK, IdKecamatanFK, IdLevelFileFK)
            VALUES ('$nama', '$ext', '$binaryData', '$kategori', '$idkecamatan', 2)";
} else {
    $sql = "INSERT INTO file (Nama, Ekstensi, FileBlob, IdFileKategoriFK, IdDesaFK, IdLevelFileFK)
            VALUES ('$nama', '$ext', '$binaryData', '$kategori', '$iddesa', 3)";
}

$maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
if ($file['size'] <= $maxFileSize) {
    if (mysqli_query($db, $sql)) {
        header("Location: ../../v?pg=FileViewKecamatan&alert=UploadSukses");
        exit();
    } else {
        echo "Database error: " . mysqli_error($db);
    }
} else {
    header("Location: ../../v?pg=FileViewKecamatan&alert=FileMax");
}

?>