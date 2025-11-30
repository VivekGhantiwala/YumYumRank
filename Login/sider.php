<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_id']) || $_SESSION['is_admin'] == false) {
    // If not logged in, redirect to login page
    header("Location: http://localhost/MiniProject(Aman)/Login/login.php");
    exit();
}

$admin_role = $_SESSION['Role'] ?? 'Guest';

// Define menu items for each role
$menu_items = [
    'Super Admin' => [
        'Dashboard' => ['icon' => 'fas fa-home', 'link' => 'index.php'],
        'Manage Foods' => [
            'icon' => 'fas fa-utensils',
            'submenu' => [
                'Add Products' => ['icon' => 'fas fa-hamburger', 'link' => 'add_product.php'],
                'View Products' => ['icon' => 'fas fa-eye', 'link' => 'view_products.php']
            ]
        ],
        'Manage Ingredients' => [
            'icon' => 'fas fa-leaf',
            'submenu' => [
                'Add Ingredients' => ['icon' => 'fas fa-carrot', 'link' => 'add_ingredient.php'],
                'View Ingredients' => ['icon' => 'fas fa-seedling', 'link' => 'view_ingredients.php']
            ]
        ],
        'Categories' => [
            'icon' => 'fas fa-tags',
            'submenu' => [
                'Add Category' => ['icon' => 'fas fa-plus-circle', 'link' => 'add_category.php'],
                'View Categories' => ['icon' => 'fas fa-eye', 'link' => 'view_categories.php']
            ]
        ],
        'Analytics' => [
            'icon' => 'fas fa-chart-pie',
            'submenu' => [
                'Food Trends' => ['icon' => 'fas fa-fire', 'link' => 'food_trends.php'],
                'User Engagement' => ['icon' => 'fas fa-comments', 'link' => 'user_engagement.php']
            ]
        ],
        'User Management' => ['icon' => 'fas fa-users', 'link' => 'user_manage.php'],
        'Admin Management' => [
            'icon' => 'fas fa-user-shield',
            'submenu' => [
                'Add Admin' => ['icon' => 'fas fa-user-shield', 'link' => 'add_admin.php'],
                'View Admins' => ['icon' => 'fas fa-user-lock', 'link' => 'view_admins.php']
            ]
        ]
    ],
    'Admin' => [
        'Dashboard' => ['icon' => 'fas fa-home', 'link' => 'index.php'],
        'Manage Foods' => [
            'icon' => 'fas fa-utensils',
            'submenu' => [
                'Add Products' => ['icon' => 'fas fa-hamburger', 'link' => 'add_product.php'],
                'View Products' => ['icon' => 'fas fa-eye', 'link' => 'view_products.php']
            ]
        ],
        'Manage Ingredients' => [
            'icon' => 'fas fa-leaf',
            'submenu' => [
                'Add Ingredients' => ['icon' => 'fas fa-carrot', 'link' => 'add_ingredient.php'],
                'View Ingredients' => ['icon' => 'fas fa-seedling', 'link' => 'view_ingredients.php']
            ]
        ],
        'Categories' => [
            'icon' => 'fas fa-tags',
            'submenu' => [
                'Add Category' => ['icon' => 'fas fa-plus-circle', 'link' => 'add_category.php'],
                'View Categories' => ['icon' => 'fas fa-eye', 'link' => 'view_categories.php']
            ]
        ],
        'Analytics' => [
            'icon' => 'fas fa-chart-pie',
            'submenu' => [
                'Food Trends' => ['icon' => 'fas fa-fire', 'link' => 'food_trends.php'],
                'User Engagement' => ['icon' => 'fas fa-comments', 'link' => 'user_engagement.php']
            ]
        ],
        'User Management' => ['icon' => 'fas fa-users', 'link' => 'user_manage.php']
    ],
    'Content Manager' => [
        'Dashboard' => ['icon' => 'fas fa-home', 'link' => 'index.php'],
        'Manage Foods' => [
            'icon' => 'fas fa-utensils',
            'submenu' => [
                'Add Products' => ['icon' => 'fas fa-hamburger', 'link' => 'add_product.php'],
                'View Products' => ['icon' => 'fas fa-eye', 'link' => 'view_products.php']
            ]
        ],
        'Manage Ingredients' => [
            'icon' => 'fas fa-leaf',
            'submenu' => [
                'Add Ingredients' => ['icon' => 'fas fa-carrot', 'link' => 'add_ingredient.php'],
                'View Ingredients' => ['icon' => 'fas fa-seedling', 'link' => 'view_ingredients.php']
            ]
        ],
        'Categories' => [
            'icon' => 'fas fa-tags',
            'submenu' => [
                'Add Category' => ['icon' => 'fas fa-plus-circle', 'link' => 'add_category.php'],
                'View Categories' => ['icon' => 'fas fa-eye', 'link' => 'view_categories.php']
            ]
        ]
    ],
    'User Support' => [
        'Dashboard' => ['icon' => 'fas fa-home', 'link' => 'index.php'],
        'User Management' => ['icon' => 'fas fa-users', 'link' => 'user_manage.php']
    ],
    'Data Analyst' => [
        'Dashboard' => ['icon' => 'fas fa-home', 'link' => 'index.php'],
        'Analytics' => [
            'icon' => 'fas fa-chart-pie',
            'submenu' => [
                'Food Trends' => ['icon' => 'fas fa-fire', 'link' => 'food_trends.php'],
                'User Engagement' => ['icon' => 'fas fa-comments', 'link' => 'user_engagement.php']
            ]
        ]
    ]
];

