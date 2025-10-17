<?php include "../App/Control/FunctionPegawaiEdit.php"; ?>

<style>
    /* Enhanced styling for form blocking */
    .form-blocked {
        opacity: 0.7;
        pointer-events: none;
        position: relative;
    }
    
    .form-blocked:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(248, 249, 250, 0.3);
        z-index: 1;
    }
    
    .form-blocked input:disabled,
    .form-blocked select:disabled,
    .form-blocked textarea:disabled {
        background-color: #f8f9fa !important;
        cursor: not-allowed !important;
        border-color: #dee2e6 !important;
    }
    
    .alert-info {
        border-left: 4px solid #17a2b8;
    }
    
    .badge-info {
        background-color: #17a2b8;
        color: white;
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
</style>

<?php
// Check if spouse data already exists
$IdTemp = isset($_GET['Kode']) ? sql_url($_GET['Kode']) : '';
$hasSpouseData = false;
$spouseCount = 0;

if ($IdTemp) {
    $QueryCheckSpouse = mysqli_query($db, "SELECT COUNT(*) as total FROM hiskel_suami_istri WHERE IdPegawaiFK = '$IdTemp'");
    if ($QueryCheckSpouse) {
        $DataCheck = mysqli_fetch_assoc($QueryCheckSpouse);
        $spouseCount = $DataCheck['total'];
        $hasSpouseData = ($spouseCount > 0);
    }
}
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Input Suami/Istri</h5>&nbsp;<span style="font-style: italic; color:red">*) Wajib Diisi</span>
                    <?php if ($hasSpouseData): ?>
                        <div class="float-right">
                            <span class="badge badge-info">Data sudah ada - Form dinonaktifkan</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="ibox-content">
                    <?php if ($hasSpouseData): ?>
                        <div class="alert alert-info" role="alert">
                            <i class="fa fa-info-circle"></i> 
                            <strong>Informasi:</strong> Data suami/istri sudah ada untuk pegawai ini. 
                            Anda dapat mengedit atau menghapus data yang sudah ada melalui tabel di bawah, 
                            tetapi tidak dapat menambahkan data baru karena setiap pegawai hanya boleh memiliki satu data suami/istri.
                        </div>
                    <?php endif; ?>
                    
                    <form action="../App/Model/ExcPegawaiSuamiIstriAdminDesa?Act=Save" method="POST" enctype="multipart/form-data" id="spouseForm">
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
                                    <div class="col-lg-8"><input type="text" name="NIKSuamiIstri" id="NIKSuamiIstri" class="form-control" placeholder="Masukkan NIK Suami/Istri" autocomplete="off" required onkeypress="return hanyaAngka(event)" <?php echo $hasSpouseData ? 'disabled' : ''; ?>>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nama Suami/Istri<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NamaSuamiIstri" id="NamaSuamiIstri" class="form-control" placeholder="Masukkan Nama Suami/Istri" autocomplete="off" required <?php echo $hasSpouseData ? 'disabled' : ''; ?>>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Tempat Lahir<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="TempatLahir" id="TempatLahir" placeholder="Masukkan Tempat Lahir" class="form-control" autocomplete="off" required <?php echo $hasSpouseData ? 'disabled' : ''; ?>>
                                    </div>
                                </div>
                                <div class="form-group row" id="TanggalLahir">
                                    <label class="col-lg-3 col-form-label">Tanggal Lahir<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-4">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="TanggalLahir" id="TanggalLahir" class="form-control" value="" required <?php echo $hasSpouseData ? 'disabled' : ''; ?>>
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
                                        <select name="StatusHubungan" id="StatusHubungan" style="width: 100%;" class="select2_hubungan form-control" required <?php echo $hasSpouseData ? 'disabled' : ''; ?>>
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
                                            <input type="text" name="TanggalNikah" id="TanggalNikah" class="form-control" required <?php echo $hasSpouseData ? 'disabled' : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Pendidikan<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php if ($hasSpouseData): ?>
                                            <select class="form-control" disabled>
                                                <option>Form tidak dapat diisi - Data sudah ada</option>
                                            </select>
                                        <?php else: ?>
                                            <?php include "../App/Control/FunctionSelectPendidikan.php"; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Pekerjaan</label>
                                    <div class="col-lg-8"><input type="text" name="Pekerjaan" id="Pekerjaan" placeholder="Masukkan Pekerjaan" class="form-control" autocomplete="off" <?php echo $hasSpouseData ? 'disabled' : ''; ?>>
                                    </div>
                                </div>
                                
                                <?php if (!$hasSpouseData): ?>
                                    <button class="btn btn-primary" type="submit" name="Save" id="Save">Save</button>
                                    <a href="?pg=PegawaiDetailAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>&tab=tab-2" class="btn btn-success">Batal</a>
                                <?php else: ?>
                                    <div class="alert alert-warning" style="margin-top: 20px;">
                                        <i class="fa fa-exclamation-triangle"></i> 
                                        Form tidak dapat digunakan karena data suami/istri sudah ada.
                                        Gunakan tombol Edit atau Hapus pada tabel di bawah untuk mengubah data.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tempat<br>Tanggal Lahir</th>
                <th>Hubungan<br>Tanggal Nikah</th>
                <th>Pendidikan</th>
                <th>Pekerjaan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_GET['Kode'])) {
                $IdTemp = sql_url($_GET['Kode']);
                $Nomor = 1;
                $QuerySuamiIstri = mysqli_query($db, "SELECT
                hiskel_suami_istri.IdPegawaiFK,
                master_pegawai.IdPegawaiFK,
                hiskel_suami_istri.IdPendidikanFK,
                master_pendidikan.IdPendidikan,
                hiskel_suami_istri.IdSuamiIstri,
                hiskel_suami_istri.NIK,
                hiskel_suami_istri.Nama,
                hiskel_suami_istri.Tempat,
                hiskel_suami_istri.TanggalLahir,
                hiskel_suami_istri.StatusHubungan,
                hiskel_suami_istri.TanggalNikah,
                master_pendidikan.JenisPendidikan,
                hiskel_suami_istri.Pekerjaan
                FROM
                hiskel_suami_istri
                INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = hiskel_suami_istri.IdPegawaiFK
                INNER JOIN master_pendidikan ON hiskel_suami_istri.IdPendidikanFK = master_pendidikan.IdPendidikan
                WHERE
                hiskel_suami_istri.IdPegawaiFK = '$IdTemp'");
                while ($DataSuamiIstri = mysqli_fetch_assoc($QuerySuamiIstri)) {
                    $IdSuamiIstri = $DataSuamiIstri['IdSuamiIstri'];
                    $NIK = $DataSuamiIstri['NIK'];
                    $Nama = $DataSuamiIstri['Nama'];
                    $Tempat = $DataSuamiIstri['Tempat'];

                    $TglLahir = $DataSuamiIstri['TanggalLahir'];
                    $exp = explode('-', $TglLahir);
                    $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                    $Hubungan = $DataSuamiIstri['StatusHubungan'];

                    $TglNikah = $DataSuamiIstri['TanggalNikah'];
                    $exp = explode('-', $TglNikah);
                    $TanggalNikah = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                    $Pendidikan = $DataSuamiIstri['JenisPendidikan'];
                    $Pekerjaan = $DataSuamiIstri['Pekerjaan'];

            ?>
            
                    <tr class="gradeX">
                        <td>
                            <?php echo $Nomor; ?>
                        </td>
                        <td>
                            <?php echo $NIK; ?>
                        </td>
                        <td>
                            <?php echo $Nama; ?>
                        </td>
                        <td>
                            <?php echo $Tempat; ?><br>
                            <?php echo $TanggalLahir; ?>
                        </td>
                        <td>
                            <?php echo $Hubungan; ?><br>
                            <?php echo $TanggalNikah; ?>
                        </td>
                        <td>
                            <?php echo $Pendidikan; ?>
                        </td>
                        <td>
                            <?php echo $Pekerjaan; ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="?pg=PegawaiEditSuamiIstriAdminDesa&Kode=<?php echo sql_url($IdSuamiIstri); ?>" 
                                   class="btn btn-warning btn-sm" title="Edit Data">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="#" 
                                   class="btn btn-danger btn-sm btn-delete-suamiistri" 
                                   title="Hapus Data"
                                   data-id="<?php echo htmlspecialchars($IdSuamiIstri); ?>"
                                   data-nama="<?php echo htmlspecialchars($Nama); ?>"
                                   data-pegawai="<?php echo htmlspecialchars($IdTemp); ?>">
                                    <i class="fa fa-trash"></i> Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
            <?php $Nomor++;
                }
            } else {
            ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data suami/istri</td>
                </tr>
            <?php
            }
            ?>
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
error_log("CSP nonce for FunctionProfileSuamiIstri: " . $nonceAttr);
?>

<script <?php echo $nonceAttr; ?>>
// Enhanced CSP-compliant script for SuamiIstri form and delete functionality
document.addEventListener('DOMContentLoaded', function() {
    console.log('FunctionProfileSuamiIstri script loaded with CSP nonce');
    console.log('SweetAlert2 available:', typeof Swal !== 'undefined');
    console.log('jQuery available:', typeof $ !== 'undefined');
    
    var hasSpouseData = <?php echo $hasSpouseData ? 'true' : 'false'; ?>;
    console.log('Has spouse data:', hasSpouseData);
    
    if (hasSpouseData) {
        console.log('Spouse data exists - implementing form blocking...');
        
        // Additional visual feedback dengan CSP compliance
        var formInputs = document.querySelectorAll('#spouseForm input, #spouseForm select, #spouseForm textarea');
        formInputs.forEach(function(input) {
            if (!input.readOnly && !input.disabled && input.type !== 'hidden') {
                input.disabled = true;
                input.style.backgroundColor = '#f8f9fa';
                input.style.cursor = 'not-allowed';
                input.title = 'Form tidak dapat diisi - Data suami/istri sudah ada';
            }
        });
        
        // Add visual styling to disabled form
        var formElement = document.getElementById('spouseForm');
        if (formElement) {
            formElement.style.opacity = '0.7';
            formElement.style.pointerEvents = 'none';
        }
        
        // Show info message if user tries to interact with blocked form
        if (typeof Swal !== 'undefined') {
            var blockedMessage = function() {
                Swal.fire({
                    title: 'Form Diblokir',
                    html: 'Data suami/istri sudah ada untuk pegawai ini.<br>' +
                          'Gunakan tombol <strong>Edit</strong> atau <strong>Hapus</strong> pada tabel untuk mengelola data.',
                    icon: 'info',
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#3085d6',
                    customClass: {
                        container: 'my-swal'
                    }
                });
            };
            
            // Add click handler untuk form yang diblokir
            document.addEventListener('click', function(e) {
                if (e.target.closest('#spouseForm') && e.target.tagName !== 'A') {
                    e.preventDefault();
                    e.stopPropagation();
                    blockedMessage();
                    return false;
                }
            });
        }
        
    } else {
        console.log('No spouse data - form is available for input');
        
        // Enable form submission dengan validation
        var saveButton = document.getElementById('Save');
        if (saveButton) {
            saveButton.addEventListener('click', function(e) {
                console.log('Save button clicked - validating form...');
                
                var requiredFields = document.querySelectorAll('#spouseForm [required]');
                var isValid = true;
                var emptyFields = [];
                
                requiredFields.forEach(function(field) {
                    if (!field.value.trim()) {
                        isValid = false;
                        emptyFields.push(field.getAttribute('name') || field.id);
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Form Tidak Lengkap',
                            html: 'Mohon lengkapi semua field yang wajib diisi:<br>' +
                                  '<strong>' + emptyFields.join(', ') + '</strong>',
                            icon: 'warning',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#f39c12'
                        });
                    } else {
                        alert('Mohon lengkapi semua field yang wajib diisi: ' + emptyFields.join(', '));
                    }
                    return false;
                }
            });
        }
    }
    
    // Delay untuk memastikan semua library sudah load
    setTimeout(function() {
        console.log('Setting up CSP-compliant delete event handlers for SuamiIstri...');
        
        // Native JavaScript Event Delegation (CSP-compliant)
        document.addEventListener('click', function(e) {
            var deleteBtn = e.target.closest('.btn-delete-suamiistri');
            if (deleteBtn) {
                console.log('SuamiIstri delete button found:', deleteBtn);
                e.preventDefault();
                e.stopPropagation();
                
                var idSuamiIstri = deleteBtn.getAttribute('data-id');
                var nama = deleteBtn.getAttribute('data-nama');
                var idPegawai = deleteBtn.getAttribute('data-pegawai');
                
                console.log('=== CSP-COMPLIANT SUAMIISTRI DELETE BUTTON CLICKED ===');
                console.log('Data attributes:', {
                    id: idSuamiIstri,
                    nama: nama,
                    pegawai: idPegawai
                });
                
                confirmDeleteSuamiIstri(idSuamiIstri, nama, idPegawai);
                return false;
            }
        });
        
        // jQuery event delegation sebagai backup
        if (typeof $ !== 'undefined') {
            $(document).off('click.deleteSuamiIstri').on('click.deleteSuamiIstri', '.btn-delete-suamiistri', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                console.log('jQuery SuamiIstri delete event triggered');
                
                var idSuamiIstri = $(this).data('id');
                var nama = $(this).data('nama');
                var idPegawai = $(this).data('pegawai');
                
                console.log('jQuery SuamiIstri data:', {
                    id: idSuamiIstri,
                    nama: nama,
                    pegawai: idPegawai
                });
                
                confirmDeleteSuamiIstri(idSuamiIstri, nama, idPegawai);
                return false;
            });
        }
        
    }, 1000); // Delay 1 detik untuk memastikan DataTables sudah selesai
});

