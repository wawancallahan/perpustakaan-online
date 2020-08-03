@extends ('admin.layout.app')

@section ('breadcrumbs')
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Konfig</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Konfig</a></li>
                                <li class="active"><a href="#">Edit Konfig</a></li>
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
                <div class="card-header">Edit Konfig</div>
                <form action="{{ route('admin.config.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body card-block">
                        <div class="form-group">
                            <label class="form-control-label">Nama</label>
                            <input type="text" class="form-control" value="{{ $item->name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Isi</label>
                            <input type="text" name="value" placeholder="Isi" class="form-control" value="{{ $item->value }}" required >
                        </div>
                        <div class="form-group mt-5">
                            <button type="button" class="btn btn-primary" id="simpan">Simpan</button>
                            <a href="{{ route('admin.config.index') }}" class="btn btn-default">Batal</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>
        jQuery(function($) {
            $('#simpan').on('click', function (e) {
                e.preventDefault();

                var form = $(e.currentTarget).closest('form');

                var checkVal = $(form)[0].checkValidity();

                if(checkVal) {
                    swal({
                        title: "Apakah Data Ini Sudah Benar?",
                        text: "Data Akan Disimpan Ke Database!",
                        icon: "warning",
                        buttons: true,
                    })
                    .then((willCreated) => {
                        if (willCreated) {
                            form.submit();
                        }
                    });
                    
                } else {
                    $(form)[0].reportValidity();
                }
            });
        });
    </script>
@endsection