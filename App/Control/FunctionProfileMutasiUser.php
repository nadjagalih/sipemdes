<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Mutasi</th>
                <th>Jabatan</th>
                <th>Tanggal Mutasi</th>
                <th>Nomor SK <br>SK Mutasi</th>
                <th>Set Mutasi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $IdTemp = $_SESSION['IdUser'];
            $No = 1;
            $QMutasiView = mysqli_query($db, "SELECT
                                        history_mutasi.JenisMutasi,
                                        history_mutasi.IdMutasi,
                                        master_mutasi.Mutasi,
                                        history_mutasi.IdJabatanFK,
                                        master_jabatan.IdJabatan,
                                        master_jabatan.Jabatan,
                                        history_mutasi.NomorSK,
                                        history_mutasi.TanggalMutasi,
                                        history_mutasi.FileSKMutasi,
                                        history_mutasi.Setting,
                                        history_mutasi.KeteranganJabatan,
                                        master_mutasi.IdMutasi AS MasterId,
                                        history_mutasi.IdPegawaiFK
                                        FROM history_mutasi
                                        INNER JOIN master_mutasi ON history_mutasi.JenisMutasi = master_mutasi.IdMutasi
                                        INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                                        WHERE history_mutasi.IdPegawaiFK = '$IdTemp'
                                        ORDER BY history_mutasi.TanggalMutasi DESC");
            while ($DataView = mysqli_fetch_assoc($QMutasiView)) {
                $IdMutasi = $DataView['IdMutasi'];
                $JenisMutasi = $DataView['Mutasi'];
                $Jabatan = $DataView['Jabatan'];
                $TglMutasi = $DataView['TanggalMutasi'];
                $exp = explode('-', $TglMutasi);
                $TanggalMutasi = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
                $NomorSK = $DataView['NomorSK'];
                $SKMutasi = $DataView['FileSKMutasi'];
                $SetMutasi = $DataView['Setting'];
            ?>
                <tr class="gradeX">
                    <td><?php echo $No; ?> </td>
                    <td><?php echo $JenisMutasi; ?> </td>
                    <td><?php echo $Jabatan; ?> </td>
                    <td><?php echo $TanggalMutasi; ?> </td>
                    <td>Nomor SK : <?php echo $NomorSK; ?>
                        <br>
                        <a target='_BLANK' href='../Module/Variabel/Download?File=<?php echo $SKMutasi; ?>'>Lihat File SK</a>
                    </td>

                    <td>
                        <?php if ($SetMutasi == 0) { ?>
                            <span class="label label-warning float-left">NON AKTIF</span>
                        <?php } elseif ($SetMutasi == 1) { ?>
                            <span class="label label-success float-left">AKTIF</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php $No++;
            } ?>
        </tbody>
    </table>
</div>