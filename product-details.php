<?php
// Include the database configuration file
include('db/config.php');

// Get the menu_id from the URL
$menu_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($menu_id > 0) {
    // Fetch cake details
    $query = "SELECT menu_name, price, image_path, description, status, category_name FROM menu WHERE menu_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $menu_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cake = $result->fetch_assoc();
    } else {
        echo "Cake not found.";
        exit;
    }
} else {
    echo "Invalid cake ID.";
    exit;
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
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- Title Tag  -->
    <title>Sweet Spot Cake shop</title>
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
  

    <link rel="stylesheet" href="#" id="colors" />
    <style>
.date-options, .time-options {
  display: flex;
  gap: 10px;
}



.date-option, .time-option, .category-btn, .btn {
  background-color: #fff; /* Default white background */
  color: #333;
  border: 1px solid #ddd;
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
  min-height: 50px; /* Set minimum height for taller buttons */
  min-width: 100px; /* Optional: Set minimum width for consistency */
  display: flex;
  align-items: center;
  justify-content: center;
}


.date-option.active, .time-option.active, .category-btn.active, .btn.active {
  background-color: #4CAF50; /* Green background when selected */
  color: white; /* White text when selected */
}

.delivery-date, .delivery-time, .card-message, .quantity-container {
  margin-top: 20px;
}
.date-option, .time-option {
  background-color: #fff; /* Default white background */
  color: #333;
  border: 1px solid #ddd;
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
  min-height: 50px; /* Set minimum height for taller buttons */
  min-width: 100px; /* Optional: Set minimum width for consistency */
  display: flex;
  align-items: center;
  justify-content: center;
}

.date-option.active, .time-option.active {
  background-color: #ff9800; /* Orange background when selected */
  color: #fff; /* White text when selected */
}


/* Additional styling for horizontal alignment */
.options-row {
  display: flex;
  gap: 20px;
  align-items: center;
  justify-content: center; /* Centers horizontally */
  margin-top: 20px;
  flex-wrap: wrap; /* Allows wrapping on smaller screens */
}


.card-message {
  margin-top: 40px; /* More space above the Card Message */
}

.card-message label {
  display: block;
  margin-bottom: 5px; /* Space between label and textarea */
}

.full-calendar {
  background-color: #f5f5f5;
  color: #333;
  border: none;
  padding: 10px;
  cursor: pointer;
  width: 100%;
}

.card-message textarea {
  width: 100%;
  height: 150px;
  padding: 10px;
  border: 1px solid #ddd;
  resize: none;
  font-size: 1rem;
}


/* Category button styles */
.category-btn {
  background-color: #fff;
  color: #333;
  border: 1px solid #ccc;
  padding: 8px 16px;
  border-radius: 5px;
  cursor: pointer;
  text-align: center;
  min-width: 100px;
}

.category-btn.active {
  background-color: #ff9800; /* Orange when active */
  color: white;
}

.cake-des {
  padding: 20px;
}

.delivery-date {
  position: relative;
}

.full-calendar {
  display: inline-block;
  text-align: center;
  padding: 10px;
}

#calendarDropdown.show {
  opacity: 1;
  max-height: 500px; /* You can adjust this value to match the height of your calendar */
}
.calendar-dropdown {
  position: relative; /* Allow it to push content down */
  width: 100%;
  background-color: white;
  border: 1px solid #ddd;
  padding: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  max-height: 340px; /* Start collapsed */
  overflow: hidden; /* Hide content when collapsed */
  transition: max-height 0.3s ease; /* Smooth expand/collapse */
  margin-top: 10px; /* Adds a bit of spacing when expanded */
}


.calendar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.calendar-table {
  width: 100%;
  border-collapse: collapse;
}

.calendar-table th,
.calendar-table td {
  width: 14.28%;
  text-align: center;
  padding: 5px;
}

.selected-day {
  background-color: #ff009b; /* Orange for selected day */
  color: white;
  border-radius: 2%;
}

.delivery-time-label {
  font-size: 16px;
  font-weight: bold;
  margin-bottom: 8px;
}

.time-options {
  display: flex;
  gap: 10px;
  justify-content: center;
  flex-wrap: wrap;
}

.time-option {
  background-color: #fff; /* Default white background */
  color: #333;
  border: 1px solid #ddd;
  padding: 12px 15px;
  border-radius: 5px;
  cursor: pointer;
  text-align: center;
  flex-grow: 1;
  min-width: 120px;
}

.time-option.active {
  background-color: #ff9800; /* Orange when active */
  color: white;
}

