<?php
// Main view page untuk list award yang tersedia untuk admin desa
include __DIR__ . "/../../../App/Control/FunctionAwardListAdminDesa.php";
?>

<style>
    .wrapper-content {
        padding: 0 20px 20px 20px;
        background: white;
        min-height: calc(100vh - 60px);
    }
    
    .list-section {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    
    .list-header {
        background: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .list-header h5 {
        margin: 0;
        color: #495057;
        font-weight: 500;
    }
    
    .award-list {
        padding: 0;
    }
    
    .award-item-row {
        display: flex;
        align-items: flex-start;
        padding: 20px;
        border-bottom: 1px solid #f1f1f1;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }
    
    .award-item-row:hover {
        background: #f8f9fa;
    }
    
    .award-item-row:last-child {
        border-bottom: none;
    }
    
    .award-number {
        margin-right: 20px;
        min-width: 40px;
    }
    
    .award-number .number {
        display: inline-block;
        width: 30px;
        height: 30px;
        background: #007bff;
        color: white;
        text-align: center;
        line-height: 30px;
        border-radius: 4px;
        font-weight: 500;
        font-size: 14px;
    }
    
    .award-content {
        flex: 1;
        margin-right: 15px;
    }
    
    .award-main-info {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
    }
    
    .award-title {
        color: #007bff;
        margin: 0;
        font-size: 18px;
        font-weight: 500;
    }
    
    .award-title:hover {
        text-decoration: none;
        color: #0056b3;
    }
    
    .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
    }
    
    /* Status Pill - bentuk capsule/pill */
    .status-pill {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 50px; /* Bentuk capsule/pill */
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-right: 10px;
    }
    
    /* Status Action Group - untuk layout horizontal */
    .status-action-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    /* Status Colors - capsule style */
    .status-berlangsung {
        background: #28a745;
        color: white;
    }
    
    .status-aktif {
        background: #d4edda;
        color: #155724;
    }
    
    .status-berlangsung {
        background: #28a745;
        color: white;
    }
    
    .status-pendaftaran {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-tutup {
        background: #f8d7da;
        color: #721c24;
    }
    
    .status-selesai {
        background: #f8d7da;
        color: #721c24;
    }
    
    .btn-pilih-award {
        background: #007bff;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .btn-pilih-award:hover {
        background: #0056b3;
        color: white;
        transform: translateY(-1px);
    }
    
    .award-details {
        margin-bottom: 10px;
    }
    
    .detail-row {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
        font-size: 14px;
        color: #666;
    }
    
    .detail-icon {
        width: 20px;
        margin-right: 8px;
        color: #999;
    }
    
    .detail-text {
        line-height: 1.4;
    }
    
    .award-description {
        color: #888;
        font-size: 14px;
        line-height: 1.5;
        margin-top: 8px;
    }
    
    /* Award List Styling */
    .list-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .list-header {
        background: white;
        color: white;
        padding: 20px 25px;
        border-bottom: 1px solid #e6e9ed;
    }
    
    .list-header h5 {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 600;
    }
    
    .list-header i {
        margin-right: 10px;
        font-size: 1.2rem;
    }
    
    .award-list {
        padding: 0;
    }
    
    .award-item-row {
        display: flex;
        align-items: flex-start;
        padding: 25px;
        border-bottom: 1px solid #f1f3f4;
        transition: all 0.3s ease;
        background: white;
    }
    
    .award-item-row:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .award-item-row:last-child {
        border-bottom: none;
    }
    
    .award-number {
        min-width: 60px;
        margin-right: 20px;
    }
    
    .award-number .number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 50%;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
    }
    
    .award-content {
        flex: 1;
    }
    
    .award-main-info {
        margin-bottom: 15px;
    }
    
    .award-title {
        margin: 0 0 10px 0;
        font-size: 1.3rem;
        font-weight: 600;
        color: #2c3e50;
    }
    
    .award-title i {
        margin-right: 8px;
        font-size: 1.2rem;
    }
    
    .award-status {
        margin-bottom: 15px;
    }
    
    .status-action-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .status-pill {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }
    
    .status-pendaftaran {
        background-color: #e8f5e8;
        color: #2e7d32;
        border: 1px solid #a5d6a7;
    }
    
    .status-berlangsung {
        background-color: #fff3e0;
        color: #f57c00;
        border: 1px solid #ffcc02;
    }
    
    .status-selesai {
        background-color: #f3e5f5;
        color: #7b1fa2;
        border: 1px solid #ce93d8;
    }
    
    .status-aktif {
        background-color: #e3f2fd;
        color: #1976d2;
        border: 1px solid #90caf9;
    }
    
    .status-tutup {
        background-color: #fafafa;
        color: #616161;
        border: 1px solid #e0e0e0;
    }
    
    .btn-pilih-award {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(102, 126, 234, 0.3);
    }
    
    .btn-pilih-award:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .award-details {
        margin: 15px 0;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #667eea;
    }
    
    .detail-row {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        font-size: 0.9rem;
        color: #555;
    }
    
    .detail-row:last-child {
        margin-bottom: 0;
    }
    
    .detail-icon {
        min-width: 25px;
        text-align: center;
        margin-right: 10px;
        color: #667eea;
    }
    
    .detail-text {
        flex: 1;
    }
    
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
    
    /* Simple Header Styling */
    .simple-header {
        padding: 40px 0 30px 0;
        margin-bottom: 20px;
    }
    
    .simple-header h1 {
        color: #333;
        font-size: 32px;
        font-weight: 300;
        margin: 0 0 10px 0;
        line-height: 1.2;
    }
    
    .breadcrumb-simple {
        color: #999;
        font-size: 14px;
        font-weight: 300;
    }
    
    .breadcrumb-simple .active {
        color: #666;
        font-weight: 400;
    }
    
    .breadcrumb-simple span {
        margin: 0 2px;
    }
    
    /* Modal Styling */
    .modal-dialog {
        max-width: 600px;
        margin: 1.75rem auto;
    }
    
    .modal-content {
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    
    .modal-header {
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        padding: 15px 25px;
    }
    
    .modal-title {
        color: #495057;
        font-weight: 500;
    }
    
    .modal-body {
        padding: 25px;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-group:last-child {
        margin-bottom: 0;
    }
    
    .form-group label {
        color: #495057;
        font-weight: 500;
        margin-bottom: 10px;
        display: block;
    }
    
    .form-control {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 10px 15px;
        font-size: 14px;
        width: 100%;
        box-sizing: border-box;
        min-height: 40px;
    }
    
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .alert {
        padding: 12px;
        margin: 15px 0;
        border-radius: 4px;
        font-size: 14px;
    }
    
    .alert-info {
        background-color: #d1ecf1;
        border-color: #bee5eb;
        color: #0c5460;
        border-left: 4px solid #1ab394;
    }
    
    .modal-footer {
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
        padding: 15px 25px;
    }
    
    @media (max-width: 768px) {
        .award-item-row {
            flex-direction: column;
            gap: 15px;
        }
        
        .award-number {
            margin-right: 0;
        }
        
        .award-main-info {
            flex-direction: column;
            gap: 10px;
        }
        
        .status-action-group {
            justify-content: flex-start;
            margin-top: 10px;
        }
        
        .status-pill {
            margin-right: 8px;
            font-size: 10px;
            padding: 5px 12px;
        }
        
        .simple-header h1 {
            font-size: 24px;
        }
        
        .award-item-row {
            flex-direction: column;
            padding: 20px 15px;
        }
        
        .award-number {
            margin-bottom: 15px;
            margin-right: 0;
            text-align: center;
        }
        
        .status-action-group {
            justify-content: center;
        }
        
        .award-details {
            margin: 10px 0;
            padding: 12px;
        }
        
        .list-header {
            padding: 15px 20px;
        }
        
        .list-header h5 {
            font-size: 1.2rem;
        }
    }
    
    /* Buttons */
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .btn-outline-primary {
        color: #4285F4;
        border-color: #4285F4;
    }
    
    .btn-outline-primary:hover {
        background-color: #4285F4;
        border-color: #4285F4;
        color: white;
    }
    
    .btn-outline-info {
        color: #17a2b8;
        border-color: #17a2b8;
    }
    
    .btn-outline-info:hover {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: white;
    }
    
    .badge-info {
        background-color: #17a2b8;
        border: 1px solid #17a2b8;
        color: white;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Award/Penghargaan Desa</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="?pg=Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Award Desa</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-4">
        <br>
        <div class="title-action">
            <a href="?pg=KaryaDesaAdminDesa" class="btn btn-primary">
                <i class="fa fa-list"></i> Riwayat Karya Desa
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
                        <input type="hidden" name="pg" value="AwardViewAdminDesa">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">Semua Status</option>
                                        <option value="Aktif" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                        <option value="Berlangsung" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Berlangsung') ? 'selected' : ''; ?>>Sedang Berlangsung</option>
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
                                        <button type="submit" class="btn btn-primary btn-block">
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
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Award Tersedia</h5>
                    <h1 class="no-margins text-primary"><?php echo $TotalAwardTersedia; ?></h1>
                    <small>Bisa didaftarkan</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Riwayat Karya</h5>
                    <h1 class="no-margins text-success"><?php echo $TotalKaryaTerdaftar; ?></h1>
                    <small>Sudah didaftarkan</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Sedang Berlangsung</h5>
                    <h1 class="no-margins text-warning"><?php echo $AwardBerlangsung; ?></h1>
                    <small>Masa penjurian</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Award Tahun Ini</h5>
                    <h1 class="no-margins text-info"><?php echo $AwardTahunIni; ?></h1>
                    <small>Tahun <?php echo date('Y'); ?></small>
                </div>
            </div>
        </div>
    </div>

    <!-- Award List -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox list-section">
                <div class="list-header">
                    <h5><i class="fa fa-trophy"></i> Awards </h5>
                </div>                
                <div class="award-list">
                    <?php 
                    if ($QueryAwardList && mysqli_num_rows($QueryAwardList) > 0) {
                        $no = 1;
                        while ($DataAward = mysqli_fetch_assoc($QueryAwardList)) {
                            $IdAward = $DataAward['IdAward'];
                            $JenisPenghargaan = $DataAward['JenisPenghargaan'];
                            $TahunPenghargaan = $DataAward['TahunPenghargaan'];
                            $StatusAktif = $DataAward['StatusAktif'];
                            $MasaAktifMulai = $DataAward['MasaAktifMulai'];
                            $MasaAktifSelesai = $DataAward['MasaAktifSelesai'];
                            $MasaPenjurianMulai = $DataAward['MasaPenjurianMulai'];
                            $MasaPenjurianSelesai = $DataAward['MasaPenjurianSelesai'];
                            
                            // Check status
                            $currentDate = date('Y-m-d');
                            $statusClass = '';
                            $statusText = '';
                            
                            if ($StatusAktif == 'Aktif') {
                                if (!empty($MasaPenjurianMulai) && !empty($MasaPenjurianSelesai)) {
                                    if ($currentDate >= $MasaPenjurianMulai && $currentDate <= $MasaPenjurianSelesai) {
                                        $statusClass = 'status-berlangsung';
                                        $statusText = 'MASA PENJURIAN';
                                    } elseif ($currentDate > $MasaPenjurianSelesai) {
                                        $statusClass = 'status-selesai';
                                        $statusText = 'SELESAI';
                                    } else {
                                        $statusClass = 'status-pendaftaran';
                                        $statusText = 'PENDAFTARAN';
                                    }
                                } else {
                                    $statusClass = 'status-aktif';
                                    $statusText = 'AKTIF';
                                }
                            } else {
                                $statusClass = 'status-tutup';
                                $statusText = 'NONAKTIF';
                            }
                            
                            // Check if desa sudah daftar
                            $SudahDaftar = false;
                            $checkTable = mysqli_query($db, "SHOW TABLES LIKE 'desa_award'");
                            if ($checkTable && mysqli_num_rows($checkTable) > 0) {
                                $QueryCekDaftar = mysqli_query($db, "SELECT COUNT(*) as total FROM desa_award WHERE IdDesaFK = '$IdDesa' AND IdAwardFK = '$IdAward'");
                                if ($QueryCekDaftar) {
                                    $CekDaftar = mysqli_fetch_assoc($QueryCekDaftar);
                                    $SudahDaftar = $CekDaftar['total'] > 0;
                                }
                            }
                    ?>
                    <div class="award-item-row">
                        <div class="award-content">
                            <div class="award-main-info">
                                <h5 class="award-title">
                                    <i class="fa fa-trophy text-warning"></i>
                                    <?php echo $JenisPenghargaan . ' ' . $TahunPenghargaan; ?>
                                </h5>
                                <div class="award-status">
                                    <div class="status-action-group">
                                        <span class="status-pill <?php echo $statusClass; ?>">
                                            <?php echo $statusText; ?>
                                        </span>
                                        <?php if ($SudahDaftar): ?>
                                            <span class="badge badge-info">
                                                <i class="fa fa-check"></i> Sudah Terdaftar
                                            </span>
                                            <a href="?pg=KaryaDesaAdminDesa&award=<?php echo $IdAward; ?>" class="btn btn-outline-primary btn-sm">
                                                <i class="fa fa-eye"></i> Lihat Karya
                                            </a>
                                        <?php else: ?>
                                            <?php if ($StatusAktif == 'Aktif' && $statusText != 'SELESAI'): ?>
                                                <button type="button" class="btn btn-pilih-award" onclick="openDaftarModal('<?php echo $IdAward; ?>', '<?php echo addslashes($JenisPenghargaan . ' ' . $TahunPenghargaan); ?>')">
                                                    <i class="fa fa-plus"></i> Daftar Karya
                                                </button>
                                            <?php else: ?>
                                                <span class="text-muted">Tidak dapat mendaftar</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <a href="?pg=DetailAwardAdminDesa&id=<?php echo $IdAward; ?>" class="btn btn-outline-info btn-sm">
                                            <i class="fa fa-info-circle"></i> Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="award-details">
                                <div class="detail-row">
                                    <span class="detail-icon"><i class="fa fa-building"></i></span>
                                    <span class="detail-text">Penyelenggara: Pemerintah Daerah</span>
                                </div>
                                <?php if ($MasaAktifMulai && $MasaAktifSelesai): ?>
                                <div class="detail-row">
                                    <span class="detail-icon"><i class="fa fa-calendar"></i></span>
                                    <span class="detail-text">
                                        Masa Aktif: <?php echo date('d M Y', strtotime($MasaAktifMulai)); ?> - 
                                        <?php echo date('d M Y', strtotime($MasaAktifSelesai)); ?>
                                    </span>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($MasaPenjurianMulai) && !empty($MasaPenjurianSelesai)): ?>
                                <div class="detail-row">
                                    <span class="detail-icon"><i class="fa fa-gavel"></i></span>
                                    <span class="detail-text">
                                        Masa Penjurian: <?php echo date('d M Y', strtotime($MasaPenjurianMulai)); ?> - 
                                        <?php echo date('d M Y', strtotime($MasaPenjurianSelesai)); ?>
                                    </span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php 
                        }
                    } else {
                    ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fa fa-trophy"></i>
                        </div>
                        <div class="empty-content">
                            <h4>Belum ada award tersedia</h4>
                            <p>Silakan tunggu pengumuman award berikutnya dari pemerintah daerah</p>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Daftar Karya -->
<div class="modal fade" id="modalDaftarKarya" tabindex="-1" role="dialog" aria-labelledby="modalDaftarKaryaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDaftarKaryaLabel">
                    <i class="fa fa-plus"></i> Daftar Karya ke Penghargaan
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formDaftarKarya" method="POST" action="../App/Control/ProcessDaftarKarya.php">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i>
                                <strong>Perhatian:</strong> Setiap desa hanya dapat mendaftar <strong>1 kategori</strong> per penghargaan. Pilih kategori dengan bijak!
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" id="IdAward" name="IdAward" value="">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Penghargaan</label>
                                <input type="text" id="NamaPenghargaan" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select id="IdKategoriAward" name="IdKategoriAward" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                </select>
                                <small class="form-text text-muted">
                                    <i class="fa fa-exclamation-triangle text-warning"></i>
                                    Setelah memilih kategori, Anda tidak dapat mengubah atau mendaftar kategori lain.
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Judul Karya <span class="text-danger">*</span></label>
                                <input type="text" id="JudulKarya" name="JudulKarya" class="form-control" maxlength="255" required>
                                <small class="form-text text-muted">Masukkan judul karya yang akan didaftarkan</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Link/URL Karya <span class="text-danger">*</span></label>
                                <textarea id="LinkKarya" name="LinkKarya" class="form-control" rows="3" required placeholder="https://"></textarea>
                                <small class="form-text text-muted">
                                    Masukkan URL/link karya (website, video YouTube, file Google Drive, dll.)
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Keterangan <small class="text-muted">(Opsional)</small></label>
                                <textarea id="Keterangan" name="Keterangan" class="form-control" rows="3" placeholder="Keterangan tambahan tentang karya..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Daftar Karya
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openDaftarModal(idAward, namaPenghargaan) {
    // Set nilai award
    document.getElementById('IdAward').value = idAward;
    document.getElementById('NamaPenghargaan').value = namaPenghargaan;
    
    // Reset form
    document.getElementById('formDaftarKarya').reset();
    document.getElementById('IdAward').value = idAward;
    document.getElementById('NamaPenghargaan').value = namaPenghargaan;
    
    // Load kategori
    loadKategori(idAward);
    
    // Show modal
    $('#modalDaftarKarya').modal('show');
}

function loadKategori(idAward) {
    const kategoriSelect = document.getElementById('IdKategoriAward');
    kategoriSelect.innerHTML = '<option value="">-- Loading... --</option>';
    
    const ajaxUrl = '../App/Control/FunctionDaftarKarya.php?ajax=getKategori&IdAward=' + idAward;
    console.log('Loading kategori from:', ajaxUrl);
    
    // AJAX request untuk get kategori (path diperbaiki)
    fetch(ajaxUrl)
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.status);
            }
            return response.text();
        })
        .then(data => {
            console.log('Received data:', data);
            kategoriSelect.innerHTML = data;
            if (data.includes('-- Pilih Kategori --')) {
                console.log('✅ Kategori loaded successfully');
            } else {
                console.log('⚠️ Unexpected response format');
            }
        })
        .catch(error => {
            console.error('Error loading kategori:', error);
            kategoriSelect.innerHTML = '<option value="">-- Error loading kategori --</option>';
        });
}

// Handle form submission
document.getElementById('formDaftarKarya').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Show loading
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Mendaftar...';
    submitBtn.disabled = true;
    
    fetch('../App/Control/ProcessDaftarKarya.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Submit response status:', response.status);
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Submit response data:', data);
        if (data.success) {
            alert('Karya berhasil didaftarkan!\n\nID Karya: ' + data.data.id);
            $('#modalDaftarKarya').modal('hide');
            location.reload(); // Refresh halaman
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error submitting form:', error);
        alert('Terjadi kesalahan saat mendaftar karya.\nSilakan cek console untuk detail error.');
    })
    .finally(() => {
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});
</script>

