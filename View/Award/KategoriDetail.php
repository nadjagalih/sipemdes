<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



// Debug parameter
// Debug code removed for production

try {
    include "../App/Control/FunctionKategoriDetail.php";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    die();
}

// Pastikan variabel terdefinisi dengan nilai default
$NamaKategori = isset($NamaKategori) ? $NamaKategori : 'Kategori Tidak Ditemukan';
$JenisPenghargaan = isset($JenisPenghargaan) ? $JenisPenghargaan : 'Unknown';
$StatusAward = isset($StatusAward) ? $StatusAward : 'Unknown';
$IdAward = isset($IdAward) ? $IdAward : '';
$IdKategoriAward = isset($IdKategoriAward) ? $IdKategoriAward : '';
$totalPeserta = isset($totalPeserta) ? $totalPeserta : 0;
$pesertaBerposisi = isset($pesertaBerposisi) ? $pesertaBerposisi : 0;
$DeskripsiKategori = isset($DeskripsiKategori) ? $DeskripsiKategori : '';
$MasaPenjurianMulai = isset($MasaPenjurianMulai) ? $MasaPenjurianMulai : '';
$MasaPenjurianSelesai = isset($MasaPenjurianSelesai) ? $MasaPenjurianSelesai : '';
$isMasaPenjurian = isset($isMasaPenjurian) ? $isMasaPenjurian : false;
$statusPenjurian = isset($statusPenjurian) ? $statusPenjurian : 'Status tidak diketahui';
$QueryPeserta = isset($QueryPeserta) ? $QueryPeserta : null;

// Inisialisasi variabel juara
$juara1 = null;
$juara2 = null;
$juara3 = null;
$posisiTerisi = array(); // Array untuk menyimpan posisi yang sudah terisi

