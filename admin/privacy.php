<?php
include "sider.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YumYumRank - Privacy Policy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .content-section {
            opacity: 1;
            transform: none;
        }

        .policy-icon {
            font-size: 3rem;
            color: #4A90E2;
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .5;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8 ml-64"> <!-- Added margin-left to accommodate sidebar -->
        <h1 class="text-4xl font-bold text-center mb-8 animate-pulse">Privacy Policy</h1>
        
        <div class="content-section bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center mb-4">
                <i class="fas fa-user-shield policy-icon mr-4"></i>
                <h2 class="text-2xl font-semibold">Information Collection</h2>
            </div>
            <p class="text-gray-700">At YumYumRank, we collect information to provide better services to our users. This includes personal information such as your name, email address, and dietary preferences. We also collect data on your interactions with our platform to improve our recommendations and user experience.</p>
        </div>

        <div class="content-section bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center mb-4">
                <i class="fas fa-lock policy-icon mr-4"></i>
                <h2 class="text-2xl font-semibold">Data Security</h2>
            </div>
            <p class="text-gray-700">We implement a variety of security measures to maintain the safety of your personal information. This includes encryption of sensitive data, regular security audits, and strict access controls for our employees. Your trust is important to us, and we strive to use commercially acceptable means to protect your personal information.</p>
        </div>

        <div class="content-section bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center mb-4">
                <i class="fas fa-share-alt policy-icon mr-4"></i>
                <h2 class="text-2xl font-semibold">Information Sharing</h2>
            </div>
            <p class="text-gray-700">YumYumRank does not sell, trade, or rent users' personal identification information to others. We may share generic aggregated demographic information not linked to any personal identification information regarding visitors and users with our business partners and trusted affiliates for the purposes outlined above.</p>
        </div>

        <div class="content-section bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center mb-4">
                <i class="fas fa-cookie-bite policy-icon mr-4"></i>
                <h2 class="text-2xl font-semibold">Cookies Usage</h2>
            </div>
            <p class="text-gray-700">YumYumRank uses "cookies" to enhance user experience. A cookie is a small piece of data stored on the user's computer by the web browser while browsing our website. These are used to remember user preferences and improve our services. Users can choose to set their web browser to refuse cookies, or to alert you when cookies are being sent.</p>
        </div>

    </div>

    <script>
        // Removed GSAP animations to ensure content is always visible
    </script>
</body>
</html>