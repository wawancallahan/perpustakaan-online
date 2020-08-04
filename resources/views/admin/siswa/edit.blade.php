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
                                <li><a href="#">Siswa</a></li>
                                <li class="active"><a href="#">Tambah Siswa</a></li>
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
                <div class="card-header">Tambah Siswa</div>
                <form action="{{ route('admin.siswa.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body card-block">
                        <div class="form-group">
                            <label class="form-control-label">NIS</label>
                            <input type="text" name="nis" placeholder="NIS" class="form-control" value="{{ $item->nis }}" required >
                        </div>
                        
                        <div class="form-group">
                            <label class="form-control-label">Nama</label>
                            <input type="text" name="name" placeholder="Nama" class="form-control" value="{{ $item->name }}" required >
                        </div>
                        
                        <div class="form-group">
                            <label class="form-control-label">Kelas</label>
                            <select name="kelas_id" id="kelas" class="form-control" required>
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelas as $kelasItem)
                                    <option value="{{ $kelasItem->id }}" {{ $item->kelas_id == $kelasItem->id ? 'selected' : '' }}>{{ $kelasItem->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Jenis Kelamin</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ $item->gender == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="P" {{ $item->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Telepon</label>
                            <input type="text" name="phone" placeholder="Telepon" class="form-control" value="{{ $item->phone }}" required >
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Alamat</label>
                            <textarea name="address" class="form-control" id="" rows="4" placeholder="Alamat">{{ $item->address }}</textarea>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label class="form-control-label">Password</label>
                            <input type="password" name="password" placeholder="Password" class="form-control">
                            <div class="alert alert-info mt-3">
                                Password tidak usah diisi jika tidak diganti!
                            </div>
                        </div>

                        <div class="form-group mt-5">
                            <button type="button" class="btn btn-primary" id="simpan">Simpan</button>
                            <a href="{{ route('admin.siswa.index') }}" class="btn btn-default">Batal</a>
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
            $('#gender').select2({
                placeholder: 'Pilih Jenis Kelamin',
                allowClear: false,
                width: '100%',
                theme: "bootstrap4"
            });

            $('#kelas').select2({
                placeholder: 'Pilih Kelas',
                allowClear: false,
                width: '100%',
                theme: "bootstrap4"
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