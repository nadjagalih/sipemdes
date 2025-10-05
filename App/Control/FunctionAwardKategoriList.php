<?php
// Query untuk mendapatkan kategori award dengan status award
$QueryKategori = mysqli_query($db, "SELECT 
    mk.IdKategoriAward,
    mk.NamaKategori,
    mk.DeskripsiKategori,
    mk.TanggalInput,
    ma.StatusAktif as StatusAward
    FROM master_kategori_award mk
    JOIN master_award_desa ma ON mk.IdAwardFK = ma.IdAward
    WHERE mk.IdAwardFK = '$IdAward'
    ORDER BY mk.TanggalInput DESC");

if (mysqli_num_rows($QueryKategori) > 0) {
    $no = 1;
    while ($DataKategori = mysqli_fetch_assoc($QueryKategori)) {
        $IdKategoriAward = $DataKategori['IdKategoriAward'];
        $NamaKategori = $DataKategori['NamaKategori'];
        $DeskripsiKategori = $DataKategori['DeskripsiKategori'];
        $StatusAward = $DataKategori['StatusAward'];
        $TanggalInputKategori = date('d M Y', strtotime($DataKategori['TanggalInput']));

        // Query untuk mendapatkan jumlah peserta per kategori
        $QueryCountPeserta = mysqli_query($db, "SELECT 
            COUNT(*) as total_peserta,
            COUNT(CASE WHEN Posisi IS NOT NULL AND Posisi != '' THEN 1 END) as peserta_berposisi
            FROM desa_award da
            WHERE da.IdKategoriAwardFK = '$IdKategoriAward'");

        $DataCount = mysqli_fetch_assoc($QueryCountPeserta);
        $totalPeserta = $DataCount['total_peserta'];
        $pesertaBerposisi = $DataCount['peserta_berposisi'];

        $badgeAward = ($StatusAward == 'Aktif') ? 'label-success' : 'label-default';

        // Format deskripsi yang panjang
        $deskripsiShort = !empty($DeskripsiKategori) ? (strlen($DeskripsiKategori) > 80 ? substr($DeskripsiKategori, 0, 80) . '...' : $DeskripsiKategori) : '';
?>
        <div class="kategori-item" style="border-bottom: 1px solid #e7eaec; padding: 20px 0;">
            <div class="row">
                <div class="col-md-1 text-center">
                    <div style="padding-top: 10px;">
                        <h4 style="margin: 0; color: #676a6c; font-weight: bold;"><?php echo $no; ?></h4>
                    </div>
                </div>
                <div class="col-md-1 text-center">
                    <i class="fa fa-trophy" style="font-size: 32px; color: #f8ac59; margin-top: 8px;"></i>
                </div>
                <div class="col-md-6">
                    <div>
                        <h4 style="margin: 0 0 5px 0; color: #1ab394; font-weight: bold;">
                            <?php echo $NamaKategori; ?>
                        </h4>
                        <?php if (!empty($deskripsiShort)): ?>
                            <p style="margin: 0 0 8px 0; color: #676a6c; font-size: 13px;">
                                <?php echo $deskripsiShort; ?>
                            </p>
                        <?php endif; ?>
                        <p style="margin: 0; color: #999; font-size: 12px;">
                            <i class="fa fa-calendar text-muted"></i> Dibuat: <?php echo $TanggalInputKategori; ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-2 text-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-cog"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a href="?pg=KategoriDetail&Kode=<?php echo $IdKategoriAward; ?>">
                                    <i class="fa fa-eye text-info"></i> Detail
                                </a>
                            </li>
                            <li>
                                <a href="#" onclick="editKategori('<?php echo $IdKategoriAward; ?>')">
                                    <i class="fa fa-edit text-success"></i> Edit Kategori
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#" onclick="confirmDelete('../App/Model/ExcKategoriAward.php?Act=Delete&Kode=<?php echo $IdKategoriAward; ?>', 'Yakin ingin menghapus kategori ini? Semua peserta dalam kategori ini akan ikut terhapus.')">
                                    <i class="fa fa-trash text-danger"></i> Hapus Kategori
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php
        $no++;
    }
} else {
    ?>
    <div class="text-center" style="padding: 60px 0;">
        <i class="fa fa-folder-open" style="font-size: 48px; color: #ddd;"></i>
        <h3 style="color: #676a6c; margin-top: 20px;">Belum Ada Kategori</h3>
        <p style="color: #999;">Award ini belum memiliki kategori. Tambahkan kategori untuk mulai mengelola peserta.</p>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddKategori">
            <i class="fa fa-plus"></i> Tambah Kategori Pertama
        </button>
    </div>
<?php
}
?>