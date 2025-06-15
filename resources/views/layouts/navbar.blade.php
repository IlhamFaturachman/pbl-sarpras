<nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
  <!-- Menu toggle button (only visible on mobile) -->
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center justify-content-between w-100" id="navbar-collapse">
    <ul class="navbar-nav flex-row align-items-center">
      <!-- Role badge -->
      <li class="nav-item me-3">
        <span class="badge bg-primary text-white text-uppercase fw-semibold px-3 py-2">
          {{ Auth::user()->getRoleNames()->first() }}
        </span>
      </li>
    </ul>

    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <!-- Notifications -->
      <li class="nav-item dropdown-notification navbar-dropdown dropdown me-3">
        <a class="nav-link dropdown-toggle hide-arrow position-relative d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="dropdown">
          <i class="bx bx-bell" style="font-size: 1.5rem;"></i>
          @if ($unreadCount > 0)
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            style="font-size: 0.65rem; min-width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;">
            {{ $unreadCount }}
          </span>
          @endif
        </a>

        <ul class="dropdown-menu dropdown-menu-end py-0 shadow">
          <li class="dropdown-menu-header border-bottom">
            <div class="dropdown-header d-flex align-items-center py-3">
              <h6 class="mb-0 me-auto">Notifikasi</h6>
            </div>
          </li>
          <li class="dropdown-notifications-list" style="max-height: 300px; overflow-y: auto;">
            <ul class="list-group list-group-flush">
              @forelse($notifikasiList as $notif)
              <li class="list-group-item list-group-item-action dropdown-item {{ !$notif->is_read ? 'bg-light' : '' }}">
                <a href="{{ route('notifikasi.baca', $notif->id) }}" class="d-flex align-items-center gap-2 text-dark text-decoration-none">
                  <i class="bx bx-bell text-primary"></i>
                  <div class="flex-grow-1">
                    <h6 class="mb-0 fw-semibold text-wrap text-break" style="max-width: 300px;">
                      {{ $notif->isi_notifikasi }}
                    </h6>
                    <small class="text-muted">
                      {{ optional($notif->created_at)->setTimezone('Asia/Jakarta')->diffForHumans() }}
                    </small>
                  </div>
                </a>
              </li>
              @empty
              <li class="list-group-item text-center text-muted">Tidak ada notifikasi</li>
              @endforelse
            </ul>
          </li>
        </ul>
      </li>

      <!-- User account dropdown -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <img src="{{ Auth::user()->foto_profile ? asset('storage/' . Auth::user()->foto_profile) : asset('assets/img/avatars/default-avatar.png') }}" alt="user avatar" class="rounded-circle">
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow">
          <li>
            <a class="dropdown-item" href="/profil">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar avatar-online">
                    <img src="{{ Auth::user()->foto_profile ? asset('storage/' . Auth::user()->foto_profile) : asset('assets/img/avatars/default-avatar.png') }}" alt="user avatar" class="rounded-circle">
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-0">{{ Auth::user()->nama_lengkap }}</h6>
                  <small class="text-muted">{{ Auth::user()->email }}</small>
                </div>
              </div>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
              @csrf
              <a class="dropdown-item cursor-pointer" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bx bx-power-off me-2"></i>
                <span class="align-middle">Log Out</span>
              </a>
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>