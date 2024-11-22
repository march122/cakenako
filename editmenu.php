<?php

include 'db/config.php';

// Check if the menu ID is provided in the URL
if (!isset($_GET['id'])) {
    die('Menu ID not provided.');
}

// Get the menu ID and sanitize it
$menu_id = intval($_GET['id']);

// Prepare the SQL query to fetch the menu item
$query = "SELECT * FROM menu WHERE menu_id = $menu_id";
$result = mysqli_query($conn, $query);

// Check if the menu item was found
if ($result && mysqli_num_rows($result) > 0) {
    $menu = mysqli_fetch_assoc($result);
} else {
    die('Menu not found.');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Edit Product</title>

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.jpg" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css" />
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css" />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/product.css" />
</head>

<body>
    <div class="main-wrapper">
        <div class="header">
            <?php include 'includes/header.php'; ?>
        </div>
        <div><?php include 'includes/sidebar.php'; ?></div>
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Edit Menu</h4>
                        <h6>Edit existing Menu</h6>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="alert" id="success-alert" style="display: none;">Update successful!</div>
                        <form id="edit-menu-form" enctype="multipart/form-data">
                            <input type="hidden" name="menu_id" value="<?php echo htmlspecialchars($menu['menu_id']); ?>" />
                            <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($menu['image_path']); ?>" />

                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Menu Name</label>
                                        <input type="text" name="menu_name" class="form-control" value="<?php echo htmlspecialchars($menu['menu_name']); ?>" />
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category" class="form-control">
                                            <option value="">Choose Category</option>
                                            <?php
                                            $query = "SELECT c_id, category_name FROM categories";
                                            $result = $conn->query($query);

                                            if ($result && $result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    // Check if the current category is the one assigned to the menu item
                                                    $selected = ($menu['category_name'] == $row['category_name']) ? 'selected' : '';
                                                    echo '<option value="' . htmlspecialchars($row['category_name']) . '" ' . $selected . '>' . htmlspecialchars($row['category_name']) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control"><?php echo htmlspecialchars($menu['description']); ?></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="text" name="price" class="form-control" value="<?php echo htmlspecialchars($menu['price']); ?>" />
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="Available" <?php echo ($menu['status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                                            <option value="Not Available" <?php echo ($menu['status'] == 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <?php if (!empty($menu['image_path'])): ?>
                                            <div class="image-preview-container">
                                                <img id="image-preview" src="<?php echo htmlspecialchars($menu['image_path']); ?>" alt="Menu Image" class="existing-image" />
                                            </div>
                                        <?php else: ?>
                                            <div class="image-preview-container">
                                                <img id="image-preview" src="#" alt="Menu Image" style="display: none;" class="existing-image" />
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" id="image-input" name="image" class="form-control" />
                                        <small>Leave blank if you do not want to update the image.</small>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary">Update Menu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script>
$(document).ready(function () {
    // Image preview handler
    $('#image-input').on('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#image-preview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#image-preview').attr('src', '#').hide();
        }
    });

    // Form submit handler with AJAX
    $('#edit-menu-form').on('submit', function (event) {
        event.preventDefault();
        
        // Form Validation
        const menuName = $('input[name="menu_name"]');
        const description = $('textarea[name="description"]');
        const price = $('input[name="price"]');
        const image = $('#image-input')[0].files[0];

        let isValid = true;

        // Clear previous error messages
        $('.error-message').remove();

        // Validate Menu Name (Only Letters)
        const menuNameRegex = /^[a-zA-Z\s]+$/;
        if (!menuName.val().match(menuNameRegex)) {
            menuName.css('border-color', 'red');
            menuName.after('<span class="error-message" style="color: red;">Menu name should only contain letters.</span>');
            isValid = false;
        } else {
            menuName.css('border-color', '');
        }

        // Validate Description (Min 20 characters and max 120 words)
        const descriptionText = description.val();
        const descriptionWordCount = descriptionText.split(/\s+/).length;
        if (descriptionWordCount < 20 || descriptionWordCount > 120) {
            description.css('border-color', 'lightcoral');
            description.after('<span class="error-message" style="color: red;">Description must be between 20 and 120 words.</span>');
            isValid = false;
        } else {
            description.css('border-color', '');
        }

        // Validate Price (Only Numbers)
        const priceRegex = /^[0-9]+(\.[0-9]{1,2})?$/; // Allow decimal values with two decimal places
        if (!price.val().match(priceRegex)) {
            price.css('border-color', 'lightcoral');
            price.after('<span class="error-message" style="color: red;">Price should be a valid number.</span>');
            isValid = false;
        } else {
            price.css('border-color', '');
        }

        // Validate Image (Only jpeg, png)
        if (image && !/(jpeg|png)$/i.test(image.name)) {
            $('#image-input').css('border-color', 'lightcoral');
            $('#image-input').after('<span class="error-message" style="color: red;">Please upload a valid image (jpeg or png).</span>');
            isValid = false;
        } else {
            $('#image-input').css('border-color', '');
        }

        // If all fields are valid, submit the form
        if (isValid) {
            $.ajax({
                url: 'db/update.php',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (response) {
                    const message = response.trim() === 'success' ? 'Update successful!' : ' ' + response;
                    displayMessage(message, response.trim() === 'success');
                },
                error: function () {
                    displayMessage('An error occurred. Please try again.', false);
                }
            });
        } else {
            displayMessage('Please fill out all fields correctly.', false);
        }
    });

    // Function to display messages in the alert box
    function displayMessage(message, isSuccess) {
        const alertBox = $('#success-alert');
        alertBox.text(message).toggleClass('alert-success', isSuccess).toggleClass('alert-danger', !isSuccess).show();

        setTimeout(() => {
            alertBox.hide();
        }, 3000);
    }
});
</script>

</script>

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
</body>

</html>