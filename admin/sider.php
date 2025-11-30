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

// Define Quick Links for footer
$quick_links = [
    'Privacy Policy' => ['icon' => 'fas fa-user-secret', 'link' => 'privacy.php'],
    'Terms of Service' => ['icon' => 'fas fa-file-contract', 'link' => 'terms.php'],
    'Help' => ['icon' => 'fas fa-question-circle', 'link' => 'help.php']
];

// Allow access to all update pages for specific roles
$update_pages = [
    'update_product.php',
    'update_ingredient.php',
    'edit_category.php',
];

$allowed_roles = ['Content Manager', 'Admin', 'Super Admin'];

// Function to generate menu items
function generateMenuItems($items)
{
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

// Function to check access
function checkAccess($requested_page)
{
    global $admin_role, $menu_items, $allowed_roles, $update_pages;

    if (!isset($menu_items[$admin_role])) {
        $_SESSION['error_message'] = 'You do not have permission to access this page.';
        header("Location: index.php");
        exit();
    }

    $hasAccess = false;
    foreach ($menu_items[$admin_role] as $item) {
        if (isset($item['link']) && $item['link'] == $requested_page) {
            $hasAccess = true;
            break;
        }
        if (isset($item['submenu'])) {
            foreach ($item['submenu'] as $subItem) {
                if ($subItem['link'] == $requested_page) {
                    $hasAccess = true;
                    break 2;
                }
            }
        }
    }

    // Allow access to update pages for specific roles
    if (in_array($requested_page, $update_pages) && in_array($admin_role, $allowed_roles)) {
        $hasAccess = true;
    }

    // Allow access to Quick Links for all roles
    if (in_array($requested_page, ['privacy.php', 'terms.php', 'help.php'])) {
        $hasAccess = true;
    }

    // Allow Super Admin access to update_product.php
    if ($admin_role === 'Super Admin' && $requested_page === 'update_food.php') {
        $hasAccess = true;
    }

    if (!$hasAccess) {
        $page_name = ucwords(str_replace('_', ' ', pathinfo($requested_page, PATHINFO_FILENAME)));
        $_SESSION['error_message'] = "You do not have permission to access the {$page_name} page.";
        header("Location: index.php");
        exit();
    }
}

// Check access for the current page
$current_page = basename($_SERVER['PHP_SELF']);
checkAccess($current_page);
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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Montserrat:wght@400;600&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
            background:
                linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3Cpath d='M6 5V0H5v5H0v1h5v94h1V6h94V5H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            background-attachment: fixed;
            transition: background-color 0.5s ease;
            color: #333;
            line-height: 1.6;
            animation: bodyAurora 15s ease infinite;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 0.8rem;
        }

        h3 {
            font-size: 1.75rem;
            margin-bottom: 0.6rem;
        }

        h4 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        h5 {
            font-size: 1.25rem;
            margin-bottom: 0.4rem;
        }

        h6 {
            font-size: 1rem;
            margin-bottom: 0.3rem;
        }

        @keyframes bodyAurora {
            0% {
                background-position: 0% 0%;
            }

            50% {
                background-position: 100% 100%;
            }

            100% {
                background-position: 0% 0%;
            }
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background:
                linear-gradient(135deg, rgba(106, 17, 203, 0.9) 0%, rgba(37, 117, 252, 0.9) 100%),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath fill-rule='evenodd' d='M11 0l5 20H6l5-20zm42 31a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM0 72h40v4H0v-4zm0-8h31v4H0v-4zm20-16h20v4H20v-4zM0 56h40v4H0v-4zm63-25a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM53 41a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-30 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-28-8a5 5 0 0 0-10 0h10zm10 0a5 5 0 0 1-10 0h10zM56 5a5 5 0 0 0-10 0h10zm10 0a5 5 0 0 1-10 0h10zm-3 46a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM21 0l5 20H16l5-20zm43 64v-4h-4v4h-4v4h4v4h4v-4h4v-4h-4zM36 13h4v4h-4v-4zm4 4h4v4h-4v-4zm-4 4h4v4h-4v-4zm8-8h4v4h-4v-4z'/%3E%3C/g%3E%3C/svg%3E");
            background-attachment: fixed;
            animation: aurora 15s ease infinite;
            transition: left 0.3s ease, width 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 2px 0 20px rgba(0, 0, 0, 0.2);
            animation: slideIn 0.5s forwards;
        }

        @keyframes aurora {
            0% {
                background-position: 0% 0%;
            }

            50% {
                background-position: 100% 100%;
            }

            100% {
                background-position: 0% 0%;
            }
        }

        .sidebar .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px 10px;
            transition: all 0.4s ease;
        }

        .sidebar .logo-container img {
            width: 60px;
            height: 60px;
            transition: all 0.4s ease;
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.5));
        }

        .sidebar:hover .logo-container img {
            width: 70px;
            height: 70px;
            transform: rotate(360deg);
        }

        .sidebar .menu-title {
            font-family: 'Montserrat', sans-serif;
            padding: 15px 5px;
            font-size: 1.2rem;
            color: #fff;
            text-align: center;
            font-weight: 600;
            opacity: 0;
            transition: opacity 0.4s ease, transform 0.6s ease;
            transform: translateY(-10px);
            background: linear-gradient(90deg, #ff9a9e, #fad0c4, #ffecd2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .sidebar .menu-quote {
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            color: #ffecd2;
            text-align: center;
            opacity: 0;
            transition: opacity 0.4s ease, transform 0.6s ease;
            transform: translateY(10px);
        }

        .sidebar:hover .menu-title,
        .sidebar:hover .menu-quote {
            opacity: 1;
            transform: translateY(0);
        }

        .sidebar a {
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            opacity: 0.8;
            border-left: 4px solid transparent;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
            opacity: 1;
            transform: translateX(5px);
            color: #ffecd2;
            border-left: 4px solid #ffecd2;
        }

        .submenu {
            display: none;
            padding-left: 20px;
            background: rgba(0, 0, 0, 0.1);
            transition: max-height 0.4s ease, opacity 0.4s ease;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }

        .sidebar a:hover+.submenu,
        .submenu:hover {
            display: block;
            max-height: 300px;
            opacity: 1;
        }

        .submenu a {
            padding: 12px 15px;
            font-size: 0.9em;
        }

        .submenu a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar a i {
            min-width: 30px;
            transition: transform 0.3s ease;
            margin-right: 15px;
        }

        .sidebar a:hover i {
            transform: scale(1.2);
        }

        .sidebar a span {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar:hover a span {
            opacity: 1;
        }

        .sidebar {
            width: 70px;
            overflow: hidden;
            transition: width 0.4s ease;
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
            transition: opacity 0.4s ease;
        }

        .sidebar:hover .bottom-controls {
            display: flex;
            opacity: 1;
        }

        .bottom-controls a {
            display: block;
            margin: 10px 0;
            color: white;
            text-decoration: none;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .bottom-controls a:hover {
            color: #ffecd2;
            transform: translateY(-3px);
        }

        .footer-links {
            margin-top: 30px;
            padding: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .footer-links a {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            color: #ffecd2;
            text-decoration: none;
            margin: 8px 0;
            transition: all 0.3s ease;
            opacity: 0.7;
            border-radius: 5px;
        }

        .footer-links a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            opacity: 1;
            transform: translateX(5px);
        }

        .footer-links a i {
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .footer-links a span {
            display: none;
            transition: opacity 0.3s ease;
        }

        .sidebar:hover .footer-links a span {
            display: inline;
            opacity: 1;
        }

        .quick-links-heading {
            font-family: 'Montserrat', sans-serif;
            color: #ffecd2;
            font-size: 1.1rem;
            margin-bottom: 15px;
            text-align: center;
            opacity: 0;
            transition: opacity 0.4s ease, transform 0.4s ease;
            transform: translateY(-10px);
        }

        .sidebar:hover .quick-links-heading {
            opacity: 1;
            transform: translateY(0);
        }

        /* Loader styles */
        #loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1001;
            background-color: rgba(44, 62, 80, 0.9);
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

        /* Main content styles */
        #main-content {
            margin-left: 70px;
            padding: 20px;
            transition: margin-left 0.4s ease;
        }

        .sidebar:hover+#main-content {
            margin-left: 250px;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
            }

            .sidebar:hover {
                width: 200px;
            }

            #main-content {
                margin-left: 0;
            }

            .sidebar:hover+#main-content {
                margin-left: 200px;
            }
        }

        /* Additional enhancements */
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 35%, rgba(255, 255, 255, 0.2) 0%, transparent 25%),
                radial-gradient(circle at 75% 44%, rgba(255, 255, 255, 0.2) 0%, transparent 20%);
            opacity: 0.1;
            transition: opacity 0.3s ease;
        }

        .sidebar:hover::before {
            opacity: 0.2;
        }

        .sidebar a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 1px;
            width: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.2), transparent);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }

        .sidebar a:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        /* Scrollbar styles */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
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
                <?php
                foreach ($quick_links as $title => $item) {
                    echo "<a href='{$item['link']}'><i class='{$item['icon']}'></i> <span>{$title}</span></a>";
                }
                ?>
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
            setTimeout(function () {
                const loaderWrapper = document.getElementById('loader-wrapper');
                loaderWrapper.style.opacity = '1';
                loaderWrapper.style.transition = 'opacity 0.5s ease-out';

                setTimeout(function () {
                    loaderWrapper.style.opacity = '0';
                    setTimeout(function () {
                        loaderWrapper.style.display = 'none';
                    }, 500);
                }, 2500);
            }, 0);
        });
    </script>
</body>

</html>