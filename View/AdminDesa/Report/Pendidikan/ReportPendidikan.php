<?php
$IdDesa = $_SESSION['IdDesa'];

$QueryDesa = mysqli_query($db, "SELECT
master_kecamatan.IdKecamatan,
master_desa.IdKecamatanFK,
master_desa.IdDesa,
master_desa.NamaDesa,
master_kecamatan.Kecamatan
FROM
master_desa
INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
WHERE master_desa.IdDesa ='$IdDesa' ");
$DataDesa = mysqli_fetch_assoc($QueryDesa);
$NamaDesa = $DataDesa['NamaDesa'];
$IdKec = $DataDesa['IdKecamatan'];
$NamaKecamatan = $DataDesa['Kecamatan'];


$QProfile = mysqli_query($db, "SELECT * FROM master_setting_profile_dinas");
$DataProfile = mysqli_fetch_assoc($QProfile);
$Kabupaten = $DataProfile['Kabupaten'];
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Rekap Data Pendidikan Pemerintah Desa</h2>
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
                    <h5>Filter Pemerintah Desa</h5>
                </div>

                <div class="ibox-content">

                    <div class="text-left">
                        <a href="AdminDesa/Report/pdf/PendidikanDesaPdf" target="_BLANK">
                            <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                                Cetak PDF
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
                    <h5>Rekap Data Pendidikan Pemerintah Desa <?php echo $NamaDesa; ?> Kecamatan <?php echo $NamaKecamatan; ?> <br>Kabupaten <?php echo $Kabupaten; ?></h5>
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
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                                    <thead>
                                        <tr align="center">
                                            <th>No</th>
                                            <th>Pendidikan</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $Nomor = 1;
                                        $QueryPendidikan = mysqli_query($db, "SELECT
                                        history_pendidikan.IdPendidikanFK,
                                        history_pendidikan.Setting,
                                        master_pendidikan.IdPendidikan,
                                        master_pendidikan.JenisPendidikan,
                                        history_pendidikan.IdPegawaiFK,
                                        master_pegawai.Setting,
                                        master_pegawai.IdPegawaiFK,
                                        master_pegawai.IdDesaFK,
                                        Count(history_pendidikan.IdPegawaiFK) AS JmlPendidikan,
                                        history_mutasi.Setting AS SettingMut
                                        FROM
                                        history_pendidikan
                                        INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
                                        INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = history_pendidikan.IdPegawaiFK
                                        INNER JOIN history_mutasi ON history_pendidikan.IdPegawaiFK = history_mutasi.IdPegawaiFK
                                        WHERE
                                        history_pendidikan.Setting = 1 AND
                                        master_pegawai.Setting = 1 AND
                                        master_pegawai.IdDesaFK = '$IdDesa' AND
                                        history_mutasi.Setting = 1
                                        GROUP BY
                                        history_pendidikan.IdPendidikanFK
                                        ORDER BY
                                        master_pendidikan.IdPendidikan ASC");
                                        while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
                                            $IdPendidikan = $DataPendidikan['IdPendidikanFK'];
                                            $Pendidikan = $DataPendidikan['JenisPendidikan'];
                                            $Jumlah = $DataPendidikan['JmlPendidikan'];
                                        ?>
                                            <tr class="gradeX">
                                                <td>
                                                    <?php echo $Nomor; ?>
                                                </td>
                                                <td>
                                                    <?php echo $Pendidikan; ?>
                                                </td>
                                                <td align="center">
                                                    <strong><?php echo $Jumlah; ?></strong>
                                                </td>
                                            </tr>
                                        <?php $Nomor++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div id="GrafikPendidikan"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    Highcharts.chart('GrafikPendidikan', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<strong>Grafik Pendidikan Pemerintah Desa <?php echo $NamaDesa; ?> Kecamatan <?php echo $NamaKecamatan; ?> <br>Kabupaten <?php echo $Kabupaten; ?></strong>'
        },
        subtitle: {
            text: 'Statistik Pendidikan'
        },
        xAxis: {
            categories: ['Pendidikan '],
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
            $QueryPendidikan = mysqli_query($db, "SELECT
            history_pendidikan.IdPendidikanFK,
            history_pendidikan.Setting,
            master_pendidikan.IdPendidikan,
            master_pendidikan.JenisPendidikan,
            history_pendidikan.IdPegawaiFK,
            master_pegawai.Setting,
            master_pegawai.IdPegawaiFK,
            master_pegawai.IdDesaFK,
            Count(history_pendidikan.IdPegawaiFK) AS JmlPendidikan,
            history_mutasi.Setting AS SettingMut
            FROM
            history_pendidikan
            INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
            INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = history_pendidikan.IdPegawaiFK
            INNER JOIN history_mutasi ON history_pendidikan.IdPegawaiFK = history_mutasi.IdPegawaiFK
            history_pendidikan.Setting = 1 AND
            master_pegawai.Setting = 1 AND
            master_pegawai.IdDesaFK = '$IdDesa' AND
            history_mutasi.Setting = 1
            GROUP BY
            history_pendidikan.IdPendidikanFK
            ORDER BY
            master_pendidikan.IdPendidikan ASC");
            while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
                $IdPendidikan = $DataPendidikan['IdPendidikanFK'];
                $Pendidikan = $DataPendidikan['JenisPendidikan'];
                $Jumlah = $DataPendidikan['JmlPendidikan'];
            ?> {
                    name: '<?php echo $Pendidikan; ?>',
                    data: [<?php echo $Jumlah; ?>]
                },
            <?php } ?>
        ]
    });
</script>