<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);
    $Nomor = 1;
    $QuerySuamiIstri = mysqli_query($db, "SELECT
hiskel_suami_istri.IdPegawaiFK,
master_pegawai.IdPegawaiFK,
master_pegawai.Nama AS NamaPegawai,
hiskel_suami_istri.IdPendidikanFK,
master_pendidikan.IdPendidikan,
hiskel_suami_istri.IdSuamiIstri,
hiskel_suami_istri.NIK,
hiskel_suami_istri.Nama,
hiskel_suami_istri.Tempat,
hiskel_suami_istri.TanggalLahir,
hiskel_suami_istri.StatusHubungan,
hiskel_suami_istri.TanggalNikah,
master_pendidikan.JenisPendidikan,
hiskel_suami_istri.Pekerjaan
FROM
hiskel_suami_istri
INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = hiskel_suami_istri.IdPegawaiFK
INNER JOIN master_pendidikan ON hiskel_suami_istri.IdPendidikanFK = master_pendidikan.IdPendidikan
WHERE hiskel_suami_istri.IdSuamiIstri = '$IdTemp'");
    $DataSuamiIstri = mysqli_fetch_assoc($QuerySuamiIstri);

    $IdPegawaiFK = $DataSuamiIstri['IdPegawaiFK'];
    $IdSuamiIstri = $DataSuamiIstri['IdSuamiIstri'];
    $NamaPegawai = $DataSuamiIstri['NamaPegawai'];

    $NIK = $DataSuamiIstri['NIK'];
    $Nama = $DataSuamiIstri['Nama'];
    $Tempat = $DataSuamiIstri['Tempat'];

    $TglLahir = $DataSuamiIstri['TanggalLahir'];
    $exp = explode('-', $TglLahir);
    $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

    $Hubungan = $DataSuamiIstri['StatusHubungan'];

    $TglNikah = $DataSuamiIstri['TanggalNikah'];
    $exp = explode('-', $TglNikah);
    $TanggalNikah = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
    $IdPendidikan = $DataSuamiIstri['IdPendidikanFK'];
    $Pendidikan = $DataSuamiIstri['JenisPendidikan'];
    $Pekerjaan = $DataSuamiIstri['Pekerjaan'];
}

?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Suami/Istri</h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Edit Suami/Istri</h5>&nbsp;<span style="font-style: italic; color:red">*) Wajib Diisi</span>
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
                    <form action="../App/Model/ExcPegawaiSuamiIstri?Act=Edit" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="IdSuamiIstri" id="IdSuamiIstri" value="<?php echo $IdSuamiIstri; ?>" class="form-control" readonly>

                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK Suami/Istri<span style="font-style: italic; color:red">*</span></label>
                                    <script>
                                        function hanyaAngka(evt) {
                                            var charCode = (evt.which) ? evt.which : event.keyCode
                                            if (charCode > 31 && (charCode < 48 || charCode > 57))

                                                return false;
                                            return true;
                                        }
                                    </script>
                                    <div class="col-lg-8"><input type="text" name="NIKSuamiIstri" id="NIKSuamiIstri" value="<?php echo $NIK; ?>" class="form-control" placeholder="Masukkan NIK Suami/Istri" autocomplete="off" required onkeypress="return hanyaAngka(event)">
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nama Suami/Istri<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NamaSuamiIstri" id="NamaSuamiIstri" value="<?php echo $Nama; ?>" class="form-control" placeholder="Masukkan Nama Suami/Istri" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Tempat Lahir<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="TempatLahir" id="TempatLahir" value="<?php echo $Tempat; ?>" placeholder="Masukkan Tempat Lahir" class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row" id="TanggalLahir">
                                    <label class="col-lg-3 col-form-label">Tanggal Lahir<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-4">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="TanggalLahir" id="TanggalLahir" value="<?php echo $TanggalLahir; ?>" class="form-control" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <span style="font-style: italic; color:black;">Contoh : 16-01-1980</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Status Hubungan<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <select name="StatusHubungan" id="StatusHubungan" style="width: 100%;" class="select2_hubungan form-control" required>
                                            <option value="<?php echo $Hubungan; ?>"><?php echo $Hubungan; ?></option>
                                            <?php if ($Hubungan == 'Istri') { ?>
                                                <option value="Suami">Suami</option>
                                            <?php } elseif ($Hubungan == 'Suami') { ?>
                                                <option value="Istri">Istri</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row" id="TanggalLahir">
                                    <label class="col-lg-3 col-form-label">Tanggal Nikah<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-4">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="TanggalNikah" id="TanggalNikah" value="<?php echo $TanggalNikah; ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <span style="font-style: italic; color:black;">Contoh : 16-01-1980</span>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Pendidikan<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php include "../App/Control/FunctionSelectPendidikan.php"; ?>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Pekerjaan</label>
                                    <div class="col-lg-8"><input type="text" name="Pekerjaan" id="Pekerjaan" value="<?php echo $Pekerjaan; ?>" placeholder="Masukkan Pekerjaan" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit" name="Edit" id="Edit">Save</button>
                                <a href="?pg=PegawaiDetailSuamiIstri&Kode=<?php echo $IdPegawaiFK; ?>" class="btn btn-success ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>