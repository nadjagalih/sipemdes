<?php include "../App/Control/FunctionPegawaiEdit.php"; ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Input Pendidikan <span style="font-style: italic; color:red;">* Wajib Diisi</span></h5>
                </div>
                <div class="ibox-content">
                    <form id="formPendidikan" action="../App/Model/ExcPegawaiPendidikanAdminDesa?Act=Save" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="IdPegawaiFK" id="IdPegawaiFK" value="<?php echo $IdPegawaiFK; ?>" class="form-control" readonly>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK</label>
                                    <div class="col-lg-8"><input type="text" name="NIK" id="NIK" value="<?php echo $NIK; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Pendidikan Dari</label>
                                    <div class="col-lg-8"><input type="text" name="Nama" id="Nama" value="<?php echo $Nama; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Pendidikan<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php include "../App/Control/FunctionSelectPendidikan.php"; ?>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Tahun Masuk</label>
                                    <div class="col-lg-8"><input type="text" name="TahunMasuk" id="TahunMasuk" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Tahun Keluar</label>
                                    <div class="col-lg-8"><input type="text" name="TahunKeluar" id="TahunKeluar" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nama Sekolah<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NamaSekolah" id="NamaSekolah" class="form-control" placeholder="Masukkan Nama Sekolah" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Jurusan</label>
                                    <div class="col-lg-8"><input type="text" name="Jurusan" id="Jurusan" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nomer Ijazah</label>
                                    <div class="col-lg-8"><input type="text" name="NomerIjazah" id="NomerIjazah" class="form-control" placeholder="Masukkan Nomer Ijazah" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row" id="TanggalLahir">
                                    <label class="col-lg-3 col-form-label">Tanggal Ijazah</label>
                                    <div class="col-lg-4">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="TanggalIjazah" id="TanggalIjazah" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <span style="font-style: italic; color:black;">Contoh : 16-01-1980</span>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit" name="Save" id="Save">Save</button>
                                <a href="?pg=PegawaiDetailAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>&tab=tab-1" class="btn btn-success">Batal</a>
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
                <th>Tingkat</th>
                <th>Nama Sekolah</th>
                <th>Jurusan</th>
                <th>Thn Masuk - Thn Keluar</th>
                <th>Pendidikan Akhir</th>
                <th>No Ijasah <br>Tanggal Ijasah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_GET['Kode'])) {
                $IdTemp = sql_url($_GET['Kode']);
                $Nomor = 1;
                $QueryPendidikan = mysqli_query($db, "SELECT
                master_pegawai.IdPegawaiFK,
                history_pendidikan.IdPegawaiFK,
                history_pendidikan.IdPendidikanFK,
                history_pendidikan.IdPendidikanPegawai,
                history_pendidikan.NamaSekolah,
                history_pendidikan.Jurusan,
                history_pendidikan.Setting,
                history_pendidikan.TahunMasuk,
                history_pendidikan.TahunLulus,
                history_pendidikan.NomorIjasah,
                history_pendidikan.TanggalIjasah,
                master_pendidikan.IdPendidikan,
                master_pegawai.NIK,
                master_pegawai.Nama,
                master_pendidikan.JenisPendidikan
                FROM
                master_pegawai
                INNER JOIN history_pendidikan ON master_pegawai.IdPegawaiFK = history_pendidikan.IdPegawaiFK
                INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
                WHERE history_pendidikan.IdPegawaiFK = '$IdTemp'
                ORDER BY
                master_pendidikan.IdPendidikan DESC");
                while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
                    $IdPendidikanV = $DataPendidikan['IdPendidikanPegawai'];
                    $NamaSekolah = $DataPendidikan['NamaSekolah'];
                    $Jurusan = $DataPendidikan['Jurusan'];
                    $JenjangPendidikan = $DataPendidikan['JenisPendidikan'];
                    $Setting = $DataPendidikan['Setting'];
                    $Masuk = $DataPendidikan['TahunMasuk'];
                    $Lulus = $DataPendidikan['TahunLulus'];
                    $NomorIjasah = $DataPendidikan['NomorIjasah'];
                    $TglIjasah = $DataPendidikan['TanggalIjasah'];
                    $exp = explode('-', $TglIjasah);
                    $TanggalIjasah = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            ?>
                    <tr class="gradeX">
                        <td>
                            <?php echo $Nomor; ?>
                        </td>
                        <td>
                            <?php echo $JenjangPendidikan; ?>

                        </td>
                        <td>
                            <?php echo $NamaSekolah; ?>
                        </td>
                        <td>
                            <?php echo $Jurusan; ?>
                        </td>
                        <td>
                            <?php echo $Masuk; ?> - <?php echo $Lulus; ?>
                        </td>
                        <td>
                            <?php if ($Setting == 0) { ?>
                                <span class="label label-warning float-left">NON AKTIF</span>
                                </a><?php } elseif ($Setting == 1) { ?>
                                <span class="label label-success float-left">AKTIF</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php echo $NomorIjasah; ?><br>
                            <?php echo $TanggalIjasah; ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="?pg=PegawaiEditPendidikanAdminDesa&Kode=<?php echo sql_url($IdPendidikanV); ?>" 
                                   class="btn btn-warning btn-sm" title="Edit Data">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="#" 
                                   class="btn btn-danger btn-sm btn-delete-pendidikan" 
                                   title="Hapus Data"
                                   data-id="<?php echo htmlspecialchars($IdPendidikanV); ?>"
                                   data-sekolah="<?php echo htmlspecialchars($NamaSekolah); ?>"
                                   data-tingkat="<?php echo htmlspecialchars($JenjangPendidikan); ?>"
                                   data-pegawai="<?php echo htmlspecialchars($IdTemp); ?>">
                                    <i class="fa fa-trash"></i> Hapus
                                </a>
                                <?php if ($Setting == 0) { ?>
                                    <a href="../App/Model/ExcPegawaiPendidikanAdminDesa?Act=SettingOn&Kode=<?php echo sql_url($IdPendidikanV); ?>&IdPegawai=<?php echo $IdTemp; ?>" 
                                       class="btn btn-success btn-sm" title="Aktifkan sebagai Pendidikan Akhir">
                                        <i class="fa fa-check"></i> Pilih
                                    </a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
            <?php 
                    $Nomor++;
                }
            } else {
            ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data pendidikan</td>
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
error_log("CSP nonce for FunctionProfilePendidikan: " . $nonceAttr);
?>

<script <?php echo $nonceAttr; ?>>
// Enhanced CSP-compliant script with comprehensive error handling
document.addEventListener('DOMContentLoaded', function() {
    console.log('FunctionProfilePendidikan script loaded with CSP nonce');
    console.log('SweetAlert2 available:', typeof Swal !== 'undefined');
    console.log('jQuery available:', typeof $ !== 'undefined');
    
    // Delay untuk memastikan semua library sudah load
    setTimeout(function() {
        console.log('Setting up CSP-compliant delete event handlers...');
        
        // Native JavaScript Event Delegation (CSP-compliant)
        document.addEventListener('click', function(e) {
            console.log('Document click detected, target:', e.target);
            
            var deleteBtn = e.target.closest('.btn-delete-pendidikan');
            if (deleteBtn) {
                console.log('Delete button found:', deleteBtn);
                e.preventDefault();
                e.stopPropagation();
                
                var idPendidikan = deleteBtn.getAttribute('data-id');
                var namaSekolah = deleteBtn.getAttribute('data-sekolah');
                var tingkatPendidikan = deleteBtn.getAttribute('data-tingkat');
                var idPegawai = deleteBtn.getAttribute('data-pegawai');
                
                console.log('=== CSP-COMPLIANT DELETE BUTTON CLICKED ===');
                console.log('Delete button element:', deleteBtn);
                console.log('Data attributes:', {
                    id: idPendidikan,
                    sekolah: namaSekolah,
                    tingkat: tingkatPendidikan,
                    pegawai: idPegawai
                });
                
                confirmDeletePendidikan(idPendidikan, namaSekolah, tingkatPendidikan, idPegawai);
                return false;
            }
        });
        
        // jQuery event delegation sebagai backup (jika jQuery tersedia)
        if (typeof $ !== 'undefined') {
            $(document).off('click.deletePendidikan').on('click.deletePendidikan', '.btn-delete-pendidikan', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                console.log('jQuery delete event triggered (CSP-compliant)');
                
                var idPendidikan = $(this).data('id');
                var namaSekolah = $(this).data('sekolah');
                var tingkatPendidikan = $(this).data('tingkat');
                var idPegawai = $(this).data('pegawai');
                
                console.log('jQuery data:', {
                    id: idPendidikan,
                    sekolah: namaSekolah,
                    tingkat: tingkatPendidikan,
                    pegawai: idPegawai
                });
                
                confirmDeletePendidikan(idPendidikan, namaSekolah, tingkatPendidikan, idPegawai);
                return false;
            });
        }
        
    }, 1000); // Delay 1 detik untuk memastikan DataTables sudah selesai
});

// CSP-compliant confirmation function
function confirmDeletePendidikan(idPendidikan, namaSekolah, tingkatPendidikan, idPegawai) {
    console.log('=== CSP-COMPLIANT DELETE CONFIRMATION TRIGGERED ===');
    console.log('Parameters:', {
        idPendidikan: idPendidikan,
        namaSekolah: namaSekolah, 
        tingkatPendidikan: tingkatPendidikan,
        idPegawai: idPegawai
    });
    console.log('SweetAlert2 check:', typeof Swal !== 'undefined');
    
    if (typeof Swal !== 'undefined') {
        console.log('Showing CSP-compliant SweetAlert2 confirmation...');
        
        // CSP-compliant SweetAlert2 configuration
        Swal.fire({
            title: 'Konfirmasi Hapus',
            html: 'Apakah Anda yakin ingin menghapus data pendidikan:<br><strong>' + 
                  escapeHtml(tingkatPendidikan) + ' - ' + escapeHtml(namaSekolah) + '</strong>?',
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
            console.log('SweetAlert2 result:', result);
            
            if (result.isConfirmed) {
                console.log('Delete confirmed by user');
                
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
                var deleteUrl = '../App/Model/ExcPegawaiPendidikanAdminDesa?Act=Delete&Kode=' + 
                               encodeURIComponent(idPendidikan) + 
                               '&IdPegawai=' + encodeURIComponent(idPegawai) + 
                               '&tab=tab-1';
                
                console.log('Redirecting to:', deleteUrl);
                
                // Redirect after short delay
                setTimeout(function() {
                    window.location.href = deleteUrl;
                }, 500);
                
            } else if (result.isDismissed) {
                console.log('Delete cancelled by user');
            }
        }).catch((error) => {
            console.error('SweetAlert2 error (possible CSP issue):', error);
            // CSP-safe fallback confirmation
            if (confirm('SweetAlert2 error (CSP?). Apakah Anda yakin ingin menghapus data pendidikan "' + 
                       tingkatPendidikan + ' - ' + namaSekolah + '"?')) {
                var deleteUrl = '../App/Model/ExcPegawaiPendidikanAdminDesa?Act=Delete&Kode=' + 
                               encodeURIComponent(idPendidikan) + 
                               '&IdPegawai=' + encodeURIComponent(idPegawai) + 
                               '&tab=tab-1';
                window.location.href = deleteUrl;
            }
        });
        
    } else {
        console.log('SweetAlert2 not available (possible CSP block), using native confirm');
        // CSP-safe fallback untuk browser yang tidak support SweetAlert2
        if (confirm('Apakah Anda yakin ingin menghapus data pendidikan "' + 
                   tingkatPendidikan + ' - ' + namaSekolah + '"?')) {
            console.log('Delete confirmed via native confirm');
            var deleteUrl = '../App/Model/ExcPegawaiPendidikanAdminDesa?Act=Delete&Kode=' + 
                           encodeURIComponent(idPendidikan) + 
                           '&IdPegawai=' + encodeURIComponent(idPegawai) + 
                           '&tab=tab-1';
            console.log('Redirecting to:', deleteUrl);
            window.location.href = deleteUrl;
        } else {
            console.log('Delete cancelled via native confirm');
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