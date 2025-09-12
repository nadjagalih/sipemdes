<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Upload File Pengajuan</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Dashboard</a></li>
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
                    <h5>Form Upload File Pengajuan</h5>
                </div>
                <div class="ibox-content">
                    <form action="UserDesa/FileUpload/ProsesUploadPengajuan.php" method="POST"
                        enctype="multipart/form-data" onsubmit="return validateFile()">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Pilih File</label>
                            <div class="col-lg-8">
                                <input type="file" name="file" class="form-control" accept="application/pdf" required>
                            </div>
                        </div>
                        <input type="hidden" name="idpegawai" value="<?php echo $_SESSION['IdPegawai']; ?>">
                        <input type="hidden" name="iddesa" value="<?php echo $_SESSION['IdDesa']; ?>">
                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary" type="submit" name="upload">Upload</button>
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