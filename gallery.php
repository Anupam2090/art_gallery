<?php
require_once __DIR__ . '/db.php';
include __DIR__ . '/header.php';

$categories = ['Digital Painting', 'Pencil Art', 'Watercolor', 'Oil Painting', 'Pen Sketches', 'Acrylic Painting'];

$search = trim($_GET['q'] ?? '');
$filter = trim($_GET['category'] ?? '');

$sql = "SELECT * FROM gallery WHERE 1";
$params = [];
$types = '';

if ($search) {
  $sql .= " AND (title LIKE ? OR caption LIKE ?)";
  $like = '%' . $search . '%';
  $params[] = $like;
  $params[] = $like;
  $types .= 'ss';
}
if ($filter && in_array($filter, $categories)) {
  $sql .= " AND category = ?";
  $params[] = $filter;
  $types .= 's';
}
$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
if ($params) {
  $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$res = $stmt->get_result();
?>

<style>
  /* Gallery Card Styling */
  .gallery-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
  }

  .gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }

  .gallery-card img {
    object-fit: cover;
    height: 220px;
    width: 100%;
    transition: transform 0.4s ease;
  }

  .gallery-card:hover img {
    transform: scale(1.05);
  }

  .gallery-caption {
    max-height: 60px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3; /* max 3 lines */
    -webkit-box-orient: vertical;
    white-space: normal;
}
  .filter-buttons .btn {
    border-radius: 20px;
    padding: 5px 15px;
  }
</style>

<div class="container my-4">

  <!-- 🔍 Search + Filters -->
  <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
    <form class="d-flex flex-grow-1" method="get">
      <input class="form-control me-2" type="search" name="q" placeholder="Search artwork..."
        value="<?= htmlspecialchars($search) ?>">
      <?php if ($filter): ?><input type="hidden" name="category"
          value="<?= htmlspecialchars($filter) ?>"><?php endif; ?>
      <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-search"></i></button>
    </form>
    <div class="filter-buttons ms-auto">
      <a href="gallery.php" class="btn btn-sm <?= !$filter ? 'btn-dark' : 'btn-outline-dark' ?>">All</a>
      <?php foreach ($categories as $c): ?>
        <a href="gallery.php?category=<?= urlencode($c) ?>"
          class="btn btn-sm <?= $filter === $c ? 'btn-primary' : 'btn-outline-primary' ?>">
          <?= htmlspecialchars($c) ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- 🎨 Gallery Grid -->
  <div class="row g-4">
    <?php while ($row = $res->fetch_assoc()): ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card gallery-card h-100 shadow-sm">
          <a href="<?= htmlspecialchars($row['image']) ?>" class="glightbox" data-gallery="art">
            <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
          </a>
          <div class="card-body">
            <h5 class="card-title mb-1"><?= htmlspecialchars($row['title']) ?></h5>
            <p class="card-text small text-muted gallery-caption"><?= nl2br(htmlspecialchars($row['caption'])) ?></p>
          </div>
          <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <span class="fw-semibold">₹ <?= number_format((float) $row['price'], 2) ?></span>
            <span class="badge bg-secondary"><?= htmlspecialchars($row['category']) ?></span>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>