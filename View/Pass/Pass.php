<?php
// Mulai output buffering untuk mencegah header error
ob_start();

// Generate CSRF token jika belum ada
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Basic alert handling tanpa header redirect untuk menghindari error
if (isset($_GET['alert']) && $_GET['alert'] == 'Sukses') {
    echo "<script nonce='" . (isset($_SESSION['csp_nonce']) ? $_SESSION['csp_nonce'] : '') . "' type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: 'SUKSES',
                      text:  'Sukses Ganti Password, Silahkan Login Ulang',
                      type: 'success',
                      showConfirmButton: true
                     },
                          function(){
                            window.location.href = '../Auth/SignOut';
                          }
                     );
                    },10);
        </script>";
} else
if (isset($_GET['alert']) && $_GET['alert'] == 'Panjang') {
    echo "<script nonce='" . (isset($_SESSION['csp_nonce']) ? $_SESSION['csp_nonce'] : '') . "' type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: 'INFORMATION',
                      text:  'Panjang Minimal Password 8 Karakter',
                      type: 'warning',
                      showConfirmButton: true
                     });
                    },10);
        </script>";
} else
if (isset($_GET['alert']) && $_GET['alert'] == 'CSRFError') {
    echo "<script nonce='" . (isset($_SESSION['csp_nonce']) ? $_SESSION['csp_nonce'] : '') . "' type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: 'ERROR',
                      text:  'Token keamanan tidak valid. Silakan coba lagi.',
                      type: 'error',
                      showConfirmButton: true
                     });
                    },10);
        </script>";
} else
if (isset($_GET['alert']) && $_GET['alert'] == 'PasswordSalah') {
    echo "<script nonce='" . (isset($_SESSION['csp_nonce']) ? $_SESSION['csp_nonce'] : '') . "' type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: 'ERROR',
                      text:  'Password lama yang Anda masukkan salah',
                      type: 'error',
                      showConfirmButton: true
                     });
                    },10);
        </script>";
} else
if (isset($_GET['alert']) && $_GET['alert'] == 'DatabaseError') {
    echo "<script nonce='" . (isset($_SESSION['csp_nonce']) ? $_SESSION['csp_nonce'] : '') . "' type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: 'ERROR',
                      text:  'Gagal menyimpan password ke database. Silakan coba lagi.',
                      type: 'error',
                      showConfirmButton: true
                     });
                    },10);
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
                                <input type="password" class="form-control" name="PasswordBaru" id="PasswordBaru" placeholder="Password Baru" autocomplete="off" required minlength="8">
                                <span class="form-text m-b-none" style="font-style: italic;">*) Minimal Panjang Password 8 Karakter</span>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('passwordForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const password = document.getElementById('PasswordBaru').value;
            
            // Simple length validation
            if (password.length < 8) {
                e.preventDefault();
                alert('Password minimal 8 karakter');
                return false;
            }
            
            return true;
        });
    }
});
</script>

<?php
// Flush output buffer
ob_end_flush();
?>