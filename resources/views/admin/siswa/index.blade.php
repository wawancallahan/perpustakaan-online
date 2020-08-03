@extends ('admin.layout.app')

@section ('breadcrumbs')
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Siswa</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li class="active"><a href="#">Siswa</a></li>
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

            <div class="form-group">
                <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Siswa</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Daftar Siswa</strong>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Angkatan</th>
                                    <th>Kelas</th>
                                    <th>JK</th>
                                    <th>Telepon</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nis }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->generation }}</td>
                                        <td>{{ $item->class }}</td>
                                        <td>{{ $item->gender_formatted }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>{!! $item->status_formatted !!}</td>
                                        <td>
                                            @if ($item->status == 0)
                                                <button type="button" data-link="{{ route('admin.siswa.active', $item->id) }}" class="btn btn-primary aktif btn-sm">Aktifkan</button>
                                            @elseif ($item->status == 1)
                                                <button type="button" data-link="{{ route('admin.siswa.unactive', $item->id) }}" class="btn btn-warning non-aktif btn-sm">NonAktifkan</button>
                                            @endif
                                            <a href="{{ route('admin.siswa.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                            <button type="button" data-link="{{ route('admin.siswa.destroy', $item->id) }}" class="btn btn-danger btn-sm hapus">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Data Tidak Ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $items->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        jQuery(function ($) {
            $('.aktif').on('click', function (e) {
                e.preventDefault();
                var el = $(this);

                swal({
                    title: "Apakah anda yakin untuk mengaktif data ini?",
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

            $('.non-aktif').on('click', function (e) {
                e.preventDefault();
                var el = $(this);

                swal({
                    title: "Apakah anda yakin untuk mengnonaktifkan data ini?",
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

            $('.hapus').on('click', function (e) {
                e.preventDefault();
                var el = $(this);

                swal({
                    title: "Apakah anda yakin untuk menghapus data ini?",
                    icon: "warning",
                    text: "Data tidak dapat dikembalian setelah terhapus!",
                    dangerMode: true,
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
                    hiddenField2.setAttribute("value", "DELETE");

                    formdata.appendChild(hiddenField);
                    formdata.appendChild(hiddenField2);
                    document.body.appendChild(formdata);
                    formdata.submit();
                });
            });
        });
    </script>
@endsection