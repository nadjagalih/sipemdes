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
                </div>
                <div class="ibox-content">
                    <?php 
                    // Check if coming from detail pegawai page
                    $additionalParams = '';
                    if (isset($_GET['IdPegawai']) && isset($_GET['tab'])) {
                        $IdPegawaiParam = sql_injeksi($_GET['IdPegawai']);
                        $tabParam = sql_injeksi($_GET['tab']);
                        $additionalParams = "&IdPegawai=" . $IdPegawaiParam . "&tab=" . $tabParam;
                    }
                    ?>
                    <form action="../App/Model/ExcHistoryMutasiAdminDesa?Act=Edit<?php echo $additionalParams; ?>" method="POST" enctype="multipart/form-data">
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
                                    </div> 
                                    <div class="col-lg-4">
                                    <span style="font-style: italic; color:black;">Contoh : 16-01-1980</span>
                                    </div>
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

                                <?php
                                // Ambil status Setting dari database
                                $QuerySetting = mysqli_query($db, "SELECT Setting FROM history_mutasi WHERE IdMutasi = '$IdTemp'");
                                $DataSetting = mysqli_fetch_assoc($QuerySetting);
                                $StatusMutasi = $DataSetting['Setting'];
                                ?>

                                <div class="form-group row"><label class="col-lg-3 col-form-label">Status Mutasi<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <select name="StatusMutasi" id="StatusMutasi" class="form-control" required onchange="showStatusInfo()">
                                            <option value="<?php echo $StatusMutasi; ?>">
                                                <?php echo ($StatusMutasi == 1) ? 'AKTIF' : 'NON AKTIF'; ?>
                                            </option>
                                            <?php if ($StatusMutasi == 0) { ?>
                                                <option value="1">AKTIF</option>
                                            <?php } else { ?>
                                                <option value="0">NON AKTIF</option>
                                            <?php } ?>
                                        </select>
                                        <div id="statusInfo" class="mt-2">
                                            <?php if ($StatusMutasi == 1) { ?>
                                                <span class="text-success"><i class="fa fa-info-circle"></i> Mutasi ini sedang aktif</span>
                                            <?php } else { ?>
                                                <span class="text-warning"><i class="fa fa-exclamation-circle"></i> Mutasi ini tidak aktif</span>
                                            <?php } ?>
                                        </div>
                                        <small class="form-text text-muted">
                                            <strong>Catatan:</strong> Hanya satu mutasi yang bisa aktif per pegawai. Jika mengaktifkan mutasi ini, mutasi lain akan otomatis menjadi non-aktif.
                                        </small>
                                    </div>
                                </div>

                                <button class="btn btn-primary" type="submit" name="Edit" id="Edit">Save</button>
                                <?php if (isset($_GET['IdPegawai']) && isset($_GET['tab'])): ?>
                                    <a href="?pg=PegawaiDetailAdminDesa&Kode=<?php echo sql_url($_GET['IdPegawai']); ?>&tab=<?php echo $_GET['tab']; ?>" class="btn btn-success">Batal</a>
                                <?php else: ?>
                                    <a href="?pg=PegawaiDetailAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>&tab=tab-5" class="btn btn-success">Batal</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showStatusInfo() {
    const statusSelect = document.getElementById('StatusMutasi');
    const statusInfo = document.getElementById('statusInfo');
    const selectedValue = statusSelect.value;
    
    if (selectedValue == '1') {
        statusInfo.innerHTML = '<span class="text-success"><i class="fa fa-info-circle"></i> Mutasi ini akan menjadi aktif</span>';
    } else {
        statusInfo.innerHTML = '<span class="text-warning"><i class="fa fa-exclamation-circle"></i> Mutasi ini akan menjadi non-aktif</span>';
    }
}
</script>