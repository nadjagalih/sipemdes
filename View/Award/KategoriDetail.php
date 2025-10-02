<?php
include "../App/Control/FunctionKategoriDetail.php";
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
            <div class="ibox">
                <div class="ibox-content">
                    <div class="text-center">
                        <i class="fa fa-trophy" style="font-size: 60px; color: #f8ac59; margin-bottom: 20px;"></i>
                        <h1 class="font-bold"><?php echo $NamaKategori; ?></h1>
                        <div style="margin: 15px 0;">
                            <span class="badge badge-warning badge-lg" style="font-size: 14px; padding: 6px 12px;">
                                Kategori <?php echo $JenisPenghargaan; ?>
                            </span>
                            <span class="badge <?php echo ($StatusAward == 'Aktif') ? 'badge-success' : 'badge-secondary'; ?> badge-lg" style="font-size: 14px; padding: 6px 12px; margin-left: 10px;">
                                Award <?php echo $StatusAward; ?>
                            </span>
                        </div>
                        <?php if (!empty($DeskripsiKategori)): ?>
                            <p class="text-muted" style="margin-top: 15px; font-size: 16px;">
                                <?php echo nl2br($DeskripsiKategori); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Stats Panel -->
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Statistik Peserta</h5>
                </div>
                <div class="ibox-content">
                    <div class="row text-center">
                        <div class="col-xs-6">
                            <h2 class="font-bold text-navy"><?php echo $totalPeserta; ?></h2>
                            <span>Total Peserta</span>
                        </div>
                        <div class="col-xs-6">
                            <h2 class="font-bold text-primary"><?php echo $pesertaBerposisi; ?></h2>
                            <span>Sudah Berposisi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Panel -->
            <div class="ibox">
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

            <!-- Info Masa Penjurian -->
            <div class="ibox">
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
                    <div class="ibox-tools">
                        <span class="label label-info"><?php echo $totalPeserta; ?> Peserta</span>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php if ($totalPeserta > 0): ?>
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
