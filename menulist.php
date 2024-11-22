<?php
// Include the database configuration file
include 'db/config.php';

// Query to fetch all unique categories
$categoryQuery = "SELECT DISTINCT category_name FROM menu";
$categoryResult = mysqli_query($conn, $categoryQuery);
if (!$categoryResult) {
    die('Query Error: ' . mysqli_error($conn));
}

$query = "
    SELECT 
        menu_id, 
        menu_name, 
        price, 
        created_by, 
        image_path, 
        description, 
        status, 
        category_name,
        created_at
    FROM 
        menu
    ORDER BY created_at DESC
";

$rows = mysqli_query($conn, $query);
if (!$rows) {
    die('Query Error: ' . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <title>Menu List</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.jpg" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css" />
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css" />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <style>
        @media print {
    body {
        visibility: hidden;
    }
    .table-responsive, .table-responsive * {
        visibility: visible;
    }
    .table-responsive {
        position: absolute;
        top: 0;
        left: 0;
    }
}

@media print {
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
}

    </style>
</head>

<body>
<div class="main-wrapper">
    <div class="header">
        <?php include 'includes/header.php'; ?>
    </div>
    <?php include 'includes/sidebar.php'; ?>

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Cake List</h4>
                    <h6>Manage your Cake Menu</h6>
                </div>
                <div class="page-btn">
                    <a href="addmenu.php" class="btn btn-added">
                        <img src="assets/img/icons/plus.svg" alt="img" class="me-1" />
                        Add New Cake Menu
                    </a>
                </div>
            </div>

  


            <div class="card">
                <div class="card-body">
                <?php include 'innerheader.php'; ?>

            
       <!-- Filter Section -->
       <div class="card" id="filter_inputs">
    <div class="card-body pb-0">
        <div class="row">
            <div class="col-lg-2 col-sm-6 col-12">
                <input type="text" id="filter-name" class="form-control" placeholder="Enter Menu Name" />
            </div>
            <div class="col-lg-2 col-sm-6 col-12">
                <select id="filter-category" class="form-control">
                    <option value="">Select Category</option>
                    <?php
                    // Loop through the categories and create options
                    while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                        echo "<option value='" . htmlspecialchars($categoryRow['category_name']) . "'>" . htmlspecialchars($categoryRow['category_name']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-lg-2 col-sm-6 col-12">
                <input type="number" id="filter-price" class="form-control" placeholder="Enter Price" />
            </div>
            <div class="col-lg-2 col-sm-6 col-12">
                <select id="filter-status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="Not Available">Not Available</option>
                    <option value="Available">Available</option>
                </select>
            </div>
        </div>
    </div>
</div>
<!-- End Filter Section -->
                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all" />
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Menu Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($rows)) : ?>
                                    <tr class="menu-row">
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox" />
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td class="menu-name"><?php echo htmlspecialchars($row['menu_name']); ?></td>
                                        <td class="menu-category"><?php echo htmlspecialchars($row['category_name']); ?></td>
                                        <td class="menu-price"><?php echo htmlspecialchars($row['price']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($row['description'], 0, 30)) . '...'; ?></td>
                                        <td class="menu-status"><?php echo htmlspecialchars($row['status']); ?></td>
                                        <td>
                                            <a href="menu-details.php?id=<?php echo $row['menu_id']; ?>" class="me-3">
                                                <img src="assets/img/icons/eye.svg" alt="View" />
                                            </a>
                                            <a href="editmenu.php?id=<?php echo $row['menu_id']; ?>" class="me-3">
                                                <img src="assets/img/icons/edit.svg" alt="Edit" />
                                            </a>
                                            <a href="javascript:void(0);" class="me-3 confirm-delete" data-id="<?php echo $row['menu_id']; ?>">
                                                <img src="assets/img/icons/delete.svg" alt="Delete" />
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>

<script>
// JavaScript for Real-Time Filtering
$(document).ready(function() {
    // Filter function
    function filterTable() {
        var filterName = $('#filter-name').val().toLowerCase();
        var filterCategory = $('#filter-category').val().toLowerCase();
        var filterPrice = $('#filter-price').val();
        var filterStatus = $('#filter-status').val().toLowerCase();

        $('.menu-row').filter(function() {
            var nameMatch = $(this).find('.menu-name').text().toLowerCase().includes(filterName);
            var categoryMatch = filterCategory === "" || $(this).find('.menu-category').text().toLowerCase().includes(filterCategory);
            var priceMatch = filterPrice === "" || $(this).find('.menu-price').text() == filterPrice;
            var statusMatch = filterStatus === "" || $(this).find('.menu-status').text().toLowerCase() === filterStatus;

            $(this).toggle(nameMatch && categoryMatch && priceMatch && statusMatch);
        });
    }

    // Listen to filter input events
    $('#filter-name, #filter-category, #filter-price, #filter-status').on('keyup change', function() {
        filterTable();
    });

    // Delete confirmation
    $('.confirm-delete').click(function() {
        var menuId = $(this).data('id'); // Get the menu ID
        var row = $(this).closest('tr'); // Get the row to remove

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this menu?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'deletemenu.php',  // Call the delete script
                    type: 'POST',
                    data: { id: menuId },
                    success: function(response) {
                        if (response === 'success') {
                            // Remove the row from the table without refreshing
                            row.remove();
                            Swal.fire(
                                'Deleted!',
                                'The menu item has been deleted.',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Error!',
                                'Failed to delete the menu item.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'An error occurred while processing the request.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});


// Include jsPDF library

$(document).ready(function() {
    // Excel Export
    $('#export-excel').click(function() {
        Swal.fire({
            title: 'Do you want to download this menu as an Excel file?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, download!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                let wb = XLSX.utils.book_new();
                let menuData = [];
                $('.menu-row').each(function() {
                    const row = $(this);
                    menuData.push([
                        row.find('.menu-name').text(),
                        row.find('.menu-category').text(),
                        row.find('.menu-price').text(),
                        row.find('.menu-status').text()
                    ]);
                });

                let ws = XLSX.utils.aoa_to_sheet([['Menu Name', 'Category', 'Price', 'Status'], ...menuData]);
                XLSX.utils.book_append_sheet(wb, ws, 'Menu');
                XLSX.writeFile(wb, 'menu-list.xlsx');
            }
        });
    });

    $('#export-pdf').click(function() {
    Swal.fire({
        title: 'Do you want to download this menu as a PDF?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, download!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            let menuData = [];
            
            // Collect the data from the table
            $('.menu-row').each(function() {
                const row = $(this);
                menuData.push([
                    row.find('.menu-name').text(),  // Menu Name
                    row.find('.menu-category').text(),  // Category
                    row.find('.menu-price').text(),  // Price
                    row.find('.menu-status').text()  // Status
                ]);
            });

            // Use autoTable to generate the table in the PDF
            doc.autoTable({
                head: [['Menu Name', 'Category', 'Price', 'Status']],  // Column headers
                body: menuData  // Rows with the data
            });

            // Save the generated PDF
            doc.save('menu-list.pdf');
        }
    });
});

});


// Print the Menu
$('#print-menu').click(function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    let menuData = [];
    $('.menu-row').each(function() {
        const row = $(this);
        menuData.push([
            row.find('.menu-name').text(),
            row.find('.menu-category').text(),
            row.find('.menu-price').text(),
            row.find('.menu-status').text()
        ]);
    });

    doc.autoTable({
        head: [['Menu Name', 'Category', 'Price', 'Status']],
        body: menuData
    });

    window.print();
});
</script>

</body>
</html>
