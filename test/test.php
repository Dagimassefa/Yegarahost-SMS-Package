<?php

require_once __DIR__ . '/../src/SmsSender.php';

use Dagim\Package\SmsSender;

$smsSender = new SmsSender();

// Provide test data (recipient number)
$recipientNumber = '##################'; // Replace with actual recipient number


// Call the sendSms method
$response = $smsSender->sendSms($recipientNumber);

echo $response;