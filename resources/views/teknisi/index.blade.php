@extends('layouts.app')

@section('content')

<!-- Flash Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Laporan Penugasan Perbaikan Fasilitas</h5>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th><strong>Tanggal</strong></th>
                    <th><strong>Nama Fasilitas</strong></th>
                    <th><strong>Lokasi Fasilitas</strong></th>
                    <th class="text-center"><strong>Status Perbaikan</strong></th>
                    <th class="text-center"><strong>Actions</strong></th>
                </tr>
            </thead>
            <tbody>
                @foreach($penugasans as $penugasan)
                    <tr>
                        <td>{{ $penugasan->laporan->tanggal_laporan }}</td>
                        <td>{{ $penugasan->laporan->kerusakan->item->nama }}</td>
                        <td>
                            @php
                                $kerusakan = $penugasan->laporan->kerusakan;
                            @endphp
                            @if ($kerusakan->ruang)
                                {{ $kerusakan->ruang->nama }}, {{ $kerusakan->ruang->gedung->nama }}
                            @elseif ($kerusakan->fasum)
                                {{ $kerusakan->fasum->nama }}
                            @else
                                -
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if ($penugasan->status_penugasan == 'Progress')
                                <span style="color: #007bff; border: 1px solid #007bff; padding: 4px 8px; border-radius: 5px; display: inline-block; width: 100px;">
                                    Progress
                                </span>
                            @elseif ($penugasan->status_penugasan == 'Selesai')
                                <span style="color: #28a745; border: 1px solid #28a745; padding: 4px 8px; border-radius: 5px; display: inline-block; width: 100px;">
                                    Selesai
                                </span>
                            @elseif ($penugasan->status_penugasan == 'Revisi')
                                <span style="color: #dc3545; border: 1px solid #dc3545; padding: 4px 8px; border-radius: 5px; display: inline-block; width: 100px;">
                                    Revisi
                                </span>
                            @elseif ($penugasan->status_penugasan == 'Menunggu')
                                <span style="color: #ffc107; border: 1px solid #ffc107; padding: 4px 8px; border-radius: 5px; display: inline-block; width: 100px;">
                                    Menunggu
                                </span>
                            @else
                                <span style="display: inline-block; width: 100px;">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-primary detail-penugasan" data-id="{{ $penugasan->penugasan_id }}">Detail</button>
                                @if ($penugasan->status_penugasan === null)
                                    <button type="button" class="btn btn-sm btn-success" style="width: 100px;" onclick="showKerjakanModal('{{ $penugasan->penugasan_id }}')">Kerjakan</button>
                                @elseif ($penugasan->status_penugasan === 'Progress' || $penugasan->status_penugasan === 'Revisi')
                                    <button type="button" class="btn btn-sm btn-warning report-penugasan" data-id="{{ $penugasan->penugasan_id }}" style="width: 100px;">Lapor</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-3 me-3">
        @if ($penugasans->hasPages())
            <x-pagination :paginator="$penugasans" />
        @endif
    </div>
</div>

@include('teknisi.kerjakan')
@include('teknisi.report')

<script>
    
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            Swal.fire({
                title: "Berhasil",
                text: "{{ session('success') }}",
                icon: "success",
                timer: 3000
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: "Gagal",
                text: "{{ session('error') }}",
                icon: "error"
            });
        @endif
        
        // Detail button
        $('.detail-penugasan').on('click', function () {
            const penugasanId = $(this).data('id');
            $.ajax({
                url: "{{ url('teknisi/penugasan') }}/" + penugasanId + "/show",
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    const ruang = response.ruang || {};
                    const gedung = response.gedung || {};

                    $('#detail_ruang_id').text(ruang.ruang_id ?? '-');
                    $('#detail_kode').text(ruang.kode ?? '-');
                    $('#detail_nama').text(ruang.nama ?? '-');
                    $('#detail_gedungKode').text(gedung.kode ?? '-');
                    $('#detail_gedungNama').text(gedung.nama ?? '-');
                    $('#detail_lantai').text(ruang.lantai ?? '-');

                    $('#detailRuang').modal('show');
                },
                error: function () {
                    Swal.fire('Error', 'Gagal mengambil detail penugasan.', 'error');
                }
            });
        });

        // Handle report button click
        $('.report-penugasan').on('click', function () {
            const penugasanId = $(this).data('id');

            $.ajax({
                url: "{{ url('teknisi/penugasan') }}/" + penugasanId + "/report",
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    const penugasan = response.penugasan;

                    // Set form action
                    $('#form-report').attr('action', "{{ url('teknisi/penugasan') }}/" + penugasanId + "/report");

                    $('#reportPenugasan').modal('show');
                },
                error: function (xhr) {
                    Swal.fire({
                        title: "Error",
                        text: "Gagal mengambil data penugasan",
                        icon: "error"
                    });
                }
            });
        });

        // Preview image sebelum upload
        $('#bukti_perbaikan').on('change', function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(this.files[0]);
            } else {
                $('#preview-image').hide();
            }
        });
    });
</script>

@endsection
