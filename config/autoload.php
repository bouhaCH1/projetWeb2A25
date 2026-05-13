<?php

require_once __DIR__ . '/database.php';

spl_autoload_register(function (string $class): void {
    $base = dirname(__DIR__);
    $candidates = [
        $base . '/Model/'       . $class . '.php',
        $base . '/Model/repositories/' . $class . '.php',
        $base . '/Model/services/'     . $class . '.php',
        $base . '/Controller/'  . $class . '.php',
    ];
    foreach ($candidates as $f) {
        if (is_file($f)) { require_once $f; return; }
    }
});
