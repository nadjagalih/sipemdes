<?php
$IdKec = $_SESSION['IdKecamatan'];
$QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$IdKec' ");
$DataQuery = mysqli_fetch_assoc($QueryKecamatan);
$Kecamatan = $DataQuery['Kecamatan'];
?>

<form action="?pg=BPDFilterDesaKec" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Filter Data BPD Desa PerDesa Kecamatan <?php echo htmlspecialchars($Kecamatan); ?></h5>
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
                    <div class=row>
                        <div class="col-lg-6">
                            <div class="form-group row"><label class="col-lg-2 col-form-label">Desa</label>
                                <div class="col-lg-6">
                                    <select name="Desa" id="Desa" style="width: 100%;" class="select2_desa form-control" required>
                                        <option value="">Filter Desa</option>
                                        <?php
                                        $QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdKecamatanFK = '$IdKec' ORDER BY NamaDesa ASC");
                                        while ($RowDesa = mysqli_fetch_assoc($QueryDesa)) {
                                        ?>
                                            <option value="<?php echo isset($RowDesa['IdDesa']) ? htmlspecialchars($RowDesa['IdDesa']) : ''; ?>"> <?php echo isset($RowDesa['NamaDesa']) ? htmlspecialchars($RowDesa['NamaDesa']) : ''; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="Proses" value="Proses" class="btn btn-outline btn-primary">Tampilkan</button>
                            <a href="?pg=ReportBPDKec"><button type="button" class="btn btn-outline btn-primary">Batal</button></a>
                        </div>

                        <div class="col-lg-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTERING -->
    <?php
    if (isset($_POST['Proses'])) {
        $Desa = sql_injeksi($_POST['Desa']);

        $QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa ='$Desa' ");
        $DataDesa = mysqli_fetch_assoc($QueryDesa);
        $NamaDesa = $DataDesa['NamaDesa'];

    ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Hasil Data Filter BPD Desa <?php echo htmlspecialchars($NamaDesa); ?> Kecamatan <?php echo htmlspecialchars($Kecamatan); ?></h5>
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
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>NIK</th>
                                        <th>Nama<br>Alamat</th>
                                        <th>Tanggal Lahir<br>Jenis Kelamin</th>
                                        <th>Unit Kerja<br>Kecamatan<br>Kabupaten</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $Nomor = 1;
                                    $QueryPegawai = mysqli_query($db, "SELECT
                                    master_pegawai_bpd.IdPegawaiFK,
                                    master_pegawai_bpd.Foto,
                                    master_pegawai_bpd.NIK,
                                    master_pegawai_bpd.Nama,
                                    master_pegawai_bpd.TanggalLahir,
                                    master_pegawai_bpd.JenKel,
                                    master_pegawai_bpd.IdDesaFK,
                                    master_pegawai_bpd.Alamat,
                                    master_pegawai_bpd.RT,
                                    master_pegawai_bpd.RW,
                                    master_pegawai_bpd.Lingkungan,
                                    master_pegawai_bpd.Kecamatan AS Kec,
                                    master_pegawai_bpd.Kabupaten,
                                    master_desa.IdDesa,
                                    master_desa.NamaDesa,
                                    master_desa.IdKecamatanFK,
                                    master_kecamatan.IdKecamatan,
                                    master_kecamatan.Kecamatan,
                                    master_kecamatan.IdKabupatenFK,
                                    master_setting_profile_dinas.IdKabupatenProfile,
                                    master_setting_profile_dinas.Kabupaten
                                    FROM master_pegawai_bpd
                                    LEFT JOIN master_desa ON master_pegawai_bpd.IdDesaFK = master_desa.IdDesa
                                    LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                                    LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
                                    where master_desa.IdDesa = '$Desa'
                                    ORDER BY
                                    master_kecamatan.IdKecamatan ASC,
                                    master_desa.NamaDesa ASC");
                                    while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                                        $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
                                        $Foto = $DataPegawai['Foto'];
                                        $NIK = $DataPegawai['NIK'];
                                        $Nama = $DataPegawai['Nama'];
                                        $TanggalLahir = $DataPegawai['TanggalLahir'];
                                        $exp = explode('-', $TanggalLahir);
                                        $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
                                        $JenKel = $DataPegawai['JenKel'];
                                        $NamaDesa = $DataPegawai['NamaDesa'];
                                        $Kecamatan = $DataPegawai['Kecamatan'];
                                        $Kabupaten = $DataPegawai['Kabupaten'];
                                        $Alamat = $DataPegawai['Alamat'];
                                        $RT = $DataPegawai['RT'];
                                        $RW = $DataPegawai['RW'];

                                        $Lingkungan = $DataPegawai['Lingkungan'];
                                        $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
                                        $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
                                        $Komunitas = $LingkunganBPD['NamaDesa'];

                                        $KecamatanBPD = $DataPegawai['Kec'];
                                        $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
                                        $KecamatanBPD = mysqli_fetch_assoc($AmbilKecamatan);
                                        $KomunitasKec = $KecamatanBPD['Kecamatan'];

                                        $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec
                                    ?>

                                        <tr class="gradeX">
                                            <td>
                                                <?php echo htmlspecialchars($Nomor); ?>
                                            </td>

                                            <?php
                                            if (empty($Foto)) {
                                            ?>
                                                <td>
                                                    <a href="?pg=BPDViewFoto&Kode=<?php echo htmlspecialchars($IdPegawaiFK); ?>" title="Edit Foto"><img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/no-image.jpg"></a>
                                                </td>
                                            <?php } else { ?>
                                                <td>
                                                    <a href="?pg=BPDViewFoto&Kode=<?php echo htmlspecialchars($IdPegawaiFK); ?>" title="Edit Foto"><img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/<?php echo htmlspecialchars($Foto); ?>"></a>
                                                </td>
                                            <?php } ?>

                                            <td>
                                                <?php echo htmlspecialchars($NIK); ?>
                                            </td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($Nama); ?></strong><br><br>
                                                <?php echo htmlspecialchars($Address); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($ViewTglLahir); ?><br>
                                                <?php
                                                $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                                                $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
                                                $JenisKelamin = $DataJenKel['Keterangan'];
                                                echo htmlspecialchars($JenisKelamin);
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($NamaDesa); ?><br>
                                                <?php echo htmlspecialchars($Kecamatan); ?><br>
                                                <?php echo htmlspecialchars($Kabupaten); ?>
                                            </td>
                                        </tr>
                                    <?php $Nomor++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</form>