<?php
require_once __DIR__ . '/db.php';
include __DIR__ . '/header.php';
$c = $conn->query("SELECT * FROM contact ORDER BY id DESC LIMIT 1")->fetch_assoc();
?>
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="contact-card shadow-lg p-4 rounded-4">
      <h2 class="mb-4 text-center fw-bold">📬 Contact Me</h2>
      <ul class="list-unstyled fs-5">
        <li class="mb-3">
          <i class="fab fa-facebook me-2 text-primary"></i>
          <a class="contact-link" href="<?= htmlspecialchars($c['facebook']) ?>" target="_blank">Facebook</a>
        </li>
        <li class="mb-3">
          <i class="fab fa-instagram me-2" style="color:#E1306C;"></i>
          <a class="contact-link" href="<?= htmlspecialchars($c['instagram']) ?>" target="_blank">Instagram</a>
        </li>
        <li class="mb-3">
          <i class="fa fa-envelope me-2 text-danger"></i>
          <a class="contact-link"
            href="mailto:<?= htmlspecialchars($c['email']) ?>"><?= htmlspecialchars($c['email']) ?></a>
        </li>
        <li>
          <i class="fa fa-phone me-2 text-success"></i>
          <a class="contact-link"
            href="tel:<?= htmlspecialchars($c['phone']) ?>"><?= htmlspecialchars($c['phone']) ?></a>
        </li>
      </ul>
    </div>
  </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
