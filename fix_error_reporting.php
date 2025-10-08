<?php
/**
 * Script untuk memperbaiki error_reporting yang conflict di semua file PHP
 */

function fixErrorReporting($directory) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory)
    );
    
    $fixes = 0;
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $filepath = $file->getPathname();
            $content = file_get_contents($filepath);
            
            if ($content === false) continue;
            
            // Replace conflicting error_reporting statements
            $patterns = [
                '/error_reporting\(E_ALL \^ E_NOTICE\);\s*[\r\n]+\s*error_reporting\(E_ERROR \| E_WARNING\);/' => 'error_reporting(E_ERROR | E_WARNING | E_PARSE);',
                '/error_reporting\(E_ALL \^ E_NOTICE\);/' => 'error_reporting(E_ERROR | E_WARNING | E_PARSE);'
            ];
            
            $originalContent = $content;
            foreach ($patterns as $pattern => $replacement) {
                $content = preg_replace($pattern, $replacement, $content);
            }
            
            if ($content !== $originalContent) {
                file_put_contents($filepath, $content);
                echo "Fixed: " . $filepath . "\n";
                $fixes++;
            }
        }
    }
    
    return $fixes;
}

// Fix semua file di direktori View
$fixes = fixErrorReporting(__DIR__ . '/View');
echo "Total fixes applied: $fixes\n";
echo "Error reporting standardization completed!\n";
?>