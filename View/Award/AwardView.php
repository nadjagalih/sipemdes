<?php
// Main view page untuk list award dalam format card
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
                                        <option value="Aktif" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                        <option value="Nonaktif" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Tahun</label>
                                    <select name="tahun" class="form-control">
                                        <option value="">Semua Tahun</option>
                                        <?php for($i = date('Y'); $i >= 2015; $i--): ?>
                                            <option value="<?php echo $i; ?>" <?php echo (isset($_GET['tahun']) && $_GET['tahun'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Cari Penghargaan</label>
                                    <input type="text" name="search" class="form-control" placeholder="Nama penghargaan..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
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

<style>
/* Modern Card List Styling - Untuk struktur div yang sudah ada */
.wrapper-content {
    background: #f8f9fa;
}

.ibox {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    overflow: visible;
    border: none;
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

/* Styling untuk award-item yang sudah ada di FunctionAwardList.php */
.award-item {
    background: white;
    margin-bottom: 20px !important;
    padding: 25px !important;
    border-radius: 12px !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    border: 1px solid #e9ecef !important;
    border-bottom: none !important; /* Override border-bottom dari PHP */
    transition: all 0.3s ease;
    position: relative;
}

.award-item:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
    transform: translateY(-3px);
}

/* Nomor urut styling */
.award-item .col-md-1:first-child h4 {
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
    margin: 0 auto !important;
}

/* Award title - sesuaikan dengan AwardDesa.php */
.award-item .col-md-8 h4 {
    font-size: 18px !important;
    font-weight: 700 !important;
    color: #007bff !important;
    margin-bottom: 10px !important;
    text-decoration: none !important;
}

/* Add trophy icon - hanya satu */
.award-item .col-md-8 h4:before {
    content: "🏆 ";
    margin-right: 10px;
}

/* Info paragraphs styling - rapat seperti gambar */
.award-item .col-md-8 p {
    font-size: 14px !important;
    line-height: 1.4 !important;
    margin-bottom: 5px !important;
    color: #6c757d !important;
}

/* Deskripsi tanpa margin bottom */
.award-item .col-md-8 p:last-child {
    margin-bottom: 0 !important;
}

/* Icons FontAwesome seperti di gambar */
.award-item .col-md-8 p .fa {
    margin-right: 8px;
    color: #999;
    width: 16px;
    text-align: center;
}

/* Status badge positioning and styling */
.award-item .col-md-2 {
    position: absolute !important;
    top: 25px !important;
    right: 80px !important;
    width: auto !important;
}

.award-item .col-md-2 .label {
    padding: 8px 16px !important;
    font-size: 12px !important;
    border-radius: 20px !important;
    font-weight: 500 !important;
    text-transform: uppercase !important;
}

/* Action buttons positioning */
.award-item .col-md-1:last-child {
    position: absolute !important;
    top: 25px !important;
    right: 25px !important;
    width: auto !important;
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

/* Status badge colors - lebih kontras dan terlihat */
.label-primary {
    background-color: #007bff !important;
    color: white !important;
}

.label-success {
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

/* Override khusus untuk badge Non-Aktif agar lebih terlihat */
.award-item .label {
    min-width: 80px !important;
    display: inline-block !important;
    text-align: center !important;
    font-weight: 600 !important;
    letter-spacing: 0.5px !important;
}

/* Responsive design */
@media (max-width: 768px) {
    .award-item {
        padding: 20px !important;
    }
    
    .award-item .col-md-1:first-child h4 {
        width: 35px !important;
        height: 35px !important;
        font-size: 14px !important;
    }
    
    .award-item .col-md-8 h4 {
        font-size: 16px !important;
        margin-bottom: 12px !important;
    }
    
    .award-item .col-md-8 p {
        font-size: 13px !important;
    }
    
    .award-item .col-md-2,
    .award-item .col-md-1:last-child {
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

<script>
$(document).ready(function() {
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
</script>