@media (max-width: 768px) {
  .time-options {
    flex-direction: column;
    align-items: stretch;
  }
  .time-option {
    width: 100%;
  }
}

.date-options {
  display: flex;
  gap: 10px;
  justify-content: center;
  flex-wrap: wrap;
}

.date-option {
  background-color: #fff; /* Default white background */
  color: #333;
  border: 1px solid #ddd;
  padding: 10px 15px;
  border-radius: 5px;
  cursor: pointer;
  text-align: center;
  flex-grow: 1;
  min-width: 120px;
}

.date-option.active {
  background-color: #ff9800; /* Orange when active */
  color: white;
}

.date-option br {
  display: block;
  margin: 5px 0;
}

@media (max-width: 768px) {
  .date-options {
    flex-direction: column;
    align-items: stretch;
  }
  .date-option {
    width: 100%;
  }
}

.quantity-container {
  display: flex;
  align-items: center;
  gap: 10px;
}

.quantity, .candle-dropdown {
  width: 200px;
}

.input-group {
  width: 100%;
  display: flex;
  align-items: center;
}

.btn, .input-number {
  height: 38px;
}

.candle-dropdown label {
  display: none;
}

.candle-dropdown h6 {
  margin-bottom: 10px;
}

.dropup .dropdown-menu {
  bottom: 100%;
  left: 0;
  right: 0;
}

.add-to-cart {
  display: flex;
  justify-content: center;  /* Centers the button horizontally */
  align-items: center;  /* Centers the button vertically */
  margin-top: 20px;  /* Optional: Adjust spacing above the button */
}

.add-to-cart .btn {
  width: 300px; /* Adjust width as needed */
  height: 50px; /* Set the desired height */
  text-align: center;
  padding: 10px;
  background-color: #ff9800;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px; /* Adjust font size if needed */
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Add this CSS to style the selected button */
.btn.selected {
  background-color: #ff1c8d;
  color: white;
  border-color: #ff1c8d;
}

.btn:not(.selected):hover {
  background-color: #ff1c8d; /* Lighter shade for hover effect */
}


#reviews-container {
  margin-top: 20px;
}

.single-review {
  display: flex;  /* Align profile image, stars, and name horizontally */
  align-items: flex-start;  /* Align items at the top */
  padding: 15px;
  border-bottom: 1px solid #eaeaea;
  margin-bottom: 15px;
  flex-direction: column;  /* Stack the content vertically */
}

.review-header {
  display: flex;
  align-items: center;
  margin-right: 15px;
}

.review-header img {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  margin-right: 15px;
}

.review-info h5 {
  margin: 0;
  font-size: 16px;
}

.review-info .ratings i {
  color: #f8b400;
}

.single-review p {
  margin-top: 10px;  /* Add spacing between stars and the review text */
  font-size: 14px;  
  color: #555;
  align-self: flex-start;  /* Align the paragraph with the rest of the content */
  margin-left: 64px; /* Add left margin to move the comment right */
}


/* User rating stars - horizontally aligned */
#user-rating {
  display: flex;
  gap: 5px;
  margin-bottom: 15px;
}

#user-rating li {
  list-style-type: none;
}

#user-rating li i {
  color: #ccc; /* Set color of stars to light gray when unselected */
  font-size: 24px; /* Increase the font size of stars */
}

#user-rating li.selected i {
  color: #f8b400; /* Color for selected stars */
}

/* Overall Rating Stars - Horizontally aligned */
#overall-rating-stars {
  display: flex;
  justify-content: flex-start;
  gap: 5px;
}

#overall-rating-stars li {
  list-style-type: none;
}

#overall-rating-stars i {
  font-size: 20px;
  color: #f8b400;
}

.view-more-btn {
  background: #C91868;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: background-color 0.3s ease;
}

.view-more-btn:hover {
  background-color: #0056b3;
}

.view-more-btn:active {
  background-color: #004494;
}

.confirmation-message {
  position: fixed;
  top: 20px;               /* Distance from the top of the screen */
  right: 20px;             /* Distance from the right of the screen */
  background-color: green; /* Background color for success */
  color: white;            /* Text color */
  padding: 10px 20px;      /* Padding around the message */
  border-radius: 5px;      /* Rounded corners */
  font-size: 16px;         /* Font size */
  display: none;           /* Hide by default */
  opacity: 0;              /* Start invisible */
  transition: opacity 0.5s ease-in-out; /* Smooth fade-in and fade-out */
  z-index: 9999;           /* Ensure it's on top of other content */
}


</style>
  </head>
  <body class="js">

    <!-- End Preloader -->



    <?php include 'header.php'; ?> 



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
                <li class="active">
                  <a href="product-details.php">Menu Details</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Breadcrumbs -->

