<?php 
include 'includes/header.php';

$teamMembers = [
    [
        "name" => "Lin McClain",
        "role" => "Chef & Founder",
        "bio" => "With over 30 of culinary expertise, Chef Lin McClain is the creative force behind Teriyaki Tradesmen. Her journey began at the feet her mother, a lifetime professional cook. She began her career in food wiht her first job at 15 and has studied and practiced many cuisines throught the years. She studied at L'ecole Culinaiare earner her [degree one] and [degree two], before joing the team at Michelin Starred [restauraunt at the club], rising to sous chef before setting out on her own. Now she has her own kitchen, designs her own recipes, and serves across the greate Saint Louis region.",
        "imageUrl" => "/white.png"
    ],
    [
        "name" => "Christohis Ogle",
        "role" => " ",
        "bio" => "An 18 year industry vetran, Chris has the honor and pleasure of being the chef's first taste tester and sanity check. You will usually find chris on the truck reveling in making the food, but he also manages the email list and website",
        "imageUrl" => "/white.png"
    ],
    [
        "name" => "Carla Wisnehunt",
        "role" => "Teriyaki Penguin",
        "bio" => "They say you should alway put your best foot forward, and for us, that is Carla. The friendly lady face in front of the truck, or soft, Virgina accented voice on the phone about an event is our favorite penguin",
        "imageUrl" => "/white.png"
    ]
];
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Company Introduction -->
    <div class="text-center mb-16">
        <h1 class="text-4xl font-bold text-gray-900 mb-6">About Teriyaki Tradesmen</h1>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">
            Teriyaki Tradesmen was born from a passion for creating the perfect teriyaki experience.
            Our journey began with Chef Lin McClain's vision to bring Asian Fusion flavors
            to the streets of Saint Louis, combining traditional techniques with modern innovation.
        </p>
    </div>

    <!-- Mission Statement -->
    <div class="bg-orange-50 rounded-lg p-8 mb-16">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h2>
            <p class="text-lg text-gray-600">
                To deliver exceptional teriyaki cuisine that honors traditional Japanese flavors while
                embracing modern culinary innovation, serving our community with passion, quality, and authenticity.
            </p>
        </div>
    </div>

    <!-- Team Section -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Meet Our Team</h2>
        <div class="space-y-20">
            <?php foreach ($teamMembers as $index => $member): ?>
                <div class="grid md:grid-cols-2 gap-8 items-center <?php echo $index % 2 !== 0 ? 'direction-rtl' : ''; ?>">
                    <div class="<?php echo $index % 2 !== 0 ? 'md:order-2' : ''; ?>">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($member['name']); ?></h3>
                        <p class="text-lg text-orange-600 mb-4"><?php echo htmlspecialchars($member['role']); ?></p>
                        <p class="text-gray-600 leading-relaxed"><?php echo htmlspecialchars($member['bio']); ?></p>
                    </div>
                    <div class="<?php echo $index % 2 !== 0 ? 'md:order-1' : ''; ?>">
                        <img
                            src="<?php echo htmlspecialchars($member['imageUrl']); ?>"
                            alt="<?php echo htmlspecialchars($member['name']); ?>"
                            class="rounded-lg shadow-xl w-full h-[400px] object-cover"
                        />
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Values Section -->
    <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Quality</h3>
            <p class="text-gray-600">
                We source the finest ingredients and maintain rigorous standards in our preparation methods.
            </p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Community</h3>
            <p class="text-gray-600">
                We're proud to be part of Saint Louis's vibrant food scene and actively engage with our community.
            </p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Innovation</h3>
            <p class="text-gray-600">
                While respecting tradition, we're not afraid to experiment and create new flavor experiences.
            </p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
