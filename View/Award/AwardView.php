<?php
// Include security configuration
require_once "../Module/Security/Security.php";

// Main view page untuk list award dalam format card

// Handle alert notifications with XSS protection
if (isset($_GET['alert'])) {
    $alertType = isset($_GET['alert']) ? XSSProtection::sanitizeInput($_GET['alert']) : '';
    if ($alertType == 'SaveSuccess') {
        echo "<script nonce='" . CSPHandler::getNonce() . "'>
            document.addEventListener('DOMContentLoaded', function() {
                showSuccessModal('Award berhasil ditambahkan!');
            });
        </script>";
    } elseif ($alertType == 'EditSuccess') {
        echo "<script nonce='" . CSPHandler::getNonce() . "'>
            document.addEventListener('DOMContentLoaded', function() {
                showSuccessModal('Award berhasil diupdate!');
            });
        </script>";
    } elseif ($alertType == 'DeleteSuccess') {
        echo "<script nonce='" . CSPHandler::getNonce() . "'>
            document.addEventListener('DOMContentLoaded', function() {
                showSuccessModal('Award berhasil dihapus!');
            });
        </script>";
    } elseif ($alertType == 'DeleteError') {
        echo "<script nonce='" . CSPHandler::getNonce() . "'>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal menghapus award. Silakan coba lagi.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    alert('Gagal menghapus award. Silakan coba lagi.');
                }
            });
        </script>";
    }
}
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Data Award/Penghargaan Lomba Desa</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="?pg=SAdmin">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Award Desa</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-4">
        <br>
        <div class="title-action">
            <a href="?pg=AwardAdd" class="btn btn-info">
                <i class="fa fa-plus"></i> Tambah Award
            </a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <!-- Filter Section -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form method="GET" action="">
                        <input type="hidden" name="pg" value="AwardView">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">Semua Status</option>
                                        <option value="Aktif" <?php echo (isset($_GET['status']) && XSSProtection::escapeAttr($_GET['status']) == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                        <option value="Nonaktif" <?php echo (isset($_GET['status']) && XSSProtection::escapeAttr($_GET['status']) == 'Nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Tahun</label>
                                    <select name="tahun" class="form-control">
                                        <option value="">Semua Tahun</option>
                                        <?php for($i = date('Y'); $i >= 2015; $i--): ?>
                                            <option value="<?php echo XSSProtection::escapeAttr($i); ?>" <?php echo (isset($_GET['tahun']) && XSSProtection::escapeAttr($_GET['tahun']) == $i) ? 'selected' : ''; ?>><?php echo XSSProtection::escape($i); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Cari Penghargaan</label>
                                    <input type="text" name="search" class="form-control" placeholder="Nama penghargaan..." value="<?php echo isset($_GET['search']) ? XSSProtection::escapeAttr($_GET['search']) : ''; ?>">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-info btn-block">
                                            <i class="fa fa-search"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <!--
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Total Penghargaan</h5>
                    <h1 class="no-margins"><?php include "../App/Control/StatistikAward.php"; echo $TotalAward; ?></h1>
                    <small>Semua penghargaan</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Status Aktif</h5>
                    <h1 class="no-margins text-success"><?php echo $AwardAktif; ?></h1>
                    <small>Penghargaan aktif</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Status Nonaktif</h5>
                    <h1 class="no-margins text-warning"><?php echo $AwardNonaktif; ?></h1>
                    <small>Penghargaan nonaktif</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Penghargaan <?php echo date('Y'); ?></h5>
                    <h1 class="no-margins text-info"><?php echo $AwardTahunIni; ?></h1>
                    <small>Tahun ini</small>
                </div>
            </div>
        </div>
    </div>
    -->

    <!-- Award List Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><i class="fa fa-list"></i> Daftar Award</h5>
                </div>
                <div class="ibox-content">
                    <?php include "../App/Control/FunctionAwardList.php"; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Success Custom -->
<div class="modal fade modal-success" id="modalSuccess" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center; padding: 40px 30px;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #4CAF50, #45a049); border-radius: 50%; margin: 0 auto 20px auto; display: flex; align-items: center; justify-content: center; font-size: 40px; color: white; box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);">
                    <i class="fa fa-check"></i>
                </div>
                <h4 style="font-size: 24px; font-weight: 600; color: #333; margin-bottom: 15px;">Berhasil!</h4>
                <p style="color: #666; font-size: 16px; line-height: 1.5; margin-bottom: 25px;" id="successMessage">
                    Data berhasil disimpan
                </p>
                <button type="button" class="btn btn-success-ok" style="background: linear-gradient(135deg, #007bff, #0056b3); color: white; border: none; padding: 12px 30px; border-radius: 25px; font-weight: 600; font-size: 16px;">
                    OK
                </button>
            </div>
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
                    <button type="button" class="btn btn-cancel-delete" style="background: #6c757d; color: white; border: none; padding: 12px 25px; border-radius: 25px; font-weight: 600;">
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

<style>
/* Award List Styling - Menggunakan style dari AwardViewAdminDesa */
.wrapper-content {
    background: #f8f9fa;
}

.ibox {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    border: none;
    position: relative;
}

.ibox-title {
    background: white;
    color: #495057;
    padding: 20px 25px;
    border-bottom: 1px solid #e6e9ed;
}

.ibox-title h5 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
}

.ibox-title i {
    margin-right: 10px;
    font-size: 1.2rem;
}

.ibox-content {
    padding: 0;
    overflow: visible;
}

/* Jika ada content di dalam ibox-content yang bukan award-item, beri padding */
.ibox-content > div:not(.award-item):not(.award-list) {
    padding: 20px;
}

/* Award List Container */
.award-list {
    padding: 0;
}

/* Styling untuk award-item yang sudah ada di FunctionAwardList.php */
.award-item {
    display: flex;
    align-items: flex-start;
    padding: 25px;
    border-bottom: 1px solid #f1f3f4;
    transition: all 0.3s ease;
    background: white;
    margin-bottom: 0 !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    border: none !important;
    position: relative;
}

.award-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}

