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
        font-weight: bold;
    }

    .status-no-sukses {
        background: white;
        color: red;
        font-weight: bold;
    }

    .ibox {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: none;
    }

    .ibox-content {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }

    .form-control-lg {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 15px 20px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .form-control-lg:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        transform: translateY(-2px);
    }

    .input-group-text {
        border-radius: 10px 0 0 10px;
        border: 2px solid #e9ecef;
        border-right: none;
        background: #f8f9fa;
        color: #6c757d;
        width: 50px;
        justify-content: center;
    }

    .form-label {
        color: #495057;
        margin-bottom: 8px;
        font-size: 15px;
    }

    .btn-lg {
        border-radius: 25px;
        padding: 12px 30px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(45deg, #007bff, #0056b3);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,123,255,0.4);
    }

    .btn-secondary {
        background: linear-gradient(45deg, #6c757d, #545b62);
        border: none;
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108,117,125,0.4);
    }

    .bg-primary {
        background: linear-gradient(45deg, #007bff, #0056b3) !important;
    }

    .justify-content-center {
        justify-content: center;
    }

    .shadow-lg {
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
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
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="ibox shadow-lg border-0">
                <div class="ibox-title text-center bg-primary text-white" style="border-radius: 10px 10px 0 0;">
                    <h4 class="mb-0"><i class="fa fa-user-plus mr-2"></i>Form Input User</h4>
                </div>
                <div class="ibox-content" style="padding: 40px; border-radius: 0 0 10px 10px;">
                    <form action="../App/Model/ExcUserAdminDesa?Act=Save" method="POST" enctype="multipart/form-data">
                        
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">Nama Lengkap</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" name="UserNamaLengkap" placeholder="Masukkan Nama Lengkap" class="form-control form-control-lg" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">Username</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="fa fa-at"></i></span>
                                </div>
                                <input type="text" name="UserNama" id="UserNama" onkeyup="checkAvailability()" placeholder="Masukkan Username" class="form-control form-control-lg" required autocomplete="off">
                            </div>
                            <span id="UserAvailabilityStatus" class="form-text mt-2"></span>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="fa fa-lock"></i></span>
                                </div>
                                <input type="password" name="UserPassword" placeholder="Masukkan Password" class="form-control form-control-lg" required minlength="5">
                            </div>
                            <small class="form-text text-muted">Password minimal 5 karakter</small>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">Unit Kerja</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="fa fa-building"></i></span>
                                </div>
                                <select name="UserUnitKerja" class="form-control form-control-lg" required>
                                    <option value="">Pilih Unit Kerja</option>
                                    <option value="Desa">Desa</option>
                                    <option value="Kecamatan">Kecamatan</option>
                                    <option value="Kabupaten">Kabupaten</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">Level</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="fa fa-shield"></i></span>
                                </div>
                                <select name="UserLevel" class="form-control form-control-lg" required>
                                    <option value="">Pilih Level</option>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                    <option value="Operator">Operator</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">Status</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="fa fa-toggle-on"></i></span>
                                </div>
                                <select name="UserStatus" class="form-control form-control-lg" required>
                                    <option value="">Pilih Status</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group text-center mt-5">
                            <button type="submit" class="btn btn-primary btn-lg px-5 mr-3">
                                <i class="fa fa-save mr-2"></i>Simpan
                            </button>
                            <a href="?pg=UserViewAdminDesa" class="btn btn-secondary btn-lg px-5">
                                <i class="fa fa-arrow-left mr-2"></i>Kembali
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>