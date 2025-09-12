<?php
include "../App/Control/FunctionProfileDinasView.php";
?>
<div class="col-lg-12">
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Edit Profile Dinas</h5>
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
            <form action="../App/Model/ExcProfileDinas?Act=Edit" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="IdKabupaten" id="IdKabupaten" value="<?php echo $IdKabupaten; ?>">
                <div class="form-group row"><label class="col-lg-2 col-form-label">Kabupaten</label>
                    <div class="col-lg-2"><input type="text" name="Kabupaten" id="Kabupaten" value="<?php echo $Kabupaten; ?>" class="form-control" placeholder="Masukkan Kabupaten" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row"><label class="col-lg-2 col-form-label">Dinas</label>
                    <div class="col-lg-10"><input type="text" name="Dinas" id="Dinas" value="<?php echo $Dinas; ?>" class="form-control" placeholder="MAsukkan Nama Dinas" autocomplete="off" required></div>
                </div>
                <div class="form-group row"><label class="col-lg-2 col-form-label">Alamat</label>
                    <div class="col-lg-10">
                        <textarea name="Alamat" id="Alamat" class="form-control" style="height: 100px;" autocomplete="off"><?php echo $Alamat; ?></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-primary" type="submit" name="Edit" id="Edit">Save</button>
                        <a href="?pg=ProfileDinasView" class="btn btn-success ">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>