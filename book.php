<?php 
include 'includes/header.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Here you would add your booking logic
    // For now, we'll just simulate success
    $success = true;
}
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Book Us for Your Event</h1>
        
        <?php if ($success): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-6">
                Thank you for your booking request! We'll contact you soon to confirm the details.
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="tel" name="phone" id="phone" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                </div>

                <div>
                    <label for="eventDate" class="block text-sm font-medium text-gray-700">Event Date</label>
                    <input type="date" name="eventDate" id="eventDate" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                </div>

                <div>
                    <label for="eventType" class="block text-sm font-medium text-gray-700">Event Type</label>
                    <select name="eventType" id="eventType" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                        <option value="">Select an event type</option>
                        <option value="wedding">Wedding</option>
                        <option value="corporate">Corporate Event</option>
                        <option value="birthday">Birthday Party</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label for="guestCount" class="block text-sm font-medium text-gray-700">Expected Guest Count</label>
                    <input type="number" name="guestCount" id="guestCount" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                </div>
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700">Additional Details</label>
                <textarea name="message" id="message" rows="4"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"></textarea>
            </div>

            <div>
                <button type="submit"
                        class="w-full bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition-colors">
                    Submit Booking Request
                </button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
