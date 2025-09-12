<?php
$Nomor = 1;
$QueryMutasi = mysqli_query($db, "SELECT * FROM master_mutasi ORDER BY IdMutasi ASC");
while ($DataMutasi = mysqli_fetch_assoc($QueryMutasi)) {
    $IdMutasi = $DataMutasi['IdMutasi'];
    $Mutasi = $DataMutasi['Mutasi'];
?>
    <tr class="gradeX">
        <td>
            <?php echo $Nomor; ?>
        </td>
        <td>
            <?php echo $Mutasi; ?>
        </td>
        <td>
            <a href="?pg=MutasiEdit&Kode=<?php echo $IdMutasi; ?>">
                <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>
            </a>
            <a href="../App/Model/ExcMutasi?Act=Delete&Kode=<?php echo $IdMutasi; ?>" onclick="return confirm('Anda yakin ingin menghapus : <?php echo $Mutasi; ?> ?');">
                <button class="btn btn-outline btn-danger  btn-xs " data-toggle="tooltip" title="Delete"><i class="fa fa-eraser"></i></button>
            </a>
        </td>
    </tr>
<?php $Nomor++;
}
?>