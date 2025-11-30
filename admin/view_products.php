<?php
include "sider.php";
include "connection.php";

// Handle delete form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_food'])) {
    $food_id = $_POST['food_id'];

    // Delete from food_ingredients table
    $sql_delete_food_ingredients = "DELETE FROM food_ingredients WHERE FoodID = $food_id";
    mysqli_query($conn, $sql_delete_food_ingredients);

    // Delete from Nutritional_info table
    $sql_delete_nutritional = "DELETE FROM Nutritional_info WHERE FoodID = $food_id";
    mysqli_query($conn, $sql_delete_nutritional);

    // Delete from alternatives table
    $sql_delete_alternatives = "DELETE FROM alternatives WHERE OriginalFoodID = $food_id OR AlternativeFoodID = $food_id";
    mysqli_query($conn, $sql_delete_alternatives);

    // Delete from Foods table
    $sql_delete_food = "DELETE FROM Foods WHERE FoodID = $food_id";
    mysqli_query($conn, $sql_delete_food);
}

// Fetch all foods
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$limit = 5; // Items per page
$offset = ($page - 1) * $limit;

$whereClause = '';
if (!empty($search)) {
    $whereClause = "WHERE f.Name LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR f.Description LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
}

$query = "SELECT f.FoodID, f.Name AS FoodName, f.Description, f.Price, c.Name AS CategoryName, f.Image, f.HealthScore, f.created_at, f.about, f.product_url,
          n.Calories, n.Proteins, n.Carbs, n.Fats, n.Vitamins, n.Minerals,
          GROUP_CONCAT(CONCAT(i.Name, ' (', fi.Quantity, ' ', fi.Unit, ')') SEPARATOR ', ') AS Ingredients
          FROM Foods f 
          LEFT JOIN Categories c ON f.CategoryID = c.CategoryID
          LEFT JOIN Nutritional_info n ON f.FoodID = n.FoodID
          LEFT JOIN food_ingredients fi ON f.FoodID = fi.FoodID
          LEFT JOIN Ingredients i ON fi.IngredientID = i.IngredientID
          $whereClause
          GROUP BY f.FoodID
          LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Foods - YumYumRank Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.4/dist/locomotive-scroll.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3Cpath d='M6 5V0H5v5H0v1h5v94h1V6h94V5H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            background-attachment: fixed;
            transition: background-color 0.5s ease;
            color: #333;
            line-height: 1.6;
            animation: bodyAurora 15s ease infinite;
        }

        @keyframes bodyAurora {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
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

        .content-wrapper {
            margin-left: 60px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .sidebar-expanded .content-wrapper {
            margin-left: 250px;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0;
            }
        }

        .table {
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background-color: #4a5568;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            padding: 12px;
        }

        .table td {
            padding: 12px;
            vertical-align: middle;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }

        .table-hover tbody tr:hover {
            background-color: #e9ecef;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #4a5568;
            border-color: #4a5568;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2d3748;
            border-color: #2d3748;
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .slide-in {
            animation: slideIn 0.5s ease-in-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .about-truncate,
        .product-url-text {
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
        }

        .about-full {
            display: none;
            max-width: 300px;
            white-space: normal;
            word-wrap: break-word;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table td,
        .table th {
            white-space: normal;
            word-wrap: break-word;
            max-width: 200px;
        }

        .nutritional-info,
        .ingredients {
            max-width: 200px;
            white-space: normal;
            word-wrap: break-word;
        }
    </style>
</head>

<body>
    <div class="content-wrapper">
        <h1 class="mb-4 fade-in">View Foods</h1>

        <!-- Add Product Button -->
        <a href="add_product.php" class="btn btn-primary mb-3">Add Product</a>

        <!-- Search Input -->
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Search foods...">
        </div>

        <!-- Foods Table -->
        <div class="food-table slide-in">
            <h2>Existing Foods</h2>
            <div class="table-responsive">
                <table class="table table-striped" id="foodTable">
                    <thead>
                        <tr>
                            <th>FoodID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>HealthScore</th>
                            <th>Created At</th>
                            <th>About</th>
                            <th>Product URL</th>
                            <th>Nutritional Info</th>
                            <th>Ingredients</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mt-4">
                <!-- Pagination links will be dynamically inserted here -->
            </ul>
        </nav>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the following food item?</p>
                    <ul>
                        <li><strong>Name:</strong> <span id="foodName"></span></li>
                        <li><strong>Description:</strong> <span id="foodDescription"></span></li>
                        <li><strong>Price:</strong> <span id="foodPrice"></span></li>
                        <li><strong>Category:</strong> <span id="foodCategory"></span></li>
                        <li><strong>Health Score:</strong> <span id="foodHealthScore"></span></li>
                        <li><strong>About:</strong> <span id="foodAbout"></span></li>
                        <li><strong>Product URL:</strong> <span id="foodProductURL"></span></li>
                        <li><strong>Nutritional Info:</strong>
                            <ul>
                                <li>Calories: <span id="foodCalories"></span></li>
                                <li>Proteins: <span id="foodProteins"></span>g</li>
                                <li>Carbs: <span id="foodCarbs"></span>g</li>
                                <li>Fats: <span id="foodFats"></span>g</li>
                                <li>Vitamins: <span id="foodVitamins"></span></li>
                                <li>Minerals: <span id="foodMinerals"></span></li>
                            </ul>
                        </li>
                        <li><strong>Ingredients:</strong> <span id="foodIngredients"></span></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="">
                        <input type="hidden" name="food_id" id="modalFoodID">
                        <button type="submit" name="delete_food" class="btn btn-danger">Yes, Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script>
        // GSAP Animations
        document.addEventListener('DOMContentLoaded', (event) => {
            gsap.to('.fade-in', { duration: 1, opacity: 1 });
            gsap.to('.slide-in', { duration: 1, y: 0, opacity: 1, stagger: 0.2 });
        });

        // Populate and show the delete confirmation modal
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var foodID = button.getAttribute('data-foodid');
            var name = button.getAttribute('data-name');
            var description = button.getAttribute('data-description');
            var price = button.getAttribute('data-price');
            var category = button.getAttribute('data-category');
            var healthScore = button.getAttribute('data-healthscore');
            var about = button.getAttribute('data-about');
            var product_url = button.getAttribute('data-product_url');
            var calories = button.getAttribute('data-calories');
            var proteins = button.getAttribute('data-proteins');
            var carbs = button.getAttribute('data-carbs');
            var fats = button.getAttribute('data-fats');
            var vitamins = button.getAttribute('data-vitamins');
            var minerals = button.getAttribute('data-minerals');
            var ingredients = button.getAttribute('data-ingredients');

            var modalFoodID = deleteModal.querySelector('#modalFoodID');
            var modalFoodName = deleteModal.querySelector('#foodName');
            var modalFoodDescription = deleteModal.querySelector('#foodDescription');
            var modalFoodPrice = deleteModal.querySelector('#foodPrice');
            var modalFoodCategory = deleteModal.querySelector('#foodCategory');
            var modalFoodHealthScore = deleteModal.querySelector('#foodHealthScore');
            var modalFoodAbout = deleteModal.querySelector('#foodAbout');
            var modalFoodProductURL = deleteModal.querySelector('#foodProductURL');
            var modalFoodCalories = deleteModal.querySelector('#foodCalories');
            var modalFoodProteins = deleteModal.querySelector('#foodProteins');
            var modalFoodCarbs = deleteModal.querySelector('#foodCarbs');
            var modalFoodFats = deleteModal.querySelector('#foodFats');
            var modalFoodVitamins = deleteModal.querySelector('#foodVitamins');
            var modalFoodMinerals = deleteModal.querySelector('#foodMinerals');
            var modalFoodIngredients = deleteModal.querySelector('#foodIngredients');

            modalFoodID.value = foodID;
            modalFoodName.textContent = name;
            modalFoodDescription.textContent = description;
            modalFoodPrice.textContent = price;
            modalFoodCategory.textContent = category;
            modalFoodHealthScore.textContent = healthScore;
            modalFoodAbout.textContent = about;
            modalFoodProductURL.textContent = product_url;
            modalFoodCalories.textContent = calories;
            modalFoodProteins.textContent = proteins;
            modalFoodCarbs.textContent = carbs;
            modalFoodFats.textContent = fats;
            modalFoodVitamins.textContent = vitamins;
            modalFoodMinerals.textContent = minerals;
            modalFoodIngredients.textContent = ingredients;
        });

        // Handle sidebar hover effect
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('.sidebar');
            const contentWrapper = document.querySelector('.content-wrapper');

            sidebar.addEventListener('mouseenter', function () {
                document.body.classList.add('sidebar-expanded');
            });

            sidebar.addEventListener('mouseleave', function () {
                document.body.classList.remove('sidebar-expanded');
            });
        });

        // Ajax search functionality
        $(document).ready(function () {
            let currentPage = 1;
            const itemsPerPage = 5;
            let foodIdCounter = 1; // Initialize a counter for FoodID

            function loadFoods(page, search = '') {
                $.ajax({
                    url: 'get_foods.php',
                    method: 'GET',
                    dataType: 'json',
                    data: { page: page, search: search, limit: itemsPerPage },
                    success: function (response) {
                        let tableRows = '';
                        response.forEach(row => {
                            tableRows += `<tr>
                                <td>${(page - 1) * itemsPerPage + foodIdCounter++}</td> <!-- Manually assigned and incremented FoodID -->
                                <td>${row.FoodName}</td>
                                <td>${row.Description}</td>
                                <td>${row.Price}</td>
                                <td>${row.CategoryName}</td>
                                <td><img src='../client/asset/products/${basename(row.Image)}' width='100' alt='${row.FoodName}'></td>
                                <td>${row.HealthScore}</td>
                                <td>${row.created_at}</td>
                                <td>
                                    <div class='about-truncate' onclick='toggleAbout(this)'>${row.about.substring(0, 50)}...</div>
                                    <div class='about-full' style='display:none;'>${row.about}</div>
                                </td>
                                <td class='product-url-text' title="${row.product_url}">${row.product_url}</td>
                                <td class='nutritional-info'>Calories: ${row.Calories}<br>Proteins: ${row.Proteins}g<br>Carbs: ${row.Carbs}g<br>Fats: ${row.Fats}g<br>Vitamins: ${row.Vitamins}g<br>Minerals: ${row.Minerals}g</td>
                                <td class='ingredients'>${row.Ingredients}</td>
                                <td>
                                    <div class='btn-group' role='group'>
                                        <button type='button' class='btn btn-danger btn-sm delete-btn' data-bs-toggle='modal' data-bs-target='#deleteModal' data-foodid="${row.FoodID}" data-name="${row.FoodName}" data-description="${row.Description}" data-price="${row.Price}" data-category="${row.CategoryName}" data-image="${row.Image}" data-healthscore="${row.HealthScore}" data-about="${row.about}" data-product_url="${row.product_url}" data-calories="${row.Calories}" data-proteins="${row.Proteins}" data-carbs="${row.Carbs}" data-fats="${row.Fats}" data-vitamins="${row.Vitamins}" data-minerals="${row.Minerals}" data-ingredients="${row.Ingredients}">Delete</button>
                                        <a href='update_food.php?id=${row.FoodID}' class='btn btn-warning btn-sm update-btn'>Update</a>
                                    </div>
                                </td>
                            </tr>`;
                        });
                        $('#foodTable tbody').html(tableRows);
                        updatePagination(page);
                        foodIdCounter = 1; // Reset the counter after populating the table
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        alert("An error occurred while fetching food data.");
                    }
                });
            }

            function updatePagination(currentPage) {
                $.ajax({
                    url: 'get_food_count.php',
                    method: 'GET',
                    dataType: 'json',
                    data: { search: $('#searchInput').val() },
                    success: function (response) {
                        const totalItems = response.total;
                        const totalPages = Math.ceil(totalItems / itemsPerPage);
                        let paginationHtml = '';

                        // Add Previous button
                        paginationHtml += `<li class="page-item ${currentPage == 1 ? 'disabled' : ''}">
                                            <a class="page-link" href="#" data-page="${currentPage - 1}">&laquo; Previous</a>
                                           </li>`;

                        const maxVisiblePages = 5;
                        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

                        if (startPage > 1) {
                            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`;
                            if (startPage > 2) {
                                paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                            }
                        }

                        for (let i = startPage; i <= endPage; i++) {
                            paginationHtml += `<li class="page-item ${i === parseInt(currentPage) ? 'active' : ''}">
                                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                                               </li>`;
                        }

                        if (endPage < totalPages) {
                            if (endPage < totalPages - 1) {
                                paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                            }
                            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a></li>`;
                        }

                        // Add Next button
                        paginationHtml += `<li class="page-item ${currentPage == totalPages ? 'disabled' : ''}">
                                            <a class="page-link" href="#" data-page="${currentPage + 1}">Next &raquo;</a>
                                           </li>`;

                        $('.pagination').html(paginationHtml);

                        // Remove fixed positioning
                        $('.pagination').css({
                            'position': 'static',
                            'margin-top': '20px',
                            'margin-bottom': '20px'
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        alert("An error occurred while fetching food count.");
                    }
                });
            }

            $('#searchInput').on('keyup', function () {
                currentPage = 1;
                loadFoods(currentPage, $(this).val());
            });

            $(document).on('click', '.pagination .page-link', function (e) {
                e.preventDefault();
                currentPage = $(this).data('page');
                loadFoods(currentPage, $('#searchInput').val());
                $('html, body').animate({
                    scrollTop: $("#foodTable").offset().top
                }, 500);
            });

            // Initial load
            loadFoods(currentPage);
        });

        function basename(path) {
            return path.split('/').pop();
        }

        function toggleAbout(element) {
            $(element).next('.about-full').toggle();
        }
    </script>
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        .pagination .page-item {
            margin: 0 5px;
        }

        .pagination .page-link {
            color: #333;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 0.5rem 0.75rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 5px;
        }

        .pagination .page-item.active .page-link {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            box-shadow: 0 2px 5px rgba(0, 123, 255, 0.5);
        }

        .pagination .page-link:hover {
            color: #fff;
            background-color: #0056b3;
            border-color: #0056b3;
            transform: translateY(-2px);
        }
    </style>
</body>

<?php
mysqli_close($conn);
?>