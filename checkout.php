
<?php
// Initialize variables to hold error messages
$firstNameErr = $lastNameErr = $addressErr = $cityErr = "";
$firstName = $lastName = $address = $city = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate fields
    if (empty($_POST["first_name"])) {
        $firstNameErr = "First name is required.";
    } else {
        $firstName = test_input($_POST["first_name"]);
    }

    if (empty($_POST["last_name"])) {
        $lastNameErr = "Last name is required.";
    } else {
        $lastName = test_input($_POST["last_name"]);
    }

    if (empty($_POST["address"])) {
        $addressErr = "Address is required.";
    } else {
        $address = test_input($_POST["address"]);
    }

    if (empty($_POST["city"])) {
        $cityErr = "City is required.";
    } else {
        $city = test_input($_POST["city"]);
    }

    // If no errors, process the order
    if (empty($firstNameErr) && empty($lastNameErr) && empty($addressErr) && empty($cityErr)) {
        // Process order
        // You can insert this information into the database or proceed with payment
        // Example: redirect or proceed with payment processing
        header("Location: paymongo.php");
        exit();
    }
}

// Function to sanitize inputs
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
	<!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Title Tag  -->
    <title>Checkout</title>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="images/favicon.png">
	<!-- Web Font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	
	<!-- StyleSheet -->
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Magnific Popup -->
    <link rel="stylesheet" href="css/magnific-popup.min.css">
	<!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.css">
	<!-- Fancybox -->
	<link rel="stylesheet" href="css/jquery.fancybox.min.css">
	<!-- Themify Icons -->
    <link rel="stylesheet" href="css/themify-icons.css">
	<!-- Nice Select CSS -->
    <link rel="stylesheet" href="css/niceselect.css">
	<!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
	<!-- Flex Slider CSS -->
    <link rel="stylesheet" href="css/flex-slider.min.css">
	<!-- Owl Carousel -->
    <link rel="stylesheet" href="css/owl-carousel.css">
	<!-- Slicknav -->
    <link rel="stylesheet" href="css/slicknav.min.css">
	
	<!-- Eshop StyleSheet -->
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">

	<!-- Color CSS -->
	<link rel="stylesheet" href="css/color/color1.css">


	<link rel="stylesheet" href="#" id="colors">
	
  <style>
  
  
  /* Style for the checkout form layout */
  .shop.checkout.section {
  padding: 50px 0;
  background-color: #f9f9f9;
}