<!-- Shop Single -->
<section class="shop single section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="row">
          <!-- Cake Image Gallery -->
          <div class="col-lg-6 col-12">
            <div class="cake-gallery">
              <!-- Images slider -->
              <div class="flexslider-thumbnails">
                <ul class="slides">
                  <li data-thumb="<?= htmlspecialchars($cake['image_path']); ?>">
                    <img src="<?= htmlspecialchars($cake['image_path']); ?>" alt="<?= htmlspecialchars($cake['menu_name']); ?>" />
                  </li>
                  <li data-thumb="<?= htmlspecialchars($cake['image_path']); ?>">
                    <img src="<?= htmlspecialchars($cake['image_path']); ?>" alt="<?= htmlspecialchars($cake['menu_name']); ?>" />
                  </li>
                  <li data-thumb="<?= htmlspecialchars($cake['image_path']); ?>">
                    <img src="<?= htmlspecialchars($cake['image_path']); ?>" alt="<?= htmlspecialchars($cake['menu_name']); ?>" />
                  </li>
                  <li data-thumb="<?= htmlspecialchars($cake['image_path']); ?>">
                    <img src="<?= htmlspecialchars($cake['image_path']); ?>" alt="<?= htmlspecialchars($cake['menu_name']); ?>" />
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <!-- End Cake Image Gallery -->

          <!-- Cake Details -->
          <div class="col-lg-6 col-12 ">
            <div class="cake-des">
              <!-- Cake Name -->
              <h4 class="mb-3"><?= htmlspecialchars($cake['menu_name']); ?></h4>

              <!-- Cake Price -->
              <p class="price mb-3"><span class="discount">₱<?= number_format($cake['price'], 2); ?></span></p>

              <!-- Cake Description -->
              <p class="description mb-4"><?= htmlspecialchars($cake['description']); ?></p>

              <!-- Category -->
              <!-- <p class="cat mb-4">Category: <a href="#"><?= htmlspecialchars($cake['category_name']); ?></a></p> -->
            
              <div class="delivery-date mb-4">
  <label for="delivery-date" class="delivery-label"><h6>Select Date:</h6></label>
  <div class="date-options d-flex gap-2 mb-2">
    <button class="btn date-option" id="today-btn" onclick="selectDate('today')">Today</button>
    <button class="btn date-option" id="tomorrow-btn" onclick="selectDate('tomorrow')">Tomorrow</button>
    <button class="btn date-option" id="day-after-tomorrow-btn" onclick="selectDate('dayAfterTomorrow')">Day After Tomorrow</button>
  </div>
  <button class="btn full-calendar mt-2" onclick="toggleCalendar()"><h6>View Full Calendar</h6></button>

  <div id="calendarDropdown" class="calendar-dropdown" style="display: none;">
    <div class="calendar-header">
      <button class="btn calendar-nav" onclick="changeMonth(-1)">&#8592;</button>
      <span id="calendarMonth" class="calendar-month" data-date=""></span>
      <button class="btn calendar-nav" onclick="changeMonth(1)">&#8594;</button>
    </div>
    <table class="calendar-table">
      <thead>
        <tr>
          <th>Sun</th>
          <th>Mon</th>
          <th>Tue</th>
          <th>Wed</th>
          <th>Thu</th>
          <th>Fri</th>
          <th>Sat</th>
        </tr>
      </thead>
      <tbody id="calendarDays"></tbody>
    </table>
  </div>
