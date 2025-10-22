<?php require_once "../Module/Security/Security.php"; ?>
<style>
    .status-sukses {
        background: white;
        color: green;
    }

    .status-no-sukses {
        background: white;
        color: red;
    }

    /* Styling untuk panduan user */
    .wrapper-content .ibox {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: 1px solid #e7eaec;
    }

    .wrapper-content .ibox-title {
        border-radius: 15px 15px 0 0;
        background: #ffffff;
        color: #495057;
        border-bottom: 1px solid #e7eaec;
    }

    .wrapper-content .ibox-title h5 {
        color: #495057;
        margin: 0;
        font-weight: 600;
    }

    .wrapper-content .ibox-content {
        border-radius: 0 0 15px 15px;
        background: #ffffff;
        padding: 30px;
    }

    .wrapper-content .form-control {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .wrapper-content .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    .wrapper-content .btn {
        border-radius: 25px;
        padding: 10px 25px;
        font-weight: 600;
    }

    .wrapper-content .guide-box {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 1px solid #dee2e6;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .wrapper-content .guide-title {
        color: #495057;
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #007bff;
        display: flex;
        align-items: center;
    }

    .wrapper-content .guide-title i {
        margin-right: 8px;
        color: #007bff;
    }

    .wrapper-content .guide-steps {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .wrapper-content .guide-steps li {
        background: white;
        margin-bottom: 10px;
        padding: 12px 15px;
        border-radius: 10px;
        border-left: 4px solid #007bff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        position: relative;
        transition: all 0.3s ease;
    }

    .wrapper-content .guide-steps li:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .wrapper-content .step-number {
        background: #007bff;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        margin-right: 10px;
        flex-shrink: 0;
    }

    .wrapper-content .step-text {
        font-size: 14px;
        color: #495057;
        line-height: 1.4;
    }

    .wrapper-content .guide-note {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 10px;
        padding: 12px;
        margin-top: 15px;
        font-size: 13px;
        color: #856404;
    }

    .wrapper-content .guide-note i {
        color: #f39c12;
        margin-right: 8px;
    }

    .wrapper-content .step-container {
        display: flex;
        align-items: flex-start;
    }

    .wrapper-content .password-hint {
        font-style: italic;
    }

    /* Notification Popup Styles */
    .notification-popup {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 400px;
        border-radius: 10px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.3s ease;
    }

    .notification-popup.show {
        opacity: 1;
        transform: translateX(0);
    }

    .notification-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border: 1px solid #28a745;
    }

    .notification-error {
        background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
        color: white;
        border: 1px solid #dc3545;
    }

    .notification-content {
        padding: 15px 20px;
        display: flex;
        align-items: center;
    }

    .notification-icon {
        font-size: 24px;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .notification-text {
        flex: 1;
    }

    .notification-title {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 4px;
    }

    .notification-message {
        font-size: 14px;
        opacity: 0.9;
    }

    .notification-close {
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
        padding: 0;
        margin-left: 10px;
        opacity: 0.8;
        transition: opacity 0.2s ease;
    }

    .notification-close:hover {
        opacity: 1;
    }
</style>

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
                <strong>User</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-5">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Form Input User</h5>
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
                    <form action="../App/Model/ExcUser?Act=Save" method="POST" enctype="multipart/form-data">
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Username</label>
                            <div class="col-lg-8">
                                <input type="text" 
                                       name="UserNama" 
                                       id="UserNama" 
                                       data-validation="username"
                                       data-validation-endpoint="User/CheckAvailability.php"
                                       data-validation-target="UserAvailabilityStatus"
                                       data-validation-param="UserNama"
                                       placeholder="Masukkan Username" 
                                       class="form-control" required autocomplete="off">

                            </div>
                        </div>
                        <span id="UserAvailabilityStatus" class="form-text m-b-none"></span>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="guide-box">
                <div class="guide-title">
                    <i class="fa fa-info-circle"></i>
                    Panduan Menambah User Baru
                </div>
                
                <ol class="guide-steps">
                    <li>
                        <div class="step-container">
                            <span class="step-number">1</span>
                            <div class="step-text">
                                <strong>Buat Username Unik</strong>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="step-container">
                            <span class="step-number">2</span>
                            <div class="step-text">
                                <strong>Tentukan Password</strong>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="step-container">
                            <span class="step-number">3</span>
                            <div class="step-text">
                                <strong>Atur Hak Akses</strong>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="step-container">
                            <span class="step-number">4</span>
                            <div class="step-text">
                                <strong>Isi Nama Lengkap</strong>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="step-container">
                            <span class="step-number">5</span>
                            <div class="step-text">
                                <strong>Pilih Unit Kerja</strong>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="step-container">
                            <span class="step-number">6</span>
                            <div class="step-text">
                                <strong>Set Status User</strong>
                            </div>
                        </div>
                    </li>
                </ol>

                <div class="guide-note">
                    <i class="fa fa-exclamation-triangle"></i>
                    <strong>Catatan:</strong> Pastikan semua data sudah benar sebelum menyimpan.
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include CSPHandler untuk nonce support
require_once __DIR__ . '/../../Module/Security/CSPHandler.php';

// Check for success/error messages from URL parameters
$alertData = null;
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'add':
            $alertData = [
                'title' => 'Berhasil!',
                'message' => 'User berhasil ditambahkan.',
                'icon' => 'success'
            ];
            break;
        case 'edit':
            $alertData = [
                'title' => 'Berhasil!',
                'message' => 'User berhasil diperbarui.',
                'icon' => 'success'
            ];
            break;
        case 'delete':
            $alertData = [
                'title' => 'Berhasil!',
                'message' => 'User berhasil dihapus.',
                'icon' => 'warning'
            ];
            break;
        default:
            $alertData = [
                'title' => 'Berhasil!',
                'message' => 'Operasi berhasil dilakukan.',
                'icon' => 'success'
            ];
    }
} elseif (isset($_GET['error'])) {
    $alertData = [
        'title' => 'Error!',
        'message' => 'Terjadi kesalahan saat memproses data.',
        'icon' => 'error'
    ];
}

if ($alertData) {
    // Set data untuk JavaScript menggunakan data attributes
    echo '<div id="alert-data" 
            data-title="' . htmlspecialchars($alertData['title'], ENT_QUOTES) . '" 
            data-message="' . htmlspecialchars($alertData['message'], ENT_QUOTES) . '" 
            data-icon="' . htmlspecialchars($alertData['icon'], ENT_QUOTES) . '" 
            style="display: none;"></div>';
}
?>

<script src="../Assets/js/username-validation.js"></script>
<script src="../Assets/js/notification-handler.js"></script>