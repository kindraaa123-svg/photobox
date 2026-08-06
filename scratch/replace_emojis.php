<?php

$dir = __DIR__ . '/../resources/views';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

// Specific emojis to remove/replace
$replacements = [
    '👋' => '',
    '📸' => '',
    '👥' => '',
    '🖼️' => '',
    '🖼' => '',
    '📷' => '',
    '✨' => '',
    '🛡️' => '',
    '🛡' => '',
    '⚠️' => 'Warning:',
    '⚠️' => 'Warning:', // also catch without variation selector if any
    '⚠' => 'Warning:',
    '✅' => 'Success:',
    '📁' => '',
    '🎨' => '',
    '💖' => '',
    '🧁' => '',
];

foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getPathname();
        $content = file_get_contents($path);
        
        $original = $content;
        foreach ($replacements as $emoji => $replacement) {
            $content = str_replace($emoji, $replacement, $content);
        }
        
        if ($content !== $original) {
            file_put_contents($path, $content);
            echo "Cleaned emojis from: " . str_replace($dir . DIRECTORY_SEPARATOR, '', $path) . "\n";
        }
    }
}
echo "Replacement completed!\n";
