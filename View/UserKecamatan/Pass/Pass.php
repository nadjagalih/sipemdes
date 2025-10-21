<?php
// Mulai output buffering untuk mencegah header error
ob_start();

// Include CSPHandler untuk nonce support
require_once __DIR__ . '/../../../Module/Security/CSPHandler.php';

// Set CSP headers dengan nonce
CSPHandler::setCSPHeaders();

// Generate CSRF token jika belum ada
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Basic alert handling tanpa header redirect untuk menghindari error
if (isset($_GET['alert'])) {
    $alert = $_GET['alert'];
    $notificationScript = '';
    
    if ($alert == 'Sukses') {
        $notificationScript = "
            Swal.fire({
                title: 'SUKSES',
                text: 'Sukses Ganti Password, Silahkan Login Ulang',
                icon: 'success',
                showConfirmButton: true,
                confirmButtonText: 'OK'
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = '../AuthKecamatan/SignOut';
                }
            });
        ";
    } elseif ($alert == 'Panjang') {
        $notificationScript = "
            Swal.fire({
                title: 'PERINGATAN',
                text: 'Panjang Minimal Password 8 Karakter',
                icon: 'warning',
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
        ";
    } elseif ($alert == 'FormatPassword') {
        $notificationScript = "
            Swal.fire({
                title: 'PERINGATAN',
                text: 'Password harus mengandung minimal: 8 karakter, 1 huruf kapital, dan 1 karakter khusus (!@#$%^&*)',
                icon: 'warning',
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
        ";
    } elseif ($alert == 'CSRFError') {
        $notificationScript = "
            Swal.fire({
                title: 'ERROR',
                text: 'Token keamanan tidak valid. Silakan coba lagi.',
                icon: 'error',
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
        ";
    } elseif (strpos($alert, 'Gagal') !== false) {
        $notificationScript = "
            Swal.fire({
                title: 'ERROR',
                text: '" . htmlspecialchars($alert, ENT_QUOTES) . "',
                icon: 'error',
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
        ";
    } else {
        $notificationScript = "
            Swal.fire({
                title: 'INFORMASI',
                text: '" . htmlspecialchars($alert, ENT_QUOTES) . "',
                icon: 'info',
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
        ";
    }
    
    // Output script dengan nonce
    echo "<script " . CSPHandler::scriptNonce() . ">
        document.addEventListener('DOMContentLoaded', function() {
            // Tunggu SweetAlert2 ter-load
            if (typeof Swal !== 'undefined') {
                " . $notificationScript . "
            } else {
                // Fallback jika SweetAlert2 belum ter-load
                setTimeout(function() {
                    if (typeof Swal !== 'undefined') {
                        " . $notificationScript . "
                    } else {
                        console.error('SweetAlert2 not loaded');
                    }
                }, 500);
            }
        });
    </script>";
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
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="../App/Model/ExcPasswordKec?Act=Pass" method="POST" enctype="multipart/form-data" id="passwordForm">
                        <!-- CSRF Protection (hidden untuk compatibility) -->
                        <input type="hidden" name="csrf_token" value="<?php echo isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : ''; ?>">
                        
                        <!-- Hidden User ID -->
                        <input type="hidden" class="form-control" name="IdUser" id="IdUser" value="<?php echo isset($_SESSION['IdUser']) ? htmlspecialchars($_SESSION['IdUser']) : ''; ?>">
                        
                        <!-- Password Baru -->
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Password Baru</label>
                            <div class="col-lg-8">
                                <input type="password" class="form-control" name="PasswordBaru" id="PasswordBaru" placeholder="Password Baru" autocomplete="off" required minlength="8">
                                <span class="form-text m-b-none" style="font-style: italic;">*) Password harus mengandung minimal: 8 karakter, 1 huruf kapital, dan 1 karakter khusus (!@#$%^&*)</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary" type="submit" name="Save" id="Save">Save</button>
                                <a href="?pg=PassKecamatan" class="btn btn-success ">Batal</a>
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