<?php
// Cek apakah ada parameter yang diperlukan
if (!isset($_GET['kode']) || empty($_GET['kode']) || !isset($_GET['award']) || empty($_GET['award'])) {
    echo "<script>
        alert('Parameter tidak lengkap');
        window.location.href = '?pg=AwardViewAdminDesa';
    </script>";
    exit;
}

$IdPesertaAward = sql_injeksi($_GET['kode']);
$IdAward = sql_injeksi($_GET['award']);
$IdDesa = $_SESSION['IdDesa'] ?? '';

// Query untuk mendapatkan data karya yang akan diedit
$QueryKarya = mysqli_query($db, "SELECT 
    da.IdPesertaAward,
    da.NamaKarya,
    da.LinkKarya,
    da.DeskripsiKarya,
    da.IdKategoriAwardFK,
    mk.NamaKategori,
    mk.IdAwardFK,
    ma.JenisPenghargaan,
    ma.TahunPenghargaan,
    ma.StatusAktif
    FROM desa_award da
    JOIN master_kategori_award mk ON da.IdKategoriAwardFK = mk.IdKategoriAward
    JOIN master_award_desa ma ON mk.IdAwardFK = ma.IdAward
    WHERE da.IdPesertaAward = '$IdPesertaAward' 
    AND da.IdDesaFK = '$IdDesa' 
    AND ma.IdAward = '$IdAward'");

if (mysqli_num_rows($QueryKarya) == 0) {
    echo "<script>
        alert('Karya tidak ditemukan atau Anda tidak memiliki akses');
        window.location.href = '?pg=DetailAwardAdminDesa&id=$IdAward';
    </script>";
    exit;
}

$DataKarya = mysqli_fetch_assoc($QueryKarya);

// Cek apakah award masih aktif (untuk editing)
if ($DataKarya['StatusAktif'] != 'Aktif') {
    echo "<script>
        alert('Award sudah tidak aktif, karya tidak dapat diedit');
        window.location.href = '?pg=DetailAwardAdminDesa&id=$IdAward';
    </script>";
    exit;
}

// Handle alert notifications
if (isset($_GET['alert'])) {
    $alertType = $_GET['alert'];
    if ($alertType == 'UpdateError') {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('Gagal mengupdate karya. Silakan coba lagi.');
            });
        </script>";
    } elseif ($alertType == 'InvalidURL') {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('Format URL tidak valid! Pastikan URL dimulai dengan http:// atau https://');
            });
        </script>";
    }
}
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Edit Karya Award</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="?pg=Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="?pg=AwardViewAdminDesa">Award Tersedia</a>
            </li>
            <li class="breadcrumb-item">
                <a href="?pg=DetailAwardAdminDesa&id=<?php echo $IdAward; ?>">Detail Award</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Karya</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <div class="title-action">
            <a href="?pg=DetailAwardAdminDesa&id=<?php echo $IdAward; ?>" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Form Edit Karya Award</h5>
                    <div class="ibox-tools">
                        <span class="label label-warning">Mode Edit</span>
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="../App/Model/ExcKaryaDesa.php?Act=UpdateFromAward" id="formEditKaryaAward">
                        <input type="hidden" name="IdPesertaAward" value="<?php echo $DataKarya['IdPesertaAward']; ?>">
                        <input type="hidden" name="IdAward" value="<?php echo $IdAward; ?>">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Award/Penghargaan</label>
                                    <div class="well well-sm">
                                        <strong><?php echo $DataKarya['JenisPenghargaan'] . ' ' . $DataKarya['TahunPenghargaan']; ?></strong>
                                    </div>
                                    <small class="form-text text-muted">Award tidak dapat diubah</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <div class="well well-sm">
                                        <strong><?php echo $DataKarya['NamaKategori']; ?></strong>
                                    </div>
                                    <small class="form-text text-muted">Kategori tidak dapat diubah</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="JudulKarya">Judul Karya <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="JudulKarya" name="JudulKarya" required 
                                   value="<?php echo htmlspecialchars($DataKarya['NamaKarya']); ?>"
                                   placeholder="Masukkan judul karya Anda" maxlength="255">
                            <small class="form-text text-muted">Maksimal 255 karakter</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="LinkKarya">Link/URL Karya <span class="text-danger">*</span></label>
                            <input type="url" class="form-control" id="LinkKarya" name="LinkKarya" required 
                                   value="<?php echo htmlspecialchars($DataKarya['LinkKarya']); ?>"
                                   placeholder="https://example.com/karya-anda">
                            <small class="form-text text-muted">Masukkan URL lengkap dengan https://</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="DeskripsiKarya">Deskripsi Karya (Opsional)</label>
                            <textarea class="form-control" id="DeskripsiKarya" name="DeskripsiKarya" rows="4" 
                                      placeholder="Ceritakan tentang karya Anda..."><?php echo htmlspecialchars($DataKarya['DeskripsiKarya']); ?></textarea>
                        </div>
                        
                        <div class="hr-line-dashed"></div>
                        
                        <div class="form-group">
                            <button type="submit" name="Update" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update Karya
                            </button>
                            <a href="?pg=DetailAwardAdminDesa&id=<?php echo $IdAward; ?>" class="btn btn-white">
                                <i class="fa fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.well {
    background-color: #f5f5f5;
    border: 1px solid #e3e3e3;
    border-radius: 4px;
    padding: 19px;
    margin-bottom: 0;
}

.well-sm {
    padding: 9px;
}
</style>

<script>
// Validation
document.getElementById('formEditKaryaAward').addEventListener('submit', function(e) {
    var linkKarya = document.getElementById('LinkKarya').value;
    
    // Validasi URL format
    try {
        new URL(linkKarya);
    } catch (_) {
        e.preventDefault();
        alert('Format URL tidak valid. Pastikan URL dimulai dengan http:// atau https://');
        return false;
    }
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