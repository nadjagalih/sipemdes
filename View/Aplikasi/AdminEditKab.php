<?php include "../App/Control/FunctionPegawaiEdit.php"; ?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Validasi Data Admin Aplikasi Kabupaten</h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Edit Data</h5>&nbsp;<span style="font-style: italic; color:red">*) Wajib Diisi</span>
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
                    <form action="../App/Model/ExcAdminAplikasiKab?Act=Edit" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="IdPegawaiFK" id="IdPegawaiFK" value="<?php echo $IdPegawaiFK; ?>" class="form-control" readonly>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK<span style="font-style: italic; color:red">*</span></label>
                                    <script>
                                        function hanyaAngka(evt) {
                                            var charCode = (evt.which) ? evt.which : event.keyCode
                                            if (charCode > 31 && (charCode < 48 || charCode > 57))

                                                return false;
                                            return true;
                                        }
                                    </script>
                                    <div class="col-lg-8"><input type="text" name="NIK" id="NIK" value="<?php echo $NIK; ?>" placeholder="Masukkan NIK" class="form-control" autocomplete="off" required onkeypress="return hanyaAngka(event)">
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nama Operator<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <input type="text" name="Nama" id="Nama" value="<?php echo $Nama; ?>" placeholder="Masukkan Nama" class="form-control" autocomplete="off" required maxlength="100">
                                        <span class="form-text m-b-none" style="font-style: italic; color:red">Isi Dengan Nama Pemegang Admin Aplikasi</span>
                                    </div>
                                </div>

                                <?php
                                $QueryJabatanAdmin = mysqli_query($db, "SELECT
                                master_admin_aplikasi.IdPegawaiFK,
                                master_admin_aplikasi.IdJabatanFK,
                                master_jabatan.IdJabatan,
                                master_jabatan.Jabatan
                                FROM
                                master_admin_aplikasi
                                INNER JOIN
                                master_jabatan
                                ON
                                    master_admin_aplikasi.IdJabatanFK = master_jabatan.IdJabatan
                                    WHERE IdPegawaiFK ='$IdPegawaiFK'");
                                $DataJabatanAdmin = mysqli_fetch_assoc($QueryJabatanAdmin);
                                $IdJabatanAdmin = $DataJabatanAdmin['IdJabatanFK'];
                                $NamaJabatanAdmin = $DataJabatanAdmin['Jabatan'];
                                ?>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Jabatan<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <select name="Jabatan" id="Jabatan" style="width: 100%;" class="select2_pendidikan form-control" required>
                                            <!-- <option value="">Pilih Jabatan</option> -->
                                            <option value="<?php echo $IdJabatanAdmin; ?>"><?php echo $NamaJabatanAdmin; ?></option>
                                            <?php
                                            $QueryJabatan = mysqli_query($db, "SELECT * FROM master_jabatan WHERE IdJabatan <> '$IdJabatanAdmin' ORDER BY IdJabatan ASC");
                                            while ($DataJabatan = mysqli_fetch_assoc($QueryJabatan)) {
                                                $IdJabatan = $DataJabatan['IdJabatan'];
                                                $Jabatan = $DataJabatan['Jabatan'];
                                            ?>
                                                <option value="<?php echo $IdJabatan; ?>"><?php echo $Jabatan; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Status Kepegawaian<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php include "../App/Control/FunctionSelectStatusPegawai.php"; ?>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Unit Kerja Desa/Kelurahan<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php include "../App/Control/FunctionSelectUnitKerja.php"; ?>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Telp<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="Telp" id="Telp" value="<?php echo $Telp; ?>" placeholder="Masukkan No Telp" class="form-control" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group row"><label class="col-lg-3 col-form-label">Foto Saat Ini</label>
                                    <div class="col-lg-8">
                                        <?php if (empty($Foto)) { ?>
                                            <img style="width:190px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/no-image.jpg">
                                        <?php } else { ?>
                                            <img style="width:190px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/<?php echo $Foto; ?>">
                                        <?php } ?>
                                    </div>
                                </div>

                                <button class="btn btn-primary" type="submit" name="Edit" id="Edit">Save</button>
                                <a href="?pg=PegawaiViewAll" class="btn btn-success ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>