.award-item:last-child {
    border-bottom: none;
}

/* Nomor urut styling - seperti AwardViewAdminDesa */
.award-item .col-md-1:first-child {
    min-width: 60px;
    margin-right: 20px;
    padding: 0 !important;
}

.award-item .col-md-1:first-child h4 {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 45px !important;
    height: 45px !important;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white !important;
    border-radius: 50% !important;
    font-weight: 700 !important;
    font-size: 1.1rem !important;
    box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3) !important;
    margin: 0 !important;
}

/* Award content area */
.award-item .col-md-8 {
    flex: 1;
    padding: 0 !important;
}

/* Award title - style seperti AwardViewAdminDesa */
.award-item .col-md-8 h4 {
    margin: 0 0 10px 0 !important;
    font-size: 1.3rem !important;
    font-weight: 600 !important;
    color: #2c3e50 !important;
    text-decoration: none !important;
}

.award-item .col-md-8 h4 i {
    margin-right: 8px;
    font-size: 1.2rem;
    color: #ffc107;
}

/* Award details section */
.award-item .col-md-8 .award-details {
    margin: 15px 0;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #667eea;
}

/* Info paragraphs styling */
.award-item .col-md-8 p {
    display: flex;
    align-items: center;
    margin-bottom: 8px !important;
    font-size: 0.9rem !important;
    color: #555 !important;
    line-height: 1.4 !important;
}

.award-item .col-md-8 p:last-child {
    margin-bottom: 0 !important;
}

/* Icons FontAwesome - detail row style */
.award-item .col-md-8 p .fa {
    min-width: 25px;
    text-align: center;
    margin-right: 10px;
    color: #667eea;
    width: auto;
}

/* Status badge positioning and styling */
.award-item .col-md-2 {
    position: absolute !important;
    top: 25px !important;
    right: 120px !important;
    width: auto !important;
    padding: 0 !important;
}

.award-item .col-md-2 .label {
    padding: 6px 14px !important;
    border-radius: 20px !important;
    font-size: 0.75rem !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    display: inline-block !important;
}

