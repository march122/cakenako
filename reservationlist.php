<?php

// Database connection (adjust with your credentials)
$host = 'localhost';
$dbname = 'cake_db';
$username = 'root'; // Change if necessary
$password = ''; // Change if necessary

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle search query
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Filter query (if applicable)
$filterStatus = '';
if (isset($_GET['status'])) {
    $filterStatus = $_GET['status'];
}

// Build the SQL query with search and filter options
$query = "SELECT * FROM online_payments WHERE 1";

if ($search) {
    $query .= " AND (id LIKE '%$search%' OR billing_name LIKE '%$search%' OR billing_email LIKE '%$search%')";
}

if ($filterStatus) {
    $query .= " AND status = '$filterStatus'";
}

$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
  <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects" />
  <meta name="robots" conjtent="noindex, nofollow" />
  <title>Reservation List</title>
  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.jpg" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css" />
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css" />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
  <div class="main-wrapper">
    <div class="header">
      <?php include 'includes/header.php' ?>
    </div>
    <?php include 'includes/sidebar.php'; ?>

    <div class="page-wrapper"
      <div class="content">
        <div class="page-header">
          <div class="page-title">
            <h4>Reservation List</h4>
            <h6>Manage your reservation</h6>
          </div>
          <div class="page-btn">
            <a href="pos.php" class="btn btn-added">
              <img src="assets/img/icons/plus.svg" alt="img" class="me-1" />
              Add New reservation
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <div class="card mb-0" id="filter_inputs">
              <div class="card-body pb-0">
                <div class="row">
                  <div class="col-lg col-sm-6 col-12">
                    <!-- Search form -->
                    <form method="get" action="">
                      <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-control" placeholder="Search payments" />
                    </form>
                  </div>
                  <div class="col-lg col-sm-6 col-12">
                    <!-- Filter form -->
                    <form method="get" action="">
                      <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">Filter by Status</option>
                        <option value="paid" <?php if ($filterStatus == 'paid') echo 'selected'; ?>>Paid</option>
                        <option value="pending" <?php if ($filterStatus == 'pending') echo 'selected'; ?>>Pending</option>
                      </select>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <div id="table">
              <div class="table-responsive">
                <table class="table datanew">
                  <thead>
                    <tr>
                      <th>Reference Id</th>
                      <th>Amount</th>
                      <th>Status</th>
                      <th>Created At</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                    
                     
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($result->num_rows > 0) : ?>
                      <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                          <td><?php echo htmlspecialchars($row['id']); ?></td>
                          <td><?php echo htmlspecialchars($row['amount']); ?></td>
                          <td><?php echo htmlspecialchars($row['status']); ?></td>
                          <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                       
                          <td><?php echo htmlspecialchars($row['billing_name']); ?></td>
                          <td><?php echo htmlspecialchars($row['billing_email']); ?></td>
                          <td><?php echo htmlspecialchars($row['billing_phone']); ?></td>
                         
               
                        </tr>
                      <?php endwhile; ?>
                    <?php else : ?>
                      <tr>
                        <td colspan="10">No payments found</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 

  <script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/feather.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/select2/js/select2.min.js"></script>
<script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>
<script src="assets/js/script.js"></script>

</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
