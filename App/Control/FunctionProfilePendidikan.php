<?php include "../App/Control/FunctionPegawaiEdit.php"; ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Input Pendidikan <span style="font-style: italic; color:red;">* Wajib Diisi</span></h5>
                </div>
                <div class="ibox-content">
                    <form id="formPendidikan" action="../App/Model/ExcPegawaiPendidikanAdminDesa?Act=Save" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="IdPegawaiFK" id="IdPegawaiFK" value="<?php echo $IdPegawaiFK; ?>" class="form-control" readonly>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">NIK</label>
                                    <div class="col-lg-8"><input type="text" name="NIK" id="NIK" value="<?php echo $NIK; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Pendidikan Dari</label>
                                    <div class="col-lg-8"><input type="text" name="Nama" id="Nama" value="<?php echo $Nama; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Pendidikan<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8">
                                        <?php include "../App/Control/FunctionSelectPendidikan.php"; ?>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Tahun Masuk</label>
                                    <div class="col-lg-8"><input type="text" name="TahunMasuk" id="TahunMasuk" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Tahun Keluar</label>
                                    <div class="col-lg-8"><input type="text" name="TahunKeluar" id="TahunKeluar" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nama Sekolah<span style="font-style: italic; color:red">*</span></label>
                                    <div class="col-lg-8"><input type="text" name="NamaSekolah" id="NamaSekolah" class="form-control" placeholder="Masukkan Nama Sekolah" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Jurusan</label>
                                    <div class="col-lg-8"><input type="text" name="Jurusan" id="Jurusan" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Nomer Ijazah</label>
                                    <div class="col-lg-8"><input type="text" name="NomerIjazah" id="NomerIjazah" class="form-control" placeholder="Masukkan Nomer Ijazah" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row" id="TanggalLahir">
                                    <label class="col-lg-3 col-form-label">Tanggal Ijazah</label>
                                    <div class="col-lg-4">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="TanggalIjazah" id="TanggalIjazah" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <span style="font-style: italic; color:black;">Contoh : 16-01-1980</span>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit" name="Save" id="Save">Save</button>
                                <a href="?pg=PegawaiDetailAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>&tab=tab-1" class="btn btn-success">Batal</a>
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
                <th>Tingkat</th>
                <th>Nama Sekolah</th>
                <th>Jurusan</th>
                <th>Thn Masuk - Thn Keluar</th>
                <th>Pendidikan Akhir</th>
                <th>No Ijasah <br>Tanggal Ijasah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
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
                WHERE history_pendidikan.IdPegawaiFK = '$IdTemp'
                ORDER BY
                master_pendidikan.IdPendidikan DESC");
                while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
                    $IdPendidikanV = $DataPendidikan['IdPendidikanPegawai'];
                    $NamaSekolah = $DataPendidikan['NamaSekolah'];
                    $Jurusan = $DataPendidikan['Jurusan'];
                    $JenjangPendidikan = $DataPendidikan['JenisPendidikan'];
                    $Setting = $DataPendidikan['Setting'];
                    $Masuk = $DataPendidikan['TahunMasuk'];
                    $Lulus = $DataPendidikan['TahunLulus'];
                    $NomorIjasah = $DataPendidikan['NomorIjasah'];
                    $TglIjasah = $DataPendidikan['TanggalIjasah'];
                    $exp = explode('-', $TglIjasah);
                    $TanggalIjasah = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            ?>
                    <tr class="gradeX">
                        <td>
                            <?php echo $Nomor; ?>
                        </td>
                        <td>
                            <?php echo $JenjangPendidikan; ?>

                        </td>
                        <td>
                            <?php echo $NamaSekolah; ?>
                        </td>
                        <td>
                            <?php echo $Jurusan; ?>
                        </td>
                        <td>
                            <?php echo $Masuk; ?> - <?php echo $Lulus; ?>
                        </td>
                        <td>
                            <?php if ($Setting == 0) { ?>
                                <span class="label label-warning float-left">NON AKTIF</span>
                                </a><?php } elseif ($Setting == 1) { ?>
                                <span class="label label-success float-left">AKTIF</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php echo $NomorIjasah; ?><br>
                            <?php echo $TanggalIjasah; ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="?pg=PegawaiEditPendidikanAdminDesa&Kode=<?php echo sql_url($IdPendidikanV); ?>" 
                                   class="btn btn-warning btn-sm" title="Edit Data">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="#" onclick="confirmDeletePendidikan('<?php echo $IdPendidikanV; ?>', '<?php echo htmlspecialchars($NamaSekolah); ?>', '<?php echo htmlspecialchars($JenjangPendidikan); ?>', '<?php echo $IdTemp; ?>')" 
                                   class="btn btn-danger btn-sm" title="Hapus Data">
                                    <i class="fa fa-trash"></i> Hapus
                                </a>
                                <?php if ($Setting == 0) { ?>
                                    <a href="../App/Model/ExcPegawaiPendidikanAdminDesa?Act=SettingOn&Kode=<?php echo sql_url($IdPendidikanV); ?>&IdPegawai=<?php echo $IdTemp; ?>" 
                                       class="btn btn-success btn-sm" title="Aktifkan sebagai Pendidikan Akhir">
                                        <i class="fa fa-check"></i> Pilih
                                    </a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
            <?php 
                    $Nomor++;
                }
            } else {
            ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data pendidikan</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<script>
function confirmDeletePendidikan(idPendidikan, namaSekolah, tingkatPendidikan, idPegawai) {
    swal({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus data pendidikan "' + tingkatPendidikan + ' - ' + namaSekolah + '"?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }, function(isConfirm) {
        if (isConfirm) {
            // Redirect to delete action with pegawai ID for proper redirect
            window.location.href = '../App/Model/ExcPegawaiPendidikanAdminDesa?Act=Delete&Kode=' + idPendidikan + '&IdPegawai=' + idPegawai + '&tab=tab-1';
        }
    });
}
</script>