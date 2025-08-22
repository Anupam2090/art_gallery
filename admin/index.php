<?php
require_once __DIR__ . '/../db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $pass = $_POST['password'] ?? '';
  if ($email && $pass) {
    $stmt = $conn->prepare("SELECT id, email, password FROM admin WHERE email=?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($a = $res->fetch_assoc()) {
      if (password_verify($pass, $a['password'])) {
        $_SESSION['admin_id'] = $a['id'];
        $_SESSION['admin_email'] = $a['email'];
        header('Location: dashboard.php'); exit;
      }
    }
    $err = 'Invalid credentials';
  } else {
    $err = 'All fields are required';
  }
}
include __DIR__ . '/header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="mb-3">Admin Login</h3>
        <?php if ($err): ?><div class="alert alert-danger"><?= htmlspecialchars($err) ?></div><?php endif; ?>
        <form method="post" novalidate autocomplete="off">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <button class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>
