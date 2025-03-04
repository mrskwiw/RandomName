<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teriyaki Tradesmen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/lucide-css" rel="stylesheet">
</head>
<body class="relative">
    <header class="bg-white shadow-md relative z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Teriyaki Tradesmen</h1>
                </div>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="index.php" class="<?php echo $current_page === 'index.php' ? 'text-orange-600' : 'text-gray-700'; ?> hover:text-orange-500">
                        Home
                    </a>
                    <a href="schedule.php" class="<?php echo $current_page === 'schedule.php' ? 'text-orange-600' : 'text-gray-700'; ?> hover:text-orange-500">
                        Schedule
                    </a>
                    <a href="about.php" class="<?php echo $current_page === 'about.php' ? 'text-orange-600' : 'text-gray-700'; ?> hover:text-orange-500">
                        About
                    </a>
                    <a href="book.php" class="<?php echo $current_page === 'book.php' ? 'text-orange-600' : 'text-gray-700'; ?> hover:text-orange-500">
                        Book Us
                    </a>
                </nav>

                <div class="flex items-center space-x-4">
                    <a href="mailto:Contact@TeriyakiTradesmen.com" class="text-gray-700 hover:text-orange-500">
                        <i data-lucide="mail" class="h-5 w-5"></i>
                    </a>
                    <a href="https://www.facebook.com/teriyaki.tradesmen/" target="_blank" rel="noopener noreferrer" class="text-gray-700 hover:text-orange-500">
                        <i data-lucide="facebook" class="h-5 w-5"></i>
                    </a>
                    <button id="mobile-menu-button" class="md:hidden text-gray-700 hover:text-orange-500 focus:outline-none">
                        <i data-lucide="menu" class="h-6 w-6"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-40 hidden">
            <div class="fixed inset-y-0 right-0 max-w-xs w-full bg-white shadow-xl transform transition-transform duration-300 translate-x-full" id="mobile-menu-content">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-xl font-semibold text-gray-900">Menu</h2>
                        <button id="mobile-menu-close" class="text-gray-700 hover:text-orange-500 focus:outline-none">
                            <i data-lucide="x" class="h-6 w-6"></i>
                        </button>
                    </div>
                    <nav class="space-y-6">
                        <a href="index.php" class="block text-lg <?php echo $current_page === 'index.php' ? 'text-orange-600' : 'text-gray-700'; ?> hover:text-orange-500">
                            Home
                        </a>
                        <a href="schedule.php" class="block text-lg <?php echo $current_page === 'schedule.php' ? 'text-orange-600' : 'text-gray-700'; ?> hover:text-orange-500">
                            Schedule
                        </a>
                        <a href="about.php" class="block text-lg <?php echo $current_page === 'about.php' ? 'text-orange-600' : 'text-gray-700'; ?> hover:text-orange-500">
                            About
                        </a>
                        <a href="book.php" class="block text-lg <?php echo $current_page === 'book.php' ? 'text-orange-600' : 'text-gray-700'; ?> hover:text-orange-500">
                            Book Us
                        </a>
                        <div class="pt-6 border-t border-gray-200">
                            <div class="flex space-x-4">
                                <a href="mailto:Contact@TeriyakiTradesmen.com" class="text-gray-700 hover:text-orange-500">
                                    <i data-lucide="mail" class="h-5 w-5"></i>
                                </a>
                                <a href="https://www.facebook.com/teriyaki.tradesmen/" target="_blank" rel="noopener noreferrer" class="text-gray-700 hover:text-orange-500">
                                    <i data-lucide="facebook" class="h-5 w-5"></i>
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuContent = document.getElementById('mobile-menu-content');
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenuClose = document.getElementById('mobile-menu-close');

            function openMenu() {
                mobileMenu.classList.remove('hidden');
                setTimeout(() => {
                    mobileMenuContent.classList.remove('translate-x-full');
                }, 10);
            }

            function closeMenu() {
                mobileMenuContent.classList.add('translate-x-full');
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 300);
            }

            mobileMenuButton.addEventListener('click', openMenu);
            mobileMenuClose.addEventListener('click', closeMenu);
            
            // Close menu when clicking outside
            mobileMenu.addEventListener('click', function(e) {
                if (e.target === mobileMenu) {
                    closeMenu();
                }
            });

            // Close menu when pressing escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeMenu();
                }
            });
        });
    </script>
</body>
</html>
