<?php
require '../includes/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../includes/schedule_utils.php';

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        $password = $_POST['password'];
        $hashedPassword = $_ENV['ADMIN_PASSWORD'] ?? '';

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['admin_id'] = uniqid();
            $_SESSION['login_attempts'] = 0;
            $_SESSION['last_login'] = time();
        } else {
            $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
            if ($_SESSION['login_attempts'] > 5) {
                $login_error = "Too many failed login attempts. Please try again later.";
                $_SESSION['last_login'] = time();
            } else {
                $login_error = "Invalid password";
            }
        }
    }
}

// Rate limiting
$login_attempts = $_SESSION['login_attempts'] ?? 0;
$last_login = $_SESSION['last_login'] ?? 0;
$time_elapsed = time() - $last_login;

if ($login_attempts > 5 && $time_elapsed < 60) {
    include '../includes/header.php';
    echo '<div class="max-w-md mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">';
    echo '<p class="text-red-500 text-sm mb-4">Too many failed login attempts. Please try again later.</p>';
    echo '</div>';
    include '../includes/footer.php';
    exit;
}

if (!isset($_SESSION['admin_id'])) {
    // Display login form
    include '../includes/header.php';
    ?>
    <div class="max-w-md mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Admin Login</h2>
        <form method="POST">
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Password
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                    required
                />
            </div>
            <?php if (isset($login_error)): ?>
                <p class="text-red-500 text-sm mb-4"><?php echo $login_error; ?></p>
            <?php endif; ?>
            <button
                type="submit"
                class="w-full bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-700"
            >
                Login
            </button>
        </form>
    </div>
    <?php
    include '../includes/footer.php';
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['html_content'])) {
    $subject = sanitize_input($_POST['subject'] ?? 'HTML Email');
    $htmlContent = $_POST['html_content'];
    $emailListFile = __DIR__ . '/email_list.txt';

    if (file_exists($emailListFile)) {
        $emails = file($emailListFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (!empty($emails)) {
            $mail = new PHPMailer(true); // Passing `true` enables exceptions

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

                foreach ($emails as $email) {
                  $mail->addAddress($email);
                }

                // Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $htmlContent;

                $mail->send();
                record_sent_email($emails, $subject, $htmlContent);
                $message = 'Email sent to ' . count($emails) . ' subscribers.';
            } catch (Exception $e) {
                $message = "Error sending email: {$mail->ErrorInfo}";
            }
        } else {
            $message = "Email list is empty.";
        }
    } else {
        $message = "Email list file not found.";
    }
}

include '../includes/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Edit and Send HTML Email</h1>
    <a href="schedule.php" class="text-orange-600 hover:text-orange-700 mb-4 inline-block">Back to Schedule Admin</a>

    <?php if ($message): ?>
        <div class="mb-4 p-4 text-sm <?php echo (strpos($message, 'Error') !== false) ? 'text-red-600 bg-red-100' : 'text-green-600 bg-green-100'; ?> rounded-lg">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-6">
        <div>
            <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
            <input type="text" name="subject" id="subject"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
        </div>
        <div>
            <label for="html_content" class="block text-sm font-medium text-gray-700">HTML Content</label>
            <textarea id="email-body" name="html_content" rows="15"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"></textarea>
        </div>
        <div>
            <button type="submit"
                    class="w-full bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition-colors">
                Send Email
            </button>
        </div>
    </form>
</div>
<script src="https://cdn.tiny.cloud/1/<?php echo $_ENV['TINYMCE_API_KEY'] ?? ''; ?>/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: '#email-body',
    plugins: 'link image code',
    toolbar: 'undo redo | bold italic | link image | code',
  });
</script>
<?php include '../includes/footer.php'; ?>
