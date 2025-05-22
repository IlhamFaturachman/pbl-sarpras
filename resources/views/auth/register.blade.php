<!doctype html>

<html
  lang="en"
  class="layout-wide customizer-hide"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>SARPRAS - REGISTER</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}" />

  <!-- Core CSS -->
  <!-- build:css assets/vendor/css/theme.css  -->

  <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

  <!-- Vendors CSS -->

  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

  <!-- endbuild -->

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-register.css') }}" />

  <!-- Helpers -->
  <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

  <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
  <!-- Content -->

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register Card -->
        <div class="card px-sm-6 px-0">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center mb-6">
              <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                  <span class="text-primary">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="img-fluid d-block mx-auto" style="height: 50px; width: auto;">
                  </span>
                </span>
                <span class="app-brand-text demo text-heading fw-bold">Sarpras</span>
              </a>
            </div>
            <!-- /Logo -->

            <h4 class="mb-1 text-center">Selamat Datang di Sarpras! 👋</h4>
            <p class="mb-4 text-center">Masukkan data data yang diperlukan untuk memulai sesi Anda</p>

            <form id="formAuthentication" class="mb-6" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <!-- Kolom Kiri: Data User -->
                <div class="col-md-6">
                  <div class="mb-6">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input
                      type="text"
                      class="form-control"
                      id="nama_lengkap"
                      name="nama_lengkap"
                      placeholder="Masukkan Nama Lengkap"
                      autofocus />
                  </div>
                  <div class="mb-6">
                    <label for="nomor_induk" class="form-label">Nomor Induk</label>
                    <input
                      type="text"
                      class="form-control"
                      id="nomor_induk"
                      name="nomor_induk"
                      placeholder="Masukkan Nomor Induk" />
                  </div>
                </div>
                <!-- Kolom Kanan: Data User -->
                <div class="col-md-6">
                  <div class="mb-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan Email" />
                  </div>
                  <div class="form-password-toggle">
                      <label class="form-label" for="password">Password</label>
                      <div class="input-group input-group-merge">
                        <input
                          type="password"
                          id="password"
                          class="form-control"
                          name="password"
                          placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                        <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label for="foto_profil" class="form-label">Foto Profil</label>
                  <div class="custom-file-upload">
                    <label for="foto_profil" id="foto_profil_label" class="upload-label">Klik untuk unggah foto</label>
                    <input type="file" id="foto_profil" name="foto_profil" accept="image/*" onchange="previewImage(this, 'preview_foto_profil')" />
                    <div class="preview-box" id="preview_foto_profil"></div>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="identitas" class="form-label">Foto Kartu Identitas</label>
                  <div class="custom-file-upload">
                    <label for="identitas" id="identitas_label" class="upload-label">Klik untuk unggah identitas</label>
                    <input type="file" id="identitas" name="identitas" accept="image/*" onchange="previewImage(this, 'preview_identitas')" />
                    <div class="preview-box" id="preview_identitas"></div>
                  </div>
                </div>
              </div>
              <button class="btn btn-primary d-grid w-100">Sign up</button>
            </form>

            <p class="text-center mt-4">
              <span>Already have an account?</span>
              <a href="{{ route('login') }}">
                <span>Sign in instead</span>
              </a>
            </p>
          </div>
        </div>
        <!-- Register Card -->
      </div>
    </div>
  </div>

  <script>
  function previewImage(input, previewId, labelId) {
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    const label = document.getElementById(labelId);
    preview.innerHTML = ''; // Clear sebelumnya

    if (file && file.type.startsWith('image/')) {
      // Sembunyikan tombol upload
      if (label) label.style.display = 'none';

      const reader = new FileReader();
      reader.onload = function(e) {
        const img = document.createElement('img');
        img.src = e.target.result;
        preview.appendChild(img);
      };
      reader.readAsDataURL(file);
    }
  }
</script>

  <!-- Core JS -->

  <script src="../assets/vendor/libs/jquery/jquery.js"></script>

  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>

  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="../assets/vendor/js/menu.js"></script>

  <!-- endbuild -->

  <!-- Vendors JS -->

  <!-- Main JS -->

  <script src="../assets/js/main.js"></script>

  <!-- Page JS -->

  <!-- Place this tag before closing body tag for github widget button. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>