<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth.php';
include __DIR__ . '/header.php';

$err=$ok='';

function store_image_admin($file) {
  if (empty($file['name'])) return null;
  $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
  $allowed = ['jpg','jpeg','png','webp'];
  if (!in_array($ext, $allowed)) return null;
  $name = 'assets/img/profile-' . uniqid() . '.' . $ext;
  if (move_uploaded_file($file['tmp_name'], __DIR__ . '/../' . $name)) {
    return $name;
  }
  return null;
}

$about = $conn->query("SELECT * FROM about ORDER BY id DESC LIMIT 1")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $desc = trim($_POST['description'] ?? '');
  $existing = trim($_POST['existing_photo'] ?? '');
  $new = store_image_admin($_FILES['photo'] ?? []);
  $photo = $new ?: $existing;
  if (!$desc || !$photo) {
    $err = 'Description and photo are required.';
  } else {
    if ($about) {
      $stmt = $conn->prepare("UPDATE about SET description=?, photo=? WHERE id=?");
      $stmt->bind_param('ssi', $desc, $photo, $about['id']);
    } else {
      $stmt = $conn->prepare("INSERT INTO about (description, photo) VALUES (?, ?)");
      $stmt->bind_param('ss', $desc, $photo);
    }
    if ($stmt->execute()) $ok = 'About updated';
    else $err = 'Database error';
  }
  $about = $conn->query("SELECT * FROM about ORDER BY id DESC LIMIT 1")->fetch_assoc();
}
?>
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">About Me</h5>
        <?php if ($err): ?><div class="alert alert-danger"><?= htmlspecialchars($err) ?></div><?php endif; ?>
        <?php if ($ok): ?><div class="alert alert-success"><?= htmlspecialchars($ok) ?></div><?php endif; ?>
        <form method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="6" required><?= htmlspecialchars($about['description'] ?? '') ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Photo <?= $about ? '(leave empty to keep unchanged)' : '' ?></label>
            <input type="file" name="photo" class="form-control" <?= $about?'':'required' ?>>
            <?php if (!empty($about['photo'])): ?>
              <div class="mt-2">
                <img src="../<?= htmlspecialchars($about['photo']) ?>" class="img-thumbnail" style="max-height:120px">
                <input type="hidden" name="existing_photo" value="<?= htmlspecialchars($about['photo']) ?>">
              </div>
            <?php endif; ?>
          </div>
          <button class="btn btn-primary">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>
