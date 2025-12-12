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

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Input Mutasi</h5>&nbsp;<span style="font-style: italic; color:red">*) Wajib Diisi</span>
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
                        <a href="?pg=ViewMutasiAdminDesa" class="btn btn-success ">Batal</a>
                    </div>
                <?php } else { ?>
                    <div class="ibox-content">
                        <form action="../App/Model/ExcHistoryMutasiAdminDesa?Act=Save&IdPegawai=<?php echo $IdPegawaiFK; ?>&tab=tab-5" method="POST"
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
                                                <label for="File" class="custom-file-label">Pilih File SK (PDF)</label>
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

                                    <button class="btn btn-primary" type="submit" name="Save" id="SaveMutasi">Save</button>
                                    <a href="?pg=PegawaiDetailAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>&tab=tab-5" class="btn btn-success ">Batal</a>
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

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Mutasi</th>
                <th>Jabatan</th>
                <th>Tanggal Mutasi</th>
                <th>Nomor SK <br>SK Mutasi</th>
                <th>Set Mutasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_GET['Kode'])) {
                $IdTemp = sql_url($_GET['Kode']);
                $No = 1;
                $QMutasiView = mysqli_query($db, "SELECT
                                        history_mutasi.JenisMutasi,
                                        history_mutasi.IdMutasi,
                                        master_mutasi.Mutasi,
                                        history_mutasi.IdJabatanFK,
                                        master_jabatan.IdJabatan,
                                        master_jabatan.Jabatan,
                                        history_mutasi.NomorSK,
                                        history_mutasi.TanggalMutasi,
                                        history_mutasi.FileSKMutasi,
                                        history_mutasi.Setting,
                                        history_mutasi.KeteranganJabatan,
                                        master_mutasi.IdMutasi AS MasterId,
                                        history_mutasi.IdPegawaiFK
                                        FROM history_mutasi
                                        INNER JOIN master_mutasi ON history_mutasi.JenisMutasi = master_mutasi.IdMutasi
                                        INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                                        WHERE history_mutasi.IdPegawaiFK = '$IdTemp'
                                        ORDER BY history_mutasi.TanggalMutasi DESC");
                while ($DataView = mysqli_fetch_assoc($QMutasiView)) {
                    $IdMutasi = $DataView['IdMutasi'];
                    $JenisMutasi = $DataView['Mutasi'];
                    $Jabatan = $DataView['Jabatan'];
                    $TglMutasi = $DataView['TanggalMutasi'];
                    $exp = explode('-', $TglMutasi);
                    $TanggalMutasi = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
                    $NomorSK = $DataView['NomorSK'];
                    $SKMutasi = $DataView['FileSKMutasi'];
                    $SetMutasi = $DataView['Setting'];
            ?>
                    <tr class="gradeX">
                        <td><?php echo $No; ?> </td>
                        <td><?php echo $JenisMutasi; ?> </td>
                        <td><?php echo $Jabatan; ?> </td>
                        <td><?php echo $TanggalMutasi; ?> </td>
                        <td>Nomor SK : <?php echo $NomorSK; ?>
                            <br>
                            <?php if (!empty($SKMutasi)) { ?>
                                <a target='_BLANK' href='../Module/File/ViewSKMutasi.php?id=<?php echo $IdMutasi; ?>'>Lihat File SK</a>
                            <?php } else { ?>
                                <small class="text-muted">Belum ada file SK</small>
                            <?php } ?>
                        </td>

                        <td>
                            <?php if ($SetMutasi == 0) { ?>
                                <span class="label label-warning float-left">NON AKTIF</span>
                            <?php } elseif ($SetMutasi == 1) { ?>
                                <span class="label label-success float-left">AKTIF</span>
                            <?php } ?>
                        </td>
                        
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="?pg=EditMutasiAdminDesa&Kode=<?php echo $IdMutasi; ?>&IdPegawai=<?php echo $IdTemp; ?>&tab=tab-5" 
                                    class="btn btn-warning btn-sm" title="Edit Data">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <button 
                                    class="btn btn-danger btn-sm btn-delete-mutasi" 
                                    title="Hapus Data"
                                    data-id="<?php echo htmlspecialchars($IdMutasi); ?>"
                                    data-jenis="<?php echo htmlspecialchars($JenisMutasi); ?>"
                                    data-jabatan="<?php echo htmlspecialchars($Jabatan); ?>"
                                    data-pegawai="<?php echo htmlspecialchars($IdTemp); ?>">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
            <?php $No++;
                }
            } ?>
        </tbody>
    </table>
</div>

<?php
// Generate CSP nonce for inline script with enhanced security
$nonce = '';
$nonceAttr = '';

// Enhanced CSP nonce generation with fallback
if (class_exists('CSPHandler')) {
    try {
        $nonce = CSPHandler::scriptNonce();
        $nonceAttr = $nonce;
    } catch (Exception $e) {
        error_log("CSPHandler error: " . $e->getMessage());
        $nonceAttr = ''; // Fallback tanpa nonce
    }
} else {
    // Manual nonce generation sebagai fallback
    if (function_exists('random_bytes')) {
        $manualNonce = base64_encode(random_bytes(16));
        $nonceAttr = 'nonce="' . $manualNonce . '"';
        error_log("Manual nonce generated: " . $manualNonce);
    } else {
        error_log("CSPHandler not available and random_bytes not supported");
        $nonceAttr = ''; // Fallback tanpa nonce
    }
}

// Log untuk debugging
error_log("CSP nonce for FunctionProfileMutasi: " . $nonceAttr);
?>

<script <?php echo $nonceAttr; ?>>
// Enhanced CSP-compliant script for Mutasi delete
document.addEventListener('DOMContentLoaded', function() {
    console.log('FunctionProfileMutasi script loaded with CSP nonce');
    console.log('SweetAlert2 available:', typeof Swal !== 'undefined');
    console.log('jQuery available:', typeof $ !== 'undefined');
    
    // Delay untuk memastikan semua library sudah load
    setTimeout(function() {
        console.log('Setting up CSP-compliant delete event handlers for Mutasi...');
        
        // Native JavaScript Event Delegation (CSP-compliant)
        document.addEventListener('click', function(e) {
            var deleteBtn = e.target.closest('.btn-delete-mutasi');
            if (deleteBtn) {
                console.log('Mutasi delete button found:', deleteBtn);
                e.preventDefault();
                e.stopPropagation();
                
                var idMutasi = deleteBtn.getAttribute('data-id');
                var jenisMutasi = deleteBtn.getAttribute('data-jenis');
                var jabatan = deleteBtn.getAttribute('data-jabatan');
                var idPegawai = deleteBtn.getAttribute('data-pegawai');
                
                console.log('=== CSP-COMPLIANT MUTASI DELETE BUTTON CLICKED ===');
                console.log('Data attributes:', {
                    id: idMutasi,
                    jenis: jenisMutasi,
                    jabatan: jabatan,
                    pegawai: idPegawai
                });
                
                confirmDeleteMutasi(idMutasi, jenisMutasi, jabatan, idPegawai);
                return false;
            }
        });
        
        // jQuery event delegation sebagai backup
        if (typeof $ !== 'undefined') {
            $(document).off('click.deleteMutasi').on('click.deleteMutasi', '.btn-delete-mutasi', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                console.log('jQuery Mutasi delete event triggered');
                
                var idMutasi = $(this).data('id');
                var jenisMutasi = $(this).data('jenis');
                var jabatan = $(this).data('jabatan');
                var idPegawai = $(this).data('pegawai');
                
                console.log('jQuery Mutasi data:', {
                    id: idMutasi,
                    jenis: jenisMutasi,
                    jabatan: jabatan,
                    pegawai: idPegawai
                });
                
                confirmDeleteMutasi(idMutasi, jenisMutasi, jabatan, idPegawai);
                return false;
            });
        }
        
    }, 1000); // Delay 1 detik untuk memastikan DataTables sudah selesai
});

