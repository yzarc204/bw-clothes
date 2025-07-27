<?php if (isset($_SESSION['error'])): ?>
  <div class="col-12">
    <div class="alert alert-danger" role="alert"><?= $_SESSION['error'] ?></div>
  </div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
  <div class="col-12">
    <div class="alert alert-success" role="alert"><?= $_SESSION['success'] ?></div>
  </div>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>