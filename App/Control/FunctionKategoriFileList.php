<?php
$Nomor = 1;
$QueryKategoriFile = mysqli_query($db, "SELECT * FROM master_file_kategori ORDER BY IdFileKategori ASC");
while ($DataKategoriFile = mysqli_fetch_assoc($QueryKategoriFile)) {
    $IdFileKategori = $DataKategoriFile['IdFileKategori'];
    $KategoriFile = $DataKategoriFile['KategoriFile'];
    ?>
    <tr class="gradeX">
        <td>
            <?php echo $Nomor; ?>
        </td>
        <td>
            <?php echo $KategoriFile; ?>
        </td>
        <td>
            <a href="?pg=FileKategoriEdit&Kode=<?php echo $IdFileKategori; ?>">
                <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Edit"><i
                        class="fa fa-edit"></i></button>
            </a>
            <a href="../App/Model/ExcKategoriFile?Act=Delete&Kode=<?php echo $IdFileKategori; ?>"
                onclick="return confirm('Anda yakin ingin menghapus : <?php echo $KategoriFile; ?> ?');">
                <button class="btn btn-outline btn-danger  btn-xs " data-toggle="tooltip" title="Delete"><i
                        class="fa fa-eraser"></i></button>
            </a>

        </td>
    </tr>
    <?php $Nomor++;
}
?>