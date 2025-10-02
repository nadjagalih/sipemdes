<?php
include "../App/Control/FunctionAwardDetail.php";
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Award/Penghargaan</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="?pg=SAdmin">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="?pg=AwardView">Award Desa</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detail</strong>
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
        <div class="col-lg-8">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="text-center">
                        <i class="fa fa-trophy" style="font-size: 80px; color: #1ab394; margin-bottom: 20px;"></i>
                        <h1 class="font-bold"><?php echo $JenisPenghargaan; ?></h1>
                        <div style="margin: 15px 0;">
                            <span class="badge badge-primary badge-lg" style="font-size: 16px; padding: 8px 15px;">
                                Tahun <?php echo $TahunPenghargaan; ?>
                            </span>
                            <span class="badge <?php echo ($StatusAktif == 'Aktif') ? 'badge-success' : 'badge-secondary'; ?> badge-lg" style="font-size: 16px; padding: 8px 15px; margin-left: 10px;">
                                <?php echo $StatusAktif; ?>
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group text-center">
                                <label><strong>Masa Aktif Penghargaan:</strong></label>
                                <p class="form-control-static">
                                    <?php 
                                    if (!empty($MasaAktifMulai) && !empty($MasaAktifSelesai)) {
                                        echo date('d M Y', strtotime($MasaAktifMulai)) . ' - ' . date('d M Y', strtotime($MasaAktifSelesai));
                                        
                                        // Cek apakah masih dalam masa aktif
                                        $today = date('Y-m-d');
                                        if ($today >= $MasaAktifMulai && $today <= $MasaAktifSelesai) {
                                            echo ' <span class="label label-success">Sedang Berlangsung</span>';
                                        } elseif ($today < $MasaAktifMulai) {
                                            echo ' <span class="label label-warning">Belum Dimulai</span>';
                                        } else {
                                            echo ' <span class="label label-default">Sudah Berakhir</span>';
                                        }
                                    } else {
                                        echo '<em class="text-muted">Belum ditentukan</em>';
                                    }
                                    ?>
                                </p>
                            </div>
                            
                            <div class="form-group text-center">
                                <label><strong>Masa Penjurian:</strong></label>
                                <p class="form-control-static">
                                    <?php 
                                    if (!empty($MasaPenjurianMulai) && !empty($MasaPenjurianSelesai)) {
                                        echo date('d M Y', strtotime($MasaPenjurianMulai)) . ' - ' . date('d M Y', strtotime($MasaPenjurianSelesai));
                                        
                                        // Cek status masa penjurian
                                        if ($isMasaPenjurian) {
                                            echo ' <span class="label label-success">Sedang Berlangsung</span>';
                                        } elseif ($today < $MasaPenjurianMulai) {
                                            echo ' <span class="label label-warning">Belum Dimulai</span>';
                                        } else {
                                            echo ' <span class="label label-default">Sudah Berakhir</span>';
                                        }
                                    } else {
                                        echo '<em class="text-muted">Belum ditentukan</em>';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Action Panel -->
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Aksi</h5>
                </div>
                <div class="ibox-content">
                    <div class="btn-group-vertical btn-block">
                        <a href="?pg=AwardEdit&Kode=<?php echo $IdAward; ?>" class="btn btn-success">
                            <i class="fa fa-edit"></i> Edit Penghargaan
                        </a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddKategori">
                            <i class="fa fa-plus"></i> Tambah Kategori
                        </button>
                        <a href="../App/Model/ExcAward.php?Act=Delete&Kode=<?php echo $IdAward; ?>" 
                           onclick="return confirm('Yakin ingin menghapus penghargaan ini?');" class="btn btn-danger">
                            <i class="fa fa-trash"></i> Hapus Penghargaan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info Panel -->
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Informasi</h5>
                </div>
                <?php if (!empty($Deskripsi)): ?>
                    <div class="ibox-content text-center">
                        <p class="form-control-static"><?php echo nl2br($Deskripsi); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Kategori dan Peserta Section -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Kategori dan Peserta Award</h5>
                </div>
                <div class="ibox-content">
                    <?php include "../App/Control/FunctionAwardKategoriList.php"; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Kategori -->
<div class="modal fade" id="modalAddKategori" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Kategori Award</h4>
            </div>
            <form action="../App/Model/ExcKategoriAward.php?Act=Add" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="IdAward" value="<?php echo $IdAward; ?>">
                    
                    <div class="form-group">
                        <label>Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="NamaKategori" class="form-control" required 
                               placeholder="Contoh: Desa Wisata Terbaik">
                    </div>
                    
                    <div class="form-group">
                        <label>Deskripsi Kategori</label>
                        <textarea name="DeskripsiKategori" class="form-control" rows="3" 
                                  placeholder="Deskripsi kategori (opsional)"></textarea>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> <strong>Status Kategori:</strong> Status kategori akan otomatis mengikuti status award ini.
                        <br>Award ini saat ini: <strong><?php echo $StatusAktif; ?></strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                </div>
            </form>
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
                        <br>Award saat ini: <strong><?php echo $StatusAktif; ?></strong>
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

function lihatKarya() {
    var linkKarya = $('#updatePosisiLinkKarya').val();
    if (linkKarya && linkKarya.trim() !== '' && linkKarya !== 'Tidak ada link') {
        window.open(linkKarya, '_blank');
    } else {
        alert('Link karya tidak tersedia');
    }
}

function confirmDelete(url, message) {
    if (confirm(message)) {
        window.location.href = url;
    }
}
</script>
