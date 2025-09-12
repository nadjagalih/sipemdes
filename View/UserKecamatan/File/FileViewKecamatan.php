<?php
if (empty($_GET['alert'])) {
    echo "";
} elseif ($_GET['alert'] == 'UploadSukses') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Upload Berhasil',
                    text: 'File telah berhasil diupload.',
                    type: 'success'
                });
            }, 100);
          </script>";
} elseif ($_GET['alert'] == 'FileMax') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Upload gagal',
                    text: 'File melebihi 5 MB.',
                    type: 'warning'
                });
            }, 100);
          </script>";
} elseif ($_GET['alert'] == 'FileExt') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Upload gagal',
                    text: 'Tipe File Tidak Didukung (hanya file pdf).',
                    type: 'warning'
                });
            }, 100);
          </script>";
}

$IdKecamatan = $_SESSION['IdKecamatan'];

$QHeader = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$IdKecamatan'");
$DataHeader = mysqli_fetch_assoc($QHeader);
$NamaKecamatanHeader = $DataHeader['Kecamatan'];

?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Daftar File Kecamatan <?php echo $NamaKecamatanHeader ?></h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Upload File Kecamatan <?php echo $NamaKecamatanHeader ?></h5>
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
                <div class="text-left" style="margin-bottom:15px;">
                    <a href="?pg=FileUploadKecamatan">
                        <button type="button" class="btn btn-primary" style="width:150px; text-align:center">
                            Upload File
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- File Kecamatan -->
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Data File Kecamatan <?php echo $NamaKecamatanHeader ?></h5>
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
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Kategori</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $downloadDir = '../';
                            $IdKecamatan = $_SESSION['IdKecamatan'];
                            $Nomor = 1;
                            $q = mysqli_query($db, "SELECT f.*, k.KategoriFile, f.IdLevelFileFK
                                    FROM file f
                                    JOIN master_file_kategori k ON f.IdFileKategoriFK = k.IdFileKategori
                                    WHERE f.IdKecamatanFK = '{$IdKecamatan}'
                                    AND f.IdLevelFileFK = 2
                                    ORDER BY f.IdFile DESC");
                            while ($row = mysqli_fetch_assoc($q)) {
                                echo "<tr>
                                        <td>{$Nomor}</td>
                                        <td>{$row['Nama']}</td>
                                        <td>{$row['KategoriFile']}</td>
                                        <td><a href='{$downloadDir}Module/File/Download.php?id={$row['IdFile']}' target='_blank'>Download</a></td>
                                    </tr>";
                                $Nomor++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- File Desa di Kecamatan -->
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Data File Desa Kecamatan <?php echo $NamaKecamatanHeader ?></h5>
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
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Kategori</th>
                                <th>Desa</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $downloadDir = '../';
                            $IdKecamatan = $_SESSION['IdKecamatan'];
                            $Nomor = 1;
                            $q = mysqli_query($db, "SELECT f.*, k.KategoriFile, d.NamaDesa, f.IdLevelFileFK
                                    FROM file f
                                    JOIN master_file_kategori k ON f.IdFileKategoriFK = k.IdFileKategori
                                    JOIN master_desa d ON f.IdDesaFK = d.IdDesa
                                    WHERE d.IdKecamatanFK = '{$IdKecamatan}' 
                                    AND f.IdLevelFileFK = 3
                                    ORDER BY f.IdFile DESC");
                            while ($row = mysqli_fetch_assoc($q)) {
                                echo "<tr>
                                        <td>{$Nomor}</td>
                                        <td>{$row['Nama']}</td>
                                        <td>{$row['KategoriFile']}</td>
                                        <td>{$row['NamaDesa']}</td>
                                        <td><a href='{$downloadDir}Module/File/Download.php?id={$row['IdFile']}' target='_blank'>Download</a></td>
                                    </tr>";
                                $Nomor++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>