// CSP-compliant confirmation function for SuamiIstri
function confirmDeleteSuamiIstri(idSuamiIstri, nama, idPegawai) {
    console.log('=== CSP-COMPLIANT SUAMIISTRI DELETE CONFIRMATION TRIGGERED ===');
    console.log('Parameters:', {
        idSuamiIstri: idSuamiIstri,
        nama: nama,
        idPegawai: idPegawai
    });
    console.log('SweetAlert2 check:', typeof Swal !== 'undefined');
    
    if (typeof Swal !== 'undefined') {
        console.log('Showing CSP-compliant SweetAlert2 confirmation for SuamiIstri...');
        
        // CSP-compliant SweetAlert2 configuration
        Swal.fire({
            title: 'Konfirmasi Hapus',
            html: 'Apakah Anda yakin ingin menghapus data suami/istri:<br><strong>' + 
                  escapeHtml(nama) + '</strong>?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            allowOutsideClick: false,
            allowEscapeKey: true,
            customClass: {
                container: 'my-swal'
            },
            zIndex: 10000
        }).then((result) => {
            console.log('SweetAlert2 SuamiIstri result:', result);
            
            if (result.isConfirmed) {
                console.log('SuamiIstri delete confirmed by user');
                
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
                var deleteUrl = '../App/Model/ExcPegawaiSuamiIstriAdminDesa?Act=Delete&Kode=' + 
                               encodeURIComponent(idSuamiIstri) + 
                               '&IdPegawai=' + encodeURIComponent(idPegawai) + 
                               '&tab=tab-2';
                
                console.log('Redirecting to:', deleteUrl);
                
                // Redirect after short delay
                setTimeout(function() {
                    window.location.href = deleteUrl;
                }, 500);
                
            } else if (result.isDismissed) {
                console.log('SuamiIstri delete cancelled by user');
            }
        }).catch((error) => {
            console.error('SweetAlert2 error (possible CSP issue):', error);
            // CSP-safe fallback confirmation
            if (confirm('SweetAlert2 error (CSP?). Apakah Anda yakin ingin menghapus data suami/istri "' + 
                       nama + '"?')) {
                var deleteUrl = '../App/Model/ExcPegawaiSuamiIstriAdminDesa?Act=Delete&Kode=' + 
                               encodeURIComponent(idSuamiIstri) + 
                               '&IdPegawai=' + encodeURIComponent(idPegawai) + 
                               '&tab=tab-2';
                window.location.href = deleteUrl;
            }
        });
        
    } else {
        console.log('SweetAlert2 not available (possible CSP block), using native confirm');
        // CSP-safe fallback untuk browser yang tidak support SweetAlert2
        if (confirm('Apakah Anda yakin ingin menghapus data suami/istri "' + nama + '"?')) {
            console.log('SuamiIstri delete confirmed via native confirm');
            var deleteUrl = '../App/Model/ExcPegawaiSuamiIstriAdminDesa?Act=Delete&Kode=' + 
                           encodeURIComponent(idSuamiIstri) + 
                           '&IdPegawai=' + encodeURIComponent(idPegawai) + 
                           '&tab=tab-2';
            console.log('Redirecting to:', deleteUrl);
            window.location.href = deleteUrl;
        } else {
            console.log('SuamiIstri delete cancelled via native confirm');
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