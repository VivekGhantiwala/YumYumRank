<?php
include "sider.php";
include "connection.php";

$notification = '';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_ingredient'])) {
    $ingredient_id = mysqli_real_escape_string($conn, $_POST['ingredient_id']);
    
    // Check if the ingredient is used in any products
    $check_query = "SELECT COUNT(*) as count FROM food_ingredients WHERE IngredientID = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "i", $ingredient_id);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    $row = mysqli_fetch_assoc($check_result);
    $used_count = $row['count'];
    
    if ($used_count > 0) {
        $notification = '<div class="alert alert-warning" role="alert">Cannot delete ingredient. It is used in ' . $used_count . ' product(s).</div>';
    } else {
        $delete_query = "DELETE FROM Ingredients WHERE IngredientID = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($delete_stmt, "i", $ingredient_id);
        $delete_result = mysqli_stmt_execute($delete_stmt);
        
        if ($delete_result) {
            $notification = '<div class="alert alert-success" role="alert">Ingredient deleted successfully!</div>';
        } else {
            $notification = '<div class="alert alert-danger" role="alert">Error deleting ingredient: ' . mysqli_error($conn) . '</div>';
        }
        mysqli_stmt_close($delete_stmt);
    }
    mysqli_stmt_close($check_stmt);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Ingredients - YumYumRank Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .fade-in {
            opacity: 0;
        }

        .slide-in {
            transform: translateY(50px);
            opacity: 0;
        }

        .table-row {
            opacity: 0;
        }

        .btn:hover {
            transform: scale(1.1);
            transition: 0.3s;
        }

        /* Ensure the last record is visible */
        .table-responsive {
            padding-bottom: 100px;
        }

        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
            transform: scale(0.8);
        }

        .modal.show .modal-dialog {
            transform: scale(1);
        }
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
</head>

