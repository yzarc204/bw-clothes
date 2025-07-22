<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/boyka/css/bootstrap.min.css" />

  <!-- Font CSS -->
  <link rel="stylesheet" href="assets/boyka/css/font-awesome.min.css" />

  <!-- Plugins CSS -->
  <link rel="stylesheet" href="assets/boyka/css/plugins.css" />

  <!-- Main Style CSS -->
  <link rel="stylesheet" href="assets/boyka/css/style.css" />
</head>

<body>
  <section class="vh-100" style="background-color: #333">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
          <div class="card" style="border-radius: 1rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="assets/img/bg-auth.webp" alt="login form" class="img-fluid"
                  style="border-radius: 1rem 0 0 1rem; min-height: 100%; object-fit: cover; object-position: left;" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">
                  <form method="POST" action="/login">
                    <div class="d-flex align-items-center mb-3 pb-1">
                      <i class="fa fa-cubes fa-3x me-3"></i>
                      <p class="h1 fw-bold mb-0">B&W - CLOZ</p>
                    </div>

                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Đăng nhập vào tài khoản của bạn</h5>

                    <?php if (isset($_SESSION['error'])): ?>
                      <div class="alert alert-danger" role="alert"><?= $_SESSION['error'] ?></div>
                      <?php unset($_SESSION['error']); endif; ?>

                    <div class="form-outline mb-4">
                      <input type="text" id="username" name="username" class="form-control form-control-lg" />
                      <label class="form-label" for="username">Tài khoản</label>
                    </div>

                    <div class="form-outline mb-4">
                      <input type="password" id="password" name="password" class="form-control form-control-lg" />
                      <label class="form-label" for="password">Mật khẩu</label>
                    </div>

                    <div class="pt-1 mb-4">
                      <button class="btn btn-dark btn-lg btn-block" type="submit">Đăng nhập</button>
                    </div>

                    <!-- <a class="small text-muted" href="#!">Forgot password?</a> -->
                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Chưa có tài khoản? <a href="/register"
                        style="color: #393f81;">Đăng ký</a></p>
                    <!-- <a href="#!" class="small text-muted">Terms of use.</a>
                    <a href="#!" class="small text-muted">Privacy policy</a> -->
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="assets/boyka/js/bootstrap.min.js"></script>
</body>

</html>