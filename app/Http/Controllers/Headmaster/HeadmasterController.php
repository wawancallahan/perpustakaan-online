<?php

namespace App\Http\Controllers\Headmaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Book;
use App\Models\Siswa;
use App\User;

class HeadmasterController extends Controller
{
    public function dashboard() {

        $transactions = Transaction::count();
        $books = Book::count();
        $petugas = User::role('petugas')->count();
        $siswas = Siswa::count();

        $view = [
            'transactions' => $transactions,
            'books' => $books,
            'petugas' => $petugas,
            'siswas' => $siswas
        ];

        return view('headmaster.dashboard')->with($view);
    }
}
