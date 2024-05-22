# SMS OTP Sender Package for Laravel

This Laravel package facilitates sending One Time Passwords (OTPs) via SMS using the Yegara HOST API. It provides a straightforward interface to integrate OTP functionality into your Laravel applications seamlessly.

## Installation

To install this package, use Composer:

```bash
composer require dagim/sms-sender
```

## Configuration

After installation, add the following environment variables to your `.env` file:

```dotenv
SMS_DOMAIN=yourdomain.com
SMS_ID=your_package_id
```

Replace `yourdomain.com` with your actual domain and `your_package_id` with your package ID provided by Yegara HOST.

## Usage

You can utilize the `sendSms` method provided by the `SmsSender` class to send OTPs via SMS.

```php
use Dagim\Package\SmsSender;

$smsSender = new SmsSender();

// Provide recipient number
$recipientNumber = '##########'; // Replace with actual recipient number

// Send OTP SMS
$response = $smsSender->sendSms($recipientNumber);

echo $response;
```

## Example

```php
use Dagim\Package\SmsSender;

$smsSender = new SmsSender();

// Provide test data (recipient number)
$recipientNumber = '0960171717'; // Replace with actual recipient number

// Call the sendSms method
$response = $smsSender->sendSms($recipientNumber);

echo $response;
```

## Note

- This package utilizes the Yegara HOST API for sending OTP SMS.
- Ensure that your Yegara HOST account is properly configured with the necessary package ID and domain.
- The package automatically generates a 6-digit OTP for each SMS sent.

## Credits

This package is developed by Dagim, inspired by the need for a simple and efficient OTP SMS sender solution for Laravel applications.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE.md).
