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
                        <i class="fa fa-trophy" style="font-size: 80px; color: #FFD700; margin-bottom: 20px;"></i>
                        <h1 class="font-bold"><?php echo $JenisPenghargaan; ?></h1>
                        <div style="margin: 15px 0;">
                            <span class="badge badge-primary badge-lg" style="font-size: 16px; padding: 8px 15px; background-color: #007bff; color: white;">
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
            <div class="ibox" style="margin-bottom: 10px;">
                <div class="ibox-content">
                    <div class="btn-group-vertical btn-block">
                        <a href="?pg=AwardEdit&Kode=<?php echo $IdAward; ?>" class="btn btn-success">
                            <i class="fa fa-edit"></i> Edit Penghargaan
                        </a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddKategori">
                            <i class="fa fa-plus"></i> Tambah Kategori
                        </button>
                        <button type="button" class="btn btn-danger" onclick="confirmDeleteAward('<?php echo $IdAward; ?>', '<?php echo addslashes($JenisPenghargaan . ' ' . $TahunPenghargaan); ?>')">
                            <i class="fa fa-trash"></i> Hapus Penghargaan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Info Panel -->
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Deskripsi Penghargaan</h5>
                </div>
                <?php if (!empty($Deskripsi)): ?>
                    <div class="ibox-content text-center" style="min-height: 172px;">
                        <p class="form-control-static"><?php echo nl2br($Deskripsi); ?></p>
                    </div>
                <?php else: ?>
                    <div class="ibox-content text-center" style="min-height: 172px;">
                        <p class="form-control-static text-muted"><em>Tidak ada deskripsi</em></p>
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
                    <h5><i class="fa fa-list"></i> Kategori Award</h5>
                </div>
                <div class="ibox-content">
                    <?php include "../App/Control/FunctionAwardKategoriList.php"; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Card List Styling - Sama seperti AwardView.php */
.wrapper-content {
    background: #f8f9fa;
}

.ibox {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    border: 1px solid #e7eaec;
    overflow: visible;
    position: relative;
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

/* Styling untuk kategori items - mendekatkan jarak antara kolom */
.kategori-item {
    background: white;
    margin-bottom: 20px !important;
    padding: 20px !important;
    border-radius: 12px !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    border: 1px solid #e9ecef !important;
    border-bottom: none !important;
    transition: all 0.3s ease;
    position: relative;
}

.kategori-item:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
    transform: translateY(-3px);
}

/* Mendekatkan kolom nomor dengan kolom data lebih lagi */
.kategori-item .col-md-1:first-child {
    padding-right: 5px !important;
    margin-right: 0 !important;
    padding-left: 5px !important;
}

.kategori-item .col-md-1:nth-child(2) {
    padding-left: 0px !important;
    padding-right: 0px !important;
    margin-left: -20px !important;
}

.kategori-item .col-md-6 {
    padding-left: 0px !important;
    margin-left: -25px !important;
}

/* Nomor urut styling - kotak biru dengan nomor di tengah kiri */
.kategori-item .col-md-1:first-child h4 {
    background: #007bff !important;
    color: white !important;
    width: 40px !important;
    height: 40px !important;
    border-radius: 8px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-weight: bold !important;
    font-size: 16px !important;
    margin: 0 !important;
    margin-top: 0 !important;
    margin-left: 0 !important;
    text-align: center !important;
    line-height: 10px !important;
    vertical-align: middle !important;
}

/* Hapus icon piala di nomor urut */
.kategori-item .col-md-1 .fa-trophy {
    display: none !important;
}

/* Title styling - dengan icon medali tanpa nomor dan warna biru */
.kategori-item .col-md-6 h4 {
    font-size: 18px !important;
    font-weight: 700 !important;
    color: #007bff !important;
    margin-bottom: 10px !important;
    text-decoration: none !important;
}

/* Add medal icon tanpa nomor - hanya emoji medali */
.kategori-item .col-md-6 h4:before {
    content: "🏅 ";
    margin-right: 10px;
}

/* Info paragraphs styling */
.kategori-item .col-md-6 p {
    font-size: 14px !important;
    line-height: 1.4 !important;
    margin-bottom: 5px !important;
    color: #6c757d !important;
}

/* Deskripsi tanpa margin bottom */
.kategori-item .col-md-6 p:last-child {
    margin-bottom: 0 !important;
}

/* Icons FontAwesome */
.kategori-item .col-md-6 p .fa {
    margin-right: 8px;
    color: #999;
    width: 16px;
    text-align: center;
}

/* Status badge positioning and styling - diperbaiki agar tidak terpotong */
.kategori-item .col-md-2 {
    position: absolute !important;
    top: 25px !important;
    right: 120px !important;
    width: auto !important;
    min-width: 100px !important;
}

.kategori-item .col-md-2 .label {
    padding: 8px 12px !important;
    font-size: 11px !important;
    border-radius: 20px !important;
    font-weight: 500 !important;
    text-transform: uppercase !important;
    min-width: 90px !important;
    display: inline-block !important;
    text-align: center !important;
    font-weight: 600 !important;
    letter-spacing: 0.3px !important;
    white-space: nowrap !important;
}

/* Action buttons positioning - dipindahkan lebih jauh */
.kategori-item .col-md-2:last-child {
    position: absolute !important;
    top: 25px !important;
    right: 15px !important;
    width: auto !important;
}

/* Badge styling - konsisten dengan tema biru */
.label-success {
    background-color: #007bff !important;
    color: white !important;
}

