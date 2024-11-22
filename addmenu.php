<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db/config.php';

// Prepare the SQL query to fetch categories
$categoryQuery = "SELECT c.c_id, c.category_name 
                  FROM categories c
                  LEFT JOIN menu m ON c.category_name = m.category_name
                  GROUP BY c.c_id, c.category_name";
$categoryResult = $conn->query($categoryQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Add Product</title>

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.jpg" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css" />
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css" />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <style>
   
    #success-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: none;
        padding: 10px 20px;
        background-color: #28a745;
        color: white;
        border-radius: 5px;
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
                        <h4>Menu Add</h4>
                        <h6>Create new Menu</h6>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <!-- Success message (Positioned above the form) -->

                        <div class="alert alert-success" id="success-alert" style="display: none; margin-bottom: 20px;">Added successfully!</div>

                        <form id="menu-form" action="addmenu.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Menu Name</label>
                                        <input type="text" name="menu_name" class="form-control" id="menu_name" />
                                        <div class="error-message" id="menu-name-error"></div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="c_id" class="form-label">Category</label>
                                        <select name="category_name" id="c_id" class="form-select">
                                            <option value="">Select Category</option>
                                            <?php
                                            if ($categoryResult->num_rows > 0) {
                                                while ($row = $categoryResult->fetch_assoc()) {
                                                    echo '<option value="' . htmlspecialchars($row['category_name']) . '">' . htmlspecialchars($row['category_name']) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="error-message" id="category-error"></div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" id="description"></textarea>
                                        <div class="error-message" id="description-error"></div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="text" name="price" class="form-control" id="price" />
                                        <div class="error-message" id="price-error"></div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control" id="status">
                                            <option value="">Select Status</option>
                                            <option value="Available">Available</option>
                                            <option value="Not Available">Not Available</option>
                                        </select>
                                        <div class="error-message" id="status-error"></div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group image-upload text-center">
                                        <input type="file" name="menu_image" id="file-upload" accept="image/jpeg, image/png" style="display:none;" />
                                        <label for="file-upload" class="upload-label d-flex flex-column align-items-center justify-content-center">
                                            <img src="assets/img/upload-image.png" alt="" class="upload-image mb-2" />
                                            <h4 class="mb-0">Upload Image</h4>
                                            <img id="image-preview" class="preview-image mt-2" />
                                        </label>
                                        <div class="error-message" id="image-error"></div>
                                    </div>
                                </div>

                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-primary">Add Menu</button>
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



document.getElementById('menu-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form reload
    let valid = true;
    clearErrors();

    // Perform form validation as you already have (menu name, price, etc.)

    if (valid) {
        // Form is valid, now submit via AJAX
        const formData = new FormData(this);

        // AJAX request
        $.ajax({
            url: 'functions/getmenu.php',  // Endpoint where the form will be sent
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response === "success") {
                    // Show success message in the top-right corner
                    $('#success-alert').fadeIn().delay(3000).fadeOut(); // Show the message and hide after 3 seconds
                    $('#menu-form')[0].reset();  // Reset the form fields
                } else {
                    // Handle errors (if any)
                    console.log('Error: ' + response);
                }
            },
            error: function() {
                console.log('Error in AJAX request');
            }
        });
    }
});

// Image Preview Logic
document.getElementById('file-upload').addEventListener('change', function() {
    var file = this.files[0]; // Get the file selected by the user
    if (file) {
        if (file.type.startsWith('image/')) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.getElementById('image-preview');
                img.src = e.target.result;
                img.style.display = 'block'; // Show the preview image
                clearError('image-error'); // Clear error message
            }
            reader.readAsDataURL(file);
        } else {
            displayError('image-error', 'Please upload a valid image (JPG, PNG).');
            document.getElementById('image-preview').style.display = 'none'; // Hide the preview image
        }
    } else {
        resetImagePreview();
    }
});

// Real-time form validation
document.getElementById('menu_name').addEventListener('input', function() {
    validateField(this, /^[A-Za-z\s]+$/, 'menu-name-error', 'Menu name can only contain letters.');
});

document.getElementById('price').addEventListener('input', function() {
    validateField(this, /^[0-9]+(\.[0-9]{1,2})?$/, 'price-error', 'Price must be a valid number.');
});

document.getElementById('status').addEventListener('change', function() {
    validateField(this, /.+/, 'status-error', 'Please select the status.');
});

document.getElementById('c_id').addEventListener('change', function() {
    validateField(this, /.+/, 'category-error', 'Please select a category.');
});

document.getElementById('description').addEventListener('input', function() {
    validateField(this, /.+/, 'description-error', 'Description cannot be empty.');
});

// General validation for fields
function validateField(element, regex, errorElementId, errorMessage) {
    const value = element.value;
    if (!regex.test(value)) {
        displayError(errorElementId, errorMessage);
        element.style.borderColor = 'red';
    } else {
        clearError(errorElementId);
        element.style.borderColor = 'green';
    }
}

// Error message display function
function displayError(elementId, message) {
    document.getElementById(elementId).textContent = message;
    document.getElementById(elementId).style.color = 'red';
}

// Clear error message
function clearError(elementId) {
    document.getElementById(elementId).textContent = '';
}

// Form submission validation
document.getElementById('menu-form').addEventListener('submit', function(event) {
    event.preventDefault();
    let valid = true;
    clearErrors();

    // Validate form fields before submitting
    const validations = [
        validateField(document.getElementById('menu_name'), /^[A-Za-z\s]+$/, 'menu-name-error', 'Menu name can only contain letters.'),
        validateField(document.getElementById('price'), /^[0-9]+(\.[0-9]{1,2})?$/, 'price-error', 'Price must be a valid number.'),
        validateField(document.getElementById('status'), /.+/, 'status-error', 'Please select the status.'),
        validateField(document.getElementById('c_id'), /.+/, 'category-error', 'Please select a category.'),
        validateField(document.getElementById('description'), /.+/, 'description-error', 'Description cannot be empty.')
    ];

    // Check for file upload validation
    if (!document.getElementById('file-upload').files[0]) {
        displayError('image-error', 'Please upload an image.');
        valid = false;
    }

    if (valid) {
        document.getElementById('success-alert').style.display = 'block';
        document.getElementById('menu-form').submit();
    }
});

// Clear all previous error messages
function clearErrors() {
    const errors = document.querySelectorAll('.error-message');
    errors.forEach(function(error) {
        error.textContent = '';
    });

    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(function(input) {
        input.style.borderColor = '';
    });
}

// Reset image preview
function resetImagePreview() {
    document.getElementById('image-preview').style.display = 'none';
    document.getElementById('file-upload').value = '';
    clearError('image-error');
}

</script>


</body>
</html>
