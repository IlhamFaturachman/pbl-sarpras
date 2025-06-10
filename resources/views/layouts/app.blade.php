<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="{{ asset('assets/') }}"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>PBL - Silaprak</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('/assets/img/logo-removebg.png') }}" />

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

  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <!-- Page CSS -->


  <!-- Helpers -->
  <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

  <script src="{{ asset('assets/js/config.js') }}"></script>

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
  <script>
    window.OneSignalDeferred = window.OneSignalDeferred || [];
    OneSignalDeferred.push(async function(OneSignal) {
      await OneSignal.init({
        appId: "894a9a7a-0bea-4bf6-95da-31f4ed8d2239",
        notifyButton: {
          enable: true
        }
      });

      const loggedInUserId = "{{ auth()->check() ? auth()->id() : '' }}";

      if (loggedInUserId) {
        try {
          await OneSignal.login(loggedInUserId.toString());
          console.log("✅ External user ID set with login():", loggedInUserId);
        } catch (err) {
          console.error("❌ Gagal login ke OneSignal dengan ID eksternal:", err);
        }
      }
    });
  </script>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->

      @include('layouts.sidebar')

      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">

        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">

          <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">
            @yield('content')
          </div>
          <!-- / Content -->

          <!-- Footer -->
          @include('layouts.footer')
          <!-- / Footer -->

          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

  <!-- Core JS -->

  <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>

  <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>

  <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

  <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

  <!-- Main JS -->

  <script src="{{ asset('assets/js/main.js') }}"></script>

  <!-- Page JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

  <!-- Place this tag before closing body tag for github widget button. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  @yield('scripts')
</body>

</html>