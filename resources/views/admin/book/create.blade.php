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
                                <li><a href="#">Buku</a></li>
                                <li class="active"><a href="#">Tambah Buku</a></li>
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
                <div class="card-header">Tambah Buku</div>
                <form action="{{ route('admin.book.store') }}" method="POST">
                    @csrf

                    <div class="card-body card-block">
                        <div class="form-group">
                            <label class="form-control-label">ISBN</label>
                            <input type="text" name="isbn" placeholder="ISBN" class="form-control" required >
                        </div>
                        
                        <div class="form-group">
                            <label class="form-control-label">Judul</label>
                            <input type="text" name="judul" placeholder="Judul" class="form-control" required >
                        </div>
                        
                        <div class="form-group">
                            <label class="form-control-label">Tahun</label>
                            <input type="text" name="tahun" placeholder="Tahun" class="form-control" required  id="tahun">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-control-label">Pengarang</label>
                            <input type="text" name="pengarang" placeholder="Pengarang" class="form-control" required >
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Penerbit</label>
                            <input type="text" name="penerbit" placeholder="Penerbit" class="form-control" required >
                        </div>

                        <div class="form-group mt-5">
                            <button type="button" class="btn btn-primary" id="simpan">Simpan</button>
                            <a href="{{ route('admin.book.index') }}" class="btn btn-default">Batal</a>
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
            $('#tahun').datepicker({
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years",
                autoclose: true
            });

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