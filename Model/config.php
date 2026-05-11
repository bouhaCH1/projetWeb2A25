<?php
if (file_exists(__DIR__ . '/api_keys.php')) {
    require_once __DIR__ . '/api_keys.php';
}
if (!defined('GEMINI_API_KEY')) {
    define('GEMINI_API_KEY', 'YOUR_GEMINI_API_KEY_HERE');
}