<!-- Script untuk mengatasi masalah pace loading yang tidak selesai -->
<script>
    // Force pace loading to complete after page is fully loaded
    window.addEventListener('load', function() {
        // Wait a bit for all scripts to finish
        setTimeout(function() {
            // Force pace to complete if it's still running
            if (typeof Pace !== 'undefined' && Pace.running) {
                Pace.stop();
            }
            // Add pace-done class to body if not already present
            if (!document.body.classList.contains('pace-done')) {
                document.body.classList.add('pace-done');
            }
            // Hide any remaining pace elements
            var paceElements = document.querySelectorAll('.pace');
            paceElements.forEach(function(el) {
                el.style.display = 'none';
            });
        }, 1000); // Wait 1 second after page load
    });

    // Fallback - force pace to complete after DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            if (typeof Pace !== 'undefined' && Pace.running) {
                Pace.stop();
            }
            document.body.classList.add('pace-done');
        }, 2000); // Wait 2 seconds after DOM ready
    });
    
    // Function untuk close notification bar
    function closeNotificationBar() {
        const notifBar = document.querySelector('.notification-bar');
        if (notifBar) {
            notifBar.style.animation = 'slideUp 0.3s ease-out forwards';
            setTimeout(() => {
                notifBar.style.display = 'none';
                // Store in localStorage untuk session ini
                localStorage.setItem('notifBarClosed', 'true');
            }, 300);
        }
    }
    
    // Check apakah notification bar sudah di-close sebelumnya
    document.addEventListener('DOMContentLoaded', function() {
        if (localStorage.getItem('notifBarClosed') === 'true') {
            const notifBar = document.querySelector('.notification-bar');
            if (notifBar) {
                notifBar.style.display = 'none';
            }
        }
    });
</script>