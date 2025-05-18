<section id="component-footer">
  <footer class="footer bg-light">
    <div
      class="container-fluid d-flex flex-md-row flex-column justify-content-between align-items-md-center gap-1 container-p-x py-4">
      <div>
        <span class="fw-bold">Kelompok 4 ©</span>
      </div>
      <div>
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
          @csrf
          <a class="btn btn-sm btn-outline-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="icon-base bx bx-log-out-circle icon-sm me-1"></i>Logout
          </a>
        </form>
      </div>
    </div>
  </footer>
</section>