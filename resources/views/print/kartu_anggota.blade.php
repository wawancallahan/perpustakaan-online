<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets/css/normalize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <style>
        .container-card {
            width: 13cm;
            border: 1px solid #000000;
            border-radius: 5px;
            padding: 15px;
        }

        .box-logo {
            position: relative;
        }

        .logo-kartu {
            position: relative;
            transform: translate(10%, -5%);
            width: 5em;
        }
    </style>
</head>
<body>
    <div class="container-card">
        <div class="row mb-1">
            <div class="col-2">
                <div class="box-logo">
                    <img src="{{ asset('images/logo.jpg') }}" alt="" class="logo-kartu">
                </div>
            </div>
            <div class="col-10 text-center">
                <h4>Kartu Anggota Perpustakaan</h4>
                <p class="m-b">SMA NEGERI 2 MARANGKAYU</p>
            </div>
        </div>
        <hr class="mb-0 mt-0">
        <div class="mt-1">
            <div class="row">
                <div class="col-3">NIS</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $item->nis }}</div>
            </div>
            <div class="row">
                <div class="col-3">Nama</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $item->name }}</div>
            </div>
            <div class="row">
                <div class="col-3">Kelas</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $item->kelas->name ?? '-' }}</div>
            </div>
            <div class="row">
                <div class="col-3">Telepon</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $item->phone }}</div>
            </div>
            <div class="row">
                <div class="col-3">Gender</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $item->gender_formatted }}</div>
            </div>
            <div class="row">
                <div class="col-3">Alamat</div>
                <div class="col-1">:</div>
                <div class="col-8">
                    {{ $item->address }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>