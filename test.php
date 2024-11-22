<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar</title>
<style>
  /* General Reset */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
}

.navbar {
  background-color: #fff;
  padding: 10px 20px;
  border-bottom: 1px solid #ddd;
}

.navbar-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
}

.logo img {
  height: 50px;
}

.nav-links ul {
  list-style: none;
  display: flex;
  gap: 20px;
}

.nav-links ul li a {
  text-decoration: none;
  color: #000;
  font-size: 14px;
  font-weight: bold;
}

.nav-icons {
  display: flex;
  align-items: center;
  gap: 15px;
}

.nav-icons .icon {
  font-size: 18px;
  color: #000;
  text-decoration: none;
}

.nav-icons .cart-count {
  font-size: 14px;
  font-weight: bold;
}

</style>
</head>
<body>
  <header class="navbar">
    <div class="navbar-container">
      <!-- Logo -->
      <div class="logo">
        <img src="logo.png" alt="Logo" />
      </div>

      <!-- Navigation Links -->
      <nav class="nav-links">
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">Cake Menu</a></li>
          <li><a href="#">Franchise</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Store Locator</a></li>
          <li><a href="#">Contact Us</a></li>
        </ul>
      </nav>

      <!-- Icons -->
      <div class="nav-icons">
        <a href="#" class="icon search-icon">🔍</a>
        <a href="#" class="icon user-icon">👤</a>
        <a href="#" class="icon cart-icon">🛒 <span class="cart-count">(2)</span></a>
      </div>
    </div>
  </header>
</body>
</html>
