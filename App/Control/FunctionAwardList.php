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
                // Hapus teks "Sudah Berakhir" sesuai permintaan user
                // $masaAktifText .= ' (Sudah Berakhir)';
            }
        } else {
            $masaAktifText = 'Belum ditentukan';
        }
        
        // Format deskripsi yang panjang
        $deskripsiShort = !empty($Deskripsi) ? (strlen($Deskripsi) > 60 ? substr($Deskripsi, 0, 60).'...' : $Deskripsi) : '';
?>
        <div class="award-item" style="border-bottom: none; padding: 25px; background: white; margin-bottom: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border: 1px solid #e9ecef; position: relative; transition: all 0.3s ease;">
            <div class="row">
                <div class="col-md-1 text-center">
                    <div style="background: #007bff; color: white; width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px; margin: 0 auto;">
                        <?php echo $no; ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div>
                        <h4 style="margin: 0 0 10px 0; color: #007bff; font-weight: 700; font-size: 18px;">
                            <?php echo $JenisPenghargaan; ?>
                        </h4>
                        <p style="margin: 0 0 5px 0; color: #6c757d; font-size: 14px; line-height: 1.4;">
                            <i class="fa fa-building" style="margin-right: 8px; color: #999;"></i> Pemerintah Kabupaten Trenggalek
                        </p>
                        <p style="margin: 0 0 5px 0; color: #6c757d; font-size: 14px; line-height: 1.4;">
                            <i class="fa fa-calendar" style="margin-right: 8px; color: #999;"></i> Dibuat: <?php echo $TanggalInput; ?>
                        </p>
                        <p style="margin: 0 0 5px 0; color: #6c757d; font-size: 14px; line-height: 1.4;">
                            <i class="fa fa-clock-o" style="margin-right: 8px; color: #999;"></i> Masa Aktif: <?php echo $masaAktifText; ?>
                        </p>
                        <p style="margin: 0; color: #6c757d; font-size: 14px; line-height: 1.4;">
                            <?php echo $deskripsiShort; ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-2 text-center" style="position: absolute; top: 25px; right: 100px;">
                    <span class="label <?php echo $badgeClass; ?>" style="padding: 10px 18px; font-size: 12px; border-radius: 20px; font-weight: 600; text-transform: uppercase; color: white; border: 2px solid #495057; box-shadow: 0 2px 4px rgba(0,0,0,0.2); min-width: 80px; text-align: center;">
                        <?php echo $StatusAktif; ?>
                    </span>
                </div>
                <div class="col-md-1 text-right" style="position: absolute; top: 27px; right: 25px;">
                    <div class="dropdown">
                        <button class="btn btn-xs btn-outline btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-cog"></i><span class="caret"></span>
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