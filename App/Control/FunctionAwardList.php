<?php
// Build query with filters
$whereConditions = array("1=1");

if (isset($_GET['status']) && !empty($_GET['status'])) {
    $status = sql_injeksi($_GET['status']);
    $whereConditions[] = "ma.StatusAktif = '$status'";
}

if (isset($_GET['tahun']) && !empty($_GET['tahun'])) {
    $tahun = sql_injeksi($_GET['tahun']);
    $whereConditions[] = "ma.TahunPenghargaan = '$tahun'";
}

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = sql_injeksi($_GET['search']);
    $whereConditions[] = "ma.JenisPenghargaan LIKE '%$search%'";
}

$whereClause = implode(" AND ", $whereConditions);

$QueryAward = mysqli_query($db, "SELECT 
    ma.IdAward,
    ma.JenisPenghargaan,
    ma.TahunPenghargaan,
    ma.StatusAktif,
    ma.Deskripsi,
    ma.TanggalInput,
    ma.MasaAktifMulai,
    ma.MasaAktifSelesai
    FROM master_award_desa ma
    WHERE $whereClause
    ORDER BY ma.TahunPenghargaan DESC, ma.TanggalInput DESC");

$no = 1;
if (mysqli_num_rows($QueryAward) > 0) {
    while ($DataAward = mysqli_fetch_assoc($QueryAward)) {
        $IdAward = $DataAward['IdAward'];
        $JenisPenghargaan = $DataAward['JenisPenghargaan'];
        $TahunPenghargaan = $DataAward['TahunPenghargaan'];
        $StatusAktif = $DataAward['StatusAktif'];
        $Deskripsi = $DataAward['Deskripsi'];
        $TanggalInput = date('d M Y', strtotime($DataAward['TanggalInput']));
        $MasaAktifMulai = $DataAward['MasaAktifMulai'];
        $MasaAktifSelesai = $DataAward['MasaAktifSelesai'];
        
        // Auto-update status berdasarkan masa aktif
        $today = date('Y-m-d');
        $statusOtomatis = 'Non-Aktif'; // default
        
        if (!empty($MasaAktifMulai) && !empty($MasaAktifSelesai)) {
            if ($today >= $MasaAktifMulai && $today <= $MasaAktifSelesai) {
                $statusOtomatis = 'Aktif';
            }
        }
        
        // Update status di database jika berbeda
        if ($StatusAktif !== $statusOtomatis) {
            mysqli_query($db, "UPDATE master_award_desa SET StatusAktif = '$statusOtomatis' WHERE IdAward = '$IdAward'");
            $StatusAktif = $statusOtomatis; // Update variabel lokal
        }

        // Tentukan warna badge berdasarkan status
        $badgeClass = ($StatusAktif == 'Aktif') ? 'label-primary' : 'label-default';
        
        // Format masa aktif untuk tampilan
        $masaAktifText = '';
        if (!empty($MasaAktifMulai) && !empty($MasaAktifSelesai)) {
            $masaAktifText = date('d M Y', strtotime($MasaAktifMulai)) . ' - ' . date('d M Y', strtotime($MasaAktifSelesai));
            
            // Tambahkan status masa aktif
            if ($today >= $MasaAktifMulai && $today <= $MasaAktifSelesai) {
                $masaAktifText .= ' (Berlangsung)';
            } elseif ($today < $MasaAktifMulai) {
                $masaAktifText .= ' (Belum Dimulai)';
            } else {
                $masaAktifText .= ' (Sudah Berakhir)';
            }
        } else {
            $masaAktifText = 'Belum ditentukan';
        }
        
        // Format deskripsi yang panjang
        $deskripsiShort = !empty($Deskripsi) ? (strlen($Deskripsi) > 60 ? substr($Deskripsi, 0, 60).'...' : $Deskripsi) : '';
?>
        <div class="award-item" style="border-bottom: 1px solid #e7eaec; padding: 15px 0;">
            <div class="row">
                <div class="col-md-1 text-center">
                    <h4 style="margin: 0; color: #676a6c; font-weight: bold;"><?php echo $no; ?></h4>
                </div>
                <div class="col-md-8">
                    <div>
                        <h4 style="margin: 0 0 5px 0; color: #1ab394; font-weight: bold;">
                            <?php echo $JenisPenghargaan; ?>
                        </h4>
                        <p style="margin: 0; color: #676a6c; font-size: 13px;">
                            <i class="fa fa-building text-muted"></i> Pemerintah Kabupaten Trenggalek &nbsp;&nbsp;
                            <i class="fa fa-calendar text-muted"></i> Dibuat: <?php echo $TanggalInput; ?>
                        </p>
                        <p style="margin: 0; color: #676a6c; font-size: 13px;">
                            <i class="fa fa-clock-o text-muted"></i> Masa Aktif: <?php echo $masaAktifText; ?>
                        </p>
                        <p style="margin: 5px 0 0 0; color: #676a6c; font-size: 12px;">
                            <?php echo $deskripsiShort; ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    <span class="label <?php echo $badgeClass; ?>" style="padding: 4px 12px; font-size: 11px;">
                        <?php echo $StatusAktif; ?>
                    </span>
                </div>
                <div class="col-md-1 text-right">
                    <div class="dropdown">
                        <button class="btn btn-xs btn-outline btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-cog"></i> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a href="?pg=AwardDetail&Kode=<?php echo $IdAward; ?>">
                                    <i class="fa fa-eye text-info"></i> Detail
                                </a>
                            </li>
                            <li>
                                <a href="?pg=AwardEdit&Kode=<?php echo $IdAward; ?>">
                                    <i class="fa fa-edit text-success"></i> Edit
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="../App/Model/ExcAward.php?Act=Delete&Kode=<?php echo $IdAward; ?>" 
                                   onclick="return confirm('Yakin ingin menghapus penghargaan ini?');">
                                    <i class="fa fa-trash text-danger"></i> Hapus
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
        <i class="fa fa-trophy" style="font-size: 48px; color: #ddd;"></i>
        <h3 style="color: #676a6c; margin-top: 20px;">Tidak Ada Data Award</h3>
        <p style="color: #999;">Belum ada data penghargaan yang tersimpan.</p>
        <a href="?pg=AwardAdd" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Award Pertama
        </a>
    </div>
<?php 
}
?>