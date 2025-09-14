<?php
session_start();

$_SESSION['NameUser'] = '';
unset($_SESSION['NameUser']);
unset($_SESSION['PassUser']);

session_unset();
session_destroy();
header("location: SignIn?alert=SignOut");
mysqli_close($db);