// CSP-compliant confirmation function for Mutasi
function confirmDeleteMutasi(idMutasi, jenisMutasi, jabatan, idPegawai) {
    console.log('=== CSP-COMPLIANT MUTASI DELETE CONFIRMATION TRIGGERED ===');
    console.log('Parameters:', {
        idMutasi: idMutasi,
        jenisMutasi: jenisMutasi,
        jabatan: jabatan,
        idPegawai: idPegawai
    });
    console.log('SweetAlert2 check:', typeof Swal !== 'undefined');
    
    if (typeof Swal !== 'undefined') {
        console.log('Showing CSP-compliant SweetAlert2 confirmation for Mutasi...');
        
        // CSP-compliant SweetAlert2 configuration
        Swal.fire({
            title: 'Apakah Anda yakin?',
            html: 'Data mutasi <strong>' + escapeHtml(jenisMutasi) + 
                  '</strong> untuk jabatan <strong>' + escapeHtml(jabatan) + 
                  '</strong> akan dihapus secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            allowOutsideClick: false,
            allowEscapeKey: true,
            customClass: {
                container: 'my-swal'
            },
            zIndex: 10000
        }).then((result) => {
            console.log('SweetAlert2 Mutasi result:', result);
            
            if (result.isConfirmed) {
                console.log('Mutasi delete confirmed by user');
                
                // Show loading dengan CSP-compliant configuration
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu sebentar',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Build delete URL dengan proper encoding
                var deleteUrl = '../App/Model/ExcHistoryMutasiAdminDesa?Act=Delete&Kode=' + 
                               encodeURIComponent(idMutasi) + 
                               '&IdPegawai=' + encodeURIComponent(idPegawai) + 
                               '&tab=tab-5';
                
                console.log('Redirecting to:', deleteUrl);
                
                // Redirect after short delay
                setTimeout(function() {
                    window.location.href = deleteUrl;
                }, 500);
                
            } else if (result.isDismissed) {
                console.log('Mutasi delete cancelled by user');
            }
        }).catch((error) => {
            console.error('SweetAlert2 error (possible CSP issue):', error);
            // CSP-safe fallback confirmation
            if (confirm('SweetAlert2 error (CSP?). Data mutasi "' + jenisMutasi + 
                       '" untuk jabatan "' + jabatan + '" akan dihapus secara permanen. Apakah Anda yakin?')) {
                var deleteUrl = '../App/Model/ExcHistoryMutasiAdminDesa?Act=Delete&Kode=' + 
                               encodeURIComponent(idMutasi) + 
                               '&IdPegawai=' + encodeURIComponent(idPegawai) + 
                               '&tab=tab-5';
                window.location.href = deleteUrl;
            }
        });
        
    } else {
        console.log('SweetAlert2 not available (possible CSP block), using native confirm');
        // CSP-safe fallback untuk browser yang tidak support SweetAlert2
        if (confirm('Apakah Anda yakin? Data mutasi "' + jenisMutasi + '" untuk jabatan "' + jabatan + '" akan dihapus secara permanen!')) {
            console.log('Mutasi delete confirmed via native confirm');
            var deleteUrl = '../App/Model/ExcHistoryMutasiAdminDesa?Act=Delete&Kode=' + 
                           encodeURIComponent(idMutasi) + 
                           '&IdPegawai=' + encodeURIComponent(idPegawai) + 
                           '&tab=tab-5';
            console.log('Redirecting to:', deleteUrl);
            window.location.href = deleteUrl;
        } else {
            console.log('Mutasi delete cancelled via native confirm');
        }
    }
}

// CSP-compliant HTML escaping function
function escapeHtml(text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}
</script>

<script <?php echo $nonceAttr; ?>>
// Enhanced CSP-compliant file selection script
document.addEventListener('DOMContentLoaded', function() {
    // Update label ketika file dipilih dengan CSP compliance
    var fileInput = document.getElementById('File');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            var fileName = this.files[0] ? this.files[0].name : 'Pilih File SK (PDF)';
            var label = this.nextElementSibling;
            if (label) {
                label.textContent = fileName;
            }
            console.log('File selected:', fileName);
        });
    }
});
</script>