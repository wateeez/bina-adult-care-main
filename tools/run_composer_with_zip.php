<?php
// Verify zip extension file exists
$ext_path = 'C:\\xampp\\php\\ext\\php_zip.dll';
if (!file_exists($ext_path)) {
    die("Error: php_zip.dll not found at $ext_path\n");
}

// Load zip extension dynamically
if (!extension_loaded('zip')) {
    if (!dl('php_zip.dll')) {
        die("Error: Failed to load zip extension\n");
    }
}

// Verify zip extension is loaded
if (!extension_loaded('zip')) {
    die("Error: zip extension not loaded\n");
}

echo "Zip extension loaded successfully\n";

// Run composer install
passthru('C:\\xampp\\php\\php.exe C:\\xampp\\php\\composer.phar install --no-interaction', $return);
exit($return);