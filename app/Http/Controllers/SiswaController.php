<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use DB;
use Exception;
use App\Http\Requests\SiswaRequest;
use App\User;
use App\Models\Kelas;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Siswa::with('kelas')->filter($request)->paginate(10);

        $view = [
            'items' => $items
        ];

        return view('admin.siswa.index')->with($view);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::get();

        $view = [
            'kelas' => $kelas
        ];

        return view('admin.siswa.create')->with($view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiswaRequest $request)
    {
        DB::beginTransaction();

        try {
            $hasNisDuplicate = Siswa::where('nis', $request->nis)->count() > 0;

            if ($hasNisDuplicate) {
                session()->flash('flash', [
                    'type' => 'danger',
                    'message' => 'NIS telah ada sebelumnya'
                ]);

                return redirect()->back();
            }

            $hasUsernameDuplicate = User::where('username', $request->username)->count() > 0;

            if ($hasUsernameDuplicate) {
                session()->flash('flash', [
                    'type' => 'danger',
                    'message' => 'Username telah ada sebelumnya'
                ]);

                return redirect()->back();
            }

            $user = User::create([
                'name' => $request->name, 
                'username' => $request->username, 
                'password' => $request->password,
                'is_active' => 0,
                'nis' => $request->nis,
            ]);

            Siswa::create([
                'nis' => $request->nis,
                'name' => $request->name,
                'kelas_id' => $request->kelas_id,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'address' => $request->address,
                'status' => 0,
                'user_id' => $user->id
            ]);

            DB::commit();

            session()->flash('flash', [
                'type' => 'success',
                'message' => 'Data berhasil disimpan'
            ]);

            return redirect()->route('admin.siswa.index');
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
        $item = Siswa::with('user')->findOrFail($id);
        $kelas = Kelas::get();

        $view = [
            'item' => $item,
            'kelas' => $kelas
        ];

        return view('admin.siswa.edit')->with($view);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SiswaRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $hasNisDuplicate = Siswa::where('nis', $request->nis)->whereNotIn('id', [$id])->count() > 0;

            if ($hasNisDuplicate) {
                session()->flash('flash', [
                    'type' => 'danger',
                    'message' => 'NIS telah ada sebelumnya'
                ]);

                return redirect()->back();
            }

            $item = Siswa::findOrFail($id);

            $hasUsernameDuplicate = User::where('username', $request->username)->whereNotIn('id', [$item->user->id])->count() > 0;

            if ($hasUsernameDuplicate) {
                session()->flash('flash', [
                    'type' => 'danger',
                    'message' => 'Username telah ada sebelumnya'
                ]);

                return redirect()->back();
            }

            $item->update([
                'nis' => $request->nis,
                'name' => $request->name,
                'kelas_id' => $request->kelas_id,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            $user = [
                'name' => $request->name, 
                'username' => $request->username,
                'nis' => $request->nis, 
            ];

            if ($request->password !== null) {
                $user['password'] = $request->password;
            }

            $item->user()->update($user);

            DB::commit();

            session()->flash('flash', [
                'type' => 'success',
                'message' => 'Data berhasil disimpan'
            ]);

            return redirect()->route('admin.siswa.index');
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
    public function destroy($id, $user_id)
    {
        DB::beginTransaction();
        
        try {
            $item = Siswa::withCount('transaction')->find($id);

            if ($item === null) {
                session()->flash('flash', [
                    'type' => 'danger',
                    'message' => 'Data tidak ditemukan'
                ]);

                return redirect()->back();
            }

            if ($item->transaction_count > 0) {
                session()->flash('flash', [
                    'type' => 'danger',
                    'message' => 'Tidak Dapat Menghapus Siswa Karena Memiliki History Peminjaman'
                ]);

                return redirect()->back();
            }

            $user = User::where('id', $user_id)->first();
            
            $item->delete();
            $user->delete();
            
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

    public function active($id)
    {
        DB::beginTransaction();
        
        try {
            $item = Siswa::find($id);

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

            $item->user()->update([
                'is_active' => 1
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

    public function unactive($id)
    {
        DB::beginTransaction();
        
        try {
            $item = Siswa::find($id);

            if ($item === null) {
                session()->flash('flash', [
                    'type' => 'danger',
                    'message' => 'Data tidak ditemukan'
                ]);

                return redirect()->back();
            }

            $item->update([
                'status' => 0
            ]);

            $item->user()->update([
                'is_active' => 0
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

    public function kartuAnggota($id)
    {
        $item = Siswa::with('kelas')->isActive()->find($id);

        if ($item === null) {
            session()->flash('flash', [
                'type' => 'danger',
                'message' => 'Data tidak ditemukan/ Belum diaktifkan'
            ]);

            return redirect()->back();
        }

        $view = [
            'item' => $item
        ];

        return view('print.kartu_anggota')->with($view);
    }
}
