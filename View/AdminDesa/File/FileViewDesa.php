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
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'FileMax') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Upload gagal',
                    text: 'File melebihi 5 MB.',
                    type: 'warning'
                });
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'FileExt') {
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
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Daftar File Desa</h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Data File Desa</h5>
                    <div class="ibox-tools">
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="text-left" style="margin-bottom:15px;">
                        <a href="?pg=FileUploadDesa">
                            <button type="button" class="btn btn-primary" style="width:150px; text-align:center">
                                Upload File
                            </button>
                        </a>
                    </div>
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
                                $downloadDir='../';
                                $IdDesa = $_SESSION['IdDesa'];
                                $Nomor = 1;
                                $q = mysqli_query($db, "SELECT f.*, k.KategoriFile, d.NamaDesa 
                                    FROM file f
                                    JOIN master_file_kategori k ON f.IdFileKategoriFK = k.IdFileKategori
                                    JOIN master_desa d ON f.IdDesaFK = d.IdDesa
                                    WHERE f.IdDesaFK = '$IdDesa'
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
</div>