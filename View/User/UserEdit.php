<?php
include "../App/Control/FunctionUserEdit.php";
include "../App/Control/FunctionPegawaiEdit.php";
?>
<script>
    function checkAvailability() {
        // $( "#loaderIcon" ).show();
        jQuery.ajax({
            url: "User/CheckAvailability.php",
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
    .status-sukses {
        background: white;
        color: green;
    }

    .status-no-sukses {
        background: white;
        color: red;
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
                    <form action="../App/Model/ExcUserSimple?Act=Edit" method="POST" enctype="multipart/form-data">
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
                                <?php include "../App/Control/FunctionSelectAkses.php"; ?>
                            </div>
                        </div>
                        <!-- <div class="form-group row"><label class="col-lg-4 col-form-label">NIK</label>
                            <div class="col-lg-8"><input type="text" name="NIK" id="NIK" value="<?php echo $EditNIK; ?>" class="form-control" readonly>
                            </div>
                        </div> -->
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Nama</label>
                            <div class="col-lg-8"><input type="text" name="Nama" id="Nama" value="<?php echo $EditNama; ?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Unit Kerja Desa/Kelurahan</label>
                            <div class="col-lg-8">
                                <?php include "../App/Control/FunctionSelectUnitKerja.php"; ?>
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
                                    <a href="?pg=UserView" class="btn btn-success ">Batal</a>
                                <?php } else { ?>
                                    <button class="btn btn-primary" type="submit" name="Edit" id="Edit">Save</button>
                                    <a href="?pg=UserView" class="btn btn-success ">Batal</a>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
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

<script src="../Assets/js/notification-handler.js"></script>