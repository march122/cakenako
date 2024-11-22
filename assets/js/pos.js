
function searchMenu() {
  let input = document.getElementById('searchMenu').value.toLowerCase();
  let menuItems = document.querySelectorAll('.productset');
  for (let i = 0; i < menuItems.length; i++) {
    let name = menuItems[i].getAttribute('data-name').toLowerCase();
    if (name.includes(input)) {
      menuItems[i].style.display = '';
    } else {
      menuItems[i].style.display = 'none';
    }
  }
}

document.addEventListener("DOMContentLoaded", function() {
  const productListsContainer = document.getElementById(
    "product-lists-container"
  );
  const totalItemsElement = document.getElementById("total-items");
  const clearAllButton = document.getElementById("clear-all");
  const paymentMethods = document.querySelectorAll(".paymentmethod");

  // Elements for subtotal, discount, and total
  const subtotalElement = document.getElementById("subtotal-value");
  const discountElement = document.getElementById("discount-value");
  const totalElement = document.getElementById("total-value");
  const checkoutTotalElement = document.querySelector(".btn-totallabel h6"); // New element for checkout total

  function createProductList(categoryId) {
    const ul = document.createElement("ul");
    ul.className = "product-lists";
    ul.dataset.categoryId = categoryId;
    return ul;
  }
  paymentMethods.forEach(function(method) {
    method.addEventListener("click", function() {

      paymentMethods.forEach(function(m) {
        m.classList.remove("active");
      });


      this.classList.add("active");
    });
  });

  function addToProductList(item) {
    let ul = [
      ...productListsContainer.querySelectorAll("ul.product-lists"),
    ].find((ul) => ul.querySelector(`li[data-id="${item.id}"]`));

    if (!ul) {
      ul = createProductList(item.categoryId);
      productListsContainer.appendChild(ul);
    }

    const existingItem = ul.querySelector(`li[data-id="${item.id}"]`);
    if (existingItem) {
      const quantityField = existingItem.querySelector(".quantity-field");
      quantityField.value = parseInt(quantityField.value, 10) + 1;
    } else {
      const listItem = document.createElement("li");
      listItem.dataset.id = item.id;
      listItem.innerHTML = `
            <div class="productimg">
                <div class="productimgs">
                    <img src="${item.image}" alt="img" />
                </div>
                <div class="productcontet">
                    <h4>
                        ${item.name}
                        <a href="javascript:void(0);" class="ms-2" data-bs-toggle="modal" data-bs-target="#edit">
                            <img src="assets/img/icons/edit-5.svg" alt="img"/>
                        </a>
                    </h4>
                    <div class="productlinkset">
                        <h5>PT${item.id}</h5>
                    </div>
                    <div class="increment-decrement">
                        <div class="input-groups">
                            <input type="button" value="-" class="button-minus dec button"/>
                            <input type="text" name="child" value="1" class="quantity-field"/>
                            <input type="button" value="+" class="button-plus inc button"/>
                        </div>
                    </div>
                </div>
            </div>
        `;

      const priceItem = document.createElement("li");
      priceItem.dataset.id = item.id;
      priceItem.className = "price-item"; // Added class to identify price items
      priceItem.textContent = `Price: ${item.price}`;

      const deleteItem = document.createElement("li");
      deleteItem.innerHTML = `
            <a href="javascript:void(0);" class="remove-item" data-id="${item.id}">
                <img src="assets/img/icons/delete-2.svg" alt="img"/>
            </a>
        `;

      ul.appendChild(listItem);
      ul.appendChild(priceItem);
      ul.appendChild(deleteItem);
    }
    updateTotals(); // Update totals whenever a product is added
  }

  function addProductList(item) {
    console.log("Adding product:", item); // Debug log
    addToProductList(item);
  }

  function updateTotals() {
    let subtotal = 0;
    let totalItems = 0;
    const discountPercentageRegular = 0; // No discount for Regular
    const discountPercentagePWD = 0.1; // 10% discount for PWD/Senior

    [...productListsContainer.querySelectorAll("ul.product-lists")].forEach(
      (ul) => {
        [...ul.querySelectorAll(".price-item")].forEach((priceItem) => {
          const priceText = priceItem.textContent.replace("Price: ", "");
          const price = parseFloat(priceText);
          const quantityField =
            priceItem.previousElementSibling.querySelector(".quantity-field");
          const quantity = parseInt(quantityField.value, 10);
          if (!isNaN(price) && !isNaN(quantity)) {
            subtotal += price * quantity;
          }
        });
        totalItems += [...ul.querySelectorAll(".quantity-field")].reduce(
          (total, field) => total + parseInt(field.value, 10),
          0
        );
      }
    );

    // Update subtotal
    subtotalElement.textContent = `₱${subtotal.toFixed(2)}`;

    // Determine discount based on discount type selected
    const discountType = $("#discount").val();
    let discount = 0;
    if (discountType === "PWD/Senior Citizen") {
      discount = subtotal * discountPercentagePWD; // Apply 10% discount
    }

    discountElement.textContent = `₱${discount.toFixed(2)}`;

    // Update total
    const total = subtotal - discount;
    totalElement.textContent = `₱${total.toFixed(2)}`;

    // Update total items count
    totalItemsElement.textContent = totalItems;

    // Update checkout total
    if (checkoutTotalElement) {
      checkoutTotalElement.textContent = `₱${total.toFixed(2)}`;
    }
  }



  $(document).ready(function() {
    // Function to validate fields
    function validateFields() {
      let isValid = true;
      const requiredFields = $('.validate');

      // Remove previous highlights
      requiredFields.removeClass('is-invalid');

      // Check Order Type
      const orderType = $("#orderType").val();
      if (!orderType) {
        $("#orderType").addClass('is-invalid');
        isValid = false;
      }

      // Check Discount Type
      const discountType = $("#discount").val();
      if (!discountType) {
        $("#discount").addClass('is-invalid');
        isValid = false;
      }

      // Check Payment Method
      const paymentMethod = $('input[name="payment_method"]:checked');
      if (!paymentMethod.length) {
        $('.form-check-input').addClass('is-invalid');
        isValid = false;
      }

      // Enable or disable the checkout button
      $('#checkoutBtn').prop('disabled', !isValid);
      return isValid;
    }

    // Attach change event listeners to the required fields
    $("#orderType, #discount").change(validateFields);
    $('input[name="payment_method"]').change(validateFields);

    // Submit order function
    $('#checkoutBtn').click(function() {
      // Validate fields before proceeding
      if (!validateFields()) {
        alert("Please fill in all required fields.");
        return;
      }

     
    });
  });

  function showReceipt(orderDetails) {
    const subtotal = orderDetails.subtotal || 0; 
    const total_price = orderDetails.total_price || 0; 

    const receiptModal = document.createElement('div');
    receiptModal.className = 'modal fade';
    receiptModal.id = 'receiptModal';
    receiptModal.tabIndex = '-1';
    receiptModal.setAttribute('aria-labelledby', 'receiptModalLabel');
    receiptModal.setAttribute('aria-hidden', 'true');

    receiptModal.innerHTML = `
<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content receipt-content" id="receiptContent">
        <div class="modal-body receipt-body">
            <div class="receipt-header text-center">
                <h2 class="order-number">${orderDetails.order_id}</h2>
                <p class="translated-text">PINK Cake</p>
            </div>

            <div class="store-info">
                <p>Minglanilla - Ward IV Cebu</p>
                <p>SHOP 1, 1/F, THE ADDITIONAL</p>
                <p>: 123456 Phone: 2677 0202</p>
                <p>Order Time: ${new Date(orderDetails.order_time || Date.now()).toLocaleString()}</p>
                <p>Cashier: ${orderDetails.cashier_name || ''}</p>
                <p>Order ID: ${orderDetails.order_id}</p>
            </div>

            <div class="receipt-divider">****************************************************************************************</div>

            <table class="receipt-table">
                ${orderDetails.items.map(item => `
                    <tr>
                        <td>${item.quantity}x ${item.menu_name}</td>
                        <td class="text-end">₱${(item.price * item.quantity).toFixed(2)}</td>
                    </tr>
                `).join('')}
            </table>

            <div class="receipt-divider">****************************************************************************************</div>

            <div class="receipt-total-section">
                <div class="total-row">
                    <span>Total:</span>
                    <span class="text-end">₱${total_price.toFixed(2)}</span>
                </div>
                <div class="total-row">
                    <span>Cash:</span>
                    <span class="text-end">₱${orderDetails.cash || 0}</span>
                </div>
                <div class="total-row">
                    <span>Change:</span>
                    <span class="text-end">₱${(orderDetails.cash - total_price).toFixed(2)}</span>
                </div>
            </div>

            <div class="receipt-footer">
                <p>We love to hear your feedback</p>
                <p>Email us at PinkCake@gmail.com</p>
                <p>Take our survey at</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="printReceiptButton">Print Receipt</button> <!-- Added print button -->
        </div>
    </div>
</div>
`;

    document.body.appendChild(receiptModal);
    var modal = new bootstrap.Modal(receiptModal);
    modal.show();

    // Add print functionality to the Print Receipt button
    const printButton = document.getElementById('printReceiptButton');
    printButton.addEventListener('click', function() {
      printReceipt();
    });

    // Function to print the receipt
    function printReceipt() {
      const printContent = document.getElementById('receiptContent').innerHTML;
      const originalContent = document.body.innerHTML;

      document.body.innerHTML = printContent;
      window.print();
      document.body.innerHTML = originalContent;
      window.location.reload(); // Reload to restore the original content after printing
    }

    // Clear cart after the order is successful
    clearCart();

    receiptModal.addEventListener('hidden.bs.modal', function() {
      document.body.removeChild(receiptModal);
    });
  }

  function clearCart() {
    localStorage.removeItem('cartItems'); 
    productListsContainer.innerHTML = ''; 
    totalItemsElement.textContent = '0'; 
    subtotalElement.textContent = '₱0.00'; 
    discountElement.textContent = '₱0.00'; 
    totalElement.textContent = '₱0.00'; 
    if (checkoutTotalElement) {
      checkoutTotalElement.textContent = '₱0.00'; 
    }
    console.log("Cart has been cleared.");
  }


  $("#checkoutBtn").click(function() {
    var order_type = $("#orderType").val();
    var discount = $("#discount").val();
    var total_price = $("#total-value").text().replace("₱", "").trim();
    var payment_method = $('input[name="payment_method"]:checked').val();
    var customer = $("#walkin-name").val() || "Walk-in Customer";
    var created_by = "1"; // Replace with actual user ID
 
    var orderedItems = [];
    $(".product-lists li[data-id]").each(function() {
      var item = {
        menu_id: $(this).attr("data-id"),
        menu_name: $(this).find("h4").text().trim(),
        quantity: parseInt($(this).find(".quantity-field").val()),
        price: parseFloat($(this).next(".price-item").text().replace("Price: ", "").trim())
      };

      if (item.menu_id && item.menu_name && !isNaN(item.quantity) && item.price) {
        orderedItems.push(item);
      }
    });

    var data = {
      customer: customer,
      order_type: order_type,
      discount: discount,
      payment_method: payment_method,
      total_price: total_price,
      created_by: created_by,
      orderedItems: orderedItems,
    };

    $.ajax({
      url: "place_order.php",
      type: "POST",
      data: JSON.stringify(data),
      contentType: "application/json",
      dataType: "json",
      success: function(response) {
        console.log("Response from server:", response); 
        if (response.status === "success") {
          showNotification("Order submitted successfully!");


          const orderDetails = {
            order_id: response.order_id,
            items: orderedItems,
            subtotal: response.subtotal || 0, 
            total_price: parseFloat(total_price.replace("₱", "").trim()) || 0, 
            cashier_name: "JamesS" 
          };
    
          showReceipt(orderDetails);
       
        } else {
          alert("Error: " + response.message);
        }
      },

      error: function(jqXHR, textStatus, errorThrown) {
        console.log("Server response:", jqXHR.responseText);
        alert("There was an error processing your order: " + jqXHR.responseText);
      },
    });
  });



  // Show notification
  function showNotification(message) {
    const notification = document.getElementById("notification");
    const notificationMessage = document.getElementById("notification-message");
    notificationMessage.textContent = message;
    notification.style.display = "block";
    notification.style.opacity = 1;

    setTimeout(() => {
      notification.style.opacity = 0;
      setTimeout(() => {
        notification.style.display = "none";
      }, 500); // Wait for fade-out before hiding
    }, 3000); // Display for 3 seconds
  }


  document.getElementById("category").addEventListener("change", function() {
    const selectedCategory = this.value;
    const products = document.querySelectorAll(".productset");

    products.forEach((product) => {
      const productCategory = product.getAttribute("data-category");

      if (selectedCategory === "" || productCategory === selectedCategory) {
        product.style.display = "block";
      } else {
        product.style.display = "none";
      }
    });
  });

  function handleQuantityChange(event) {
    const button = event.target;
    const input = button.parentElement.querySelector(".quantity-field");
    let value = parseInt(input.value, 10);

    if (isNaN(value) || value < 0) {
      value = 0; // Reset to zero if invalid or negative
    }

    if (button.classList.contains("button-minus")) {
      if (value > 0) {
        value--;
      }
    } else if (button.classList.contains("button-plus")) {
      value++;
    }

    input.value = value;
    updateTotals(); // Update totals after changing quantity
  }

  function handleRemove(event) {
    const target = event.target.closest(".remove-item");
    if (target) {
      const ul = target.closest("ul.product-lists");
      if (ul) {
        ul.remove(); // Remove the entire <ul> element
        updateTotals(); // Update totals after removal
      }
    }
  }

  function clearAll() {
    productListsContainer.innerHTML = ""; // Remove all <ul> elements
    updateTotals(); // Update totals after clearing all
  }

  document.querySelectorAll(".productset").forEach((item) => {
    item.addEventListener("click", function() {
      const id = this.getAttribute("data-id");
      const name = this.getAttribute("data-name");
      const price = this.getAttribute("data-price");
      const image = this.getAttribute("data-image");
      const categoryId = this.getAttribute("data-category-id");

      addProductList({
        id,
        name,
        price,
        image,
        categoryId
      });
    });
  });

  document.addEventListener("click", function(event) {
    if (
      event.target.classList.contains("button-minus") ||
      event.target.classList.contains("button-plus")
    ) {
      handleQuantityChange(event);
    } else if (event.target.closest(".remove-item")) {
      handleRemove(event);
    }
  });

  clearAllButton.addEventListener("click", clearAll); // Attach the clearAll function to the "Clear all" button
});
