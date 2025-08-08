<div class="paginatoin-area">
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <p>Hiển thị <?= $pagination['total_items'] ?> mục trong <?= $pagination['total_pages'] ?> trang</p>
        </div>
        <div class="col-lg-6 col-md-6">
            <ul class="pagination-box">
                <?php if ($onFirstPage): ?>
                    <li><a class="Previous"><i class="fa fa-chevron-left"></i></a></li>
                <?php else: ?>
                    <li><a href="<?= $prevPageUrl ?>" class="Previous"><i class="fa fa-chevron-left"></i></a></li>
                <?php endif; ?>

                <?php foreach ($urls as $url): ?>
                    <?php if ($url['page'] == $pagination['page']): ?>
                        <li class="active"><a><?= $url['page'] ?></a></li>
                    <?php else: ?>
                        <li><a href="<?= $url['url'] ?>"><?= $url['page'] ?></a></li>
                    <?php endif; ?>

                <?php endforeach; ?>

                <?php if ($onLastPage): ?>
                    <li><a class="Next"><i class="fa fa-chevron-right"></i></a></li>
                <?php else: ?>
                    <li><a href="<?= $nextPageUrl ?>" class="Next"><i class="fa fa-chevron-right"></i></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>