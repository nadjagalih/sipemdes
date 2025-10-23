<?php include "../App/Control/FunctionPegawaiEdit.php";
$TipeMutasi = isset($_GET['TipeMutasi']) ? $_GET['TipeMutasi'] : '';
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
                    <h5>Form Input Mutasi</h5>&nbsp;<span style="font-style: italic; color:red">*) Wajib Diisi</span>
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

                <?php
                $JenMutasi = 0; // Inisialisasi variabel
                $CekMutasi = mysqli_query($db, "SELECT * FROM history_mutasi WHERE IdPegawaiFK = '$IdTemp' ");
                if ($CekMutasi && mysqli_num_rows($CekMutasi) > 0) {
                    while ($Result = mysqli_fetch_assoc($CekMutasi)) {
                        $IdPeg = isset($Result['IdPegawaiFK']) ? $Result['IdPegawaiFK'] : '';
                        $JenMutasi = isset($Result['JenisMutasi']) ? $Result['JenisMutasi'] : 0;
                    }
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
                        <a href="?pg=ViewMutasi" class="btn btn-success ">Batal</a>
                    </div>
                <?php } else { ?>
                    <div class="ibox-content">
                        <form action="../App/Model/ExcHistoryMutasi?Act=Save" method="POST" enctype="multipart/form-data"
                            id="formMutasi">
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
                                                style="font-style: italic; color:red">*</span></label>
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
                                                    <option value="<?php echo $IdMutasi; ?>" <?php if ($TipeMutasi == $IdMutasi)
                                                           echo 'selected'; ?>>
                                                        <?php echo $JenisMutasi; ?>
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

                                    <!-- <div class="form-group row" id="TanggalLahir">
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
                                                <label for="FotoUpload" class="custom-file-label">Pilih File :pdf</label>
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
                                    <a href="?pg=ViewMutasi" class="btn btn-success ">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script <?php echo class_exists('CSPHandler') ? CSPHandler::scriptNonce() : ''; ?>>
document.addEventListener('DOMContentLoaded', function() {
    // Update label dengan nama file yang dipilih
    const fileInput = document.getElementById('File');
    if (fileInput) {
        const fileLabel = fileInput.nextElementSibling;
        
        fileInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const fileName = e.target.files[0].name;
                fileLabel.textContent = fileName;
                fileLabel.style.color = '#1ab394';
            } else {
                fileLabel.textContent = 'Pilih File :pdf';
                fileLabel.style.color = '';
            }
        });
    }
    
    // Form validation
    const formMutasi = document.getElementById('formMutasi');
    if (formMutasi) {
        formMutasi.addEventListener('submit', function(e) {
            const fileInput = document.querySelector('input[name="FUpload"]');
            if (fileInput && fileInput.value) {
                const filePath = fileInput.value;
                const allowedExtensions = /(\.pdf)$/i;
                
                if (!allowedExtensions.exec(filePath)) {
                    e.preventDefault();
                    
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Peringatan!',
                            text: 'Hanya file PDF yang diizinkan.',
                            icon: 'warning',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#f39c12'
                        });
                    } else {
                        alert('Hanya file PDF yang diizinkan.');
                    }
                    
                    fileInput.value = '';
                    // Reset label
                    const fileLabel = fileInput.nextElementSibling;
                    if (fileLabel) {
                        fileLabel.textContent = 'Pilih File :pdf';
                        fileLabel.style.color = '';
                    }
                    return false;
                }
            }
        });
    }
});
</script>