<?php
include 'db/config.php';

// Check if the category ID is set and is numeric
if (!isset($_GET['c_id']) || !is_numeric($_GET['c_id'])) {
    die('Invalid Category ID.');
}

$c_id = intval($_GET['c_id']);

// Query to get category details
$query = "SELECT * FROM categories WHERE c_id = $c_id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $category = mysqli_fetch_assoc($result);
} else {
    echo "Error: No category found with ID " . $c_id;
    echo "Query Error: " . mysqli_error($conn);
    exit; // Stop execution
}

$category_name = isset($category['category_name']) ? $category['category_name'] : '';
$description = isset($category['description']) ? $category['description'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta name="description" content="Category Edit Page" />
    <meta name="keywords" content="admin, edit, category, bootstrap, responsive" />
    <meta name="author" content="Your Name" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Edit Category</title>

    <link
    rel="shortcut icon"
    type="image/x-icon"
    href="assets/img/favicon.jpg" />
    
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css" />
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css" />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <style>
        .alert {
            display: none;
            position: fixed;
            top: 10px;
            right: 20px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            z-index: 1000;
        }
        .error-message {
            color: red;
            font-size: 0.9rem;
        }
        .valid {
            border-color: green;
        }
        .invalid {
            border-color: red;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="header">
            <?php include 'includes/header.php'; ?>
        </div>
        <?php include 'includes/sidebar.php'; ?>

        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Edit Category</h4>
                        <h6>Edit existing Category</h6>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="alert" id="success-alert">Update successful!</div>

                        <form id="edit-category-form" method="POST">
                            <input type="hidden" name="c_id" value="<?php echo htmlspecialchars($category['c_id']); ?>" />
                            
                            <div class="row">
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <input type="text" name="category_name" class="form-control" value="<?php echo htmlspecialchars($category['category_name']); ?>" id="category-name" />
                                        <div id="category-name-error" class="error-message"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
    <div class="form-group">
        <label>Description</label>
        <input type="text" name="description" class="form-control" value="<?php echo htmlspecialchars($category['description']); ?>" id="description" />
        <div id="description-error" class="error-message"></div> <!-- Error message container -->
    </div>
</div>

                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">Choose Status</option>
                                            <option value="Not Available" <?php echo ($category['status'] == 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                                            <option value="Available" <?php echo ($category['status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary">Update Category</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/feather.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>
    <script src="assets/js/script.js"></script>

    <script>
$(document).ready(function() {
    // Store the original values of the form fields
    var originalCategoryName = $('input[name="category_name"]').val().trim();
    var originalDescription = $('input[name="description"]').val().trim();
    var originalStatus = $('select[name="status"]').val();

    // Real-time validation for Category Name
    $('#category-name').on('input', function() {
        var categoryName = $(this).val().trim();
        var regex = /^[A-Za-z\s]*$/; // Only letters and spaces allowed
        var errorMessage = '';
        if (categoryName === '') {
            errorMessage = 'Category Name cannot be empty.';
            $(this).removeClass('valid').addClass('invalid');
        } else if (!regex.test(categoryName)) {
            errorMessage = 'Category Name can only contain letters.';
            $(this).removeClass('valid').addClass('invalid');
        } else {
            $(this).removeClass('invalid').addClass('valid');
        }
        $('#category-name-error').text(errorMessage);
    });

    // Real-time validation for Description
    $('#description').on('input', function() {
        var description = $(this).val().trim();
        var errorMessage = '';
        if (description === '') {
            errorMessage = 'Description cannot be empty.';
            $(this).removeClass('valid').addClass('invalid');
        } else {
            $(this).removeClass('invalid').addClass('valid');
        }
        $('#description-error').text(errorMessage); // Display the error message
    });

    // Form submission with validation
    $('#edit-category-form').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        
        var categoryName = $('input[name="category_name"]').val().trim();
        var description = $('input[name="description"]').val().trim();
        var status = $('select[name="status"]').val();
        var hasError = false; // Flag to check if any validation error occurred

        // Validate Category Name
        if (categoryName === '') {
            $('#category-name').addClass('invalid');
            $('#category-name-error').text('Category Name is required.');
            hasError = true; // Mark that there is a validation error
        } else {
            $('#category-name').removeClass('invalid').addClass('valid');
        }

        // Validate Description
        if (description === '') {
            $('#description').addClass('invalid');
            $('#description-error').text('Description is required.');
            hasError = true; // Mark that there is a validation error
        } else {
            $('#description').removeClass('invalid').addClass('valid');
            $('#description-error').text(''); // Clear the error message when valid
        }

        // If there are validation errors, prevent form submission
        if (hasError) {
            return false; // Prevent form submission
        }

        // Check if any field has changed
        if (categoryName === originalCategoryName && description === originalDescription && status === originalStatus) {
            $('#success-alert').text('Nothing has changed.').css('background-color', '#f44336').fadeIn().delay(2000).fadeOut(); // Display message
            return false;
        }

        // AJAX request to update the category
        $.ajax({
            url: 'functions/updatecategory.php', // URL to the update script
            type: 'POST',
            data: $(this).serialize(), // Serialize form data
            success: function(response) {
                if (response.trim() === 'success') {
                    $('#success-alert').text('Update successful!').css('background-color', '#4CAF50').fadeIn().delay(2000).fadeOut();
                    setTimeout(function() {
                        window.location.href = 'categorylist.php';
                    }, 2000);
                } else {
                    $('#success-alert').text('An error occurred: ' + response).css('background-color', '#f44336').fadeIn().delay(2000).fadeOut();
                }
            },
            error: function() {
                $('#success-alert').text('An error occurred. Please try again.').css('background-color', '#f44336').fadeIn().delay(2000).fadeOut();
            }
        });
    });
});



    </script>
</body>
</html>
