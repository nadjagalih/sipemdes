<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);
    $Nomor = 1;
    $QueryOrtu = mysqli_query($db, "SELECT
hiskel_ortu.IdPegawaiFK,
master_pegawai.IdPegawaiFK,
master_pegawai.Nama AS NamaPegawai,
hiskel_ortu.IdPendidikanFK,
master_pendidikan.IdPendidikan,
hiskel_ortu.IdOrtu,
hiskel_ortu.NIK,
hiskel_ortu.Nama,
hiskel_ortu.Tempat,
hiskel_ortu.TanggalLahir,
hiskel_ortu.StatusHubungan,
hiskel_ortu.JenKel,
master_pendidikan.JenisPendidikan,
hiskel_ortu.Pekerjaan
FROM
hiskel_ortu
INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = hiskel_ortu.IdPegawaiFK
INNER JOIN master_pendidikan ON hiskel_ortu.IdPendidikanFK = master_pendidikan.IdPendidikan
WHERE hiskel_ortu.IdOrtu = '$IdTemp'");
    $DataOrtu = mysqli_fetch_assoc($QueryOrtu);

    $IdPegawaiFK = $DataOrtu['IdPegawaiFK'];
    $IdOrtu = $DataOrtu['IdOrtu'];
    $NamaPegawai = $DataOrtu['NamaPegawai'];
    $NIKOrtu = $DataOrtu['NIK'];
    $NamaOrtu = $DataOrtu['Nama'];
    $Tempat = $DataOrtu['Tempat'];

    $TglLahir = $DataOrtu['TanggalLahir'];
    $exp = explode('-', $TglLahir);
    $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

    $Hubungan = $DataOrtu['StatusHubungan'];
    $JenKel = $DataOrtu['JenKel'];

    $IdPendidikan = $DataOrtu['IdPendidikanFK'];
    $Pendidikan = $DataOrtu['JenisPendidikan'];
    $Pekerjaan = $DataOrtu['Pekerjaan'];
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Orang Tua</h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Edit Orang Tua</h5>&nbsp;<span style="font-style: italic; color:red">*) Wajib Diisi</span>
                </div>
                <div class="ibox-content">
                    <form action="../App/Model/ExcPegawaiOrtuAdminDesa?Act=Edit" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="IdOrtu" id="IdOrtu" value="<?php echo $IdOrtu; ?>" class="form-control" readonly>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Orang Tua Dari</label>
                                    <div class="col-lg-8"><input type="text" name="Nama" id="Nama" value="<?php echo $NamaPegawai; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK Orang Tua<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NIKOrtu" id="NIKOrtu" value="<?php echo $NIKOrtu; ?>" class="form-control" placeholder="Masukkan NIK Orang Tua" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nama Orang Tua<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NamaOrtu" id="NamaOrtu" value="<?php echo $NamaOrtu; ?>" class="form-control" placeholder="Masukkan Nama Orang Tua" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Tempat Lahir<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="TempatLahir" id="TempatLahir" value="<?php echo $Tempat; ?>" placeholder="Masukkan Tempat Lahir" class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row" id="TanggalLahir">
                                    <label class="col-lg-3 col-form-label">Tanggal Lahir</label>
                                    <div class="col-lg-4">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="TanggalLahir" id="TanggalLahir" value="<?php echo $TanggalLahir; ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <span style="font-style: italic; color:black;">Contoh : 16-01-1980</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Jenis Kelamin<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php $QueryJenKelAmbil = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                                        $DataAmbilJenKel = mysqli_fetch_assoc($QueryJenKelAmbil);
                                        $NamaJenKel = $DataAmbilJenKel['Keterangan'];
                                        ?>
                                        <select name="JenKel" id="JenKel" style="width: 100%;" class="select2_jenkel form-control" required>
                                            <option value="<?php echo $JenKel; ?>"><?php echo $NamaJenKel; ?></option>
                                            <?php
                                            $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel <> '$JenKel' ");
                                            while ($DataJenKel = mysqli_fetch_assoc($QueryJenKel)) {
                                                $IdJenKel = $DataJenKel['IdJenKel'];
                                                $JenKel = $DataJenKel['Keterangan'];
                                            ?>
                                                <option value="<?php echo $IdJenKel; ?>"><?php echo $JenKel; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row"><label class="col-lg-3 col-form-label">Status Hubungan<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <select name="StatusHubungan" id="StatusHubungan" style="width: 100%;" class="select2_hubungan form-control" required>
                                            <option value="<?php echo $Hubungan; ?>"><?php echo $Hubungan; ?></option>
                                            <option value="Ayah Kandung">Ayah Kandung</option>
                                            <option value="Ibu Kandung">Ibu Kandung</option>
                                            <option value="Ayah Tiri">Ayah Tiri</option>
                                            <option value="Ibu Tiri">Ibu Tiri</option>
                                            <option value="Ayah Angkat">Ayah Angkat</option>
                                            <option value="Ibu Angkat">Ibu Angkat</option>
                                        </select>
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
                                <a href="?pg=PegawaiDetailAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>&tab=tab-4" class="btn btn-success ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>