</div>









              <div class="delivery-time mb-4">
              <label for="delivery-date" class="delivery-label"><h6>Select Time:</h6></label>
                <div class="time-options d-flex gap-2">
                  <button class="btn time-option ">11AM - 1PM</button>
                  <button class="btn time-option">1PM - 3PM</button>
                  <button class="btn time-option">3PM - 5PM</button>
                  <button class="btn time-option">5PM - 7PM</button>
                </div>
              </div>

              
              <div class="quantity-container">
  <div class="quantity">
    <h6>QUANTITY</h6>
    <div class="input-group">
      <div class="button minus">
        <button type="button" class="btn btn-primary btn-number" data-type="minus" data-field="quant[1]"><i class="ti-minus"></i></button>
      </div>
      <input type="text" name="quant[1]" class="input-number" data-min="1" data-max="1000" value="1">
      <div class="button plus">
        <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]"><i class="ti-plus"></i></button>
      </div>
    </div>
  </div>

  <!-- Candle Dropdown with Label -->
  <div class="candle-dropdown">
    <h6>CANDLES</h6>
    <div class="input-group">
      <button type="button" class="btn btn-primary dropdown-toggle" id="candles" data-bs-toggle="dropdown" aria-expanded="false">
        Select Candles
      </button>
      <ul class="dropdown-menu" aria-labelledby="candles">
      
        <li><a class="dropdown-item" href="#">1</a></li>
        <li><a class="dropdown-item" href="#">2</a></li>
        <li><a class="dropdown-item" href="#">3</a></li>
        <li><a class="dropdown-item" href="#">4</a></li>
        <li><a class="dropdown-item" href="#">5</a></li>
        <li><a class="dropdown-item" href="#">6</a></li>
        <li><a class="dropdown-item" href="#">7</a></li>
        <li><a class="dropdown-item" href="#">8</a></li>
        <li><a class="dropdown-item" href="#">9</a></li>
        <li><a class="dropdown-item" href="#">10</a></li>
        <li><a class="dropdown-item" href="#">11</a></li>
        <li><a class="dropdown-item" href="#">12</a></li>
        <li><a class="dropdown-item" href="#">13</a></li>
        <li><a class="dropdown-item" href="#">14</a></li>
        <li><a class="dropdown-item" href="#">15</a></li>
        <li><a class="dropdown-item" href="#">16</a></li>
        <li><a class="dropdown-item" href="#">17</a></li>
        <li><a class="dropdown-item" href="#">18</a></li>
        <li><a class="dropdown-item" href="#">19</a></li>
        <li><a class="dropdown-item" href="#">20</a></li>
      </ul>
    </div>
  </div>
</div>


              <!-- Card Message -->
              <div class="card-message mb-4">
              <label for="delivery-date" class="delivery-label"><h6>Cake Message [Max. 20 words]</h6></label>
                <textarea id="cardMessageText" name="card_message" maxlength="250" placeholder="Input here..." rows="4" style="width: 100%; padding: 10px;"></textarea>
              </div>

         
    <!-- Add to Cart with Parameters -->
<div class="cake-buy d-flex align-items-center gap-3">
  <div class="add-to-cart">
    <a href="#" class="btn" onclick="addToCart()">Add to cart</a>
  </div>
</div>


            </div>
          </div>
          <!-- End Cake Details -->
        </div>
        <div class="row">
  <div class="col-12">
    <div class="product-info">
      <div class="nav-main">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#reviews" role="tab">Reviews</a>
          </li>
        </ul>
      </div>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="reviews" role="tabpanel">
          <div class="tab-single review-panel">
            <div class="row">
              <div class="col-12">
                <!-- Overall Rating -->
                <div class="overall-rating">
                  <h5>Overall Rating: <span id="overall-rating">0</span> / 5</h5>
                  <div class="ratings">
                    <ul class="rating" id="overall-rating-stars">
                      <!-- Stars will be dynamically updated here -->
                    </ul>
                  </div>
                </div>

                <!-- Reviews Container -->
                <div id="reviews-container" class="ratting-main">
                  <!-- Existing reviews will be displayed here dynamically -->
                </div>
                <div style="text-align: center; margin-top: 20px;">
                  <button id="view-more-reviews" class="btn view-more-btn">View More Reviews</button>
                </div>

                <!-- Add Review Section -->
                <div class="comment-review">
                 
                  <h4>Rating</h4>
                  <div class="review-inner">
                    <div class="ratings">
                      <ul class="rating" id="user-rating">
                        <li data-value="1"><i class="fa fa-star"></i></li>
                        <li data-value="2"><i class="fa fa-star"></i></li>
                        <li data-value="3"><i class="fa fa-star"></i></li>
                        <li data-value="4"><i class="fa fa-star"></i></li>
                        <li data-value="5"><i class="fa fa-star"></i></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <form class="form" id="review-form">
                  <div class="row">
                    <div class="col-lg-6 col-12">
                      <div class="form-group">
                        <label>Name<span></span></label>
                        <input type="text" id="review-name" name="name" required placeholder="Your Name" />
                      </div>
                    </div>
                    <div class="col-lg-6 col-12">
                      <div class="form-group">
                        <label>Email<span></span></label>
                        <input type="email" id="review-email" name="email" required placeholder="Your Email" />
                      </div>
                    </div>
                    <div class="col-lg-12 col-12">
                      <div class="form-group">
                        <label>Write a review<span></span></label>
                        <textarea id="review-message" name="message" rows="6" required placeholder="Write your review"></textarea>
                      </div>
                    </div>
                    <div class="col-lg-12 col-12">
                      <div class="form-group button5">
                        <button type="submit" class="btn" id="submit-review">Submit</button>
                      </div>
                    </div>
                  </div>
                </form>

                <!-- Confirmation Message -->
                <div id="confirmation-message" style="margin-top: 20px; color: green;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

    </div>
  </div>
    </div>
