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

// Base query to fetch cakes priced below 1000
$cakesQuery = "SELECT menu_id, menu_name, price, image_path, category_name
               FROM menu
               WHERE status = 1 AND price < 1000"; // Added price condition to filter cakes below 1000

// Apply category filter if selected
if ($filter !== 'all') {
  $cakesQuery .= " AND category_name = '" . $conn->real_escape_string($filter) . "'";
}

// Additional price range filter handling if provided (e.g., for other price ranges)
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

  <title>Cake Shop</title>
  <!-- Start of Async Drift Code -->
<script>
"use strict";

!function() {
  var t = window.driftt = window.drift = window.driftt || [];
  if (!t.init) {
    if (t.invoked) return void (window.console && console.error && console.error("Drift snippet included twice."));
    t.invoked = !0, t.methods = [ "identify", "config", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on" ], 
    t.factory = function(e) {
      return function() {
        var n = Array.prototype.slice.call(arguments);
        return n.unshift(e), t.push(n), t;
      };
    }, t.methods.forEach(function(e) {
      t[e] = t.factory(e);
    }), t.load = function(t) {
      var e = 3e5, n = Math.ceil(new Date() / e) * e, o = document.createElement("script");
      o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + n + "/" + t + ".js";
      var i = document.getElementsByTagName("script")[0];
      i.parentNode.insertBefore(o, i);
    };
  }
}();
drift.SNIPPET_VERSION = '0.3.1';
drift.load('ip3493n83era');
</script>
<!-- End of Async Drift Code -->
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="images/favicon.png" />
  <!-- Web Font -->
  <link
    href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
    rel="stylesheet" />



  <!-- StyleSheet -->

  <!-- Owl Carousel CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

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


  <style>

    
  .section-title h2 {
  font-size: 24px;
  text-align: center;
  margin-bottom: 20px;
  border-bottom: 1px solid #ddd;
  padding-bottom: 10px;
}

.product-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: center;
}



.product-img {
  position: relative;
  margin-bottom: 15px;
}

.product-img img {
  width: 100%;
  height: auto;
  border-radius: 8px;
}

.view-more-btn {
  display: inline-block;
            padding: 10px 20px;
            background: #C91868;


            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
}




.view-more-btn:hover {
  background: #C91868;
  color: #fff; /* Keep the text color white on hover */

}



.product-info h3 {
  font-size: 18px;
  margin-bottom: 5px;
  color: #333;
}

.product-info p {
  font-size: 16px;
  color: #666;
}

@media (min-width: 768px) {
  .product-card {
    flex: 0 0 calc(33.333% - 20px);
  }
}

.category-section {
  padding: 20px 0;
  text-align: center;
}

.category-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  justify-content: center;
}

.category-card {
  position: relative;
  overflow: hidden;
  text-align: center;
}

.category-card img {
  width: 100%;
  height: auto;
  border-radius: 10px;
}

.category-card h3 {
  margin-top: 10px;
  font-size: 1.1em;
  font-weight: bold;
  color: #333;
}
/* Ensures the navbar stays fixed at the top and maintains consistent height */
header.header {
  position: fixed; /* Keeps the navbar fixed at the top */
  top: 0;
  left: 0;
  width: 100%; /* Full width */
  height: 110px; /* Set the height of the navbar */
  background-color: #fff;
  z-index: 1000; /* Ensures it stays above other elements */
  transition: border-bottom 0.3s ease, background-color 0.3s ease;
  border-bottom: none; /* Initially no border */
  display: flex; /* Flexbox for alignment */
  align-items: center; /* Vertically centers content */
  justify-content: space-between; /* Evenly spaces items horizontally */
  padding: 0 20px; /* Adds horizontal padding */
  box-sizing: border-box; /* Ensures padding is included in the height */
}

/* Adds a border after scrolling */
header.header.scrolled {
  border-bottom: 1px solid #ddd; /* The border that appears after scrolling */
}

.middle-inner {
  max-width: 1200px;
  margin: 0 auto;
  width: 100%;
  padding: 35px 0;
  display: flex;
  justify-content: space-between;
  align-items: center; /* Keep items aligned vertically */
}

