<?php
include "../App/Control/FunctionUserEditKecamatan.php";
?>
<script>
    function checkAvailability() {
        // $( "#loaderIcon" ).show();
        jQuery.ajax({
            url: "UserKecamatan/CheckAvailability.php",
            data: 'UserNama=' + $("#UserNama").val(),
            type: "POST",
            success: function(data) {
                $("#UserAvailabilityStatus").html(data);
                $("#loaderIcon").hide();
            },
            error: function() {}
        });
    }
</script>
<style>
    /* Hanya untuk form user, tidak mempengaruhi top menu */
    .wrapper-content .status-sukses {
        background: white;
        color: green;
    }

    .wrapper-content .status-no-sukses {
        background: white;
        color: red;
    }

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
        border-bottom: 2px solid #17a2b8;
        display: flex;
        align-items: center;
    }

    .wrapper-content .guide-title i {
        margin-right: 8px;
        color: #17a2b8;
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
        border-left: 4px solid #17a2b8;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        position: relative;
        transition: all 0.3s ease;
    }

    .wrapper-content .guide-steps li:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .wrapper-content .step-number {
        background: #17a2b8;
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
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data User Kecamatan</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Setting</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>User Kecamatan</strong>
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
                    <h5>Form Edit User</h5>
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
                    <form action="../App/Model/ExcUserKecamatan?Act=Edit" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="IdUser" id="IdUser" value="<?php echo $EditIdUser; ?>">
                        <input type="hidden" name="IdPegawaiFK" id="IdPegawaiFK" value="<?php echo $IdPegawaiFK; ?>">
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Username</label>
                            <div class="col-lg-8">
                                <input type="text" name="UserNama" id="UserNama" onkeyup="checkAvailability()" value="<?php echo $EditNameAkses; ?>" class="form-control" required autocomplete="off" readonly>
                                <span id="UserAvailabilityStatus" class="form-text m-b-none"></span>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Password</label>
                            <div class="col-lg-8">
                                <input type="password" name="Pass" id="Pass" value="<?php echo $EditNamePassword; ?>" class="form-control" readonly>
                                <span class="form-text m-b-none" style="font-style: italic;">*) Minimal Panjang Password 5 Karakter</span>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Hak Akses</label>
                            <div class="col-lg-8">
                                <?php include "../App/Control/FunctionSelectAksesKecamatan.php"; ?>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Nama</label>
                            <div class="col-lg-8"><input type="text" name="Nama" id="Nama" value="<?php echo $EditNama; ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Kecamatan</label>
                            <div class="col-lg-8">
                                <?php include "../App/Control/FunctionSelectKecamatanKec.php"; ?>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Status Login</label>
                            <div class="col-lg-8">
                                <select name="Status" id="Status" style="width: 100%;" class="select2_akses form-control" required>
                                    <?php if ($EditStatusLogin == 0) { ?>
                                        <option value="0">NON AKTIF</option>
                                        <option value="1">AKTIF</option>
                                        <?php } elseif ($EditStatusLogin == 1) { ?>}
                                        <option value="1">AKTIF</option>
                                        <option value="0">NON AKTIF</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <?php if ($EditStatus == 0 and $EditSetting == 0) { ?>
                                    <a href="?pg=UserViewKecamatan" class="btn btn-success ">Batal</a>
                                <?php } else { ?>
                                    <button class="btn btn-primary" type="submit" name="Edit" id="Edit">Save</button>
                                    <a href="?pg=UserViewKecamatan" class="btn btn-success ">Batal</a>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="guide-box">
                <div class="guide-title">
                    <i class="fa fa-edit"></i>
                    Panduan Edit Data User
                </div>
                
                <ol class="guide-steps">

                    <li>
                        <div style="display: flex; align-items: flex-start;">
                            <span class="step-number">1</span>
                            <div class="step-text">
                                <strong>Ubah Hak Akses</strong><br>
                                <small>Sesuaikan level akses user</small>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div style="display: flex; align-items: flex-start;">
                            <span class="step-number">2</span>
                            <div class="step-text">
                                <strong>Update Nama</strong><br>
                                <small>Perbarui nama lengkap user</small>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div style="display: flex; align-items: flex-start;">
                            <span class="step-number">3</span>
                            <div class="step-text">
                                <strong>Ganti Unit Kerja</strong><br>
                                <small>Pilih unit kerja yang sesuai</small>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div style="display: flex; align-items: flex-start;">
                            <span class="step-number">4</span>
                            <div class="step-text">
                                <strong>Set Status Login</strong><br>
                                <small>Aktif/nonaktif untuk mengatur akses login</small>
                            </div>
                        </div>
                    </li>
                </ol>

                <div class="guide-note">
                    <i class="fa fa-exclamation-triangle"></i>
                    <strong>Catatan:</strong> Perubahan akan langsung berlaku setelah disimpan. Pastikan data sudah benar.
                </div>
            </div>
        </div>

    </div>
</div>

<?php
// Check for success/error messages from URL parameters
$alertData = null;
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'add':
            $alertData = [
                'title' => 'Berhasil!',
                'message' => 'User kecamatan berhasil ditambahkan.',
                'icon' => 'success'
            ];
            break;
        case 'edit':
            $alertData = [
                'title' => 'Berhasil!',
                'message' => 'User kecamatan berhasil diperbarui.',
                'icon' => 'success'
            ];
            break;
        case 'delete':
            $alertData = [
                'title' => 'Berhasil!',
                'message' => 'User kecamatan berhasil dihapus.',
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

<script src="../Assets/js/notification-handler.js"></script>