</section>




  <!-- Start Most Popular -->

<div class="cake-area most-popular related-cake section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="section-title">
          <h2>Related Cakes</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="owl-carousel popular-slider">
          <?php
          // Fetch related cakes from the same category, excluding the current cake
          $query = "SELECT * FROM menu WHERE category_name = ? AND menu_id != ? LIMIT 4";
          $stmt = $conn->prepare($query);
          $stmt->bind_param("si", $current_category, $cake['menu_id']);
          $stmt->execute();
          $result_related = $stmt->get_result();

          // Display the related cakes
          while ($related_cake = $result_related->fetch_assoc()) {
          ?>
          <div class="single-cake">
            <div class="cake-img">
              <a href="product-details.php?id=<?= $related_cake['menu_id']; ?>">
                <img class="default-img" src="<?= htmlspecialchars($related_cake['image_path']); ?>" alt="<?= htmlspecialchars($related_cake['menu_name']); ?>" />
                <img class="hover-img" src="<?= htmlspecialchars($related_cake['image_path']); ?>" alt="<?= htmlspecialchars($related_cake['menu_name']); ?>" />
              </a>
              <div class="button-head">
                <div class="cake-action">
                  <a title="Wishlist" href="#"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
                </div>
                <div class="cake-action-2">
                  <a title="Add to cart" href="#">Add to cart</a>
                </div>
              </div>
            </div>
            <div class="cake-content">
              <h3>
                <a href="product-details.php?id=<?= $related_cake['menu_id']; ?>">
                  <?= htmlspecialchars($related_cake['menu_name']); ?>
                </a>
              </h3>
              <div class="cake-price">
                <span>₱<?= number_format($related_cake['price'], 2); ?></span>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Most Popular -->



               
                  </div>
                </div>
              </div>
            </div> 

            </section>
    <!-- Modal -->
    

    <!-- Start Footer Area -->
    <?php include 'footer.php'; ?>
    <script>
// Variables to store selected data
let selectedDate = '';
let selectedTime = '';
let selectedCategory = '';
let selectedQuantity = 1;
let selectedCandles = 0;
let cardMessage = '';
let selectedDay = null; // Store only one selected date
let currentDate = new Date();


let selectedRating = 0;
let ratingsArray = []; // Array to store all numeric ratings
let reviewsArray = []; // Array to store all review HTML
let displayedReviews = 0; // Counter for displayed reviews
const REVIEWS_PER_PAGE = 3; // Number of reviews to show at a time
const MAX_REVIEWS_PER_USER = 3; // Maximum reviews per user
const userReviewCounts = {}; // Object to track reviews submitted by each user

// Handle the star selection for individual reviews
const ratingStars = document.querySelectorAll("#user-rating li");
ratingStars.forEach((star) => {
  star.addEventListener("click", function () {
    selectedRating = parseInt(star.getAttribute("data-value"));
    ratingStars.forEach((s) => {
      if (parseInt(s.getAttribute("data-value")) <= selectedRating) {
        s.classList.add("selected");
      } else {
        s.classList.remove("selected");
      }
    });
  });
});



// Function to generate a random anime image URL using Waifu.pics
async function getRandomAnimeImage() {
  try {
    const response = await fetch('https://api.waifu.pics/sfw/waifu');
    const data = await response.json();
    return data.url;
  } catch (error) {
    console.error("Error fetching anime image:", error);
    return 'https://via.placeholder.com/50';
  }
}

// Function to render reviews with a limit
function renderReviews() {
  const reviewsContainer = document.getElementById("reviews-container");
  reviewsContainer.innerHTML = '';

  const reviewsToShow = reviewsArray.slice(0, displayedReviews);
  reviewsToShow.forEach((reviewHTML) => {
    const reviewElement = document.createElement("div");
    reviewElement.innerHTML = reviewHTML;
    reviewsContainer.appendChild(reviewElement);
  });

  const viewMoreButton = document.getElementById("view-more-reviews");
  viewMoreButton.style.display = displayedReviews >= reviewsArray.length ? "none" : "block";
}
let offset = 2; // Initially load 2 reviews
let reviewsLoaded = 0; // Number of reviews loaded so far


// Function to update the overall rating
function updateOverallRating() {
  if (ratingsArray.length === 0) {
    document.getElementById("overall-rating").textContent = "0";
    document.getElementById("overall-rating-stars").innerHTML = '';
    return;
  }

  const total = ratingsArray.reduce((acc, rating) => acc + rating, 0);
  const averageRating = (total / ratingsArray.length).toFixed(1);

  document.getElementById("overall-rating").textContent = averageRating;

  const overallStarsContainer = document.getElementById("overall-rating-stars");
  overallStarsContainer.innerHTML = '';
  for (let i = 1; i <= 5; i++) {
    const star = document.createElement("li");
    if (i <= Math.floor(averageRating)) {
      star.innerHTML = '<i class="fa fa-star"></i>';
    } else if (i <= averageRating) {
      star.innerHTML = '<i class="fa fa-star-half-o"></i>';
    } else {
      star.innerHTML = '<i class="fa fa-star-o"></i>';
    }
    overallStarsContainer.appendChild(star);
  }
}

// Function to fetch and display reviews from the database
async function fetchReviews() {
  try {
    console.log('Fetching reviews with offset:', offset);

    const response = await fetch(`fetch_reviews.php?offset=${offset}`);
    const data = await response.json();

    if (data.reviews && data.reviews.length > 0) {
      const reviewsContainer = document.getElementById('reviews-container');
      
      // Loop through the reviews and add them to the container
      data.reviews.forEach(review => {
        const reviewHTML = `
          <div class="single-review">
            <div class="review-header">
              <img src="${review.user_image_url}" alt="User" />
              <div class="review-info">
                <h5>${review.name}</h5>
                <div class="ratings">
                  ${'<i class="fa fa-star"></i>'.repeat(review.rating)}
                  ${'<i class="fa fa-star-o"></i>'.repeat(5 - review.rating)}
                </div>
                <span class="review-date">${new Date(review.created_at).toLocaleDateString()}</span>
              </div>
            </div>
            <p>${review.message}</p>
          </div>
        `;
        reviewsContainer.innerHTML += reviewHTML;
        ratingsArray.push(parseFloat(review.rating)); // Add review rating
      });

      // Update the overall rating after fetching reviews
      updateOverallRating();

      // Update the offset for the next set of reviews
      offset += 2;

      // Check if there are no more reviews to load
      const viewMoreButton = document.getElementById('view-more-reviews');
      if (data.reviews.length < 2) {
        if (viewMoreButton) {
          viewMoreButton.style.display = 'none'; // Hide the button if no more reviews
        }
      }

    } else {
      console.log('No more reviews available');
    }
  } catch (error) {
    console.error('Error fetching reviews:', error);
  }
}

// Initially load the first 2 reviews when the page loads
window.onload = fetchReviews;

// Handle "View More Reviews" button click
document.getElementById('view-more-reviews').addEventListener('click', async function() {
  console.log('View More Reviews button clicked');
  await fetchReviews(); // Fetch more reviews when clicked
});


// Initially load the first 2 reviews when the page loads
window.onload = fetchReviews;


// Function to get menu_id from URL or localStorage
function getMenuId() {
  // First, check if menu_id is in localStorage
  const menuId = localStorage.getItem('menu_id');

  // If menu_id is not found in localStorage, try fetching it from the URL query string
  if (!menuId) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('menu_id');  // Return menu_id from URL, if present
  }

  return menuId;  // Return menu_id from localStorage if available
}




