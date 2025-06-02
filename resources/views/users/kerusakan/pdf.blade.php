<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Kerusakan Fasilitas</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background-color: #f2f2f2;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        h2 {
            text-align: center;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <body>
    <table class="border-bottom-header">
        <tr>
        <td width="15%" class="text-center"><img src="{{ asset('polinema-bw.png') }}"></td>            
        <td width="85%">
                <span class="text-center d-block font-11 font-bold mb-1">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</span>
                <span class="text-center d-block font-13 font-bold mb-1">POLITEKNIK NEGERI MALANG</span>
                <span class="text-center d-block font-10">Jl. Soekarno-Hatta No. 9 Malang 65141</span>
                <span class="text-center d-block font-10">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</span>
                <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>
    <h2>Data Kerusakan Fasilitas</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th>Lokasi Fasilitas</th>
                <th>Deskripsi Kerusakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kerusakans as $index => $kerusakan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kerusakan->item->nama ?? '-' }}</td>
                    <td>
                        @if ($kerusakan->ruang)
                            {{ $kerusakan->ruang->nama }}, {{ $kerusakan->ruang->gedung->nama }}
                        @elseif ($kerusakan->fasum)
                            {{ $kerusakan->fasum->nama }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $kerusakan->deskripsi_kerusakan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
