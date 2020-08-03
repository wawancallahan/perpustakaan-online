<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Register Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('assets/css/normalize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pe-icon-7-stroke.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
</head>
<body class="bg-dark">

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="#">
                        <img class="align-content" src="images/logo.png" alt="">
                    </a>
                </div>
                <div class="login-form">
                    
                    @include ('admin.layout.flash')

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-control-label">NIS</label>
                            <input type="text" name="nis" placeholder="NIS" class="form-control" required >
                        </div>
                        
                        <div class="form-group">
                            <label class="form-control-label">Nama</label>
                            <input type="text" name="name" placeholder="Nama" class="form-control" required >
                        </div>
                        
                        <div class="form-group">
                            <label class="form-control-label">Angkatan</label>
                            <input type="text" name="generation" placeholder="Angkatan" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-control-label">Kelas</label>
                            <input type="text" name="class" placeholder="Kelas" class="form-control" required >
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Jenis Kelamin</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Telepon</label>
                            <input type="text" name="phone" placeholder="Telepon" class="form-control" required >
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Alamat</label>
                            <textarea name="address" class="form-control" id="" rows="4" placeholder="Alamat"></textarea>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label class="form-control-label">Password</label>
                            <input type="password" name="password" placeholder="Password" class="form-control" required >
                        </div>
                        <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Register</button>
                    </form>
                    <div class="register-link m-t-15 text-center mt-4">
                        <p>Jika sudah punya akun, Silahkan klik <a href="{{ route('login') }}">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.matchHeight.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.full.min.js') }}"></script>

    <script>
        jQuery(function($) {
            $('#gender').select2({
                placeholder: 'Pilih Jenis Kelamin',
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

</body>
</html>