.row {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo img {
  height: 50px; /* Adjust logo height to fit nicely within navbar height */
}

.navbar {
  display: flex;
  justify-content: center; /* Centers the navbar content */
}

.navbar-container {
  display: flex;
}

.nav-links {
  list-style: none;
  display: flex;
  gap: 30px; /* Increase the space between items */
  padding: 0;
  margin: 0;
}

.nav-links li {
  margin: 0 10px; /* Adds a bit more space around each <li> */
  position: relative; /* Ensure positioning for dropdown */
}

.nav-links li a {
  text-decoration: none;
  color: #000;
  font-size: 16px;
  font-weight: bold;
  transition: color 0.3s ease;
}

.nav-links li a:hover {
  color: #ff6347; /* Example hover color */
}

/* Custom styles for the dropdown */
.nav-item .dropdown-menu {
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 0;
  position: absolute;
  top: 100%; /* Position it directly below the "Cake Menu" */
  left: 0;
  display: none;
  visibility: hidden;
  opacity: 0;
  transition: visibility 0s 0.3s, opacity 0.3s ease-in-out;
}

.nav-item .dropdown-item {
  padding: 10px 20px;
  font-size: 16px;
  color: #000;
  transition: background-color 0.3s ease;
}

.nav-item .dropdown-item:hover {
  background-color: #ff6347; /* Highlight on hover */
  color: white; /* Change text color on hover */
}

/* Remove the arrow on the "Cake Menu" link */
.nav-links .dropdown-toggle::after {
  content: none; /* No arrow */
}

/* Show the dropdown menu when hovering over the parent */
.nav-item:hover .dropdown-menu {
  display: block;
  visibility: visible;
  opacity: 1;
  transition: opacity 0.3s ease-in-out;
}

/* Shopping Cart Section */
.right-bar {
  display: flex;
  align-items: center;
  justify-content: flex-end; /* Ensures content aligns to the far right */
}

.shopping .single-icon {
  position: relative;
  font-size: 20px;
  color: #000;
  text-decoration: none;
  margin-right: 20px; /* Moves the cart icon slightly to the right */
  transition: color 0.3s ease;
}

.shopping .single-icon:hover {
  color: #ff6347; /* Example hover color */
}

.shopping .total-count {
  position: absolute;
  top: -10px; /* Adjust to make the count more visually balanced */
  right: -12px; /* Fine-tunes the position relative to the cart icon */
  background-color: #ff6347;
  color: #fff;
  font-size: 14px; /* Increased font size for better visibility */
  font-weight: bold;
  padding: 3px 7px; /* Adds some space for better design */
  border-radius: 50%;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Adds a subtle shadow for effect */
}

/* Shopping Cart Modal */
.shopping-item {
  position: absolute;
  right: 0;
  top: 40px;
  background-color: #fff;
  width: 300px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border-radius: 4px;
  display: none; /* Initially hidden */
}

.shopping:hover .shopping-item {
  display: block; /* Show modal on hover */
}

.shopping-item .dropdown-cart-header {
  padding: 10px;
  border-bottom: 1px solid #ddd;
  font-size: 14px;
  display: flex;
  justify-content: space-between;
}

.shopping-item ul.shopping-list {
  list-style: none;
  padding: 10px;
  max-height: 150px;
  overflow-y: auto;
}

.shopping-item .bottom {
  padding: 10px;
  border-top: 1px solid #ddd;
}

.shopping-item .total {
  display: flex;
  justify-content: space-between;
  font-size: 16px;
  font-weight: bold;
}

.shopping-item .btn {
  display: block;
  background-color: #ff6347;
  color: #fff;
  text-align: center;
  padding: 8px;
  text-decoration: none;
  border-radius: 4px;
  margin-top: 10px;
}

.shopping-item .btn:hover {
  background-color: #e55347;
}

/* Responsive Design */
@media screen and (max-width: 768px) {
  .row {
    flex-direction: column;
    align-items: flex-start;
  }

  .nav-links {
    flex-wrap: wrap;
    justify-content: flex-start;
    gap: 10px;
  }

  .shopping-item {
    width: 100%;
  }
}




</style>



</head>

<body class="js">
  <!-- Preloader -->
  <div class="preloader">
    <div class="preloader-inner">
      <div class="preloader-icon">
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
 

  <!-- Header -->
  <?php include 'header.php'; ?>

  <!--/ End Header -->


  <!--/ End Hero Area 2 -->

<!-- Categories Section -->
<!-- Categories Section -->
<!-- <div class="category-section section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="section-title">Cake Rush - Shop Birthday Cakes, Cake in Can & Gift Packs</h2>
      </div>
    </div>
    <div class="row category-grid">
      <?php foreach ($categories as $category): ?>
   
        <div class="col-md-3 col-sm-6 col-12 category-card">
          <a href="<?php echo htmlspecialchars($category['link']); ?>">
            <img src="<?php echo htmlspecialchars($category['image_path']); ?>" alt="<?php echo htmlspecialchars($category['category_name']); ?>" />
            <h3><?php echo htmlspecialchars($category['category_name']); ?></h3>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div> -->


<!-- Include the Cakes & Desserts Below PHP1,000 section here -->






<!-- Start Most Popular -->
<div class="product-area most-popular section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="section-title">
          <h2>Popular Cakes</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="owl-carousel popular-slider">
          <?php
            // Fetch and display products grouped by category
            foreach ($cakesByCategory as $categoryName => $cakes) {
              // Fetch the first cake's image in the category
              $firstCake = $cakes[0]; // Assuming the cakes are ordered by latest
              $productImage = $firstCake['image_path'];
              $productName = $firstCake['menu_name'];
              $oldPrice = ""; // Use actual price if available
              $newPrice = ""; // Use actual price if available
              ?>
              <!-- Start Single Product -->
              <div class="single-product">
                <div class="product-img">
                  <a href="Allmenu.php?category=<?php echo urlencode($categoryName); ?>">
                    <img class="default-img" src="<?php echo $productImage; ?>" alt="Product Image" />
                    <img class="hover-img" src="<?php echo $productImage; ?>" alt="Product Image" />
                    <span class="out-of-stock">Hot</span>
                  </a>
                  <!-- <div class="button-head">
                    <div class="product-action-2">
                    <a title="Add to cart" href="#" onclick="addToCart('<?php echo $firstCake['menu_id']; ?>', '<?php echo $firstCake['menu_name']; ?>', '<?php echo $firstCake['price']; ?>', '<?php echo $firstCake['image_path']; ?>')">Add to cart</a>

                    </div>
                  </div> -->
                </div>
                <div class="product-content">
                  <h3><a href="Allmenu.php?category=<?php echo urlencode($categoryName); ?>"><?php echo $productName; ?></a></h3>
                  <div class="product-price">
                    <span class="old"><?php echo $oldPrice; ?></span>
                    <span><?php echo $newPrice; ?></span>
                  </div>
                </div>
              </div>
              <!-- End Single Product -->
              <?php
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- End Most Popular Area -->






<!-- Cakes and Desserts Below 1000 -->
<div class="product-area section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="section-title">
          <h2>Cakes & Desserts Below PHP1,000</h2>
        </div>
      </div>
    </div>
    <div class="row product-grid">
      <?php
        // Counter to limit display to 6 items
        $displayedItems = 0;

        // Fetch and display products grouped by category
        foreach ($cakesByCategory as $categoryName => $cakes) {
          foreach ($cakes as $cake) {
            if ($cake['price'] < 1000) {
              if ($displayedItems >= 6) break;

              // Product details
              $productImage = $cake['image_path'];
              $productName = $cake['menu_name'];
              $productPrice = $cake['price'];
              $productId = $cake['menu_id'];
              ?>
              <!-- Single Product Card -->
              <div class="col-md-4 col-sm-6 col-12 product-card">
                <div class="product-img">
                  <a href="product-details.php?id=<?php echo urlencode($productId); ?>">
                    <img class="default-img" src="<?php echo $productImage; ?>" alt="Product Image" />
                  </a>
                </div>
                <div class="product-info">
                  <h3><?php echo htmlspecialchars($productName); ?></h3>
                  <p>PHP <?php echo number_format($productPrice, 2); ?></p>
                </div>
              </div>
              <!-- End Single Product Card -->
              <?php
              $displayedItems++;
            }
          }
          if ($displayedItems >= 6) break;
        }
      ?>
    </div>

    <!-- View More Button -->
    <div class="row">
      <div class="col-12 text-center">
        <a href="cakesbelow.php" class="view-more-btn">View More</a>
      </div>
    </div>
  </div>
</div>





 <!-- Start Midium Banner -->
 <section class="midium-banner">
    <div class="container">
    <?php
// db/config.php includes the database connection
include 'db/config.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch active banners from the database
$bannersQuery = "SELECT images_path, title, description, link FROM banners WHERE status = 1 LIMIT 2"; // Adjust LIMIT as needed
$bannersResult = $conn->query($bannersQuery);

if (!$bannersResult) {
    echo "<p>Error fetching banners. Please try again later.</p>";
    exit;
}
?>
      <div class="row">
        <?php
          // Counter to handle two banners
          $counter = 0;
          
          while ($banner = $bannersResult->fetch_assoc()) {
            $counter++;
            $imagePath = htmlspecialchars($banner['images_path']);  // Safe output for image path
            $title = htmlspecialchars($banner['title']);  // Safe output for title
            $description = htmlspecialchars($banner['description']);  // Safe output for description
            $link = htmlspecialchars($banner['link']);  // Safe output for link
        ?>
          <!-- Single Banner -->
          <div class="col-lg-6 col-md-6 col-12">
            <div class="single-banner">
              <!-- Use the image fetched from the database -->
              <img src="<?php echo $imagePath; ?>" alt="<?php echo $title; ?> Image">
              <div class="content">
                <p><?php echo $title; ?></p>
                <h3><?php echo $description; ?></h3>
                <a href="<?php echo $link; ?>">Shop Now</a>
              </div>
            </div>
          </div>
          <!-- /End Single Banner -->
          <?php
            if ($counter >= 2) break; // Stop after two banners are displayed
          }
        ?>
      </div>
    </div>
  </section>


  <!-- Start Cowndown Area -->
 
  <!-- /End Cowndown Area -->


  <!-- End Shop Blog  -->

  <!-- Start Shop Services Area -->

 

  <!-- End Shop Services Area -->
  <?php include 'reviewdisplay.php'; ?>
  <!-- Start Shop Newsletter  -->
<?php include 'news.php'; ?>
  <!-- End Shop Newsletter -->

  <?php include 'service.php'; ?>
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