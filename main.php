<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once "Module/Config/Env.php";

// Initialize alert variables
$alertMessage = '';
$alertType = '';

// Check for session-based login error
if (isset($_SESSION['login_error'])) {
    $alertMessage = $_SESSION['login_error'];
    $alertType = 'error';
    // Clear the error message after displaying
    unset($_SESSION['login_error']);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $unitAkses = $_POST['unitAkses'] ?? '';
    $username = $_POST['NameAkses'] ?? '';
    $password = $_POST['NamePassword'] ?? '';

    // Validate required fields
    if (empty($unitAkses) || empty($username) || empty($password)) {
        $alertMessage = 'Semua field harus diisi';
        $alertType = 'error';
    } else {
        // Route to appropriate authentication handler based on unit selection
        switch ($unitAkses) {
            case 'kabupaten':
                // Set session for credentials
                $_SESSION['temp_username'] = $username;
                $_SESSION['temp_password'] = $password;
                $_SESSION['temp_unit'] = 'kabupaten';

                // Redirect to AuthKabupaten/Cek.php
                header("Location: AuthKabupaten/Cek.php");
                exit;

            case 'desa':
                // Set session for credentials
                $_SESSION['temp_username'] = $username;
                $_SESSION['temp_password'] = $password;
                $_SESSION['temp_unit'] = 'desa';

                // Redirect to AuthDesa/Cek.php
                header("Location: AuthDesa/Cek.php");
                exit;

            case 'kecamatan':
                // Set session for credentials
                $_SESSION['temp_username'] = $username;
                $_SESSION['temp_password'] = $password;
                $_SESSION['temp_unit'] = 'kecamatan';

                // Redirect to AuthKecamatan/Cek.php
                header("Location: AuthKecamatan/Cek.php");
                exit;

            default:
                $alertMessage = 'Unit akses tidak valid';
                $alertType = 'error';
                break;
        }
    }
}

