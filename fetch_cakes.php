<?php
include 'database_connection.php'; // Update this to your actual database connection file

$filter = $_GET['filter'] ?? 'all';

$sql = "SELECT * FROM menu";
if ($filter !== 'all') {
    $sql .= " WHERE category_name = ?";
}

$stmt = $conn->prepare($sql);
if ($filter !== 'all') {
    $stmt->bind_param("s", $filter);
}
$stmt->execute();
$result = $stmt->get_result();

$cakes = [];
while ($row = $result->fetch_assoc()) {
    $cakes[] = $row;
}
$stmt->close();

foreach ($cakes as $cake) : ?>
  <div class="col-xl-3 col-lg-4 col-md-4 col-12">
    <div class="single-product">
      <div class="product-img">
        <a href="product-details.php?id=<?= $cake['menu_id']; ?>">
          <img class="default-img" src="<?= htmlspecialchars($cake['image_path']); ?>" alt="<?= htmlspecialchars($cake['menu_name']); ?>" />
          <img class="hover-img" src="<?= htmlspecialchars($cake['image_path']); ?>" alt="<?= htmlspecialchars($cake['menu_name']); ?>" />
        </a>
        <div class="button-head">
          <div class="product-action">
            <a data-toggle="modal" data-target="#exampleModal"
               title="Quick View"
               href="#"
               data-product-id="<?= $cake['menu_id']; ?>"
               data-product-name="<?= htmlspecialchars($cake['menu_name']); ?>"
               data-product-price="<?= number_format($cake['price'], 2); ?>"
               data-product-image="<?= htmlspecialchars($cake['image_path']); ?>"
               data-product-description="Product description here">
            </a>
            <a title="Wishlist" href="#"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
          </div>
          <div class="product-action-2">
            <a class="add-to-cart-button"
               href="#"
               data-product-id="<?= $cake['menu_id']; ?>"
               data-product-name="<?= htmlspecialchars($cake['menu_name']); ?>"
               data-product-price="<?= number_format($cake['price'], 2); ?>"
               data-product-image="<?= htmlspecialchars($cake['image_path']); ?>">
               Add to cart
            </a>
          </div>
        </div>
      </div>
      <div class="product-content">
        <h3><a href="product-details.php?id=<?= $cake['menu_id']; ?>"><?= htmlspecialchars($cake['menu_name']); ?></a></h3>
        <div class="product-price">
          <span>₱<?= number_format($cake['price'], 2); ?></span>
        </div>
      </div>
    </div>
  </div>
<?php endforeach;

$conn->close();
?>
