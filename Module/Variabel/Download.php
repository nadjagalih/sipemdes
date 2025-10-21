<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include "../Config/Env.php";

$Direktori = "../../Vendor/Media/FileSK/"; // folder tempat penyimpanan file yang boleh didownload
$FileName = $_GET['File'];

// Decode URL encoding untuk menangani spasi dan karakter khusus
$FileName = urldecode($FileName);

// Sanitasi nama file untuk keamanan
$FileName = basename($FileName);

// Debug logging
error_log("Download request - File: " . $FileName);
error_log("Download request - Full path: " . $Direktori . $FileName);
error_log("Download request - File exists: " . (file_exists($Direktori . $FileName) ? 'YES' : 'NO'));

if (file_exists($Direktori . $FileName)) {
	$file_extension = strtolower(substr(strrchr($FileName, "."), 1));

	switch ($file_extension) {
		case "pdf":
			$ctype = "application/pdf";
			break;
		case "exe":
			$ctype = "application/octet-stream";
			break;
		case "zip":
			$ctype = "application/zip";
			break;
		case "rar":
			$ctype = "application/rar";
			break;
		case "doc":
			$ctype = "application/msword";
			break;
		case "xls":
			$ctype = "application/vnd.ms-excel";
			break;
		case "ppt":
			$ctype = "application/vnd.ms-powerpoint";
			break;
		case "gif":
			$ctype = "image/gif";
			break;
		case "png":
			$ctype = "image/png";
			break;
		case "jpeg":
			$ctype = "image/jpeg";
			break;
		case "jpg":
			$ctype = "image/jpg";
			break;
			// default:
			// 	$ctype = "application/proses";
	}

	if ($file_extension == 'php' and $file_extension == 'py') {
		echo "<h1>Access forbidden!</h1>
			<p>Maaf, file yang Anda download sudah tidak tersedia.</p>";
		exit;

		//Dengan Download
	} else {
		// mysqli_query($db, "update download set hits=hits+1 where nama_file='$FileName'");

		header("Content-Type: octet/stream");
		header("Pragma: private");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false);
		header("Content-Type: $ctype");
		//header("Content-Disposition: attachment; filename=\"" . basename($FileName) . "\";");
		header("Content-Disposition: inline; filename=\"" . basename($FileName) . "\";");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . filesize($Direktori . $FileName));
		readfile("$Direktori$FileName");
		exit();
	}
} else {
	// Log error untuk debugging
	error_log("File not found: " . $Direktori . $FileName);
	
	// Cek apakah direktori ada
	if (!is_dir($Direktori)) {
		error_log("Directory does not exist: " . $Direktori);
		echo "<h1>File Tidak Ditemukan!</h1>
				<p>Maaf, direktori file tidak ditemukan.</p>
				<p>Silakan hubungi administrator sistem.</p>";
	} else {
		// Cari file dengan nama yang mirip (tanpa spasi atau karakter khusus)
		$cleanFileName = preg_replace('/[^a-zA-Z0-9._-]/', '', $FileName);
		$files = scandir($Direktori);
		$foundSimilar = false;
		
		foreach ($files as $file) {
			if ($file == '.' || $file == '..') continue;
			
			$cleanFile = preg_replace('/[^a-zA-Z0-9._-]/', '', $file);
			
			// Cari berdasarkan prefix tanggal (afs_YYYYMMDD)
			$requestedPrefix = '';
			if (preg_match('/^afs_(\d{8})_/', $FileName, $matches)) {
				$requestedPrefix = $matches[1];
				if (strpos($file, 'afs_' . $requestedPrefix) !== false) {
					$foundSimilar = $file;
					break;
				}
			}
			
			// Cari berdasarkan nama file yang mirip
			if (stripos($cleanFile, $cleanFileName) !== false || 
				stripos($file, $FileName) !== false ||
				similar_text(strtolower($file), strtolower($FileName)) > (strlen($FileName) * 0.7)) {
				$foundSimilar = $file;
				break;
			}
		}
		
		if ($foundSimilar && $foundSimilar != '.' && $foundSimilar != '..') {
			error_log("Found similar file: " . $foundSimilar . " for requested: " . $FileName);
			// Redirect ke file yang ditemukan
			header("Location: ?File=" . urlencode($foundSimilar));
			exit;
		}
		
		// List files in directory untuk debugging
		error_log("Files in directory: " . implode(', ', array_slice($files, 0, 10)));
		
		// Cari file dengan tanggal yang sama untuk ditampilkan sebagai alternatif
		$alternativeFiles = [];
		if (preg_match('/^afs_(\d{8})_/', $FileName, $matches)) {
			$requestedDate = $matches[1];
			foreach ($files as $file) {
				if ($file == '.' || $file == '..') continue;
				if (strpos($file, 'afs_' . $requestedDate) !== false) {
					$alternativeFiles[] = $file;
				}
			}
		}
		
		echo "<h1>File Tidak Ditemukan!</h1>
				<p>Maaf, file SK yang Anda cari tidak tersedia.</p>
				<p><strong>File yang dicari:</strong> " . htmlspecialchars($FileName) . "</p>";
		
		if (!empty($alternativeFiles)) {
			echo "<p><strong>File alternatif dengan tanggal yang sama:</strong></p>
					<ul>";
			foreach (array_slice($alternativeFiles, 0, 5) as $altFile) {
				echo "<li><a href='?File=" . urlencode($altFile) . "' target='_blank'>" . htmlspecialchars($altFile) . "</a></li>";
			}
			echo "</ul>";
		}
		
		echo "<p><strong>Kemungkinan penyebab:</strong></p>
				<ul>
					<li>File belum diupload ke sistem</li>
					<li>File telah dihapus atau dipindahkan</li>
					<li>Nama file di database tidak sesuai dengan file fisik</li>
				</ul>
				<p>Silakan hubungi administrator untuk mengatasi masalah ini.</p>";
	}
	exit;
}