// Handle "View More Reviews" button click
document.getElementById('view-more-reviews').addEventListener('click', async function() {
  const viewMoreButton = document.getElementById('view-more-reviews');
  if (viewMoreButton) {
    console.log('View More Reviews button clicked');
    await fetchReviews();
  } else {
    console.warn('View More Reviews button is not available');
  }
});

document.getElementById("submit-review").addEventListener("click", async function (event) {
  event.preventDefault();

  const name = document.getElementById("review-name").value.trim();
  const email = document.getElementById("review-email").value.trim();
  const message = document.getElementById("review-message").value.trim();

  // Regular expression to validate email format
  const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

  // Validation: Check if fields are empty, rating is selected, and email is valid
  if (!name || !email || !message || selectedRating === 0) {
    alert("Please fill in all fields and select a rating.");
    return;
  }

  if (!emailPattern.test(email)) {
    alert("Please enter a valid email address.");
    return;
  }

  // Track user review count
  if (!userReviewCounts[email]) {
    userReviewCounts[email] = 0;
  }

  if (userReviewCounts[email] >= MAX_REVIEWS_PER_USER) {
    alert("You can only submit up to 3 reviews.");
    return;
  }

  userReviewCounts[email]++;

  const userImageUrl = await getRandomAnimeImage();

  // Get the menu_id using the function you provided
  const menuId = getMenuId();

  const reviewData = {
    name: name,
    email: email,
    message: message,
    rating: selectedRating,
    userImageUrl: userImageUrl,
    menuId: menuId,  // Include menu_id in the review data
  };

  try {
    const response = await fetch("submit_review.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(reviewData),
    });

    if (!response.ok) {
      throw new Error("Failed to submit review");
    }

    const result = await response.json();
    console.log(result); // Handle success/failure messages from the server

    // Show the floating success message
    const confirmationMessage = document.getElementById("confirmation-message");
    confirmationMessage.textContent = "Your review has been submitted!";
    confirmationMessage.style.display = "block";  // Make the message visible
    confirmationMessage.style.opacity = 1;        // Fade in the message

    // Disable the "Submit Review" button after the review is submitted
    document.getElementById("submit-review").disabled = true;  // Disables the button

    // Reset the form and rating selection
    document.getElementById("review-form").reset();
    ratingStars.forEach((star) => star.classList.remove("selected"));
    selectedRating = 0;

    // Hide the confirmation message after 5 seconds
    setTimeout(() => {
      confirmationMessage.style.opacity = 0;      // Fade out the message
      setTimeout(() => {
        confirmationMessage.style.display = "none"; // Hide it completely after fading
      }, 500);  // Match the transition time
      // Re-enable the "Submit Review" button
      document.getElementById("submit-review").disabled = false;
    }, 5000); // 5000ms = 5 seconds

  } catch (error) {
    console.error("Error:", error);
  }
});