/* Action buttons positioning */
.award-item .col-md-1:last-child {
    position: absolute !important;
    top: 25px !important;
    right: 15px !important;
    width: auto !important;
    padding: 0 !important;
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

/* Button styling */
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

/* Filter button styling - warna biru seperti aktif */
.btn-info {
    background-color: #007bff !important;
    border-color: #007bff !important;
    color: white !important;
}

.btn-info:hover {
    background-color: #0056b3 !important;
    border-color: #0056b3 !important;
    color: white !important;
}

/* Status Colors - menggunakan style AwardViewAdminDesa */
.label-primary, .status-aktif {
    background-color: #e3f2fd !important;
    color: #1976d2 !important;
    border: 1px solid #90caf9 !important;
}

.label-success, .status-pendaftaran {
    background-color: #e8f5e8 !important;
    color: #2e7d32 !important;
    border: 1px solid #a5d6a7 !important;
}

.label-warning, .status-berlangsung {
    background-color: #fff3e0 !important;
    color: #f57c00 !important;
    border: 1px solid #ffcc02 !important;
}

.label-danger, .status-selesai {
    background-color: #f3e5f5 !important;
    color: #7b1fa2 !important;
    border: 1px solid #ce93d8 !important;
}

.label-default, .status-tutup {
    background-color: #fafafa !important;
    color: #616161 !important;
    border: 1px solid #e0e0e0 !important;
}

/* Override khusus untuk badge Non-Aktif agar lebih terlihat */
.award-item .label {
    min-width: 80px !important;
    display: inline-block !important;
    text-align: center !important;
    font-weight: 600 !important;
    letter-spacing: 0.5px !important;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    font-size: 4rem;
    color: #ddd;
    margin-bottom: 20px;
}

.empty-content h4 {
    color: #666;
    margin-bottom: 10px;
    font-size: 1.3rem;
}

.empty-content p {
    color: #999;
    font-size: 1rem;
}

/* Award Description */
.award-description {
    font-size: 0.95rem;
    color: #666;
    line-height: 1.6;
    margin-top: 15px;
    padding: 15px;
    background-color: #fff;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

/* Responsive design */
@media (max-width: 768px) {
    .award-item {
        flex-direction: column;
        padding: 20px 15px !important;
    }
    
    .award-item .col-md-1:first-child {
        margin-bottom: 15px;
        margin-right: 0;
        text-align: center;
    }
    
    .award-item .col-md-1:first-child h4 {
        width: 40px !important;
        height: 40px !important;
        font-size: 1rem !important;
    }
    
    .award-item .col-md-8 h4 {
        font-size: 1.1rem !important;
        margin-bottom: 12px !important;
    }
    
    .award-item .col-md-8 p {
        font-size: 0.85rem !important;
    }
    
    .award-item .col-md-8 .award-details {
        margin: 10px 0;
        padding: 12px;
    }
    
    .award-item .col-md-2,
    .award-item .col-md-1:last-child {
        position: relative !important;
        top: auto !important;
        right: auto !important;
        margin-top: 15px;
        text-align: center !important;
    }
    
    .ibox-title {
        padding: 15px 20px;
    }
    
    .ibox-title h5 {
        font-size: 1.2rem;
    }
}

/* Remove default table styling if any */
.ibox-content table,
.ibox-content .table {
    display: none;
}

/* Ensure award-item is visible */
.ibox-content .award-item {
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

<script nonce="<?php echo CSPHandler::getNonce(); ?>">
$(document).ready(function() {
    // Debug: Check if jQuery and modal are working
    console.log('AwardView.php loaded, jQuery version:', $.fn.jquery);
    console.log('Modal element exists:', $('#modalConfirmDelete').length > 0);
    
    // Event listener untuk delete award button (CSP-compliant)
    $(document).on('click', '.delete-award-btn', function(e) {
        e.preventDefault();
        
        var awardId = $(this).data('award-id');
        var awardName = $(this).data('award-name');
        
        console.log('Delete clicked for:', awardId, awardName);
        
        // Call confirm delete function
        confirmDeleteAward(awardId, awardName);
        
        return false;
    });
    
    // Event listener untuk tombol Batal di modal delete (CSP-compliant)
    $(document).on('click', '.btn-cancel-delete', function(e) {
        e.preventDefault();
        $('#modalConfirmDelete').modal('hide');
        return false;
    });
    
    // Event listener untuk tombol OK di modal success (CSP-compliant)
    $(document).on('click', '.btn-success-ok', function(e) {
        e.preventDefault();
        $('#modalSuccess').modal('hide');
        return false;
    });
    
    // Test modal functionality
    window.testModal = function() {
        $('#modalConfirmDelete').modal('show');
    };
    
    // Test confirmDeleteAward function
    window.testDeleteFunction = function() {
        confirmDeleteAward('test123', 'Test Award');
    };
    
    // Hapus teks "Sudah Berakhir" dari semua elemen
    setTimeout(function() {
        // Hapus teks dalam semua elemen text
        $('*').contents().filter(function() {
            return this.nodeType === 3; // Text nodes
        }).each(function() {
            if (this.textContent.includes('Sudah Berakhir')) {
                this.textContent = this.textContent.replace(/Sudah Berakhir/g, '');
            }
            if (this.textContent.includes('sudah berakhir')) {
                this.textContent = this.textContent.replace(/sudah berakhir/gi, '');
            }
        });
        
        // Hapus elemen yang hanya berisi teks "Sudah Berakhir"
        $('.text-muted').each(function() {
            var text = $(this).text().trim();
            if (text === 'Sudah Berakhir' || text === 'sudah berakhir') {
                $(this).hide();
            }
        });
        
        // Hapus dari semua td
        $('td').each(function() {
            var html = $(this).html();
            if (html && html.includes('Sudah Berakhir')) {
                $(this).html(html.replace(/Sudah Berakhir/g, ''));
            }
            if (html && html.includes('sudah berakhir')) {
                $(this).html(html.replace(/sudah berakhir/gi, ''));
            }
        });
        
    }, 500); // Delay untuk memastikan konten sudah dimuat
    
    // Fix dropdown yang terpotong
    $('.dropdown-menu').each(function() {
        $(this).css({
            'position': 'absolute',
            'z-index': '1050',
            'min-width': '150px'
        });
    });
    
    // Fix overflow untuk dropdown
    $('.table-responsive').css('overflow', 'visible');
    $('.dataTables_wrapper').css('overflow', 'visible');
    $('.ibox').css('overflow', 'visible');
    $('.ibox-content').css('overflow', 'visible');
    
    // Event untuk dropdown yang dinamis
    $(document).on('show.bs.dropdown', '.dropdown', function() {
        $(this).find('.dropdown-menu').css({
            'position': 'absolute',
            'z-index': '1050'
        });
    });
    
    // Add hover effects to award items
    $(document).on('mouseenter', '.award-item', function() {
        $(this).css({
            'box-shadow': '0 8px 20px rgba(0,0,0,0.15)',
            'transform': 'translateY(-3px)'
        });
    });
    
    $(document).on('mouseleave', '.award-item', function() {
        $(this).css({
            'box-shadow': '0 4px 12px rgba(0,0,0,0.1)',
            'transform': 'translateY(0)'
        });
    });
});

// Function untuk show success modal
function showSuccessModal(message) {
    document.getElementById('successMessage').innerHTML = message.replace(/\n/g, '<br>');
    $('#modalSuccess').modal({
        backdrop: 'static',
        keyboard: false
    });
}

// Function untuk konfirmasi hapus award
function confirmDeleteAward(id, nama) {
    // Debug: Log parameters
    console.log('confirmDeleteAward called with:', {id: id, nama: nama});
    
    // Escape nama untuk mencegah XSS
    var namaEscaped = nama.replace(/'/g, "&#39;").replace(/"/g, "&quot;");
    
    document.getElementById('deleteMessage').innerHTML = 'Penghargaan "<strong>' + namaEscaped + '</strong>" akan dihapus permanen.<br><br>Semua kategori dan peserta dalam penghargaan ini juga akan ikut terhapus.';
    
    document.getElementById('confirmDeleteBtn').onclick = function() {
        // Debug: Log the URL that will be called
        var deleteUrl = '../App/Model/ExcAward.php?Act=Delete&Kode=' + encodeURIComponent(id);
        console.log('Delete URL:', deleteUrl);
        
        // Close modal first
        $('#modalConfirmDelete').modal('hide');
        
        // Add loading overlay
        document.body.innerHTML += '<div id="loadingOverlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">Menghapus penghargaan...</div>';
        
        // Log before redirect
        console.log('Redirecting to:', deleteUrl);
        
        // Redirect to delete URL
        window.location.href = deleteUrl;
    };
    
    // Show modal
    console.log('Showing modal...');
    $('#modalConfirmDelete').modal({
        backdrop: 'static',
        keyboard: false
    });
}
</script>
