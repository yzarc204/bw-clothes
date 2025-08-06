<?php require './views/layouts/adminlte/html_start.php'; ?>
<?php require './views/layouts/adminlte/header.php'; ?>

<div class="row g-4 py-5">
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title fw-bold">Sửa sản phẩm</h3>
      </div>
      <div class="card-body">
        <form action="/admin/product/<?= $product['id'] ?>/edit" method="POST" enctype="multipart/form-data">
          <div class="row gx-4 gy-3">
            <?php require './views/layouts/adminlte/message.php'; ?>

            <div class="col-md-6 col-12">
              <label for="name" class="form-label">Tên sản phẩm</label>
              <input type="text" class="form-control" id="name" name="name"
                value="<?= $_SESSION['old']['name'] ?? $product['name'] ?? '' ?>" />
            </div>

            <div class="col-md-6 col-12">
              <label for="category_id" class="form-label">Danh mục</label>
              <select class="form-control" id="category_id" name="category_id">
                <option value="">Không chọn danh mục</option>
                <?php foreach ($categories as $category): ?>
                  <option value="<?= $category['id'] ?>" <?= (($_SESSION['old']['category_id'] ?? $product['category_id']) == $category['id']) ? 'selected' : '' ?>>
                    <?= $category['name'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6 col-12">
              <label for="featured_image" class="form-label">Ảnh đại diện</label>
              <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/*">
              <div class="row gx-3 gy-3 mt-2">
                <!-- Ảnh đại diện hiện tại -->
                <div class="col-md-6">
                  <p class="fw-bold">Ảnh hiện tại</p>
                  <div class="d-flex flex-column align-items-center">
                    <img src="<?= BASE_URL . '/' . $product['featured_image'] ?>" alt="Ảnh đại diện"
                      style="height: 100px; width: auto; object-fit: cover;">
                  </div>
                </div>
                <!-- Ảnh đại diện mới -->
                <div class="col-md-6">
                  <p class="fw-bold">Ảnh mới</p>
                  <div class="d-flex flex-column align-items-center" id="new_featured_previews"></div>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-12">
              <label for="images" class="form-label">Các ảnh khác</label>
              <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
              <div class="row gx-3 gy-3 mt-2">
                <!-- Ảnh đã thêm -->
                <div class="col-md-6">
                  <p class="fw-bold">Ảnh đã thêm</p>
                  <div class="row gx-3 gy-3" id="existing_images">
                    <?php foreach ($images as $image): ?>
                      <div class="col-auto d-flex flex-column align-items-center">
                        <img src="<?= BASE_URL . '/' . $image['image_url'] ?>" alt="Product image"
                          style="height: 100px; width: auto; object-fit: cover;">
                        <a onclick="return confirm('Bạn có chắc chắn muốn xoá ảnh này?');"
                          class="btn btn-warning btn-sm mt-2"
                          href="/admin/product-image/<?= $image['id'] ?>/delete">Xoá</a>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
                <!-- Ảnh thêm mới -->
                <div class="col-md-6">
                  <p class="fw-bold">Ảnh thêm mới</p>
                  <div class="row gx-3 gy-3" id="new_images_previews"></div>
                </div>
              </div>
            </div>

            <div class="col-12">
              <label for="description" class="form-label">Mô tả sản phẩm</label>
              <textarea class="form-control" id="description"
                name="description"><?= $_SESSION['old']['description'] ?? $product['description'] ?? '' ?></textarea>
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-primary w-100">Cập nhật sản phẩm</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require './views/layouts/adminlte/footer.php'; ?>

<script type="text/javascript" src="/vendors/jquery.min.js"></script>
<script type="text/javascript">
  const $featuredImage = $('#featured_image');
  const $newFeaturedPreviews = $('#new_featured_previews');
  const $imagesInput = $('#images');
  const $newImagesPreviews = $('#new_images_previews');
  let selectedFeaturedFile = null; // Lưu file ảnh đại diện
  let selectedFiles = []; // Mảng lưu file các ảnh mới

  // Xử lý ảnh đại diện mới
  $featuredImage.on('change', function () {
    $newFeaturedPreviews.empty();
    selectedFeaturedFile = this.files[0];

    if (!selectedFeaturedFile) return;

    const blob = URL.createObjectURL(selectedFeaturedFile);
    const $img = $('<img>', {
      src: blob,
      css: { height: '100px', width: 'auto', objectFit: 'cover' },
      on: {
        load: () => URL.revokeObjectURL(blob) // Giải phóng bộ nhớ
      }
    });

    const $removeBtn = $('<button>', {
      text: 'Xóa',
      class: 'btn btn-danger btn-sm mt-2',
      click: removeFeaturedFile
    });

    const $container = $('<div>', {
      class: 'd-flex flex-column align-items-center'
    }).append($img, $removeBtn);

    $newFeaturedPreviews.append($container);
  });

  // Xóa ảnh đại diện mới
  function removeFeaturedFile() {
    selectedFeaturedFile = null;
    $featuredImage.val(''); // Reset input file
    $newFeaturedPreviews.empty();
  }

  // Xử lý ảnh mới
  $imagesInput.on('change', function () {
    const newFiles = Array.from(this.files);
    if (!newFiles.length) return;

    selectedFiles = selectedFiles.concat(newFiles);
    updateNewImagesPreviews();
    updateInputFiles();
  });

  // Cập nhật preview ảnh mới
  function updateNewImagesPreviews() {
    $newImagesPreviews.empty();

    selectedFiles.forEach((file, index) => {
      const blob = URL.createObjectURL(file);
      const $img = $('<img>', {
        src: blob,
        css: { height: '100px', width: 'auto', objectFit: 'cover' },
        on: {
          load: () => URL.revokeObjectURL(blob) // Giải phóng bộ nhớ
        }
      });

      const $removeBtn = $('<button>', {
        text: 'Xóa',
        class: 'btn btn-danger btn-sm mt-2',
        click: () => removeFile(index)
      });

      const $container = $('<div>', {
        class: 'col-auto d-flex flex-column align-items-center'
      }).append($img, $removeBtn);

      $newImagesPreviews.append($container);
    });
  }

  // Xóa ảnh mới
  function removeFile(index) {
    selectedFiles.splice(index, 1);
    updateNewImagesPreviews();
    updateInputFiles();
  }

  // Cập nhật input files
  function updateInputFiles() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    $imagesInput[0].files = dt.files;
  }
</script>
<?php require './views/layouts/adminlte/html_end.php'; ?>
<?php unset($_SESSION['old']); ?>