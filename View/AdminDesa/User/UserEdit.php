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
    .status-sukses {
        background: white;
        color: green;
    }

    .status-no-sukses {
        background: white;
        color: red;
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
                </div>
                <div class="ibox-content">
                    <form action="../App/Model/ExcUserAdminDesa?Act=Edit" method="POST" enctype="multipart/form-data">
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