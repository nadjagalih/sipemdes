<?php
// Form tambah award baru

// Handle alert notifications
if (isset($_GET['alert'])) {
    $alertType = $_GET['alert'];
    if ($alertType == 'SaveError') {
        $showErrorModal = true;
        $errorMessage = 'Gagal menyimpan award. Silakan coba lagi.';
    }
}
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Tambah Award/Penghargaan</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="?pg=SAdmin">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="?pg=AwardView">Award Desa</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Tambah Award</strong>
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
                    <h5>Form Tambah Award/Penghargaan</h5>
                </div>
                <div class="ibox-content">
                    <form action="../App/Model/ExcAward.php?Act=Save" method="POST">
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Jenis Penghargaan <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="JenisPenghargaan" required>
                                <small class="form-text text-muted">Contoh: Lomba Desa Inovatif, Desa Wisata Terbaik, Penghargaan Kalpataru</small>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Tahun <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="number" class="form-control" name="TahunPenghargaan" min="2000" max="<?php echo date('Y')+1; ?>" value="<?php echo date('Y'); ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Masa Aktif <span class="text-danger">*</span></label>
                            <div class="col-lg-5">
                                <label class="control-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="MasaAktifMulai" required>
                                <small class="form-text text-muted">Kapan penghargaan mulai berlaku</small>
                            </div>
                            <div class="col-lg-5">
                                <label class="control-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="MasaAktifSelesai" required>
                                <small class="form-text text-muted">Kapan penghargaan berakhir</small>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Masa Penjurian</label>
                            <div class="col-lg-5">
                                <label class="control-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="MasaPenjurianMulai">
                                <small class="form-text text-muted">Kapan penjurian dimulai (opsional)</small>
                            </div>
                            <div class="col-lg-5">
                                <label class="control-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="MasaPenjurianSelesai">
                                <small class="form-text text-muted">Kapan penjurian berakhir (opsional)</small>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Status</label>
                            <div class="col-lg-10">
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> Status award akan otomatis ditentukan berdasarkan masa aktif penghargaan.
                                    <br><strong>Aktif:</strong> Jika tanggal hari ini berada dalam rentang masa aktif.
                                    <br><strong>Non-Aktif:</strong> Jika di luar masa aktif atau belum/sudah berakhir.
                                    <br><strong>Masa Penjurian:</strong> Jika diatur, admin hanya bisa memilih pemenang selama masa penjurian berlangsung.
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Deskripsi</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" name="Deskripsi" rows="5" placeholder="Deskripsi lengkap tentang penghargaan ini..."></textarea>
                            </div>
                        </div>
                        
                        <div class="hr-line-dashed"></div>
                        
                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary" type="submit" name="Save">
                                    <i class="fa fa-save"></i> Simpan Award
                                </button>
                                <a href="?pg=AwardView" class="btn btn-secondary">
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
</script>
<?php endif; ?>
