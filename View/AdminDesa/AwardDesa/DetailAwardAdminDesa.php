<?php
// Detail award page untuk admin desa
include "../App/Control/FunctionDetailAwardAdminDesa.php";
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Award</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="?pg=Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="?pg=AwardViewAdminDesa">Award Tersedia</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detail Award</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <br>
        <div class="title-action">
            <a href="?pg=AwardViewAdminDesa" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <?php if ($DataAward): ?>
    <div class="row">
        <!-- Award Info -->
        <div class="col-lg-8">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><i class="fa fa-trophy"></i> Informasi Award</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="award-header text-center mb-4">
                                <div class="award-year" style="font-size: 48px; font-weight: bold; color: #1ab394;">
                                    <?php echo $DataAward['TahunPenghargaan']; ?>
                                </div>
                                <h1 class="award-title"><?php echo $DataAward['JenisPenghargaan']; ?></h1>
                                <span class="badge <?php echo $statusInfo['badge']; ?> badge-lg">
                                    <?php echo $statusInfo['text']; ?>
                                </span>
                            </div>
                            
                            <?php if (!empty($DataAward['Deskripsi'])): ?>
                            <div class="award-description">
                                <h4>Deskripsi</h4>
                                <p class="text-justify"><?php echo nl2br($DataAward['Deskripsi']); ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <div class="award-timeline">
                                <h4>Timeline Award</h4>
                                <div class="timeline-item">
                                    <?php if ($DataAward['MasaAktifMulai'] && $DataAward['MasaAktifSelesai']): ?>
                                    <div class="timeline-content">
                                        <span class="timeline-title">
                                            <i class="fa fa-calendar text-primary"></i> Masa Aktif Pendaftaran
                                        </span>
                                        <p><?php echo date('d F Y', strtotime($DataAward['MasaAktifMulai'])); ?> - <?php echo date('d F Y', strtotime($DataAward['MasaAktifSelesai'])); ?></p>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($DataAward['MasaPenjurianMulai']) && !empty($DataAward['MasaPenjurianSelesai'])): ?>
                                    <div class="timeline-content">
                                        <span class="timeline-title">
                                            <i class="fa fa-gavel text-warning"></i> Masa Penjurian
                                        </span>
                                        <p><?php echo date('d F Y', strtotime($DataAward['MasaPenjurianMulai'])); ?> - <?php echo date('d F Y', strtotime($DataAward['MasaPenjurianSelesai'])); ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Action Panel -->
        <div class="col-lg-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><i class="fa fa-cogs"></i> Aksi</h5>
                </div>
                <div class="ibox-content">
                    <div class="text-center">
                        <?php 
                        // Cek apakah ada karya yang terdaftar untuk award ini
                        if ($jumlahKaryaAward > 0): 
                        ?>
                            <div class="alert alert-info">
                                <i class="fa fa-check-circle"></i>
                                <strong>Sudah Terdaftar</strong><br>
                                Desa sudah mendaftarkan <?php echo $jumlahKaryaAward; ?> karya ke award ini.
                            </div>
                            <a href="?pg=KaryaDesa" class="btn btn-primary btn-block">
                                <i class="fa fa-list"></i> Lihat Semua Karya Desa
                            </a>
                            <?php if ($statusInfo['text'] == 'Pendaftaran'): ?>
                            <small class="text-muted">
                                <i class="fa fa-info-circle"></i> 
                                Setiap desa hanya dapat mendaftar 1 kategori per award
                            </small>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if ($statusInfo['text'] == 'Pendaftaran'): ?>
                                <div class="alert alert-success">
                                    <i class="fa fa-clock-o"></i>
                                    <strong>Bisa Mendaftar</strong><br>
                                    Award ini sedang membuka pendaftaran.
                                </div>
                                <a href="?pg=AwardViewAdminDesa" class="btn btn-success btn-block">
                                    <i class="fa fa-plus"></i> Daftar Karya
                                </a>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle"></i>
                                    <strong>Tidak Bisa Mendaftar</strong><br>
                                    Award sedang tidak membuka pendaftaran.
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Status Detail -->
            <div class="ibox">
                <div class="ibox-title">
                    <h5><i class="fa fa-info-circle"></i> Status Detail</h5>
                </div>
                <div class="ibox-content">
                    <div class="status-detail">
                        <div class="status-item">
                            <span class="status-label">Status Award:</span>
                            <span class="badge <?php echo $statusInfo['badge']; ?>">
                                <?php echo $statusInfo['text']; ?>
                            </span>
                        </div>
                        
                        <div class="status-item">
                            <span class="status-label">Tahun:</span>
                            <span class="status-value"><?php echo $DataAward['TahunPenghargaan']; ?></span>
                        </div>
                        
                        <div class="status-item">
                            <span class="status-label">Status:</span>
                            <span class="status-value"><?php echo $DataAward['StatusAktif']; ?></span>
                        </div>
                        
                        <div class="status-item">
                            <span class="status-label">Karya Terdaftar:</span>
                            <span class="status-value"><?php echo $jumlahKaryaAward . ' karya'; ?></span>
                        </div>
                        
                        <?php 
                        // Hitung jumlah kategori
                        $jumlahKategori = !empty($KategoriList) ? count($KategoriList) : 0;
                        ?>
                        <div class="status-item">
                            <span class="status-label">Kategori Tersedia:</span>
                            <span class="status-value"><?php echo $jumlahKategori; ?> kategori</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Kategori -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><i class="fa fa-tags"></i> Kategori Award</h5>
                </div>
                <div class="ibox-content">
                    <?php if (!empty($KategoriList)): ?>
                    <div class="row">
                        <?php foreach ($KategoriList as $kategori): ?>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="kategori-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fa fa-tag text-primary"></i>
                                            <?php echo $kategori['NamaKategori']; ?>
                                        </h5>
                                        <?php if (!empty($kategori['DeskripsiKategori'])): ?>
                                        <p class="card-text">
                                            <?php echo $kategori['DeskripsiKategori']; ?>
                                        </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle"></i> Belum ada kategori yang tersedia untuk award ini.
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Karya Desa yang Terdaftar -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><i class="fa fa-list"></i> Karya Desa yang Terdaftar</h5>
                </div>
                <div class="ibox-content">
                    <?php if ($QueryKaryaAward && mysqli_num_rows($QueryKaryaAward) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori</th>
                                        <th>Judul Karya</th>
                                        <th>Link Karya</th>
                                        <th>Posisi</th>
                                        <th>Status</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    // Reset pointer jika perlu
                                    if ($QueryKaryaAward) {
                                        mysqli_data_seek($QueryKaryaAward, 0);
                                    }
                                    while ($QueryKaryaAward && ($DataKaryaAward = mysqli_fetch_assoc($QueryKaryaAward))): 
                                        // Status berdasarkan award dan posisi
                                        $statusBadge = 'badge-secondary';
                                        $statusText = 'Menunggu Hasil';
                                        
                                        if (!empty($DataKaryaAward['Posisi']) && $DataKaryaAward['Posisi'] > 0) {
                                            $statusBadge = 'badge-success';
                                            $statusText = 'Peringkat ' . $DataKaryaAward['Posisi'];
                                        } elseif ($DataKaryaAward['StatusAward'] == 'Non-Aktif') {
                                            $statusBadge = 'badge-warning';
                                            $statusText = 'Award Selesai';
                                        }
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <span class="badge badge-info"><?php echo $DataKaryaAward['NamaKategori']; ?></span>
                                        </td>
                                        <td>
                                            <strong><?php echo $DataKaryaAward['JudulKarya']; ?></strong>
                                            <?php if (!empty($DataKaryaAward['Keterangan'])): ?>
                                                <br><small class="text-muted"><?php echo substr($DataKaryaAward['Keterangan'], 0, 50) . '...'; ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo $DataKaryaAward['LinkKarya']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fa fa-external-link"></i> Lihat Karya
                                            </a>
                                        </td>
                                        <td>
                                            <?php if (!empty($DataKaryaAward['Posisi']) && $DataKaryaAward['Posisi'] > 0): ?>
                                                <span class="badge badge-success">Peringkat <?php echo $DataKaryaAward['Posisi']; ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">Belum ada</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge <?php echo $statusBadge; ?>"><?php echo $statusText; ?></span>
                                        </td>
                                        <td><?php echo date('d M Y H:i', strtotime($DataKaryaAward['TanggalDaftar'])); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-info" onclick="detailKaryaAward('<?php echo $DataKaryaAward['IdPesertaAward']; ?>', '<?php echo addslashes($DataKaryaAward['JudulKarya']); ?>', '<?php echo addslashes($DataKaryaAward['Keterangan'] ?? ''); ?>', '<?php echo $DataKaryaAward['LinkKarya']; ?>', '<?php echo $DataKaryaAward['NamaKategori']; ?>')">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <?php if ($DataKaryaAward['StatusAward'] == 'Aktif'): ?>
                                                <a href="?pg=EditKaryaAward&kode=<?php echo $DataKaryaAward['IdPesertaAward']; ?>&award=<?php echo $IdAward; ?>" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="hapusKaryaAward('<?php echo $DataKaryaAward['IdPesertaAward']; ?>', '<?php echo addslashes($DataKaryaAward['JudulKarya']); ?>')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <i class="fa fa-info-circle"></i>
                            <strong>Belum Ada Karya Terdaftar</strong><br>
                            Desa belum mendaftarkan karya untuk award ini.
                            <?php if ($statusInfo['text'] == 'Pendaftaran'): ?>
                                <br><br>
                                <a href="?pg=AwardViewAdminDesa" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Daftar Karya Sekarang
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php else: ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger text-center">
                <i class="fa fa-exclamation-triangle"></i>
                <strong>Award tidak ditemukan</strong><br>
                Award yang Anda cari tidak ditemukan atau tidak tersedia.
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.award-header {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    padding: 30px;
    border-radius: 10px;
    margin-bottom: 30px;
}

.award-title {
    color: #2c3e50;
    margin: 15px 0;
}

.badge-lg {
    padding: 8px 15px;
    font-size: 14px;
}

.timeline-item {
    border-left: 3px solid #1ab394;
    padding-left: 20px;
    margin-left: 10px;
}

.timeline-content {
    margin-bottom: 20px;
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
}

.timeline-title {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

.status-detail .status-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.status-detail .status-item:last-child {
    border-bottom: none;
}

.status-label {
    font-weight: bold;
    color: #555;
}

.status-value {
    color: #333;
}

.kategori-card .card {
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.kategori-card .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}
</style>

<!-- Modal Detail Karya Award -->
<div class="modal fade" id="modalDetailKaryaAward" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail Karya Award</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Judul Karya</label>
                            <p id="detailJudulKaryaAward" class="form-control-static"></p>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <p id="detailKategoriAward" class="form-control-static"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Link Karya</label>
                            <p><a id="detailLinkKaryaAward" href="#" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-external-link"></i> Buka Karya</a></p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Deskripsi Karya</label>
                    <p id="detailDeskripsiKaryaAward" class="form-control-static"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
function detailKaryaAward(id, judul, deskripsi, link, kategori) {
    document.getElementById('detailJudulKaryaAward').textContent = judul;
    document.getElementById('detailKategoriAward').textContent = kategori;
    document.getElementById('detailLinkKaryaAward').href = link;
    document.getElementById('detailDeskripsiKaryaAward').textContent = deskripsi || 'Tidak ada deskripsi';
    
    $('#modalDetailKaryaAward').modal('show');
}

function hapusKaryaAward(id, judul) {
    if (confirm('Yakin ingin menghapus karya "' + judul + '"?\n\nKarya yang sudah dihapus tidak dapat dikembalikan.')) {
        // Redirect ke halaman delete dengan parameter yang tepat
        window.location.href = '../App/Model/ExcKaryaDesa.php?Act=Delete&Kode=' + id + '&redirect=DetailAwardAdminDesa&award=<?php echo $IdAward; ?>';
    }
}
</script>