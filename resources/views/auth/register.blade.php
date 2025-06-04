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

  <title>Register | SiLaprak</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo-removebg.png') }}" />

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
                <span class="app-brand-text demo text-heading fw-bold">SiLaprak</span>
              </a>
            </div>
            <!-- /Logo -->

            <h4 class="mb-1 text-center">Selamat Datang di SiLaprak! 👋</h4>
            <p class="mb-4 text-center">Masukkan data data yang diperlukan untuk mendaftar</p>

            <form id="formAuthentication" class="mb-6" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <!-- Baris Pertama: Nama Lengkap, NIM, Nama -->
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input
                      type="text"
                      class="form-control @error('nama_lengkap') is-invalid @enderror"
                      id="nama_lengkap"
                      name="nama_lengkap"
                      placeholder="Masukkan Nama Lengkap"
                      value="{{ old('nama_lengkap') }}"
                      required />
                    @error('nama_lengkap')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="nomor_induk" class="form-label">NIM</label>
                    <input
                      type="text"
                      class="form-control @error('nomor_induk') is-invalid @enderror"
                      id="nomor_induk"
                      name="nomor_induk"
                      placeholder="Masukkan NIM"
                      value="{{ old('nomor_induk') }}"
                      required pattern="\d+"
                      title="NIM harus berupa angka" />
                    @error('nomor_induk')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input
                      type="text"
                      class="form-control @error('nama') is-invalid @enderror"
                      id="nama"
                      name="nama"
                      placeholder="Masukkan Nama"
                      value="{{ old('nama') }}"
                      required />
                    @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <!-- Baris Kedua: Email dan Password -->
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                      type="email"
                      class="form-control @error('email') is-invalid @enderror"
                      id="email"
                      name="email"
                      placeholder="Masukkan Email"
                      value="{{ old('email') }}"
                      required />
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-6 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control @error('password') is-invalid @enderror"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                    @error('password')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                </div>

                <!-- Upload Foto Profil -->
                <div class="mb-3">
                  <label for="foto_profile" class="form-label">Foto Profil</label>
                  <div class="custom-file-upload">
                    <label for="foto_profile" id="foto_profile_label" class="upload-label">Klik untuk unggah foto</label>
                    <input
                      type="file"
                      id="foto_profile"
                      name="foto_profile"
                      accept="image/*"
                      onchange="previewImage(this, 'preview_foto_profile')"
                      required />
                    <div class="preview-box" id="preview_foto_profile"></div>
                    @error('foto_profile')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <!-- Upload Identitas -->
                <div class="mb-3">
                  <label for="identitas" class="form-label">Foto Kartu Identitas</label>
                  <div class="custom-file-upload">
                    <label for="identitas" id="identitas_label" class="upload-label">Klik untuk unggah identitas</label>
                    <input
                      type="file"
                      id="identitas"
                      name="identitas"
                      accept="image/*"
                      onchange="previewImage(this, 'preview_identitas')"
                      required />
                    <div class="preview-box" id="preview_identitas"></div>
                    @error('identitas')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
              <button class="btn btn-primary d-grid w-100">Sign up</button>
            </form>

            <p class="text-center mt-4">
              <span>Sudah mempunyai akun?</span>
              <a href="{{ route('login') }}">
                <span>Masuk</span>
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