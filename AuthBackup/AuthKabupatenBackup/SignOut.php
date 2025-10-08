<?php
session_start();
require_once "../../Module/Config/Env.php";

$_SESSION['NameUser'] = '';
unset($_SESSION['NameUser']);
unset($_SESSION['PassUser']);

session_unset();
session_destroy();
header("location: SignIn?alert=SignOut");
if (isset($db) && $db) {
    mysqli_close($db);
}
