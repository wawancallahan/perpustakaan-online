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
                                <th>Nis/Siswa</th>
                                <th>Keterlambatan</th>
                                <th>Denda</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tanggal_pinjam_formatted }}</td>
                                    <td>{{ $item->tanggal_kembali_formatted }}</td>
                                    <td>{{ $item->book->judul }}</td>
                                    <td>{{ $item->siswa->nis }}/<br>{{ $item->siswa->name }}</td>
                                    <td>{!! $item->keterlambatan !!}</td>
                                    <td>{!! $item->denda !!}</td>
                                    <td>{!! $item->status_formatted !!}</td>
                                    <td>
                                        <button type="button" data-link="{{ route('admin.transaction.return-book', $item->id) }}" class="btn btn-primary btn-sm kembalikan"> <i class="fa fa-location-arrow"></i> Pengembalian</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Data Tidak Ditemukan</td>
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
        jQuery(function ($) {
            $('.kembalikan').on('click', function (e) {
                e.preventDefault();
                var el = $(this);

                swal({
                    title: "Apakah anda yakin buku ini telah kembali?",
                    icon: "warning",
                    text: "Data akan tersimpan di Database!",
                    buttons: true,
                }).then(function () {
                    var formdata = document.createElement("form");
                    formdata.setAttribute("method", "POST");
                    formdata.setAttribute("action", el.data('link'));

                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", "_token");
                    hiddenField.setAttribute("value", "{{ csrf_token() }}");

                    var hiddenField2 = document.createElement("input");
                    hiddenField2.setAttribute("type", "hidden");
                    hiddenField2.setAttribute("name", "_method");
                    hiddenField2.setAttribute("value", "PATCH");

                    formdata.appendChild(hiddenField);
                    formdata.appendChild(hiddenField2);
                    document.body.appendChild(formdata);
                    formdata.submit();
                });
            });
        });
    </script>
@endsection