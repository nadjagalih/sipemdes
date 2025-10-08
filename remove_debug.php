<?php
/**
 * Script untuk menghapus debug code di production
 */

function removeDebugCode($directory) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory)
    );
    
    $fixes = 0;
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $filepath = $file->getPathname();
            $content = file_get_contents($filepath);
            
            if ($content === false) continue;
            
            $originalContent = $content;
            
            // Remove various debug statements
            $patterns = [
                '/echo\s+["\']<!--.*?Debug.*?-->["\'];?\s*[\r\n]*/' => '// Debug code removed for production' . "\n",
                '/echo\s+"<!--.*?Debug.*?-->";?\s*[\r\n]*/' => '// Debug code removed for production' . "\n",
                '/echo\s+\'<!--.*?Debug.*?-->\';?\s*[\r\n]*/' => '// Debug code removed for production' . "\n",
                '/if\s*\(\s*\$debugMode\s*\)\s*echo.*?;[\r\n]*/' => '// Debug mode code removed for production' . "\n",
                '/if\s*\(\s*\$debugMode\s*\)\s*error_log.*?;[\r\n]*/' => '// Debug error log removed for production' . "\n",
                '/error_log\s*\(\s*["\']Query error.*?["\'].*?\);[\r\n]*/' => '// Error log removed for production' . "\n"
            ];
            
            foreach ($patterns as $pattern => $replacement) {
                $content = preg_replace($pattern, $replacement, $content);
            }
            
            if ($content !== $originalContent) {
                file_put_contents($filepath, $content);
                echo "Debug removed: " . basename($filepath) . "\n";
                $fixes++;
            }
        }
    }
    
    return $fixes;
}

// Remove debug code dari semua file
$fixes = removeDebugCode(__DIR__);
echo "Total debug removals: $fixes\n";
echo "Debug code cleanup completed!\n";
?>