<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);
    $Nomor = 1;
    $QueryAnak = mysqli_query($db, "SELECT
hiskel_anak.IdPegawaiFK,
master_pegawai.IdPegawaiFK,
master_pegawai.Nama AS NamaPegawai,
hiskel_anak.IdPendidikanFK,
master_pendidikan.IdPendidikan,
hiskel_anak.IdAnak,
hiskel_anak.NIK,
hiskel_anak.Nama,
hiskel_anak.Tempat,
hiskel_anak.TanggalLahir,
hiskel_anak.StatusHubungan,
hiskel_anak.JenKel,
master_pendidikan.JenisPendidikan,
hiskel_anak.Pekerjaan
FROM
hiskel_anak
INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = hiskel_anak.IdPegawaiFK
INNER JOIN master_pendidikan ON hiskel_anak.IdPendidikanFK = master_pendidikan.IdPendidikan
WHERE hiskel_anak.IdAnak = '$IdTemp'");
    $DataAnak = mysqli_fetch_assoc($QueryAnak);

    $IdPegawaiFK = $DataAnak['IdPegawaiFK'];
    $IdAnak = $DataAnak['IdAnak'];
    $NamaPegawai = $DataAnak['NamaPegawai'];
    $NIKAnak = $DataAnak['NIK'];
    $NamaAnak = $DataAnak['Nama'];
    $Tempat = $DataAnak['Tempat'];

    $TglLahir = $DataAnak['TanggalLahir'];
    $exp = explode('-', $TglLahir);
    $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

    $Hubungan = $DataAnak['StatusHubungan'];
    $JenKel = $DataAnak['JenKel'];

    $IdPendidikan = $DataAnak['IdPendidikanFK'];
    $Pendidikan = $DataAnak['JenisPendidikan'];
    $Pekerjaan = $DataAnak['Pekerjaan'];
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Anak</h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Edit Anak</h5>&nbsp;<span style="font-style: italic; color:red">*) Wajib Diisi</span>
                </div>
                <div class="ibox-content">
                    <form action="../App/Model/ExcPegawaiAnakAdminDesa?Act=Edit" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="IdAnak" id="IdAnak" value="<?php echo $IdAnak; ?>" class="form-control" readonly>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Anak Dari</label>
                                    <div class="col-lg-8"><input type="text" name="Nama" id="Nama" value="<?php echo $NamaPegawai; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK Anak<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NIKAnak" id="NIKAnak" value="<?php echo $NIKAnak; ?>" class="form-control" placeholder="Masukkan NIK Anak" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nama Anak<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NamaAnak" id="NamaAnak" value="<?php echo $NamaAnak; ?>" class="form-control" placeholder="Masukkan Nama Anak" autocomplete="off" required>
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
                                            <option value="Anak Kandung">Anak Kandung</option>
                                            <option value="Anak Angkat">Anak Angkat</option>
                                            <option value="Anak Tiri">Anak Tiri</option>
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
                                <a href="?pg=PegawaiDetailAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>&tab=tab-3" class="btn btn-success ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>