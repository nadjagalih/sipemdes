<?php include "../App/Control/FunctionPegawaiEdit.php"; ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Input Orang Tua</h5>&nbsp;<span style="font-style: italic; color:red">*) Wajib Diisi</span>
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
                    <form action="../App/Model/ExcPegawaiOrtuAdminDesa?Act=Save" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="IdPegawaiFK" id="IdPegawaiFK" value="<?php echo $IdPegawaiFK; ?>" class="form-control" readonly>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK</label>
                                    <div class="col-lg-8"><input type="text" name="NIK" id="NIK" value="<?php echo $NIK; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Orang Tua Dari</label>
                                    <div class="col-lg-8"><input type="text" name="Nama" id="Nama" value="<?php echo $Nama; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK Orang Tua<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NIKOrtu" id="NIKOrtu" class="form-control" placeholder="Masukkan NIK Orang Tua" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nama Orang Tua<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NamaOrtu" id="NamaOrtu" class="form-control" placeholder="Masukkan Nama Orang Tua" autocomplete="off" required>
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
                                            <input type="text" name="TanggalLahir" id="TanggalLahir" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <span style="font-style: italic; color:black;">Contoh : 16-01-1980</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Jenis Kelamin<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <select name="JenKel" id="JenKel" style="width: 100%;" class="select2_jenkel form-control" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <?php
                                            $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel ORDER BY IdJenKel ASC");
                                            while ($DataJenKel = mysqli_fetch_assoc($QueryJenKel)) {
                                                $IdJenKel = $DataJenKel['IdJenKel'];
                                                $JenKel = $DataJenKel['Keterangan'];
                                            ?>
                                                <option value="<?php echo $IdJenKel; ?>"><?php echo $JenKel; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row"><label class="col-lg-3 col-form-label">Status Hubungan<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <select name="StatusHubungan" id="StatusHubungan" style="width: 100%;" class="select2_hubungan form-control" required>
                                            <option value="">Pilih Status Hubungan</option>
                                            <option value="Ayah Kandung">Ayah Kandung</option>
                                            <option value="Ibu Kandung">Ibu Kandung</option>
                                            <option value="Ayah Tiri">Ayah Tiri</option>
                                            <option value="Ibu Tiri">Ibu Tiri</option>
                                            <option value="Ayah Angkat">Ayah Angkat</option>
                                            <option value="Ibu Angkat">Ibu Angkat</option>
                                        </select>
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
                                <a href="?pg=PegawaiDetailAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>&tab=tab-4" class="btn btn-success ">Batal</a>
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
                <th>Orang Tua Dari</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tempat<br>Tanggal Lahir</th>
                <th>Hubungan</th>
                <th>Jenis Kelamin</th>
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
                $QueryOrtu = mysqli_query($db, "SELECT
                hiskel_ortu.IdPegawaiFK,
                master_pegawai.IdPegawaiFK,
                master_pegawai.Nama AS NamaPegawai,
                hiskel_ortu.IdPendidikanFK,
                master_pendidikan.IdPendidikan,
                hiskel_ortu.IdOrtu,
                hiskel_ortu.NIK,
                hiskel_ortu.Nama,
                hiskel_ortu.Tempat,
                hiskel_ortu.TanggalLahir,
                hiskel_ortu.StatusHubungan,
                hiskel_ortu.JenKel,
                master_pendidikan.JenisPendidikan,
                hiskel_ortu.Pekerjaan
                FROM
                hiskel_ortu
                INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = hiskel_ortu.IdPegawaiFK
                INNER JOIN master_pendidikan ON hiskel_ortu.IdPendidikanFK = master_pendidikan.IdPendidikan
                WHERE hiskel_ortu.IdPegawaiFK = '$IdTemp'");
                while ($DataOrtu = mysqli_fetch_assoc($QueryOrtu)) {
                    $IdOrtu = $DataOrtu['IdOrtu'];
                    $NamaPegawai = $DataOrtu['NamaPegawai'];
                    $NIK = $DataOrtu['NIK'];
                    $Nama = $DataOrtu['Nama'];
                    $Tempat = $DataOrtu['Tempat'];

                    $TglLahir = $DataOrtu['TanggalLahir'];
                    $exp = explode('-', $TglLahir);
                    $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                    $Hubungan = $DataOrtu['StatusHubungan'];
                    $JenKel = $DataOrtu['JenKel'];

                    $Pendidikan = $DataOrtu['JenisPendidikan'];
                    $Pekerjaan = $DataOrtu['Pekerjaan'];

            ?>
                    <tr class="gradeX">
                        <td>
                            <?php echo $Nomor; ?>
                        </td>
                        <td>
                            <?php echo $NamaPegawai; ?>
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
                        </td>
                        <td>
                            <?php
                            $QJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                            $DataJenKel = mysqli_fetch_assoc($QJenKel);
                            echo $JenisKelamin = $DataJenKel['Keterangan'];
                            ?>

                        </td>
                        <td>
                            <?php echo $Pendidikan; ?>
                        </td>
                        <td>
                            <?php echo $Pekerjaan; ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="?pg=PegawaiEditOrtuAdminDesa&Kode=<?php echo sql_url($IdOrtu); ?>" 
                                   class="btn btn-warning btn-sm" title="Edit Data">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="#" 
                                   class="btn btn-danger btn-sm btn-delete-ortu" 
                                   title="Hapus Data"
                                   data-id="<?php echo htmlspecialchars($IdOrtu); ?>"
                                   data-nama="<?php echo htmlspecialchars($Nama); ?>"
                                   data-hubungan="<?php echo htmlspecialchars($Hubungan); ?>"
                                   data-pegawai="<?php echo htmlspecialchars($IdTemp); ?>">
                                    <i class="fa fa-trash"></i> Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
            <?php 
                    $Nomor++;
                }
            } else {
            ?>
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data orang tua</td>
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
error_log("CSP nonce for FunctionProfileOrtu: " . $nonceAttr);
?>

<script <?php echo $nonceAttr; ?>>
// Enhanced CSP-compliant script for Ortu delete
document.addEventListener('DOMContentLoaded', function() {
    console.log('FunctionProfileOrtu script loaded with CSP nonce');
    console.log('SweetAlert2 available:', typeof Swal !== 'undefined');
    console.log('jQuery available:', typeof $ !== 'undefined');
    
    // Delay untuk memastikan semua library sudah load
    setTimeout(function() {
        console.log('Setting up CSP-compliant delete event handlers for Ortu...');
        
        // Native JavaScript Event Delegation (CSP-compliant)
        document.addEventListener('click', function(e) {
            var deleteBtn = e.target.closest('.btn-delete-ortu');
            if (deleteBtn) {
                console.log('Ortu delete button found:', deleteBtn);
                e.preventDefault();
                e.stopPropagation();
                
                var idOrtu = deleteBtn.getAttribute('data-id');
                var namaOrtu = deleteBtn.getAttribute('data-nama');
                var statusHubungan = deleteBtn.getAttribute('data-hubungan');
                var idPegawai = deleteBtn.getAttribute('data-pegawai');
                
                console.log('=== CSP-COMPLIANT ORTU DELETE BUTTON CLICKED ===');
                console.log('Data attributes:', {
                    id: idOrtu,
                    nama: namaOrtu,
                    hubungan: statusHubungan,
                    pegawai: idPegawai
                });
                
                confirmDeleteOrtu(idOrtu, namaOrtu, statusHubungan, idPegawai);
                return false;
            }
        });
        
        // jQuery event delegation sebagai backup
        if (typeof $ !== 'undefined') {
            $(document).off('click.deleteOrtu').on('click.deleteOrtu', '.btn-delete-ortu', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                console.log('jQuery Ortu delete event triggered');
                
                var idOrtu = $(this).data('id');
                var namaOrtu = $(this).data('nama');
                var statusHubungan = $(this).data('hubungan');
                var idPegawai = $(this).data('pegawai');
                
                console.log('jQuery Ortu data:', {
                    id: idOrtu,
                    nama: namaOrtu,
                    hubungan: statusHubungan,
                    pegawai: idPegawai
                });
                
                confirmDeleteOrtu(idOrtu, namaOrtu, statusHubungan, idPegawai);
                return false;
            });
        }
        
    }, 1000); // Delay 1 detik untuk memastikan DataTables sudah selesai
});

// CSP-compliant confirmation function for Ortu
function confirmDeleteOrtu(idOrtu, namaOrtu, statusHubungan, idPegawai) {
    console.log('=== CSP-COMPLIANT ORTU DELETE CONFIRMATION TRIGGERED ===');
    console.log('Parameters:', {
        idOrtu: idOrtu,
        namaOrtu: namaOrtu,
        statusHubungan: statusHubungan,
        idPegawai: idPegawai
    });
    console.log('SweetAlert2 check:', typeof Swal !== 'undefined');
    
    if (typeof Swal !== 'undefined') {
        console.log('Showing CSP-compliant SweetAlert2 confirmation for Ortu...');
        
        // CSP-compliant SweetAlert2 configuration
        Swal.fire({
            title: 'Konfirmasi Hapus',
            html: 'Apakah Anda yakin ingin menghapus data orang tua:<br><strong>' + 
                  escapeHtml(namaOrtu) + ' (' + escapeHtml(statusHubungan) + ')</strong>?',
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
            console.log('SweetAlert2 Ortu result:', result);
            
            if (result.isConfirmed) {
                console.log('Ortu delete confirmed by user');
                
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
                var deleteUrl = '../App/Model/ExcPegawaiOrtuAdminDesa?Act=Delete&Kode=' + 
                               encodeURIComponent(idOrtu) + 
                               '&IdPegawai=' + encodeURIComponent(idPegawai) + 
                               '&tab=tab-4';
                
                console.log('Redirecting to:', deleteUrl);
                
                // Redirect after short delay
                setTimeout(function() {
                    window.location.href = deleteUrl;
                }, 500);
                
            } else if (result.isDismissed) {
                console.log('Ortu delete cancelled by user');
            }
        }).catch((error) => {
            console.error('SweetAlert2 error (possible CSP issue):', error);
            // CSP-safe fallback confirmation
            if (confirm('SweetAlert2 error (CSP?). Apakah Anda yakin ingin menghapus data orang tua "' + 
                       namaOrtu + ' (' + statusHubungan + ')"?')) {
                var deleteUrl = '../App/Model/ExcPegawaiOrtuAdminDesa?Act=Delete&Kode=' + 
                               encodeURIComponent(idOrtu) + 
                               '&IdPegawai=' + encodeURIComponent(idPegawai) + 
                               '&tab=tab-4';
                window.location.href = deleteUrl;
            }
        });
        
    } else {
        console.log('SweetAlert2 not available (possible CSP block), using native confirm');
        // CSP-safe fallback untuk browser yang tidak support SweetAlert2
        if (confirm('Apakah Anda yakin ingin menghapus data orang tua "' + namaOrtu + ' (' + statusHubungan + ')"?')) {
            console.log('Ortu delete confirmed via native confirm');
            var deleteUrl = '../App/Model/ExcPegawaiOrtuAdminDesa?Act=Delete&Kode=' + 
                           encodeURIComponent(idOrtu) + 
                           '&IdPegawai=' + encodeURIComponent(idPegawai) + 
                           '&tab=tab-4';
            console.log('Redirecting to:', deleteUrl);
            window.location.href = deleteUrl;
        } else {
            console.log('Ortu delete cancelled via native confirm');
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