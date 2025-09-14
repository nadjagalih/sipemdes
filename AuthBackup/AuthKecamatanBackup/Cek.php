<?php
require_once "../Module/Config/Env.php";

$username = sql_injeksi($_POST['NameAkses']);
$password = sql_injeksi($_POST['NamePassword']);

if (!ctype_alnum($username)) {
	header("Location: SignIn?alert=Kosong");
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
	$data = mysqli_fetch_assoc($sql);

	if (mysqli_num_rows($sql) > 0) {
		if (password_verify($password, $data['NamePassword'])) {

			session_start();

			// Fungsi Logout Automatis
			login_validate();

			$_SESSION['IdUser'] 		= $data['IdUser'];
			$_SESSION['NameUser'] 		= $data['NameAkses'];
			$_SESSION['PassUser'] 		= $data['NamePassword'];
			$_SESSION['Setting'] 		= $data['Status'];
			$_SESSION['IdLevelUserFK'] 	= $data['IdLevelUserFK'];
			$_SESSION['Status'] 		= $data['StatusLogin'];
			$_SESSION['IdKecamatan']	= $data['IdKecamatanFK'];

			unset($_SESSION['visited_pensiun_kecamatan']);

			if ($data['StatusLogin'] == 0) {
				header("Location: SignIn?alert=Status");
			} elseif ($data['StatusLogin'] == 1) {
				if ($data['IdLevelUserFK'] == 4) {
					header("Location: ../View/v?pg=Kecamatan");
				}
			}
		} else {
			header("Location: SignIn?alert=Cek");
		}
	} else {
		header("Location: SignIn?alert=Cek");
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