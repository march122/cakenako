<?php
// db/config.php includes the database connection
include 'db/config.php';

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch active Cake Categories from the database
$categoryQuery = "SELECT DISTINCT category_name FROM categories WHERE status = 1"; // status = 1 for active categories
$categoryResult = $conn->query($categoryQuery);

if (!$categoryResult) {
  echo "<p>Error fetching categories. Please try again later.</p>";
  exit;
}

// Prepare an array to hold categories and latest images per category
$categories = [];
$latestImages = [];

// Fetch the latest image for each category from the menu
$cakeCategoryQuery = "SELECT category_name, image_path
                      FROM menu
                      WHERE status = 1
                      AND category_name IS NOT NULL
                      ORDER BY c_id DESC"; // Assuming 'c_id' is the primary key

$cakeCategoryResult = $conn->query($cakeCategoryQuery);

if ($cakeCategoryResult && $cakeCategoryResult->num_rows > 0) {
  while ($cake = $cakeCategoryResult->fetch_assoc()) {
    $category = htmlspecialchars($cake['category_name']);
    // Store the latest image for the category only if it hasn't been set yet
    if (!isset($latestImages[$category])) {
      $latestImages[$category] = htmlspecialchars($cake['image_path']);
    }
  }
}

// Fetch all cakes from the menu with optional filtering
$filter = isset($_GET['category']) ? $_GET['category'] : 'all';
$priceFilter = isset($_GET['price']) ? $_GET['price'] : '';

// Base query to fetch cakes
$cakesQuery = "SELECT menu_id, menu_name, price, image_path, category_name
               FROM menu
               WHERE status = 1";

// Apply category filter if selected
if ($filter !== 'all') {
  $cakesQuery .= " AND category_name = '" . $conn->real_escape_string($filter) . "'";
}

// Price filter handling
if ($priceFilter) {
  list($minPrice, $maxPrice) = explode('-', $priceFilter);
  $cakesQuery .= " AND price BETWEEN " . (int)$minPrice . " AND " . (int)$maxPrice;
}

// Fetch cakes based on filters
$cakesResult = $conn->query($cakesQuery);

if (!$cakesResult) {
  echo "<p>Error fetching cakes. Please try again later.</p>";
  exit;
}

// Prepare an array to hold cakes grouped by category
$cakesByCategory = [];
if ($cakesResult->num_rows > 0) {
  while ($cake = $cakesResult->fetch_assoc()) {
    $cakesByCategory[$cake['category_name']][] = $cake;
  }
}



function fetchCakesByCategory($conn) {
  // Define the SQL query to retrieve cakes grouped by category
  $sql = "SELECT menu_name, price, image_path, category_name, menu_id FROM menu ORDER BY category_name";
  $result = $conn->query($sql);

  // Initialize an array to store cakes by category
  $cakesByCategory = [];

  if ($result->num_rows > 0) {
      // Loop through the result and group cakes by category
      while ($row = $result->fetch_assoc()) {
          $category = $row['category_name'];
          if (!isset($cakesByCategory[$category])) {
              $cakesByCategory[$category] = [];
          }
          $cakesByCategory[$category][] = $row;
      }
  }
  return $cakesByCategory;
}


?>

<!DOCTYPE html>
<html lang="zxx">

<head>
  <!-- Meta Tag -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="copyright" content="" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Title Tag  -->
  <title>Sweet Spot Cakeshop</title>
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="images/favicon.png" />
  <!-- Web Font -->
  <link
    href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
    rel="stylesheet" />

  <!-- StyleSheet -->

  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.css" />
  <!-- Magnific Popup -->
  <link rel="stylesheet" href="css/magnific-popup.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome.css" />
  <!-- Fancybox -->
  <link rel="stylesheet" href="css/jquery.fancybox.min.css" />
  <!-- Themify Icons -->
  <link rel="stylesheet" href="css/themify-icons.css" />
  <!-- Jquery Ui -->
  <link rel="stylesheet" href="css/jquery-ui.css" />
  <!-- Nice Select CSS -->
  <link rel="stylesheet" href="css/niceselect.css" />
  <!-- Animate CSS -->
  <link rel="stylesheet" href="css/animate.css" />
  <!-- Flex Slider CSS -->
  <link rel="stylesheet" href="css/flex-slider.min.css" />
  <!-- Owl Carousel -->
  <link rel="stylesheet" href="css/owl-carousel.css" />
  <!-- Slicknav -->
  <link rel="stylesheet" href="css/slicknav.min.css" />

  <!-- Eshop StyleSheet -->
  <link rel="stylesheet" href="css/reset.css" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="css/responsive.css" />

  <!-- Color CSS -->
  <link rel="stylesheet" href="css/color/color1.css" />


  <link rel="stylesheet" href="#" id="colors" />
