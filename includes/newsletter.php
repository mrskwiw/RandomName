<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailListFile = __DIR__ . '/../admin/email_list.txt';
    $file = fopen($emailListFile, 'a');

    if ($file) {
      fwrite($file, $email . "\n");
      fclose($file);
      $success = true;
    } else {
      $error = "Error saving email address.";
    }
  } else {
    $error = "Invalid email address.";
  }
}
?>

<div class="bg-orange-50 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto text-center">
      <h2 class="text-3xl font-bold text-gray-900">Join Our Mailing List</h2>
      <p class="mt-4 text-lg text-gray-600">
        Stay up-to-date with our latest news, events, and special offers!
      </p>
    </div>
    <div class="mt-10">
      <form action="" method="post" class="max-w-md mx-auto">
        <?php if (isset($success) && $success): ?>
          <p class="text-green-600 text-center mb-4">Thank you for subscribing!</p>
        <?php elseif (isset($error)): ?>
          <p class="text-red-600 text-center mb-4"><?php echo $error; ?></p>
        <?php endif; ?>
        <div class="flex items-center">
          <label for="email" class="sr-only">Email address</label>
          <input type="email" name="email" id="email" required placeholder="Enter your email"
                 class="w-full px-5 py-3 border border-gray-300 rounded-l-md focus:ring-orange-500 focus:border-orange-500">
          <button type="submit"
                  class="bg-orange-600 text-white px-6 py-3 rounded-r-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
            Subscribe
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
