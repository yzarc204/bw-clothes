<?php
require './views/layouts/boyka/html_start.php';
require './views/layouts/boyka/header.php';
?>

<?php
$breadcrumbTitle = 'Thông tin sản phẩm';
include './views/layouts/boyka/breadcrumb.php';
?>

<div class="content-wraper">
    <div class="container">
        <div class="row single-product-area">
            <div class="col-lg-5 col-md-6">
                <!-- Product Details Left -->
                <div class="product-details-left">
                    <div class="product-details-images slider-lg-image-1">
                        <div class="lg-image">
                            <a href="#" class="img-poppu">
                                <img src="<?= BASE_URL . '/' . $product['featured_image'] ?>" alt="product image">
                            </a>
                        </div>
                        <?php foreach ($images as $image): ?>
                            <div class="lg-image">
                                <a href="#" class="img-poppu">
                                    <img src="<?= BASE_URL . '/' . $image['image_url'] ?>" alt="product image">
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="product-details-thumbs slider-thumbs-1">
                        <div class="sm-image">
                            <img src="<?= BASE_URL . '/' . $product['featured_image'] ?>" alt="product image thumb">
                        </div>
                        <?php foreach ($images as $image): ?>
                            <div class="sm-image">
                                <img src="<?= BASE_URL . '/' . $image['image_url'] ?>" alt="product image thumb">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!--// Product Details Left -->
            </div>

            <div class="col-lg-7 col-md-6">
                <div class="product-details-view-content">
                    <div class="product-info">
                        <h2><?= $product['name'] ?></h2>
                        <div class="price-box">
                            <span class="old-price" id="price"></span>
                            <span class="new-price" id="sale_price"></span>
                            <span class="discount discount-percentage">Tiết kiệm <span id="discount">0</span>%</span>
                        </div>
                        <p><?= nl2br($product['description']) ?></p>
                        <form action="/cart/add" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <div class="d-flex gap-2 flex-wrap">
                                <?php foreach ($variants as $variant): ?>
                                    <input type="radio" class="btn-check" name="variant_id"
                                        id="variant_<?= $variant['id'] ?>" data-price="<?= $variant['price'] ?>"
                                        data-sale-price="<?= $variant['sale_price'] ?>" autocomplete="off">
                                    <label class="btn btn-outline-dark" for="variant_<?= $variant['id'] ?>">
                                        <?= $variant['color'] ?> -
                                        <?= $variant['size'] ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                            <div class="single-add-to-cart">
                                <div class="cart-quantity">
                                    <div class="quantity">
                                        <label>Số lượng</label>
                                        <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box" name="quantity" value="1" type="text">
                                            <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                            <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                        </div>
                                    </div>
                                    <!-- <button class="add-to-cart" type="submit" >Add to cart</button> -->
                                    <a class="add-to-cart" href="/cart/add/<?= $product['id'] ?>">Thêm vào giỏ</a>
                                </div>
                            </div>
                        </form>
                        <div class="product-availability">
                            <i class="fa fa-check"></i> Còn hàng
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="product-details-tab mt--60">
                    <ul role="tablist" class="mb--50 nav">
                        <li class="active" role="presentation">
                            <a data-bs-toggle="tab" role="tab" href="#description" class="active">Description</a>
                        </li>
                        <li role="presentation">
                            <a data-bs-toggle="tab" role="tab" href="#sheet">Product Details</a>
                        </li>
                        <li role="presentation">
                            <a data-bs-toggle="tab" role="tab" href="#reviews">Reviews</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div class="product_details_tab_content tab-content">
                    <!-- Start Single Content -->
                    <div class="product_tab_content tab-pane active" id="description" role="tabpanel">
                        <div class="product_description_wrap">
                            <div class="product_desc mb--30">
                                <h2 class="title_3">Details</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit
                                    ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                    reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                    mollit anim id.</p>
                            </div>
                            <div class="pro_feature">
                                <h2 class="title_3">Features</h2>
                                <ul class="feature_list">
                                    <li><a href="#"><i class="fa fa-play"></i>Duis aute irure dolor in reprehenderit in
                                            voluptate velit esse</a></li>
                                    <li><a href="#"><i class="fa fa-play"></i>Irure dolor in reprehenderit in voluptate
                                            velit esse</a></li>
                                    <li><a href="#"><i class="fa fa-play"></i>Sed do eiusmod tempor incididunt ut labore
                                            et </a></li>
                                    <li><a href="#"><i class="fa fa-play"></i>Nisi ut aliquip ex ea commodo
                                            consequat.</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Content -->
                    <!-- Start Single Content -->
                    <div class="product_tab_content tab-pane" id="sheet" role="tabpanel">
                        <div class="pro_feature">
                            <h2 class="title_3">Data sheet</h2>
                            <ul class="feature_list">
                                <li><a href="#"><i class="fa fa-play"></i>Duis aute irure dolor in reprehenderit in
                                        voluptate velit esse</a></li>
                                <li><a href="#"><i class="fa fa-play"></i>Irure dolor in reprehenderit in voluptate
                                        velit esse</a></li>
                                <li><a href="#"><i class="fa fa-play"></i>Irure dolor in reprehenderit in voluptate
                                        velit esse</a></li>
                                <li><a href="#"><i class="fa fa-play"></i>Sed do eiusmod tempor incididunt ut labore et
                                    </a></li>
                                <li><a href="#"><i class="fa fa-play"></i>Sed do eiusmod tempor incididunt ut labore et
                                    </a></li>
                                <li><a href="#"><i class="fa fa-play"></i>Nisi ut aliquip ex ea commodo consequat.</a>
                                </li>
                                <li><a href="#"><i class="fa fa-play"></i>Nisi ut aliquip ex ea commodo consequat.</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Single Content -->
                    <!-- Start Single Content -->
                    <div class="product_tab_content tab-pane" id="reviews" role="tabpanel">
                        <div class="review_address_inner">
                            <!-- Start Single Review -->
                            <div class="pro_review">
                                <div class="review_thumb">
                                    <img alt="review images" src="assets/images/review/1.jpg">
                                </div>
                                <div class="review_details">
                                    <div class="review_info">
                                        <h4><a href="#">Gerald Barnes</a></h4>
                                        <ul class="product-rating d-flex">
                                            <li><span class="fa fa-star"></span></li>
                                            <li><span class="fa fa-star"></span></li>
                                            <li><span class="fa fa-star"></span></li>
                                            <li><span class="fa fa-star"></span></li>
                                            <li><span class="fa fa-star"></span></li>
                                        </ul>
                                        <div class="rating_send">
                                            <a href="#"><i class="fa fa-reply"></i></a>
                                        </div>
                                    </div>
                                    <div class="review_date">
                                        <span>27 Jun, 2023 at 3:30pm</span>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas
                                        elese ifend. Phasellus a felis at estei to bibendum feugiat ut eget eni Praesent
                                        et messages in con sectetur posuere dolor non.</p>
                                </div>
                            </div>
                            <!-- End Single Review -->
                            <!-- Start Single Review -->
                            <div class="pro_review ans">
                                <div class="review_thumb">
                                    <img alt="review images" src="assets/images/review/2.jpg">
                                </div>
                                <div class="review_details">
                                    <div class="review_info">
                                        <h4><a href="#">Gerald Barnes</a></h4>
                                        <ul class="product-rating d-flex">
                                            <li><span class="fa fa-star"></span></li>
                                            <li><span class="fa fa-star"></span></li>
                                            <li><span class="fa fa-star"></span></li>
                                            <li><span class="fa fa-star"></span></li>
                                            <li><span class="fa fa-star"></span></li>
                                        </ul>
                                        <div class="rating_send">
                                            <a href="#"><i class="fa fa-reply"></i></a>
                                        </div>
                                    </div>
                                    <div class="review_date">
                                        <span>27 Jun, 2023 at 4:32pm</span>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas
                                        elese ifend. Phasellus a felis at estei to bibendum feugiat ut eget eni Praesent
                                        et messages in con sectetur posuere dolor non.</p>
                                </div>
                            </div>
                            <!-- End Single Review -->
                        </div>
                        <!-- Start RAting Area -->
                        <div class="rating_wrap">
                            <h2 class="rating-title">Write A review</h2>
                            <h4 class="rating-title-2">Your Rating</h4>
                            <div class="rating_list">
                                <ul class="product-rating d-flex">
                                    <li><span class="fa fa-star"></span></li>
                                    <li><span class="fa fa-star"></span></li>
                                    <li><span class="fa fa-star"></span></li>
                                    <li><span class="fa fa-star"></span></li>
                                    <li><span class="fa fa-star"></span></li>
                                </ul>
                            </div>
                        </div>
                        <!-- End RAting Area -->
                        <div class="comments-area comments-reply-area">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="#" class="comment-form-area">
                                        <div class="comment-input">
                                            <p class="comment-form-author">
                                                <label>Name <span class="required">*</span></label>
                                                <input type="text" required="required" name="Name">
                                            </p>
                                            <p class="comment-form-email">
                                                <label>Email <span class="required">*</span></label>
                                                <input type="text" required="required" name="email">
                                            </p>
                                        </div>
                                        <p class="comment-form-comment">
                                            <label>Comment</label>
                                            <textarea class="comment-notes" required="required"></textarea>
                                        </p>
                                        <div class="comment-form-submit">
                                            <input type="submit" value="Post Comment" class="comment-submit">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Content -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './views/layouts/boyka/footer.php'; ?>

<script>
    function formatCurrency(value) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(value);
    }

    document.querySelectorAll('input[name="variant_id"]').forEach(input => {
        input.addEventListener('change', function () {
            // Giả sử mỗi variant có giá riêng, bạn cần lấy giá từ dữ liệu variant
            const price = this.dataset.price; // Ví dụ: data-price="349.99"
            const salePrice = this.dataset.salePrice; // Ví dụ: data-sale-price="299.99"
            const discount = salePrice ? ((price - salePrice) / price * 100).toFixed(0) : 0;

            document.getElementById('discount').textContent = discount;
            if (salePrice.trim() !== '') {
                document.getElementById('price').textContent = formatCurrency(price);
                document.getElementById('sale_price').textContent = formatCurrency(salePrice);
            } else {
                document.getElementById('price').textContent = '';
                document.getElementById('sale_price').textContent = formatCurrency(price);
            }
        });
    });

    // Tự động check vào variant đầu tiên
    document.querySelector('input[name="variant_id"]').checked = true;
    document.querySelector('input[name="variant_id"]').dispatchEvent(new Event('change'));
</script>

<?php include './views/layouts/boyka/html_end.php'; ?>