.label-primary {
    background-color: #007bff !important;
    color: white !important;
}

.label-warning {
    background-color: #ffc107 !important;
    color: #212529 !important;
}

.label-danger {
    background-color: #dc3545 !important;
    color: white !important;
}

.label-default {
    background-color: #6c757d !important;
    color: white !important;
}

/* Dropdown styling */
.dropdown-menu {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border: 1px solid #e9ecef;
    border-radius: 6px;
    z-index: 1050;
    min-width: 150px;
}

.dropdown-item {
    padding: 10px 16px;
    color: #495057;
    font-size: 14px;
}

.dropdown-item:hover {
    background: #f8f9fa;
    color: #495057;
}

.btn-outline {
    border: 1px solid #ddd;
    background: #f8f9fa;
    color: #6c757d;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 12px;
}

.btn-outline:hover {
    background: #e9ecef;
    border-color: #adb5bd;
}

/* Responsive design */
@media (max-width: 768px) {
    .kategori-item {
        padding: 20px !important;
    }
    
    .kategori-item .col-md-1:first-child h4 {
        width: 35px !important;
        height: 35px !important;
        font-size: 14px !important;
    }
    
    .kategori-item .col-md-6 h4 {
        font-size: 16px !important;
        margin-bottom: 12px !important;
    }
    
    .kategori-item .col-md-6 p {
        font-size: 13px !important;
    }
    
    .kategori-item .col-md-2 {
        position: relative !important;
        top: auto !important;
        right: auto !important;
        margin-top: 15px;
        text-align: left !important;
    }
}

/* Remove default table styling if any */
.ibox-content table,
.ibox-content .table {
    display: none;
}

/* Ensure kategori-item is visible */
.ibox-content .kategori-item {
    display: block !important;
}

/* Additional spacing */
.ibox-content > div:first-child {
    margin-top: 0;
}

.ibox-content > div:last-child {
    margin-bottom: 0;
}
</style>

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
                        <select name="Posisi" id="updatePosisiPosisi" class="form-control">
                            <option value="">-- Tidak Mendapat Juara --</option>
                            <option value="1">🥇 Juara 1</option>
                            <option value="2">🥈 Juara 2</option>
                            <option value="3">🥉 Juara 3</option>
                        </select>
                        <small class="text-muted">Hanya tersedia juara 1, 2, dan 3. Peserta lain tidak mendapat juara.</small>
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

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center; padding: 40px 30px;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f44336, #d32f2f); border-radius: 50%; margin: 0 auto 20px auto; display: flex; align-items: center; justify-content: center; font-size: 40px; color: white; box-shadow: 0 5px 15px rgba(244, 67, 54, 0.3);">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
                <h4 style="font-size: 24px; font-weight: 600; color: #333; margin-bottom: 15px;">Yakin ingin menghapus penghargaan?</h4>
                <p style="color: #666; font-size: 16px; line-height: 1.5; margin-bottom: 25px;" id="deleteMessage">
                    Penghargaan yang sudah dihapus tidak dapat dikembalikan.
                </p>
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button type="button" class="btn" style="background: #6c757d; color: white; border: none; padding: 12px 25px; border-radius: 25px; font-weight: 600;" onclick="closeDeleteModal()">
                        Batal
                    </button>
                    <button type="button" class="btn" style="background: linear-gradient(135deg, #f44336, #d32f2f); color: white; border: none; padding: 12px 25px; border-radius: 25px; font-weight: 600;" id="confirmDeleteBtn">
                        Hapus
                    </button>
                </div>
            </div>
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
    
    // Set dropdown value berdasarkan posisi
    if (posisi && (posisi == 1 || posisi == 2 || posisi == 3)) {
        $('#updatePosisiPosisi').val(posisi);
    } else {
        $('#updatePosisiPosisi').val(''); // Tidak mendapat juara
    }
    
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

// Function untuk konfirmasi hapus award
function confirmDeleteAward(id, nama) {
    document.getElementById('deleteMessage').innerHTML = 'Penghargaan "<strong>' + nama + '</strong>" akan dihapus permanen.<br><br>Semua kategori dan peserta dalam penghargaan ini juga akan ikut terhapus.';
    
    document.getElementById('confirmDeleteBtn').onclick = function() {
        window.location.href = '../App/Model/ExcAward.php?Act=Delete&Kode=' + id;
    };
    
    $('#modalConfirmDelete').modal({
        backdrop: 'static',
        keyboard: false
    });
}

// Function untuk close delete modal
function closeDeleteModal() {
    $('#modalConfirmDelete').modal('hide');
}

$(document).ready(function() {
    // Add hover effects to kategori items - sama seperti AwardView.php
    $(document).on('mouseenter', '.kategori-item', function() {
        $(this).css({
            'box-shadow': '0 8px 20px rgba(0,0,0,0.15)',
            'transform': 'translateY(-3px)'
        });
    });
    
    $(document).on('mouseleave', '.kategori-item', function() {
        $(this).css({
            'box-shadow': '0 4px 12px rgba(0,0,0,0.1)',
            'transform': 'translateY(0)'
        });
    });
    
    // Fix dropdown positioning
    $(document).on('show.bs.dropdown', '.dropdown', function() {
        $(this).find('.dropdown-menu').css({
            'position': 'absolute',
            'z-index': '1050'
        });
    });
    
    // Fix overflow untuk dropdown
    $('.ibox').css('overflow', 'visible');
    $('.ibox-content').css('overflow', 'visible');
});
</script>
