
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compact Reviews Carousel</title>

    
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
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .payment-section {
    text-align: center;
  
    padding: 20px;
    border-radius: 10px;
    margin: 20px auto;
    max-width: 800px;
    font-family: Arial, sans-serif;
 
}

.payment-heading {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 15px;
}

.payment-icons img {
    width: 450px;
    margin: 0 10px;
    vertical-align: middle;
}

.powered-by {
    margin: 20px 0;
}

.powered-by img {
    width: 500px;
    margin-top: 10px;
}

.payment-description {
    font-size: 1rem;
    margin-top: 15px;
}

.secure-payments {
    font-size: 1rem;
    margin-top: 10px;
}
    </style>
 <!-- Header -->

    
</head>

<body>

<?php include 'header.php'; ?>


<section class="payment-section">
    <h2 class="payment-heading">Mode of Payments</h2>
    <div class="payment-icons">
        <img src="img/menu/payment-method.png" alt="GCash">
        
     
    </div>
    <div class="powered-by">
        <p>Powered by</p>
        <img src="img/menu/PayMongo-Badge.png" alt="PayMongo">
    </div>
    <p class="payment-description">
        We accept GCash, credit cards, bank transfers, Maya, and GrabPay mobile wallets. We also accept BillEase Buy Now, Pay Later.
    </p>
    <p class="secure-payments">
        Select <strong>Secure Payments by PayMongo</strong> upon checkout. You will be redirected to PayMongo's secure payment portal.
    </p>
</section>

   
 
    <!-- Modal -->
    <div class="modal" id="reviewModal">
        <div class="modal-content">
            <button class="modal-close" id="modalClose">&times;</button>
            <img id="modalImage" src="" alt="User Image">
            <div class="stars" id="modalStars"></div>
            <p id="modalMessage" style="font-size: 1rem; color: #555;"></p>
            <div class="review-meta" id="modalDate"></div>
            <p class="review-name" id="modalName"></p>
        </div>
    </div>
    
    <?php include 'news.php'; ?>
  <!-- End Shop Newsletter -->

  <?php include 'service.php'; ?>
  <?php include 'footer.php'; ?>

    <script>
        const container = document.getElementById('reviewsContainer');
        const modal = document.getElementById('reviewModal');
        const modalImage = document.getElementById('modalImage');
        const modalStars = document.getElementById('modalStars');
        const modalMessage = document.getElementById('modalMessage');
        const modalDate = document.getElementById('modalDate');
        const modalName = document.getElementById('modalName');
        const modalClose = document.getElementById('modalClose');

        let reviews = [];
        let currentIndex = 0;

        async function loadReviews() {
            try {
                const response = await fetch(`fetch_reviews.php?offset=0`);
                const data = await response.json();
                reviews = data.reviews;

                reviews.forEach((review, index) => {
                    const card = document.createElement('div');
                    card.className = 'review-card';
                    card.innerHTML = `
                        <img src="${review.user_image_url || 'default-image.jpg'}" alt="${review.name}">
                        <div class="stars">${'★'.repeat(review.rating)}</div>
                        <div class="review-message">${review.message.slice(0, 30)}...</div>
                        <div class="review-meta">${new Date(review.created_at).toLocaleDateString()}</div>
                        <p class="review-name">${review.name}</p>
                    `;
                    card.addEventListener('click', () => openModal(review));
                    container.appendChild(card);
                });
            } catch (error) {
                console.error('Error loading reviews:', error);
            }
        }

        function openModal(review) {
            modalImage.src = review.user_image_url || 'default-image.jpg';
            modalStars.textContent = '★'.repeat(review.rating);
            modalMessage.textContent = review.message;
            modalDate.textContent = new Date(review.created_at).toLocaleDateString();
            modalName.textContent = review.name;
            modal.style.display = 'flex';
        }

        modalClose.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        function autoSlide() {
            setInterval(() => {
                currentIndex = (currentIndex + 1) % reviews.length;
                container.scrollTo({
                    left: currentIndex * 235, // Adjust for card width + gap
                    behavior: 'smooth',
                });
            }, 2000);
        }

        let isDragging = false;
        let startX, scrollLeft;

        container.addEventListener('mousedown', (e) => {
            isDragging = true;
            startX = e.pageX - container.offsetLeft;
            scrollLeft = container.scrollLeft;
            container.style.cursor = 'grabbing';
        });

        container.addEventListener('mouseleave', () => {
            isDragging = false;
            container.style.cursor = 'grab';
        });

        container.addEventListener('mouseup', () => {
            isDragging = false;
            container.style.cursor = 'grab';
        });

        container.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            const x = e.pageX - container.offsetLeft;
            const walk = (x - startX) * 1.5; // Control swipe speed
            container.scrollLeft = scrollLeft - walk;
        });

        loadReviews().then(() => autoSlide());
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
