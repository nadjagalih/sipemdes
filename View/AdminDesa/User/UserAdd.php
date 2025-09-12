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
        <div class="col-lg-8">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Form Input User</h5>
                </div>
                <div class="ibox-content">
                    <form action="../App/Model/ExcUserAdminDesa?Act=Save" method="POST" enctype="multipart/form-data">
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Username</label>
                            <div class="col-lg-8">
                                <input type="text" name="UserNama" id="UserNama" onkeyup="checkAvailability()" placeholder="Masukkan Username" class="form-control" required autocomplete="off">

                            </div>
                        </div>
                        <span id="UserAvailabilityStatus" class="form-text m-b-none"></span>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="guide-box">
                <div class="guide-title">
                    <i class="fa fa-info-circle"></i>
                    Panduan Menambah User Baru
                </div>
                
                <ol class="guide-steps">
                    <li>
                        <div style="display: flex; align-items: flex-start;">
                            <span class="step-number">1</span>
                            <div class="step-text">
                                <strong>Buat Username Unik</strong>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div style="display: flex; align-items: flex-start;">
                            <span class="step-number">2</span>
                            <div class="step-text">
                                <strong>Tentukan Password</strong>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div style="display: flex; align-items: flex-start;">
                            <span class="step-number">3</span>
                            <div class="step-text">
                                <strong>Atur Hak Akses</strong>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div style="display: flex; align-items: flex-start;">
                            <span class="step-number">4</span>
                            <div class="step-text">
                                <strong>Isi Nama Lengkap</strong>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div style="display: flex; align-items: flex-start;">
                            <span class="step-number">5</span>
                            <div class="step-text">
                                <strong>Pilih Unit Kerja</strong>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div style="display: flex; align-items: flex-start;">
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