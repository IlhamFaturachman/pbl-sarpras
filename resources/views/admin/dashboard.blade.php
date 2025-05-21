@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <!-- Chart Lebar Penuh -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="m-0 me-2">Total Perbaikan</h5>
        </div>
        <div class="card-body">
          <div id="TotalPerbaikanChart" style="height: 350px;"></div>
        </div>
      </div>
    </div>
  </div>

<!-- Card Growth (3 buah) -->
<div class="row">
  @php
    $labels = ['Gedung', 'Ruang', 'Fasum'];
    $values = [78, 65, 88];
    $progress = [62, 50, 75];
  @endphp

  @for ($i = 0; $i < 3; $i++)
  <div class="col-md-4 mb-4">
    <div class="card h-100">
      <div class="card-body d-flex align-items-center flex-column py-4">
        <!-- Dropdown Tahun -->
        <div class="text-center mb-3">
          <div class="btn-group">
            <button type="button" class="btn btn-outline-primary">2024</button>
            <button
              type="button"
              class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">2023</a></li>
              <li><a class="dropdown-item" href="#">2022</a></li>
            </ul>
          </div>
        </div>

        <!-- Radial Chart -->
        <div id="growthChart{{ $i+1 }}" class="mb-3"></div>

        <!-- Label -->
        <h6 class="mb-0">{{ $values[$i] }}% Growth</h6>
        <small class="text-muted">{{ $progress[$i] }}% Progress Perbaikan {{ $labels[$i] }}</small>
      </div>
    </div>
  </div>
  @endfor
</div>

</div>
@endsection
