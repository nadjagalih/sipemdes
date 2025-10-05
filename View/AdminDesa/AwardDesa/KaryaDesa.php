<?php
include "../App/Control/FunctionKaryaDesa.php";
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Riwayat Karya</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="?pg=Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Karya Saya</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <div class="title-action">
            <a href="?pg=AwardViewAdminDesa" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Riwayat Karya</h5>
                    <h1 class="no-margins"><?php echo $totalKarya; ?></h1>
                    <small>Total Karya</small>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Menang</h5>
                    <h1 class="no-margins text-success"><?php echo $totalMenang; ?></h1>
                    <small>Mendapat posisi</small>
                </div>
            </div>
        </div>
    </div>

    <!-- List Karya -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Daftar Karya</h5>
                </div>
                <div class="ibox-content">
                    <?php if ($QueryKarya && mysqli_num_rows($QueryKarya) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Award</th>
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
                                    mysqli_data_seek($QueryKarya, 0); // Reset pointer
                                    while ($DataKarya = mysqli_fetch_assoc($QueryKarya)): 
                                        // Status berdasarkan award dan posisi
                                        $statusBadge = 'badge-secondary';
                                        $statusText = 'Menunggu Hasil';
                                        
                                        if (!empty($DataKarya['Posisi'])) {
                                            $statusBadge = 'badge-success';
                                            $statusText = 'Menang';
                                        } elseif ($DataKarya['StatusAward'] == 'Non-Aktif') {
                                            $statusBadge = 'badge-warning';
                                            $statusText = 'Award Selesai';
                                        }
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <strong><?php echo $DataKarya['JenisPenghargaan']; ?></strong>
                                            <br><small><?php echo $DataKarya['TahunPenghargaan']; ?></small>
                                        </td>
                                        <td>
                                            <span class="badge badge-info"><?php echo $DataKarya['NamaKategori']; ?></span>
                                        </td>
                                        <td><?php echo $DataKarya['JudulKarya']; ?></td>
                                        <td>
                                            <a href="<?php echo $DataKarya['LinkKarya']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fa fa-external-link"></i> Lihat Karya
                                            </a>
                                        </td>
                                        <td>
                                            <?php if (!empty($DataKarya['Posisi'])): ?>
                                                <span class="badge badge-success"><?php echo $DataKarya['Posisi']; ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">Belum ada</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge <?php echo $statusBadge; ?>"><?php echo $statusText; ?></span>
                                        </td>
                                        <td><?php echo date('d M Y', strtotime($DataKarya['TanggalDaftar'])); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-info" onclick="detailKarya('<?php echo $DataKarya['IdDesaAward']; ?>', '<?php echo addslashes($DataKarya['JudulKarya']); ?>', '<?php echo addslashes($DataKarya['Keterangan'] ?? ''); ?>', '<?php echo $DataKarya['LinkKarya']; ?>')">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center" style="padding: 50px;">
                            <i class="fa fa-trophy" style="font-size: 60px; color: #ddd;"></i>
                            <h3>Belum Ada Karya</h3>
                            <p class="text-muted">Anda belum mendaftarkan karya apapun.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Karya -->
<div class="modal fade" id="modalDetailKarya" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail Karya</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Judul Karya</label>
                    <p id="detailJudulKarya" class="form-control-static"></p>
                </div>
                <div class="form-group">
                    <label>Link Karya</label>
                    <p><a id="detailLinkKarya" href="#" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-external-link"></i> Buka Karya</a></p>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <p id="detailDeskripsiKarya" class="form-control-static"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
function detailKarya(id, judul, deskripsi, link) {
    document.getElementById('detailJudulKarya').textContent = judul;
    document.getElementById('detailLinkKarya').href = link;
    document.getElementById('detailDeskripsiKarya').textContent = deskripsi || 'Tidak ada deskripsi';
    
    $('#modalDetailKarya').modal('show');
}

function hapusKarya(id, judul) {
    if (confirm('Yakin ingin menghapus karya "' + judul + '"?')) {
        window.location.href = '../App/Model/ExcKaryaDesa.php?Act=Delete&Kode=' + id;
    }
}
</script>