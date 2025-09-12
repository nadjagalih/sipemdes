<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include "../Config/Env.php";

$Direktori = "../../Vendor/Media/FileSK/"; // folder tempat penyimpanan file yang boleh didownload
$FileName = $_GET['File'];

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
	echo "<h1>Access forbidden!</h1>
			<p>Maaf, file yang Anda download sudah tidak tersedia xxx. <br /></p>";
	exit;
}
