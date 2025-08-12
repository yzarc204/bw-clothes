<?php $pageTitle = 'Dashboard'; ?>
<?php require './views/layouts/adminlte/html_start.php'; ?>
<?php require './views/layouts/adminlte/header.php'; ?>

<div class="row g-4 mt-2">
  <!-- Tổng số sản phẩm -->
  <div class="col-lg-3 col-md-6 col-12">
    <div class="small-box text-bg-primary">
      <div class="inner">
        <h3><?= currencyFormat($totalProduct) ?></h3>
        <p>Sản phẩm</p>
      </div>
      <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true">
        <path
          d="M17.5777 4.43152L15.5777 3.38197C13.8221 2.46066 12.9443 2 12 2C11.0557 2 10.1779 2.46066 8.42229 3.38197L8.10057 3.5508L17.0236 8.64967L21.0403 6.64132C20.3941 5.90949 19.3515 5.36234 17.5777 4.43152Z" />
        <path
          d="M21.7484 7.96434L17.75 9.96353V13C17.75 13.4142 17.4142 13.75 17 13.75C16.5858 13.75 16.25 13.4142 16.25 13V10.7135L12.75 12.4635V21.904C13.4679 21.7252 14.2848 21.2965 15.5777 20.618L17.5777 19.5685C19.7294 18.4393 20.8052 17.8748 21.4026 16.8603C22 15.8458 22 14.5833 22 12.0585V11.9415C22 10.0489 22 8.86557 21.7484 7.96434Z" />
        <path
          d="M11.25 21.904V12.4635L2.25164 7.96434C2 8.86557 2 10.0489 2 11.9415V12.0585C2 14.5833 2 15.8458 2.5974 16.8603C3.19479 17.8748 4.27062 18.4393 6.42228 19.5685L8.42229 20.618C9.71524 21.2965 10.5321 21.7252 11.25 21.904Z" />
        <path
          d="M2.95969 6.64132L12 11.1615L15.4112 9.4559L6.52456 4.37785L6.42229 4.43152C4.64855 5.36234 3.6059 5.90949 2.95969 6.64132Z" />
      </svg>
      <a href="/admin/product"
        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
        Quản lí sản phẩm <i class="bi bi-link-45deg"></i>
      </a>
    </div>
  </div>
  <!-- Tổng số biến thể -->
  <div class="col-lg-3 col-md-6 col-12">
    <div class="small-box text-bg-info">
      <div class="inner">
        <h3><?= currencyFormat($totalVariant) ?></h3>
        <p>Biến thể</p>
      </div>
      <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true">
        <path
          d="M22.0009 16.5V19.5C22.0009 20.88 20.8809 22 19.5009 22H12.3609C11.4709 22 11.0309 20.93 11.6509 20.3L17.5209 14.3C17.7109 14.11 17.9709 14 18.2309 14H19.5009C20.8809 14 22.0009 15.12 22.0009 16.5Z" />
        <path
          d="M18.3702 11.2895L15.6602 13.9995L13.2002 16.4495C12.5702 17.0795 11.4902 16.6395 11.4902 15.7495C11.4902 12.5395 11.4902 7.25953 11.4902 7.25953C11.4902 6.98953 11.6002 6.73953 11.7802 6.54953L12.7002 5.62953C13.6802 4.64953 15.2602 4.64953 16.2402 5.62953L18.3602 7.74953C19.3502 8.72953 19.3502 10.3095 18.3702 11.2895Z" />
        <path
          d="M7.5 2H4.5C3 2 2 3 2 4.5V18C2 18.27 2.03 18.54 2.08 18.8C2.11 18.93 2.14 19.06 2.18 19.19C2.23 19.34 2.28 19.49 2.34 19.63C2.35 19.64 2.35 19.65 2.35 19.65C2.36 19.65 2.36 19.65 2.35 19.66C2.49 19.94 2.65 20.21 2.84 20.46C2.95 20.59 3.06 20.71 3.17 20.83C3.28 20.95 3.4 21.05 3.53 21.15L3.54 21.16C3.79 21.35 4.06 21.51 4.34 21.65C4.35 21.64 4.35 21.64 4.35 21.65C4.5 21.72 4.65 21.77 4.81 21.82C4.94 21.86 5.07 21.89 5.2 21.92C5.46 21.97 5.73 22 6 22C6.41 22 6.83 21.94 7.22 21.81C7.33 21.77 7.44 21.73 7.55 21.68C7.9 21.54 8.24 21.34 8.54 21.08C8.63 21.01 8.73 20.92 8.82 20.83L8.86 20.79C9.56 20.07 10 19.08 10 18V4.5C10 3 9 2 7.5 2ZM6 19.5C5.17 19.5 4.5 18.83 4.5 18C4.5 17.17 5.17 16.5 6 16.5C6.83 16.5 7.5 17.17 7.5 18C7.5 18.83 6.83 19.5 6 19.5Z" />
      </svg>
      <a href="/admin/attribute"
        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
        Quản lí biến thể <i class="bi bi-link-45deg"></i>
      </a>
    </div>
  </div>
  <!-- Tổng số đơn hàng -->
  <div class="col-lg-3 col-md-6 col-12">
    <div class="small-box text-bg-success">
      <div class="inner">
        <h3><?= currencyFormat($totalOrder) ?></h3>
        <p>Đơn hàng</p>
      </div>
      <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true">
        <path
          d="M2.08416 2.7512C2.22155 2.36044 2.6497 2.15503 3.04047 2.29242L3.34187 2.39838C3.95839 2.61511 4.48203 2.79919 4.89411 3.00139C5.33474 3.21759 5.71259 3.48393 5.99677 3.89979C6.27875 4.31243 6.39517 4.76515 6.4489 5.26153C6.47295 5.48373 6.48564 5.72967 6.49233 6H17.1305C18.8155 6 20.3323 6 20.7762 6.57708C21.2202 7.15417 21.0466 8.02369 20.6995 9.76275L20.1997 12.1875C19.8846 13.7164 19.727 14.4808 19.1753 14.9304C18.6236 15.38 17.8431 15.38 16.2821 15.38H10.9792C8.19028 15.38 6.79583 15.38 5.92943 14.4662C5.06302 13.5523 4.99979 12.5816 4.99979 9.64L4.99979 7.03832C4.99979 6.29837 4.99877 5.80316 4.95761 5.42295C4.91828 5.0596 4.84858 4.87818 4.75832 4.74609C4.67026 4.61723 4.53659 4.4968 4.23336 4.34802C3.91052 4.18961 3.47177 4.03406 2.80416 3.79934L2.54295 3.7075C2.15218 3.57012 1.94678 3.14197 2.08416 2.7512Z" />
        <path
          d="M7.5 18C8.32843 18 9 18.6716 9 19.5C9 20.3284 8.32843 21 7.5 21C6.67157 21 6 20.3284 6 19.5C6 18.6716 6.67157 18 7.5 18Z" />
        <path
          d="M16.5 18.0001C17.3284 18.0001 18 18.6716 18 19.5001C18 20.3285 17.3284 21.0001 16.5 21.0001C15.6716 21.0001 15 20.3285 15 19.5001C15 18.6716 15.6716 18.0001 16.5 18.0001Z" />
      </svg>
      <a href="/admin/order"
        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
        Quản lí đơn hàng <i class="bi bi-link-45deg"></i>
      </a>
    </div>
  </div>
  <!-- Tổng số người dùng -->
  <div class="col-lg-3 col-md-6 col-12">
    <div class="small-box text-bg-danger">
      <div class="inner">
        <h3><?= currencyFormat($totalUser) ?></h3>
        <p>Người dùng</p>
      </div>
      <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true">
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M5 9.5C5 7.01472 7.01472 5 9.5 5C11.9853 5 14 7.01472 14 9.5C14 11.9853 11.9853 14 9.5 14C7.01472 14 5 11.9853 5 9.5Z" />
        <path
          d="M14.3675 12.0632C14.322 12.1494 14.3413 12.2569 14.4196 12.3149C15.0012 12.7454 15.7209 13 16.5 13C18.433 13 20 11.433 20 9.5C20 7.567 18.433 6 16.5 6C15.7209 6 15.0012 6.2546 14.4196 6.68513C14.3413 6.74313 14.322 6.85058 14.3675 6.93679C14.7714 7.70219 15 8.5744 15 9.5C15 10.4256 14.7714 11.2978 14.3675 12.0632Z" />
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M4.64115 15.6993C5.87351 15.1644 7.49045 15 9.49995 15C11.5112 15 13.1293 15.1647 14.3621 15.7008C15.705 16.2847 16.5212 17.2793 16.949 18.6836C17.1495 19.3418 16.6551 20 15.9738 20H3.02801C2.34589 20 1.85045 19.3408 2.05157 18.6814C2.47994 17.2769 3.29738 16.2826 4.64115 15.6993Z" />
        <path
          d="M14.8185 14.0364C14.4045 14.0621 14.3802 14.6183 14.7606 14.7837V14.7837C15.803 15.237 16.5879 15.9043 17.1508 16.756C17.6127 17.4549 18.33 18 19.1677 18H20.9483C21.6555 18 22.1715 17.2973 21.9227 16.6108C21.9084 16.5713 21.8935 16.5321 21.8781 16.4932C21.5357 15.6286 20.9488 14.9921 20.0798 14.5864C19.2639 14.2055 18.2425 14.0483 17.0392 14.0008L17.0194 14H16.9997C16.2909 14 15.5506 13.9909 14.8185 14.0364Z" />
      </svg>
      <a href="/admin/user"
        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
        Quản lí người dùng <i class="bi bi-link-45deg"></i>
      </a>
    </div>
  </div>
