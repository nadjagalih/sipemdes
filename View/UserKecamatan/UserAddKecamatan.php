
<style>
    .status-sukses {
        background: white;
        color: green;
    }

    .status-no-sukses {
        background: white;
        color: red;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data User Kecamatan</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Setting</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>User Kecamatan</strong>
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
                    <h5>Form Input User</h5>
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
                    <form action="../App/Model/ExcUserKecamatan?Act=Save" method="POST" enctype="multipart/form-data">
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Username</label>
                            <div class="col-lg-8">
                                <input type="text" 
                                       name="UserNama" 
                                       id="UserNama" 
                                       data-validation="username-kecamatan"
                                       data-validation-endpoint="UserKecamatan/CheckAvailability.php"
                                       data-validation-target="UserAvailabilityStatus"
                                       data-validation-param="UserNama"
                                       placeholder="Masukkan Username" 
                                       class="form-control" required autocomplete="off">

                            </div>
                        </div>
                        <span id="UserAvailabilityStatus" class="form-text m-b-none"></span>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>