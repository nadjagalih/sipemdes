<?php
if (empty($_GET['alert'])) {
    echo "";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'UploadSukses') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Upload Berhasil',
                    text: 'File pengajuan pensiun telah berhasil diupload dan sedang menunggu persetujuan dari Desa.',
                    type: 'success'
                });
            }, 1000);
          </script>";

} elseif (isset($_GET['alert']) && $_GET['alert'] == 'UploadGagalPegawai') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Upload Gagal',
                    text: 'Terjadi kesalahan simpan data pegawai.',
                    type: 'error'
                });
            }, 1000);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'UploadGagalDB') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Upload Gagal',
                    text: 'Terjadi kesalahan menyimpan ke database.',
                    type: 'error'
                });
            }, 1000);
          </script>";
}
?>
<div class="row wrapper border-bottom white-bg page-heading" style="margin-bottom: 25px;">
    <div class="col-lg-10">
        <h2>Data Profile</h2>
    </div>
</div>

<?php

$idPegawai = $_SESSION['IdPegawai'];

// Query dengan JOIN ke history_mutasi untuk mendapatkan TanggalMutasi dan IdJabatanFK
$q = mysqli_query($db, "SELECT 
    p.TanggalPensiun, 
    p.IdPegawaiFK, 
    p.IdFilePengajuanPensiunFK, 
    p.StatusPensiunDesa, 
    p.StatusPensiunKecamatan, 
    p.StatusPensiunKabupaten,
    h.TanggalMutasi,
    h.IdJabatanFK
FROM master_pegawai p
LEFT JOIN history_mutasi h ON p.IdPegawaiFK = h.IdPegawaiFK AND h.Setting = 1
WHERE p.IdPegawaiFK = '$idPegawai'");
$data = mysqli_fetch_assoc($q);

$FilePengajuan = $data['IdFilePengajuanPensiunFK'];
$StatusPensiunDesa = $data['StatusPensiunDesa'];
$StatusPensiunKecamatan = $data['StatusPensiunKecamatan'];
$StatusPensiunKabupaten = $data['StatusPensiunKabupaten'];
$IdJabatanFK = $data['IdJabatanFK'];
$TanggalMutasi = $data['TanggalMutasi'];

$flagTampilkanUpload = false;

if (is_null($FilePengajuan)) {
    $flagTampilkanUpload = true;
}
if ($StatusPensiunDesa === '0') {
    $flagTampilkanUpload = true;
}
if ($StatusPensiunKecamatan === '0') {
    $flagTampilkanUpload = true;
}
if ($StatusPensiunKabupaten === '0') {
    $flagTampilkanUpload = true;
}

// Hitung tanggal pensiun berdasarkan jabatan
// Jika Kepala Desa (IdJabatanFK = 1), pensiun = TanggalMutasi + 6 tahun
// Jika bukan Kepala Desa, gunakan TanggalPensiun dari master_pegawai
if ($IdJabatanFK == 1 && !is_null($TanggalMutasi)) {
    $tanggalPensiun = date('Y-m-d', strtotime('+6 year', strtotime($TanggalMutasi)));
} else {
    $tanggalPensiun = $data['TanggalPensiun'];
}

$tanggalSekarang = date('Y-m-d');

// Hitung tanggal 3 bulan sebelum pensiun
$tanggal3BulanSebelumPensiun = date('Y-m-d', strtotime('-3 months', strtotime($tanggalPensiun)));

// Tampilkan box ajukan pensiun jika sudah kurang dari 3 bulan sebelum pensiun atau sudah lewat tanggal pensiun
if ($tanggalSekarang >= $tanggal3BulanSebelumPensiun) {
    // Tentukan status tracking
    $step1 = false; // Upload Surat
    $step2 = false; // Disetujui Desa
    $step3 = false; // Disetujui Kecamatan
    $step4 = false; // Disetujui Kabupaten
    $step5 = false; // Telah Disetujui (Semua)
    
    $rejected = false;
    $rejectedBy = '';
    $rejectedAt = 0; // 1=Desa, 2=Kecamatan, 3=Kabupaten
    
    // Logika pengecekan status ditolak berdasarkan IdFilePengajuanPensiunFK
    // Jika IdFilePengajuanPensiunFK NULL tapi ada status yang di-set, artinya ditolak
    if (is_null($FilePengajuan)) {
        // Cek apakah pernah ditolak (status ada nilai tapi file NULL)
        if ($StatusPensiunDesa === '0' || $StatusPensiunDesa === 0) {
            $rejected = true;
            $rejectedBy = 'Desa';
            $rejectedAt = 1;
        } elseif ($StatusPensiunKecamatan === '0' || $StatusPensiunKecamatan === 0) {
            $rejected = true;
            $rejectedBy = 'Kecamatan';
            $rejectedAt = 2;
        } elseif ($StatusPensiunKabupaten === '0' || $StatusPensiunKabupaten === 0) {
            $rejected = true;
            $rejectedBy = 'Kabupaten';
            $rejectedAt = 3;
        }
    } else {
        // File ada, berarti pernah upload
        $step1 = true;
        
        // Cek status Desa
        if ($StatusPensiunDesa === '1' || $StatusPensiunDesa === 1) {
            $step2 = true;
        }
        // NULL = masih menunggu
        
        // Cek status Kecamatan (hanya jika Desa approve)
        if ($step2) {
            if ($StatusPensiunKecamatan === '1' || $StatusPensiunKecamatan === 1) {
                $step3 = true;
            }
        }
        
        // Cek status Kabupaten (hanya jika Kecamatan approve)
        if ($step3) {
            if ($StatusPensiunKabupaten === '1' || $StatusPensiunKabupaten === 1) {
                $step4 = true;
                $step5 = true; // Jika kabupaten setuju, berarti semua setuju
            }
        }
    }
    ?>
    
    <style>
        .tracking-container {
            padding: 25px 15px;
            background: #fff;
            border-radius: 8px;
        }
        
        .tracking-header {
            text-align: left;
            margin-bottom: 20px;
        }
        
        .tracking-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 3px;
        }
        
        .tracking-subtitle {
            font-size: 12px;
            color: #666;
        }
        
        .tracking-progress {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 25px 0 15px 0;
        }
        
        .progress-line {
            position: absolute;
            top: 15px;
            left: 5%;
            right: 5%;
            height: 3px;
            background: #e0e0e0;
            z-index: 1;
        }
        
        .progress-line-fill {
            height: 100%;
            transition: width 0.5s ease;
        }
        
        .progress-line-fill.approved {
            background: #7c3aed;
        }
        
        .progress-line-fill.rejected {
            background: #dc3545;
        }
        
        .progress-step {
            position: relative;
            z-index: 2;
            text-align: center;
            flex: 1;
        }
        
        .step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e0e0e0;
            border: 2px solid #e0e0e0;
            margin: 0 auto 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .step-circle.active {
            background: #7c3aed;
            border-color: #7c3aed;
        }
        
        .step-circle.rejected {
            background: #dc3545;
            border-color: #dc3545;
        }
        
        .step-circle i {
            font-size: 14px;
            color: #fff;
        }
        
        .step-icon {
            width: 20px;
            height: 20px;
        }
        
        .step-label {
            font-size: 11px;
            font-weight: 600;
            color: #333;
            margin-top: 5px;
        }
        
        .step-sublabel {
            font-size: 10px;
            color: #666;
            margin-top: 2px;
            min-height: 15px;
        }
        
        .alert-rejected {
            background: #fee;
            border: 1px solid #fcc;
            padding: 12px;
            border-radius: 6px;
            margin-top: 15px;
            color: #c33;
            text-align: center;
            font-size: 13px;
        }
        
        .status-description {
            background: #f8f9fa;
            border-left: 4px solid #7c3aed;
            padding: 10px 15px;
            margin-top: 15px;
            border-radius: 4px;
            font-size: 12px;
            color: #555;
        }
        
        .status-description.rejected-desc {
            border-left-color: #dc3545;
            background: #fff5f5;
        }
        
        .status-description strong {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
    </style>
    
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content tracking-container">
                <div class="tracking-header">
                    <div class="tracking-title">STATUS PENGAJUAN PENSIUN</div>
                    <div class="tracking-subtitle">
                        <?php 
                        if ($rejected) {
                            echo "Pengajuan ditolak oleh " . $rejectedBy;
                        } elseif ($step5) {
                            echo "Pengajuan Anda telah disetujui";
                        } elseif ($step1) {
                            echo "Pengajuan Anda sedang diproses";
                        } else {
                            echo "Silakan upload surat pengajuan pensiun";
                        }
                        ?>
                    </div>
                </div>
                
                <div class="tracking-progress">
                    <div class="progress-line">
                        <div class="progress-line-fill <?php echo $rejected ? 'rejected' : 'approved'; ?>" style="width: <?php 
                            if ($rejected) {
                                // Progress merah sampai tahap ditolak
                                if ($rejectedAt == 1) echo '12.5%'; // Ditolak Desa
                                elseif ($rejectedAt == 2) echo '37.5%'; // Ditolak Kecamatan
                                elseif ($rejectedAt == 3) echo '62.5%'; // Ditolak Kabupaten
                            }
                            elseif ($step5) echo '100%'; // Semua disetujui - biru
                            elseif ($step4) echo '75%'; // Sampai Kabupaten disetujui - biru
                            elseif ($step3) echo '50%'; // Sampai Kecamatan disetujui - biru
                            elseif ($step2) echo '25%'; // Sampai Desa disetujui - biru
                            elseif ($step1) echo '12.5%'; // Baru upload - biru
                            else echo '0%'; // Belum ada - tidak ada warna
                        ?>;"></div>
                    </div>
                    
                    <!-- Step 1: Upload Surat -->
                    <div class="progress-step">
                        <div class="step-circle <?php echo ($step1 && !$rejected) ? 'active' : ($rejected ? '' : ''); ?>">
                            <i class="fa fa-upload"></i>
                        </div>
                        <div class="step-label">Upload Surat</div>
                        <div class="step-label">Pengajuan</div>
                    </div>
                    
                    <!-- Step 2: Disetujui Desa -->
                    <div class="progress-step">
                        <div class="step-circle <?php 
                            if ($rejected && $rejectedAt == 1) {
                                echo 'rejected';
                            } elseif ($step2) {
                                echo 'active';
                            }
                        ?>">
                            <i class="fa <?php echo ($rejected && $rejectedAt == 1) ? 'fa-times' : 'fa-check'; ?>"></i>
                        </div>
                        <div class="step-label">Desa</div>
                        <div class="step-sublabel">
                            <?php if ($rejected && $rejectedAt == 1) { ?>
                                <span style="color: #dc3545; font-weight: 600;">Ditolak</span>
                            <?php } elseif ($step2) { ?>
                                <span style="color: #7c3aed; font-weight: 600;">Disetujui</span>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <!-- Step 3: Disetujui Kecamatan -->
                    <div class="progress-step">
                        <div class="step-circle <?php 
                            if ($rejected && $rejectedAt == 2) {
                                echo 'rejected';
                            } elseif ($step3) {
                                echo 'active';
                            }
                        ?>">
                            <i class="fa <?php echo ($rejected && $rejectedAt == 2) ? 'fa-times' : 'fa-check'; ?>"></i>
                        </div>
                        <div class="step-label">Kecamatan</div>
                        <div class="step-sublabel">
                            <?php if ($rejected && $rejectedAt == 2) { ?>
                                <span style="color: #dc3545; font-weight: 600;">Ditolak</span>
                            <?php } elseif ($step3) { ?>
                                <span style="color: #7c3aed; font-weight: 600;">Disetujui</span>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <!-- Step 4: Disetujui Kabupaten -->
                    <div class="progress-step">
                        <div class="step-circle <?php 
                            if ($rejected && $rejectedAt == 3) {
                                echo 'rejected';
                            } elseif ($step4) {
                                echo 'active';
                            }
                        ?>">
                            <i class="fa <?php echo ($rejected && $rejectedAt == 3) ? 'fa-times' : 'fa-check'; ?>"></i>
                        </div>
                        <div class="step-label">Kabupaten</div>
                        <div class="step-sublabel">
                            <?php if ($rejected && $rejectedAt == 3) { ?>
                                <span style="color: #dc3545; font-weight: 600;">Ditolak</span>
                            <?php } elseif ($step4) { ?>
                                <span style="color: #7c3aed; font-weight: 600;">Disetujui</span>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <!-- Step 5: Telah Disetujui -->
                    <div class="progress-step">
                        <div class="step-circle <?php echo ($step5 && !$rejected) ? 'active' : ''; ?>">
                            <i class="fa fa-home"></i>
                        </div>
                        <div class="step-label">Telah</div>
                        <div class="step-label">Disetujui</div>
                    </div>
                </div>
                
                <?php if ($rejected) { ?>
                    <div class="status-description rejected-desc">
                        <strong><i class="fa fa-exclamation-circle"></i> Pengajuan Ditolak</strong>
                        Pengajuan pensiun Anda telah ditolak.<strong><?php echo $rejectedBy; ?></strong>
                        Silakan periksa kembali dokumen Anda dan upload ulang surat pengajuan pensiun.
                    </div>
                <?php } elseif ($step5) { ?>
                    <div class="status-description">
                        <strong><i class="fa fa-check-circle"></i> Pengajuan Disetujui</strong>
                        Selamat! Pengajuan pensiun Anda telah disetujui oleh Desa, Kecamatan, dan Kabupaten. 
                        Proses selanjutnya akan ditindaklanjuti oleh admin.
                    </div>
                <?php } elseif ($step4) { ?>
                    <div class="status-description">
                        <strong><i class="fa fa-clock-o"></i> Menunggu Persetujuan Kabupaten</strong>
                        Pengajuan Anda telah disetujui oleh Desa dan Kecamatan. Saat ini sedang menunggu persetujuan dari tingkat Kabupaten.
                    </div>
                <?php } elseif ($step3) { ?>
                    <div class="status-description">
                        <strong><i class="fa fa-clock-o"></i> Menunggu Persetujuan Kecamatan</strong>
                        Pengajuan Anda telah disetujui oleh Desa. Saat ini sedang menunggu persetujuan dari tingkat Kecamatan.
                    </div>
                <?php } elseif ($step2) { ?>
                    <div class="status-description">
                        <strong><i class="fa fa-clock-o"></i> Menunggu Persetujuan Kecamatan</strong>
                        Pengajuan Anda telah disetujui oleh Desa. Saat ini sedang menunggu persetujuan dari tingkat Kecamatan.
                    </div>
                <?php } elseif ($step1) { ?>
                    <div class="status-description">
                        <strong><i class="fa fa-clock-o"></i> Menunggu Persetujuan Desa</strong>
                        Surat pengajuan pensiun Anda telah diupload. Saat ini sedang menunggu persetujuan dari tingkat Desa.
                    </div>
                <?php } else { ?>
                    <div class="status-description">
                        <strong><i class="fa fa-info-circle"></i> Belum Ada Pengajuan</strong>
                        Anda belum mengupload surat pengajuan pensiun. Silakan klik tombol "Upload File" di bawah untuk memulai proses pengajuan.
                    </div>
                <?php } ?>
            </div>

            <div class="ibox-title">
                <h5>Ajukan Pensiun</h5>
            </div>

            <div class="ibox-content">
                <div class="text-left">
                    <?php
                    // Tombol Lihat File jika sudah upload
                    if (!is_null($FilePengajuan) && $FilePengajuan != '') {
                        ?>
                        <a href="../Module/File/ViewFilePengajuan.php?id=<?php echo $FilePengajuan; ?>" target="_blank">
                            <button type="button" class="btn btn-primary" style="width:150px; text-align:center">
                                <i class="fa fa-file-pdf-o"></i> Lihat File
                            </button>
                        </a>
                        <?php
                    }
                    
                    // Tombol Upload jika belum upload atau ditolak
                    if ($flagTampilkanUpload) {
                        ?>
                        <a href="?pg=FileUploadPengajuan">
                            <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                                Upload File
                            </button>
                        </a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<form action="UserDesa/Dashboard/PdfProfile" method="GET" target="_BLANK" enctype="multipart/form-data">
    <!-- <div class="wrapper wrapper-content animated fadeInRight"> -->
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Profile</h5>&nbsp;
                <?php include "../App/Control/FunctionProfilePegawaiUser.php" ?>
                <input type="hidden" name="Kode" id="Kode" value="<?php echo $IdPegawaiFK; ?>" />
                <button type="submit" name="Proses" value="Proses" class="btn btn-success">Cetak PDF</button>

                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#" class="dropdown-item">Config option 1</a>
                        </li>
                        <li><a href="#" class="dropdown-item">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="wrapper wrapper-content animated fadeInUp">
                            <div class="ibox">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="m-b-md">
                                            <h2><strong><?php echo $Nama; ?></strong></h2>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-lg-4" id="cluster_info">
                                        <dl class="row mb-0">
                                            <div class="col-sm-4 text-sm-right">
                                                <?php
                                                if (empty($Foto)) {
                                                    ?>
                                                    <dt>
                                                        <img style="width:200px; height:auto" alt="image"
                                                            class="message-avatar"
                                                            src="../Vendor/Media/Pegawai/no-image.jpg">
                                                    </dt>
                                                <?php } else { ?>
                                                    <dt>
                                                        <img style="width:200px; height:auto" alt="image"
                                                            class="message-avatar"
                                                            src="../Vendor/Media/Pegawai/<?php echo $Foto; ?>">
                                                    </dt>
                                                <?php } ?>
                                            </div>
                                        </dl>

                                    </div>

                                    <div class="col-lg-8">
                                        <dl class="row mb-0">
                                            <div class="col-sm-4 text-sm-right">
                                                <dt>NIK : </dt>
                                            </div>
                                            <div class="col-sm-8 text-sm-left">
                                                <dd class="mb-1"><span
                                                        class="label label-primary"><?php echo $NIK; ?></span></dd>
                                            </div>
                                        </dl>
                                        <dl class="row mb-0">
                                            <div class="col-sm-4 text-sm-right">
                                                <dt>Tempat Lahir :</dt>
                                            </div>
                                            <div class="col-sm-8 text-sm-left">
                                                <dd class="mb-1"><?php echo $TempatLahir; ?></dd>
                                            </div>
                                        </dl>
                                        <dl class="row mb-0">
                                            <div class="col-sm-4 text-sm-right">
                                                <dt>Tanggal Lahir :</dt>
                                            </div>
                                            <div class="col-sm-8 text-sm-left">
                                                <dd class="mb-1"> <?php echo $TanggalLahir; ?></dd>
                                            </div>
                                        </dl>
                                        <dl class="row mb-0">
                                            <div class="col-sm-4 text-sm-right">
                                                <dt>Jenis Kelamin :</dt>
                                            </div>
                                            <div class="col-sm-8 text-sm-left">
                                                <dd class="mb-1"> <?php echo $DetailNamaJenKel; ?> </dd>
                                            </div>
                                        </dl>
                                        <dl class="row mb-0">
                                            <div class="col-sm-4 text-sm-right">
                                                <dt>Agama :</dt>
                                            </div>
                                            <div class="col-sm-8 text-sm-left">
                                                <dd class="mb-1"> <?php echo $DetailNamaAgama; ?> </dd>
                                            </div>
                                        </dl>
                                        <dl class="row mb-0">
                                            <div class="col-sm-4 text-sm-right">
                                                <dt>Golongan Darah :</dt>
                                            </div>
                                            <div class="col-sm-8 text-sm-left">
                                                <dd class="mb-1"> <?php echo $DetailNamaGolDarah; ?> </dd>
                                            </div>
                                        </dl>
                                        <dl class="row mb-0">
                                            <div class="col-sm-4 text-sm-right">
                                                <dt>Alamat :</dt>
                                            </div>
                                            <div class="col-sm-8 text-sm-left">
                                                <dd class="mb-1">
                                                    <?php echo $Alamat; ?>
                                                    RT <?php echo $RT; ?> /
                                                    RW <?php echo $RW; ?>
                                                    <?php echo $DetailNamaDesa; ?>
                                                    <?php echo $DetailNamaKecamatan; ?>
                                                </dd>
                                            </div>
                                        </dl>
                                        <dl class="row mb-0">
                                            <div class="col-sm-4 text-sm-right">
                                                <dt>Status Pernikahan :</dt>
                                            </div>
                                            <div class="col-sm-8 text-sm-left">
                                                <dd class="mb-1"> <?php echo $DetailNamaSTNikah; ?> </dd>
                                            </div>
                                        </dl>
                                        <dl class="row mb-0">
                                            <div class="col-sm-4 text-sm-right">
                                                <dt>No Telp :</dt>
                                            </div>
                                            <div class="col-sm-8 text-sm-left">
                                                <dd class="mb-1"> <?php echo $Telp; ?> </dd>
                                            </div>
                                        </dl>
                                        <dl class="row mb-0">
                                            <div class="col-sm-4 text-sm-right">
                                                <dt>Status Kepegawaian :</dt>
                                            </div>
                                            <div class="col-sm-8 text-sm-left">
                                                <dd class="mb-1"> <?php echo $DetailNamaSTPegawai; ?> </dd>
                                            </div>
                                        </dl>
                                        <dl class="row mb-0">
                                            <div class="col-sm-4 text-sm-right">
                                                <dt>Unit Kerja :</dt>
                                            </div>
                                            <div class="col-sm-8 text-sm-left">
                                                <dd class="mb-1">
                                                    Kelurahan/Desa <?php echo $DetailNamaUnitKerja; ?> - Kecamatan
                                                    <?php echo $DetailNamaKecamatanUnitKerja; ?>
                                                </dd>
                                            </div>
                                        </dl>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <dl class="row mb-0">
                                            <div class="col-sm-2 text-sm-right">
                                                <dt>Completed:</dt>
                                            </div>
                                            <div class="col-sm-10 text-sm-left">
                                                <dd>
                                                    <div class="progress m-b-1">
                                                        <div style="width: 100%;"
                                                            class="progress-bar progress-bar-striped progress-bar-animated">
                                                        </div>
                                                    </div>
                                                    <small>Profile completed in <strong>100%</strong></small>
                                                </dd>
                                            </div>
                                        </dl>
                                    </div>
                                </div>

                                <div class="row m-t-sm">
                                    <div class="col-lg-12">
                                        <div class="panel blank-panel">
                                            <div class="panel-heading">
                                                <div class="panel-options">
                                                    <ul class="nav nav-tabs">
                                                        <li><a class="nav-link active" href="#tab-1"
                                                                data-toggle="tab">Pendidikan</a></li>
                                                        <li><a class="nav-link" href="#tab-2" data-toggle="tab">Suami
                                                                Istri</a></li>
                                                        <li><a class="nav-link" href="#tab-3" data-toggle="tab">Anak</a>
                                                        </li>
                                                        <li><a class="nav-link" href="#tab-4" data-toggle="tab">Orang
                                                                Tua</a></li>
                                                        <li><a class="nav-link" href="#tab-5"
                                                                data-toggle="tab">Mutasi</a></li>
                                                        <li><a class="nav-link" href="#tab-6"
                                                                data-toggle="tab">Siltap</a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="panel-body">

                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab-1">
                                                        <div class="feed-activity-list">
                                                            <?php include "../App/Control/FunctionProfilePendidikanUser.php" ?>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane" id="tab-2">
                                                        <?php include "../App/Control/FunctionProfileSuamiIstriUser.php" ?>
                                                    </div>

                                                    <div class="tab-pane" id="tab-3">
                                                        <?php include "../App/Control/FunctionProfileAnakUser.php" ?>
                                                    </div>

                                                    <div class="tab-pane" id="tab-4">
                                                        <?php include "../App/Control/FunctionProfileOrtuUser.php" ?>
                                                    </div>

                                                    <div class="tab-pane" id="tab-5">
                                                        <?php include "../App/Control/FunctionProfileMutasiUser.php" ?>
                                                    </div>

                                                    <div class="tab-pane" id="tab-6">
                                                        <div class="table-responsive">
                                                            <table
                                                                class="table table-striped table-bordered table-hover dataTables-kecamatan">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Penghasilan Tetap</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            Rp. <?php echo $Siltap; ?>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- </div> -->
        <?php
        if (isset($_POST['Proses'])) {
            $Kode = sql_injeksi($_POST['Kode']);
        } ?>
</form>