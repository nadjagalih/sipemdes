<?php
// Form edit award
include "../App/Control/FunctionAwardEdit.php";
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
                                <input type="date" class="form-control" name="MasaPenjurianMulai" value="<?php echo $MasaPenjurianMulai; ?>">
                                <small class="form-text text-muted">Kapan penjurian dimulai (opsional)</small>
                            </div>
                            <div class="col-lg-5">
                                <label class="control-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="MasaPenjurianSelesai" value="<?php echo $MasaPenjurianSelesai; ?>">
                                <small class="form-text text-muted">Kapan penjurian berakhir (opsional)</small>
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
