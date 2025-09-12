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
        <h2>Data Mutasi</h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Input Mutasi</h5>&nbsp;<span style="font-style: italic; color:red">*) Wajib Diisi</span>
                </div>

                <?php
                $CekMutasi = mysqli_query($db, "SELECT * FROM history_mutasi WHERE IdPegawaiFK = '$IdTemp' ");
                while ($Result = mysqli_fetch_assoc($CekMutasi)) {
                    $IdPeg = $Result['IdPegawaiFK'];
                    $JenMutasi = $Result['JenisMutasi'];
                }

                if ($JenMutasi == 3 or $JenMutasi == 4 or $JenMutasi == 5) { ?>
                    <div class="ibox-content">
                        <div class="row" style="color: brown;">
                            <div class="col-lg-12">
                                <h5>DATA MUTASI TIDAK DAPAT DI TAMBAHKAN<br>
                                    SILAHKAN HUBUNGI ADMIN DINAS PEMBERDAYAAN MASYARAKAT DESA
                                </h5>
                            </div>
                        </div>
                        <a href="?pg=ViewMutasiAdminDesa" class="btn btn-success ">Batal</a>
                    </div>
                <?php } else { ?>
                    <div class="ibox-content">
                        <form action="../App/Model/ExcHistoryMutasiAdminDesa?Act=Save" method="POST"
                            enctype="multipart/form-data" onsubmit="return validateFile()">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="hidden" name="IdPegawaiFK" id="IdPegawaiFK"
                                        value="<?php echo $IdPegawaiFK; ?>" class="form-control" readonly>
                                    <div class="form-group row"><label class="col-lg-3 col-form-label">NIK</label>
                                        <div class="col-lg-8"><input type="text" name="NIK" id="NIK"
                                                value="<?php echo $NIK; ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row"><label class="col-lg-3 col-form-label">Mutasi Dari</label>
                                        <div class="col-lg-8"><input type="text" name="Nama" id="Nama"
                                                value="<?php echo $Nama; ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="TanggalLahir">
                                        <label class="col-lg-3 col-form-label">Tanggal SK Mutasi<span
                                                style="font-style: italic; color:red">*</label>
                                        <div class="col-lg-4">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="TanggalMutasi" id="TanggalMutasi"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <span style="font-style: italic; color:black;">Contoh : 16-01-1980</span>
                                        </div>
                                    </div>
                                    <div class="form-group row"><label class="col-lg-3 col-form-label">Nomer SK<span
                                                style="font-style: italic; color:red">*</span></label>
                                        <div class="col-lg-8"><input type="text" name="NomerSK" id="NomerSK"
                                                class="form-control" placeholder="Masukkan Nomer SK" autocomplete="off"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row"><label class="col-lg-3 col-form-label">Jenis Mutasi<span
                                                style="font-style: italic; color:red">*</span></label>
                                        <div class="col-lg-8">
                                            <select name="JenisMutasi" id="JenisMutasi" style="width: 100%;"
                                                class="select2_pendidikan form-control" required>
                                                <option value="">Pilih Jenis Mutasi</option>
                                                <?php
                                                $QueryMutasi = mysqli_query($db, "SELECT * FROM master_mutasi ORDER BY IdMutasi ASC");
                                                while ($DataMutasi = mysqli_fetch_assoc($QueryMutasi)) {
                                                    $IdMutasi = $DataMutasi['IdMutasi'];
                                                    $JenisMutasi = $DataMutasi['Mutasi'];
                                                    ?>
                                                    <option value="<?php echo $IdMutasi; ?>"><?php echo $JenisMutasi; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row"><label class="col-lg-3 col-form-label">Jabatan<span
                                                style="font-style: italic; color:red">*</span></label>
                                        <div class="col-lg-8">
                                            <select name="Jabatan" id="Jabatan" style="width: 100%;"
                                                class="select2_pendidikan form-control" required>
                                                <option value="">Pilih Jabatan</option>
                                                <?php
                                                $QueryJabatan = mysqli_query($db, "SELECT * FROM master_jabatan ORDER BY IdJabatan ASC");
                                                while ($DataJabatan = mysqli_fetch_assoc($QueryJabatan)) {
                                                    $IdJabatan = $DataJabatan['IdJabatan'];
                                                    $Jabatan = $DataJabatan['Jabatan'];
                                                    ?>
                                                    <option value="<?php echo $IdJabatan; ?>"><?php echo $Jabatan; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <!--
                                    <div class="form-group row" id="TanggalLahir">
                                        <label class="col-lg-3 col-form-label">Tanggal MT</label>
                                        <div class="col-lg-4">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="TanggalTMT" id="TanggalTMT" class="form-control" required>
                                            </div>
                                        </div>
                                    </div> -->

                                    <!-- PREVIEW UPLOAD FOTO -->
                                    <div class="form-group row"><label class="col-lg-3 col-form-label">Upload File SK<span
                                                style="font-style: italic; color:red">*</span></label>
                                        <div class="col-lg-8">
                                            <div class="custom-file">
                                                <input type="file" name="FUpload" id="File" accept="application/pdf"
                                                    class="custom-file-input" autofocus required>
                                                <label for="FotoUpload" class="custom-file-label">Pilih File :
                                                    pdf</label>
                                            </div>
                                            <span class="form-text m-b-none" style="font-style: italic;">*) Ukuran File Max
                                                2 MB</span>
                                        </div>
                                    </div>
                                    <!-- SELESAI PREVIEW UPLOAD FOTO -->

                                    <div class="form-group row"><label class="col-lg-3 col-form-label">Keterangan</label>
                                        <div class="col-lg-8"><input type="text" name="Keterangan" id="Keterangan"
                                                class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit" name="Save" id="Save">Save</button>
                                    <a href="?pg=ViewMutasiAdminDesa" class="btn btn-success ">Batal</a>
                                </div>
                            </div>
                        </form>
                        <script>
                            function validateFile() {
                                const fileInput = document.querySelector('input[name="FUpload"]');
                                const filePath = fileInput.value;
                                const allowedExtensions = /(\.pdf)$/i;
                                if (!allowedExtensions.exec(filePath)) {
                                    alert('Hanya file PDF yang diizinkan.');
                                    fileInput.value = '';
                                    return false;
                                }
                                return true;
                            }
                        </script>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>