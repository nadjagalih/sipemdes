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
    
    /* Statistics Cards dengan border yang jelas */
    .ibox {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: 2px solid #dee2e6;
        overflow: hidden;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    
    .ibox:hover {
        border-color: #007bff;
        box-shadow: 0 4px 12px rgba(0,123,255,0.15);
        transform: translateY(-2px);
    }
    
    .ibox-content {
        padding: 20px;
        text-align: center;
    }
    
    .ibox-content h5 {
        margin: 0 0 10px 0;
        color: #495057;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .ibox-content h1 {
        margin: 10px 0;
        font-size: 36px;
        font-weight: bold;
    }
    
    .ibox-content small {
        color: #6c757d;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .list-section {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border: 2px solid #dee2e6;
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
    
    .award-details-container {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }
    
    .award-details-left {
        flex: 1;
    }
    
    .award-details-right {
        flex: 0 0 auto;
        min-width: 200px;
    }
    
    .achievement-box {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px 20px;
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        border: 2px solid #f1c40f;
        border-radius: 10px;
        margin-bottom: 10px;
        box-shadow: 0 4px 8px rgba(241, 196, 15, 0.3);
        min-height: 60px;
    }
    
    .achievement-icon {
        font-size: 32px;
        line-height: 1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .achievement-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
        flex: 1;
    }
    
    .achievement-info .badge {
        font-size: 14px;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        width: fit-content;
    }
    
    .achievement-category {
        font-size: 15px;
        color: #555;
        line-height: 1.3;
        font-weight: 600;
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
        background: white;
        /* Removed: cursor: pointer, transition, and hover transform */
    }
    
    /* Removed hover effects for award-item-row */
    
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
        cursor: pointer;
    }
    
    .btn-pilih-award:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    /* Tambahan untuk tombol detail dan daftar karya */
    .btn-outline-info,
    .btn-outline-primary {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-outline-info:hover,
    .btn-outline-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    
    .award-details {
        margin: 15px 0;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #667eea;
    }
    
    .award-details-container {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }
    
    .award-details-left {
        flex: 1;
    }
    
    .award-details-right {
        flex: 0 0 auto;
        min-width: 200px;
    }
    
    .achievement-box {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px 20px;
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        border: 2px solid #f1c40f;
        border-radius: 10px;
        margin-bottom: 10px;
        box-shadow: 0 4px 8px rgba(241, 196, 15, 0.3);
        min-height: 60px;
    }
    
    .achievement-icon {
        font-size: 32px;
        line-height: 1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .achievement-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
        flex: 1;
    }
    
    .achievement-info .badge {
        font-size: 14px;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        width: fit-content;
    }
    
    .achievement-category {
        font-size: 15px;
        color: #555;
        line-height: 1.3;
        font-weight: 600;
    }
    
    /* Recent achievement highlighting - konsisten dengan dashboard */
    .recent-achievement {
        border: 2px solid #28a745 !important;
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%) !important;
        animation: pulse-glow 2s infinite alternate;
    }
    
    @keyframes pulse-glow {
        from {
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }
        to {
            box-shadow: 0 6px 12px rgba(40, 167, 69, 0.5);
        }
    }
    
    .achievement-date {
        font-size: 10px;
        color: #999;
        margin-top: 2px;
        font-style: italic;
    }
    
    .badge-sm {
        font-size: 10px;
        padding: 2px 6px;
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
        
        .award-details-container {
            flex-direction: column;
            gap: 15px;
        }
        
        .award-details-right {
            min-width: auto;
        }
        
        .achievement-box {
            justify-content: center;
            padding: 12px 15px;
            min-height: 50px;
        }
        
        .achievement-icon {
            font-size: 28px;
        }
        
        .achievement-info .badge {
            font-size: 12px;
            padding: 4px 8px;
        }
        
        .achievement-category {
            font-size: 13px;
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
    
    /* Modal Success Styling */
    .modal-success {
        z-index: 1060;
    }
    
    .modal-success .modal-dialog {
        max-width: 400px;
        margin: 30vh auto;
    }
    
    .modal-success .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        text-align: center;
        padding: 0;
    }
    
    .modal-success .modal-body {
        padding: 40px 30px 30px 30px;
    }
    
    .success-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #4CAF50, #45a049);
        border-radius: 50%;
        margin: 0 auto 20px auto;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        color: white;
        box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
    }
    
    .success-title {
        font-size: 24px;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
    }
    
    .success-message {
        color: #666;
        font-size: 16px;
        line-height: 1.5;
        margin-bottom: 25px;
    }
    
    .btn-success-ok {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0, 123, 255, 0.3);
    }
    
    .btn-success-ok:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
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
                                    if ($currentDate > $MasaPenjurianSelesai) {
                                        $statusClass = 'status-selesai';
                                        $statusText = 'SELESAI';
                                    } else {
                                        $statusClass = 'status-aktif';
                                        $statusText = 'AKTIF';
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
                                <div class="award-details-container">
                                    <!-- Left Column: Penyelenggara and Masa Aktif -->
                                    <div class="award-details-left">
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

                                    <!-- Right Column: Achievement Display -->
                                    <div class="award-details-right">
                                        <?php
                                        // Debug current session and variables
                                        $currentDesaId = $_SESSION['IdDesa'];
                                        $currentDate = date('Y-m-d');
                                        
                                        // Use the same query logic as dashboard notification for consistency
                                        $hasRealData = false;
                                        
                                        // Check if desa_award table exists
                                        $checkTable = mysqli_query($db, "SHOW TABLES LIKE 'desa_award'");
                                        
                                        if ($checkTable && mysqli_num_rows($checkTable) > 0) {
                                            // Get achievement data using the SAME pattern as FunctionNotifikasiAward.php
                                            // This ensures consistency with dashboard notifications
                                            $QueryWinner = mysqli_query($db, "SELECT 
                                                da.IdPesertaAward,
                                                da.NamaKarya AS JudulKarya,
                                                da.Posisi,
                                                da.TanggalInput,
                                                da.IdKategoriAwardFK,
                                                mk.NamaKategori,
                                                ma.JenisPenghargaan,
                                                ma.TahunPenghargaan,
                                                ma.MasaPenjurianSelesai,
                                                ma.MasaAktifSelesai,
                                                ma.StatusAktif
                                                FROM desa_award da
                                                JOIN master_kategori_award mk ON da.IdKategoriAwardFK = mk.IdKategoriAward
                                                JOIN master_award_desa ma ON mk.IdAwardFK = ma.IdAward
                                                WHERE ma.IdAward = '$IdAward' AND da.IdDesaFK = '$currentDesaId'
                                                AND da.Posisi IS NOT NULL 
                                                AND da.Posisi > 0 
                                                AND da.Posisi <= 3
                                                -- Hanya tampilkan jika masa penjurian sudah selesai
                                                AND (ma.MasaPenjurianSelesai IS NULL OR ma.MasaPenjurianSelesai < '$currentDate')
                                                AND (
                                                    -- Jika award masih aktif: tampilkan dalam 30 hari
                                                    (ma.StatusAktif = 'Aktif' AND da.TanggalInput >= DATE_SUB('$currentDate', INTERVAL 30 DAY))
                                                    OR
                                                    -- Jika award sudah selesai: tampilkan dalam 90 hari (lebih lama)
                                                    (ma.StatusAktif = 'Non-Aktif' AND da.TanggalInput >= DATE_SUB('$currentDate', INTERVAL 90 DAY))
                                                    OR
                                                    -- Jika masa aktif sudah berakhir: tampilkan dalam 90 hari
                                                    (ma.MasaAktifSelesai IS NOT NULL AND ma.MasaAktifSelesai < '$currentDate' 
                                                     AND da.TanggalInput >= DATE_SUB('$currentDate', INTERVAL 90 DAY))
                                                )
                                                ORDER BY da.Posisi ASC, da.TanggalInput DESC");
                                            
                                            if ($QueryWinner) {
                                                if (mysqli_num_rows($QueryWinner) > 0) {
                                                    $hasRealData = true;
                                                    
                                                    // Track displayed achievements to prevent duplicates
                                                    $displayedAchievements = [];
                                                    
                                                    while ($Winner = mysqli_fetch_assoc($QueryWinner)) {
                                                    $posisi = $Winner['Posisi'];
                                                    $kategoriId = $Winner['IdKategoriAwardFK'];
                                                    $uniqueKey = $kategoriId . '_' . $posisi;
                                                    
                                                    // Skip if already displayed (prevent duplicates)
                                                    if (in_array($uniqueKey, $displayedAchievements)) {
                                                        continue;
                                                    }
                                                    $displayedAchievements[] = $uniqueKey;
                                                    
                                                    $kategori = $Winner['NamaKategori'] ? $Winner['NamaKategori'] : 'Kategori Award';
                                                    
                                                    // Check if this is a recent achievement (last 7 days)
                                                    $isRecent = false;
                                                    if (!empty($Winner['TanggalInput'])) {
                                                        $isRecent = (strtotime($Winner['TanggalInput']) > strtotime('-7 days'));
                                                    }
                                                    
                                                    // Set icon and label based on position
                                                    $posisiInt = intval($posisi);
                                                    switch($posisiInt) {
                                                        case 1:
                                                            $icon = '🥇';
                                                            $juaraText = 'Juara 1';
                                                            $badgeClass = 'badge-warning';
                                                            break;
                                                        case 2:
                                                            $icon = '🥈';
                                                            $juaraText = 'Juara 2';
                                                            $badgeClass = 'badge-secondary';
                                                            break;
                                                        case 3:
                                                            $icon = '🥉';
                                                            $juaraText = 'Juara 3';
                                                            $badgeClass = 'badge-info';
                                                            break;
                                                        default:
                                                            // Only positions 1-3 should appear based on our query
                                                            $icon = '🏆';
                                                            $juaraText = 'Juara ' . $posisi;
                                                            $badgeClass = 'badge-success';
                                                            break;
                                                    }
                                            ?>
                                            <div class="achievement-box <?php echo $isRecent ? 'recent-achievement' : ''; ?>">
                                                <div class="achievement-icon"><?php echo $icon; ?></div>
                                                <div class="achievement-info">
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge <?php echo $badgeClass; ?>"><?php echo $juaraText; ?></span>
                                                        <?php if ($isRecent): ?>
                                                        <!--<span class="badge badge-success badge-sm ml-2">BARU</span>-->
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="achievement-category">Kategori: <?php echo htmlspecialchars($kategori); ?></div>
                                                    <?php if (!empty($Winner['JudulKarya'])): ?>
                                                    <div class="achievement-title" style="font-size: 12px; color: #666; margin-top: 3px;">
                                                        <?php echo htmlspecialchars($Winner['JudulKarya']); ?>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php if (!empty($Winner['TanggalInput'])): ?>
                                                    <div class="achievement-date" style="font-size: 10px; color: #999; margin-top: 2px;">
                                                        <?php echo date('d/m/Y', strtotime($Winner['TanggalInput'])); ?>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php 
                                                    }
                                                } else {
                                                    // Jika tidak ada achievement data
                                                    $hasRealData = false;
                                                }
                                            } else {
                                                // Error pada query
                                                // Error log removed for production
                                                $hasRealData = false;
                                            }
                                        }
                                        
                                        // Jika tidak ada data achievement, tampilkan pesan kosong
                                        if (!$hasRealData):
                                        ?>
                                        <div class="text-muted text-center">
                                            <i class="fa fa-info-circle"></i>
                                            <small>Belum ada pencapaian untuk award ini</small>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
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

<!-- Modal Success Custom -->
<div class="modal fade modal-success" id="modalSuccess" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="success-icon">
                    <i class="fa fa-check"></i>
                </div>
                <h4 class="success-title">Berhasil!</h4>
                <p class="success-message" id="successMessage">
                    Data berhasil disimpan
                </p>
                <button type="button" class="btn btn-success-ok" onclick="closeSuccessModal()">
                    OK
                </button>
            </div>
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
            showSuccessModal('Karya berhasil didaftarkan!\n\nID Karya: ' + data.data.id);
            $('#modalDaftarKarya').modal('hide');
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

// Function untuk show success modal
function showSuccessModal(message) {
    document.getElementById('successMessage').innerHTML = message.replace(/\n/g, '<br>');
    $('#modalSuccess').modal({
        backdrop: 'static',
        keyboard: false
    });
}

// Function untuk close success modal
function closeSuccessModal() {
    $('#modalSuccess').modal('hide');
    setTimeout(() => {
        location.reload(); // Refresh halaman setelah modal tertutup
    }, 300);
}
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