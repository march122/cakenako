
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

        /* General Section Styles */
        .section {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            padding: 40px 10%;
            margin-top: 130px;
        }

        .image-container {
            flex: 1;
            text-align: center;
            padding: 20px;
        }

        .image-container img {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
        }

        .text-container {
            flex: 1;
            padding: 40px;
            text-align: left;
        }

        .text-container h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        .text-container p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #C91868;


            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
        }

        .btn:hover {
            background: #C91868;

;

        }

        .reviews-section {
            text-align: center;
            padding: 40px 10%;
            background: #fff;
        }

        .reviews-container {
            display: flex;
            gap: 15px;
            overflow: hidden;
            scroll-snap-type: x mandatory;
            position: relative;
            padding: 20px 0;
            scroll-behavior: smooth;
        }

        .review-card {
            flex: 0 0 calc(220px);
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 15px;
            scroll-snap-align: center;
            cursor: pointer;
        }

        .review-card img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-bottom: 10px;
            object-fit: cover;
        }

        .stars {
            color: #ffcc00;
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .review-message {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 5px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .review-meta {
            color: #888;
            font-size: 0.8rem;
            margin-bottom: 8px;
        }

        .review-name {
            font-weight: bold;
            font-size: 0.9rem;
            color: #333;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            border-radius: 10px;
            padding: 20px;
            width: 90%;
            max-width: 400px;
            text-align: left;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            max-height: 90%;
            overflow-y: auto;
        }

        .modal-content img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            object-fit: cover;
        }

        .modal-close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .section {
                flex-direction: column;
                text-align: center;
            }

            .text-container {
                padding: 20px 0;
            }
        }
    </style>
 <!-- Header -->

    
</head>

<body>

<?php include 'header.php'; ?>


    <!-- Section 1: Image Left, Text Right -->
    <section class="section">
        <div class="image-container">
           <img src="img/menu/cake1.png" alt="Farmers with ube in a truck">
        </div>
        <div class="text-container">
        <h1>Skip the lines, reserve like a Boss</h1>
<p>Pick-up like a boss at your convenient time or simply book an advance delivery to your location.</p>

<a href="Allmenu.php" class="btn">Proceed</a>

        </div>
    </section>

   
    <!-- Reviews Section -->
    <section class="reviews-section">
        <h2>Hear it from our Sweet Fam!</h2>
        <div class="reviews-container" id="reviewsContainer"></div>
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
