<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Data Kerusakan Fasilitas</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 30px;
            font-size: 12pt;
        }

        .header-table {
            width: 100%;
        }

        .header-table td {
            vertical-align: top;
        }

        .logo {
            height: 90px;
        }

        .instansi-text {
            text-align: center;
            line-height: 1.4;
        }

        .instansi-text span {
            display: block;
        }

        hr.garis-bawah {
            border: 1px solid black;
            margin-top: 5px;
        }

        h3 {
            text-align: center;
            margin: 20px 0 10px 0;
            font-weight: bold;
            text-transform: uppercase;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        table.data th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10pt;
        }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td width="15%" class="text-center">
                <img src="{{ $imageSrc }}" class="logo">
            </td>
            <td width="85%" class="instansi-text">
                <span style="font-size:13pt; font-weight:bold;">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</span>
                <span style="font-size:14pt; font-weight:bold;">POLITEKNIK NEGERI MALANG</span>
                <span style="font-size:11pt;">Jl. Soekarno-Hatta No. 9 Malang 65141</span>
                <span style="font-size:11pt;">Telepon (0341) 404424 Pes. 101–105, 0341–404420, Fax. (0341) 404420</span>
                <span style="font-size:11pt;">Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>
    <hr class="garis-bawah">

    <h3>Laporan Data Kerusakan Fasilitas</h3>

    <table class="data">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Item</th>
                <th>Lokasi Fasilitas</th>
                <th>Deskripsi Kerusakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kerusakans as $index => $kerusakan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
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

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
