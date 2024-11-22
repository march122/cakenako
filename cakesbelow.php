<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'cake_db';

$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch all cakes below PHP 1000
$sql = "SELECT * FROM menu WHERE price < 1000 ORDER BY category_name ASC";
$result = $conn->query($sql);
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

  <style>
  .product-container {
    display: flex;
    flex-wrap: wrap;
    gap: 100px; /* Adjust this value to control spacing */
    justify-content: space-around; /* Ensures even distribution */
  }

  .product-info {
    text-align: center;
    padding-top: 10px;
  }

  .product-info h3 {
    margin-bottom: 10px; /* Adds space between name and price */
    font-size: 1.2em;
  }

  .product-info p {
    font-size: 1.1em;
    color: #333; /* Adjust color if needed */
  }

  /* Add space between product cards */
  .product-card {
    margin-bottom: 35px; /* Adjusts vertical space between each product card */
    width: calc(33.33% - 20px); /* Ensure three cards per row */
  }
</style>

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


  <!-- Cakes and Desserts Below 1000 Section -->
<div class="product-area section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="section-title">
          <h2>All Cakes & Desserts Below PHP1,000</h2>
        </div>
      </div>
    </div>
    <div class="row product-grid">
  <?php
    if ($result->num_rows > 0) {
      while ($cake = $result->fetch_assoc()) {
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
      }
    } else {
      echo "<p>No cakes below PHP1,000 found.</p>";
    }
    $conn->close();
  ?>
</div>

  </div>
</div>

<SCript>
  
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

</SCript>


      <!-- Start Shop Newsletter  -->
      <?php include 'news.php'; ?>
      <!-- End Shop Newsletter -->

      <?php include 'footer.php'; ?>