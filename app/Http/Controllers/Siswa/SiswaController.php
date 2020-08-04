<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class SiswaController extends Controller
{
    public function dashboard() {

        $transactions = Transaction::onThisSiswa()->count();

        $today = Carbon::now();

        $transactionTelat = Transaction::with('book')
                                        ->where('tanggal_kembali', '<=', $today->toDateString())
                                        ->get();

        $isActive = auth()->user()->is_active == 1;

        $view = [
            'transactions' => $transactions,
            'transactionTelat' => $transactionTelat,
            'isActive' => $isActive
        ];

        return view('siswa.dashboard')->with($view);
    }
}