</head>

<body class="js">
  <!-- Preloader -->
  <!-- <div class="preloader">
    <div class="preloader-inner">
      <div class="preloader-icon">
        <span></span>
        <span></span>
      </div>
    </div>
  </div> -->
  <!-- End Preloader -->


  <!-- /End Color Plate -->

  <!-- Header -->
  <?php include 'header.php'; ?>
 
  <!--/ End Header -->

  <!-- Breadcrumbs -->
  <div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="bread-inner">
            <ul class="bread-list">
              <li>
                <a href="index.php">Home<i class="ti-arrow-right"></i></a>
              </li>
              <li class="active"><a href="Allmenu.php">Menu Cakes</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Breadcrumbs -->

  <div class="product-area section">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="section-title">
            <h2>Cakes Menu</h2>
          </div>
        </div>
      </div>
   <!-- HTML to display tabs and cakes -->
<div class="row">
  <div class="col-12">
    <div class="product-info">
      <div class="nav-main">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link <?= $filter === 'all' ? 'active' : '' ?>" data-toggle="tab" href="#allcakes" role="tab">All Cakes</a>
          </li>
          <?php foreach ($latestImages as $category => $image) : ?>
            <li class="nav-item">
              <a class="nav-link <?= $filter === $category ? 'active' : '' ?>" data-toggle="tab" href="#<?= strtolower(str_replace(' ', '', $category)); ?>" role="tab"><?= htmlspecialchars($category); ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade <?= $filter === 'all' ? 'show active' : '' ?>" id="allcakes" role="tabpanel">
          <div class="tab-single">
            <div class="row">
              <?php foreach ($cakesByCategory as $category => $cakes) : ?>
                <?php foreach ($cakes as $cake) : ?>
                  <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                    <div class="single-product">
                      <div class="product-img">
                        <a href="product-details.php?id=<?= $cake['menu_id']; ?>">
                          <img class="default-img" src="<?= htmlspecialchars($cake['image_path']); ?>" alt="<?= htmlspecialchars($cake['menu_name']); ?>" />
                          <img class="hover-img" src="<?= htmlspecialchars($cake['image_path']); ?>" alt="<?= htmlspecialchars($cake['menu_name']); ?>" />
                        </a>
                        <div class="button-head">
                          <div class="product-action">
                            <a data-toggle="modal" data-target="#exampleModal"
                               title="Quick View"
                               href=""
                               data-product-id="<?= $cake['menu_id']; ?>"
                               data-product-name="<?= htmlspecialchars($cake['menu_name']); ?>"
                               data-product-price="<?= number_format($cake['price'], 2); ?>"
                               data-product-image="<?= htmlspecialchars($cake['image_path']); ?>"
                               data-product-description="Product description here">
                            </a>
                          </div>
                          <!-- <div class="product-action-2">
                            <a class="add-to-cart-button" href="" 
                               data-product-id="<?= $cake['menu_id']; ?>" 
                               data-product-name="<?= htmlspecialchars($cake['menu_name']); ?>" 
                               data-product-price="<?= number_format($cake['price'], 2); ?>" 
                               data-product-image="<?= htmlspecialchars($cake['image_path']); ?>"
                               onclick="addToCart('<?= $cake['menu_id']; ?>', '<?= htmlspecialchars($cake['menu_name']); ?>', '<?= number_format($cake['price'], 2); ?>', '<?= htmlspecialchars($cake['image_path']); ?>')">
                               Add to cart
                            </a>
                          </div> -->
                        </div>
                      </div>
                      <div class="product-content">
                        <h3><a href="product-details.php?id=<?= $cake['menu_id']; ?>"><?= htmlspecialchars($cake['menu_name']); ?></a></h3>
                        <div class="product-price">
                          <span>₱<?= number_format($cake['price'], 2); ?></span>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <?php foreach ($cakesByCategory as $category => $cakes) : ?>
          <div class="tab-pane fade <?= $filter === $category ? 'show active' : '' ?>" id="<?= strtolower(str_replace(' ', '', $category)); ?>" role="tabpanel">
            <div class="tab-single">
              <div class="row">
                <?php foreach ($cakes as $cake) : ?>
                  <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                    <div class="single-product">
                      <div class="product-img">
                        <a href="product-details.php?id=<?= $cake['menu_id']; ?>">
                          <img class="default-img" src="<?= htmlspecialchars($cake['image_path']); ?>" alt="<?= htmlspecialchars($cake['menu_name']); ?>" />
                          <img class="hover-img" src="<?= htmlspecialchars($cake['image_path']); ?>" alt="<?= htmlspecialchars($cake['menu_name']); ?>" />
                        </a>
                        <div class="button-head">
                          <div class="product-action">
                            <a data-toggle="modal" data-target="#exampleModal"
                               title="Quick View"
                               href=""
                               data-product-id="<?= $cake['menu_id']; ?>"
                               data-product-name="<?= htmlspecialchars($cake['menu_name']); ?>"
                               data-product-price="<?= number_format($cake['price'], 2); ?>"
                               data-product-image="<?= htmlspecialchars($cake['image_path']); ?>"
                               data-product-description="Product description here">
                            </a>
                          </div>
                          <!-- <div class="product-action-2">
                            <a class="add-to-cart-button" href="" 
                               data-product-id="<?= $cake['menu_id']; ?>" 
                               data-product-name="<?= htmlspecialchars($cake['menu_name']); ?>" 
                               data-product-price="<?= number_format($cake['price'], 2); ?>" 
                               data-product-image="<?= htmlspecialchars($cake['image_path']); ?>"
                               onclick="addToCart('<?= $cake['menu_id']; ?>', '<?= htmlspecialchars($cake['menu_name']); ?>', '<?= number_format($cake['price'], 2); ?>', '<?= htmlspecialchars($cake['image_path']); ?>')">
                               Add to cart
                            </a>
                          </div> -->
                        </div>
                      </div>
                      <div class="product-content">
                        <h3><a href="product-details.php?id=<?= $cake['menu_id']; ?>"><?= htmlspecialchars($cake['menu_name']); ?></a></h3>
                        <div class="product-price">
                          <span>₱<?= number_format($cake['price'], 2); ?></span>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<?php $conn->close(); ?>

      <!-- Start Shop Newsletter  -->
      <?php include 'news.php'; ?>
      <!-- End Shop Newsletter -->

      <?php include 'footer.php'; ?>

      <script>
  
