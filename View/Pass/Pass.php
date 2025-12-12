<?php
// Mulai output buffering untuk mencegah header error
ob_start();

// Include CSPHandler untuk nonce support
require_once __DIR__ . '/../../Module/Security/CSPHandler.php';

// Set CSP headers dengan nonce
CSPHandler::setCSPHeaders();

// Generate CSRF token jika belum ada
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Enhanced alert handling with proper CSP compliance and SweetAlert2 loading check
$alertType = isset($_GET['alert']) ? $_GET['alert'] : '';
$nonce = CSPHandler::getNonce();

if (!empty($alertType)) {
    // Konfigurasi notifikasi
    $notifications = [
        'Sukses' => [
            'title' => 'SUKSES',
            'text' => 'Sukses Ganti Password, Silahkan Login Ulang',
            'icon' => 'success',
            'redirect' => '../Auth/SignOut'
        ],
        'Panjang' => [
            'title' => 'INFORMATION',
            'text' => 'Panjang Minimal Password 8 Karakter',
            'icon' => 'warning'
        ],
        'FormatPassword' => [
            'title' => 'PERINGATAN',
            'text' => 'Password harus mengandung minimal: 8 karakter, 1 huruf kapital, dan 1 karakter khusus (!@#$%^&*)',
            'icon' => 'warning'
        ],
        'CSRFError' => [
            'title' => 'ERROR',
            'text' => 'Token keamanan tidak valid. Silakan coba lagi.',
            'icon' => 'error'
        ],
        'PasswordSalah' => [
            'title' => 'ERROR',
            'text' => 'Password lama yang Anda masukkan salah',
            'icon' => 'error'
        ],
        'DatabaseError' => [
            'title' => 'ERROR',
            'text' => 'Gagal menyimpan password ke database. Silakan coba lagi.',
            'icon' => 'error'
        ]
    ];

    if (isset($notifications[$alertType])) {
        $notif = $notifications[$alertType];
        $hasRedirect = isset($notif['redirect']);
        
        echo "<script nonce='" . $nonce . "'>
        // Fungsi untuk menampilkan notifikasi dengan pengecekan SweetAlert2
        function showPasswordNotification() {
            if (typeof Swal !== 'undefined') {
                console.log('SweetAlert2 loaded - showing notification');
                Swal.fire({
                    title: '" . addslashes($notif['title']) . "',
                    text: '" . addslashes($notif['text']) . "',
                    icon: '" . $notif['icon'] . "',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#1ab394',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                })" . ($hasRedirect ? ".then(function(result) {
                    if (result.isConfirmed) {
                        window.location.href = '" . $notif['redirect'] . "';
                    }
                })" : "") . ";
            } else {
                console.log('SweetAlert2 not loaded - using alert fallback');
                alert('" . addslashes($notif['title']) . "\\n\\n" . addslashes($notif['text']) . "');" 
                . ($hasRedirect ? "
                window.location.href = '" . $notif['redirect'] . "';" : "") . "
            }
        }
        
        // Tunggu DOM dan SweetAlert2 ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(showPasswordNotification, 100);
            });
        } else {
            setTimeout(showPasswordNotification, 100);
        }
        </script>";
    }
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data User</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Setting</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Password</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-5">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Ganti Password</h5>
                </div>
                <div class="ibox-content">
                    <form action="../App/Model/ExcPassword?Act=Pass" method="POST" enctype="multipart/form-data" id="passwordForm">
                        <!-- CSRF Protection (hidden untuk compatibility) -->
                        <input type="hidden" name="csrf_token" value="<?php echo isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : ''; ?>">
                        
                        <!-- Hidden User ID -->
                        <input type="hidden" class="form-control" name="IdUser" id="IdUser" value="<?php echo isset($_SESSION['IdUser']) ? htmlspecialchars($_SESSION['IdUser']) : ''; ?>">
                        
                        <!-- Password Baru (desain lama) -->
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Password Baru</label>
                            <div class="col-lg-8">
                                <div style="position: relative;">
                                    <input type="password" class="form-control" name="PasswordBaru" id="PasswordBaru" placeholder="Password Baru" autocomplete="off" required minlength="8" style="padding-right: 40px;">
                                    <span toggle="#PasswordBaru" class="fa fa-eye field-icon toggle-password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #676a6c;"></span>
                                </div>
                                <span class="form-text m-b-none" style="font-style: italic;">*) Password harus mengandung minimal: 8 karakter, 1 huruf kapital, dan 1 karakter khusus (!@#$%^&*)</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary" type="submit" name="Save" id="Save">Save</button>
                                <a href="?pg=Pass" class="btn btn-success ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Simple validation script -->
<script <?php echo CSPHandler::scriptNonce(); ?>>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.querySelector('.toggle-password');
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const passwordInput = document.querySelector(this.getAttribute('toggle'));
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    }
    
    const form = document.getElementById('passwordForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const password = document.getElementById('PasswordBaru').value;
            
            // Validasi panjang password
            if (password.length < 8) {
                e.preventDefault();
                showPasswordValidationError('Password minimal 8 karakter');
                return false;
            }
            
            // Validasi huruf kapital
            if (!/[A-Z]/.test(password)) {
                e.preventDefault();
                showPasswordValidationError('Password harus mengandung minimal 1 huruf kapital (A-Z)');
                return false;
            }
            
            // Validasi karakter khusus
            if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
                e.preventDefault();
                showPasswordValidationError('Password harus mengandung minimal 1 karakter khusus (!@#$%^&* dll)');
                return false;
            }
            
            return true;
        });
        
        // Fungsi untuk menampilkan error validasi
        function showPasswordValidationError(message) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'PERINGATAN',
                    text: message,
                    icon: 'warning',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#f39c12'
                });
            } else {
                alert('PERINGATAN\n\n' + message);
            }
        }
    }
});
</script>

<?php
// Flush output buffer
ob_end_flush();
?>