<body>
    <div class="container mx-auto mt-5 bg-gray-100 p-4 animate__animated animate__fadeIn">
        <h1 class="mb-4 fade-in animate__animated animate__fadeInUp">View Ingredients</h1>

        <?php 
        if (!empty($notification)) {
            echo $notification;
        }
        ?>

        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Search ingredients...">
        </div>

        <!-- Add Ingredient Button -->
        <div class="mb-4">
            <a href="add_ingredient.php" class="btn btn-primary animate__animated animate__fadeIn">Add New Ingredient</a>
        </div>

        <!-- Ingredients Table -->
        <div class="ingredient-table slide-in mt-5 animate__animated animate__fadeInUp">
            <h2>Existing Ingredients</h2>
            <div class="table-responsive">
                <table class="table table-striped table-auto w-full text-left text-gray-500 animate__animated animate__fadeInUp">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Health Impact</th>
                            <th>Used In</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="ingredientTableBody">
                    </tbody>
                </table>
            </div>
        </div>
        <div id="paginationContainer"></div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the following ingredient?</p>
                    <ul>
                        <li><strong>Name:</strong> <span id="ingredientName"></span></li>
                        <li><strong>Description:</strong> <span id="ingredientDescription"></span></li>
                        <li><strong>Health Impact:</strong> <span id="ingredientHealthImpact"></span></li>
                        <li><strong>Used In:</strong> <span id="ingredientUsageCount"></span> food(s)</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="ingredient_id" id="ingredientId">
                        <button type="submit" name="delete_ingredient" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script>
        gsap.to('.fade-in', { opacity: 1, duration: 1 });
        gsap.to('.slide-in', { opacity: 1, y: 0, duration: 1 });
        gsap.to('.table-row', { opacity: 1, duration: 0.5, stagger: 0.2 });

        // Delete modal functionality
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const ingredientNameSpan = document.getElementById('ingredientName');
        const ingredientDescriptionSpan = document.getElementById('ingredientDescription');
        const ingredientHealthImpactSpan = document.getElementById('ingredientHealthImpact');
        const ingredientUsageCountSpan = document.getElementById('ingredientUsageCount');
        const ingredientIdInput = document.getElementById('ingredientId');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const description = this.getAttribute('data-description');
                const healthImpact = this.getAttribute('data-health-impact');
                const usageCount = this.getAttribute('data-usage-count');
                
                ingredientNameSpan.textContent = name;
                ingredientDescriptionSpan.textContent = description;
                ingredientHealthImpactSpan.textContent = healthImpact;
                ingredientUsageCountSpan.textContent = usageCount;
                ingredientIdInput.value = id;
                deleteModal.show();
            });
        });

        // Animate modal
        const modalElement = document.getElementById('deleteModal');
        modalElement.addEventListener('show.bs.modal', function (event) {
            gsap.from('.modal-content', {duration: 0.3, scale: 0.5, opacity: 0, ease: "back.out(1.7)"});
        });

        // AJAX search functionality
        const searchInput = document.getElementById('searchInput');
        const ingredientTableBody = document.getElementById('ingredientTableBody');
        const paginationContainer = document.getElementById('paginationContainer');
        let currentPage = 1;
        let totalPages = 1;
        const itemsPerPage = 5;

        function updateTable(data) {
            let tableRows = '';
            const startIndex = (currentPage - 1) * itemsPerPage + 1;
            data.forEach((row, index) => {
                const isUsed = parseInt(row.usage_count) > 0;
                const deleteButtonHtml = isUsed ? 
                    `<button type="button" class="btn btn-secondary btn-sm animate__animated animate__fadeInUp" disabled>Cannot Be Deleted</button>` :
                    `<button type="button" class="btn btn-danger btn-sm delete-btn animate__animated animate__fadeInUp" 
                        data-id="${row.IngredientID}" 
                        data-name="${row.Name}"
                        data-description="${row.description}"
                        data-health-impact="${row.HealthImpact}"
                        data-usage-count="${row.usage_count}">
                        Delete
                    </button>`;
                tableRows += `<tr class="table-row animate__animated animate__fadeInUp">
                                    <td>${startIndex + index}</td>
                                    <td>${row.Name}</td>
                                    <td>${row.description}</td>
                                    <td>${row.HealthImpact}</td>
                                    <td>${row.usage_count}</td>
                                    <td>
                                        ${deleteButtonHtml}
                                        <a href="update_ingredient.php?ingredient_id=${row.IngredientID}" class="btn btn-warning btn-sm animate__animated animate__fadeInUp">Update</a>
                                    </td>
                                </tr>`;
            });
            ingredientTableBody.innerHTML = tableRows;
            setTimeout(attachDeleteListeners, 100); 
        }

        function loadPage(page, searchTerm = '') {
            const url = `get_ingredients.php?page=${page}&limit=${itemsPerPage}&search=${encodeURIComponent(searchTerm)}`;
            console.log("Fetching URL:", url);
            console.log("Search term:", searchTerm);
            fetch(url)
                .then(response => {
                    console.log("Response status:", response.status); 
                    return response.json();
                })
                .then(data => {
                    updateTable(data);
                    const countUrl = `get_ingredient_count.php?search=${encodeURIComponent(searchTerm)}`;
                    console.log("Fetching count URL:", countUrl);
                    return fetch(countUrl);
                })
                .then(response => response.json())
                .then(countData => {
                    totalPages = Math.ceil(countData.total / itemsPerPage);
                    updatePagination();
                })
                .catch(error => {
                    console.error("Error fetching data:", error);
                });
        }

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim();
            currentPage = 1; // Reset page to 1 on search
            loadPage(currentPage, searchTerm); 
        });

        function updatePagination() {
            let paginationHtml = '';
            const maxVisiblePages = 5;
            const ellipsis = '<li class="page-item disabled"><span class="page-link">...</span></li>';

            // Previous button
            paginationHtml += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                                    <a class="page-link" href="#" data-page="${currentPage - 1}">&laquo; Previous</a>
                                </li>`;

            if (totalPages <= maxVisiblePages) {
                // Show all pages if total pages are less than or equal to maxVisiblePages
                for (let i = 1; i <= totalPages; i++) {
                    paginationHtml += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                                        </li>`;
                }
            } else {
                // Show first page
                paginationHtml += `<li class="page-item ${currentPage === 1 ? 'active' : ''}">
                                        <a class="page-link" href="#" data-page="1">1</a>
                                    </li>`;

                // Calculate start and end of visible pages
                let start = Math.max(2, currentPage - Math.floor(maxVisiblePages / 2));
                let end = Math.min(totalPages - 1, start + maxVisiblePages - 3);
                start = Math.max(2, end - maxVisiblePages + 3);

                if (start > 2) paginationHtml += ellipsis;

                for (let i = start; i <= end; i++) {
                    paginationHtml += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                                        </li>`;
                }

                if (end < totalPages - 1) paginationHtml += ellipsis;

                // Show last page
                paginationHtml += `<li class="page-item ${currentPage === totalPages ? 'active' : ''}">
                                        <a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>
                                    </li>`;
            }

            // Next button
            paginationHtml += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                                    <a class="page-link" href="#" data-page="${currentPage + 1}">Next &raquo;</a>
                                </li>`;

            paginationContainer.innerHTML = '<ul class="pagination">' + paginationHtml + '</ul>';
            
            const pageLinks = paginationContainer.querySelectorAll('.page-link');
            pageLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const newPage = parseInt(link.dataset.page);
                    if (newPage >= 1 && newPage <= totalPages && newPage !== currentPage) {
                        currentPage = newPage;
                        loadPage(currentPage, searchInput.value.trim());
                    }
                });
            });
        }

        function attachDeleteListeners() {
            const deleteButtons = document.querySelectorAll('.delete-btn:not([disabled])');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const description = this.getAttribute('data-description');
                    const healthImpact = this.getAttribute('data-health-impact');
                    const usageCount = this.getAttribute('data-usage-count');
                    
                    document.getElementById('ingredientName').textContent = name;
                    document.getElementById('ingredientDescription').textContent = description;
                    document.getElementById('ingredientHealthImpact').textContent = healthImpact;
                    document.getElementById('ingredientUsageCount').textContent = usageCount;
                    document.getElementById('ingredientId').value = id;
                    
                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    deleteModal.show();
                });
            });
        }

        // Initial load
        loadPage(1);
    </script>
</body>

</html>

<?php mysqli_close($conn); ?>