// Function to add item to the cart
function addToCart() {
    // Get the selected quantity, default to 1 if not selected
    const quantity = document.querySelector('.input-number').value || 1;
    
    // Get selected candles from dropdown (trim any whitespace)
    const candles = document.querySelector("#candles").innerText.trim();
    
    // Get the card message text (if provided)
    const message = document.querySelector("#cardMessageText").value || '';
    
    // Get cake details from the page
    const cakeName = document.querySelector(".cake-des h4").textContent;
    const cakePrice = parseFloat(document.querySelector(".price .discount").textContent.replace("₱", "").trim());
    const cakeImage = document.querySelector(".cake-gallery img").src; // Assuming the main image is in the first <img> tag

    // Create an item object to add to the cart
    const newItem = {
        name: cakeName,
        price: cakePrice,
        quantity: parseInt(quantity),
        candles: candles,
        message: message,
        image: cakeImage,
        date: selectedDate,
        time: selectedTime,
    };

    // Get current cart from localStorage (or initialize as an empty array)
    const cart = JSON.parse(localStorage.getItem("cart") || "[]");

    // Check if the item already exists in the cart
    const existingItemIndex = cart.findIndex(item => 
        item.name === newItem.name && 
        item.candles === newItem.candles && 
        item.message === newItem.message && 
        item.date === newItem.date && 
        item.time === newItem.time
    );

    if (existingItemIndex !== -1) {
        // If the item exists, update its quantity
        cart[existingItemIndex].quantity += newItem.quantity;
    } else {
        // If the item does not exist, add it to the cart
        cart.push(newItem);
    }

    // Save the updated cart back to localStorage
    localStorage.setItem("cart", JSON.stringify(cart));

    // Optionally, alert user or display a success message
    alert(`${cakeName} has been added to your cart!`);
}

