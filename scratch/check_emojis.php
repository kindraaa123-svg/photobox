<?php

function getFiles($dir) {
    if (!is_dir($dir)) return [];
    $it = new RecursiveDirectoryIterator($dir);
    $display = new RecursiveIteratorIterator($it);
    $files = [];
    foreach ($display as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $files[] = $file->getPathname();
        }
    }
    return $files;
}

$emojiRegex = '/\p{So}/u';

$dirs = [
    __DIR__ . '/../resources',
    __DIR__ . '/../app',
];

foreach ($dirs as $dir) {
    $files = getFiles($dir);
    foreach ($files as $file) {
        $content = file_get_contents($file);
        if (preg_match_all($emojiRegex, $content, $matches)) {
            // Filter out copyright and arrows to only report actual potential emojis
            $found = array_diff(array_unique($matches[0]), ['©', '➔']);
            if (!empty($found)) {
                echo "File: " . str_replace(__DIR__ . '/../', '', $file) . "\n";
                echo "Found Emojis: " . implode(', ', $found) . "\n\n";
            }
        }
    }
}
