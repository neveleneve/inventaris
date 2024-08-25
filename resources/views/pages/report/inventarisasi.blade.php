<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pencatatan Inventaris {{ $jenis }}</title>
    <style>
        .text-center {
            text-align: center;
        }

        .text-indent {
            text-indent: 50px;
        }

        .text-justify {
            text-align: justify;
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

        .fw-light {
            font-weight: lighter;
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

        .table {
            width: 100%;
            border-collapse: collapse
        }

        .table td,
        .table th {
            text-align: center;
            padding: 5px 10px;
            border: 1px solid #333;
        }

        .w-25 {
            width: 25%;
        }

        .w-50 {
            width: 50%;
        }

        .w-75 {
            width: 75%;

        }
    </style>
</head>

<body>
    <p class="text-center h1 fw-bold mb-0">
        Laporan Inventarisasi {{ $jenis }}
    </p>
    <p class="text-indent text-justify">
        Inventarisasi {{ $inventaris['jenis'] }} ini mencatat semua item yang telah di{{ $inventaris['jenis'] }}kan
        dalam periode tertentu. Setiap barang telah diperiksa dan dipastikan untuk didistribusikan sesuai dengan
        kebutuhan operasional. Laporan ini memuat informasi kode, jenis, dan tahun inventarisasi untuk memastikan
        ketertiban dan akurasi data yang ada.
    </p>
    <p class="text-indent text-justify">
        Adapun data yang dimaksud akan dijelaskan pada pernyataan sebagai berikut:
    </p>
    <table class="w-75 text-indent">
        <tbody>
            <tr>
                <td class="fw-bold">Kode Inventarisasi</td>
                <td>:</td>
                <td>{{ $inventaris['kode'] }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Jenis Inventarisasi</td>
                <td>:</td>
                <td>{{ ucwords($inventaris['jenis']) }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Tahun Inventarisasi</td>
                <td>:</td>
                <td>{{ $inventaris['tahun'] }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Diverifikasi Pada</td>
                <td>:</td>
                <td>{{ date('d F Y, H:i:s', strtotime($inventaris['verifikasi'])) }}</td>
            </tr>
        </tbody>
    </table>
    <p class="text-indent text-justify">
        Informasi lebih lanjut mengenai data aset pencatatan inventaris tercantum dalam tabel berikut:
    </p>
    <table class="table">
        <thead>
            <tr>
                <th>Kode Aset</th>
                <th>Nama Aset</th>
                <th>Jenis Aset</th>
                @if ($inventaris['jenis'] == 'keluar')
                    <th>Keterangan</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($aset as $item)
                <tr>
                    <td>{{ $item['kode'] }}</td>
                    <td>{{ $item['nama'] }}</td>
                    <td>{{ $item['jenis'] }}</td>
                    @if ($inventaris['jenis'] == 'keluar')
                        <td>{{ $item['keterangan'] }}</td>
                    @endif
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</body>

</html>
