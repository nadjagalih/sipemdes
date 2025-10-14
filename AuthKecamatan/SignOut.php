<?php
session_start();
require_once "../Module/Config/Env.php";

// Clear all session data
$_SESSION['NameUser'] = '';
unset($_SESSION['NameUser']);
unset($_SESSION['PassUser']);

session_unset();
session_destroy();

// Prevent browser caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Close database connection if exists
if (isset($db) && $db) {
    mysqli_close($db);
}

// Direct redirect to login page without countdown
if (!headers_sent()) {
    header("Location: SignIn.php");
    exit();
}

// Fallback JavaScript redirect if headers already sent
?>
<script>
    // Clear browser storage
    if (typeof(Storage) !== "undefined") {
        sessionStorage.clear();
        localStorage.clear();
    }
    
    // Prevent back button
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
    
    // Immediate redirect
    window.location.replace("SignIn.php");
</script>
<?php exit(); ?>
