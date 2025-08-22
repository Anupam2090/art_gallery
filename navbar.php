<?php require_once __DIR__ . '/config.php'; ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>">🎨 My Art</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>gallery.php">Gallery</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>contact.php">Contact</a></li>
          <?php if (!empty($_SESSION['user_id'])): ?>
            <li class="nav-item"><a class="nav-link" href="#">Hello, <?= htmlspecialchars($_SESSION['user_name']) ?></a></li>
            <li class="nav-item">
              <a href="<?= BASE_URL ?>logout.php" 
                onclick="return confirm('Are you sure you want to logout?')" 
                class="nav-link text-danger fw-bold">
                Logout
              </a>
            </li>

          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>signup.php">Signup</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>login.php">Login</a></li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="btn btn-outline-dark ms-lg-3" href="<?= BASE_URL ?>admin/">Admin</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
