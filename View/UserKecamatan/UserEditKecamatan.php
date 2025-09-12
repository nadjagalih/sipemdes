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
    </div>
</div>