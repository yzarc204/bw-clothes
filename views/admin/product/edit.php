<?php require './views/layouts/adminlte/html_start.php'; ?>
<?php require './views/layouts/adminlte/header.php'; ?>

<div class="row g-4 py-5">
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title fw-bold">Sửa sản phẩm</h3>
      </div>
      <div class="card-body">
        <form action="/admin/product/create" method="POST" enctype="multipart/form-data">
          <div class="row gx-4 gy-3">
            <?php require './views/layouts/adminlte/message.php'; ?>

            <div class="col-md-6 col-12">
              <label for="name" class="form-label">Tên sản phẩm</label>
              <input type="text" class="form-control" id="name" name="name"
                value="<?= htmlspecialchars($_SESSION['old']['name'] ?? $product['name'] ?? '') ?>" />
            </div>

            <div class="col-md-6 col-12">
              <label for="category_id" class="form-label">Danh mục</label>
              <select class="form-control" id="category_id" name="category_id">
                <option value="">Không chọn danh mục</option>
                <?php foreach ($categories as $category): ?>
                  <option value="<?= htmlspecialchars($category['id']) ?>" <?= (($_SESSION['old']['category_id'] ?? '') == $category['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6 col-12">
              <label for="featured_image" class="form-label">Ảnh đại diện</label>
              <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/*">
              <div class="mt-2 d-flex flex-column align-items-center" id="featured_previews_container">
                <img class="d-none" id="featured_previews" style="height: 100px; object-fit: cover;" />
              </div>
            </div>

            <div class="col-md-6 col-12">
              <label for="images" class="form-label">Các ảnh khác</label>
              <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
              <div class="row gx-3 gy-3 mt-2" id="previews"></div>
            </div>

            <div class="col-12">
              <label for="description" class="form-label">Mô tả sản phẩm</label>
              <textarea class="form-control" id="description"
                name="description"><?= htmlspecialchars($_SESSION['old']['description'] ?? '') ?></textarea>
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-primary w-100">Thêm sản phẩm</button>
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
  const $featuredPreviews = $('#featured_previews');
  const $featuredPreviewsContainer = $('#featured_previews_container');
  const $imagesInput = $('#images');
  const $previews = $('#previews');
  let selectedFeaturedFile = null; // Lưu file ảnh đại diện
  let selectedFiles = []; // Mảng lưu file các ảnh khác

  // Xử lý ảnh đại diện
  $featuredImage.on('change', function () {
    $featuredPreviewsContainer.empty();
    $featuredPreviews.addClass('d-none');
    selectedFeaturedFile = this.files[0];

    if (!selectedFeaturedFile) return;

    const blob = URL.createObjectURL(selectedFeaturedFile);
    $featuredPreviews.attr('src', blob).removeClass('d-none');

    const $removeBtn = $('<button>', {
      text: 'Xóa',
      class: 'btn btn-danger btn-sm mt-2',
      click: removeFeaturedFile
    });

    $featuredPreviewsContainer.append($featuredPreviews, $removeBtn);
    $featuredPreviews.one('load', () => URL.revokeObjectURL(blob)); // Giải phóng bộ nhớ
  });

  // Xóa ảnh đại diện
  function removeFeaturedFile() {
    selectedFeaturedFile = null;
    $featuredImage.val(''); // Reset input file
    $featuredPreviewsContainer.empty();
    $featuredPreviews.addClass('d-none');
  }

  // Xử lý các ảnh khác
  $imagesInput.on('change', function () {
    const newFiles = Array.from(this.files);
    if (!newFiles.length) return;

    selectedFiles = selectedFiles.concat(newFiles);
    updatePreviews();
    updateInputFiles();
  });

  function updatePreviews() {
    $previews.empty();

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

      $previews.append($container);
    });
  }

  function removeFile(index) {
    selectedFiles.splice(index, 1);
    updatePreviews();
    updateInputFiles();
  }

  function updateInputFiles() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    $imagesInput[0].files = dt.files;
  }
</script>
<?php require './views/layouts/adminlte/html_end.php'; ?>
<?php unset($_SESSION['old']); ?>