<?php
session_start();

// Check if user or admin is logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
  // Redirect to home.php (login/signup page)
  header("Location: home.php");
  exit;
}
?>

<?php
require_once __DIR__ . '/db.php';
include __DIR__ . '/header.php';

$about = $conn->query("SELECT * FROM about ORDER BY id DESC LIMIT 1")->fetch_assoc();

// fallback if photo is missing
$photo = !empty($about['photo']) ? htmlspecialchars($about['photo']) : 'assets/img/profile-placeholder.jpg';
?>
<div class="about-section d-flex align-items-center justify-content-center">
  <div class="container">
    <div class="row align-items-center justify-content-center">

      <!-- Left: Profile Picture -->
      <div class="col-md-4 text-center mb-4">
        <img src="<?= $photo ?>" class="img-fluid rounded-circle shadow-lg profile-pic" alt="Profile">
      </div>

      <!-- Right: About Card -->
      <div class="col-md-6">
        <div class="card about-card text-white">
          <h1 class="display-5 fw-bold mb-3 fade-in">About Me</h1>
          <p class="lead fade-in delay-1">
            <?= nl2br(htmlspecialchars($about['description'])) ?>
          </p>
          <a href="gallery.php" class="btn btn-gradient mt-3 fade-in delay-2">
            🎨 Explore Gallery
          </a>
        </div>
      </div>

    </div>
  </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>