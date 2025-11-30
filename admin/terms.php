<?php
include "sider.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - YumYumRank</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .terms-icon {
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
        <h1 class="text-4xl font-bold text-center mb-8 animate-fade-in">Terms of Service</h1>
        
        <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-6 animate-fade-in">
            <div class="flex items-center mb-4">
                <i class="fas fa-handshake terms-icon mr-4"></i>
                <h2 class="text-2xl font-semibold">1. Acceptance of Terms</h2>
            </div>
            <p class="mb-4 text-gray-700">By accessing or using YumYumRank, you agree to be bound by these Terms of Service and all applicable laws and regulations. If you do not agree with any part of these terms, you may not use our service.</p>
        </div>
        
        <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-6 animate-fade-in">
            <div class="flex items-center mb-4">
                <i class="fas fa-check-circle terms-icon mr-4"></i>
                <h2 class="text-2xl font-semibold">2. Use of Service</h2>
            </div>
            <p class="mb-4 text-gray-700">You agree to use YumYumRank only for purposes that are legal, proper, and in accordance with these Terms and any applicable laws or regulations. Misuse of our service may result in termination of your account.</p>
        </div>
        
        <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-6 animate-fade-in">
            <div class="flex items-center mb-4">
                <i class="fas fa-user-shield terms-icon mr-4"></i>
                <h2 class="text-2xl font-semibold">3. User Account</h2>
            </div>
            <p class="mb-4 text-gray-700">You are responsible for maintaining the confidentiality of your account and password. You agree to accept responsibility for all activities that occur under your account. Notify us immediately of any unauthorized use.</p>
        </div>
        
        <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-6 animate-fade-in">
            <div class="flex items-center mb-4">
                <i class="fas fa-file-alt terms-icon mr-4"></i>
                <h2 class="text-2xl font-semibold">4. Content</h2>
            </div>
            <p class="mb-4 text-gray-700">Users are solely responsible for the content they post. YumYumRank does not guarantee the accuracy, integrity, or quality of user-generated content. We reserve the right to remove any content that violates our policies.</p>
        </div>
        
        <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-6 animate-fade-in">
            <div class="flex items-center mb-4">
                <i class="fas fa-ban terms-icon mr-4"></i>
                <h2 class="text-2xl font-semibold">5. Termination</h2>
            </div>
            <p class="mb-4 text-gray-700">We reserve the right to terminate or suspend access to our service immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms. All provisions of the Terms shall survive termination.</p>
        </div>
    </div>

    <script>
        // Fade-in animation for content sections
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.animate-fade-in');
            sections.forEach((section, index) => {
                setTimeout(() => {
                    section.style.opacity = '0';
                    section.style.transform = 'translateY(20px)';
                    section.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    
                    setTimeout(() => {
                        section.style.opacity = '1';
                        section.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 200);
            });
        });

        // Smooth scroll to sections when clicking on navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add hover effect to section headers
        const sectionHeaders = document.querySelectorAll('.bg-white h2');
        sectionHeaders.forEach(header => {
            header.addEventListener('mouseenter', () => {
                header.style.color = '#4A90E2';
                header.style.transition = 'color 0.3s ease';
            });
            header.addEventListener('mouseleave', () => {
                header.style.color = '';
            });
        });
    </script>
</body>
</html>