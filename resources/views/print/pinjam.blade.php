<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets/css/normalize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <style>
        .container-box {
            width: 40em;
            border: 1px solid #000000;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container-box">
        <div class="mb-2">
            <div class="text-center">
                <h4>Peminjaman Buku</h4>
                <p class="m-b">SMP Negeri Zero One Kamen Rider</p>
            </div>
        </div>
        <div class="mt-1">
            <div class="row">
                <div class="col-3">NIS</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $item->siswa->nis }}</div>
            </div>
            <div class="row">
                <div class="col-3">Nama</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $item->siswa->name }}</div>
            </div>
            <div class="row">
                <div class="col-3">Angkatan</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $item->siswa->generation }}</div>
            </div>
            <div class="row">
                <div class="col-3">Kelas</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $item->siswa->class }}</div>
            </div>
            <div class="row">
                <div class="col-3">Telepon</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $item->siswa->phone }}</div>
            </div>
            <div class="row">
                <div class="col-3">Gender</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $item->siswa->gender_formatted }}</div>
            </div>
            <div class="row">
                <div class="col-3">Alamat</div>
                <div class="col-1">:</div>
                <div class="col-8">
                    {{ $item->siswa->address }}
                </div>
            </div>
            <div class="row">
                <div class="col-3">Tanggal Pinjam</div>
                <div class="col-1">:</div>
                <div class="col-8">
                    {{ $item->tanggal_pinjam_formatted }}
                </div>
            </div>
            <div class="row">
                <div class="col-3">Tanggal Kembali</div>
                <div class="col-1">:</div>
                <div class="col-8">
                    {{ $item->tanggal_kembali_formatted }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>