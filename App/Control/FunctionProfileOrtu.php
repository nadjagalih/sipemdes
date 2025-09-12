<?php include "../App/Control/FunctionPegawaiEdit.php"; ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Input Orang Tua</h5>&nbsp;<span style="font-style: italic; color:red">*) Wajib Diisi</span>
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
                    <form action="../App/Model/ExcPegawaiOrtuAdminDesa?Act=Save" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="IdPegawaiFK" id="IdPegawaiFK" value="<?php echo $IdPegawaiFK; ?>" class="form-control" readonly>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK</label>
                                    <div class="col-lg-8"><input type="text" name="NIK" id="NIK" value="<?php echo $NIK; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Orang Tua Dari</label>
                                    <div class="col-lg-8"><input type="text" name="Nama" id="Nama" value="<?php echo $Nama; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK Orang Tua<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NIKOrtu" id="NIKOrtu" class="form-control" placeholder="Masukkan NIK Orang Tua" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nama Orang Tua<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NamaOrtu" id="NamaOrtu" class="form-control" placeholder="Masukkan Nama Orang Tua" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Tempat Lahir<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="TempatLahir" id="TempatLahir" placeholder="Masukkan Tempat Lahir" class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row" id="TanggalLahir">
                                    <label class="col-lg-3 col-form-label">Tanggal Lahir<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-4">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="TanggalLahir" id="TanggalLahir" class="form-control" required>
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
                                        <select name="JenKel" id="JenKel" style="width: 100%;" class="select2_jenkel form-control" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <?php
                                            $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel ORDER BY IdJenKel ASC");
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
                                            <option value="">Pilih Status Hubungan</option>
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
                                    <div class="col-lg-8"><input type="text" name="Pekerjaan" id="Pekerjaan" placeholder="Masukkan Pekerjaan" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit" name="Save" id="Save">Save</button>
                                <a href="?pg=PegawaiViewOrtuAdminDesa" class="btn btn-success ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
        <thead>
            <tr>
                <th>No</th>
                <th>Orang Tua Dari</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tempat<br>Tanggal Lahir</th>
                <th>Hubungan</th>
                <th>Jenis Kelamin</th>
                <th>Pendidikan</th>
                <th>Pekerjaan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
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
                WHERE hiskel_ortu.IdPegawaiFK = '$IdTemp'");
                while ($DataOrtu = mysqli_fetch_assoc($QueryOrtu)) {
                    $IdOrtu = $DataOrtu['IdOrtu'];
                    $NamaPegawai = $DataOrtu['NamaPegawai'];
                    $NIK = $DataOrtu['NIK'];
                    $Nama = $DataOrtu['Nama'];
                    $Tempat = $DataOrtu['Tempat'];

                    $TglLahir = $DataOrtu['TanggalLahir'];
                    $exp = explode('-', $TglLahir);
                    $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                    $Hubungan = $DataOrtu['StatusHubungan'];
                    $JenKel = $DataOrtu['JenKel'];

                    $Pendidikan = $DataOrtu['JenisPendidikan'];
                    $Pekerjaan = $DataOrtu['Pekerjaan'];

            ?>
                    <tr class="gradeX">
                        <td>
                            <?php echo $Nomor; ?>
                        </td>
                        <td>
                            <?php echo $NamaPegawai; ?>
                        </td>
                        <td>
                            <?php echo $NIK; ?>
                        </td>
                        <td>
                            <?php echo $Nama; ?>
                        </td>
                        <td>
                            <?php echo $Tempat; ?><br>
                            <?php echo $TanggalLahir; ?>
                        </td>
                        <td>
                            <?php echo $Hubungan; ?><br>
                        </td>
                        <td>
                            <?php
                            $QJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                            $DataJenKel = mysqli_fetch_assoc($QJenKel);
                            echo $JenisKelamin = $DataJenKel['Keterangan'];
                            ?>

                        </td>
                        <td>
                            <?php echo $Pendidikan; ?>
                        </td>
                        <td>
                            <?php echo $Pekerjaan; ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="?pg=PegawaiEditOrtuAdminDesa&Kode=<?php echo sql_url($IdOrtu); ?>" 
                                   class="btn btn-warning btn-sm" title="Edit Data">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="#" onclick="confirmDelete('<?php echo $IdOrtu; ?>', '<?php echo htmlspecialchars($Nama); ?>', '<?php echo htmlspecialchars($Hubungan); ?>')" 
                                   class="btn btn-danger btn-sm" title="Hapus Data">
                                    <i class="fa fa-trash"></i> Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
            <?php 
                    $Nomor++;
                }
            } else {
            ?>
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data orang tua</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<script>
function confirmDelete(idOrtu, namaOrtu, statusHubungan) {
    swal({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus data orang tua "' + namaOrtu + ' (' + statusHubungan + ')"?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }, function(isConfirm) {
        if (isConfirm) {
            // Redirect to delete action
            window.location.href = '../App/Model/ExcPegawaiOrtuAdminDesa?Act=Delete&Kode=' + idOrtu;
        }
    });
}
</script>