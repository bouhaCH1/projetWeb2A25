<?php
require_once __DIR__ . '/Model/config.php';
$url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . GEMINI_API_KEY;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
if (isset($data['models'])) {
    foreach ($data['models'] as $model) {
        if (strpos($model['name'], 'gemini') !== false) {
            echo str_replace('models/', '', $model['name']) . "\n";
        }
    }
} else {
    echo "Error: " . $response;
}
