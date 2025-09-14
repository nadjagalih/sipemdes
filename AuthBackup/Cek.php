<?php
require_once "../Module/Config/Env.php";

$username = sql_injeksi($_POST['NameAkses']);
$password = sql_injeksi($_POST['NamePassword']);

if (!ctype_alnum($username)) {
	header("Location: SignIn?alert=Kosong");
} else {
	$sql = mysqli_query($db, "SELECT
	main_user.IdUser,
	main_user.NameAkses,
	main_user.NamePassword,
	main_user.IdLevelUserFK,
	main_user.Status,
	main_user.IdPegawai,
	main_user.StatusLogin,
	master_pegawai.IdPegawaiFK,
	master_pegawai.IdDesaFK
	FROM
	main_user
	INNER JOIN master_pegawai ON main_user.IdPegawai = master_pegawai.IdPegawaiFK
	WHERE main_user.NameAkses = '$username' ");
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
			$_SESSION['IdPegawai']		= $data['IdPegawai'];
			$_SESSION['IdDesa']			= $data['IdDesaFK'];

			unset($_SESSION['visited_pensiun_perangkat']);
			unset($_SESSION['visited_pensiun_sadmin']);

			if ($data['StatusLogin'] == 0) {
				header("Location: SignIn?alert=Status");
			} elseif ($data['StatusLogin'] == 1) {

				if ($data['IdLevelUserFK'] == 1) {
					header("Location: ../View/v?pg=SAdmin");
				} elseif ($data['IdLevelUserFK'] == 2) {
					header("Location: ../View/v?pg=Admin");
				} elseif ($data['IdLevelUserFK'] == 3) {
					header("Location: ../View/v?pg=User");
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