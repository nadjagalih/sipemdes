<?php
class cek_sql_injeksi
{
	function __construct()
	{
	}

	function validasi($str, $tipe)
	{
		switch ($tipe) {
			default:
			case 'sql':
				$str = stripcslashes($str);
				$str = htmlspecialchars($str);
				$str = strip_tags($str);
				$str = preg_replace('/[^A-Za-z0-9]/', '', $str);
				return intval($str);
			case 'xss':
				$str = stripcslashes($str);
				$str = htmlspecialchars($str);
				$str = strip_tags($str);
				$str = preg_replace('/[\W]/', '', $str);
				return $str;
		}
	}

	function extension($path)
	{
		$file = pathinfo($path);
		if (file_exists($file['dirname'] . '/' . $file['basename'])) {
			return $file['basename'];
		}
	}
}
