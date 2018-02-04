<?php

$env = 'production';
if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
    $env = 'development';
}

return [
    'env' => $env,
    'host' => 'dev.php7mvc.com',
    'display_errors' => true
];