// Query untuk mendapatkan semua juara jika IdKategoriAward tersedia
if (!empty($IdKategoriAward)) {
    // Query untuk mendapatkan juara 1
    $QueryJuara1 = mysqli_query($db, "SELECT 
        pa.IdPesertaAward,
        pa.NamaPeserta,
        pa.NamaKarya,
        pa.LinkKarya,
        pa.Posisi,
        md.NamaDesa,
        mk.Kecamatan
        FROM desa_award pa
        INNER JOIN master_desa md ON pa.IdDesaFK = md.IdDesa
        INNER JOIN master_kecamatan mk ON md.IdKecamatanFK = mk.IdKecamatan
        WHERE pa.IdKategoriAwardFK = '$IdKategoriAward' 
        AND pa.Posisi = 1
        LIMIT 1");

    if ($QueryJuara1 && mysqli_num_rows($QueryJuara1) > 0) {
        $juara1 = mysqli_fetch_assoc($QueryJuara1);
        $posisiTerisi[1] = $juara1['IdPesertaAward'];
    }

    // Query untuk mendapatkan juara 2
    $QueryJuara2 = mysqli_query($db, "SELECT 
        pa.IdPesertaAward,
        pa.NamaPeserta,
        pa.NamaKarya,
        pa.LinkKarya,
        pa.Posisi,
        md.NamaDesa,
        mk.Kecamatan
        FROM desa_award pa
        INNER JOIN master_desa md ON pa.IdDesaFK = md.IdDesa
        INNER JOIN master_kecamatan mk ON md.IdKecamatanFK = mk.IdKecamatan
        WHERE pa.IdKategoriAwardFK = '$IdKategoriAward' 
        AND pa.Posisi = 2
        LIMIT 1");

    if ($QueryJuara2 && mysqli_num_rows($QueryJuara2) > 0) {
        $juara2 = mysqli_fetch_assoc($QueryJuara2);
        $posisiTerisi[2] = $juara2['IdPesertaAward'];
    }

    // Query untuk mendapatkan juara 3
    $QueryJuara3 = mysqli_query($db, "SELECT 
        pa.IdPesertaAward,
        pa.NamaPeserta,
        pa.NamaKarya,
        pa.LinkKarya,
        pa.Posisi,
        md.NamaDesa,
        mk.Kecamatan
        FROM desa_award pa
        INNER JOIN master_desa md ON pa.IdDesaFK = md.IdDesa
        INNER JOIN master_kecamatan mk ON md.IdKecamatanFK = mk.IdKecamatan
        WHERE pa.IdKategoriAwardFK = '$IdKategoriAward' 
        AND pa.Posisi = 3
        LIMIT 1");

    if ($QueryJuara3 && mysqli_num_rows($QueryJuara3) > 0) {
        $juara3 = mysqli_fetch_assoc($QueryJuara3);
        $posisiTerisi[3] = $juara3['IdPesertaAward'];
    }
}

// Debug code removed for production
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo $NamaKategori; ?></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="?pg=SAdmin">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="?pg=AwardView">Award Desa</a>
            </li>
            <li class="breadcrumb-item">
                <a href="?pg=AwardDetail&Kode=<?php echo $IdAward; ?>">Detail Award</a>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <br>
        <a href="?pg=AwardDetail&Kode=<?php echo $IdAward; ?>" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row" style="display: flex; align-items: stretch;">
        <div class="col-lg-4">
            <div class="row">
                <!-- Action Panel -->

                <!-- Info Masa Penjurian
                <div class="col-lg-12">
                    <div class="ibox" style="min-height: 255px;">
                        <div class="ibox-title">
                            <h5>Status Penjurian</h5>
                        </div>
                        <div class="ibox-content" style="min-height: 200px;">
                            <?php if (!empty($MasaPenjurianMulai) && !empty($MasaPenjurianSelesai)): ?>
                                <p><strong>Masa Penjurian:</strong><br>
                                    <?php echo date('d M Y', strtotime($MasaPenjurianMulai)) . ' - ' . date('d M Y', strtotime($MasaPenjurianSelesai)); ?></p>
                            <?php endif; ?>

                            <div class="alert <?php echo $isMasaPenjurian ? 'alert-success' : 'alert-warning'; ?>">
                                <i class="fa <?php echo $isMasaPenjurian ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?>"></i>
                                <strong><?php echo $statusPenjurian; ?></strong>
                                <?php if ($isMasaPenjurian): ?>
                                    <br>Admin dapat memilih pemenang saat ini.
                                <?php else: ?>
                                    <br>Tidak dapat memilih pemenang di luar masa penjurian.
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>



    <!-- Tabel Peserta -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Daftar Peserta</h5>
                    <!-- Label peserta dihapus -->
                </div>
                <div class="ibox-content">
                    <?php if ($totalPeserta > 0 && $QueryPeserta): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="18%">Nama Peserta (Desa)</th>
                                        <th width="20%">Nama Karya</th>
                                        <th width="18%">Link Karya</th>
                                        <th width="12%" class="text-center">Posisi/Juara</th>
                                        <th width="13%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($DataPeserta = mysqli_fetch_assoc($QueryPeserta)) {
                                        $IdPesertaAward = $DataPeserta['IdPesertaAward'];
                                        $NamaPeserta = $DataPeserta['NamaPeserta'];
                                        $NamaKarya = $DataPeserta['NamaKarya'];
                                        $LinkKarya = $DataPeserta['LinkKarya'];
                                        $Posisi = $DataPeserta['Posisi'];
                                        $TanggalSubmit = date('d M Y', strtotime($DataPeserta['TanggalSubmit']));
                                    ?>
                                        <tr <?php echo (!empty($Posisi) && in_array($Posisi, [1, 2, 3])) ? 'class="juara-highlight"' : ''; ?>>
                                            <td class="text-center"><?php echo $no; ?></td>
                                            <td>
                                                <strong><?php echo $NamaPeserta; ?></strong>
                                                <br><small class="text-muted">Submit: <?php echo $TanggalSubmit; ?></small>
                                            </td>
                                            <td>
                                                <span class="text-navy"><?php echo $NamaKarya; ?></span>
                                            </td>
                                            <td>
                                                <?php if (!empty($LinkKarya)): ?>
                                                    <a href="<?php echo $LinkKarya; ?>" target="_blank" class="btn btn-xs btn-success">
                                                        <i class="fa fa-external-link"></i> Lihat Karya
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">Tidak ada link</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (!empty($Posisi)): ?>
                                                    <?php
                                                    switch ($Posisi) {
                                                        case 1:
                                                            echo '<span class="badge" style="background: #FFD700; color: #000;">🥇 Juara 1</span>';
                                                            break;
                                                        case 2:
                                                            echo '<span class="badge" style="background: #C0C0C0; color: #000;">🥈 Juara 2</span>';
                                                            break;
                                                        case 3:
                                                            echo '<span class="badge" style="background: #CD7F32; color: #fff;">🥉 Juara 3</span>';
                                                            break;
                                                        default:
                                                            echo '<span class="text-muted">Tidak Berposisi</span>';
                                                    }
                                                    ?>
                                                <?php else: ?>
                                                    <span class="text-muted">Tidak Berposisi</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($isMasaPenjurian): ?>
                                                    <?php
                                                    // Tentukan class button berdasarkan apakah sudah memiliki posisi atau tidak
                                                    $buttonClass = !empty($Posisi) ? 'btn-success' : 'btn-primary';
                                                    $buttonIcon = !empty($Posisi) ? 'fa-edit' : 'fa-trophy';
                                                    $buttonText = !empty($Posisi) ? 'Edit Posisi' : 'Set Posisi';
                                                    ?>
                                                    <button type="button" class="btn btn-xs <?php echo $buttonClass; ?>"
                                                        onclick="updatePosisi('<?php echo $IdPesertaAward; ?>', '<?php echo addslashes($NamaPeserta); ?>', '<?php echo addslashes($NamaKarya); ?>', '<?php echo $Posisi; ?>', '<?php echo addslashes($LinkKarya); ?>')"
                                                        title="<?php echo $buttonText; ?>">
                                                        <i class="fa <?php echo $buttonIcon; ?>"></i> <?php echo $buttonText; ?>
                                                    </button>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-xs btn-secondary" disabled
                                                        title="Tidak dapat update posisi di luar masa penjurian">
                                                        <i class="fa fa-lock"></i> Terkunci
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center" style="padding: 60px 0;">
                            <i class="fa fa-users" style="font-size: 48px; color: #ddd;"></i>
                            <h3 style="color: #676a6c; margin-top: 20px;">Belum Ada Peserta</h3>
                            <p style="color: #999;">Belum ada desa yang submit karya untuk kategori ini.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Modern styling konsisten dengan AwardDetail.php */
    .wrapper-content {
        background: #f8f9fa;
    }

    .ibox {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border: 2px solid #dee2e6;
        overflow: visible;
        position: relative;
        margin-bottom: 20px;
    }

    .ibox-title {
        background: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid #dee2e6;
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

    /* Table styling dengan tema biru */
    .table th {
        background: #f8f9fa;
        color: #495057;
        font-weight: 600;
        border-top: none;
    }

    .table-striped>tbody>tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }

    .table-hover>tbody>tr:hover {
        background-color: #e9ecef;
    }

    /* Badge dan button styling konsisten */
    .badge-info {
        background-color: #007bff !important;
        color: white !important;
    }

    .badge-primary {
        background-color: #007bff !important;
        color: white !important;
    }

    .btn-primary {
        background-color: #007bff !important;
        border-color: #007bff !important;
    }

    .btn-primary:hover {
        background-color: #0056b3 !important;
        border-color: #0056b3 !important;
    }

    /* Styling untuk juara title */
    .ibox-title h5 strong {
        color: #007bff;
    }

    .ibox-title h5 {
        font-size: 16px;
        font-weight: 500;
    }



    .text-navy {
        color: #007bff !important;
    }

    /* Alert styling */
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }

    .alert-warning {
        background-color: #fff3cd;
        border-color: #ffeaa7;
        color: #856404;
    }

    /* Label styling konsisten dengan tema */
    .label-info {
        background-color: #007bff !important;
        color: white !important;
    }

    /* Style untuk posisi dropdown */
    #updatePosisiDropdown option:disabled {
        background-color: #f8f9fa !important;
        color: #6c757d !important;
        font-style: italic;
    }

    /* Alert styling untuk informasi posisi */
    .alert-info {
        border-left: 4px solid #17a2b8;
        font-size: 13px;
    }

    /* Button variations */
    .btn-success.btn-xs {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success.btn-xs:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    /* Highlight untuk juara yang sudah ditetapkan */
    .juara-highlight {
        background-color: #fff3cd !important;
        border-left: 4px solid #ffc107;
    }

    /* Style untuk modal info */
    .modal .alert-info {
        margin-bottom: 15px;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .ibox {
            margin-bottom: 20px;
        }

        .table-responsive {
            border: none;
        }
        
        .alert-info {
            font-size: 12px;
        }
    }
</style>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="modalEditKategori" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Kategori Award</h4>
            </div>
            <form action="../App/Model/ExcKategoriAward.php?Act=Edit" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="IdKategoriAward" id="editIdKategoriAward">

                    <div class="form-group">
                        <label>Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="NamaKategori" id="editNamaKategori" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi Kategori</label>
                        <textarea name="DeskripsiKategori" id="editDeskripsiKategori" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> <strong>Status Kategori:</strong> Status kategori akan otomatis mengikuti status award induknya.
                        <br>Award saat ini: <strong><?php echo $StatusAward; ?></strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Update Posisi Peserta -->
<div class="modal fade" id="modalUpdatePosisi" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Posisi/Juara</h4>
            </div>
            <form action="../App/Model/ExcPesertaAward.php?Act=UpdatePosisi" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="IdPesertaAward" id="updatePosisiIdPeserta">

                    <div class="form-group">
                        <label>Nama Peserta</label>
                        <input type="text" id="updatePosisiNamaPeserta" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Nama Karya</label>
                        <input type="text" id="updatePosisiNamaKarya" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Link Karya</label>
                        <div class="input-group">
                            <input type="text" id="updatePosisiLinkKarya" class="form-control" readonly>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-success" onclick="window.open(document.getElementById('updatePosisiLinkKarya').value, '_blank')"
                                    id="btnLihatKarya" style="display: none;">
                                    <i class="fa fa-external-link"></i> Lihat
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Posisi/Juara</label>
                        <select name="Posisi" id="updatePosisiDropdown" class="form-control">
                            <!-- Options akan di-generate oleh JavaScript -->
                        </select>
                        <small class="text-muted">
                            <i class="fa fa-info-circle text-info"></i>
                            Hanya tersedia juara 1, 2, dan 3. Setiap posisi hanya bisa dipilih oleh satu peserta.
                            <br><strong>Posisi yang sudah terisi akan ditandai sebagai "Sudah Terisi".</strong>
                        </small>
                    </div>
                    
                    <!-- Informasi posisi yang sudah terisi -->
                    <div class="alert alert-info" style="font-size: 12px;">
                        <strong>Status Posisi Kategori:</strong>
                        <br>
                        <?php if ($juara1): ?>
                            🥇 <strong>Juara 1:</strong> <?php echo htmlspecialchars($juara1['NamaDesa']); ?> - <?php echo htmlspecialchars($juara1['NamaKarya']); ?>
                            <br>
                        <?php else: ?>
                            � <strong>Juara 1:</strong> <span class="text-muted">Belum ada</span>
                            <br>
                        <?php endif; ?>
                        
                        <?php if ($juara2): ?>
                            � <strong>Juara 2:</strong> <?php echo htmlspecialchars($juara2['NamaDesa']); ?> - <?php echo htmlspecialchars($juara2['NamaKarya']); ?>
                            <br>
                        <?php else: ?>
                            🥈 <strong>Juara 2:</strong> <span class="text-muted">Belum ada</span>
                            <br>
                        <?php endif; ?>
                        
                        <?php if ($juara3): ?>
                            🥉 <strong>Juara 3:</strong> <?php echo htmlspecialchars($juara3['NamaDesa']); ?> - <?php echo htmlspecialchars($juara3['NamaKarya']); ?>
                        <?php else: ?>
                            🥉 <strong>Juara 3:</strong> <span class="text-muted">Belum ada</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Posisi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editKategori(id) {
        $.get('../App/Model/ExcKategoriAward.php?Act=GetKategoriData&Kode=' + id, function(data) {
            if (data.error) {
                alert('Error: ' + data.error);
                return;
            }

            $('#editIdKategoriAward').val(data.IdKategoriAward);
            $('#editNamaKategori').val(data.NamaKategori);
            $('#editDeskripsiKategori').val(data.DeskripsiKategori);

            $('#modalEditKategori').modal('show');
        }, 'json');
    }

    function updatePosisi(id, namaPeserta, namaKarya, posisi, linkKarya) {
        $('#updatePosisiIdPeserta').val(id);
        $('#updatePosisiNamaPeserta').val(namaPeserta);
        $('#updatePosisiNamaKarya').val(namaKarya);

        // Handle link karya
        if (linkKarya && linkKarya.trim() !== '') {
            $('#updatePosisiLinkKarya').val(linkKarya);
            $('#btnLihatKarya').show();
        } else {
            $('#updatePosisiLinkKarya').val('Tidak ada link');
            $('#btnLihatKarya').hide();
        }

        // Clear dropdown dan rebuild options berdasarkan posisi yang tersedia
        rebuildPosisiDropdown(id, posisi);

        $('#modalUpdatePosisi').modal('show');
    }

    function rebuildPosisiDropdown(currentPesertaId, currentPosisi) {
        var dropdown = $('#updatePosisiDropdown');
        dropdown.empty();
        
        // Always add "Tidak Mendapat Juara" option
        dropdown.append('<option value="">-- Tidak Mendapat Juara --</option>');
        
        // Data posisi yang sudah terisi dari PHP
        var posisiTerisi = <?php echo json_encode($posisiTerisi); ?>;
        
        // Cek setiap posisi (1, 2, 3)
        for (var i = 1; i <= 3; i++) {
            var isAvailable = true;
            var optionText = '';
            var icon = '';
            
            // Tentukan icon dan text
            switch(i) {
                case 1:
                    icon = '🥇';
                    optionText = 'Juara 1';
                    break;
                case 2:
                    icon = '🥈';
                    optionText = 'Juara 2';
                    break;
                case 3:
                    icon = '🥉';
                    optionText = 'Juara 3';
                    break;
            }
            
            // Cek apakah posisi sudah terisi oleh peserta lain
            if (posisiTerisi[i] && posisiTerisi[i] !== currentPesertaId) {
                isAvailable = false;
            }
            
            // Tambahkan option
            if (isAvailable) {
                var option = $('<option></option>')
                    .attr('value', i)
                    .text(icon + ' ' + optionText);
                dropdown.append(option);
            } else {
                // Jika tidak tersedia, tambahkan option disabled
                var option = $('<option></option>')
                    .attr('value', i)
                    .attr('disabled', true)
                    .text(icon + ' ' + optionText + ' (Sudah Terisi)')
                    .css('color', '#999');
                dropdown.append(option);
            }
        }
        
        // Set current value
        dropdown.val(currentPosisi || '');
    }

    function submitUpdatePosisi() {
        var posisiValue = $('#updatePosisiDropdown').val();
        var namaPeserta = $('#updatePosisiNamaPeserta').val();

        // If no juara selected, just submit
        if (!posisiValue || posisiValue === '') {
            if (confirm('Apakah Anda yakin ingin menghapus posisi juara dari ' + namaPeserta + '?')) {
                return true; // Let form submit normally
            }
            return false;
        }

        // Check if position is disabled (shouldn't happen with proper UI, but just in case)
        var selectedOption = $('#updatePosisiDropdown option:selected');
        if (selectedOption.is(':disabled')) {
            alert('Posisi yang dipilih sudah terisi oleh peserta lain!');
            return false;
        }

        // Confirmation for juara selection
        var juaraText = posisiValue == '1' ? 'Juara 1' : (posisiValue == '2' ? 'Juara 2' : 'Juara 3');
        var icon = posisiValue == '1' ? '🥇' : (posisiValue == '2' ? '🥈' : '🥉');
        
        if (confirm(icon + ' Apakah Anda yakin ingin menetapkan posisi ' + juaraText + ' untuk ' + namaPeserta + '?\n\nCatatan: Posisi ini akan menggantikan posisi sebelumnya jika ada.')) {
            return true; // Let form submit normally
        }
        return false;
    }

    // Override form submission to use our validation
    $(document).ready(function() {
        $('#modalUpdatePosisi form').on('submit', function(e) {
            e.preventDefault();
            if (submitUpdatePosisi()) {
                this.submit();
            }
        });
    });

    function confirmDelete(url, message) {
        if (confirm(message)) {
            window.location.href = url;
        }
    }
</script>