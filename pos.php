<?php

include 'db/config.php';
include 'functions/functionpos.php';
$categories = getAllCategories($conn);


$categoryQuery = "SELECT DISTINCT category_name FROM categories WHERE status = 1";
$categoryResult = $conn->query($categoryQuery);



$categories = getAllCategories($conn);


$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

$categoryQuery = "SELECT DISTINCT category_name FROM categories WHERE status = 1";
$categoryResult = $conn->query($categoryQuery);


if (!empty($selectedCategory)) {
  $menuQuery = "SELECT * FROM menu WHERE category_name = '$selectedCategory' ORDER BY category_name";
} else {
  $menuQuery = "SELECT * FROM menu ORDER BY category_name";
}

$menuResult = $conn->query($menuQuery);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=0" />

  <meta
    name="keywords"
    content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects" />

  <meta name="robots" content="noindex, nofollow" />
  <title>POS</title>

  <link
    rel="shortcut icon"
    type="image/x-icon"
    href="assets/img/favicon.jpg" />

  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />

  <link rel="stylesheet" href="assets/css/animate.css" />


  <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css" />

  <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />

  <link
    rel="stylesheet"
    href="assets/plugins/fontawesome/css/fontawesome.min.css" />
  <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />

  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/css/pos.css" />

</head>

