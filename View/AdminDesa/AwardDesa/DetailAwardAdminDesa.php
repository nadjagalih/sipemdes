<?php
// Detail award page untuk admin desa
include "../App/Control/FunctionDetailAwardAdminDesa.php";
?>

<?php
// Handle alert notifications
if (isset($_GET['alert'])) {
    $$alertType = isset($_GET['alert']) ? sql_injeksi($_GET['alert']) : '';
    if ($alertType == 'DeleteSuccess') {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showSuccessModal('Karya berhasil dihapus!');
            });
        </script>";
    } elseif ($alertType == 'UpdateSuccess') {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showSuccessModal('Karya berhasil diupdate!');
            });
        </script>";
    } elseif ($alertType == 'DeleteError') {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('Gagal menghapus karya. Silakan coba lagi.');
            });
        </script>";
    } elseif ($alertType == 'UpdateError') {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('Gagal mengupdate karya. Silakan coba lagi.');
            });
        </script>";
    } elseif ($alertType == 'AccessDenied') {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('Anda tidak memiliki akses untuk mengedit karya ini!');
            });
        </script>";
    }
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Award</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="?pg=Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="?pg=AwardViewAdminDesa">Award Desa</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detail Award</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <br>
        <div class="title-action">
            <a href="?pg=AwardViewAdminDesa" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <?php if ($DataAward): ?>
    <div class="row">
        <!-- Award Info -->
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="text-center">
                        <i class="fa fa-trophy" style="font-size: 80px; color: #FFD700; margin-bottom: 20px;"></i>
                        <h1 class="font-bold"><?php echo $DataAward['JenisPenghargaan']; ?></h1>
                        <div style="margin: 15px 0;">
                            <span class="badge badge-primary badge-lg" style="font-size: 16px; padding: 8px 15px; background-color: #007bff; color: white;">
                                Tahun <?php echo $DataAward['TahunPenghargaan']; ?>
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group text-center">
                                <label><strong>Masa Aktif Penghargaan:</strong></label>
                                <p class="form-control-static">
                                    <?php 
                                    if (!empty($DataAward['MasaAktifMulai']) && !empty($DataAward['MasaAktifSelesai'])) {
                                        echo date('d M Y', strtotime($DataAward['MasaAktifMulai'])) . ' - ' . date('d M Y', strtotime($DataAward['MasaAktifSelesai']));
                                        
                                        // Cek apakah masih dalam masa aktif
                                        $today = date('Y-m-d');
                                        if ($today >= $DataAward['MasaAktifMulai'] && $today <= $DataAward['MasaAktifSelesai']) {
                                            echo ' <span class="label label-success">Sedang Berlangsung</span>';
                                        } elseif ($today < $DataAward['MasaAktifMulai']) {
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
                                    if (!empty($DataAward['MasaPenjurianMulai']) && !empty($DataAward['MasaPenjurianSelesai'])) {
                                        echo date('d M Y', strtotime($DataAward['MasaPenjurianMulai'])) . ' - ' . date('d M Y', strtotime($DataAward['MasaPenjurianSelesai']));
                                        
                                        // Cek status masa penjurian
                                        $today = date('Y-m-d');
                                        if ($today >= $DataAward['MasaPenjurianMulai'] && $today <= $DataAward['MasaPenjurianSelesai']) {
                                            echo ' <span class="label label-success">Sedang Berlangsung</span>';
                                        } elseif ($today < $DataAward['MasaPenjurianMulai']) {
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
                            
                            <?php if (!empty($DataAward['Deskripsi'])): ?>
                            <div class="form-group text-center">
                                <label><strong>Deskripsi Penghargaan:</strong></label>
                                <p class="form-control-static"><?php echo nl2br($DataAward['Deskripsi']); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Action Panel -->
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="text-center">
                        <?php 
                        // Cek apakah ada karya yang terdaftar untuk award ini
                        if ($jumlahKaryaAward > 0): 
                        ?>
                            <div class="alert alert-info">
                                <i class="fa fa-check-circle"></i>
                                <strong>Sudah Terdaftar</strong><br>
                                Desa sudah mendaftarkan <?php echo $jumlahKaryaAward; ?> karya ke award ini.
                            </div>
                            <?php if ($statusInfo['text'] == 'Pendaftaran'): ?>
                            <small class="text-muted">
                                <i class="fa fa-info-circle"></i> 
                                Setiap desa hanya dapat mendaftar 1 kategori per award
                            </small>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if ($statusInfo['text'] == 'Pendaftaran'): ?>
                                <div class="alert alert-success">
                                    <i class="fa fa-clock-o"></i>
                                    <strong>Bisa Mendaftar</strong><br>
                                    Award ini sedang membuka pendaftaran.
                                </div>
                                <a href="?pg=AwardViewAdminDesa" class="btn btn-success btn-block">
                                    <i class="fa fa-plus"></i> Daftar Karya
                                </a>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle"></i>
                                    <strong>Tidak Bisa Mendaftar</strong><br>
                                    Award sedang tidak membuka pendaftaran.
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Karya Desa yang Terdaftar -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><i class="fa fa-list"></i> Karya Desa yang Terdaftar</h5>
                </div>
                <div class="ibox-content">
                    <?php if ($QueryKaryaAward && mysqli_num_rows($QueryKaryaAward) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori</th>
                                        <th>Judul Karya</th>
                                        <th>Link Karya</th>
                                        <th>Posisi</th>
                                        <th>Status</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    // Reset pointer jika perlu
                                    if ($QueryKaryaAward) {
                                        mysqli_data_seek($QueryKaryaAward, 0);
                                    }
                                    while ($QueryKaryaAward && ($DataKaryaAward = mysqli_fetch_assoc($QueryKaryaAward))): 
                                        // Status berdasarkan award dan posisi
                                        $statusBadge = 'badge-secondary';
                                        $statusText = 'Menunggu Hasil';
                                        
                                        if (!empty($DataKaryaAward['Posisi']) && $DataKaryaAward['Posisi'] > 0) {
                                            $statusBadge = 'badge-success';
                                            $statusText = 'Peringkat ' . $DataKaryaAward['Posisi'];
                                        } elseif ($DataKaryaAward['StatusAward'] == 'Non-Aktif') {
                                            $statusBadge = 'badge-warning';
                                            $statusText = 'Award Selesai';
                                        }
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <span class="badge badge-info"><?php echo $DataKaryaAward['NamaKategori']; ?></span>
                                        </td>
                                        <td>
                                            <strong><?php echo $DataKaryaAward['JudulKarya']; ?></strong>
                                            <?php if (!empty($DataKaryaAward['Keterangan'])): ?>
                                                <br><small class="text-muted"><?php echo substr($DataKaryaAward['Keterangan'], 0, 50) . '...'; ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo $DataKaryaAward['LinkKarya']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fa fa-external-link"></i> Lihat Karya
                                            </a>
                                        </td>
                                        <td>
                                            <?php if (!empty($DataKaryaAward['Posisi']) && $DataKaryaAward['Posisi'] > 0): ?>
                                                <span class="badge badge-success">Peringkat <?php echo $DataKaryaAward['Posisi']; ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">Belum ada</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge <?php echo $statusBadge; ?>"><?php echo $statusText; ?></span>
                                        </td>
                                        <td><?php echo date('d M Y H:i', strtotime($DataKaryaAward['TanggalDaftar'])); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-info" onclick="detailKaryaAward('<?php echo $DataKaryaAward['IdPesertaAward']; ?>', '<?php echo addslashes($DataKaryaAward['JudulKarya']); ?>', '<?php echo addslashes($DataKaryaAward['Keterangan'] ?? ''); ?>', '<?php echo $DataKaryaAward['LinkKarya']; ?>', '<?php echo $DataKaryaAward['NamaKategori']; ?>')">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <?php if ($DataKaryaAward['StatusAward'] == 'Aktif'): ?>
                                                <!--
                                                <a href="?pg=EditKaryaAward&kode=<?php echo $DataKaryaAward['IdPesertaAward']; ?>&award=<?php echo $IdAward; ?>" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                -->
                                                <button type="button" class="btn btn-sm btn-danger" onclick="hapusKaryaAward('<?php echo $DataKaryaAward['IdPesertaAward']; ?>', '<?php echo addslashes($DataKaryaAward['JudulKarya']); ?>')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <i class="fa fa-info-circle"></i>
                            <strong>Belum Ada Karya Terdaftar</strong><br>
                            Desa belum mendaftarkan karya untuk award ini.
                            <?php if ($statusInfo['text'] == 'Pendaftaran'): ?>
                                <br><br>
                                <a href="?pg=AwardViewAdminDesa" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Daftar Karya Sekarang
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php else: ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger text-center">
                <i class="fa fa-exclamation-triangle"></i>
                <strong>Award tidak ditemukan</strong><br>
                Award yang Anda cari tidak ditemukan atau tidak tersedia.
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
/* Award Detail Styling */
.award-header {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    padding: 30px;
    border-radius: 10px;
    margin-bottom: 30px;
}

.award-title {
    color: #2c3e50;
    margin: 15px 0;
}

.badge-lg {
    padding: 8px 15px;
    font-size: 14px;
}

.timeline-item {
    border-left: 3px solid #1ab394;
    padding-left: 20px;
    margin-left: 10px;
}

.timeline-content {
    margin-bottom: 20px;
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
}

.timeline-title {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

.status-detail .status-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.status-detail .status-item:last-child {
    border-bottom: none;
}

.status-label {
    font-weight: bold;
    color: #555;
}

.status-value {
    color: #333;
}

.kategori-card .card {
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.kategori-card .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

/* Modern ibox styling untuk konsistensi */
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
    border-radius: 8px 8px 0 0;
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
</style>

<!-- Modal Detail Karya Award -->
<div class="modal fade" id="modalDetailKaryaAward" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail Karya Award</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Judul Karya</label>
                            <p id="detailJudulKaryaAward" class="form-control-static"></p>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <p id="detailKategoriAward" class="form-control-static"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Link Karya</label>
                            <p><a id="detailLinkKaryaAward" href="#" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-external-link"></i> Buka Karya</a></p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Deskripsi Karya</label>
                    <p id="detailDeskripsiKaryaAward" class="form-control-static"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Karya Award -->
<div class="modal fade" id="modalConfirmDeleteAward" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center; padding: 40px 30px;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f44336, #d32f2f); border-radius: 50%; margin: 0 auto 20px auto; display: flex; align-items: center; justify-content: center; font-size: 40px; color: white; box-shadow: 0 5px 15px rgba(244, 67, 54, 0.3);">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
                <h4 style="font-size: 24px; font-weight: 600; color: #333; margin-bottom: 15px;">Yakin ingin menghapus karya?</h4>
                <p style="color: #666; font-size: 16px; line-height: 1.5; margin-bottom: 25px;" id="deleteAwardMessage">
                    Karya yang sudah dihapus tidak dapat dikembalikan.
                </p>
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button type="button" class="btn" style="background: #6c757d; color: white; border: none; padding: 12px 25px; border-radius: 25px; font-weight: 600;" onclick="closeDeleteAwardModal()">
                        Batal
                    </button>
                    <button type="button" class="btn" style="background: linear-gradient(135deg, #f44336, #d32f2f); color: white; border: none; padding: 12px 25px; border-radius: 25px; font-weight: 600;" id="confirmDeleteAwardBtn">
                        Hapus
                    </button>
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
                <button type="button" style="background: linear-gradient(135deg, #007bff, #0056b3); color: white; border: none; padding: 12px 30px; border-radius: 25px; font-weight: 600; font-size: 16px;" onclick="closeSuccessModal()">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function detailKaryaAward(id, judul, deskripsi, link, kategori) {
    document.getElementById('detailJudulKaryaAward').textContent = judul;
    document.getElementById('detailKategoriAward').textContent = kategori;
    document.getElementById('detailLinkKaryaAward').href = link;
    document.getElementById('detailDeskripsiKaryaAward').textContent = deskripsi || 'Tidak ada deskripsi';
    
    $('#modalDetailKaryaAward').modal('show');
}

function hapusKaryaAward(id, judul) {
    document.getElementById('deleteAwardMessage').innerHTML = 'Karya "<strong>' + judul + '</strong>" akan dihapus permanen.<br><br>Karya yang sudah dihapus tidak dapat dikembalikan.';
    
    document.getElementById('confirmDeleteAwardBtn').onclick = function() {
        // Redirect ke halaman delete dengan parameter yang tepat
        window.location.href = '../App/Model/ExcKaryaDesa.php?Act=Delete&Kode=' + id + '&redirect=DetailAwardAdminDesa&award=<?php echo $IdAward; ?>';
    };
    
    $('#modalConfirmDeleteAward').modal({
        backdrop: 'static',
        keyboard: false
    });
}

function closeDeleteAwardModal() {
    $('#modalConfirmDeleteAward').modal('hide');
}

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
    
</script>