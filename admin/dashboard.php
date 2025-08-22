<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: home.php");
  exit;
}
?>


<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth.php';
include __DIR__ . '/header.php';

$total_art = $conn->query("SELECT COUNT(*) AS c FROM gallery")->fetch_assoc()['c'] ?? 0;
$total_users = $conn->query("SELECT COUNT(*) AS c FROM users")->fetch_assoc()['c'] ?? 0;
?>
<h3 class="mb-4">Dashboard</h3>
<div class="row g-3">
  <div class="col-md-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Artworks</h5>
        <p class="display-6 mb-0"><?= (int)$total_art ?></p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Users</h5>
        <p class="display-6 mb-0"><?= (int)$total_users ?></p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Quick Links</h5>
        <div class="d-grid gap-2">
          <a class="btn btn-outline-primary" href="manage_gallery.php">Manage Gallery</a>
          <a class="btn btn-outline-primary" href="manage_about.php">Manage About</a>
          <a class="btn btn-outline-primary" href="manage_contact.php">Manage Contact</a>
          <a class="btn btn-outline-primary" href="manage_admin.php">Admin Settings</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>