.checkout-form {
  background-color: #fff;
  padding: 25px;
  border-radius: 5px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.checkout-form h2 {
  font-size: 24px;
  font-weight: 600;
  color: #333;
  margin-bottom: 20px;
}

.checkout-form .form-group label {
  font-weight: 500;
  color: #333;
  display: block;
  margin-bottom: 5px;
}

.checkout-form .form-group input[type="text"],
.checkout-form .form-group input[type="email"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
  color: #333;
}

.checkout-form .form-group .error {
  color: red;
  font-size: 12px;
  margin-top: 5px;
}

.order-details {
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.order-details .single-widget h2 {
  font-size: 18px;
  font-weight: 600;
  color: #333;
  margin-bottom: 15px;
  text-align: center;
}

.order-details .cart-summary {
  padding-top: 15px;
}

.order-details .cart-summary .table {
  width: 100%;
  margin-bottom: 0;
}

.order-details .cart-summary .table tbody tr td {
  font-size: 14px;
  color: #333;
}

.order-details .content ul {
  list-style: none;
  padding: 0;
  margin: 15px 0;
}

.order-details .content ul li {
  font-size: 16px;
  display: flex;
  justify-content: space-between;
  padding: 10px 0;
  border-bottom: 1px solid #f0f0f0;
}

.order-details .content ul li:last-child {
  border-bottom: none;
}

.order-details .content ul li span {
  font-weight: 600;
  font-size: 18px;
}

.order-details .content ul li span#cart-final-total {
  font-size: 20px;
  color: #333;
  font-weight: bold;
}

.order-details .get-button .button {
  text-align: center;
}

.order-details .get-button .button .btn {
  background-color: #000; /* Black background */
  color: #fff; /* White text */
  padding: 12px 20px;
  font-size: 16px;
  font-weight: 500;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  width: 100%;
  text-transform: uppercase;
  transition: background-color 0.3s, color 0.3s; /* Smooth transition */
}

.order-details .get-button .button .btn:hover {
  background-color: #ff1c8d; /* Pink on hover */
  color: #fff; /* White text on hover */
}

.order-details .get-button .button .btn:disabled {
  background-color: #d3d3d3; /* Light gray */
  color: #a0a0a0; /* Light gray text */
  cursor: not-allowed;
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
	<!-- End Preloader -->

	
	<!-- /End Color Plate -->
		
		<!-- Header -->
		<?php include 'header.php'; ?>
		<!-- Breadcrumbs -->
		<div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<ul class="bread-list">
								<li><a href="index.php">Home<i class="ti-arrow-right"></i></a></li>
								<li class="active"><a href="blog-single.html">Checkout</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Breadcrumbs -->
    <section class="shop checkout section">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-12">
        <div class="checkout-form">
          <h2>Make Your Checkout Here</h2>
          <form id="checkoutForm" class="form" method="post" action="paymongo.php" target="_blank">
            <div class="row">
              <div class="col-lg-6 col-md-6 col-12">
                <div class="form-group">
                  <label>First Name<span>*</span></label>
                  <input type="text" name="first_name" value="<?= isset($first_name) ? $first_name : ''; ?>" required="required">
                  <?php if(isset($errors['first_name'])): ?>
                    <div class="error"><?= $errors['first_name']; ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-12">
                <div class="form-group">
                  <label>Last Name<span>*</span></label>
                  <input type="text" name="last_name" value="<?= isset($last_name) ? $last_name : ''; ?>" required="required">
                  <?php if(isset($errors['last_name'])): ?>
                    <div class="error"><?= $errors['last_name']; ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-12">
                <div class="form-group">
                  <label>Address<span>*</span></label>
                  <input type="text" name="address" value="<?= isset($address) ? $address : ''; ?>" required="required">
                  <?php if(isset($errors['address'])): ?>
                    <div class="error"><?= $errors['address']; ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-12">
                <div class="form-group">
                  <label>City<span>*</span></label>
                  <input type="text" name="city" value="<?= isset($city) ? $city : ''; ?>" required="required">
                  <?php if(isset($errors['city'])): ?>
                    <div class="error"><?= $errors['city']; ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <!-- Hidden fields for order items and total amount -->
              <input type="hidden" name="items" id="items" />
              <input type="hidden" name="total_amount" id="total_amount" />
            </div>
          </form>
        </div>
      </div>
      <div class="col-lg-4 col-12">
        <div class="order-details">
          <div class="single-widget">
            <h2>CART TOTALS</h2>
            <div class="cart-summary">
              <table class="table">
                <tbody id="checkout-cart-items">
                  <!-- Cart items will be populated here dynamically -->
                </tbody>
              </table>
            </div>
            <div class="content">
              <ul class="totals-list">
                <li><span>Subtotal:</span> <span id="cart-subtotal">₱0.00</span></li>
                <li><span>Discount:</span> <span id="cart-total">₱0.00</span></li>
                <li><span><strong>Total:</strong></span> <span id="cart-final-total">₱0.00</span></li>
              </ul>
            </div>
            <div class="single-widget get-button">
              <div class="button">
                <button type="submit" form="checkoutForm" class="btn" id="checkoutButton">Proceed to Payment</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>





		
		<!-- Start Shop Services Area  -->
	  <?php include 'service.php'; ?>

		<!-- End Shop Services -->
		
		<!-- Start Shop Newsletter  -->
	
	
		<!-- End Shop Newsletter -->
			
		
    <?php include 'footer.php'; ?>
		<script>

document.addEventListener("DOMContentLoaded", function () {
  updateCart(); // Initialize cart display on page load
  toggleProceedButton(); // Check cart status on page load
});

// Function to update both cart sections
function updateCart() {
  const cart = JSON.parse(localStorage.getItem("cart") || "[]");
  const cartItemsContainer = document.getElementById("checkout-cart-items"); // View Cart section
  const cartTotalsContainer = document.querySelector("#cart-item-list"); // Cart Totals section
  const cartTotal = document.querySelector("#cart-total"); // Cart total price
  const cartSubtotal = document.querySelector("#cart-subtotal"); // Subtotal
  const cartItemCount = document.querySelector("#cart-item-count"); // Number of items
  const cartItemText = document.querySelector("#cart-item-text"); // Item text

  // Clear existing content in both sections
  cartItemsContainer.innerHTML = "";
  cartTotalsContainer.innerHTML = "";

  let totalAmount = 0;
  let itemCount = 0;

  // Loop through cart items and render them
  cart.forEach((item, index) => {
    const itemTotal = item.price * item.quantity;
    totalAmount += itemTotal;
    itemCount += item.quantity;

    // Render item in "View Cart" section (table)
    let viewCartRow = `
      <tr>
        <td><img src="${item.image}" alt="${item.name}" class="cart-item-image"></td>
        <td>${item.name}</td>
        <td>${item.quantity}</td>
        <td>₱${itemTotal.toFixed(2)}</td>
    `;

    // Conditionally display Date, Time, and Message below the name if available
    let dateTimeDisplay = '';
    if (item.date || item.time || item.message) {
      dateTimeDisplay = `
        <td>
          ${item.date ? `<p><strong>Date:</strong> ${item.date}</p>` : ''}
          ${item.time ? `<p><strong>Time:</strong> ${item.time}</p>` : ''}
          ${item.message ? `<p><strong>Message:</strong> ${item.message}</p>` : ''}
        </td>
      `;
    }

    viewCartRow += dateTimeDisplay + `</tr>`;
    cartItemsContainer.innerHTML += viewCartRow;

    // Render item in "Cart Totals" section (list)
    const cartTotalItem = document.createElement("li");
    cartTotalItem.classList.add("cart-item");

    let cartTotalItemHTML = `
      <img src="${item.image}" alt="${item.name}" class="cart-item-image">
      <div class="cart-item-details">
        <h5>${item.name}</h5>
        <p>₱${item.price.toFixed(2)} x ${item.quantity}</p>
    `;

    // Conditionally add Date, Time, and Message below the name in Cart Totals section if available
    if (item.date || item.time || item.message) {
      cartTotalItemHTML += `
        ${item.date ? `<p><strong>Date:</strong> ${item.date}</p>` : ''}
        ${item.time ? `<p><strong>Time:</strong> ${item.time}</p>` : ''}
        ${item.message ? `<p><strong>Message:</strong> ${item.message}</p>` : ''}
      `;
    }

    cartTotalItemHTML += `</div>`;
    cartTotalItem.innerHTML = cartTotalItemHTML;
    cartTotalsContainer.appendChild(cartTotalItem);
  });

  // Update totals and item count
  cartTotal.textContent = `₱${totalAmount.toFixed(2)}`;
  cartSubtotal.textContent = `₱${totalAmount.toFixed(2)}`;
  cartItemCount.textContent = itemCount;
  cartItemText.textContent = itemCount ? `Items: ${itemCount}` : "No items in cart";
}

// Function to remove an item from the cart
function removeItem(index) {
  const cart = JSON.parse(localStorage.getItem("cart") || "[]");

  // Remove the item at the specified index
  cart.splice(index, 1);

  // Update localStorage and the cart view
  localStorage.setItem("cart", JSON.stringify(cart));
  updateCart();
  toggleProceedButton();
}

function toggleProceedButton() {
  const cart = JSON.parse(localStorage.getItem("cart") || "[]");
  const proceedButton = document.querySelector('#checkoutButton');

  if (cart.length === 0) {
    proceedButton.disabled = true;
    proceedButton.classList.add("disabled");
  } else {
    proceedButton.disabled = false;
    proceedButton.classList.remove("disabled");
  }
}


document.getElementById('checkoutButton').addEventListener('click', function (event) {
  event.preventDefault();

  // Check if the cart is empty
  const cart = JSON.parse(localStorage.getItem("cart") || "[]");
  if (cart.length === 0) {
    alert("Your cart is empty.");
    return;
  }

  // Validate form fields
  const form = document.getElementById('checkoutForm');
  let isValid = true;

  // Validate all required inputs
  form.querySelectorAll("input[required]").forEach(input => {
    const errorDiv = input.nextElementSibling;

    // Check if the field is empty
    if (!input.value.trim()) {
      isValid = false;
      input.classList.add("error-border"); // Add a red border for visual feedback
      if (errorDiv && errorDiv.classList.contains("error")) {
        errorDiv.textContent = "This field is required"; // Display error message
      }
    } else {
      input.classList.remove("error-border");
      if (errorDiv && errorDiv.classList.contains("error")) {
        errorDiv.textContent = ""; // Clear the error message if the field is valid
      }

      // Additional validation for specific fields
      if (input.name === "first_name" || input.name === "last_name") {
        if (!/^[a-zA-Z\s]+$/.test(input.value.trim())) {
          isValid = false;
          input.classList.add("error-border");
          if (errorDiv && errorDiv.classList.contains("error")) {
            errorDiv.textContent = "Only letters and spaces are allowed.";
          }
        }
      }

    }
  });

  // Stop submission if validation fails
  if (!isValid) {
    alert("Please fill up information.");
    return;
  }

  // Prepare cart data for submission
  const items = cart.map(item => ({
    product_name: item.name,
    quantity: item.quantity,
    price: item.price,
    total: item.price * item.quantity
  }));

  const totalAmount = items.reduce((acc, item) => acc + item.total, 0);

  // Populate hidden fields
  document.getElementById('items').value = JSON.stringify(items);
  document.getElementById('total_amount').value = totalAmount;

  // Submit the form
  form.submit();

  // Clear the cart and update the display
  localStorage.removeItem("cart");
  updateCart();
});



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