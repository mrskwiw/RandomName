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

require_once '../includes/schedule_utils.php';

// Handle form submissions
if (isset($_SESSION['admin_id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'add':
                    $date = sanitize_input($_POST['date']);
                    $time = sanitize_input($_POST['time']);
                    $location = sanitize_input($_POST['location']);
                    $address = sanitize_input($_POST['address']);
                    add_event($date, $time, $location, $address);
                    break;
                    
                case 'cancel':
                    $id = (int)$_POST['id'];
                    cancel_event($id);
                    break;
                    
                case 'cleanup':
                    remove_expired_events();
                    break;
            }
        }
    }
}

include '../includes/header.php';
?>

<?php if (!isset($_SESSION['admin_id'])): ?>
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
<?php else: ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Schedule Administration</h1>
            <a href="../index.php" class="text-orange-600 hover:text-orange-700">Back to Website</a>
        </div>
        <div class="mb-4">
            <a href="admin.php" class="text-orange-600 hover:text-orange-700">Admin Links</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-xl font-bold mb-4">Add New Event</h2>
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="add">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="date" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Time</label>
                        <input type="text" name="time" required placeholder="e.g., 11:00 AM - 3:00 PM"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" name="address" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                    </div>

                    <button type="submit"
                            class="w-full bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-700">
                        Add Event
                    </button>
                </form>
            </div>

            <div>
                <h2 class="text-xl font-bold mb-4">Current Events</h2>
                <div class="space-y-4">
                    <?php
                    $events = get_active_events();
                    foreach ($events as $event):
                    ?>
                        <div class="p-4 rounded-lg border <?php echo $event['status'] === 'cancelled' ? 'bg-gray-50 border-gray-300' : 'bg-white border-gray-200'; ?>">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold">
                                        <?php echo date('F j, Y', strtotime($event['date'])); ?> - <?php echo htmlspecialchars($event['time']); ?>
                                    </p>
                                    <p><?php echo htmlspecialchars($event['location']); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($event['address']); ?></p>
                                    <?php if ($event['status'] === 'cancelled'): ?>
                                        <p class="text-red-600 text-sm mt-1">Cancelled</p>
                                    <?php endif; ?>
                                </div>
                                <div class="space-x-2">
                                    <?php if ($event['status'] === 'active'): ?>
                                        <form method="POST" class="inline">
                                            <input type="hidden" name="action" value="cancel">
                                            <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                                            <button type="submit"
                                                    class="text-orange-600 hover:text-orange-700 text-sm">
                                                Cancel
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <form method="POST" class="mt-8">
                    <input type="hidden" name="action" value="cleanup">
                    <button type="submit"
                            class="text-gray-600 hover:text-gray-700 text-sm">
                        Clean up expired events
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
