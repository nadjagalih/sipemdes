<?php include "../App/Control/FunctionPegawaiEdit.php"; ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Input Suami/Istri</h5>&nbsp;<span style="font-style: italic; color:red">*) Wajib Diisi</span>
                </div>
                <div class="ibox-content">
                    <form action="../App/Model/ExcPegawaiSuamiIstriAdminDesa?Act=Save" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="IdPegawaiFK" id="IdPegawaiFK" value="<?php echo $IdPegawaiFK; ?>" class="form-control" readonly>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK</label>
                                    <div class="col-lg-8"><input type="text" name="NIK" id="NIK" value="<?php echo $NIK; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nama</label>
                                    <div class="col-lg-8"><input type="text" name="Nama" id="Nama" value="<?php echo $Nama; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK Suami/Istri<span style="font-style: italic; color:red">*</span></label>
                                    <script>
                                        function hanyaAngka(evt) {
                                            var charCode = (evt.which) ? evt.which : event.keyCode
                                            if (charCode > 31 && (charCode < 48 || charCode > 57))

                                                return false;
                                            return true;
                                        }
                                    </script>
                                    <div class="col-lg-8"><input type="text" name="NIKSuamiIstri" id="NIKSuamiIstri" class="form-control" placeholder="Masukkan NIK Suami/Istri" autocomplete="off" required onkeypress="return hanyaAngka(event)">
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nama Suami/Istri<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NamaSuamiIstri" id="NamaSuamiIstri" class="form-control" placeholder="Masukkan Nama Suami/Istri" autocomplete="off" required>
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
                                            <input type="text" name="TanggalLahir" id="TanggalLahir" class="form-control" value="" required>
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
                                            <option value="">Pilih Status Hubungan</option>
                                            <option value="Suami">Suami</option>
                                            <option value="Istri">Istri</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row" id="TanggalLahir">
                                    <label class="col-lg-3 col-form-label">Tanggal Nikah<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-4">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="TanggalNikah" id="TanggalNikah" class="form-control" required>
                                        </div>
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
                                <a href="?pg=PegawaiViewSuamiIstriAdminDesa" class="btn btn-success ">Batal</a>
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
                <th>NIK</th>
                <th>Nama</th>
                <th>Tempat<br>Tanggal Lahir</th>
                <th>Hubungan<br>Tanggal Nikah</th>
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
                $QuerySuamiIstri = mysqli_query($db, "SELECT
                hiskel_suami_istri.IdPegawaiFK,
                master_pegawai.IdPegawaiFK,
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
                WHERE
                hiskel_suami_istri.IdPegawaiFK = '$IdTemp'");
                while ($DataSuamiIstri = mysqli_fetch_assoc($QuerySuamiIstri)) {
                    $IdSuamiIstri = $DataSuamiIstri['IdSuamiIstri'];
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

                    $Pendidikan = $DataSuamiIstri['JenisPendidikan'];
                    $Pekerjaan = $DataSuamiIstri['Pekerjaan'];

            ?>
            
                    <tr class="gradeX">
                        <td>
                            <?php echo $Nomor; ?>
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
                            <?php echo $TanggalNikah; ?>
                        </td>
                        <td>
                            <?php echo $Pendidikan; ?>
                        </td>
                        <td>
                            <?php echo $Pekerjaan; ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="?pg=PegawaiEditSuamiIstriAdminDesa&Kode=<?php echo sql_url($IdSuamiIstri); ?>" 
                                   class="btn btn-warning btn-sm" title="Edit Data">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="#" onclick="confirmDeleteSuamiIstri('<?php echo $IdSuamiIstri; ?>', '<?php echo htmlspecialchars($Nama); ?>', '<?php echo $IdTemp; ?>')" 
                                   class="btn btn-danger btn-sm" title="Hapus Data">
                                    <i class="fa fa-trash"></i> Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
            <?php $Nomor++;
                }
            } else {
            ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data suami/istri</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<script>
function confirmDeleteSuamiIstri(idSuamiIstri, nama, idPegawai) {
    swal({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus data suami/istri "' + nama + '"?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }, function(isConfirm) {
        if (isConfirm) {
            // Redirect to delete action with pegawai ID for proper redirect
            window.location.href = '../App/Model/ExcPegawaiSuamiIstriAdminDesa?Act=Delete&Kode=' + idSuamiIstri + '&IdPegawai=' + idPegawai + '&tab=tab-2';
        }
    });
}
</script>