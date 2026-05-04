<?php
// List available Gemini models
$apiKey = 'AIzaSyAji3HFIooQCPfzIXwDJXAnqETT0NKdqgk';

$ch = curl_init("https://generativelanguage.googleapis.com/v1beta/models?key=$apiKey");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "Error: $error\n";
    exit;
}

$data = json_decode($response, true);

if (isset($data['models'])) {
    echo "Available Gemini models that support generateContent:\n";
    echo "=====================================================\n";
    foreach ($data['models'] as $model) {
        $methods = $model['supportedGenerationMethods'] ?? [];
        if (in_array('generateContent', $methods)) {
            echo $model['name'] . "\n";
        }
    }
} else {
    echo "Raw response:\n";
    echo $response . "\n";
}
