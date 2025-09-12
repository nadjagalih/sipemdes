<?php
include "../App/Control/FunctionProfileDinasView.php";

if ($_GET['alert'] == 'Edit') {
    echo
        "<script type='text/javascript'>
        setTimeout(function () {
            swal({
                title: '',
                text:  'Data Berhasil Dirubah',
                type: 'warning',
                showConfirmButton: true
            });
        },10);
    </script>";
}
?>

<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInUp">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="m-b-md">
                                <a href="?pg=ProfileDinasEdit" class="btn btn-primary float-right">Edit Setting</a>
                                <h2><b>Profile Dinas</b></h2>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-right">
                                    <dt>ID Profile :</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1"><?php echo $IdKabupaten; ?></dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-right">
                                    <dt>Kabupaten :</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1"><?php echo $Kabupaten; ?></dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-right">
                                    <dt>Perangkat Daerah :</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1 text-navy"><?php echo $Dinas; ?></dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-right">
                                    <dt>Alamat :</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1"><?php echo $Alamat; ?></dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>