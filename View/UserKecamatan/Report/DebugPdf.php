<?php
// Debug file untuk cek PDF generation
echo "<h3>PDF Debug Information</h3>";

// Check if Html2Pdf exists
$html2pdfPath = __DIR__ . '/../../../Vendor/html2pdf/vendor/autoload.php';
echo "<p><strong>Html2Pdf Path:</strong> " . $html2pdfPath . "</p>";
echo "<p><strong>File Exists:</strong> " . (file_exists($html2pdfPath) ? 'YES' : 'NO') . "</p>";

if (file_exists($html2pdfPath)) {
    try {
        require_once($html2pdfPath);
        echo "<p><strong>Html2Pdf Library:</strong> Loaded successfully</p>";
        
        use Spipu\Html2Pdf\Html2Pdf;
        $testPdf = new Html2Pdf('P', 'A4', 'fr');
        echo "<p><strong>Html2Pdf Instance:</strong> Created successfully</p>";
        
    } catch (Exception $e) {
        echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p><strong>Solution:</strong> Install Html2Pdf library in Vendor/html2pdf/</p>";
}

// Check session
session_start();
echo "<p><strong>Session IdKecamatan:</strong> " . (isset($_SESSION['IdKecamatan']) ? $_SESSION['IdKecamatan'] : 'NOT SET') . "</p>";

// Check database connection
include '../../../Module/Config/Env.php';
if (isset($db)) {
    echo "<p><strong>Database:</strong> Connected</p>";
} else {
    echo "<p><strong>Database:</strong> Not connected</p>";
}
?>
