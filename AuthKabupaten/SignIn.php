<?php
/**
 * SignIn AuthKabupaten - All in One Style
 * Menggabungkan form dan proses login dalam satu file seperti AllInOne.php
 */

require_once "../Module/Config/Env.php";
require_once "../Module/Security/Security.php";

$message = '';
$messageType = '';
$showForm = true;

// Rate limiting
$clientIP = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
if (!RateLimiter::checkLimit('login_kabupaten_' . $clientIP, 5, 900)) { // 5 attempts per 15 minutes
    $message = 'Terlalu banyak percobaan login. Coba lagi dalam 15 menit.';
    $messageType = 'error';
    $showForm = false;
}

// Proses login jika ada POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST) && $showForm) {
    // Validate CSRF token
    CSRFProtection::validateOrDie();
    
    $username = XSSProtection::sanitizeInput($_POST['NameAkses'] ?? '');
    $password = XSSProtection::sanitizeInput($_POST['NamePassword'] ?? '');

    if (empty(trim($username)) || empty(trim($password))) {
        $message = 'Username atau password tidak boleh kosong!';
        $messageType = 'error';
    } else {
        // Query database using prepared statement
        $query = "SELECT
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
            WHERE main_user.NameAkses = ?";
            
        if ($stmt = mysqli_prepare($db, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if ($data = mysqli_fetch_assoc($result)) {

            if (password_verify($password, $data['NamePassword'])) {
                if ($data['StatusLogin'] == 0) {
                    $message = 'User sudah tidak aktif!';
                    $messageType = 'error';
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

                        // Fungsi Logout Automatis
                        $_SESSION["expires_by"] = time() + 1800; // 30 menit

                        unset($_SESSION['visited_pensiun_sadmin']);

                        // Redirect berdasarkan level
                        if ($data['IdLevelUserFK'] == 1) {
                            header("Location: ../View/v?pg=SAdmin");
                            exit;
                        } else {
                            header("Location: ../View/v?pg=Dashboard");
                            exit;
                        }
                    } else {
                        $message = 'Level user tidak sesuai untuk akses Kabupaten!';
                        $messageType = 'error';
                    }
                }
            } else {
                $message = 'Password salah!';
                $messageType = 'error';
            }
        } else {
            $message = 'Username tidak ditemukan!';
            $messageType = 'error';
        }
    }
}
}

?>
<!DOCTYPE html>
<html lang="id">

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.2);
            padding: 35px 40px;
            min-width: 450px;
            max-width: 500px;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c);
            border-radius: 20px 20px 0 0;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-section img {
            width: 70px;
            height: auto;
            margin-bottom: 15px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
        }

        .title-main {
            color: #2c3e50;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
            letter-spacing: -0.5px;
        }

        .title-sub {
            color: #7f8c8d;
            font-size: 13px;
            font-weight: 400;
            margin-bottom: 4px;
        }

        .title-unit {
            color: #e74c3c;
            font-size: 15px;
            font-weight: 600;
            padding: 6px 14px;
            background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%);
            border-radius: 25px;
            display: inline-block;
            margin-top: 8px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-control {
            border: 2px solid #e0e6ed;
            border-radius: 12px;
            padding: 15px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            font-weight: 400;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: #fff;
            outline: none;
        }

        .form-control::placeholder {
            color: #95a5a6;
            font-weight: 400;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #bdc3c7;
            font-size: 18px;
            z-index: 2;
        }

        .form-control.with-icon {
            padding-left: 50px;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-back {
            background: linear-gradient(135deg, #fd79a8 0%, #e84393 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-size: 14px;
            font-weight: 500;
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
        }

        .btn-back:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(253, 121, 168, 0.3);
            color: white;
            text-decoration: none;
        }

        .button-group {
            text-align: center;
        }

        .alert-custom {
            border: none;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 25px;
            font-weight: 500;
            border-left: 4px solid #e84393;
        }

        .alert-error {
            background: linear-gradient(135deg, #fd79a8 0%, #fdcb6e 100%);
            color: white;
        }

        .alert-success {
            background: linear-gradient(135deg, #00b894 0%, #00cec9 100%);
            color: white;
        }

        .footer-info {
            text-align: center;
            margin-top: 20px;
            color: #7f8c8d;
            font-size: 12px;
        }

        .security-badge {
            display: inline-flex;
            align-items: center;
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 11px;
            color: #6c757d;
            margin-top: 15px;
        }

        .security-badge i {
            margin-right: 5px;
            color: #28a745;
        }

        @keyframes float {
            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        @media (max-width: 576px) {
            .login-container {
                min-width: auto;
                width: 100%;
                margin: 10px;
                padding: 30px 25px;
            }

            .title-main {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo-section">
            <img src="../Vendor/Media/Logo/Kabupaten.png" alt="Logo" class="floating">
            <div class="title-main">APLIKASI SIPEMDES</div>
            <div class="title-sub">Sistem Informasi Pemerintahan Desa</div>
            <div class="title-sub">Dinas Pemberdayaan Masyarakat dan Desa</div>
            <div class="title-unit">Unit Akses Kabupaten</div>
        </div>

        <?php if ($message): ?>
            <div class="alert-custom alert-<?php echo $messageType; ?>">
                <i class="fa fa-exclamation-triangle"></i>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" id="loginForm">
            <?php echo CSRFProtection::getTokenField(); ?>
            <div class="form-group">
                <i class="fa fa-user input-icon"></i>
                <input type="text"
                       class="form-control with-icon"
                       name="NameAkses"
                       id="username"
                       placeholder="Masukkan Username"
                       value="<?php echo isset($_POST['NameAkses']) ? XSSProtection::escape($_POST['NameAkses']) : ''; ?>"
                       autocomplete="off"
                       required>
            </div>

            <div class="form-group">
                <i class="fa fa-lock input-icon"></i>
                <input type="password"
                       class="form-control with-icon"
                       name="NamePassword"
                       id="password"
                       placeholder="Masukkan Password"
                       autocomplete="off"
                       required>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-login" id="submitBtn">
                    <i class="fa fa-sign-in"></i> &nbsp; Masuk
                </button>

                <a href="../" class="btn-back">
                    <i class="fa fa-arrow-left"></i> &nbsp; Kembali
                </a>
            </div>
        </form>

        <div class="footer-info">
            <div class="security-badge">
                <i class="fa fa-shield"></i>
                Sistem Keamanan Aktif
            </div>
            <div style="margin-top: 10px;">
                © 2025 Pemerintah Kabupaten Trenggalek
            </div>
        </div>
    </div>

    <script src="../Vendor/Assets/sweetalert/sweetalert.min.js"></script>

    <script>
        // Form submission dengan loading state sederhana
        document.getElementById('loginForm').addEventListener('submit', function () {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> &nbsp; Memproses...';
            submitBtn.disabled = true;
        });

        // Focus effect untuk input
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function () {
                this.parentElement.style.transform = 'scale(1.02)';
                this.parentElement.style.transition = 'transform 0.2s ease';
            });

            input.addEventListener('blur', function () {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Auto focus pada username
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('username').focus();
        });

        // SweetAlert untuk error
        <?php if ($message && $messageType === 'error'): ?>
        setTimeout(function() {
            swal({
                title: 'Login Gagal!',
                text: '<?php echo addslashes($message); ?>',
                type: 'error',
                confirmButtonText: 'Coba Lagi',
                confirmButtonColor: '#667eea'
            });
        }, 100);
        <?php endif; ?>
    </script>
</body>
</html>
