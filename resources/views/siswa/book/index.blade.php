@extends ('admin.layout.app')

@section ('breadcrumbs')
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Buku</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li class="active"><a href="#">Buku</a></li>
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
                    <strong class="card-title">Daftar Buku</strong>
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
                                <th>ISBN</th>
                                <th>Judul</th>
                                <th>Tahun</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->isbn }}</td>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ $item->tahun }}</td>
                                    <td>{{ $item->pengarang }}</td>
                                    <td>{{ $item->penerbit }}</td>
                                    <td>
                                        <a href="{{ route('siswa.book.borrow', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-rocket"></i> Pinjam</a>
                                    </td>
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

@section('js')
    <script>
        @if(session()->get('flash.print') !== null)
            window.open('{{ session()->get("flash.print") }}', '_blank');
        @endif
    </script>
@endsection