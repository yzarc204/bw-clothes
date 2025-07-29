<?php require './views/layouts/adminlte/html_start.php'; ?>
<?php require './views/layouts/adminlte/header.php'; ?>

<div class="row g-4 py-5">
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title fw-bold">Thêm sản phẩm</h3>
      </div>
      <div class="card-body">
        <form action="/admin/category/create" method="POST" enctype="multipart/form-data" id="myForm">
          <div class="row gx-4 gy-3">
            <?php require './views/layouts/adminlte/message.php'; ?>

            <div class="col-md-6 col-12">
              <label for="name" class="form-label">Tên sản phẩm</label>
              <input type="text" class="form-control" id="name" name="name"
                value="<?= $_SESSION['old']['name'] ?? '' ?>" />
            </div>

            <div class="col-md-6 col-12">
              <label for="name" class="form-label">Danh mục</label>
              <select class="form-control" name="category_id">
                <?php foreach ($categories as $category): ?>
                  <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6 col-12">
              <label for="description" class="form-label">Mô tả sản phẩm</label>
              <textarea class="form-control" name="description">
                <?= $_SESSION['old']['description'] ?? '' ?>
              </textarea>
            </div>

            <div class="col-md-6 col-12">
              <label for="name" class="form-label">Hình ảnh sản phẩm</label>
              <input type="file" class="form-control" id="images" name="images" multiple accept="image/*">
              <div class="row gx-3 gy-3 mt-2" id="previews"></div>
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
</div>

<?php require './views/layouts/adminlte/footer.php'; ?>
<script type="text/javascript" src="/vendors/jquery.min.js"></script>
<script type="text/javascript">
  let selectedFiles = []; // Mảng lưu file đã chọn để quản lý

  $('#images').on('change', function () {
    const newFiles = Array.from(this.files); // Lấy file mới chọn
    selectedFiles = selectedFiles.concat(newFiles); // Thêm vào mảng hiện tại (hoặc thay = newFiles nếu muốn reset khi chọn mới)
    updatePreviews(); // Cập nhật preview
    updateInputFiles(); // Cập nhật input.files để submit đúng
  });

  function updatePreviews() {
    $('#previews').html(''); // Xóa preview cũ
    selectedFiles.forEach((file, index) => {
      const img = document.createElement('img');
      const objUrl = window.URL.createObjectURL(file);
      img.src = objUrl;
      img.style.height = '100px';
      img.style.width = 'auto';
      img.style.objectFit = 'cover';

      const removeBtn = document.createElement('button');
      removeBtn.textContent = 'Xóa';
      removeBtn.className = 'btn btn-danger btn-sm mt-2'; // Style nút xóa cho phù hợp AdminLTE
      removeBtn.onclick = () => removeFile(index); // Gọi hàm xóa

      const container = document.createElement('div');
      container.className = 'col-auto d-flex flex-column align-items-center'; // Sử dụng flex-column để nút xóa ở bên dưới ảnh và canh giữa
      container.appendChild(img);
      container.appendChild(removeBtn);
      $('#previews').append(container);
    });
  }

  function removeFile(index) {
    selectedFiles.splice(index, 1); // Xóa file khỏi mảng
    updatePreviews(); // Cập nhật lại preview
    updateInputFiles(); // Cập nhật input.files
  }

  function updateInputFiles() {
    const dt = new DataTransfer(); // Tạo DataTransfer mới
    selectedFiles.forEach(file => dt.items.add(file)); // Thêm file còn lại
    $('#images')[0].files = dt.files; // Gán lại vào input
  }
</script>
<?php require './views/layouts/adminlte/html_end.php'; ?>