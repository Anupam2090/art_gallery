<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth.php';
include __DIR__ . '/header.php';

$categories = ['Digital Painting','Pencil Art','Watercolor','Oil Painting','Pen Sketches', 'Acrylic Painting'];
$err = $ok = '';

// Handle Create/Update/Delete
$action = $_GET['action'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

function store_image($file) {
  if (empty($file['name'])) return null;
  $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
  $allowed = ['jpg','jpeg','png','webp'];
  if (!in_array($ext, $allowed)) return null;
  $name = 'uploads/' . uniqid('art_', true) . '.' . $ext;
  if (move_uploaded_file($file['tmp_name'], __DIR__ . '/../' . $name)) {
    return $name;
  }
  return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title'] ?? '');
  $caption = trim($_POST['caption'] ?? '');
  $price = (float)($_POST['price'] ?? 0);
  $category = trim($_POST['category'] ?? '');
  $existing_image = trim($_POST['existing_image'] ?? '');
  $new_image = store_image($_FILES['image'] ?? []);
  $img_to_save = $new_image ?: $existing_image;

  if (!$title || !$caption || !$category || !in_array($category, $categories) || !$img_to_save) {
    $err = 'All fields including a valid image are required.';
  } else {
    if ($id) { // update
      $stmt = $conn->prepare("UPDATE gallery SET title=?, caption=?, price=?, category=?, image=? WHERE id=?");
      $stmt->bind_param('ssdssi'.'' , $title, $caption, $price, $category, $img_to_save, $id);
    } else { // insert
      $stmt = $conn->prepare("INSERT INTO gallery (title, caption, price, category, image) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param('ssdss', $title, $caption, $price, $category, $img_to_save);
    }
    // Fix bind_param format for update (manual because of the space in the previous string)
    if ($id) { $stmt->bind_param('ssdssi', $title, $caption, $price, $category, $img_to_save, $id); }
    if ($stmt->execute()) {
      $ok = $id ? 'Artwork updated' : 'Artwork added';
      if (!$id) { $id = $conn->insert_id; }
    } else {
      $err = 'Database error';
    }
  }
}

if ($action === 'delete' && $id) {
  $stmt = $conn->prepare("DELETE FROM gallery WHERE id=?");
  $stmt->bind_param('i', $id);
  $stmt->execute();
  header('Location: manage_gallery.php?deleted=1'); exit;
}

$editing = null;
if ($action === 'edit' && $id) {
  $stmt = $conn->prepare("SELECT * FROM gallery WHERE id=?");
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $editing = $stmt->get_result()->fetch_assoc();
}
?>
<div class="row">
  <div class="col-lg-5">
    <div class="card shadow-sm mb-3">
      <div class="card-body">
        <h5 class="card-title"><?= $editing ? 'Edit Artwork' : 'Add Artwork' ?></h5>
        <?php if (!empty($_GET['deleted'])): ?><div class="alert alert-warning">Artwork deleted</div><?php endif; ?>
        <?php if ($err): ?><div class="alert alert-danger"><?= htmlspecialchars($err) ?></div><?php endif; ?>
        <?php if ($ok): ?><div class="alert alert-success"><?= htmlspecialchars($ok) ?></div><?php endif; ?>
        <form method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($editing['title'] ?? '') ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Caption</label>
            <textarea name="caption" class="form-control" rows="3" required><?= htmlspecialchars($editing['caption'] ?? '') ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Price (₹)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?= htmlspecialchars($editing['price'] ?? '0.00') ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-select" required>
              <option value="">Choose...</option>
              <?php foreach ($categories as $c): ?>
                <option value="<?= htmlspecialchars($c) ?>" <?= (!empty($editing['category']) && $editing['category']===$c)?'selected':'' ?>><?= htmlspecialchars($c) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Image <?= $editing ? '(leave empty to keep unchanged)' : '' ?></label>
            <input type="file" name="image" class="form-control" <?= $editing?'':'required' ?>>
            <?php if ($editing): ?>
              <div class="mt-2">
                <img src="../<?= htmlspecialchars($editing['image']) ?>" alt="" class="img-thumbnail" style="max-height:120px">
                <input type="hidden" name="existing_image" value="<?= htmlspecialchars($editing['image']) ?>">
              </div>
            <?php endif; ?>
          </div>
          <button class="btn btn-primary"><?= $editing ? 'Update' : 'Add' ?></button>
          <?php if ($editing): ?>
            <a href="manage_gallery.php" class="btn btn-secondary">Cancel</a>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">All Artworks</h5>
        <div class="table-responsive">
          <table class="table table-striped align-middle">
            <thead><tr>
              <th>Image</th><th>Title</th><th>Category</th><th>Price</th><th>Actions</th>
            </tr></thead>
            <tbody>
            <?php
            $res = $conn->query("SELECT * FROM gallery ORDER BY created_at DESC");
            while ($g = $res->fetch_assoc()): ?>
              <tr>
                <td><img src="../<?= htmlspecialchars($g['image']) ?>" style="height:60px" class="rounded"></td>
                <td><?= htmlspecialchars($g['title']) ?></td>
                <td><span class="badge text-bg-secondary"><?= htmlspecialchars($g['category']) ?></span></td>
                <td>₹ <?= number_format((float)$g['price'],2) ?></td>
                <td>
                  <a class="btn btn-sm btn-outline-primary" href="manage_gallery.php?action=edit&id=<?= $g['id'] ?>"><i class="fa fa-edit"></i></a>
                  <a class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this artwork?')" href="manage_gallery.php?action=delete&id=<?= $g['id'] ?>"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
            <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>
