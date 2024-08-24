<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        .text-center {
            text-align: center;
        }

        .h1 {
            font-size: 28px;
            letter-spacing: 1px;
        }

        .h2 {
            font-size: 24px;
            letter-spacing: 1px;
        }

        .h3 {
            font-size: 20px;
            letter-spacing: 1px;
        }

        .fw-bold {
            font-weight: bold;
        }

        .mb-0 {
            margin-bottom: 0px;
        }

        .mb-1 {
            margin-bottom: 20px;
        }

        .mt-0 {
            margin-top: 0px;
        }

        .mt-1 {
            margin-top: 20px;
        }

        table {
            width: 100%;
        }

        .table {
            border-collapse: collapse
        }

        .table td,
        .table th {
            text-align: center;
            padding: 5px 10px;
            border: 1px solid #333;
        }
    </style>
</head>

<body>
    <p class="text-center h1 fw-bold mb-0">
        Laporan {{ $title }}
    </p>
    @if (isset($tahun))
        <h1 class="text-center h3 mt-0">
            Tahun {{ $tahun }}
        </h1>
    @endif
    <p>
        Data {{ strtolower($title) }} dibawah ini merupakan data hasil proses pengolahan data yang dilakukan oleh
        sistem. Adapun data {{ strtolower($title) }}
        @if (isset($tahun))
            Tahun {{ $tahun }}
        @endif
        ialah:
    </p>
    @if ($title != 'Inventarisasi Tahunan')
        <table class="table">
            <thead>
                <tr>
                    <th>Kode Aset</th>
                    <th>Nama</th>
                    <th>Tahun Pengadaan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $item->id_item }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->inventaris->tahun_pengadaan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            <h1 class="text-center h3 mb-0 mt-0">
                                Data Kosong
                            </h1>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Kode Inventarisasi</th>
                    <th>Jenis Inventarisasi</th>
                    <th>Jumlah Aset</th>
                    <th>Tahun</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $item->kode_inventarisasi }}</td>
                        <td>{{ ucwords($item->jenis_inventarisasi) }}</td>
                        <td>
                            {{ $item->jenis_inventarisasi == 'masuk' ? $item->aset_count : $item->inventaris_keluar_count }}
                        </td>
                        <td>{{ $item->tahun_pengadaan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <h1 class="text-center h3 mb-0 mt-0">
                                Data Kosong
                            </h1>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif
</body>

</html>