// Function to generate menu items
function generateMenuItems($items) {
    foreach ($items as $title => $item) {
        if (isset($item['submenu'])) {
            echo "<a href='#' class='submenu-toggle'><i class='{$item['icon']}'></i> <span>{$title}</span></a>";
            echo "<div class='submenu'>";
            foreach ($item['submenu'] as $subTitle => $subItem) {
                echo "<a href='{$subItem['link']}'><i class='{$subItem['icon']}'></i> {$subTitle}</a>";
            }
            echo "</div>";
        } else {
            echo "<a href='{$item['link']}'><i class='{$item['icon']}'></i> <span>{$title}</span></a>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YumYumRank Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="icon" href="file.png" type="image/x-icon">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            transition: background-color 0.3s ease;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            height: 100%;
            width: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: left 0.3s ease, width 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.5s forwards;
        }

        @keyframes slideIn {
            from { left: -250px; }
            to { left: 0; }
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 10px;
            transition: all 0.3s ease;
        }

        .sidebar .logo-container img {
            width: 40px;
            height: 40px;
            transition: all 0.3s ease;
        }

        .sidebar:hover .logo-container img {
            width: 60px;
            height: 60px;
        }

        .sidebar .logo-container img:hover {
            transform: rotate(360deg);
        }

        .sidebar .menu-title {
            padding: 10px 5px;
            font-size: 1rem;
            color: #fff;
            text-align: center;
            font-weight: bold;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.5s ease;
            transform: translateY(-10px);
            background: linear-gradient(90deg, #ff9a9e, #fad0c4, #ffecd2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar .menu-quote {
            font-size: 0.7rem;
            color: #ffecd2;
            text-align: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar:hover .menu-title,
        .sidebar:hover .menu-quote {
            opacity: 1;
            transform: translateY(0);
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            transition: background 0.3s ease, transform 0.3s ease, color 0.3s ease;
            opacity: 0.8;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
            opacity: 1;
            transform: translateX(5px);
            color: #ffecd2;
        }

        .submenu {
            display: none;
            padding-left: 20px;
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar a:hover + .submenu,
        .submenu:hover {
            display: block;
        }

        .submenu a {
            padding: 10px 15px;
            font-size: 0.9em;
        }

        .submenu a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar a i {
            min-width: 30px;
            transition: transform 0.3s ease;
            margin-right: 10px;
        }

        .sidebar a span {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar:hover a span {
            opacity: 1;
        }

        .sidebar {
            width: 60px;
            overflow: hidden;
            transition: width 0.3s ease;
        }

        .sidebar:hover {
            width: 250px;
        }

        .bottom-controls {
            margin-top: auto;
            padding: 20px;
            text-align: center;
            color: white;
            opacity: 0.8;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: opacity 0.3s ease;
        }

        .sidebar:hover .bottom-controls {
            display: flex;
            opacity: 1;
        }

        .bottom-controls a {
            display: block;
            margin: 5px 0;
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .bottom-controls a:hover {
            color: #ffecd2;
        }

        .footer-links {
            margin-top: 20px;
            padding: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .footer-links a {
            display: block;
            color: #ffecd2;
            text-decoration: none;
            margin: 5px 0;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }

        .submenu-toggle::after {
            content: '\f107';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .submenu-toggle.active::after {
            transform: rotate(180deg);
        }

        .submenu {
            display: none;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .submenu.active {
            display: block;
            max-height: 500px;
        }
        #loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1001;
            background-color: #2c3e50;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.5s, visibility 0.5s;
        }

        #loader-wrapper.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader {
            --path: #3498db;
            --dot: #f39c12;
            --duration: 3s;
            width: 44px;
            height: 44px;
            position: relative;
        }

        .loader:before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            position: absolute;
            display: block;
            background: var(--dot);
            top: 37px;
            left: 19px;
            transform: translate(-18px, -18px);
            animation: dotRect var(--duration) cubic-bezier(0.785, 0.135, 0.15, 0.86) infinite;
        }

        .loader svg {
            display: block;
            width: 100%;
            height: 100%;
        }

        .loader svg rect,
        .loader svg polygon,
        .loader svg circle {
            fill: none;
            stroke: var(--path);
            stroke-width: 10px;
            stroke-linejoin: round;
            stroke-linecap: round;
        }

        .loader svg polygon {
            stroke-dasharray: 145 76 145 76;
            stroke-dashoffset: 0;
            animation: pathTriangle var(--duration) cubic-bezier(0.785, 0.135, 0.15, 0.86) infinite;
        }

        .loader svg rect {
            stroke-dasharray: 192 64 192 64;
            stroke-dashoffset: 0;
            animation: pathRect 3s cubic-bezier(0.785, 0.135, 0.15, 0.86) infinite;
        }

        .loader svg circle {
            stroke-dasharray: 150 50 150 50;
            stroke-dashoffset: 75;
            animation: pathCircle var(--duration) cubic-bezier(0.785, 0.135, 0.15, 0.86) infinite;
        }

        .loader.triangle {
            width: 48px;
        }

        .loader.triangle:before {
            left: 21px;
            transform: translate(-10px, -18px);
            animation: dotTriangle var(--duration) cubic-bezier(0.785, 0.135, 0.15, 0.86) infinite;
        }

        @keyframes pathTriangle {
            33% {
                stroke-dashoffset: 74;
            }

            66% {
                stroke-dashoffset: 147;
            }

            100% {
                stroke-dashoffset: 221;
            }
        }

        @keyframes dotTriangle {
            33% {
                transform: translate(0, 0);
            }

            66% {
                transform: translate(10px, -18px);
            }

            100% {
                transform: translate(-10px, -18px);
            }
        }

        @keyframes pathRect {
            25% {
                stroke-dashoffset: 64;
            }

            50% {
                stroke-dashoffset: 128;
            }

            75% {
                stroke-dashoffset: 192;
            }

            100% {
                stroke-dashoffset: 256;
            }
        }

        @keyframes dotRect {
            25% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(18px, -18px);
            }

            75% {
                transform: translate(0, -36px);
            }

            100% {
                transform: translate(-18px, -18px);
            }
        }

        @keyframes pathCircle {
            25% {
                stroke-dashoffset: 125;
            }

            50% {
                stroke-dashoffset: 175;
            }

            75% {
                stroke-dashoffset: 225;
            }

            100% {
                stroke-dashoffset: 275;
            }
        }
        .quick-links-heading {
            color: #ffecd2;
            font-size: 1.1rem;
            margin-bottom: 10px;
            text-align: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            font-family: 'Montserrat', sans-serif;
        }

        .sidebar:hover .quick-links-heading {
            opacity: 1;
        }

        .footer-links a {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            color: #ffecd2;
            text-decoration: none;
            transition: background 0.3s ease, color 0.3s ease;
            font-size: 0.8rem;
            opacity: 0.7;
        }

        .footer-links a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            opacity: 1;
        }

        .footer-links a i {
            margin-right: 10px;
            font-size: 1rem;
        }

        .footer-links a span {
            display: none;
            transition: opacity 0.3s ease;
        }
        .sidebar:hover .footer-links a span {
            display: inline;
            opacity: 1;
        }
    </style>
</head>
<body>
    <!-- Loader -->
    <div id="loader-wrapper">
        <div class="loader">
            <svg viewBox="0 0 80 80">
                <circle id="test" cx="40" cy="40" r="32"></circle>
            </svg>
        </div>
        <div class="loader triangle">
            <svg viewBox="0 0 86 80">
                <polygon points="43 8 79 72 7 72"></polygon>
            </svg>
        </div>
        <div class="loader">
            <svg viewBox="0 0 80 80">
                <rect x="8" y="8" width="64" height="64"></rect>
            </svg>
        </div>
    </div>
    <div id="main-content">
        <div class="sidebar" id="sidebar">
            <div class="logo-container">
                <img src="file.png" alt="YumYumRank Logo">
                <div class="menu-title">YumYumRank</div>
                <div class="menu-quote">Taste the world, one rank at a time</div>
            </div>
            <?php
            if (isset($menu_items[$admin_role])) {
                generateMenuItems($menu_items[$admin_role]);
            } else {
                echo "<p>No menu items available for your role.</p>";
            }
            ?>
            <a href="logout.php"><i class="fas fa-door-open"></i> <span>Exit YumYumRank</span></a>

            <div class="footer-links">
                <h4 class="quick-links-heading"><span class="quick-links-text">Quick Links</span></h4>
                <a href="privacy.php"><i class="fas fa-user-secret"></i> <span>Privacy Policy</span></a>
                <a href="terms.php"><i class="fas fa-file-contract"></i> <span>Terms of Service</span></a>
                <a href="help.php"><i class="fas fa-question-circle"></i> <span>Help</span></a>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const submenuToggles = document.querySelectorAll('.submenu-toggle');
            const loaderWrapper = document.getElementById('loader-wrapper');

            sidebar.classList.add('active');

            submenuToggles.forEach(toggle => {
                toggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    this.classList.toggle('active');
                    const submenu = this.nextElementSibling;
                    submenu.classList.toggle('active');
                });

                toggle.addEventListener('mouseenter', function () {
                    this.classList.add('active');
                    const submenu = this.nextElementSibling;
                    submenu.classList.add('active');
                });

                toggle.addEventListener('mouseleave', function () {
                    const submenu = this.nextElementSibling;
                    if (!submenu.matches(':hover')) {
                        this.classList.remove('active');
                        submenu.classList.remove('active');
                    }
                });
            });

            const submenus = document.querySelectorAll('.submenu');
            submenus.forEach(submenu => {
                submenu.addEventListener('mouseleave', function () {
                    this.classList.remove('active');
                    this.previousElementSibling.classList.remove('active');
                });
            });

            // Improved loader hiding with fade-out effect
            setTimeout(function() {
                const loaderWrapper = document.getElementById('loader-wrapper');
                loaderWrapper.style.opacity = '1';
                loaderWrapper.style.transition = 'opacity 0.5s ease-out';
                
                setTimeout(function() {
                    loaderWrapper.style.opacity = '0';
                    setTimeout(function() {
                        loaderWrapper.style.display = 'none';
                    }, 500);
                }, 2500);
            }, 0);
        });
    </script>
<?php
