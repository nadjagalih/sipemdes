<?php include "../App/Control/FunctionPegawaiEdit.php"; ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Input Anak</h5>&nbsp;<span style="font-style: italic; color:red">*) Wajib Diisi</span>
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
                    <form action="../App/Model/ExcPegawaiAnakAdminDesa?Act=Save" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="IdPegawaiFK" id="IdPegawaiFK" value="<?php echo $IdPegawaiFK; ?>" class="form-control" readonly>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK</label>
                                    <div class="col-lg-8"><input type="text" name="NIK" id="NIK" value="<?php echo $NIK; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Anak Dari</label>
                                    <div class="col-lg-8"><input type="text" name="Nama" id="Nama" value="<?php echo $Nama; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK Anak<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NIKAnak" id="NIKAnak" class="form-control" placeholder="Masukkan NIK Anak" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nama Anak<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NamaAnak" id="NamaAnak" class="form-control" placeholder="Masukkan Nama Anak" autocomplete="off" required>
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
                                    <div class="col-lg-8"><input type="text" name="Pekerjaan" id="Pekerjaan" placeholder="Masukkan Pekerjaan" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit" name="Save" id="Save">Save</button>
                                <a href="?pg=PegawaiDetailAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>&tab=tab-3" class="btn btn-success ">Batal</a>
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
                 <th>Anak Dari</th>
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
                    WHERE hiskel_anak.IdPegawaiFK = '$IdTemp'");
                    while ($DataAnak = mysqli_fetch_assoc($QueryAnak)) {
                        $IdAnak = $DataAnak['IdAnak'];
                        $NamaPegawai = $DataAnak['NamaPegawai'];
                        $NIK = $DataAnak['NIK'];
                        $Nama = $DataAnak['Nama'];
                        $Tempat = $DataAnak['Tempat'];

                        $TglLahir = $DataAnak['TanggalLahir'];
                        $exp = explode('-', $TglLahir);
                        $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                        $Hubungan = $DataAnak['StatusHubungan'];
                        $JenKel = $DataAnak['JenKel'];

                        $Pendidikan = $DataAnak['JenisPendidikan'];
                        $Pekerjaan = $DataAnak['Pekerjaan'];

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
                                 <a href="?pg=PegawaiEditAnakAdminDesa&Kode=<?php echo sql_url($IdAnak); ?>" 
                                    class="btn btn-warning btn-sm" title="Edit Data">
                                     <i class="fa fa-edit"></i> Edit                                </a>
                                 <a href="#" onclick="confirmDeleteAnak('<?php echo $IdAnak; ?>', '<?php echo htmlspecialchars($Nama); ?>', '<?php echo htmlspecialchars($Hubungan); ?>', '<?php echo $IdTemp; ?>')" 
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
                        <td colspan="10" class="text-center">Tidak ada data anak</td>
                    </tr>
                <?php
                }
                ?>
         </tbody>
     </table>
 </div>

<script>
function confirmDeleteAnak(idAnak, namaAnak, statusHubungan, idPegawai) {
    swal({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus data anak "' + namaAnak + ' (' + statusHubungan + ')"?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }, function(isConfirm) {
        if (isConfirm) {
            // Redirect to delete action with pegawai ID for proper redirect
            window.location.href = '../App/Model/ExcPegawaiAnakAdminDesa?Act=Delete&Kode=' + idAnak + '&IdPegawai=' + idPegawai + '&tab=tab-3';
        }
    });
}
</script>