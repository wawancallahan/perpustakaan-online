@extends ('admin.layout.app')

@section ('breadcrumbs')
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Peminjaman</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li class="active"><a href="#">Peminjaman</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section ('content')
    <div class="row">
        <div class="col-md-12">

            @include ('admin.layout.flash')

            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Daftar Peminjaman</strong>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <form action="{{ url()->current() }}" method="GET">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-primary">Filter</button>
                                </div>
                                <input type="text" name="q" class="form-control" placeholder="Cari..." maxlength="255" value="{{ request()->get('q') }}">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Buku</th>
                                <th>Keterlambatan</th>
                                <th>Denda</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tanggal_pinjam_formatted }}</td>
                                    <td>{{ $item->tanggal_kembali_formatted }}</td>
                                    <td>{{ $item->book->judul }}</td>
                                    <td>{!! $item->keterlambatan !!}</td>
                                    <td>{!! $item->denda !!}</td>
                                    <td>{!! $item->status_formatted !!}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Data Tidak Ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $items->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection