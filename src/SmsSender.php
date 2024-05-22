<?php

namespace Dagim\Package;

class SmsSender
{
    private function loadEnv($file)
    {
        if (!file_exists($file)) {
            throw new \Exception("The .env file does not exist.");
        }

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue; // Skip comments
            }
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }

    public function sendSms($to, $otp)
    {
        // Load environment variables
        $this->loadEnv(__DIR__ . '/../../.env');

        // Retrieve configurations from environment variables
        $server = 'https://sms.yegara.com/api3/send';
        $domain = getenv('SMS_DOMAIN');
        $id = getenv('SMS_ID');

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
