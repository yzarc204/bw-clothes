</head>

<body>
  <!-- Main Wrapper Start -->
  <div class="main-wrapper">
    <!-- header-area start -->
    <div class="header-area">
      <!-- header-top start -->
      <div class="header-top bg-grey">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 order-2 order-lg-1">
            </div>
            <div class="col-lg-4 order-1 order-lg-2">
              <div class="top-selector-wrapper">
                <ul class="single-top-selector">
                  <!-- Sanguage Start -->
                  <li class="setting-top list-inline-item">
                    <div class="btn-group">
                      <button class="dropdown-toggle">
                        <i class="fa fa-user-circle-o"></i> <?= $loginedUser['name'] ?>
                        <i class="fa fa-angle-down"></i>
                      </button>
                      <div class="dropdown-menu">
                        <ul>
                          <?php if ($loginedUser['is_admin']): ?>
                            <li><a href="/admin">Trang quản trị</a></li>
                          <?php endif; ?>
                          <li><a href="/order">Đơn hàng</a></li>
                          <li><a href="/logout">Đăng xuất</a></li>
                        </ul>
                      </div>
                    </div>
                  </li>
                  <!-- Sanguage End -->
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Header-top end -->
      <!-- Header-bottom start -->
      <div class="header-bottom-area header-sticky">
        <div class="container">
          <div class="row">
            <div class="col-lg-2 col-4">
              <!-- logo start -->
              <div class="logo">
                <a href="/"><img src="<?= BASE_URL . '/' . LOGO ?>" alt="" style="max-height: 35px;" /></a>
              </div>
              <!-- logo end -->
            </div>
            <div class="col-lg-7 d-none d-lg-block">
              <!-- main-menu-area start -->
              <div class="main-menu-area">
                <nav class="main-navigation">
                  <ul>
                    <li><a href="/">Trang chủ</a></li>
                    <li><a href="/shop">Sản phẩm mới</a></li>
                    <?php foreach ($menuCategories as $category): ?>
                      <li><a href="/category/<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                </nav>
              </div>
              <!-- main-menu-area End -->
            </div>
            <div class="col-lg-3 col-8">
              <div class="header-bottom-right">
                <div class="block-search">
                  <div class="trigger-search">
                    <i class="fa fa-search"></i> <span>Tìm kiếm</span>
                  </div>
                  <div class="search-box main-search-active">
                    <form action="/shop" class="search-box-inner">
                      <input type="text" name="s" placeholder="Tìm kiếm ..." required />
                      <button class="search-btn" type="submit">
                        <i class="fa fa-search"></i>
                      </button>
                    </form>
                  </div>
                </div>
                <div class="shoping-cart">
                  <div class="btn-group">
                    <!-- Mini Cart Button start -->
                    <button class="dropdown-toggle">
                      <i class="fa fa-shopping-cart"></i> Giỏ hàng (<?= $userCart['total_variants'] ?>)
                    </button>
                    <!-- Mini Cart button end -->

                    <?php require './views/layouts/boyka/mini_cart.php'; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <!-- mobile-menu start -->
              <div class="mobile-menu d-block d-lg-none"></div>
              <!-- mobile-menu end -->
            </div>
          </div>
        </div>
      </div>
      <!-- Header-botto m end -->
    </div>
    <!-- Header-area end -->