<?php
// Form tambah award baru
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
