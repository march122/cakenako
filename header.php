
 
<!-- Header -->
<header class="header shop v3">
  <div class="middle-inner">
    <div class="container">
      <div class="row align-items-center">
        <!-- Logo Section -->
        <div class="col-lg-2 col-md-2 col-12">
          <div class="logo">
            <a href="index.html"><img src="img/menu/logo.png" alt="logo" /></a>
          </div>
        </div>

        <!-- Navigation Links Section -->
        <div class="col-lg-8 col-md-7 col-12">
  <nav class="navbar">
    <div class="navbar-container">
      <ul class="nav-links">
        <li><a href="#">Home</a></li>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle">Cake Menu</a>
          <ul class="dropdown-menu">
            <li><a href="Allmenu.php" class="dropdown-item">All Cakes</a></li>
            <li><a href="#" class="dropdown-item">Birthday Cakes</a></li>
            <li><a href="#" class="dropdown-item">Wedding Cakes</a></li>
            <li><a href="#" class="dropdown-item">Cupcakes</a></li>
          </ul>
        </li>
        <li><a href="#">Franchise</a></li>
        <li><a href="#">FAQ</a></li>
        <li><a href="#">Store Locator</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>
    </div>
  </nav>
</div>


        <!-- Shopping Cart Section -->
        <div class="col-lg-2 col-md-3 col-12">
          <div class="right-bar">
            <div class="shopping">
              <a href="#" class="single-icon">
                <i class="ti-shopping-cart"></i>
                <span id="cart-item-count" class="total-count">0</span>
              </a>
              <!-- Shopping Cart Modal -->
              <div id="shopping-item" class="shopping-item">
                <div class="dropdown-cart-header">
                  <span id="cart-item-text">0 Items</span>
                  <a href="http://localhost/cake/cart.php">View Cart</a>
                </div>
                <ul id="cart-item-list" class="shopping-list"></ul>
                <div class="bottom">
                  <div class="total">
                    <span>Total</span>
                    <span id="cart-total" class="total-amount">₱0.00</span>
                  </div>
                  <a href="checkout.php" class="btn animate">Checkout</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<!--/ End Header -->


  <script>
  // Cart data array to hold cart items
  let cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];

  // Function to save cart data to local storage
  function saveCartToLocalStorage() {
    localStorage.setItem("cartItems", JSON.stringify(cartItems));
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
    let totalItemCount = 0; // Variable to hold the total quantity of items

    // Loop through the cart and display each item
    cart.forEach((item, index) => {
        const cartItem = document.createElement("li");
        cartItem.classList.add("cart-item");

        // Start building the cart item HTML
        let cartItemHTML = ` 
            <img src="${item.image}" alt="${item.name}" class="cart-item-image">
            <div class="cart-item-details">
                <h5>${item.name}</h5>
                <p>₱${item.price.toFixed(2)} x ${item.quantity}</p>
                <p>${item.candles} candles</p>
        `;

        // Conditionally add the message if it's not empty
        if (item.message) {
            cartItemHTML += `<p><strong>Card Message:</strong> ${item.message}</p>`;
        }

        // Conditionally add the date if it's not empty
        if (item.date) {
            cartItemHTML += `<p><strong>Date:</strong> ${item.date}</p>`;
        }

        // Conditionally add the time if it's not empty
        if (item.time) {
            cartItemHTML += `<p><strong>Time:</strong> ${item.time}</p>`;
        }

        // Close the cart item details
        cartItemHTML += `</div>`;

        // Add the item to the cart
        cartItem.innerHTML = cartItemHTML;
        cartItemList.appendChild(cartItem);

        // Update the total price and total item count
        totalAmount += item.price * item.quantity;
        totalItemCount += item.quantity;  // Add the quantity of this item to the total
    });

    // Update cart item count and total
    cartItemCount.textContent = totalItemCount; // Update the count to show total quantity
    cartItemText.textContent = totalItemCount ? `Items: ${totalItemCount}` : "No items in cart";
    cartTotal.textContent = `₱${totalAmount.toFixed(2)}`;
}


  // Load cart from local storage when page loads
  document.addEventListener("DOMContentLoaded", function() {
    updateCart();
  });

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

      console.log("Adding to cart:", { productId, productName, productPrice, productImage });

      // Add item to cart
      addToCart(productId, productName, productPrice, productImage);
    });
  });

  function showCakesMenu() {
    // Hide other sections
    document.getElementById('home-section').style.display = 'none';
    // Add other sections here if needed
    
    // Show Cakes Menu section
    document.getElementById('cakes-menu-section').style.display = 'block';
  }

  
</script>

