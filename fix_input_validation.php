<?php
/**
 * Script untuk memperbaiki direct $_GET/$_POST access tanpa validasi
 */

function fixInputValidation($directory) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory)
    );
    
    $fixes = 0;
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $filepath = $file->getPathname();
            
            // Skip certain directories/files that might have complex logic
            if (strpos($filepath, 'Vendor') !== false || 
                strpos($filepath, 'vendor') !== false ||
                strpos($filepath, 'fix_') !== false ||
                strpos($filepath, 'remove_') !== false) {
                continue;
            }
            
            $content = file_get_contents($filepath);
            if ($content === false) continue;
            
            $originalContent = $content;
            
            // Fix common $_GET direct access patterns
            $patterns = [
                // Fix simple $_GET comparisons
                '/if\s*\(\s*\$_GET\[\s*[\'"](\w+)[\'"]\s*\]\s*==\s*[\'"](\w+)[\'"]\s*\)/' => 'if (isset($_GET[\'$1\']) && $_GET[\'$1\'] == \'$2\')',
                '/elseif\s*\(\s*\$_GET\[\s*[\'"](\w+)[\'"]\s*\]\s*==\s*[\'"](\w+)[\'"]\s*\)/' => 'elseif (isset($_GET[\'$1\']) && $_GET[\'$1\'] == \'$2\')',
                
                // Fix $_POST direct assignment with validation
                '/\$(\w+)\s*=\s*\$_POST\[\s*[\'"](\w+)[\'"]\s*\];/' => '$$$1 = isset($_POST[\'$2\']) ? sql_injeksi($_POST[\'$2\']) : \'\';',
                '/\$(\w+)\s*=\s*\$_GET\[\s*[\'"](\w+)[\'"]\s*\];/' => '$$$1 = isset($_GET[\'$2\']) ? sql_injeksi($_GET[\'$2\']) : \'\';'
            ];
            
            foreach ($patterns as $pattern => $replacement) {
                $content = preg_replace($pattern, $replacement, $content);
            }
            
            if ($content !== $originalContent) {
                file_put_contents($filepath, $content);
                echo "Fixed input validation: " . basename($filepath) . "\n";
                $fixes++;
            }
        }
    }
    
    return $fixes;
}

// Fix input validation issues
$fixes = fixInputValidation(__DIR__ . '/View');
echo "Total input validation fixes: $fixes\n";

// Also fix some App files
$fixes += fixInputValidation(__DIR__ . '/App');
echo "Total fixes applied: $fixes\n";
echo "Input validation fixes completed!\n";
?>