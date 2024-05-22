<?php

require_once __DIR__ . '/../src/SmsSender.php';

use Dagim\Package\SmsSender;

$smsSender = new SmsSender();

// Provide test data (recipient number and OTP)
$recipientNumber = '0911686102'; // Replace with actual recipient number
$otp = '123456'; // Replace with actual OTP

// Call the sendSms method
$response = $smsSender->sendSms($recipientNumber, $otp);

echo $response;
