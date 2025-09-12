<?php
if ($EditIdUser == '') {
?>
    <select name="Akses" id="Akses" style="width: 100%;" class="select2_akses form-control" required>
        <option value="">Pilih Hak Akses</option>
        <?php
        $QueryLevel = mysqli_query($db, "SELECT * FROM leveling_user WHERE IdLevelUser <> 1 AND IdLevelUser <> 2 AND IdLevelUser <> 4 AND IdLevelUser <> 5 ORDER BY IdLevelUser ASC");
        while ($DataLevel = mysqli_fetch_assoc($QueryLevel)) {
            $IdLevelUser = $DataLevel['IdLevelUser'];
            $UserLevel = $DataLevel['UserLevel'];
        ?>
            <option value="<?php echo $IdLevelUser; ?>"><?php echo $UserLevel; ?></option>
        <?php }
        ?>
    </select>
<?php } elseif ($EditIdUser <> '') {
?>
    <select name="Akses" id="Akses" style="width: 100%;" class="select2_akses form-control" required>
        <option value="<?php echo $EditIdLevelUserFK; ?>"><?php echo $EditUserLevel; ?></option>
        <?php
        $QueryLevel = mysqli_query($db, "SELECT * FROM leveling_user WHERE IdLevelUser <> '$EditIdLevelUserFK' AND IdLevelUser <> 1 AND IdLevelUser <> 2 AND IdLevelUser <> 4 AND IdLevelUser <> 5 ORDER BY IdLevelUser ASC");
        while ($DataLevel = mysqli_fetch_assoc($QueryLevel)) {
            $IdLevelUser = $DataLevel['IdLevelUser'];
            $UserLevel = $DataLevel['UserLevel'];
        ?>
            <option value="<?php echo $IdLevelUser; ?>"><?php echo $UserLevel; ?></option>
        <?php }
        ?>
    </select>
<?php } ?>