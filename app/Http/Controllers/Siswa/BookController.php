<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use DB;
use Exception;
use App\Http\Requests\BorrowRequest;
use App\Models\Transaction;
use Carbon\Carbon;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $items = Book::filter($request)->isActive()->paginate(10);

        $view = [
            'items' => $items
        ];

        return view('siswa.book.index')->with($view);
    }

    public function borrow($id)
    {
        $item = Book::isActive()->findOrFail($id);

        $view = [
            'item' => $item
        ];

        return view('siswa.book.borrow')->with($view);
    }

    public function borrowStore(BorrowRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $item = Book::isActive()->findOrFail($id);

            $tanggal_pinjam = Carbon::now()->startOfDay();
            $tanggal_kembali = Carbon::parse($request->tanggal_kembali)->startOfDay();

            Transaction::create([
                'tanggal_pinjam' => $tanggal_pinjam,
                'tanggal_kembali' => $tanggal_kembali,
                'book_id' => $item->id,
                'siswa_id' => auth()->user()->siswa->id,
                'status' => 0
            ]);

            $waktu = $tanggal_pinjam->diff($tanggal_kembali)->days;

            DB::commit();

            session()->flash('flash', [
                'type' => 'success',
                'message' => 'Buku berhasil dipinjam dengan waktu ' . $waktu . ' hari'
            ]);

            return redirect()->route('siswa.book.index');

        } catch (Exception $e) {
            session()->flash('flash', [
                'type' => 'danger',
                'message' => $e->getMessage()
            ]);
        }

        return redirect()->back();
    }
}
