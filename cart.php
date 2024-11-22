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
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- Title Tag  -->
    <title>Cakeshop</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/favicon.png" />
    <!-- Web Font -->
    <link
      href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
      rel="stylesheet"
    />

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
    <!--<link rel="stylesheet" href="css/color/color2.css">-->
    <!--<link rel="stylesheet" href="css/color/color3.css">-->
    <!--<link rel="stylesheet" href="css/color/color4.css">-->
    <!--<link rel="stylesheet" href="css/color/color5.css">-->
    <!--<link rel="stylesheet" href="css/color/color6.css">-->
    <!--<link rel="stylesheet" href="css/color/color7.css">-->
    <!--<link rel="stylesheet" href="css/color/color8.css">-->
    <!--<link rel="stylesheet" href="css/color/color9.css">-->
    <!--<link rel="stylesheet" href="css/color/color10.css">-->
    <!--<link rel="stylesheet" href="css/color/color11.css">-->
    <!--<link rel="stylesheet" href="css/color/color12.css">-->

    <link rel="stylesheet" href="#" id="colors" />
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

    <?php include 'header.php'; ?>
    <!-- Breadcrumbs -->
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="bread-inner">
              <ul class="bread-list">
                <li>
                  <a href="index1.html">Home<i class="ti-arrow-right"></i></a>
                </li>
                <li class="active"><a href="blog-single.html">Cart</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Breadcrumbs -->

 <!-- Shopping Cart -->
<div class="shopping-cart section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <!-- Shopping Summary -->
        <table class="table shopping-summary">
          <thead>
            <tr class="main-heading">
              <th>PRODUCT</th>
              <th>NAME</th>
              <th class="text-center">UNIT PRICE</th>
              <th class="text-center">QUANTITY</th>
              <th class="text-center">TOTAL</th>
              <th class="text-center"><i class="ti-trash remove-icon"></i></th>
            </tr>
          </thead>
          <tbody id="checkout-cart-items">
            <!-- Dynamic rows will be inserted here -->
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <!-- Total Amount -->
        <div class="total-amount">
          <div class="row">
            <div class="col-lg-8 col-md-5 col-12">
              <div class="left">
                <div class="coupon">
                  <form action="#" target="_blank">
                    <input name="Coupon" placeholder="Enter Your Coupon" />
                    <button class="btn">Apply</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-7 col-12">
              <div class="right">
                <ul>
                  <li>
                    Subtotal: <span id="cart-subtotal">₱0.00</span>
                  </li>
                  <li>
                    Total: <span id="cart-total">₱0.00</span>
                  </li>
                </ul>
                <div class="button5">
                  <a href="#" class="btn" id="checkoutButton">Checkout</a>
               
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--/ End Total Amount -->
      </div>
    </div>
  </div>
</div>
<!--/ End Shopping Cart -->



<script>
function updateCart() {
  const cart = JSON.parse(localStorage.getItem("cart") || "[]");

  // Elements for table and list views
  const cartItemsContainer = document.getElementById("checkout-cart-items"); // Table view
  const cartItemList = document.querySelector("#cart-item-list"); // List view
  const cartSubtotalElement = document.querySelector("#cart-subtotal"); // Subtotal
  const cartTotalElement = document.querySelector("#cart-total"); // Total
  const checkoutButton = document.getElementById("checkoutButton"); // Checkout button
  const cartItemCount = document.querySelector("#cart-item-count"); // For displaying total items count (numeric)

  // Clear cart views before updating
  cartItemsContainer.innerHTML = "";
  cartItemList.innerHTML = "";

  let subtotal = 0;
  let totalItemCount = 0;

  // Loop through the cart and display each item in both views (table and list)
  cart.forEach((item, index) => {
    const itemTotal = item.price * item.quantity;
    subtotal += itemTotal;
    totalItemCount += item.quantity;

    // Table row for checkout cart
    const row = `
      <tr>
        <td>
          <img src="${item.image}" alt="${item.name}" class="cart-item-image" style="max-width: 50px;">
        </td>
        <td>${item.name}</td>
        <td class="text-center">₱${item.price.toFixed(2)}</td>
        <td class="text-center">
          <button class="btn btn-sm btn-outline-secondary" onclick="changeQuantity(${index}, -1)">-</button>
          <span class="mx-2">${item.quantity}</span>
          <button class="btn btn-sm btn-outline-secondary" onclick="changeQuantity(${index}, 1)">+</button>
        </td>
        <td class="text-center">₱${itemTotal.toFixed(2)}</td>
        <td class="text-center">
          <button class="btn btn-danger btn-sm" onclick="removeItem(${index})">
            <i class="ti-trash"></i>
          </button>
        </td>
      </tr>
    `;
    cartItemsContainer.innerHTML += row;

    // Cart item for view cart list
    const cartItem = document.createElement("li");
    cartItem.classList.add("cart-item");
    let cartItemHTML = `
      <img src="${item.image}" alt="${item.name}" class="cart-item-image">
      <div class="cart-item-details">
        <h5>${item.name}</h5>
        <p>₱${item.price.toFixed(2)} x ${item.quantity}</p>
        <p>${item.candles} candles</p>
    `;

    if (item.message) {
      cartItemHTML += `<p><strong>Card Message:</strong> ${item.message}</p>`;
    }
    if (item.date) {
      cartItemHTML += `<p><strong>Date:</strong> ${item.date}</p>`;
    }
    if (item.time) {
      cartItemHTML += `<p><strong>Time:</strong> ${item.time}</p>`;
    }
    cartItemHTML += `</div>`;

    cartItem.innerHTML = cartItemHTML;
    cartItemList.appendChild(cartItem);
  });

  // Update totals and item count
  cartSubtotalElement.textContent = `₱${subtotal.toFixed(2)}`;
  cartTotalElement.textContent = `₱${subtotal.toFixed(2)}`;

  // Update item count (numeric) for view cart
  if (cartItemCount) {
    cartItemCount.textContent = totalItemCount ? totalItemCount : "0";  // Display as number
  }

  // Enable or disable checkout button based on cart contents
  if (cart.length === 0) {
    checkoutButton.setAttribute("disabled", true);
    checkoutButton.classList.add("disabled");
  } else {
    checkoutButton.removeAttribute("disabled");
    checkoutButton.classList.remove("disabled");
  }
}


// Change quantity of items in the cart
function changeQuantity(index, change) {
  const cart = JSON.parse(localStorage.getItem("cart") || "[]");
  cart[index].quantity += change;

  if (cart[index].quantity <= 0) {
    cart.splice(index, 1);
  }

  localStorage.setItem("cart", JSON.stringify(cart));
  updateCart();
}

// Remove item from the cart
function removeItem(index) {
  const cart = JSON.parse(localStorage.getItem("cart") || "[]");
  cart.splice(index, 1);

  localStorage.setItem("cart", JSON.stringify(cart));
  updateCart();
}

// Initialize cart on page load
document.addEventListener("DOMContentLoaded", updateCart);

// Event listener for "Add to Cart" button
document.querySelectorAll(".add-to-cart-button").forEach((button) => {
  button.addEventListener("click", function (e) {
    e.preventDefault();

    // Retrieve product details from data attributes
    const productId = this.getAttribute("data-product-id");
    const productName = this.getAttribute("data-product-name");
    const productPrice = this.getAttribute("data-product-price");
    const productImage = this.getAttribute("data-product-image");

    // Check if data attributes are retrieved correctly
    if (!productId || !productName || !productPrice || !productImage) {
      console.error("Product data is missing or undefined");
      return;
    }

    // Add item to cart
    addToCart(productId, productName, productPrice, productImage);
  });
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
