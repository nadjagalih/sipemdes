<?php
$IdKec = $_SESSION['IdKecamatan'];
$QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$IdKec' ");
$DataQuery = mysqli_fetch_assoc($QueryKecamatan);
$Kecamatan = $DataQuery['Kecamatan'];
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data BPD Kecamatan <?php echo $Kecamatan; ?></h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Filter BPD</h5>
                </div>

                <div class="ibox-content">

                    <div class="text-left">
                        <a href="?pg=BPDFilterDesaKec">
                            <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                                Filter Desa
                            </button>
                        </a>
                        <a href="?pg=BPDPDFFilterDesaKec">
                            <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                                PDF Desa
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Data BPD Kabupaten <?php echo $Kabupaten; ?></h5>
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
                                    WHERE
                                    master_kecamatan.IdKecamatan = '$IdKec'
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
                                            <?php echo $Nomor; ?>
                                        </td>

                                        <?php
                                        if (empty($Foto)) {
                                        ?>
                                            <td>
                                                <a href="?pg=BPDViewFoto&Kode=<?php echo $IdPegawaiFK; ?>" title="Edit Foto"><img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/no-image.jpg"></a>
                                            </td>
                                        <?php } else { ?>
                                            <td>
                                                <a href="?pg=BPDViewFoto&Kode=<?php echo $IdPegawaiFK; ?>" title="Edit Foto"><img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/<?php echo $Foto; ?>"></a>
                                            </td>
                                        <?php } ?>

                                        <td>
                                            <?php echo $NIK; ?>
                                        </td>
                                        <td>
                                            <strong><?php echo $Nama; ?></strong><br><br>
                                            <?php echo $Address; ?>
                                        </td>
                                        <td>
                                            <?php echo $ViewTglLahir; ?><br>
                                            <?php
                                            $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                                            $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
                                            $JenisKelamin = $DataJenKel['Keterangan'];
                                            echo $JenisKelamin;
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $NamaDesa; ?><br>
                                            <?php echo $Kecamatan; ?><br>
                                            <?php echo $Kabupaten; ?>
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
</div>