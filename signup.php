<?php
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$err=''; $ok='';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $pass = $_POST['password'] ?? '';
  if ($name && $email && $pass) {
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $name, $email, $hash);
    try {
      $stmt->execute();
      $ok = 'Account created. You can login now.';
    } catch (mysqli_sql_exception $e) {
      $err = 'Email already exists';
    }
  } else {
    $err = 'All fields are required';
  }
}
include __DIR__ . '/header.php';
?>
<head><link rel="stylesheet" href="assets/css/style.css">
</head>
<div class="row justify-content-center">
  <div class="col-md-6">
    <h2 class="mb-3">Create Account</h2>
    <?php if ($err): ?><div class="alert alert-danger"><?= htmlspecialchars($err) ?></div><?php endif; ?>
    <?php if ($ok): ?><div class="alert alert-success"><?= htmlspecialchars($ok) ?></div><?php endif; ?>
    <form method="post" novalidate>
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-success w-100">Sign Up</button>
      <p class="mt-3 small">Already have an account? <a href="login.php">Login</a></p>
    </form>
  </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>
