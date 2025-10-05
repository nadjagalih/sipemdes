<?php
// Mock data list award yang tersedia
$listAward = [
    [
        'IdAward' => 1,
        'NamaAward' => 'Soetran Award',
        'Penyelenggara' => 'Pemerintah Daerah Kabupaten Trenggalek',
        'TanggalMulai' => '2025-01-01',
        'TanggalSelesai' => '2025-12-31',
        'StatusAward' => 'Berlangsung',
        'Deskripsi' => 'Derkripsi Award.'
    ],
    [
        'IdAward' => 2,
        'NamaAward' => 'Transoe',
        'Penyelenggara' => 'Pemerintah Daerah Kabupaten Trenggalek',
        'TanggalMulai' => '2025-03-01',
        'TanggalSelesai' => '2025-11-30',
        'StatusAward' => 'Berlangsung',
        'Deskripsi' => ' Deskripsi Award.'
    ]
];


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Award Desa - SIPEMDES</title>
    
    <!-- CSS -->
    <link href="../../../Assets/argon/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../Assets/argon/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../../../Assets/argon/css/animate.css" rel="stylesheet">
    <link href="../../../Assets/argon/css/style.css" rel="stylesheet">
    
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
        
        .form-control select,
        select.form-control {
            padding: 10px 35px 10px 15px;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
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
        }
        
        .badge {
            padding: 4px 8px;
            font-size: 11px;
            font-weight: 500;
            border-radius: 4px;
        }
        
        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .text-danger {
            color: #dc3545 !important;
        }
        
        .text-muted {
            color: #6c757d !important;
        }
        
        .modal-footer {
            background: #f8f9fa;
            border-top: 1px solid #dee2e6;
            padding: 15px 25px;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }
        
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }
        
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
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
        }
        
        /* Simple Header Styling - seperti screenshot */
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
    </style>
</head>

