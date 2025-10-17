<?php
$IdKec = isset($_SESSION['IdKecamatan']) ? $_SESSION['IdKecamatan'] : '';
$QueryKecamatan = mysqli_query($db, "SELECT 
    master_kecamatan.*,
    master_setting_profile_dinas.Kabupaten
    FROM master_kecamatan 
    LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
    WHERE master_kecamatan.IdKecamatan = '$IdKec' ");
$DataQuery = mysqli_fetch_assoc($QueryKecamatan);
$Kecamatan = isset($DataQuery['Kecamatan']) ? $DataQuery['Kecamatan'] : 'Unknown';
$Kabupaten = isset($DataQuery['Kabupaten']) ? $DataQuery['Kabupaten'] : 'Unknown';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data BPD Kecamatan <?php echo $Kecamatan; ?></h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <style>
        /* Custom styling untuk header tabel agar sesuai dengan warna sidebar */
        .dataTables-kecamatan thead th {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            color: white !important;
            font-weight: bold !important;
            text-align: center !important;
            border: 1px solid #1e3c72 !important;
            padding: 12px 8px !important;
        }
        
        .dataTables-kecamatan thead tr {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
        }
        
        /* Override untuk DataTables sorting */
        .dataTables-kecamatan thead th.sorting,
        .dataTables-kecamatan thead th.sorting_asc,
        .dataTables-kecamatan thead th.sorting_desc {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            color: white !important;
        }
        
        /* Styling untuk baris tabel */
        .dataTables-kecamatan tbody tr:hover {
            background-color: #f0f8ff !important;
        }
        
        /* Styling untuk sel tabel */
        .dataTables-kecamatan td {
            border: 1px solid #dee2e6 !important;
            vertical-align: middle !important;
            padding: 8px !important;
        }
        
        /* Override Bootstrap default */
        .table-striped > thead > tr > th {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            color: white !important;
        }
    </style>
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
                            <thead style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
                                <tr style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">No</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Foto</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">NIK</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Nama<br>Alamat</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Tanggal Lahir<br>Jenis Kelamin</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Unit Kerja<br>Kecamatan<br>Kabupaten</th>
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
                                    // Direct data access with validation
                                    $IdPegawaiFK = isset($DataPegawai['IdPegawaiFK']) ? $DataPegawai['IdPegawaiFK'] : '';
                                    $Foto = isset($DataPegawai['Foto']) ? $DataPegawai['Foto'] : '';
                                    $NIK = isset($DataPegawai['NIK']) ? $DataPegawai['NIK'] : '';
                                    $Nama = isset($DataPegawai['Nama']) ? $DataPegawai['Nama'] : '';
                                    
                                    // Date formatting
                                    $TanggalLahir = isset($DataPegawai['TanggalLahir']) ? $DataPegawai['TanggalLahir'] : '';
                                    $ViewTglLahir = !empty($TanggalLahir) ? date('d-m-Y', strtotime($TanggalLahir)) : '';
                                    
                                    $JenKel = isset($DataPegawai['JenKel']) ? $DataPegawai['JenKel'] : '';
                                    $NamaDesa = isset($DataPegawai['NamaDesa']) ? $DataPegawai['NamaDesa'] : '';
                                    $KecamatanData = isset($DataPegawai['Kecamatan']) ? $DataPegawai['Kecamatan'] : '';
                                    $KabupatenData = isset($DataPegawai['Kabupaten']) ? $DataPegawai['Kabupaten'] : '';
                                    $Alamat = isset($DataPegawai['Alamat']) ? $DataPegawai['Alamat'] : '';
                                    $RT = isset($DataPegawai['RT']) ? $DataPegawai['RT'] : '';
                                    $RW = isset($DataPegawai['RW']) ? $DataPegawai['RW'] : '';

                                    $Lingkungan = isset($DataPegawai['Lingkungan']) ? $DataPegawai['Lingkungan'] : '';
                                    $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
                                    $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
                                    $Komunitas = isset($LingkunganBPD['NamaDesa']) ? $LingkunganBPD['NamaDesa'] : '';

                                    $KecamatanBPD = isset($DataPegawai['Kec']) ? $DataPegawai['Kec'] : '';
                                    $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
                                    $KecamatanBPD = mysqli_fetch_assoc($AmbilKecamatan);
                                    $KomunitasKec = isset($KecamatanBPD['Kecamatan']) ? $KecamatanBPD['Kecamatan'] : '';

                                    $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
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
                                            <?php echo htmlspecialchars($NIK); ?>
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($Nama); ?></strong><br><br>
                                            <?php echo htmlspecialchars($Address); ?>
                                        </td>
                                        <td>
                                            <?php echo $ViewTglLahir; ?><br>
                                            <?php
                                            $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                                            $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
                                            $JenisKelamin = isset($DataJenKel['Keterangan']) ? $DataJenKel['Keterangan'] : 'N/A';
                                            echo htmlspecialchars($JenisKelamin);
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($NamaDesa); ?><br>
                                            <?php echo htmlspecialchars($KecamatanData); ?><br>
                                            <?php echo htmlspecialchars($KabupatenData); ?>
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