</div>

<div class="row g-4 mt-2">
  <!-- Đơn hàng thành công -->
  <div class="col-lg-3 col-md-6 col-12">
    <div class="info-box">
      <span class="info-box-icon text-bg-primary shadow-sm">
        <i class="bi bi-cart-check-fill"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">Đơn hàng thành công</span>
        <span class="info-box-number"><?= $totalSuccessOrder ?></span>
      </div>
    </div>
  </div>
  <!-- Sản phẩm đã bán -->
  <div class="col-lg-3 col-md-6 col-12">
    <div class="info-box">
      <span class="info-box-icon text-bg-info shadow-sm">
        <i class="bi bi-archive-fill"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">Sản phẩm đã bán</span>
        <span class="info-box-number"><?= currencyFormat($totalPurchasedProduct) ?></span>
      </div>
    </div>
  </div>
  <!-- Doanh thu -->
  <div class="col-lg-3 col-md-6 col-12">
    <div class="info-box">
      <span class="info-box-icon text-bg-success shadow-sm">
        <i class="bi bi-archive-fill"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">Doanh thu</span>
        <span class="info-box-number"><?= currencyFormat($totalRevenue) ?>đ</span>
      </div>
    </div>
  </div>
  <!-- Đơn hàng bị hủy -->
  <div class="col-lg-3 col-md-6 col-12">
    <div class="info-box">
      <span class="info-box-icon text-bg-danger shadow-sm">
        <i class="bi bi-archive-fill"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">Đơn hàng bị hủy</span>
        <span class="info-box-number"><?= $totalCancelOrder ?></span>
      </div>
    </div>
  </div>
</div>

<?php require './views/layouts/adminlte/footer.php'; ?>
<?php require './views/layouts/adminlte/html_end.php'; ?>