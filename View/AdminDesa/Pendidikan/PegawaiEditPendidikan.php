<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);
    $Nomor = 1;
    $QueryPendidikan = mysqli_query($db, "SELECT
master_pegawai.IdPegawaiFK,
history_pendidikan.IdPegawaiFK,
history_pendidikan.IdPendidikanFK,
history_pendidikan.IdPendidikanPegawai,
history_pendidikan.NamaSekolah,
history_pendidikan.Jurusan,
history_pendidikan.Setting,
history_pendidikan.TahunMasuk,
history_pendidikan.TahunLulus,
history_pendidikan.NomorIjasah,
history_pendidikan.TanggalIjasah,
master_pendidikan.IdPendidikan,
master_pegawai.NIK,
master_pegawai.Nama,
master_pendidikan.JenisPendidikan
FROM
master_pegawai
INNER JOIN history_pendidikan ON master_pegawai.IdPegawaiFK = history_pendidikan.IdPegawaiFK
INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
WHERE history_pendidikan.IdPendidikanPegawai = '$IdTemp'
ORDER BY
master_pegawai.IdPegawaiFK ASC,
master_pendidikan.IdPendidikan ASC");
    $DataPendidikan = mysqli_fetch_assoc($QueryPendidikan);
    $IdPendidikanV = $DataPendidikan['IdPendidikanPegawai'];
    $NamaSekolah = $DataPendidikan['NamaSekolah'];
    $Jurusan = $DataPendidikan['Jurusan'];
    $Pendidikan = $DataPendidikan['JenisPendidikan'];
    $Setting = $DataPendidikan['Setting'];
    $Masuk = $DataPendidikan['TahunMasuk'];
    $Lulus = $DataPendidikan['TahunLulus'];
    $NamaPegawai = $DataPendidikan['Nama'];
    $NIK = $DataPendidikan['NIK'];
    $IdPendidikan = $DataPendidikan['IdPendidikan'];
    $NomorIjasah = $DataPendidikan['NomorIjasah'];
    $TanggalIjasah = $DataPendidikan['TanggalIjasah'];
    $exp = explode("-", $TanggalIjasah);
    $TglIjasah = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Pendidikan</h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Edit Pendidikan <span style="font-style: italic; color:red;">* Wajib Diisi</span></h5>
                </div>
                <div class="ibox-content">
                    <form action="../App/Model/ExcPegawaiPendidikanAdminDesa?Act=Edit" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="IdPendidikanV" id="IdPendidikanV" value="<?php echo $IdPendidikanV; ?>" class="form-control" readonly>
                            <div class="col-lg-6">
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK</label>
                                    <div class="col-lg-8"><input type="text" name="NIK" id="NIK" value="<?php echo $NIK; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Pendidikan Dari</label>
                                    <div class="col-lg-8"><input type="text" name="Nama" id="Nama" value="<?php echo $NamaPegawai; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Pendidikan<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php include "../App/Control/FunctionSelectPendidikan.php"; ?>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Tahun Masuk</label>
                                    <div class="col-lg-8"><input type="text" name="TahunMasuk" id="TahunMasuk" value="<?php echo $Masuk; ?>" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Tahun Keluar</label>
                                    <div class="col-lg-8"><input type="text" name="TahunKeluar" id="TahunKeluar" value="<?php echo $Lulus; ?>" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nama Sekolah</label>
                                    <div class="col-lg-8"><input type="text" name="NamaSekolah" id="NamaSekolah" value="<?php echo $NamaSekolah; ?>" class="form-control" placeholder="Masukkan Nama Sekolah" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Jurusan</label>
                                    <div class="col-lg-8"><input type="text" name="Jurusan" id="Jurusan" value="<?php echo $Jurusan; ?>" placeholder="Masukkan Jurusan" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nomer Ijazah</label>
                                    <div class="col-lg-8"><input type="text" name="NomerIjazah" id="NomerIjazah" value="<?php echo $NomorIjasah; ?>" class="form-control" placeholder="Masukkan Nomer Ijazah" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row" id="TanggalLahir">
                                    <label class="col-lg-3 col-form-label">Tanggal Ijazah</label>
                                    <div class="col-lg-4">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="TanggalIjazah" id="TanggalIjazah" value="<?php echo $TglIjasah; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <span style="font-style: italic; color:black;">Contoh : 16-01-1980</span>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit" name="Edit" id="Edit">Save</button>
                                <a href="?pg=PegawaiDetailAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>&tab=tab-1" class="btn btn-success ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>