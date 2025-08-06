<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <!--begin::Brand Link-->
    <a href="/admin" class="brand-link">
      <!--begin::Brand Image-->
      <img src="<?= BASE_URL ?>/assets/adminlte/img/AdminLTELogo.png" alt="AdminLTE Logo"
        class="brand-image opacity-75 shadow" />
      <!--end::Brand Image-->
      <!--begin::Brand Text-->
      <span class="brand-text fw-light">AdminLTE 4</span>
      <!--end::Brand Text-->
    </a>
    <!--end::Brand Link-->
  </div>
  <!--end::Sidebar Brand-->
  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <!--begin::Sidebar Menu-->
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation"
        data-accordion="false" id="navigation">
        <li class="nav-item">
          <a href="/admin/product" class="nav-link">
            <i class="nav-icon bi bi-archive-fill"></i>
            <p>Quản lí sản phẩm</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/admin/category" class="nav-link">
            <i class="nav-icon bi bi-tag-fill"></i>
            <p>Quản lí danh mục</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/admin/attribute" class="nav-link">
            <i class="nav-icon bi bi-palette2"></i>
            <p>Thuộc tính biến thể</p>
          </a>
        </li>
      </ul>
      <!--end::Sidebar Menu-->
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>