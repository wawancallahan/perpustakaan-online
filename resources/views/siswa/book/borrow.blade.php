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
                                <li class="active"><a href="#">Pinjam Buku</a></li>
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
                <div class="card-header">Detail Buku</div>
                <div class="card-body card-block">
                    <div class="form-group">
                        <label class="form-control-label">ISBN</label>
                        <p class="form-control">{{ $item->isbn }}</p>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-control-label">Judul</label>
                        <p class="form-control">{{ $item->judul }}</p>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-control-label">Tahun</label>
                        <p class="form-control">{{ $item->tahun }}</p>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-control-label">Pengarang</label>
                        <p class="form-control">{{ $item->pengarang }}</p>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">Penerbit</label>
                        <p class="form-control">{{ $item->penerbit }}</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Data Pinjaman</div>
                <div class="card-body card-block">
                    <form action="{{ route('siswa.book.borrow', $item->id) }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-control-label">Tanggal Kembali</label>
                            <input type="text" name="tanggal_kembali" placeholder="Tanggal Kembali" class="form-control" required id="tanggal_kembali">
                        </div>

                        <div class="form-group mt-5">
                            <button type="button" class="btn btn-primary" id="simpan">Simpan</button>
                            <a href="{{ route('siswa.book.index') }}" class="btn btn-default">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>
        jQuery(function($) {
            $('#tanggal_kembali').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true
            });

            $('#simpan').on('click', function (e) {
                e.preventDefault();

                var form = $(e.currentTarget).closest('form');

                var checkVal = $(form)[0].checkValidity();

                if(checkVal) {
                    swal({
                        title: "Apakah Data Ini Sudah Benar?",
                        text: "Lakukan Peminjaman Buku!",
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