<?php
// Form edit award
include "../App/Control/FunctionAwardEdit.php";

// Handle alert notifications
if (isset($_GET['alert'])) {
    $alertType = $_GET['alert'];
    if ($alertType == 'EditError') {
        $showErrorModal = true;
        $errorMessage = 'Gagal mengupdate award. Silakan coba lagi.';
    }
}
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Edit Award/Penghargaan</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="?pg=SAdmin">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="?pg=AwardView">Award Desa</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Award</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <br>
        <a href="?pg=AwardView" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Form Edit Award/Penghargaan</h5>
                </div>
                <div class="ibox-content">
                    <form action="../App/Model/ExcAward.php?Act=Edit" method="POST">
                        <input type="hidden" name="IdAward" value="<?php echo $IdAward; ?>">
                        
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Jenis Penghargaan <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="JenisPenghargaan" value="<?php echo $JenisPenghargaan; ?>" required>
                                <small class="form-text text-muted">Contoh: Lomba Desa Inovatif, Desa Wisata Terbaik, Penghargaan Kalpataru</small>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Tahun <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="number" class="form-control" name="TahunPenghargaan" min="2000" max="<?php echo date('Y')+1; ?>" value="<?php echo $TahunPenghargaan; ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Masa Aktif <span class="text-danger">*</span></label>
                            <div class="col-lg-5">
                                <label class="control-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="MasaAktifMulai" value="<?php echo $MasaAktifMulai; ?>" required>
                                <small class="form-text text-muted">Kapan penghargaan mulai berlaku</small>
                            </div>
                            <div class="col-lg-5">
                                <label class="control-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="MasaAktifSelesai" value="<?php echo $MasaAktifSelesai; ?>" required>
                                <small class="form-text text-muted">Kapan penghargaan berakhir</small>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Masa Penjurian</label>
                            <div class="col-lg-5">
                                <label class="control-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="MasaPenjurianMulai" value="<?php echo $MasaPenjurianMulai; ?>" readonly>
                                <small class="form-text text-muted">Otomatis sama dengan tanggal mulai aktif award</small>
                            </div>
                            <div class="col-lg-5">
                                <label class="control-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="MasaPenjurianSelesai" value="<?php echo $MasaPenjurianSelesai; ?>">
                                <small class="form-text text-muted">Minimal sama dengan tanggal akhir aktif award</small>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Status Saat Ini</label>
                            <div class="col-lg-10">
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> Status award saat ini: <strong><?php echo $StatusAktif; ?></strong>
                                    <br>Status masa penjurian: <strong><?php echo $statusPenjurian; ?></strong>
                                    <br>Status award akan otomatis diupdate berdasarkan masa aktif penghargaan saat halaman dimuat.
                                    <br><strong>Aktif:</strong> Jika tanggal hari ini berada dalam rentang masa aktif.
                                    <br><strong>Non-Aktif:</strong> Jika di luar masa aktif atau belum/sudah berakhir.
                                    <br><strong>Masa Penjurian:</strong> 
                                    <br>• Tanggal mulai penjurian = tanggal mulai penghargaan
                                    <br>• Tanggal akhir penjurian minimal sama dengan tanggal akhir penghargaan (bisa lebih lama)
                                    <?php if ($isMasaPenjurian): ?>
                                        <br><span class="text-success"><strong>Penjurian sedang berlangsung - Admin dapat memilih pemenang!</strong></span>
                                    <?php else: ?>
                                        <br><span class="text-warning"><strong>Di luar masa penjurian - Tidak dapat memilih pemenang saat ini.</strong></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Deskripsi</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" name="Deskripsi" rows="5"><?php echo $Deskripsi; ?></textarea>
                            </div>
                        </div>
                        
                        <div class="hr-line-dashed"></div>
                        
                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary" type="submit" name="Edit">
                                    <i class="fa fa-save"></i> Update Award
                                </button>
                                <a href="?pg=AwardDetail&Kode=<?php echo $IdAward; ?>" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Error -->
<div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center; padding: 40px 30px;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f44336, #d32f2f); border-radius: 50%; margin: 0 auto 20px auto; display: flex; align-items: center; justify-content: center; font-size: 40px; color: white; box-shadow: 0 5px 15px rgba(244, 67, 54, 0.3);">
                    <i class="fa fa-times"></i>
                </div>
                <h4 style="font-size: 24px; font-weight: 600; color: #333; margin-bottom: 15px;">Terjadi Kesalahan</h4>
                <p style="color: #666; font-size: 16px; line-height: 1.5; margin-bottom: 25px;">
                    <?php echo isset($errorMessage) ? $errorMessage : 'Terjadi kesalahan, silakan coba lagi.'; ?>
                </p>
                <button type="button" class="btn" style="background: linear-gradient(135deg, #007bff, #0056b3); color: white; border: none; padding: 12px 25px; border-radius: 25px; font-weight: 600;" onclick="closeErrorModal()">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<?php if (isset($showErrorModal) && $showErrorModal): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#modalError').modal({
        backdrop: 'static',
        keyboard: false
    });
});

function closeErrorModal() {
    $('#modalError').modal('hide');
    // Remove alert parameter from URL
    if (window.history.replaceState) {
        var url = new URL(window.location);
        url.searchParams.delete('alert');
        window.history.replaceState(null, null, url);
    }
}

// Auto-fill dan validasi masa penjurian
document.addEventListener('DOMContentLoaded', function() {
    const masaAktifMulai = document.querySelector('input[name="MasaAktifMulai"]');
    const masaAktifSelesai = document.querySelector('input[name="MasaAktifSelesai"]');
    const masaPenjurianMulai = document.querySelector('input[name="MasaPenjurianMulai"]');
    const masaPenjurianSelesai = document.querySelector('input[name="MasaPenjurianSelesai"]');
    
    // Auto-fill tanggal mulai penjurian berdasarkan tanggal mulai aktif
    if (masaAktifMulai && masaPenjurianMulai) {
        masaAktifMulai.addEventListener('change', function() {
            masaPenjurianMulai.value = this.value;
        });
        
        // Set initial value if masa aktif mulai already has value
        if (masaAktifMulai.value) {
            masaPenjurianMulai.value = masaAktifMulai.value;
        }
    }
    
    // Set min date untuk tanggal akhir penjurian dan validasi
    if (masaAktifSelesai && masaPenjurianSelesai) {
        masaAktifSelesai.addEventListener('change', function() {
            // Set minimum date untuk penjurian selesai
            masaPenjurianSelesai.min = this.value;
            
            // Set default value jika belum ada atau kurang dari minimum
            if (!masaPenjurianSelesai.value || masaPenjurianSelesai.value < this.value) {
                masaPenjurianSelesai.value = this.value;
            }
        });
        
        // Set initial min date and value
        if (masaAktifSelesai.value) {
            masaPenjurianSelesai.min = masaAktifSelesai.value;
            if (!masaPenjurianSelesai.value || masaPenjurianSelesai.value < masaAktifSelesai.value) {
                masaPenjurianSelesai.value = masaAktifSelesai.value;
            }
        }
        
        // Validasi saat input tanggal akhir penjurian diubah
        masaPenjurianSelesai.addEventListener('change', function() {
            if (masaAktifSelesai.value && this.value < masaAktifSelesai.value) {
                alert('Tanggal akhir penjurian tidak boleh kurang dari tanggal akhir penghargaan!');
                this.value = masaAktifSelesai.value;
            }
        });
    }
});
</script>
<?php endif; ?>
