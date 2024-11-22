<?php
// Include your database config and the file containing the function
include 'db/config.php'; // Your database configuration
include 'functions/getcategory.php'; // Update this path to where get_filtered_categories is defined

// Get the category ID from the URL
$c_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Check if the ID is valid
if ($c_id <= 0) {
    echo "Invalid Category ID.";
    exit;
}

// Fetch category details from the database based on c_id
$query = "SELECT * FROM categories WHERE c_id = $c_id";
$result = mysqli_query($conn, $query);

// Check if the category exists
if (mysqli_num_rows($result) > 0) {
    // Fetch the category data
    $category = mysqli_fetch_assoc($result);
} else {
    echo "Category not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
  <meta name="description" content="POS - Bootstrap Admin Template" />
  <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects" />
  <meta name="author" content="Dreamguys - Bootstrap Admin Template" />
  <meta name="robots" content="noindex, nofollow" />
  <title>Cakes</title>

  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.jpg" />
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/animate.css" />
  <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css" />
  <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css" />
  <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <?php include 'includes/header.php'; ?>
      <?php include 'includes/sidebar.php'; ?>
      <div class="page-wrapper">
        <div class="content">
          <div class="page-header">
            <div class="page-title">
              <h4>Category Details</h4>
              <h6>Full details of the category</h6>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-8 col-sm-12">
              <div class="card">
                <div class="card-body">
                  <div class="productdetails">
                    <ul class="product-bar">
                      <li>
                        <h4>Category Name</h4>
                        <h6><?php echo htmlspecialchars($category['category_name']); ?></h6>
                      </li>
                      <li>
                        <h4>Description</h4>
                        <h6><?php echo nl2br(htmlspecialchars($category['description'])); ?></h6>
                      </li>
                      <li>
                        <h4>Status</h4>
                        <h6><?php echo htmlspecialchars($category['status']); ?></h6>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
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
</body>
</html>
