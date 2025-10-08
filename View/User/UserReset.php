<?php
include "../App/Control/FunctionUserEdit.php";
require_once "../Module/Security/Security.php";
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data User</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Setting</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>User</strong>
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
                    <h5>Form Reset Password User</h5>
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
                    <form action="../App/Model/ExcUser?Act=Reset" method="POST" enctype="multipart/form-data">
                        <?php echo CSRFProtection::getTokenField(); ?>
                        <input type="hidden" name="IdUser" id="IdUser" value="<?php echo XSSProtection::escape($EditIdUser); ?>">
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Username</label>
                            <div class="col-lg-8">
                                <input type="text" name="User" id="User" value="<?php echo XSSProtection::escape($EditNameAkses); ?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Password</label>
                            <div class="col-lg-8">
                                <input type="text" name="Pass" id="Pass" value="12345" class="form-control" readonly>
                                <span class="form-text m-b-none" style="font-style: italic;">*) Reset Password Ke Default</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary" type="submit" name="Reset" id="Reset">Save</button>
                                <a href="?pg=UserView" class="btn btn-success ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>