<?php
if ($_GET['alert'] == 'Sukses') {
    echo
    "<script type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: 'SUKSES',
                      text:  'Sukses Ganti Password, Silahkan Login Ulang',
                      type: 'success',
                      showConfirmButton: true
                     },
                          function(){
                            window.location.href = '../Auth/SignOut';
                          }
                     );
                    },10);
        </script>";
} else
if ($_GET['alert'] == 'Panjang') {
    echo
    "<script type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: 'INFORMATION',
                      text:  'Panjang Minimal Password 5 Karakter',
                      type: 'warning',
                      showConfirmButton: true
                     });
                    },10);
        </script>";
}
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
                <strong>Password</strong>
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
                    <h5>Form Ganti Password</h5>
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
                    <form action="../App/Model/ExcPasswordKec?Act=Pass" method="POST" enctype="multipart/form-data">
                        <input type="hidden" class="form-control" name="IdUser" id="IdUser" value="<?php echo $_SESSION['IdUser']; ?>">
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Password Baru</label>
                            <div class="col-lg-8">
                                <input type="password" class="form-control" name="PasswordBaru" id="PasswordBaru" placeholder="Password Baru" autocomplete="off" required>
                                <span class="form-text m-b-none" style="font-style: italic;">*) Minimal Panjang Password 5 Karakter</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary" type="submit" name="Save" id="Save">Save</button>
                                <a href="?pg=Pass" class="btn btn-success ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>