<body>
    <!-- Simple Page Header -->
    <div class="simple-header">
        <h1>Award/Penghargaan</h1>
        <div class="breadcrumb-simple">
            <span>Dashboard</span> / <span>Award</span>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                
                <!-- List Section -->
                <div class="list-section">
                    <div class="list-header">
                        <h5><i class="fa fa-list"></i> Daftar Award</h5>
                    </div>
                    
                    <div class="award-list">
                        <?php $no = 1; ?>
                        <?php foreach ($listAward as $award): ?>
                        <div class="award-item-row" onclick="selectAward(<?php echo $award['IdAward']; ?>)">
                            <div class="award-number">
                                <span class="number"><?php echo $no++; ?></span>
                            </div>
                            <div class="award-content">
                                <div class="award-main-info">
                                    <h5 class="award-title">
                                        <i class="fa fa-trophy text-warning"></i>
                                        <?php echo $award['NamaAward']; ?>
                                    </h5>
                                    <div class="award-status">
                                        <div class="status-action-group">
                                            <span class="status-pill status-<?php echo strtolower($award['StatusAward']); ?>">
                                                <?php echo strtoupper($award['StatusAward']); ?>
                                            </span>
                                            <button class="btn btn-pilih-award" onclick="event.stopPropagation(); showSubmitModal(<?php echo $award['IdAward']; ?>)">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="award-details">
                                    <div class="detail-row">
                                        <span class="detail-icon"><i class="fa fa-building"></i></span>
                                        <span class="detail-text"><?php echo $award['Penyelenggara']; ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-icon"><i class="fa fa-calendar"></i></span>
                                        <span class="detail-text">
                                            Dibuat: <?php echo date('d M Y', strtotime($award['TanggalMulai'])); ?>
                                        </span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-icon"><i class="fa fa-clock-o"></i></span>
                                        <span class="detail-text">
                                            Masa Aktif: <?php echo date('d M Y', strtotime($award['TanggalMulai'])); ?> - 
                                            <?php echo date('d M Y', strtotime($award['TanggalSelesai'])); ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="award-description">
                                    <?php echo $award['Deskripsi']; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Karya (Demo) -->
    <div class="modal fade" id="detailKaryaModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <h4 class="modal-title"><i class="fa fa-eye"></i> Detail Karya Penghargaan (Demo)</h4>
                    <button type="button" class="close" data-dismiss="modal" style="color: white;">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="demo-notice">
                        <p><i class="fa fa-info-circle"></i> Ini adalah tampilan demo untuk manajemen karya award.</p>
                    </div>
                    
                    <div class="alert alert-success">
                        <h5><i class="fa fa-trophy"></i> <?php echo $awardAktif['NamaAward']; ?></h5>
                        <strong>Kategori:</strong> <?php echo $dataPendaftaran['NamaKategori']; ?>
                    </div>
                    
                    <hr>
                    
                    <!-- Form Input Karya Baru -->
                    <h5><i class="fa fa-plus-circle"></i> Tambah Karya/Prestasi Baru</h5>
                    <div class="form-group">
                        <label><strong>Judul Karya/Prestasi:</strong></label>
                        <input type="text" class="form-control" placeholder="Contoh: Pembangunan Jalan Desa Beraspal 3 KM">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Tahun Prestasi:</strong></label>
                                <select class="form-control">
                                    <option value="">-- Pilih Tahun --</option>
                                    <option value="2025">2025</option>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Jenis Link Dokumentasi:</strong></label>
                                <select class="form-control">
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="gdrive">Google Drive (Folder/File)</option>
                                    <option value="youtube">YouTube (Video)</option>
                                    <option value="photos">Google Photos (Album)</option>
                                    <option value="website">Website/Blog</option>
                                    <option value="drive">OneDrive/Dropbox</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label><strong>Link Dokumentasi Karya:</strong></label>
                        <input type="url" class="form-control" placeholder="https://drive.google.com/drive/folders/...">
                        <small class="text-muted">
                            <i class="fa fa-info-circle"></i> 
                            Pastikan link dapat diakses publik atau berikan akses ke panitia
                        </small>
                    </div>
                    
                    <div class="form-group">
                        <label><strong>Deskripsi Detail Karya:</strong></label>
                        <textarea class="form-control" rows="4" placeholder="Jelaskan detail karya/prestasi, dampak yang dihasilkan, dan manfaat bagi masyarakat desa..."></textarea>
                    </div>

                    <!-- List Karya yang Sudah Ada -->
                    <hr>
                    <h5><i class="fa fa-list"></i> Karya yang Sudah Disubmit</h5>
                    <?php foreach ($mockKarya as $index => $karya): ?>
                    <div class="list-group-item" style="border: 1px solid #dee2e6; border-radius: 8px; margin-bottom: 10px; padding: 15px;">
                        <div class="row">
                            <div class="col-md-8">
                                <h6 class="mb-1">
                                    <strong><?php echo $karya['JudulKarya']; ?></strong>
                                    <span class="badge badge-<?php echo $karya['StatusKarya'] == 'Approved' ? 'success' : 'info'; ?> ml-2">
                                        <?php echo $karya['StatusKarya']; ?>
                                    </span>
                                </h6>
                                <p class="text-muted mb-2"><?php echo $karya['DeskripsiKarya']; ?></p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small><strong>Tahun:</strong> <?php echo $karya['TahunPrestasi']; ?></small>
                                    </div>
                                    <div class="col-md-6">
                                        <small><strong>Jenis:</strong> <?php echo $karya['JenisLink']; ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="<?php echo $karya['LinkKarya']; ?>" target="_blank" class="btn btn-primary btn-sm mb-1">
                                    <i class="fa fa-external-link"></i> Lihat Karya
                                </a>
                                <br>
                                <button class="btn btn-warning btn-sm" onclick="editKarya(<?php echo $index; ?>)">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-award" onclick="alert('Demo mode: Simpan karya berhasil!')">
                        <i class="fa fa-save"></i> Simpan Karya (Demo)
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Submit Award -->
    <div class="modal fade" id="submitAwardModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-list"></i> Pilih Kategori
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="submitAwardForm">
                        <div class="form-group">
                            <label for="namaKategori">Nama Kategori <span class="text-danger">*</span></label>
                            <select class="form-control" id="namaKategori" name="namaKategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Desa Wisata Terbaik">Desa Wisata Terbaik</option>
                                <option value="Desa Digital Terdepan">Desa Digital Terdepan</option>
                                <option value="Desa Mandiri Pangan">Desa Mandiri Pangan</option>
                                <option value="Desa Ramah Lingkungan">Desa Ramah Lingkungan</option>
                                <option value="Desa Inovatif">Desa Inovatif</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="judulKarya">Judul Karya <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="judulKarya" name="judulKarya" 
                                   placeholder="Contoh: Program Digitalisasi Pelayanan Desa" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="linkKarya">Link Karya <span class="text-danger">*</span></label>
                            <input type="url" class="form-control" id="linkKarya" name="linkKarya" 
                                   placeholder="https://contoh.com/karya" required>
                            <small class="text-muted">Masukkan link ke karya/dokumentasi yang akan disubmit</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" onclick="submitAward()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="../../../Assets/argon/js/jquery-3.1.1.min.js"></script>
    <script src="../../../Assets/argon/js/bootstrap.min.js"></script>
    <script src="../../../Assets/argon/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../../../Assets/argon/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="../../../Assets/argon/js/inspinia.js"></script>

    <script>
        var currentAwardId = null;
        
        function showSubmitModal(idAward) {
            currentAwardId = idAward;
            $('#submitAwardModal').modal('show');
        }
        
        function submitAward() {
            var namaKategori = $('#namaKategori').val();
            var judulKarya = $('#judulKarya').val().trim();
            var linkKarya = $('#linkKarya').val().trim();
            
            // Validasi
            if (!namaKategori) {
                alert('Silakan pilih kategori terlebih dahulu!');
                $('#namaKategori').focus();
                return;
            }
            
            if (!judulKarya) {
                alert('Judul karya harus diisi!');
                $('#judulKarya').focus();
                return;
            }
            
            if (!linkKarya) {
                alert('Link karya harus diisi!');
                $('#linkKarya').focus();
                return;
            }
            
            // Validasi URL
            try {
                new URL(linkKarya);
            } catch (e) {
                alert('Format link tidak valid! Pastikan dimulai dengan http:// atau https://');
                $('#linkKarya').focus();
                return;
            }
            
            // Demo submission
            alert('Demo Mode: Berhasil submit!\n\n' +
                  'Award ID: ' + currentAwardId + '\n' +
                  'Kategori: ' + namaKategori + '\n' +
                  'Judul Karya: ' + judulKarya + '\n' +
                  'Link Karya: ' + linkKarya + '\n\n' +
                  'Pada implementasi nyata, data akan disimpan ke database.');
            
            // Reset form dan tutup modal
            $('#submitAwardForm')[0].reset();
            $('#submitAwardModal').modal('hide');
        }
        
        // Reset form ketika modal ditutup
        $('#submitAwardModal').on('hidden.bs.modal', function () {
            $('#submitAwardForm')[0].reset();
            currentAwardId = null;
        });
    </script>
</body>
</html>