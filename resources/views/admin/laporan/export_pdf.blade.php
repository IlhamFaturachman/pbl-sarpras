<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Data Kerusakan Fasilitas</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 4px 3px;
        }

        th {
            text-align: left;
            background-color: #f2f2f2;
        }

        .d-block {
            display: block;
        }

        img {
            width: auto;
            height: 80px;
            max-width: 150px;
            max-height: 150px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .p-1 {
            padding: 5px 1px 5px 1px;
        }

        .font-10 {
            font-size: 10pt;
        }

        .font-11 {
            font-size: 11pt;
        }

        .font-12 {
            font-size: 12pt;
        }

        .font-13 {
            font-size: 13pt;
        }

        .border-bottom-header {
            border-bottom: 1px solid;
        }

        .border-all,
        .border-all th,
        .border-all td {
            border: 1px solid black;;
        }

        .status-selesai {
            color: green;
            font-weight: bold;
        }

        .status-proses {
            color: orange;
            font-weight: bold;
        }

        .status-ditolak {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center">
                <img src="{{ $logoSrc }}" width="100" height="100">
            </td>
            <td width="85%">
                <span class="text-center d-block font-11 font-bold mb-1">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</span>
                <span class="text-center d-block font-13 font-bold mb-1">POLITEKNIK NEGERI MALANG</span>
                <span class="text-center d-block font-10">Jl. Soekarno-Hatta No. 9 Malang 65141</span>
                <span class="text-center d-block font-10">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</span>
                <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>

    <h3 class="text-center">LAPORAN DATA KERUSAKAN FASILITAS</h3>
    <table class="border-all">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">ID Laporan</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Pelapor</th>
                <th class="text-center">Sarana</th>
                <th class="text-center">Lokasi</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center">Verifikator</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $l)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $l->laporan_id }}</td>
                    <td>{{ \Carbon\Carbon::parse($l->tanggal_laporan)->format('d/m/Y') }}</td>
                    <td>{{ $l->kerusakan->pelapor->nama ?? '-' }}</td>
                    <td>{{ $l->kerusakan->item->nama }}</td>
                    <td>
                        @if($l->kerusakan->item->ruang)
                        {{ $l->kerusakan->item->ruang->gedung->nama }}, {{ $l->kerusakan->item->ruang->nama }}
                        @elseif($l->kerusakan->item->fasum)
                        {{ $l->kerusakan->item->fasum->nama }}
                        @else
                        -
                        @endif
                    </td>
                    <td>{{ $l->kerusakan->deskripsi_kerusakan ?? '-' }}</td>
                    <td>{{ $l->verifikator->nama ?? '-' }}</td>
                    <td class="
                        @if($l->status_laporan == 'Selesai')
                            status-selesai
                        @elseif(in_array($l->status_laporan, ['Diajukan', 'Disetujui', 'Dikerjakan']))
                            status-proses
                        @else
                            status-ditolak
                        @endif
                    ">
                        @if($l->status_laporan == 'Selesai')
                            Selesai
                        @elseif(in_array($l->status_laporan, ['Diajukan', 'Disetujui', 'Dikerjakan']))
                            Proses
                        @else
                            Ditolak
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; font-size: 10pt;">
        <p><strong>Keterangan Status:</strong></p>
        <ul style="margin: 5px 0;">
            <li><span class="status-selesai">Selesai</span> - Laporan telah ditangani dan selesai</li>
            <li><span class="status-proses">Proses</span> - Laporan sedang dalam proses penanganan</li>
            <li><span class="status-ditolak">Ditolak</span> - Laporan ditolak</li>
        </ul>
    </div>

    <div style="margin-top: 30px; text-align: right; font-size: 10pt;">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>