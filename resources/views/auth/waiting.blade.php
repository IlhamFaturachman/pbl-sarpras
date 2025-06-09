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

    <title>Pendaftaran Berhasil | SiLaprak</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/assets/img/logo-removebg.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="../assets/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>

    <!-- Custom Success Page Styles -->
    <style>
      .success-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #28a745, #20c997);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        animation: bounceIn 0.6s ease-out;
      }

      @keyframes bounceIn {
        0% {
          transform: scale(0.3);
          opacity: 0;
        }
        50% {
          transform: scale(1.05);
        }
        70% {
          transform: scale(0.9);
        }
        100% {
          transform: scale(1);
          opacity: 1;
        }
      }

      .success-card {
        text-align: center;
        padding: 2rem 1rem;
      }

      .success-title {
        color: #28a745;
        font-weight: 600;
        margin-bottom: 1rem;
      }

      .success-message {
        color: #6c757d;
        margin-bottom: 2rem;
        line-height: 1.6;
      }

      .btn-group-custom {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
      }

      .btn-group-custom .btn {
        flex: 1;
      }

      @media (max-width: 576px) {
        .btn-group-custom {
          flex-direction: column;
        }
        
        .btn-group-custom .btn {
          width: 100%;
        }
      }

      .alert-success-custom {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        border: 1px solid #c3e6cb;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        color: #155724;
      }
    </style>
  </head>

  <body>
    <!-- Content -->
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Success Card -->
          <div class="card px-sm-6 px-0">
            <div class="card-body success-card">
              <!-- Logo -->
              <div class="app-brand justify-content-center mb-4">
                <a href="/" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <span class="text-primary">
                      <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="img-fluid d-block mx-auto" style="height: 50px; width: auto;">
                    </span>
                  </span>
                  <span class="app-brand-text demo text-heading fw-bold">SiLaprak</span>
                </a>
              </div>
              <!-- /Logo -->

              <!-- Success Icon -->
              <div class="success-icon">
                <i class="bx bx-check"></i>
              </div>

              <!-- Success Message -->
              <h2 class="success-title">Pendaftaran Berhasil! 🎉</h2>
              
              @if (session('status'))
                <div class="alert-success-custom">
                  <i class="bx bx-info-circle me-2"></i>
                  {{ session('status') }}
                </div>
              @endif

              <div class="success-message">
                <p class="mb-2">Terima kasih telah mendaftar di SiLaprak!</p>
                <p class="mb-0">Akun Anda sedang menunggu verifikasi dari admin. Anda akan mendapatkan notifikasi melalui email setelah akun diverifikasi.</p>
              </div>

              <!-- Action Buttons -->
              <div class="btn-group-custom">
                <a href="{{ route('login') }}" class="btn btn-primary">
                  <i class="bx bx-log-in me-1"></i>
                  Ke Halaman Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary">
                  <i class="bx bx-user-plus me-1"></i>
                  Daftar Lagi
                </a>
              </div>

              <!-- Additional Info -->
              <div class="mt-4 pt-3" style="border-top: 1px solid #e9ecef;">
                <small class="text-muted">
                  <i class="bx bx-info-circle me-1"></i>
                  Proses verifikasi biasanya memakan waktu 1-2 hari kerja
                </small>
              </div>

              <!-- Footer Links -->
              <div class="mt-4">
                <p class="text-center">
                  <span class="text-muted">Butuh bantuan?</span>
                  <a href="mailto:support@silaprak.com" class="text-primary">
                    <span>Hubungi Support</span>
                  </a>
                </p>
              </div>
            </div>
          </div>
          <!-- /Success Card -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>