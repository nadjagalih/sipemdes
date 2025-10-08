<?php
if (empty($_GET['alert'])) {
    echo "";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'UploadSukses') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Upload Berhasil',
                    text: 'File telah berhasil diupload.',
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

$q = mysqli_query($db, "SELECT TanggalPensiun, IdPegawaiFK, IdFilePengajuanPensiunFK, StatusPensiunDesa, StatusPensiunKecamatan, StatusPensiunKabupaten From master_pegawai p WHERE p.IdPegawaiFK = '$idPegawai'");
$data = mysqli_fetch_assoc($q);

$FilePengajuan = $data['IdFilePengajuanPensiunFK'];
$StatusPensiunDesa = $data['StatusPensiunDesa'];
$StatusPensiunKecamatan = $data['StatusPensiunKecamatan'];
$StatusPensiunKabupaten = $data['StatusPensiunKabupaten'];

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

$tanggalPensiun = $data['TanggalPensiun'];

$tanggalSekarang = date('Y-m-d');

if ($tanggalPensiun <= $tanggalSekarang && $flagTampilkanUpload) {
    ?>

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Ajukan Pensiun</h5>
                <?php
                if ($StatusPensiunDesa === '0') {
                    echo "<span class='label label-danger'>*) Pengajuan Pensiun Ditolak Desa</span>";
                } 
                if ($StatusPensiunKecamatan === '0') {
                    echo "<span class='label label-danger'>*) Pengajuan Pensiun Ditolak Kecamatan</span>";
                }
                if ($StatusPensiunKabupaten === '0') {
                    echo "<span class='label label-danger'>*) Pengajuan Pensiun Ditolak Kabupaten</span>";
                }
                
                ?>
            </div>

            <div class="ibox-content">
                <div class="text-left">
                    <a href="?pg=FileUploadPengajuan">
                        <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                            Upload File
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    echo " ";
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