// Function to update the cart view
function updateCart() {
    const cart = JSON.parse(localStorage.getItem("cart") || "[]");
    const cartItemList = document.querySelector("#cart-item-list");
    const cartItemText = document.querySelector("#cart-item-text");
    const cartTotal = document.querySelector("#cart-total");
    const cartItemCount = document.querySelector("#cart-item-count");

    // Clear the cart before adding new items
    cartItemList.innerHTML = "";
    let totalAmount = 0;

    // Loop through the cart and display each item
    cart.forEach((item, index) => {  // Use the index for each item
        const cartItem = document.createElement("li");
        cartItem.classList.add("cart-item");

        // Create the date, time, and message display only if they exist
        const dateTimeDisplay = `
            ${item.date ? `<p><strong>Date:</strong> ${item.date}</p>` : ''}
            ${item.time ? `<p><strong>Time:</strong> ${item.time}</p>` : ''}
        `;

        const messageDisplay = item.message ? `<p><strong>Message:</strong> ${item.message}</p>` : '';

        cartItem.innerHTML = `
            <img src="${item.image}" alt="${item.name}" class="cart-item-image">
            <div class="cart-item-details">
                <h5>${item.name}</h5>
                <p>₱${item.price.toFixed(2)} x ${item.quantity}</p>
                <p>${item.candles} candles</p>
                ${messageDisplay}  <!-- Display the message if exists -->
                ${dateTimeDisplay ? `<div class="cart-item-datetime">${dateTimeDisplay}</div>` : ''}
            </div>
        `;
        cartItemList.appendChild(cartItem);

        // Update the total price
        totalAmount += item.price * item.quantity;
    });

    // Update cart item count and total
    cartItemCount.textContent = cart.length;
    cartItemText.textContent = cart.length ? `Items: ${cart.length}` : "No items in cart";
    cartTotal.textContent = `₱${totalAmount.toFixed(2)}`;
}

// Function to remove an item from the cart
function removeItem(index) {
    const cart = JSON.parse(localStorage.getItem("cart") || "[]");

    // Remove the item by its index
    cart.splice(index, 1);

    // Save the updated cart back to localStorage
    localStorage.setItem("cart", JSON.stringify(cart));

    // Update the cart view after removal
    updateCart();
}

</script>






      <!-- Jquery -->
      <script src="js/jquery.min.js"></script>
      <script src="js/jquery-migrate-3.0.0.js"></script>
      <script src="js/jquery-ui.min.js"></script>
      <!-- Popper JS -->
      <script src="js/popper.min.js"></script>
      <!-- Bootstrap JS -->
      <script src="js/bootstrap.min.js"></script>
      <!-- Color JS -->
      <script src="js/colors.js"></script>
      <!-- Slicknav JS -->
      <script src="js/slicknav.min.js"></script>
      <!-- Owl Carousel JS -->
      <script src="js/owl-carousel.js"></script>
      <!-- Magnific Popup JS -->
      <script src="js/magnific-popup.js"></script>
      <!-- Fancybox JS -->
      <script src="js/facnybox.min.js"></script>
      <!-- Waypoints JS -->
      <script src="js/waypoints.min.js"></script>
      <!-- Countdown JS -->
      <script src="js/finalcountdown.min.js"></script>
      <!-- Nice Select JS -->
      <script src="js/nicesellect.js"></script>
      <!-- Ytplayer JS -->
      <script src="js/ytplayer.min.js"></script>
      <!-- Flex Slider JS -->
      <script src="js/flex-slider.js"></script>
      <!-- ScrollUp JS -->
      <script src="js/scrollup.js"></script>
      <!-- Onepage Nav JS -->
      <script src="js/onepage-nav.min.js"></script>
      <!-- Easing JS -->
      <script src="js/easing.js"></script>
      <!-- Active JS -->
      <script src="js/active.js"></script>
</body>

</html>