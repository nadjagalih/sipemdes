<!-- SweetAlert2 -->
<link href="../Assets/sweetalert/sweetalert2.min.css" rel="stylesheet">
<script src="../Assets/sweetalert/sweetalert2.min.js"></script>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Desa</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Setting</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Desa</strong>
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
                    <h5>Form Input Desa</h5>
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
                    <form action="../App/Model/ExcDesa?Act=Save" method="POST" enctype="multipart/form-data">
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Kode Desa</label>
                            <div class="col-lg-8"><input type="text" name="KodeDesa" id="KodeDesa" placeholder="Masukkan Kode Desa" class="form-control" required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Desa</label>
                            <div class="col-lg-8"><input type="text" name="Desa" id="Desa" placeholder="Masukkan Desa" class="form-control" required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Kecamatan</label>
                            <div class="col-lg-8">
                                <?php include "../App/Control/FunctionSelectKecamatan.php"; ?>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Kabupaten</label>
                            <div class="col-lg-8">
                                <?php include "../App/Control/FunctionSelectKabupaten.php"; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">
                                <i class="fas fa-phone"></i>
                                No. Telepon
                            </label>
                            <div class="col-lg-8">
                                <input type="text" 
                                    class="form-control" 
                                    name="NoTelepon" 
                                    id="NoTelepon" 
                                    placeholder="Contoh: 0341-123456 / 08123456789" 
                                    required
                                    autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Alamat Desa
                            </label>
                            <div class="col-lg-8">
                                <textarea 
                                    class="form-control" 
                                    name="AlamatDesa" 
                                    id="AlamatDesa" 
                                    rows="3" 
                                    placeholder="Masukkan alamat lengkap desa..." 
                                    required
                                    autocomplete="off"></textarea>
                            </div>
                        </div>

                        <input type="hidden" name="Latitude" id="Latitude" value="">
                        <input type="hidden" name="Longitude" id="Longitude" value="">

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary" type="submit" name="Save" id="Save">Save</button>
                                <a href="?pg=DesaView" class="btn btn-success ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Check for success/error alerts
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const alert = urlParams.get('alert');
        
        if (alert === 'Error') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        }
    });
</script>