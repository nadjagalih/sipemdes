<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);
    $Nomor = 1;
    $QueryMutasi = mysqli_query($db, "SELECT
                master_pegawai.IdPegawaiFK,
                history_mutasi.IdPegawaiFK,
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
                    <form action="../App/Model/ExcHistoryMutasiAdminDesa?Act=EditSK" method="POST"
                        enctype="multipart/form-data" onsubmit="return validateFile()">
                        <div class=" row">
                        <input type="hidden" name="IdMutasi" id="IdMutasi" value="<?php echo $IdMutasi; ?>"
                            class="form-control" readonly>
                        <div class="col-lg-6">
                            <input type="hidden" name="IdPegawaiFK" id="IdPegawaiFK" value="<?php echo $IdPegawaiFK; ?>"
                                class="form-control" readonly>
                            <div class="form-group row"><label class="col-lg-3 col-form-label">NIK</label>
                                <div class="col-lg-8"><input type="text" name="NIK" id="NIK" value="<?php echo $NIK; ?>"
                                        class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row"><label class="col-lg-3 col-form-label">Mutasi Dari</label>
                                <div class="col-lg-8"><input type="text" name="Nama" id="Nama"
                                        value="<?php echo $Nama; ?>" class="form-control" readonly>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6">

                            <!-- PREVIEW UPLOAD FOTO -->
                            <div class="form-group row"><label class="col-lg-3 col-form-label">Upload File SK</label>
                                <div class="col-lg-8">
                                    <div class="custom-file">
                                        <input type="file" name="FUpload" id="File" accept="application/pdf"
                                            class="custom-file-input" autofocus required>
                                        <label for="FotoUpload" class="custom-file-label">Pilih File : pdf</label>
                                    </div>
                                    <span class="form-text m-b-none" style="font-style: italic;">*) Ukuran File Max 2 MB
                                        <br><?php echo $FileSK; ?>
                                        <input type="hidden" name="FileLama" id="FileLama"
                                            value="<?php echo $FileSK; ?>">
                                    </span>

                                </div><span style="font-style: italic; color:red">*</span>
                            </div>
                            <!-- SELESAI PREVIEW UPLOAD FOTO -->

                            <button class="btn btn-primary" type="submit" name="EditSK" id="EditSK">Save</button>
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
        </div>
    </div>
</div>
</div>