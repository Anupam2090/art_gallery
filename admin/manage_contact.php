<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth.php';
include __DIR__ . '/header.php';

$err=$ok='';
$c = $conn->query("SELECT * FROM contact ORDER BY id DESC LIMIT 1")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $facebook = trim($_POST['facebook'] ?? '');
  $instagram = trim($_POST['instagram'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone'] ?? '');

  if ($c) {
    $stmt = $conn->prepare("UPDATE contact SET facebook=?, instagram=?, email=?, phone=? WHERE id=?");
    $stmt->bind_param('ssssi', $facebook, $instagram, $email, $phone, $c['id']);
  } else {
    $stmt = $conn->prepare("INSERT INTO contact (facebook, instagram, email, phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $facebook, $instagram, $email, $phone);
  }
  if ($stmt->execute()) { $ok='Contact updated'; $c = $conn->query("SELECT * FROM contact ORDER BY id DESC LIMIT 1")->fetch_assoc(); }
  else $err='Database error';
}
?>
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Contact Info</h5>
        <?php if ($err): ?><div class="alert alert-danger"><?= htmlspecialchars($err) ?></div><?php endif; ?>
        <?php if ($ok): ?><div class="alert alert-success"><?= htmlspecialchars($ok) ?></div><?php endif; ?>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Facebook URL</label>
            <input type="url" name="facebook" class="form-control" value="<?= htmlspecialchars($c['facebook'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Instagram URL</label>
            <input type="url" name="instagram" class="form-control" value="<?= htmlspecialchars($c['instagram'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($c['email'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($c['phone'] ?? '') ?>">
          </div>
          <button class="btn btn-primary">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>