// Function to close the calendar
function closeCalendar() {
  const calendarDropdown = document.getElementById("calendarDropdown");
  calendarDropdown.style.display = "none";
}


// Function to handle selecting a specific date option
function selectDate(option) {
  const today = new Date();
  let selectedDate;

  if (option === 'today') {
    selectedDate = today;
  } else if (option === 'tomorrow') {
    selectedDate = new Date(today);
    selectedDate.setDate(today.getDate() + 1);
  } else if (option === 'dayAfterTomorrow') {
    selectedDate = new Date(today);
    selectedDate.setDate(today.getDate() + 2);
  }

  // Save the selected date globally
  selectedDate = selectedDate;

  // Update the displayed date in the UI
  document.getElementById('selectedDateDisplay').textContent = selectedDate.toDateString(); // Update the display

  // Optionally close the calendar if it was opened
  closeCalendar();
}


// Function to handle selection of a button (Date, Time, Category)
function selectButton(section, selectedButton) {
  // Remove 'selected' class from all buttons in the section
  document.querySelectorAll(`${section} .btn`).forEach(button => button.classList.remove('selected'));

  // Add 'selected' class to the clicked button
  selectedButton.classList.add('selected');

  // Save the selected value based on the section
  if (section === '.delivery-date') {
    // Close the calendar if a date option is selected
    const calendar = document.getElementById("calendarDropdown");
    if (calendar.style.display === "block") {
      selectedDate = ''; // Reset to default if the calendar is open
      document.querySelectorAll('.date-option').forEach(button => button.classList.remove('selected'));
      calendar.style.display = "none"; // Close the calendar when a date is selected
    }

    // Save the selected date value
    selectedDate = selectedButton.innerText; // Assuming the button text is the date
    document.getElementById('selectedDateDisplay').textContent = selectedDate; // Optionally update the displayed selected date
  } 
  else if (section === '.delivery-time') {
    // Save the selected time value
    selectedTime = selectedButton.innerText;
    document.getElementById('selectedTimeDisplay').textContent = selectedTime; // Optionally update the displayed selected time
  } 

}


// Event listeners for button selections (Date, Time, Category)
document.querySelectorAll('.date-option').forEach(button => {
  button.addEventListener('click', () => {
    selectButton('.delivery-date', button);
    // Close calendar automatically after selecting a date
    document.getElementById("calendarDropdown").style.display = "none";
  });
});

document.querySelectorAll('.time-option').forEach(button => {
  button.addEventListener('click', () => selectButton('.delivery-time', button));
});


