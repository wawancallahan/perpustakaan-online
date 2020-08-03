<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;
use DB;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = User::role(['petugas', 'admin', 'headmaster'])->paginate(10);

        $view = [
            'items' => $items
        ];

        return view('admin.user.index')->with($view);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();

        try {
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
                'password' => bcrypt($request->password),
                'active' => 1,
            ]);

            $user->assignRole('petugas');

            DB::commit();

            session()->flash('flash', [
                'type' => 'success',
                'message' => 'Data berhasil disimpan'
            ]);

            return redirect()->route('admin.user.index');
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
        $item = User::findOrFail($id);

        $view = [
            'item' => $item
        ];

        return view('admin.user.edit')->with($view);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $hasUsernameDuplicate = User::where('username', $request->username)->whereNotIn('id', [$id])->count() > 0;

            if ($hasUsernameDuplicate) {
                session()->flash('flash', [
                    'type' => 'danger',
                    'message' => 'Username telah ada sebelumnya'
                ]);

                return redirect()->back();
            }

            $item = User::findOrFail($id);

            $item->fill([
                'name' => $request->name,
                'username' => $request->username
            ]);

            if ($request->password !== null) {
                $item->fill([
                    'password' => bcrypt($request->password)
                ]);
            }

            $item->update();

            DB::commit();

            session()->flash('flash', [
                'type' => 'success',
                'message' => 'Data berhasil disimpan'
            ]);

            return redirect()->route('admin.user.index');
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
            if ($id == auth()->user()->id) {
                session()->flash('flash', [
                    'type' => 'danger',
                    'message' => 'Tidak dapat menghapus user sendiri'
                ]);

                return redirect()->back();
            }

            $item = User::find($id);

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
