<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="/" class="app-brand-link">
        <div style="display: flex; align-items: center;">
          <img src="{{ asset('assets/img/logo.png') }}" alt="" style="width: 65px; height: 65px; margin-right: 8px;">
          <span style="font-size: 1.5rem; font-weight: bold; color: #333;">Sarpras</span>
        </div>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
      </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboard -->
      @role('admin')
        <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a
            href="{{ route('admin.dashboard') }}"
          @endrole
      @role('mahasiswa|dosen|tendik')
        <li class="menu-item {{ request()->routeIs('users.dashboard') ? 'active' : '' }}">
        <a
            href="{{ route('users.dashboard') }}"
          @endrole
          class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-smile"></i>
          <div class="text-truncate" data-i18n="Support">Dashboard</div>
        </a>
      </li>
      @role('admin')
      <li class="menu-item {{ request()->routeIs('data.*') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-home-smile"></i>
          <div class="text-truncate" data-i18n="Dashboards">Data</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ request()->routeIs('data.user') ? 'active' : '' }}">
            <a href="{{ route('data.user') }}" class="menu-link">
              <div class="text-truncate" data-i18n="Analytics">Data User</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('data.fasilitas') ? 'active' : '' }}">
            <a href="{{ route('data.fasilitas') }}" class="menu-link">
              <div class="text-truncate" data-i18n="CRM">Data Fasilitas</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('data.ruang') ? 'active' : '' }}">
            <a href="{{ route('data.ruang') }}" class="menu-link">
              <div class="text-truncate" data-i18n="CRM">Data Ruang</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('data.gedung') ? 'active' : '' }}">
            <a href="{{ route('data.gedung') }}" class="menu-link">
              <div class="text-truncate" data-i18n="CRM">Data Gedung</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('data.periode') ? 'active' : '' }}">
            <a href="{{ route('data.periode') }}" class="menu-link">
              <div class="text-truncate" data-i18n="CRM">Data Periode</div>
            </a>
          </li>
        </ul>
      </li>      
      @endrole
      @role('sarpas')
      <li class="menu-item">
        <a
          href="#"
          class="menu-link">
          <i class="menu-icon tf-icons bx bx-file"></i>
          <div class="text-truncate" data-i18n="Documentation">Laporan</div>
        </a>
      </li>
      @endrole
    </ul>
  </aside>