<?php
$QHeader = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$IdKecamatan'");
$DataHeader = mysqli_fetch_assoc($QHeader);
$NamaKecamatan = $DataHeader['Kecamatan'];
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Upload File Desa</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Dashboard</a></li>
            <li class="breadcrumb-item"><a>Dokumen</a></li>
            <li class="breadcrumb-item active"><strong>Upload File</strong></li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Upload File</h5>
                </div>
                <div class="ibox-content">
                    <form action="UserKecamatan/File/ProsesUploadKecamatan.php" method="POST"
                        enctype="multipart/form-data" onsubmit="return validateFile()">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Kategori File</label>
                            <div class="col-lg-8">
                                <select name="kategori" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php
                                    $q = mysqli_query($db, "SELECT * FROM master_file_kategori");
                                    while ($row = mysqli_fetch_assoc($q)) {
                                        echo "<option value='{$row['IdFileKategori']}'>{$row['KategoriFile']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Kecamatan</label>
                            <div class="col-lg-8">
                                <input type="text" name="namakecamatan" class="form-control" required readonly
                                    value="<?php echo $NamaKecamatan; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Desa</label>
                            <div class="col-lg-8">
                                <select name="iddesa" class="form-control">
                                    <option value="">Pilih Desa</option>
                                    <?php
                                    $q = mysqli_query($db, "SELECT * FROM master_desa
                                    WHERE IdKecamatanFK = '{$_SESSION['IdKecamatan']}'");
                                    while ($row = mysqli_fetch_assoc($q)) {
                                        echo "<option value='{$row['IdDesa']}'>{$row['NamaDesa']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Nama File</label>
                            <div class="col-lg-8">
                                <input type="text" name="namafile" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Upload File</label>
                            <div class="col-lg-8">
                                <input type="file" name="file" class="form-control" accept="application/pdf" required>
                            </div>
                        </div>
                        <input type="hidden" name="idkecamatan" value="<?php echo $_SESSION['IdKecamatan']; ?>">
                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary" type="submit" name="upload">Upload</button>
                                <a href="?pg=FileViewKecamatan" class="btn btn-success">Lihat File</a>
                            </div>
                        </div>
                    </form>
                    <script>
                        function validateFile() {
                            const fileInput = document.querySelector('input[name="file"]');
                            const filePath = fileInput.value;
                            const allowedExtensions = /(\.pdf)$/i;
                            if (!allowedExtensions.exec(filePath)) {
                                alert('Hanya file PDF yang diizinkan.');
                                fileInput.value = '';
                                return false;
                            }
                            return true;
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>