<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth.php';
include __DIR__ . '/header.php';

$err=$ok='';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $new_email = trim($_POST['email'] ?? '');
  $new_pass = $_POST['password'] ?? '';
  if (!$new_email) {
    $err = 'Email is required';
  } else {
    if ($new_pass) {
      $hash = password_hash($new_pass, PASSWORD_DEFAULT);
      $stmt = $conn->prepare("UPDATE admin SET email=?, password=? WHERE id=?");
      $stmt->bind_param('ssi', $new_email, $hash, $_SESSION['admin_id']);
    } else {
      $stmt = $conn->prepare("UPDATE admin SET email=? WHERE id=?");
      $stmt->bind_param('si', $new_email, $_SESSION['admin_id']);
    }
    if ($stmt->execute()) { $ok='Admin creds updated'; $_SESSION['admin_email'] = $new_email; }
    else $err='Database error';
  }
}
$admin = $conn->query("SELECT * FROM admin WHERE id=".(int)$_SESSION['admin_id'])->fetch_assoc();
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Admin Settings</h5>
        <?php if ($err): ?><div class="alert alert-danger"><?= htmlspecialchars($err) ?></div><?php endif; ?>
        <?php if ($ok): ?><div class="alert alert-success"><?= htmlspecialchars($ok) ?></div><?php endif; ?>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($admin['email'] ?? '') ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">New Password (leave blank to keep same)</label>
            <input type="password" name="password" class="form-control">
          </div>
          <button class="btn btn-primary">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>
