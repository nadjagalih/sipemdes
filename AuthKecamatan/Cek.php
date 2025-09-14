<?php
require_once "../Module/Config/Env.php";

session_start();

// Get credentials from session
if (isset($_SESSION['temp_username']) && isset($_SESSION['temp_password'])) {
    $username = sql_injeksi($_SESSION['temp_username']);
    $password = sql_injeksi($_SESSION['temp_password']);

    // Clear temporary session data
    unset($_SESSION['temp_username']);
    unset($_SESSION['temp_password']);
    unset($_SESSION['temp_unit']);
} else {
    $_SESSION['login_error'] = 'Terjadi kesalahan sistem, silakan coba lagi';
    header("Location: ../main.php");
    exit;
}

if (empty($username) || !ctype_alnum($username)) {
	$_SESSION['login_error'] = 'Username tidak boleh kosong atau mengandung karakter khusus';
	header("Location: ../main.php");
	exit;
} else {
	$sql = mysqli_query($db, "SELECT
	main_user_kecamatan.IdUser,
	main_user_kecamatan.NameAkses,
	main_user_kecamatan.NamePassword,
	main_user_kecamatan.IdLevelUserFK,
	main_user_kecamatan.Status,
	main_user_kecamatan.IdKecamatanFK,
	main_user_kecamatan.StatusLogin
	FROM
	main_user_kecamatan
	WHERE main_user_kecamatan.NameAkses = '$username' ");

	if (mysqli_num_rows($sql) > 0) {
		$data = mysqli_fetch_assoc($sql);

		if (password_verify($password, $data['NamePassword'])) {
			// Password correct, check account status
			if ($data['StatusLogin'] == 0) {
				$_SESSION['login_error'] = 'Akun Anda tidak aktif. Hubungi administrator';
				header("Location: ../main.php");
				exit;
			} elseif ($data['StatusLogin'] == 1) {
				// Login successful, set session
				login_validate();

				$_SESSION['IdUser'] 		= $data['IdUser'];
				$_SESSION['NameUser'] 		= $data['NameAkses'];
				$_SESSION['PassUser'] 		= $data['NamePassword'];
				$_SESSION['Setting'] 		= $data['Status'];
				$_SESSION['IdLevelUserFK'] 	= $data['IdLevelUserFK'];
				$_SESSION['Status'] 		= $data['StatusLogin'];
				$_SESSION['IdKecamatan']	= $data['IdKecamatanFK'];

				unset($_SESSION['visited_pensiun_kecamatan']);

				if ($data['IdLevelUserFK'] == 4) {
					header("Location: ../View/v?pg=Kecamatan");
				} else {
					$_SESSION['login_error'] = 'Level akses tidak valid';
					header("Location: ../main.php");
				}
				exit;
			}
		} else {
			// Password incorrect
			$_SESSION['login_error'] = 'Username atau password salah';
			header("Location: ../main.php");
			exit;
		}
	} else {
		// User not found
		$_SESSION['login_error'] = 'Username atau password salah';
		header("Location: ../main.php");
		exit;
	}
}
?>


<!-- Proses Untuk Logout Otomatis -->
<?php
$tanggal = date("Y-m-d H:i:s");

//fungsi untuk Logout otomatis
function login_validate()
{
	//ukuran waktu dalam detik
	$timer = 10;
	//untuk menambah masa validasi
	$_SESSION["expires_by"] = time() + $timer;
}

function login_check()
{
	//berfungsi untuk mengambil nilai dari session yang pertama
	$exp_time = $_SESSION["expires_by"];

	//jika waktu sistem lebih kecil dari nilai waktu session
	if (time() < $exp_time) {
		//panggil fungsi dan tambah waktu session
		login_validate();
		return true;
	} else {
		//jika waktu session lebih kecil dari waktu session atau lewat batas
		//maka akan dilakukan unset session
		unset($_SESSION["expires_by"]);
		return false;
	}
}
?>