<?php

require_once __DIR__ . '/database.php';

spl_autoload_register(function (string $class): void {
    $base = dirname(__DIR__);
    $candidates = [
        $base . '/models/'       . $class . '.php',
        $base . '/models/repositories/' . $class . '.php',
        $base . '/models/services/'     . $class . '.php',
        $base . '/controllers/'  . $class . '.php',
    ];
    foreach ($candidates as $f) {
        if (is_file($f)) { require_once $f; return; }
    }
});
