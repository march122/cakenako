<?php
// Database connection (replace with your actual connection details)
$host = 'localhost'; // Database host
$username = 'root'; // Database username
$password = ''; // Database password
$dbname = 'cake_db'; // Database name

$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch the slider data
$sql = "SELECT * FROM contents ORDER BY slider_order ASC";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Start building the HTML for the slider
    echo '<section class="hero-area2">
            <div class="home-slider">';
    
    // Fetch each row and display the content
    while($row = $result->fetch_assoc()) {
        $image_url = $row['image_url'];
        $sub_title = $row['sub_title'];
        $title = $row['title'];
        $description = $row['description'];
        $button_text = $row['button_text'];
        $button_link = $row['button_link'];
        
        echo "
        <div class='single-slider overlay' style='background-image:url($image_url);'>
            <div class='container'>
                <div class='row'>
                    <div class='col-12'>
                        <div class='content'>
                            <p class='sub-title'>$sub_title</p>
                            <h4 class='title'>$title</h4>
                            <p class='des'>$description</p>
                            <div class='button'>
                                <a href='$button_link' class='btn'>$button_text</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
    }
    
    // Close the slider container
    echo '</div>
        </section>';
} else {
    echo "No content available.";
}

$conn->close();
?>
