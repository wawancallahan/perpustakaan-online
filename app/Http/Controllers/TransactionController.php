<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Config;
use DB;
use Exception;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $denda = Config::where('name', 'denda')->first()->value ?? 0;

        $items = Transaction::with(['book', 'siswa'])->filter($request)->orderBy('status', 'asc')->orderBy('tanggal_kembali')->paginate(10);

        $items->getCollection()->transform(function ($item) use ($denda) {
            $keterlambatan_hari = $item->tanggal_pinjam->startOfDay()->gt($item->tanggal_kembali) 
                                ? $item->tanggal_pinjam->diff($item->tanggal_kembali->startOfDay())->days 
                                : 0;

            $item->keterlambatan = '<span class="badge badge-' . ($keterlambatan_hari > 0 ? "danger" : "success") . '">' . $keterlambatan_hari . ' hari</span>';
            $item->denda = '<span class="badge badge-' . ($keterlambatan_hari > 0 ? "danger" : "success") . '">Rp. ' . ($keterlambatan_hari * $denda) . '</span>';

            return $item;
        });

        $view = [
            'items' => $items
        ];

        return view('admin.transaction.index')->with($view);
    }

    public function returnBook($id)
    {
        DB::beginTransaction();
        
        try {
            $item = Transaction::find($id);

            if ($item === null) {
                session()->flash('flash', [
                    'type' => 'danger',
                    'message' => 'Data tidak ditemukan'
                ]);

                return redirect()->back();
            }

            $item->update([
                'status' => 1
            ]);

            DB::commit();

            session()->flash('flash', [
                'type' => 'success',
                'message' => 'Data berhasil disimpan'
            ]);
        } catch (Exception $e) {
            session()->flash('flash', [
                'type' => 'danger',
                'message' => $e->getMessage()
            ]);
        }

        return redirect()->back();
    }
}
