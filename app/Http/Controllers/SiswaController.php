<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use DB;
use Exception;
use App\Http\Requests\SiswaRequest;
use App\User;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Siswa::paginate(10);

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
        return view('admin.siswa.create');
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

            $user = User::create([
                'name' => $request->name, 
                'username' => $request->nis, 
                'password' => $request->password,
                'is_active' => 0
            ]);

            Siswa::create([
                'nis' => $request->nis,
                'name' => $request->name,
                'generation' => $request->generation,
                'class' => $request->class,
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

        $view = [
            'item' => $item
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

            $item->update([
                'nis' => $request->nis,
                'name' => $request->name,
                'generation' => $request->generation,
                'class' => $request->class,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            $user = [
                'name' => $request->name, 
                'username' => $request->nis, 
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
    public function destroy($id)
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

            $user = User::where('username', $item->nis)->first();

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
}
