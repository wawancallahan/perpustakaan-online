<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use DB;
use App\Http\Requests\BookRequest;
use Exception;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Book::paginate(10);

        $view = [
            'items' => $items
        ];

        return view('admin.book.index')->with($view);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.book.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        DB::beginTransaction();

        try {
            $hasIsbnDuplicate = Book::where('isbn', $request->isbn)->count() > 0;

            if ($hasIsbnDuplicate) {
                session()->flash('flash', [
                    'type' => 'danger',
                    'message' => 'Nomor ISBN telah ada sebelumnya'
                ]);

                return redirect()->back();
            }

            Book::create([
                'isbn' => $request->isbn,
                'judul' => $request->judul,
                'tahun' => $request->tahun,
                'pengarang' => $request->pengarang,
                'penerbit' => $request->penerbit,
                'active' => 1,
                'created_by' => auth()->user()->id
            ]);

            DB::commit();

            session()->flash('flash', [
                'type' => 'success',
                'message' => 'Data berhasil disimpan'
            ]);

            return redirect()->route('admin.book.index');
        } catch (Exception $e) {
            session()->flash('flash', [
                'type' => 'danger',
                'message' => $e->getMessage()
            ]);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Book::findOrFail($id);

        $view = [
            'item' => $item
        ];

        return view('admin.book.edit')->with($view);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $hasIsbnDuplicate = Book::where('isbn', $request->isbn)->whereNotIn('id', [$id])->count() > 0;

            if ($hasIsbnDuplicate) {
                session()->flash('flash', [
                    'type' => 'danger',
                    'message' => 'Nomor ISBN telah ada sebelumnya'
                ]);

                return redirect()->back();
            }

            $item = Book::findOrFail($id);

            $item->update([
                'isbn' => $request->isbn,
                'judul' => $request->judul,
                'tahun' => $request->tahun,
                'pengarang' => $request->pengarang,
                'penerbit' => $request->penerbit
            ]);

            DB::commit();

            session()->flash('flash', [
                'type' => 'success',
                'message' => 'Data berhasil disimpan'
            ]);

            return redirect()->route('admin.book.index');
        } catch (Exception $e) {
            session()->flash('flash', [
                'type' => 'danger',
                'message' => $e->getMessage()
            ]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        
        try {
            $item = Book::find($id);

            if ($item === null) {
                session()->flash('flash', [
                    'type' => 'danger',
                    'message' => 'Data tidak ditemukan'
                ]);

                return redirect()->back();
            }

            $item->delete();

            DB::commit();

            session()->flash('flash', [
                'type' => 'success',
                'message' => 'Data berhasil dihapus'
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
