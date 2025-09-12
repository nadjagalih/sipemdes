<?php
$Nomor = 1;
$QueryJabatan = mysqli_query($db, "SELECT * FROM master_jabatan ORDER BY IdJabatan ASC");
while ($DataJabatan = mysqli_fetch_assoc($QueryJabatan)) {
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
        <td>
            <?php
            if ($IdJabatan == 1) { ?>
                <a href="?pg=JabatanEdit&Kode=<?php echo $IdJabatan; ?>">
                    <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>
                </a>
            <?php } else { ?>
                <a href="?pg=JabatanEdit&Kode=<?php echo $IdJabatan; ?>">
                    <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>
                </a>
                <a href="../App/Model/ExcJabatan?Act=Delete&Kode=<?php echo $IdJabatan; ?>" onclick="return confirm('Anda yakin ingin menghapus : <?php echo $Jabatan; ?> ?');">
                    <button class="btn btn-outline btn-danger  btn-xs " data-toggle="tooltip" title="Delete"><i class="fa fa-eraser"></i></button>
                </a>
            <?php } ?>
        </td>
    </tr>
<?php $Nomor++;
}
?>