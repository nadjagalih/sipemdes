<?php include "../App/Control/FunctionPegawaiEdit.php"; ?>

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
        <h2>Data Suami/Istri</h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Input Suami/Istri</h5>&nbsp;<span style="font-style: italic; color:red">*) Wajib Diisi</span>
                </div>
                <div class="ibox-content">
                    <form action="../App/Model/ExcPegawaiSuamiIstriAdminDesa?Act=Save" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="IdPegawaiFK" id="IdPegawaiFK" value="<?php echo $IdPegawaiFK; ?>" class="form-control" readonly>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK</label>
                                    <div class="col-lg-8"><input type="text" name="NIK" id="NIK" value="<?php echo $NIK; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nama</label>
                                    <div class="col-lg-8"><input type="text" name="Nama" id="Nama" value="<?php echo $Nama; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK Suami/Istri<span style="font-style: italic; color:red">*</span></label>
                                    <script>
                                        function hanyaAngka(evt) {
                                            var charCode = (evt.which) ? evt.which : event.keyCode
                                            if (charCode > 31 && (charCode < 48 || charCode > 57))

                                                return false;
                                            return true;
                                        }
                                    </script>
                                    <div class="col-lg-8"><input type="text" name="NIKSuamiIstri" id="NIKSuamiIstri" class="form-control" placeholder="Masukkan NIK Suami/Istri" autocomplete="off" required onkeypress="return hanyaAngka(event)">
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nama Suami/Istri<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NamaSuamiIstri" id="NamaSuamiIstri" class="form-control" placeholder="Masukkan Nama Suami/Istri" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Tempat Lahir<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="TempatLahir" id="TempatLahir" placeholder="Masukkan Tempat Lahir" class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row" id="TanggalLahir">
                                    <label class="col-lg-3 col-form-label">Tanggal Lahir<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-4">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="TanggalLahir" id="TanggalLahir" class="form-control" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <span style="font-style: italic; color:black;">Contoh : 16-01-1980</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Status Hubungan<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <select name="StatusHubungan" id="StatusHubungan" style="width: 100%;" class="select2_hubungan form-control" required>
                                            <option value="">Pilih Status Hubungan</option>
                                            <option value="Suami">Suami</option>
                                            <option value="Istri">Istri</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row" id="TanggalLahir">
                                    <label class="col-lg-3 col-form-label">Tanggal Nikah<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-4">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="TanggalNikah" id="TanggalNikah" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Pendidikan<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php include "../App/Control/FunctionSelectPendidikan.php"; ?>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Pekerjaan</label>
                                    <div class="col-lg-8"><input type="text" name="Pekerjaan" id="Pekerjaan" placeholder="Masukkan Pekerjaan" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit" name="Save" id="Save">Save</button>
                                <a href="?pg=PegawaiViewSuamiIstriAdminDesa" class="btn btn-success ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>