<?php
include "../App/Control/FunctionUserEdit.php";
include "../App/Control/FunctionPegawaiEdit.php";
?>
<script>
    function checkAvailability() {
        // $( "#loaderIcon" ).show();
        jQuery.ajax({
            url: "AdminDesa/User/CheckAvailability.php",
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
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Edit User</h5>
                </div>
                <div class="ibox-content">
                    <form action="../App/Model/ExcUserAdminDesa?Act=Edit" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="IdUser" id="IdUser" value="<?php echo $EditIdUser; ?>">
                        <input type="hidden" name="IdPegawaiFK" id="IdPegawaiFK" value="<?php echo $IdPegawaiFK; ?>">
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Username</label>
                            <div class="col-lg-8">
                                <input type="text" name="UserNama" id="UserNama" onkeyup="checkAvailability()" value="<?php echo $EditNameAkses; ?>" class="form-control" required autocomplete="off">
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
                                <?php include "../App/Control/FunctionSelectAksesAdminDesa.php"; ?>
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
                                <?php include "../App/Control/FunctionSelectUnitKerjaAdminDesa.php"; ?>
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
                                    <a href="?pg=UserViewAdminDesa" class="btn btn-success ">Batal</a>
                                <?php } else { ?>
                                    <button class="btn btn-primary" type="submit" name="Edit" id="Edit">Save</button>
                                    <a href="?pg=UserViewAdminDesa" class="btn btn-success ">Batal</a>
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
                                <strong>Edit Username</strong><br>
                                <small>Ubah username jika diperlukan, sistem akan cek ketersediaan</small>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div style="display: flex; align-items: flex-start;">
                            <span class="step-number">2</span>
                            <div class="step-text">
                                <strong>Update Password</strong><br>
                                <small>Ganti password atau biarkan tetap sama</small>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div style="display: flex; align-items: flex-start;">
                            <span class="step-number">3</span>
                            <div class="step-text">
                                <strong>Ubah Hak Akses</strong><br>
                                <small>Sesuaikan level akses user</small>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div style="display: flex; align-items: flex-start;">
                            <span class="step-number">4</span>
                            <div class="step-text">
                                <strong>Update Nama</strong><br>
                                <small>Perbarui nama lengkap user</small>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div style="display: flex; align-items: flex-start;">
                            <span class="step-number">5</span>
                            <div class="step-text">
                                <strong>Ganti Unit Kerja</strong><br>
                                <small>Pilih unit kerja yang sesuai</small>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div style="display: flex; align-items: flex-start;">
                            <span class="step-number">6</span>
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

<!-- Script untuk mengatasi masalah pace loading yang tidak selesai -->
<script>
    // Force pace loading to complete after page is fully loaded
    window.addEventListener('load', function() {
        // Wait a bit for all scripts to finish
        setTimeout(function() {
            // Force pace to complete if it's still running
            if (typeof Pace !== 'undefined' && Pace.running) {
                Pace.stop();
            }
            // Add pace-done class to body if not already present
            if (!document.body.classList.contains('pace-done')) {
                document.body.classList.add('pace-done');
            }
            // Hide any remaining pace elements
            var paceElements = document.querySelectorAll('.pace');
            paceElements.forEach(function(el) {
                el.style.display = 'none';
            });
        }, 1000); // Wait 1 second after page load
    });

    // Fallback - force pace to complete after DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            if (typeof Pace !== 'undefined' && Pace.running) {
                Pace.stop();
            }
            document.body.classList.add('pace-done');
        }, 2000); // Wait 2 seconds after DOM ready
    });
    
    // Function untuk close notification bar
    function closeNotificationBar() {
        const notifBar = document.querySelector('.notification-bar');
        if (notifBar) {
            notifBar.style.animation = 'slideUp 0.3s ease-out forwards';
            setTimeout(() => {
                notifBar.style.display = 'none';
                // Store in localStorage untuk session ini
                localStorage.setItem('notifBarClosed', 'true');
            }, 300);
        }
    }
    
    // Check apakah notification bar sudah di-close sebelumnya
    document.addEventListener('DOMContentLoaded', function() {
        if (localStorage.getItem('notifBarClosed') === 'true') {
            const notifBar = document.querySelector('.notification-bar');
            if (notifBar) {
                notifBar.style.display = 'none';
            }
        }
    });
</script>