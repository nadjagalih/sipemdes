<!-- PREVIEW UPLOAD FOTO -->
<style>
    .error {
        background-color: #F44336;
        color: #FFFFFF;
        font-weight: bold;
        padding: 10px;
    }

    .warning {
        background-color: #E65100;
        color: #FFFFFF;
        font-weight: bold;
        padding: 10px;
    }
</style>
<script>
    $(function() {
        $("#FileFoto").change(function() {
            $("#pesan").empty(); // To remove the previous error pesan
            var file = this.files[0];
            var imagefile = file.type;
            var match = ["image/jpeg", "image/png", "image/jpg"];

            if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
                $("#FileFoto").css("color", "red");
                $('#see').attr('src', '');
                $("#pesan").html("<p class='error'>File Yang Diijinkan : jpeg, jpg dan png</p>");
                return false;
            } else {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);

                // for validate image size
                var limit = 2000000; //2MB ==> 1.048.576 bytes = 1MB;
                if (this.files[0].size > limit) {
                    $("#pesan").html('<p class="warning">Ukuran Foto Maximal 2MB!</p>');
                    $("#FileFoto").css("color", "red");
                }
            }
        });
    });

    function imageIsLoaded(e) {
        $("#FileFoto").css("color", "green");
        //$('#image_preview').css("display", "block");
        $('#see').attr('src', e.target.result);
        $('#see').attr('width', '190px');
        $('#see').attr('height', '190px');
    };
</script>
<!-- SELESAI PREVIEW UPLOAD FOTO -->

<?php include "../App/Control/FunctionPegawaiEdit.php"; ?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Foto</h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Input</h5>
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
                        <div class="col-sm-6 b-r">
                            <h3 class="m-t-none m-b">Masukkan Foto</h3>
                            <form action="../App/Model/ExcPegawai?Act=Foto" method="POST" enctype="multipart/form-data">
                                <p><input type="hidden" name="IdPegawaiFK" id="IdPegawaiFK" value="<?php echo $IdPegawaiFK; ?>" class="form-control" readonly></p>
                                <input type="hidden" name="NamaLama" id="NamaLama" value="<?php echo $Foto; ?>" readonly>

                                <!-- PREVIEW UPLOAD FOTO -->
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Foto</label>
                                    <div class="col-lg-8">
                                        <div class="custom-file">
                                            <input type="file" name="FUpload" id="FileFoto" accept="image/*" class="custom-file-input" autofocus>
                                            <label for="FotoUpload" class="custom-file-label">Pilih File : png/jpg/jpeg</label>
                                        </div>
                                        <span class="form-text m-b-none" style="font-style: italic;">*) Ukuran File Max 5 MB</span>
                                    </div>
                                </div>
                                <!-- SELESAI PREVIEW UPLOAD FOTO -->

                                <div>
                                    <button class="btn btn-primary" type="submit" name="Foto" id="Foto">Save</button>
                                    <a href="?pg=PegawaiViewAll" class="btn btn-success ">Batal</a>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-3">
                            <h4>Foto Saat Ini</h4>
                            <p>
                                <!-- PREVIEW UPLOAD FOTO -->
                                <div class="form-group row"><label class="col-lg-3 col-form-label"></label>
                                    <div class="col-lg-8">
                                        <?php if (empty($Foto)) { ?>
                                            <img style="width:190px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/no-image.jpg">
                                        <?php } else { ?>
                                            <img style="width:190px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/<?php echo $Foto; ?>">
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- SELESAI PREVIEW UPLOAD FOTO -->
                            </p>
                        </div>
                        <div class="col-sm-3">
                            <h4>Preview</h4>
                            <p>
                                <!-- PREVIEW UPLOAD FOTO -->
                                <div class="form-group row"><label class="col-lg-3 col-form-label"></label>
                                    <div class="col-lg-8">
                                        <div id="pesan"></div>
                                        <img id="see" />
                                    </div>
                                </div>
                                <!-- SELESAI PREVIEW UPLOAD FOTO -->
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>