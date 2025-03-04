# Guide: Setting Up the Email System

This guide assumes you have already implemented the code provided in the previous steps, including the PHPMailer library, the `.env` and `.conf` files, and the email sending functionality in `admin/send_email.php`, `admin/upload_email.php`, and `admin/edit_email.php`.

## Step 1: Configure SMTP Settings in `.env`

The `.env` file stores sensitive information, including your SMTP credentials. You need to configure these settings to allow PHPMailer to connect to your email server.

1.  **Locate the `.env` File:** This file should be in the root directory of your project (the same directory as `index.php`).
2.  **Open the `.env` File:** Use a text editor to open the `.env` file.
3.  **Modify SMTP Settings:** Replace the placeholder values with your actual SMTP server settings:

    ```
    SMTP_HOST=smtp.example.com        # Your SMTP server hostname (e.g., smtp.gmail.com)
    SMTP_USER=your_email@example.com  # Your SMTP username (usually your email address)
    SMTP_PASS=your_smtp_password      # Your SMTP password
    SMTP_PORT=587                     # Your SMTP port (usually 587 for TLS or 465 for SSL)
    ADMIN_PASSWORD=secure_admin_password # Your admin password (hashed)
    TINYMCE_API_KEY=your_tinymce_api_key # Your TinyMCE API key
    ```

    *   **`SMTP_HOST`:** The hostname of your SMTP server.
    *   **`SMTP_USER`:** The username for your SMTP server.
    *   **`SMTP_PASS`:** The password for your SMTP server.
    *   **`SMTP_PORT`:** The port number for your SMTP server.
    *   **`ADMIN_PASSWORD`:** The hashed admin password.
    *   **`TINYMCE_API_KEY`:** Your TinyMCE API key.

    **Important:**
    *   If you are using Gmail, you might need to enable "Less secure app access" or use an "App Password" if you have 2FA enabled.
    *   If you are using a different email provider, refer to their documentation for the correct SMTP settings.
    *   **Never commit the `.env` file to version control.**

## Step 2: Configure Sender Information in `.conf`

The `.conf` file stores application settings, including the sender's email address and name.

1.  **Locate the `.conf` File:** This file should be in the root directory of your project (the same directory as `index.php`).
2.  **Open the `.conf` File:** Use a text editor to open the `.conf` file.
3.  **Modify Sender Settings:** Replace the placeholder values with your actual sender information:

    ```
    SENDER_EMAIL=your_email@example.com  # The email address that will appear as the sender
    SENDER_NAME=Teriyaki Tradesmen      # The name that will appear as the sender
    ```

    *   **`SENDER_EMAIL`:** The email address that will be used as the sender.
    *   **`SENDER_NAME`:** The name that will be used as the sender.

## Step 3: Verify `includes/config.php`

The `includes/config.php` file is responsible for loading the settings from the `.env` and `.conf` files. Ensure that it is correctly loading the settings:

```php
<?php
// Load .env file
if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Load .conf file
if (file_exists(__DIR__ . '/../.conf')) {
    $lines = file(__DIR__ . '/../.conf', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            define(trim($key), trim($value));
        }
    }
}

// Enforce HTTPS
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    $redirectURL = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirectURL);
    exit();
}

// Session settings
ini_set('session.cookie_httponly', true);
ini_set('session.cookie_secure', true);
session_set_cookie_params(['samesite' => 'Strict']);
session_start();

// Function to sanitize input
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
?>
```

## Step 4: Verify Email Sending Logic

The email sending logic is implemented in `admin/send_email.php`, `admin/upload_email.php`, and `admin/edit_email.php`. Ensure that the PHPMailer settings are correctly using the environment variables and constants:

```php
// Example from admin/send_email.php
$mail = new PHPMailer(true);
try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = $_ENV['SMTP_HOST'] ?? 'smtp.example.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['SMTP_USER'] ?? 'your_email@example.com';
    $mail->Password   = $_ENV['SMTP_PASS'] ?? 'your_smtp_password';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $_ENV['SMTP_PORT'] ?? 587;

    // Recipients
    $mail->setFrom(SENDER_EMAIL, SENDER_NAME);
    // ...
}
```

## Step 5: Test the Email System

1.  **Access the Admin Panel:** Log in to the admin panel.
2.  **Send a Test Email:** Use the "Send Email" page to send a test email to your email list.
3.  **Check Your Inbox:** Verify that the email was sent successfully and that it appears in your inbox.
4.  **Check the Email Log:** Verify that the email was recorded in the `sent_emails` table.

## Troubleshooting

*   **Email Not Sending:**
    *   Double-check your SMTP settings in the `.env` file.
    *   Verify that your SMTP server is working correctly.
    *   Check your spam folder.
    *   Check your server's error logs for any PHPMailer errors.
*   **Email Not Recorded:**
    *   Check your server's error logs for any database errors.
    *   Verify that the `sent_emails` table exists in your `schedule.db` file.
*   **Authentication Issues:**
    *   Double-check your admin password in the `.env` file.
    *   Make sure you are using the hashed password.

## Important Notes

*   **Security:** Always keep your SMTP credentials and admin password secure.
*   **Error Handling:** Implement more robust error handling for a production environment.
*   **Testing:** Thoroughly test the email system before deploying it to a production environment.