// Function to toggle the calendar visibility
function toggleCalendar() {
  const calendar = document.getElementById("calendarDropdown");
  const dateOptions = document.querySelector('.date-options');
  
  // Check if the calendar is currently visible
  if (calendar.style.display === "none" || !calendar.style.display) {
    // Show the calendar with smooth transition
    calendar.style.display = "block";  // Ensure it’s displayed
    
    // Apply transition for smooth opening
    setTimeout(() => {
      calendar.style.transition = "opacity 0.5s ease-in-out, max-height 0.5s ease-in-out"; // Apply transition effect
      calendar.style.opacity = 1;  // Fade in
      calendar.style.maxHeight = "500px"; // Adjust max height based on your content
    }, 10); // Small delay for the transition to take effect
    
    // Clear the selected date when opening the full calendar view
    selectedDate = ''; // Reset the selected date to default
    renderCalendar();  // Re-render the calendar to reflect the reset state
    
    // Remove the selected styling for date options
    dateOptions.querySelectorAll('.btn').forEach(button => button.classList.remove('selected'));
  } else {
    // Hide the calendar with smooth transition
    calendar.style.transition = "opacity 0.5s ease-in-out, max-height 0.5s ease-in-out"; // Apply transition effect
    calendar.style.opacity = 0;  // Fade out
    calendar.style.maxHeight = "0"; // Collapse the calendar
    
    // After the transition, set the display to 'none' to remove it from the layout
    setTimeout(() => {
      calendar.style.display = "none";
    }, 500); // Wait for the transition to complete before hiding the element
  }
}





function formatDate(date) {
    const options = { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' };
    return date.toLocaleDateString('en-GB', options);
}

// Function to get the weekday abbreviation
function getWeekdayAbbreviation(date) {
    const options = { weekday: 'short' };
    return date.toLocaleDateString('en-GB', options);
}

// Get current date and next two days
const today = new Date();
const tomorrow = new Date(today);
tomorrow.setDate(today.getDate() + 1);
const dayAfterTomorrow = new Date(today);
dayAfterTomorrow.setDate(today.getDate() + 2);

// Set button text dynamically with correct weekdays
document.getElementById('today-btn').innerHTML = `Today<br>${formatDate(today)}`;
document.getElementById('tomorrow-btn').innerHTML = `${getWeekdayAbbreviation(tomorrow)}<br>${formatDate(tomorrow)}`;
document.getElementById('day-after-tomorrow-btn').innerHTML = `${getWeekdayAbbreviation(dayAfterTomorrow)}<br>${formatDate(dayAfterTomorrow)}`;

// Event listener for the "Add to Cart" button
document.querySelector('.add-to-cart a').addEventListener('click', function(event) {
  event.preventDefault();
  
  selectedQuantity = document.querySelector('.input-number').value || 1;
  selectedCandles = document.querySelector('#candles').innerText || 0;
  cardMessage = document.querySelector('#cardMessageText').value || '';

  const cartData = { 
    date: selectedDate, // Use selectedDate here
    time: selectedTime,  // Use selectedTime here
    category: selectedCategory, 
    quantity: selectedQuantity, 
    candles: selectedCandles, 
    cardMessage 
  };

  localStorage.setItem('cartData', JSON.stringify(cartData));

  console.log(localStorage.getItem('cartData'));

  updateCart(); // Update the cart display
});



// Event listener for the "Select Date" label/button to toggle calendar visibility
document.querySelector('.delivery-label').addEventListener('click', toggleCalendar);

function renderCalendar() {
  const calendarMonth = document.getElementById("calendarMonth");
  const calendarDays = document.getElementById("calendarDays");
  const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  calendarMonth.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
  calendarDays.innerHTML = "";

  const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
  const lastDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();

  let dayCell = "<tr>";
  for (let i = 0; i < firstDay; i++) dayCell += "<td></td>";
  for (let day = 1; day <= lastDate; day++) {
    const dayId = `${currentDate.getFullYear()}-${currentDate.getMonth()}-${day}`;
    const isSelected = selectedDay === dayId ? 'selected-day' : '';
    dayCell += `<td onclick="selectDay('${dayId}')" class="${isSelected}">${day}</td>`;
    if ((day + firstDay) % 7 === 0) dayCell += "</tr><tr>";
  }
  dayCell += "</tr>";
  calendarDays.innerHTML = dayCell;
}

function changeMonth(offset) {
  currentDate.setMonth(currentDate.getMonth() + offset);
  renderCalendar();
}

function selectDay(dayId) {
  selectedDay = dayId;
  selectedDate = ''; // Clear the selected date when a date is selected from the calendar
  renderCalendar();
}

// Display a custom message in the Card Message textarea
function displayMessage(message) {
  document.getElementById('cardMessageText').value = message;
}

// jQuery for dropdown functionality
$(document).ready(function() {
  $('.dropdown-item').on('click', function() {
    const selectedValue = $(this).text();
    $('#candles').text('Candles: ' + selectedValue);
  });
});

// Initialize an empty cart if it doesn't exist in localStorage
if (!localStorage.getItem("cart")) {
    localStorage.setItem("cart", JSON.stringify([]));
}






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