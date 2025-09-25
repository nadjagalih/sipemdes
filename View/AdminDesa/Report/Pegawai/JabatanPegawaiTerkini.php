<?php
$IdDesa = $_SESSION['IdDesa'];

$QDesaJudul = mysqli_query($db, "SELECT
master_kecamatan.IdKecamatan,
master_desa.IdKecamatanFK,
master_desa.IdDesa,
master_desa.NamaDesa,
master_kecamatan.Kecamatan
FROM
master_desa
INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
WHERE IdDesa= '$IdDesa' ");
$DataDesaJudul = mysqli_fetch_assoc($QDesaJudul);
$NamaDesa = $DataDesaJudul['NamaDesa'];
$NamaKecamatan = $DataDesaJudul['Kecamatan'];

$QProfile = mysqli_query($db, "SELECT * FROM master_setting_profile_dinas");
$DataProfile = mysqli_fetch_assoc($QProfile);
$Kabupaten = $DataProfile['Kabupaten'];
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Rekap Jabatan Pemerintah Desa</h2>
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

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Filter Pemerintah Desa</h5>
            </div>

            <div class="ibox-content">

                <div class="text-left">
                    <a href="AdminDesa/Report/Pdf/JabatanPegawaiDesaPdf" target="_BLANK">
                        <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                            Cetak PDF Desa
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Rekap Pemerintah Desa <?php echo $NamaDesa; ?> Kecamatan <?php echo $NamaKecamatan; ?> <br>Kabupaten <?php echo $Kabupaten; ?></h5>
            </div>

            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                        <thead>
                            <tr align="center">
                                <th rowspan="2">No</th>
                                <th rowspan="2">Jabatan</th>
                                <th rowspan="2">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $Nomor = 1;

                            $QJabatan = mysqli_query($db, "SELECT * FROM master_jabatan ORDER BY IdJabatan");
                            while ($DataJabatan = mysqli_fetch_assoc($QJabatan)) {
                                $IdJabatan = $DataJabatan['IdJabatan'];
                                $Jabatan = $DataJabatan['Jabatan'];
                            ?>

                                <tr class="gradeX">
                                    <td>
                                        <?php echo $Nomor; ?>
                                    </td>
                                    <td>
                                        <?php echo $Jabatan; ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $QMutasi = mysqli_query($db, "SELECT
                                        Count(history_mutasi.IdPegawaiFK) AS Jumlah,
                                        history_mutasi.IdJabatanFK,
                                        history_mutasi.Setting,
                                        master_pegawai.IdPegawaiFK,
                                        master_pegawai.IdDesaFK,
                                        master_pegawai.Setting
                                        FROM
                                        history_mutasi
                                        INNER JOIN master_pegawai ON history_mutasi.IdPegawaiFK = master_pegawai.IdPegawaiFK
                                        WHERE
                                        history_mutasi.Setting = 1 AND
                                        history_mutasi.JenisMutasi <> 3 AND
                                        history_mutasi.JenisMutasi <> 4 AND
                                        history_mutasi.JenisMutasi <> 5 AND
                                        master_pegawai.IdDesaFK = '$IdDesa' AND
                                        history_mutasi.IdJabatanFK = '$IdJabatan' AND
                                        master_pegawai.Setting = 1
                                        GROUP BY
                                        history_mutasi.IdJabatanFK");
                                        while ($Mutasi = mysqli_fetch_assoc($QMutasi)) {
                                            $Jumlah = $Mutasi['Jumlah'];
                                            if ($Jumlah <> 0) {
                                                echo $Jumlah;
                                            } else {
                                                echo "0";
                                            }
                                        }
                                        ?>
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

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Grafik Rekap Pemerintah Desa <?php echo $NamaDesa; ?> Kecamatan <?php echo $NamaKecamatan; ?> <br>Kabupaten <?php echo $Kabupaten; ?></h5>
            </div>

            <div class="ibox-content">
                <div id="GrafikJabatan"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    Highcharts.chart('GrafikJabatan', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<strong>Grafik Pemerintah Desa</strong>'
        },
        subtitle: {
            text: 'Pemerintah Desa Berdasarkan Jabatan'
        },
        xAxis: {
            categories: ['Jabatan '],
            crosshair: false
        },

        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah (Perangkat)'
            }
        },

        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    fontSize: '8px',
                    fontFamily: 'Tahoma',
                    rotation: -0,
                    align: 'center',
                    formatnumber: '{point.y:.0f}',
                    y: 0
                    /*format: '{point.y:.1f}%'*/
                }
            }
        },
        series: [
            <?php
            $QJabatan = mysqli_query($db, "SELECT
            Count(history_mutasi.IdPegawaiFK) AS JumlahJabatan,
            history_mutasi.IdJabatanFK,
            history_mutasi.Setting,
            master_pegawai.IdPegawaiFK,
            master_pegawai.IdDesaFK,
            master_pegawai.Setting,
            master_jabatan.IdJabatan,
            master_jabatan.Jabatan
            FROM
            history_mutasi
            INNER JOIN master_pegawai ON history_mutasi.IdPegawaiFK = master_pegawai.IdPegawaiFK
            INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
            WHERE
            history_mutasi.Setting = 1 AND
            history_mutasi.JenisMutasi <> 3 AND
            history_mutasi.JenisMutasi <> 4 AND
            history_mutasi.JenisMutasi <> 5 AND
            master_pegawai.IdDesaFK = '$IdDesa' AND
            master_pegawai.Setting = 1
            GROUP BY
            history_mutasi.IdJabatanFK");
            while ($DataJabatan = mysqli_fetch_assoc($QJabatan)) {
                $Jabatan = $DataJabatan['Jabatan'];
                $JmlJabatan = $DataJabatan['JumlahJabatan'];
            ?> {
                    name: '<?php echo $Jabatan; ?>',
                    data: [<?php echo $JmlJabatan; ?>]
                },
            <?php } ?>
        ]
    });
</script>