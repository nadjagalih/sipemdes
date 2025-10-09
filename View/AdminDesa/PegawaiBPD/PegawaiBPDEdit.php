<?php include "../App/Control/FunctionPegawaiBPDEdit.php"; ?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data BPD</h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Edit Data BPD</h5>&nbsp;<span style="font-style: italic; color:red">*) Wajib Diisi</span>
                    
                </div>
                <div class="ibox-content">
                    <form action="../App/Model/ExcPegawaiBPDAdminDesa?Act=Edit" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="IdPegawaiFK" id="IdPegawaiFK" value="<?php echo htmlspecialchars($IdPegawaiFK); ?>" class="form-control" readonly>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK<span style="font-style: italic; color:red">*</span></label>
                                    <script>
                                        function hanyaAngka(evt) {
                                            var charCode = (evt.which) ? evt.which : event.keyCode
                                            if (charCode > 31 && (charCode < 48 || charCode > 57))

                                                return false;
                                            return true;
                                        }
                                    </script>
                                    <div class="col-lg-8"><input type="text" name="NIK" id="NIK" value="<?php echo htmlspecialchars($NIK); ?>" placeholder="Masukkan NIK" class="form-control" autocomplete="off" required onkeypress="return hanyaAngka(event)">
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nama<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="Nama" id="Nama" value="<?php echo htmlspecialchars($Nama); ?>" placeholder="Masukkan Nama" class="form-control" autocomplete="off" required maxlength="100">
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Tempat Lahir<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="TempatLahir" id="TempatLahir" value="<?php echo htmlspecialchars($TempatLahir); ?>" placeholder="Masukkan Tempat Lahir" class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row" id="TanggalLahir">
                                    <label class="col-lg-3 col-form-label">Tanggal Lahir<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-4">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="TanggalLahir" id="TanggalLahir" class="form-control" value="<?php echo htmlspecialchars($TanggalLahir); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <span style="font-style: italic; color:black;">Contoh : 16-01-1980</span>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Alamat</label>
                                    <div class="col-lg-8"><input type="text" name="Alamat" id="Alamat" value="<?php echo htmlspecialchars($Alamat); ?>" placeholder=" Masukkan Alamat" class="form-control" autocomplete="off" required>
                                    </div><span style="font-style: italic; color:red">*</span>
                                </div>
                                <div class="form-group row"><label class="col-sm-3 col-form-label">RT / RW<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="RT" id="RT" value="<?php echo htmlspecialchars($RT); ?>" placeholder="RT" class="form-control" autocomplete="off" required>
                                            </div><span style="font-style: italic;">/</span>
                                            <div class="col-md-3">
                                                <input type="text" name="RW" id="RW" value="<?php echo htmlspecialchars($RW); ?>" placeholder="RW" class="form-control" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Kelurahan/Desa<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php include "../App/Control/FunctionSelectDesa.php"; ?>
                                    </div>
                                </div>

                                <div class="form-group row"><label class="col-lg-3 col-form-label">Kecamatan<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php include "../App/Control/FunctionSelectKecamatan.php"; ?>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Kabupaten<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php include "../App/Control/FunctionSelectKabupaten.php"; ?>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Jenis Kelamin<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php include "../App/Control/FunctionSelectJenKel.php"; ?>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Agama<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php include "../App/Control/FunctionSelectAgama.php"; ?>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Golongan Darah<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php include "../App/Control/FunctionSelectGolDarah.php"; ?>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Status Pernikahan<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php include "../App/Control/FunctionSelectPernikahan.php"; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Status Kepegawaian<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php include "../App/Control/FunctionSelectStatusPegawai.php"; ?>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Unit Kerja Desa/Kelurahan<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php include "../App/Control/FunctionSelectUnitKerjaAdminDesa.php"; ?>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Telp</label>
                                    <div class="col-lg-8"><input type="text" name="Telp" id="Telp" value="<?php echo htmlspecialchars($Telp); ?>" placeholder="Masukkan No Telp" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Email</label>
                                    <div class="col-lg-8"><input type="email" name="Email" id="Email" value="<?php echo htmlspecialchars($Email); ?>" placeholder="contoh@gmail.com" class="form-control" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group row"><label class="col-lg-3 col-form-label">Foto Saat Ini</label>
                                    <div class="col-lg-8">
                                        <?php if (empty($Foto)) { ?>
                                            <img style="width:190px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/no-image.jpg">
                                        <?php } else { ?>
                                            <img style="width:190px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/<?php echo htmlspecialchars($Foto); ?>">
                                        <?php } ?>
                                    </div>
                                </div>

                                <button class="btn btn-primary" type="submit" name="Edit" id="Edit">Save</button>
                                <a href="?pg=PegawaiBPDViewAllAdminDesa" class="btn btn-success ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>