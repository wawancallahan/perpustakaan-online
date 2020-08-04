@extends ('admin.layout.app')

@section ('breadcrumbs')

@endsection

@section ('content')
     <!-- Widgets  -->
     <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="stat-widget-five">
                        <div class="stat-icon dib flat-color-1">
                            <i class="fa fa-book"></i>
                        </div>
                        <div class="stat-content">
                            <div class="text-left dib">
                                <div class="stat-text"><span class="count">{{ $transactions }}</span></div>
                                <div class="stat-heading">Buku Dipinjam</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">

            @if ( ! $isActive)
                <div class="alert alert-warning">
                    <h4 class="alert-heading">Informasi Akun!</h4>
                    <p class="mb-0">Akun Anda Dalam Tahap Validasi, Mohon Hubungi Petugas Perpustakaan!</p>
                </div>
            @endif

            @foreach ($transactionTelat as $transaction)
                <div class="alert alert-danger">
                    <h4 class="alert-heading">Informasi Pengembalian!</h4>
                    <p>Buku {{ $transaction->book->judul }} harus segera dikembalian!</p>
                    <p class="mb-0">Tanggal Kembali : {{ $transaction->tanggal_kembali_formatted }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection