<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Debug parameter
echo "<!-- Debug: Kode parameter = " . (isset($_GET['Kode']) ? $_GET['Kode'] : 'TIDAK ADA') . " -->";

try {
    include "../App/Control/FunctionKategoriDetail.php";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    die();
}

// Pastikan variabel terdefinisi dengan nilai default
$NamaKategori = isset($NamaKategori) ? $NamaKategori : 'Kategori Tidak Ditemukan';
$JenisPenghargaan = isset($JenisPenghargaan) ? $JenisPenghargaan : 'Unknown';
$StatusAward = isset($StatusAward) ? $StatusAward : 'Unknown';
$IdAward = isset($IdAward) ? $IdAward : '';
$IdKategoriAward = isset($IdKategoriAward) ? $IdKategoriAward : '';
$totalPeserta = isset($totalPeserta) ? $totalPeserta : 0;
$pesertaBerposisi = isset($pesertaBerposisi) ? $pesertaBerposisi : 0;
$DeskripsiKategori = isset($DeskripsiKategori) ? $DeskripsiKategori : '';
$MasaPenjurianMulai = isset($MasaPenjurianMulai) ? $MasaPenjurianMulai : '';
$MasaPenjurianSelesai = isset($MasaPenjurianSelesai) ? $MasaPenjurianSelesai : '';
$isMasaPenjurian = isset($isMasaPenjurian) ? $isMasaPenjurian : false;
$statusPenjurian = isset($statusPenjurian) ? $statusPenjurian : 'Status tidak diketahui';
$QueryPeserta = isset($QueryPeserta) ? $QueryPeserta : null;

echo "<!-- Debug: Variabel sudah disiapkan -->";
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Kategori - <?php echo $NamaKategori; ?></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="?pg=SAdmin">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="?pg=AwardView">Award Desa</a>
            </li>
            <li class="breadcrumb-item">
                <a href="?pg=AwardDetail&Kode=<?php echo $IdAward; ?>">Detail Award</a>
            </li>
            <li class="breadcrumb-item active">
                <strong><?php echo $NamaKategori; ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <br>
        <a href="?pg=AwardDetail&Kode=<?php echo $IdAward; ?>" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-8">
            <div class="ibox" style="min-height: 280px;">
                <div class="ibox-content">
                    <div class="text-center">
                        <i class="fa fa-trophy" style="font-size: 80px; color: #FFD700; margin-bottom: 20px;"></i>
                        <h1 class="font-bold"><?php echo $NamaKategori; ?></h1>
                        <div style="margin: 15px 0;">
                            <span class="badge badge-warning badge-lg" style="font-size: 16px; padding: 8px 15px; background-color: #007bff; color: white;">
                                Kategori <?php echo $JenisPenghargaan; ?>
                            </span>
                            <span class="badge <?php echo ($StatusAward == 'Aktif') ? 'badge-success' : 'badge-secondary'; ?> badge-lg" style="font-size: 16px; padding: 8px 15px; margin-left: 10px;">
                                Award <?php echo $StatusAward; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Action Panel -->
            <div class="ibox" style="min-height: 280px;">
                <div class="ibox-title">
                    <h5>Aksi Kategori</h5>
                </div>
                <div class="ibox-content">
                    <div class="btn-group-vertical btn-block">
                        <button type="button" class="btn btn-success" onclick="editKategori('<?php echo $IdKategoriAward; ?>')">
                            <i class="fa fa-edit"></i> Edit Kategori
                        </button>
                        <a href="../App/Model/ExcKategoriAward.php?Act=Delete&Kode=<?php echo $IdKategoriAward; ?>" 
                           onclick="return confirm('Yakin ingin menghapus kategori ini? Semua peserta dalam kategori ini akan ikut terhapus.');" class="btn btn-danger">
                            <i class="fa fa-trash"></i> Hapus Kategori
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <!-- Info Deskripsi Panel -->
            <?php if (!empty($DeskripsiKategori)): ?>
            <div class="ibox" style="min-height: 180px;">
                <div class="ibox-title">
                    <h5>Deskripsi Kategori</h5>
                </div>
                <div class="ibox-content">
                    <p class="form-control-static"><?php echo nl2br($DeskripsiKategori); ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <!-- Info Masa Penjurian -->
            <div class="ibox" style="min-height: 180px;">
                <div class="ibox-title">
                    <h5>Status Penjurian</h5>
                </div>
                <div class="ibox-content">
                    <?php if (!empty($MasaPenjurianMulai) && !empty($MasaPenjurianSelesai)): ?>
                        <p><strong>Masa Penjurian:</strong><br>
                        <?php echo date('d M Y', strtotime($MasaPenjurianMulai)) . ' - ' . date('d M Y', strtotime($MasaPenjurianSelesai)); ?></p>
                    <?php endif; ?>
                    
                    <div class="alert <?php echo $isMasaPenjurian ? 'alert-success' : 'alert-warning'; ?>">
                        <i class="fa <?php echo $isMasaPenjurian ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?>"></i>
                        <strong><?php echo $statusPenjurian; ?></strong>
                        <?php if ($isMasaPenjurian): ?>
                            <br>Admin dapat memilih pemenang saat ini.
                        <?php else: ?>
                            <br>Tidak dapat memilih pemenang di luar masa penjurian.
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tabel Peserta -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Daftar Peserta Kategori <?php echo $NamaKategori; ?></h5>
                    <!-- Label peserta dihapus -->
                </div>
                <div class="ibox-content">
                    <?php if ($totalPeserta > 0 && $QueryPeserta): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="18%">Nama Peserta (Desa)</th>
                                        <th width="15%">Kategori</th>
                                        <th width="20%">Nama Karya</th>
                                        <th width="18%">Link Karya</th>
                                        <th width="12%" class="text-center">Posisi/Juara</th>
                                        <th width="13%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    while ($DataPeserta = mysqli_fetch_assoc($QueryPeserta)) {
                                        $IdPesertaAward = $DataPeserta['IdPesertaAward'];
                                        $NamaPeserta = $DataPeserta['NamaPeserta'];
                                        $NamaKarya = $DataPeserta['NamaKarya'];
                                        $LinkKarya = $DataPeserta['LinkKarya'];
                                        $Posisi = $DataPeserta['Posisi'];
                                        $TanggalSubmit = date('d M Y', strtotime($DataPeserta['TanggalSubmit']));
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no; ?></td>
                                            <td>
                                                <strong><?php echo $NamaPeserta; ?></strong>
                                                <br><small class="text-muted">Submit: <?php echo $TanggalSubmit; ?></small>
                                            </td>
                                            <td>
                                                <span class="badge badge-info"><?php echo $NamaKategori; ?></span>
                                            </td>
                                            <td>
                                                <span class="text-navy"><?php echo $NamaKarya; ?></span>
                                            </td>
                                            <td>
                                                <?php if (!empty($LinkKarya)): ?>
                                                    <a href="<?php echo $LinkKarya; ?>" target="_blank" class="btn btn-xs btn-success">
                                                        <i class="fa fa-external-link"></i> Lihat Karya
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">Tidak ada link</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (!empty($Posisi)): ?>
                                                    <span class="badge badge-primary">Juara <?php echo $Posisi; ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($isMasaPenjurian): ?>
                                                    <button type="button" class="btn btn-xs btn-primary" 
                                                            onclick="updatePosisi('<?php echo $IdPesertaAward; ?>', '<?php echo addslashes($NamaPeserta); ?>', '<?php echo addslashes($NamaKarya); ?>', '<?php echo $Posisi; ?>', '<?php echo addslashes($LinkKarya); ?>')">
                                                        <i class="fa fa-trophy"></i> Update Posisi
                                                    </button>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-xs btn-secondary" disabled 
                                                            title="Tidak dapat update posisi di luar masa penjurian">
                                                        <i class="fa fa-lock"></i> Terkunci
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php 
                                        $no++;
                                    } 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center" style="padding: 60px 0;">
                            <i class="fa fa-users" style="font-size: 48px; color: #ddd;"></i>
                            <h3 style="color: #676a6c; margin-top: 20px;">Belum Ada Peserta</h3>
                            <p style="color: #999;">Belum ada desa yang submit karya untuk kategori ini.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern styling konsisten dengan AwardDetail.php */
.wrapper-content {
    background: #f8f9fa;
}

.ibox {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    border: 2px solid #dee2e6;
    overflow: visible;
    position: relative;
    margin-bottom: 20px;
}

.ibox-title {
    background: #f8f9fa;
    padding: 15px 20px;
    border-bottom: 1px solid #dee2e6;
}

.ibox-title h5 {
    margin: 0;
    color: #495057;
    font-weight: 500;
}

.ibox-content {
    padding: 20px;
    overflow: visible;
}

/* Table styling dengan tema biru */
.table th {
    background: #f8f9fa;
    color: #495057;
    font-weight: 600;
    border-top: none;
}

.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #f8f9fa;
}

.table-hover > tbody > tr:hover {
    background-color: #e9ecef;
}

/* Badge dan button styling konsisten */
.badge-info {
    background-color: #007bff !important;
    color: white !important;
}

.badge-primary {
    background-color: #007bff !important;
    color: white !important;
}

.btn-primary {
    background-color: #007bff !important;
    border-color: #007bff !important;
}

.btn-primary:hover {
    background-color: #0056b3 !important;
    border-color: #0056b3 !important;
}

.text-navy {
    color: #007bff !important;
}

/* Alert styling */
.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.alert-warning {
    background-color: #fff3cd;
    border-color: #ffeaa7;
    color: #856404;
}

/* Label styling konsisten dengan tema */
.label-info {
    background-color: #007bff !important;
    color: white !important;
}

/* Responsive design */
@media (max-width: 768px) {
    .ibox {
        margin-bottom: 20px;
    }
    
    .table-responsive {
        border: none;
    }
}
</style>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="modalEditKategori" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Kategori Award</h4>
            </div>
            <form action="../App/Model/ExcKategoriAward.php?Act=Edit" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="IdKategoriAward" id="editIdKategoriAward">
                    
                    <div class="form-group">
                        <label>Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="NamaKategori" id="editNamaKategori" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Deskripsi Kategori</label>
                        <textarea name="DeskripsiKategori" id="editDeskripsiKategori" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> <strong>Status Kategori:</strong> Status kategori akan otomatis mengikuti status award induknya.
                        <br>Award saat ini: <strong><?php echo $StatusAward; ?></strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Update Posisi Peserta -->
<div class="modal fade" id="modalUpdatePosisi" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Posisi/Juara</h4>
            </div>
            <form action="../App/Model/ExcPesertaAward.php?Act=UpdatePosisi" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="IdPesertaAward" id="updatePosisiIdPeserta">
                    
                    <div class="form-group">
                        <label>Nama Peserta</label>
                        <input type="text" id="updatePosisiNamaPeserta" class="form-control" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>Nama Karya</label>
                        <input type="text" id="updatePosisiNamaKarya" class="form-control" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>Link Karya</label>
                        <div class="input-group">
                            <input type="text" id="updatePosisiLinkKarya" class="form-control" readonly>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-success" onclick="window.open(document.getElementById('updatePosisiLinkKarya').value, '_blank')" 
                                        id="btnLihatKarya" style="display: none;">
                                    <i class="fa fa-external-link"></i> Lihat
                                </button>
                            </span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Posisi/Juara</label>
                        <input type="number" name="Posisi" id="updatePosisiPosisi" class="form-control" min="1" 
                               placeholder="1 untuk juara 1, dst. Kosongkan jika tidak ada posisi">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Posisi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editKategori(id) {
    $.get('../App/Model/ExcKategoriAward.php?Act=GetKategoriData&Kode=' + id, function(data) {
        if (data.error) {
            alert('Error: ' + data.error);
            return;
        }
        
        $('#editIdKategoriAward').val(data.IdKategoriAward);
        $('#editNamaKategori').val(data.NamaKategori);
        $('#editDeskripsiKategori').val(data.DeskripsiKategori);
        
        $('#modalEditKategori').modal('show');
    }, 'json');
}

function updatePosisi(id, namaPeserta, namaKarya, posisi, linkKarya) {
    $('#updatePosisiIdPeserta').val(id);
    $('#updatePosisiNamaPeserta').val(namaPeserta);
    $('#updatePosisiNamaKarya').val(namaKarya);
    $('#updatePosisiPosisi').val(posisi || '');
    
    // Handle link karya
    if (linkKarya && linkKarya.trim() !== '') {
        $('#updatePosisiLinkKarya').val(linkKarya);
        $('#btnLihatKarya').show();
    } else {
        $('#updatePosisiLinkKarya').val('Tidak ada link');
        $('#btnLihatKarya').hide();
    }
    
    $('#modalUpdatePosisi').modal('show');
}

function confirmDelete(url, message) {
    if (confirm(message)) {
        window.location.href = url;
    }
}
</script>
