<?php
// Include security configuration
require_once "../Module/Security/Security.php";

// Use prepared statement for security
$stmt = SQLProtection::prepare($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = ?", [$IdKecamatan]);
$result = SQLProtection::execute($stmt);
$DataHeader = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
$NamaKecamatan = XSSProtection::escape($DataHeader['Kecamatan']);
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
                    <form action="File/ProsesUpload.php" method="POST" enctype="multipart/form-data"
                        onsubmit="return validateFile()">
                        <?php echo CSRFProtection::getTokenField(); ?>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Kategori File</label>
                            <div class="col-lg-8">
                                <select name="kategori" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php
                                    $q = mysqli_query($db, "SELECT * FROM master_file_kategori");
                                    while ($row = mysqli_fetch_assoc($q)) {
                                        echo "<option value='" . XSSProtection::escapeAttr($row['IdFileKategori']) . "'>" . XSSProtection::escape($row['KategoriFile']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Kabupaten</label>
                            <div class="col-lg-8">
                                <input type="text" name="namakabupaten" class="form-control" required readonly
                                    value="Trenggalek">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Kecamatan</label>
                            <div class="col-lg-8">
                                <select name="idkecamatan" id="idkecamatan" class="form-control"
                                    onchange="loadDesa(this.value)">
                                    <option value="">Pilih Kecamatan</option>
                                    <?php
                                    $q = mysqli_query($db, "SELECT * FROM master_kecamatan");
                                    while ($row = mysqli_fetch_assoc($q)) {
                                        echo "<option value='{$row['IdKecamatan']}'>{$row['Kecamatan']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Desa</label>
                            <div class="col-lg-8">
                                <select name="iddesa" id="iddesa" class="form-control">
                                    <option value="">Pilih Desa</option>
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
                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary" type="submit" name="upload">Upload</button>
                                <a href="?pg=FileViewAdmin" class="btn btn-success">Lihat File</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
<script>
    function loadDesa(idKecamatan) {
        if (idKecamatan === "") {
            document.getElementById("iddesa").innerHTML = "<option value=''>Pilih Desa</option>";
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open("GET", "File/get_desa.php?idkecamatan=" + idKecamatan, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("iddesa").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }
</script>