<?php
include "sider.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help - YumYumRank</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .help-icon {
            font-size: 2.5rem;
            color: #4A90E2;
        }
        
        .animate-fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8 ml-64"> <!-- Added margin-left to accommodate sidebar -->
        <h1 class="text-4xl font-bold text-center mb-8 animate-fade-in">Help Center</h1>
        
        <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-6 animate-fade-in">
            <div class="flex items-center mb-4">
                <i class="fas fa-question-circle help-icon mr-4"></i>
                <h2 class="text-2xl font-semibold">Frequently Asked Questions</h2>
            </div>
            
            <div class="mb-6">
                <h3 class="text-xl font-medium mb-2">How do I create an account?</h3>
                <p class="text-gray-700">To create an account, click on the "Sign Up" button in the top right corner of the homepage. Fill in your details and follow the prompts to complete registration.</p>
            </div>
            
            <div class="mb-6">
                <h3 class="text-xl font-medium mb-2">How can I reset my password?</h3>
                <p class="text-gray-700">Click on the "Forgot Password" link on the login page. Enter your email address, and we'll send you instructions to reset your password.</p>
            </div>
            
            <div class="mb-6">
                <h3 class="text-xl font-medium mb-2">How do I add a new product?</h3>
                <p class="text-gray-700">Navigate to the "Manage Foods" section in the sidebar, then click on "Add Products". Fill in the required information and submit the form.</p>
            </div>
            
            <div class="mb-6">
                <h3 class="text-xl font-medium mb-2">How can I contact support?</h3>
                <p class="text-gray-700">For additional help, please email us at support@yumyumrank.com or use the contact form in the "Contact Us" section.</p>
            </div>
        </div>
        
        <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-6 animate-fade-in">
            <div class="flex items-center mb-4">
                <i class="fas fa-book-open help-icon mr-4"></i>
                <h2 class="text-2xl font-semibold">User Guide</h2>
            </div>
            <p class="text-gray-700 mb-4">For a comprehensive guide on how to use YumYumRank, please download our user manual:</p>
            <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <i class="fas fa-download mr-2"></i>
                <span>Download User Guide</span>
            </a>
        </div>
        
        <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-6 animate-fade-in">
            <div class="flex items-center mb-4">
                <i class="fas fa-video help-icon mr-4"></i>
                <h2 class="text-2xl font-semibold">Video Tutorials</h2>
            </div>
            <p class="text-gray-700 mb-4">Check out our video tutorials for step-by-step guidance:</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-200 p-4 rounded">
                    <h3 class="font-medium mb-2">Getting Started with YumYumRank</h3>
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="bg-gray-200 p-4 rounded">
                    <h3 class="font-medium mb-2">Advanced Features Tutorial</h3>
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fade-in animation for content sections
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.animate-fade-in');
            sections.forEach((section, index) => {
                setTimeout(() => {
                    section.style.opacity = '1';
                }, index * 200);
            });
        });
    </script>
</body>
</html>