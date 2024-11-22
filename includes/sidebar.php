<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page's filename

// Function to determine if a page is active
function isActive($page)
{
  global $current_page;
  return $current_page == $page ? 'active' : '';
}
?>

<div class="sidebar" id="sidebar">
  <div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
      <ul>
        <li class="<?php echo isActive('index.html'); ?>">
          <a href="index.html">
            <img src="assets/img/icons/dashboard.svg" alt="img" /><span>Dashboard</span>
          </a>
        </li>
        <li class="submenu">
          <a href="javascript:void(0);">
            <img src="assets/img/icons/product.svg" alt="img" /><span>Menu</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li><a href="menulist.php" class="<?php echo isActive('menulist.php'); ?>">Menu List</a></li>
            <li><a href="addmenu.php" class="<?php echo isActive('addmenu.php'); ?>">Add Menu</a></li>
            <li><a href="categorylist.php" class="<?php echo isActive('categorylist.php'); ?>">Category List</a></li>
            <li><a href="addcategory.php" class="<?php echo isActive('addcategory.php'); ?>">Add Category</a></li>

          </ul>
        </li>
        <li class="submenu">
          <a href="javascript:void(0);">
            <img src="assets/img/icons/purchase1.svg" alt="img" /><span>Orders</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li><a href="orderlist.php" class="<?php echo isActive('orderlist.php'); ?>">Order List</a></li>
          </ul>
        </li>
        <li class="submenu">
          <a href="javascript:void(0);">
            <img src="assets/img/icons/quotation1.svg" alt="img" /><span>Discount</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li><a href="discountlist.php" class="<?php echo isActive('discountlist.php'); ?>">Discount List</a></li>
            <li><a href="adddiscount.php" class="<?php echo isActive('addiscount.php'); ?>">Add Discount</a></li>
          </ul>
        </li>

        <li class="submenu">
          <a href="javascript:void(0);">
            <img src="assets/img/icons/quotation1.svg" alt="img" /><span>Reservation</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li><a href="http://localhost/cakeph/pos.php" class="<?php echo isActive('pos.php'); ?>">Add Reservation</a></li>
            <li><a href="reservationlist.php" class="<?php echo isActive('reservationlist.php'); ?>">Reservation List</a></li>
          </ul>
        </li>
   
   
        <li class="submenu">
          <a href="javascript:void(0);">
            <img src="assets/img/icons/users1.svg" alt="img" /><span>Users</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li><a href="adduser.php" class="<?php echo isActive('adduser.php'); ?>">New User</a></li>
            <li><a href="userlist.php" class="<?php echo isActive('userlists.php'); ?>">Users List</a></li>
          </ul>
        </li>
        <li class="submenu">
          <a href="javascript:void(0);">
            <img src="assets/img/icons/settings.svg" alt="img" /><span>Settings</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li><a href="generalsettings.php" class="<?php echo isActive('generalsettings.php'); ?>">General Settings</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>