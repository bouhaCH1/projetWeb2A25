<?php
require_once 'Model/AIService.php';

$title = "Senior Web Developer";
$desc = "We are looking for a developer with 5 years of experience in PHP and React.";

echo "Testing AIService Classification...\n";
$result = AIService::classifyMission($title, $desc);

echo "Result:\n";
print_r($result);
