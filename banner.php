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


  <!-- Start Midium Banner -->
  <section class="midium-banner">
    <div class="container">
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
  <!-- End Midium Banner -->

