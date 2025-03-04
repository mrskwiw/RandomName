<?php
require '../includes/config.php';

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

include '../includes/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Admin Panel</h1>
    <a href="schedule.php" class="text-orange-600 hover:text-orange-700 mb-4 inline-block">Back to Schedule</a>

    <div class="mb-4">
        <a href="send_email.php" class="text-orange-600 hover:text-orange-700">Send Email</a> |
        <a href="upload_email.php" class="text-orange-600 hover:text-orange-700">Upload & Send HTML Email</a> |
        <a href="edit_email.php" class="text-orange-600 hover:text-orange-700">Edit & Send HTML Email</a> |
        <a href="email_log.php" class="text-orange-600 hover:text-orange-700">Email Log</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
