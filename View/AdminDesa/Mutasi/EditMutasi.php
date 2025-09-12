<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);
    $Nomor = 1;
    $QueryMutasi = mysqli_query($db, "SELECT
                master_pegawai.IdPegawaiFK,
                history_mutasi.IdPegawaiFK AS IdPeg,
                master_pegawai.NIK,
                master_pegawai.Nama,
                history_mutasi.TanggalMutasi,
                history_mutasi.NomorSK,
                history_mutasi.JenisMutasi,
                history_mutasi.IdJabatanFK,
                history_mutasi.TanggalTMT,
                history_mutasi.FileSKMutasi,
                history_mutasi.IdMutasi,
                history_mutasi.KeteranganJabatan,
                master_mutasi.IdMutasi AS MasterId,
                master_mutasi.Mutasi,
                master_jabatan.IdJabatan,
                master_jabatan.Jabatan
                FROM history_mutasi
                INNER JOIN master_pegawai ON history_mutasi.IdPegawaiFK = master_pegawai.IdPegawaiFK
                INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                INNER JOIN master_mutasi ON history_mutasi.JenisMutasi = master_mutasi.IdMutasi
                WHERE history_mutasi.IdMutasi = '$IdTemp' ");

    $DataMutasi = mysqli_fetch_assoc($QueryMutasi);

    $IdPegawaiFK = $DataMutasi['IdPeg'];
    $NIK = $DataMutasi['NIK'];
    $Nama = $DataMutasi['Nama'];

    $IdMutasi = $DataMutasi['IdMutasi'];

    $TglSKMutasi = $DataMutasi['TanggalMutasi'];
    $exp = explode('-', $TglSKMutasi);
    $TanggalSKMutasi = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

    $NomerSK = $DataMutasi['NomorSK'];
    $JenisMutasi = $DataMutasi['JenisMutasi'];
    $Mutasi = $DataMutasi['Mutasi'];
    $IdJabatan = $DataMutasi['IdJabatan'];
    $Jabatan = $DataMutasi['Jabatan'];

    $TglTMT = $DataMutasi['TanggalTMT'];
    $exp1 = explode("-", $TglTMT);
    $TanggalTMT = $exp1[2] . "-" . $exp1[1] . "-" . $exp1[0];

    $FileSK = $DataMutasi['FileSKMutasi'];
    $Keterangan = $DataMutasi['KeteranganJabatan'];
}
?>

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
                    <h5>Form Edit Mutasi</h5>&nbsp;<span style="font-style: italic; color:red">*) Wajib Diisi</span>
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
                    <form action="../App/Model/ExcHistoryMutasiAdminDesa?Act=Edit" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="IdMutasi" id="IdMutasi" value="<?php echo $IdMutasi; ?>" class="form-control" readonly>
                            <div class="col-lg-6">
                                <input type="hidden" name="IdPegawaiFK" id="IdPegawaiFK" value="<?php echo $IdPegawaiFK; ?>" class="form-control" readonly>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK</label>
                                    <div class="col-lg-8"><input type="text" name="NIK" id="NIK" value="<?php echo $NIK; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Mutasi Dari</label>
                                    <div class="col-lg-8"><input type="text" name="Nama" id="Nama" value="<?php echo $Nama; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row" id="TanggalLahir">
                                    <label class="col-lg-3 col-form-label">Tanggal SK Mutasi<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-4">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="TanggalMutasi" id="TanggalMutasi" class="form-control" value="<?php echo $TanggalSKMutasi; ?>" required>
                                        </div>
                                    </div <div class="col-lg-4">
                                    <span style="font-style: italic; color:black;">Contoh : 16-01-1980</span>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nomer SK<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NomerSK" id="NomerSK" class="form-control" value="<?php echo $NomerSK; ?>" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>




                            <div class="col-lg-6">
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Jenis Mutasi<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <select name="JenisMutasi" id="JenisMutasi" style="width: 100%;" class="select2_pendidikan form-control" required>
                                            <option value="<?php echo $JenisMutasi; ?>"><?php echo $Mutasi; ?></option>
                                            <?php
                                            $QueryMutasi = mysqli_query($db, "SELECT * FROM master_mutasi Where IdMutasi <> '$JenisMutasi' ORDER BY IdMutasi ASC");
                                            while ($DataMutasi = mysqli_fetch_assoc($QueryMutasi)) {
                                                $IdMutasi = $DataMutasi['IdMutasi'];
                                                $JenisMutasi = $DataMutasi['Mutasi'];
                                            ?>
                                                <option value="<?php echo $IdMutasi; ?>"><?php echo $JenisMutasi; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Jabatan<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <select name="Jabatan" id="Jabatan" style="width: 100%;" class="select2_pendidikan form-control" required>
                                            <option value="<?php echo $IdJabatan; ?>"><?php echo $Jabatan; ?></option>
                                            <?php
                                            $QueryJabatan = mysqli_query($db, "SELECT * FROM master_jabatan WHERE IdJabatan <>'$IdJabatan' ORDER BY IdJabatan ASC");
                                            while ($DataJabatan = mysqli_fetch_assoc($QueryJabatan)) {
                                                $IdJabatan = $DataJabatan['IdJabatan'];
                                                $Jabatan = $DataJabatan['Jabatan'];
                                            ?>
                                                <option value="<?php echo $IdJabatan; ?>"><?php echo $Jabatan; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="form-group row" id="TanggalLahir">
                                    <label class="col-lg-3 col-form-label">Tanggal MT</label>
                                    <div class="col-lg-4">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="TanggalTMT" id="TanggalTMT" class="form-control" value="<?php echo $TanggalTMT; ?>">
                                        </div>
                                    </div>
                                </div> -->

                                <div class="form-group row"><label class="col-lg-3 col-form-label">Keterangan</label>
                                    <div class="col-lg-8"><input type="text" name="Keterangan" id="Keterangan" class="form-control" value="<?php echo $Keterangan; ?>" autocomplete="off">
                                    </div>
                                </div>

                                <button class="btn btn-primary" type="submit" name="Edit" id="Edit">Save</button>
                                <a href="?pg=ViewMutasiAdminDesa" class="btn btn-success ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>