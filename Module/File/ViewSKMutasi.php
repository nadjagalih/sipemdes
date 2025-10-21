<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../Config/Env.php';

if (!isset($_GET['id'])) {
    die("Missing ID parameter.");
}

$id = intval($_GET['id']);

// Query untuk mendapatkan file SK dari history_mutasi
$q = mysqli_query($db, "SELECT 
    FileSKMutasi, 
    NomorSK,
    TanggalMutasi,
    FileSKMutasiBlob
    FROM history_mutasi 
    WHERE IdMutasi = $id");

if (!$q || mysqli_num_rows($q) === 0) {
    die("Data mutasi tidak ditemukan.");
}

$row = mysqli_fetch_assoc($q);
$filename = $row['FileSKMutasi'];
$fileBlob = $row['FileSKMutasiBlob'];

// Jika ada BLOB data, gunakan itu
if (!empty($fileBlob)) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    // Set headers untuk preview/view file tanpa download
    if ($extension === 'pdf') {
        header("Content-Type: application/pdf");
        header("Content-Disposition: inline; filename=\"" . basename($filename) . "\"");
    } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
        header("Content-Type: image/" . $extension);
        header("Content-Disposition: inline; filename=\"" . basename($filename) . "\"");
    } else {
        // For other file types
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: inline; filename=\"" . basename($filename) . "\"");
    }
    
    header("Cache-Control: public");
    header("Expires: " . gmdate("D, d M Y H:i:s", time() + 3600) . " GMT");
    
    // Output file content dari BLOB
    echo $fileBlob;
    exit;
}

// Jika tidak ada BLOB, coba cari file fisik
if (!empty($filename)) {
    $direktori = "../../Vendor/Media/FileSK/";
    $fullPath = $direktori . $filename;
    
    // Decode URL encoding untuk menangani spasi dan karakter khusus
    $decodedFilename = urldecode($filename);
    $decodedPath = $direktori . $decodedFilename;
    
    // Cek apakah file ada (dengan nama asli atau decoded)
    if (file_exists($fullPath)) {
        $filePath = $fullPath;
    } elseif (file_exists($decodedPath)) {
        $filePath = $decodedPath;
    } else {
        // Cari file dengan nama yang mirip
        $files = scandir($direktori);
        $foundFile = false;
        
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') continue;
            
            // Cari berdasarkan similarity
            if (stripos($file, basename($filename, '.pdf')) !== false ||
                similar_text(strtolower($file), strtolower($filename)) > (strlen($filename) * 0.7)) {
                $foundFile = $direktori . $file;
                break;
            }
        }
        
        if ($foundFile) {
            $filePath = $foundFile;
        } else {
            // File tidak ditemukan
            echo "<h1>File SK Tidak Ditemukan</h1>";
            echo "<p>File SK Mutasi tidak dapat ditemukan.</p>";
            echo "<p><strong>File yang dicari:</strong> " . htmlspecialchars($filename) . "</p>";
            echo "<p><strong>Nomor SK:</strong> " . htmlspecialchars($row['NomorSK']) . "</p>";
            echo "<p><strong>Tanggal Mutasi:</strong> " . htmlspecialchars($row['TanggalMutasi']) . "</p>";
            echo "<p>Silakan hubungi administrator untuk mengatasi masalah ini.</p>";
            exit;
        }
    }
    
    // Jika file ditemukan, tampilkan
    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    
    // Set headers untuk preview/view file
    if ($extension === 'pdf') {
        header("Content-Type: application/pdf");
    } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
        header("Content-Type: image/" . $extension);
    } else {
        header("Content-Type: application/octet-stream");
    }
    
    header("Content-Disposition: inline; filename=\"" . basename($filePath) . "\"");
    header("Cache-Control: public");
    header("Expires: " . gmdate("D, d M Y H:i:s", time() + 3600) . " GMT");
    header("Content-Length: " . filesize($filePath));
    
    // Output file content
    readfile($filePath);
    exit;
}

// Jika tidak ada file sama sekali
echo "<h1>File SK Tidak Tersedia</h1>";
echo "<p>File SK Mutasi tidak tersedia untuk data ini.</p>";
echo "<p><strong>Nomor SK:</strong> " . htmlspecialchars($row['NomorSK']) . "</p>";
echo "<p><strong>Tanggal Mutasi:</strong> " . htmlspecialchars($row['TanggalMutasi']) . "</p>";
exit;
?>
