<?php
include "sider.php";

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$deleteMessage = '';

// Delete category if requested
if (isset($_POST['delete'])) {
    $id = $_POST['delete'];

    // Check if the category has associated foods
    $check_sql = "SELECT COUNT(*) AS count FROM Foods WHERE CategoryID = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_row = $check_result->fetch_assoc();
    $foodCount = $check_row['count'];
    $check_stmt->close();

    if ($foodCount > 0) {
        $deleteMessage = "Cannot delete category. There are $foodCount associated foods.";
    } else {
        // Delete the category
        $delete_sql = "DELETE FROM Categories WHERE CategoryID = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);
        $delete_stmt->execute();
        $delete_stmt->close();
        $deleteMessage = "Category deleted successfully.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .main-content {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #f8f8f8;
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        .card-body {
            padding: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }
        #pagination {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        .btn-disabled {
            background-color: #6c757d;
            border-color: #6c757d;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <?php if (!empty($deleteMessage)): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $deleteMessage; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h1>Categories</h1>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search categories...">
                </div>
            </div>
            <div class="card-body">
                <a href="add_category.php" class="btn btn-primary mb-3">Add New Category</a>
                <table class="table table-striped table-hover" id="categoryTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Food Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div id="pagination"></div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the following category?</p>
                    <p><strong>Name:</strong> <span id="categoryName"></span></p>
                    <p><strong>Description:</strong> <span id="categoryDescription"></span></p>
                    <p><strong>Image:</strong></p>
                    <img id="categoryImage" src="" alt="Category Image" style="max-width: 100%; max-height: 200px;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="">
                        <input type="hidden" name="delete" id="deleteCategoryId">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       $(document).ready(function() {
    let currentPage = 1;
    const itemsPerPage = 5;
    updateContent("", currentPage);

    $("#searchInput").on("input", function() {
        let searchTerm = $(this).val().trim();
        currentPage = 1;
        updateContent(searchTerm, currentPage);
    });

    function updateContent(searchTerm, page) {
        $.ajax({
            url: "get_categories.php",
            type: "GET",
            data: { search: searchTerm, page: page, limit: itemsPerPage },
            success: function(response) {
                let categories = JSON.parse(response);
                let tableRows = '';
                categories.forEach(category => {
                    let deleteButton = category.FoodCount > 0 
                        ? `<button class='btn btn-sm btn-disabled' disabled>Cannot Be Deleted</button>`
                        : `<button class='btn btn-sm btn-danger delete-btn' data-category-id='${category.CategoryID}' data-category-name='${category.Name}' data-category-description='${category.Description}' data-category-image='${category.image_path}'>Delete</button>`;
                    tableRows += `<tr>
                        <td>${category.Name}</td>
                        <td>${category.Description}</td>
                        <td>${category.image_path ? `<img src='../client/asset/${category.image_path.split('/').pop()}' alt='Category Image' style='max-width: 100px;'>` : 'No image'}</td>
                        <td>${category.FoodCount}</td>
                        <td>
                            <a href='edit_category.php?id=${category.CategoryID}' class='btn btn-sm btn-primary me-2'>Edit</a>
                            ${deleteButton}
                        </td>
                    </tr>`;
                });
                $("#categoryTable tbody").html(tableRows);
                updatePagination(page, searchTerm);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                alert("An error occurred while fetching category data.");
            }
        });
    }

    function updatePagination(page, searchTerm) {
        $.ajax({
            url: "get_category_count.php",
            type: "GET",
            data: { search: searchTerm },
            success: function(response) {
                let data = JSON.parse(response);
                let totalItems = data.total;
                let totalPages = Math.ceil(totalItems / itemsPerPage);
                let paginationHtml = '<ul class="pagination">';
                
                paginationHtml += `<li class="page-item ${page === 1 ? 'disabled' : ''}">
                                    <a class="page-link" href="#" data-page="${page - 1}">&laquo; Previous</a>
                                   </li>`;
                
                for (let i = 1; i <= totalPages; i++) {
                    paginationHtml += `<li class="page-item ${i === page ? 'active' : ''}">
                                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                                        </li>`;
                }
                
                paginationHtml += `<li class="page-item ${page === totalPages ? 'disabled' : ''}">
                                    <a class="page-link" href="#" data-page="${page + 1}">Next &raquo;</a>
                                   </li>`;
                
                paginationHtml += '</ul>';
                $("#pagination").html(paginationHtml);
                $(document).off('click', '.pagination .page-link').on('click', '.pagination .page-link', function(e) {
                    e.preventDefault();
                    let clickedPage = $(this).data('page');
                    if (clickedPage >= 1 && clickedPage <= totalPages) {
                        currentPage = clickedPage;
                        updateContent(searchTerm, currentPage);
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                alert("An error occurred while fetching category count.");
            }
        });
    }

    $(document).on('click', '.delete-btn', function() {
        let categoryId = $(this).data('category-id');
        let categoryName = $(this).data('category-name');
        let categoryDescription = $(this).data('category-description');
        let categoryImage = $(this).data('category-image');
        showDeleteModal(categoryId, categoryName, categoryDescription, categoryImage);
    });

    function showDeleteModal(categoryId, categoryName, categoryDescription, categoryImage) {
        $('#categoryName').text(categoryName);
        $('#categoryDescription').text(categoryDescription);
        $('#categoryImage').attr('src', categoryImage ? `../client/asset/${categoryImage.split('/').pop()}` : '');
        $('#deleteCategoryId').val(categoryId);
        $('#deleteModal').modal('show');
    }
});
    </script>
</body>
</html>
