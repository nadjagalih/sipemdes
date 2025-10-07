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
        <div class="item" style="border-bottom: 1px solid #e7eaec; padding: 20px !important; margin-bottom: 20px !important; border-radius: 12px !important; box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important; border: 1px solid #e9ecef !important; transition: all 0.3s ease; position: relative; background: white;">
            <div class="row">
                <!-- Content area dengan padding minimal -->
                <div class="col-md-6" style="padding-left: 35px !important; margin-left: -25px !important;">
                    <div>
                        <h4 style="margin: 0 0 10px 0; color: #007bff !important; font-weight: 700 !important; font-size: 18px !important;">
                            🏅 <a href="?pg=KategoriDetail&Kode=<?php echo $IdKategoriAward; ?>"><?php echo $NamaKategori; ?></a>
                        </h4>
                        <?php if (!empty($deskripsiShort)): ?>
                            <p style="margin: 0 0 5px 0; color: #6c757d !important; font-size: 14px !important; line-height: 1.4 !important;">
                                <i class="fa fa-info-circle" style="margin-right: 8px; color: #999; width: 16px; text-align: center;"></i><?php echo $deskripsiShort; ?>
                            </p>
                        <?php endif; ?>
                        <p style="margin: 0; color: #6c757d !important; font-size: 14px !important; line-height: 1.4 !important;">
                            <i class="fa fa-calendar" style="margin-right: 8px; color: #999; width: 16px; text-align: center;"></i>Dibuat: <?php echo $TanggalInputKategori; ?>
                        </p>
                    </div>
                </div>
                <!-- Status badge dengan posisi absolute -->
                <div class="col-md-2" style="position: absolute !important; top: 30px !important; right: 120px !important; width: auto !important; min-width: 100px !important;">
                    <span class="label <?php echo $badgeAward; ?>" style="padding: 8px 12px !important; font-size: 11px !important; border-radius: 20px !important; font-weight: 500 !important; text-transform: uppercase !important; min-width: 90px !important; display: inline-block !important; text-align: center !important; font-weight: 600 !important; letter-spacing: 0.3px !important; white-space: nowrap !important;">
                        <?php echo $StatusAward; ?>
                    </span>
                </div>
                <!-- Action buttons dengan posisi absolute -->
                <div class="col-md-2" style="position: absolute !important; top: 25px !important; right: 15px !important; width: auto !important;">
                    <div class="dropdown">
                        <button class="btn btn-outline" style="border: 1px solid #ddd; background: #f8f9fa; color: #6c757d; padding: 8px 12px; border-radius: 6px; font-size: 12px;" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-cog"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" style="box-shadow: 0 4px 12px rgba(0,0,0,0.15); border: 1px solid #e9ecef; border-radius: 6px; z-index: 1050; min-width: 150px;">
                            <li>
                                <a href="?pg=KategoriDetail&Kode=<?php echo $IdKategoriAward; ?>" style="padding: 10px 16px; color: #495057; font-size: 14px;">
                                    <i class="fa fa-eye text-info"></i> Detail
                                </a>
                            </li>
                            <li>
                                <a href="#" onclick="editKategori('<?php echo $IdKategoriAward; ?>')" style="padding: 10px 16px; color: #495057; font-size: 14px;">
                                    <i class="fa fa-edit text-success"></i> Edit Kategori
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#" onclick="confirmDelete('../App/Model/ExcKategoriAward.php?Act=Delete&Kode=<?php echo $IdKategoriAward; ?>', 'Yakin ingin menghapus kategori ini? Semua peserta dalam kategori ini akan ikut terhapus.')" style="padding: 10px 16px; color: #495057; font-size: 14px;">
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