// Handle URL parameters for alerts (from authentication redirects)
if (isset($_GET['alert'])) {
    switch ($_GET['alert']) {
        case 'Kosong':
            $alertMessage = 'Username tidak boleh kosong atau mengandung karakter khusus';
            $alertType = 'error';
            break;
        case 'Cek':
            $alertMessage = 'Username atau password salah';
            $alertType = 'error';
            break;
        case 'Status':
            $alertMessage = 'Akun Anda tidak aktif. Hubungi administrator';
            $alertType = 'error';
            break;
        default:
            $alertMessage = 'Terjadi kesalahan, silakan coba lagi';
            $alertType = 'error';
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPEMDES | Kab. Trenggalek</title>
    <link href="Vendor/Media/Logo/Kabupaten.png" type="image/x-icon" rel="icon">
    <!-- SECURITY FIX: Added preconnect and SRI-like headers for Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" 
          rel="stylesheet" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800;900&display=swap" 
          rel="stylesheet" crossorigin="anonymous">

    <style>
        :root {
            --bg: #f8f9fa;
            --text: #495057;
            --muted: #6c757d;
            --primary: #0d6efd;
            --primary-hover: #0b5ed7;
            --border: #ced4da;
            --focus: rgba(13, 110, 253, 0.25);
            --error: #dc3545;
            --error-bg: #f8d7da;
            --error-border: #f5c6cb;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; background: var(--bg); font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; color: var(--text); }

        /* Alert styles */
        .alert {
            padding: 12px 16px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 6px;
            font-size: 14px;
            line-height: 1.4;
        }
        .alert-error {
            color: var(--error);
            background-color: var(--error-bg);
            border-color: var(--error-border);
        }

        /* Layout */
        .login-grid {
            display: grid;
            grid-template-columns: 60% 40%;
            min-height: 100vh;
            width: 100%;
        }

        /* Left: image/brand */
        .left-side {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0a0a37 0%, #1845b3 100%);
            overflow: hidden;
            font-family: 'Nunito', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
        }
        .left-inner { text-align: center; color: #fff; padding: 24px; }
        .left-logo { width: 140px; height: 140px; border-radius: 50%; background: rgba(255,255,255,.1); border: 2px solid rgba(255,255,255,.25); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
        .left-logo img { width: 90px; height: 90px; object-fit: contain; }
        .left-title { font-family: 'Nunito', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; font-weight: 300; font-size: 44px; line-height: 1.2; letter-spacing: 0.3px; color: rgba(255, 255, 255, 0.98); margin-bottom: 10px; text-shadow: 0 1px 2px rgba(0,0,0,.25); }
        .left-sub { font-weight: 300; font-size: 20px; line-height: 1.6; letter-spacing: 0.3px; color: rgba(255, 255, 255, 0.95); }

        /* Right: form */
        .right-side { position: relative; background: #fff; display: flex; align-items: center; justify-content: flex-start; padding-left: 72px; padding-right: 24px;
            /* Typography defaults for login area */
            font-family: 'Inter', sans-serif; font-size: .875rem; font-weight: 400; line-height: 1.5rem; }
        .form-wrap { width: 100%; max-width: 420px; padding: 24px; }
        .form-head { margin-bottom: 24px; }
        .form-head h1 { font-size: 22px; font-weight: 600; color: black; margin-bottom: 6px; }
        .form-head p { font-size: 13px; color: var(--muted); }

        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: .875rem; font-weight: 400; line-height: 1.5rem; color: var(--muted); margin-bottom: 6px; }
        /* Override: make right-side labels light black */
        .right-side label { color: #222222; }
        /* Field + icon wrapper */
        .field { position: relative; }
        .field .icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center; color: var(--muted); pointer-events: none; }
        .field .icon svg { width: 18px; height: 18px; stroke: currentColor; }

        .control { width: 100%; height: 48px; padding: 10px 12px 10px 44px; font-size: .875rem; font-weight: 500; line-height: 1.5rem; color: var(--text); background: #fff; border: 1px solid var(--border); border-radius: 6px; transition: box-shadow .15s ease, border-color .15s ease; }
        .control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 .2rem var(--focus); }
        .control::placeholder { color: #adb5bd; }
        select.control { appearance: none; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='none'%3e%3cpath d='M4.5 6l3.5 4L11.5 6' stroke='%236c757d' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 12px center; background-size: 14px; padding-right: 36px; }

        .btn { width: 100%; height: 48px; border: 1px solid var(--primary); background: var(--primary); color: #fff; font-size: .875rem; font-weight: 500; line-height: 1.5rem; border-radius: 6px; cursor: pointer; transition: background .15s ease, transform .1s ease, box-shadow .15s ease; margin-top: 8px; }
        .btn:hover { background: var(--primary-hover); box-shadow: 0 6px 16px rgba(13,110,253,.25); transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }

        /* Footer fixed at the bottom and centered */
        .footer { position: absolute; bottom: 16px; left: 24px; right: 24px; font-size: 12px; color: var(--muted); text-align: center; }
        .footer strong { color: var(--text); font-weight: 700; }

        /* Responsive */
        @media (max-width: 992px) {
            .login-grid { grid-template-columns: 1fr; }
            .left-side { min-height: 36vh; }
            .right-side { min-height: 64vh; justify-content: center; padding: 24px; }
            /* keep footer at bottom on mobile as well */
        }
        @media (max-width: 576px) {
            .left-logo { width: 110px; height: 110px; }
            .left-logo img { width: 70px; height: 70px; }
            .left-title { font-size: 30px; }
            .form-wrap { max-width: 92%; }
        }
    </style>
</head>

<body>
    <div class="login-grid">
        <!-- Left: Branding/Image -->
        <aside class="left-side">
            <div class="left-inner">
                <div class="left-logo">
                    <img src="Vendor/Media/Logo/Kabupaten.png" alt="Kabupaten Trenggalek">
                </div>
                <div class="left-title">Sistem Informasi Pemerintahan Desa</div>
                <div class="left-sub">Kabupaten Trenggalek</div>
            </div>
        </aside>

        <!-- Right: Form Login -->
        <main class="right-side">
            <div class="form-wrap">
                <header class="form-head">
                    <h1>SIPEMDES</h1>
                    <p>Silakan pilih unit akses dan masukkan kredensial Anda</p>
                </header>

                <!-- Debug dan Alert Messages -->
                <?php if (isset($_GET['alert'])): ?>
                    <?php
                    // Force set alert message berdasarkan parameter
                    switch ($_GET['alert']) {
                        case 'Cek':
                            $alertMessage = 'Username atau password salah';
                            $alertType = 'error';
                            break;
                        case 'Kosong':
                            $alertMessage = 'Username tidak boleh kosong atau mengandung karakter khusus';
                            $alertType = 'error';
                            break;
                        case 'Status':
                            $alertMessage = 'Akun Anda tidak aktif. Hubungi administrator';
                            $alertType = 'error';
                            break;
                    }
                    ?>


                    <!-- Error Message - Paksa Tampil -->
                    <div style="background: #f8d7da !important; color: #721c24 !important; border: 2px solid #f5c6cb !important; padding: 15px; margin: 10px 0; border-radius: 6px; font-weight: bold; font-size: 16px;">
                        ⚠️ <?php echo htmlspecialchars($alertMessage); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($alertMessage) && !isset($_GET['alert'])): ?>
                <div class="alert alert-<?php echo $alertType; ?>" style="display: block !important; visibility: visible !important; background-color: #f8d7da !important; color: #721c24 !important; border: 1px solid #f5c6cb !important;">
                    <?php echo htmlspecialchars($alertMessage); ?>
                </div>
                <?php endif; ?>

                <form id="loginForm" method="POST" action="">
                    <div class="form-group">
                        <label for="unitAkses">Unit Akses</label>
                        <div class="field">
                            <span class="icon" aria-hidden="true">
                                <!-- Building icon -->
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 21h18M6 21V7l6-4 6 4v14M9 10h2m2 0h2M9 14h2m2 0h2M9 18h6" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                            <select id="unitAkses" name="unitAkses" class="control" required>
                                <option value="">Pilih Unit Akses</option>
                                <option value="desa">Pemerintah Desa</option>
                                <option value="kecamatan">Pemerintah Kecamatan</option>
                                <option value="kabupaten">Pemerintah Kabupaten</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="field">
                            <span class="icon" aria-hidden="true">
                                <!-- User icon -->
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 21a8 8 0 10-16 0M12 11a4 4 0 100-8 4 4 0 000 8z" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                            <input id="username" name="NameAkses" type="text" class="control" placeholder="Masukkan username" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="field">
                            <span class="icon" aria-hidden="true">
                                <!-- Lock icon -->
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 10V7a5 5 0 0110 0v3M6 10h12a2 2 0 012 2v7a2 2 0 01-2 2H6a2 2 0 01-2-2v-7a2 2 0 012-2z" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                            <input id="password" name="NamePassword" type="password" class="control" placeholder="Masukkan password" autocomplete="new-password" required>
                            <button type="button" id="togglePassword" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); padding: 0; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;">
                                <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 18px; height: 18px; stroke: currentColor;">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="12" cy="12" r="3" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn" id="submitBtn">Masuk</button>
                </form>

                <div class="footer">© 2025 <strong>Pemerintah Kabupaten Trenggalek</strong></div>
            </div>
        </main>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', () => {
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle the eye icon - change to eye-slash when password is visible
            if (type === 'text') {
                // Show eye-slash icon (password is visible)
                eyeIcon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M21 4L3 20" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="12" r="3" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                `;
            } else {
                // Show normal eye icon (password is hidden)
                eyeIcon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="12" r="3" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                `;
            }
        });

        // Prevent form submission from saving to browser history
        document.getElementById('loginForm').addEventListener('submit', function() {
            // Clear form data after a short delay to prevent browser from saving it
            setTimeout(() => {
                this.reset();
            }, 100);
        });
    </script>
</body>
</html>
