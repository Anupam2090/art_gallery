<?php
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE)
  session_start();

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $pass = $_POST['password'] ?? '';

  if ($email && $pass) {
    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email=?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($u = $res->fetch_assoc()) {
      if (password_verify($pass, $u['password'])) {
        // Save session
        $_SESSION['user_id'] = $u['id'];
        $_SESSION['user_name'] = $u['name'];
        $session_id = session_id();

        // Insert into active_sessions table
        $stmt2 = $conn->prepare("INSERT INTO active_sessions (user_id, session_id, login_time) VALUES (?, ?, NOW())");
        $stmt2->bind_param("is", $u['id'], $session_id);
        $stmt2->execute();

        header('Location: index.php');
        exit;
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
    <h2 class="mb-3">User Login</h2>
    <?php if ($err): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div><?php endif; ?>
    <form method="post" novalidate>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-primary w-100">Login</button>
      <p class="mt-3 small">Don't have an account? <a href="signup.php">Sign up</a></p>
    </form>
  </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>