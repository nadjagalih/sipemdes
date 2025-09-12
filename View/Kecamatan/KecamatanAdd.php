<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Kecamatan</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Setting</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Kecamatan</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-5">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Input Kecamatan</h5>
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
                    <form action="../App/Model/ExcKecamatan?Act=Save" method="POST" enctype="multipart/form-data">
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Kode Kecamatan</label>
                            <div class="col-lg-8"><input type="text" name="KodeKecamatan" id="KodeKecamatan" placeholder="Masukkan Kode Kecamatan" class="form-control" required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Kecamatan</label>
                            <div class="col-lg-8"><input type="text" name="Kecamatan" id="Kecamatan" placeholder="Masukkan Kecamatan" class="form-control" required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Kabupaten</label>
                            <div class="col-lg-8">
                                <?php include "../App/Control/FunctionSelectKabupaten.php"; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary" type="submit" name="Save" id="Save">Save</button>
                                <a href="?pg=KecamatanView" class="btn btn-success ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>