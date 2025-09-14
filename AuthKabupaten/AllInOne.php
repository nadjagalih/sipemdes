<?php
/**
 * All-in-One Login - SIPEMDES AuthKabupaten
 * Form dan proses login dalam satu file untuk mengatasi masalah form submission
 */

require_once "../Module/Config/Env.php";

$message = '';
$messageType = '';
$debug_info = '';

// Proses login jika ada POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    $debug_info .= "✅ POST Request diterima<br>";

    $username = sql_injeksi($_POST['NameAkses'] ?? '');
    $password = sql_injeksi($_POST['NamePassword'] ?? '');

    $debug_info .= "Username: '$username'<br>";
    $debug_info .= "Password: '$password'<br>";

    if (empty(trim($username)) || empty(trim($password))) {
        $message = 'Username atau password tidak boleh kosong!';
        $messageType = 'error';
        $debug_info .= "❌ Validasi gagal: field kosong<br>";
    } else {
        $debug_info .= "✅ Validasi berhasil<br>";

        // Query database
        $sql = mysqli_query($db, "SELECT
            main_user.IdUser,
            main_user.NameAkses,
            main_user.NamePassword,
            main_user.IdLevelUserFK,
            main_user.Status,
            main_user.IdPegawai,
            main_user.StatusLogin,
            master_pegawai.IdPegawaiFK,
            master_pegawai.IdDesaFK,
            master_pegawai.Nama
            FROM main_user
            INNER JOIN master_pegawai ON main_user.IdPegawai = master_pegawai.IdPegawaiFK
            WHERE main_user.NameAkses = '$username'");

        $debug_info .= "Query executed: " . mysqli_num_rows($sql) . " hasil<br>";

        if (mysqli_num_rows($sql) > 0) {
            $data = mysqli_fetch_assoc($sql);
            $debug_info .= "✅ User ditemukan: " . $data['Nama'] . "<br>";
            $debug_info .= "Level: " . $data['IdLevelUserFK'] . "<br>";
            $debug_info .= "Status: " . $data['StatusLogin'] . "<br>";

            if (password_verify($password, $data['NamePassword'])) {
                $debug_info .= "✅ Password verify berhasil<br>";

                if ($data['StatusLogin'] == 0) {
                    $message = 'User sudah tidak aktif!';
                    $messageType = 'error';
                    $debug_info .= "❌ User tidak aktif<br>";
                } else {
                    if ($data['IdLevelUserFK'] == 1 || $data['IdLevelUserFK'] == 2) {
                        // Set session
                        session_start();
                        $_SESSION['IdUser'] = $data['IdUser'];
                        $_SESSION['NameUser'] = $data['NameAkses'];
                        $_SESSION['PassUser'] = $data['NamePassword'];
                        $_SESSION['Setting'] = $data['Status'];
                        $_SESSION['IdLevelUserFK'] = $data['IdLevelUserFK'];
                        $_SESSION['Status'] = $data['StatusLogin'];
                        $_SESSION['IdPegawai'] = $data['IdPegawai'];
                        $_SESSION['IdDesa'] = $data['IdDesaFK'];

                        $debug_info .= "✅ Session berhasil di-set<br>";

                        // Redirect berdasarkan level
                        if ($data['IdLevelUserFK'] == 1) {
                            $debug_info .= "🎯 Redirect ke Super Admin dashboard<br>";
                            header("Location: ../View/v?pg=SAdmin");
                            exit;
                        } else {
                            $debug_info .= "🎯 Redirect ke Admin Kabupaten dashboard<br>";
                            header("Location: ../View/v?pg=Dashboard");
                            exit;
                        }
                    } else {
                        $message = 'Level user tidak sesuai untuk akses Kabupaten!';
                        $messageType = 'error';
                        $debug_info .= "❌ Level tidak sesuai: " . $data['IdLevelUserFK'] . "<br>";
                    }
                }
            } else {
                $message = 'Password salah!';
                $messageType = 'error';
                $debug_info .= "❌ Password verify gagal<br>";
            }
        } else {
            $message = 'Username tidak ditemukan!';
            $messageType = 'error';
            $debug_info .= "❌ User tidak ditemukan<br>";
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPEMDES | Kab. Trenggalek</title>
    <link href="../Vendor/Media/Logo/Pemkab.png" type="image/x-icon" rel="icon">
    <link href="../Vendor/Assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Vendor/Assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../Vendor/Assets/css/animate.css" rel="stylesheet">
    <link href="../Vendor/Assets/css/style.css" rel="stylesheet">
    <link href="../Vendor/Assets/sweetalert/sweetalert.css" rel="stylesheet">
    <style>
        .debug-panel {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
            font-size: 12px;
        }
        .message-panel {
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <div class="loginColumns animated fadeInDown">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="ibox-content" align="center">
                    <img style="width: 60px; height: auto" src="../Vendor/Media/Logo/Kabupaten.png"><br><br>
                    <span style="color:black"><strong>Dinas Pemberdayaan Masyarakat dan Desa</strong></span><br><br>
                    <span style="color:black; font-size:16px;"><strong>APLIKASI SIPEMDES</strong></span><br>
                    <span style="color:black"><strong>Sistem Informasi Pemerintahan Desa</strong></span><br><br>
                    <span style="color:brown; font-size:14px;"><strong>Unit Akses Kabupaten</strong></span>

                    <?php if ($message): ?>
                        <div class="message-panel">
                            <div class="alert alert-<?php echo $messageType === 'error' ? 'danger' : 'success'; ?>">
                                <?php echo $message; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="" class="m-t">
                        <div class="form-group">
                            <input type="text"
                                   class="form-control"
                                   name="NameAkses"
                                   placeholder="Masukkan Username"
                                   value="<?php echo isset($_POST['NameAkses']) ? htmlspecialchars($_POST['NameAkses']) : 'admindpmd'; ?>"
                                   autocomplete="off"
                                   required>
                        </div>

                        <div class="form-group">
                            <input type="password"
                                   class="form-control"
                                   name="NamePassword"
                                   placeholder="Masukkan Password"
                                   value="<?php echo isset($_POST['NamePassword']) ? htmlspecialchars($_POST['NamePassword']) : '12345'; ?>"
                                   autocomplete="off"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-full btn-primary">
                            <i class="fa fa-sign-in"></i> Login
                        </button>
                        <a href="../" class="btn btn-full btn-danger">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </form>

                    <?php if ($debug_info): ?>
                        <div class="debug-panel text-left">
                            <strong>🔍 Debug Information:</strong><br>
                            <?php echo $debug_info; ?>
                        </div>
                    <?php endif; ?>

                    <div class="debug-panel text-left">
                        <strong>📊 Request Info:</strong><br>
                        Method: <?php echo $_SERVER['REQUEST_METHOD']; ?><br>
                        POST Data: <?php echo empty($_POST) ? 'Kosong' : 'Ada (' . count($_POST) . ' field)'; ?><br>
                        Time: <?php echo date('Y-m-d H:i:s'); ?><br>
                    </div>

                    <div style="margin-top: 15px; font-size: 11px; color: #666;">
                        <strong>💡 Quick Test:</strong> Username dan password sudah terisi otomatis.<br>
                        Klik "Login" untuk test langsung.
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <hr />
    </div>

    <script src="../Vendor/Assets/sweetalert/sweetalert.min.js"></script>
</body>
</html>
