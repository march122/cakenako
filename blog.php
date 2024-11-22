<?php
// Include the database connection file
include 'db/config.php';

// Fetch blog posts
$query = "SELECT * FROM blog ORDER BY date DESC LIMIT 3";
$result = $conn->query($query);

// Check if the query was successful
if (!$result) {
    echo "<p>Error fetching blog posts. Please try again later.</p>";
    exit;
}
?>

<!-- Start Shop Blog  -->
<section class="shop-blog section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>From Our Blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Single Blog  -->
                    <div class="shop-single-blog">
                        <img src="<?php echo $row['image_url']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <div class="content">
                            <p class="date"><?php echo date("d F, Y. l", strtotime($row['date'])); ?></p>
                            <a href="/blog/<?php echo $row['url_slug']; ?>" class="title"><?php echo htmlspecialchars($row['title']); ?></a>
                            <a href="/blog/<?php echo $row['url_slug']; ?>" class="more-btn">Continue Reading</a>
                        </div>
                    </div>
                    <!-- End Single Blog  -->
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- End Shop Blog  -->

<?php
// Close the database connection
$conn->close();
?>
