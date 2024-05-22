<?php

namespace Dagim\Package;

class SmsSender
{
    private $generatedOtps = [];

    public function generateOtp()
    {
        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);
        
        // Check if OTP is already generated
        while (in_array($otp, $this->generatedOtps)) {
            $otp = rand(100000, 999999);
        }
        
        // Add generated OTP to the list
        $this->generatedOtps[] = $otp;

        return $otp;
    }

    public function sendSms($to)
    {
        // Generate OTP
        $otp = $this->generateOtp();

        // Retrieve configurations from Laravel's environment variables
        $server = 'https://sms.yegara.com/api3/send';
        $domain = env('SMS_DOMAIN');
        $id = env('SMS_ID');

        $postData = array('to' => $to, 'otp' => $otp, 'id' => $id, 'domain' => $domain);
        $content = json_encode($postData);

        $curl = curl_init($server);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        // Disable SSL certificate verification
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($curl); // Capture any cURL error
        curl_close($curl);

        if ($status >= 200 && $status < 300) {
            return "Response: " . $json_response;
        } else {
            return "Request failed with status code: " . $status . "\n" . "Response: " . $json_response . "\n" . ($curl_error ? "cURL Error: " . $curl_error : "");
        }
    }
}