<body>

  <div class="main-wrappers">
    <div id="notification" class="notification">
      <span id="notification-message">Order submitted successfully!</span>
    </div>
    <div class="header">
      <?php include 'includes/header.php'; ?>
    </div>

    <div class="page-wrapper ms-0">
      <div class="content">
        <div class="row">
          <div class="col-lg-8 col-sm-12 tabs_wrapper">
            <div class="page-header">
              <div class="page-title">
                <h4>Categories</h4>
                <h6>Manage your purchases</h6>
              </div>
            </div>
            <div class="search-set">
              <div class="search-input">
                <input type="text" id="searchMenu" onkeyup="searchMenu()" placeholder="Search...">

              </div>

              <!-- Category Filter -->
              <form method="GET" id="categoryForm">
                <div class="flex items-center space-x-2">
                  <label for="category" class="block text-sm font-medium">Category:</label>
                  <select name="category" id="category" class="block w-full p-2 border rounded-md" onchange="document.getElementById('categoryForm').submit();">
                    <option value="">All Categories</option>
                    <?php
                    if ($categoryResult->num_rows > 0) {
                      while ($category = $categoryResult->fetch_assoc()) {
                        $selected = ($category['category_name'] == $selectedCategory) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($category['category_name']) . '" ' . $selected . '>' . htmlspecialchars($category['category_name']) . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
              </form>

            </div>
            <div class="tab_content active">
              <div class="row">
                <?php
                if ($menuResult->num_rows > 0) {
                  $currentCategory = '';
                  while ($row = $menuResult->fetch_assoc()) {
                    if ($currentCategory !== $row['category_name']) {
                      if ($currentCategory !== '') {
                        echo '</div>';
                      }
                      $currentCategory = $row['category_name'];
                      echo '<h3>' . htmlspecialchars($currentCategory) . '</h3>';
                      echo '<div class="row">';
                    }
                ?>
                    <div class="col-lg-3 col-sm-6 d-flex">
                      <div class="productset flex-fill" data-id="<?php echo htmlspecialchars($row['menu_id']); ?>"
                        data-name="<?php echo htmlspecialchars($row['menu_name']); ?>"
                        data-price="<?php echo number_format($row['price'], 2); ?>"
                        data-image="<?php echo htmlspecialchars($row['image_path']); ?>" style="cursor: pointer;">
                        <div class="productsetimg">
                          <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="img" />
                          <h6>10%</h6>
                          
                        </div>
                        <div class="productsetcontent">
                          <h4><?php echo htmlspecialchars($row['menu_name']); ?></h4>
                          <h6><?php echo number_format($row['price'], 2); ?></h6>
                        </div>
                      </div>
                    </div>
                <?php
                  }
                  echo '</div>';
                } else {
                  echo "No products available.";
                }
                ?>
              </div>

            </div>
          </div>
          <div class="col-lg-4 col-sm-12">
            <div class="order-list">
              <div class="orderid">

              </div>
              <div class="actionproducts">
                <ul>

                  <li>
                    <a
                      href="javascript:void(0);"
                      data-bs-toggle="dropdown"
                      aria-expanded="false"
                      class="dropset">
                      <img src="assets/img/icons/ellipise1.svg" alt="img" />
                    </a>
                    <ul
                      class="dropdown-menu"
                      aria-labelledby="dropdownMenuButton"
                      data-popper-placement="bottom-end">
                      <li>
                        <a href="#" class="dropdown-item">Action</a>
                      </li>
                      <li>
                        <a href="#" class="dropdown-item">Another Action</a>
                      </li>
                      <li>
                        <a href="#" class="dropdown-item">Something Elses</a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
            <div class="card card-order">
              <div class="card-body">
                <div class="row">
                  <div class="col-12">

                    <label for="walkin-name" class="form-label">Cart</label>

                  </div>
                  <!-- <div class="col-12">
                    <a
                      href="javascript:void(0);"
                      class="btn btn-adds"
                      data-bs-toggle="modal"
                      data-bs-target="#create"><i class="fa fa-plus me-2"></i>Add Reservation</a>
                  </div> -->

                  <div class="container mt-4">
                    <div class="row">
                      <div class="col-lg-6 col-md-12 mb-3">
                        <label for="orderType" class="form-label">Order Type</label>
                        <select id="orderType" name="order_type" class="form-select validate">
                          <option value="">Select Order Type</option> <!-- Add this option -->
                          <option value="DINE">Dine-In</option>
                          <option value="TAKE OUT">Take-Out</option>
                        </select>
                      </div>
                      <!-- Discount Type -->
                      <div class="col-lg-6 col-md-12 mb-3">
                        <label for="discount" class="form-label">Discount Type</label>
                        <select id="discount" name="discount" class="form-select validate">
                          <option value="">Select Discount Type</option> <!-- Add this option -->
                          <option value="Regular">Regular</option>
                          <option value="PWD/Senior Citizen">PWD/Senior Citizen</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="split-card"></div>
              <div class="card-body pt-0">
                <form id="checkoutForm">
                  <div class="totalitem">
                    <h4>Total products: <span id="total-items">0</span></h4>
                    <a href="javascript:void(0);" id="clear-all">Clear all</a>
                  </div>

                  <div class="product-table">

                    <div id="product-lists-container">


                    </div>
                  </div>
              </div>
              <div class="split-card"></div>
              <div class="card-body pt-0 pb-2">
                  <!-- Subtotal, Discount, and Total Section -->
  <div class="setvalue">
    <ul>
      <li>
        <h5>Subtotal</h5>
        <h6 id="subtotal-value">₱0.00</h6>
      </li>
      <li>
        <h5>Discount</h5>
        <h6 id="discount-value">₱0.00</h6>
      </li>
      <li class="total-value">
        <h5>Total</h5>
        <h6 id="total-value">₱0.00</h6>
      </li>
    </ul>
  </div>
  <!-- Amount Tendered and Change Section (Always visible) -->
  <div class="cash-type-area">
    <div class="form-group">
      <label for="cash-tendered">Amount Tendered (₱)</label>
      <input type="number" id="cash-tendered" class="form-control" placeholder="Enter amount tendered">
    </div>
    <div class="form-group">
      <label for="change">Change (₱)</label>
      <input type="text" id="change" class="form-control" readonly value="₱0.00">
    </div>
  </div>



  <!-- Payment Method -->
  <div class="col-lg-12">
    <div class="d-flex justify-content-start">
      <div class="form-check">
        <input type="radio" id="cash" name="payment_method" value="Cash" class="form-check-input validate">
        <label for="cash" class="form-check-label">Cash</label>
      </div>
      <div class="form-check">
        <input type="radio" id="debit" name="payment_method" value="Debit" class="form-check-input validate">
        <label for="debit" class="form-check-label">Debit</label>
      </div>
      <div class="form-check">
        <input type="radio" id="scan" name="payment_method" value="Scan" class="form-check-input validate">
        <label for="scan" class="form-check-label">Scan</label>
      </div>
    </div>
  </div>


  <button type="button" id="checkoutBtn" class="btn-totallabel d-flex justify-content-between align-items-center w-100 py-2" disabled>
    <h5 class="mb-0">Checkout</h5>
    <h6 class="mb-0" id="total-price-display">₱0.00</h6>
  </button>


  <div class="btn-pos">
    <ul>
      <li>
        <a class="btn"><img src="assets/img/icons/pause1.svg" alt="img" class="me-1" />Hold</a>
      </li>
      <li>
        <a class="btn"><img src="assets/img/icons/edit-6.svg" alt="img" class="me-1" />Quotation</a>
      </li>
      <li>
        <a class="btn"><img src="assets/img/icons/trash12.svg" alt="img" class="me-1" />Void</a>
      </li>
      <li>
        <a class="btn"><img src="assets/img/icons/wallet1.svg" alt="img" class="me-1" />Payment</a>
      </li>
      <li>
        <a class="btn" data-bs-toggle="modal" data-bs-target="#recents"><img src="assets/img/icons/transcation.svg" alt="img" class="me-1" />Transaction</a>
      </li>
    </ul>
  </div>
</div> </div>  </div></div></div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  <script>
// Function to calculate and display change
document.getElementById('cash-tendered').addEventListener('input', calculateChange);

function calculateChange() {
    // Parse values from Total and Amount Tendered fields
    const totalValue = parseFloat(document.getElementById('total-value').innerText.replace('₱', '').replace(',', '')) || 0;
    const amountTendered = parseFloat(document.getElementById('cash-tendered').value) || 0;
    const change = amountTendered - totalValue;
    document.getElementById('change').value = '₱' + change.toFixed(2);
}
document.getElementById('checkoutBtn').addEventListener('click', function() {
  document.getElementById('cash-tendered').value = ''; 
  document.getElementById('change').value = '₱0.00';  // Optionally, you can also do other actions like clearing the cart or showing a confirmation
  console.log("Checkout process initiated. Fields reset.");
});
</script>
<script src="assets/js/pos.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/jquery-3.6.0.min.js"></script>

  <script src="assets/js/feather.min.js"></script>

  <script src="assets/js/jquery.slimscroll.min.js"></script>

  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/dataTables.bootstrap4.min.js"></script>

  <script src="assets/plugins/select2/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
  <script src="assets/js/script.js"></script>
</body>

</html>