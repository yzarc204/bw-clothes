<div class="paginatoin-area">
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <p>Showing <?= ($products['page'] - 1) * $products['limit'] + 1 ?> - <?= min($products['page'] * $products['limit'] , $products['total_items']) ?> of <?= $products['total_items'] ?> item(s)</p>
        </div>
        <div class="col-lg-6 col-md-6">
            <ul class="pagination-box justify-content-end">
                <?php if ($products['page'] > 1): ?>
                    <li>
                        <a href="<?= $paginationHref . $products['page'] - 1 ?>" class="Previous">
                            <i class="fa fa-chevron-left"></i> Previous
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $products['total_pages']; $i++): ?>
                    <li class="<?= ($i == $page) ? 'active' : '' ?>">
                        <a href="<?= $paginationHref . $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $products['total_pages']): ?>
                    <li>
                        <a href="<?= $paginationHref . $products['page'] + 1 ?>" class="Next">
                            Next <i class="fa fa-chevron-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>