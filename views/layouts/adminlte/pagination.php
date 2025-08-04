<ul class="pagination m-0">
  <?php if (!$onFirstPage): ?>
    <li class="page-item"><a class="page-link" href="<?= $prevPageUrl ?>">«</a></li>
  <?php else: ?>
    <li class="page-item"><span class="page-link disabled">«</span></li>
  <?php endif; ?>

  <?php foreach ($urls as $url): ?>
    <?php if ($url['page'] == $pagination['page']): ?>
      <li class="page-item"><span class="page-link disabled"><?= $url['page'] ?></span></li>
    <?php else: ?>
      <li class="page-item"><a class="page-link" href="<?= $url['url'] ?>"><?= $url['page'] ?></a></li>
    <?php endif; ?>
  <?php endforeach; ?>

  <?php if (!$onLastPage): ?>
    <li class="page-item"><a class="page-link" href="<?= $nextPageUrl ?>">»</a></li>
  <?php else: ?>
    <li class="page-item"><span class="page-link disabled">»</span></li>
  <?php endif; ?>

</ul>