@extends ('admin.layout.app')

@section ('breadcrumbs')
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>User</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">User</a></li>
                                <li class="active"><a href="#">Edit User</a></li>
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
                <div class="card-header">Edit User</div>
                <form action="{{ route('admin.user.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label class="form-control-label">Nama</label>
                            <input type="text" name="name" placeholder="Nama" class="form-control" value="{{ $item->name }}" required >
                        </div>
                        
                        <div class="form-group">
                            <label class="form-control-label">Username</label>
                            <input type="text" name="username" placeholder="Username" class="form-control" value="{{ $item->username }}" required >
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Password</label>
                            <input type="password" name="password" placeholder="Password" class="form-control">
                            <div class="alert alert-info mt-3">
                                Password tidak usah diisi jika tidak diganti!
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Tipe</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">Pilih Tipe</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ $role->id == $item->roles->first()->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-5">
                            <button type="button" class="btn btn-primary" id="simpan">Simpan</button>
                            <a href="{{ route('admin.user.index') }}" class="btn btn-default">Batal</a>
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
            $('#role').select2({
                placeholder: 'Pilih Tipe',
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