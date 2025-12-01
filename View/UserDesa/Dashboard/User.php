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
    ?>
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Ajukan Pensiun</h5>&nbsp;
                <?php
                // Jika file sudah diupload dan menunggu persetujuan desa
                if (!is_null($FilePengajuan) && is_null($StatusPensiunDesa) && is_null($StatusPensiunKecamatan) && is_null($StatusPensiunKabupaten)) {
                    ?>
                    <button type="button" class="btn btn-warning" disabled>*) Menunggu Persetujuan Desa</button>
                    <?php
                }
                // Jika file sudah diupload dan disetujui desa, menunggu persetujuan kecamatan
                elseif (!is_null($FilePengajuan) && $StatusPensiunDesa === '1' && is_null($StatusPensiunKecamatan)) {
                    ?>
                    <button type="button" class="btn btn-info" disabled>*) Menunggu Persetujuan Kecamatan</button>
                    <?php
                }
                // Jika file sudah diupload dan disetujui kecamatan, menunggu persetujuan kabupaten
                elseif (!is_null($FilePengajuan) && $StatusPensiunDesa === '1' && $StatusPensiunKecamatan === '1' && is_null($StatusPensiunKabupaten)) {
                    ?>
                    <button type="button" class="btn btn-info" disabled>*) Menunggu Persetujuan Kabupaten</button>
                    <?php
                }
                // Jika semua sudah disetujui
                elseif (!is_null($FilePengajuan) && $StatusPensiunDesa === '1' && $StatusPensiunKecamatan === '1' && $StatusPensiunKabupaten === '1') {
                    ?>
                    <button type="button" class="btn btn-success" disabled>*) Pengajuan Pensiun Disetujui</button>
                    <?php
                }
                // Jika ada penolakan
                else {
                    if ($StatusPensiunDesa === '0') {
                        echo "<span class='label label-danger'>*) Pengajuan Pensiun Ditolak Desa</span> ";
                    } 
                    if ($StatusPensiunKecamatan === '0') {
                        echo "<span class='label label-danger'>*) Pengajuan Pensiun Ditolak Kecamatan</span> ";
                    }
                    if ($StatusPensiunKabupaten === '0') {
                        echo "<span class='label label-danger'>*) Pengajuan Pensiun Ditolak Kabupaten</span>";
                    }
                }
                ?>
            </div>

            <div class="ibox-content">
                <div class="text-left">
                    <?php
                    // Tampilkan pesan sesuai status
                    if (!is_null($FilePengajuan) && is_null($StatusPensiunDesa) && is_null($StatusPensiunKecamatan) && is_null($StatusPensiunKabupaten)) {
                        echo "<p class='text-muted'>File pengajuan pensiun Anda telah diupload dan sedang menunggu persetujuan dari Desa.</p>";
                    }
                    elseif (!is_null($FilePengajuan) && $StatusPensiunDesa === '1' && is_null($StatusPensiunKecamatan)) {
                        echo "<p class='text-muted'>File pengajuan pensiun Anda telah disetujui Desa dan sedang menunggu persetujuan dari Kecamatan.</p>";
                    }
                    elseif (!is_null($FilePengajuan) && $StatusPensiunDesa === '1' && $StatusPensiunKecamatan === '1' && is_null($StatusPensiunKabupaten)) {
                        echo "<p class='text-muted'>File pengajuan pensiun Anda telah disetujui Desa dan Kecamatan, sedang menunggu persetujuan dari Kabupaten.</p>";
                    }
                    elseif (!is_null($FilePengajuan) && $StatusPensiunDesa === '1' && $StatusPensiunKecamatan === '1' && $StatusPensiunKabupaten === '1') {
                        echo "<p class='text-success'><strong>Pengajuan pensiun Anda telah disetujui oleh Desa, Kecamatan, dan Kabupaten.</strong></p>";
                    }
                    
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