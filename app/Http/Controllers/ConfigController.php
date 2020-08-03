<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Http\Requests\ConfigRequest;
use DB;
use Validator;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Config::get();

        $view = [
            'items' => $items
        ];

        return view('admin.config.index')->with($view);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $item = Config::findOrFail($id);

        $view = [
            'item' => $item
        ];

        return view('admin.config.edit')->with($view);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConfigRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $item = Config::findOrFail($id);

            $validator = $this->validationConfig($item, $request);

            if ($validator !== null && $validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $item->update([
                'value' => $request->value,
            ]);

            DB::commit();

            session()->flash('flash', [
                'type' => 'success',
                'message' => 'Data berhasil disimpan'
            ]);

            return redirect()->route('admin.config.index');
        } catch (Exception $e) {
            session()->flash('flash', [
                'type' => 'danger',
                'message' => $e->getMessage()
            ]);
        }

        return redirect()->back();
    }

    public function validationConfig($item, $request) {
        switch ($item->name) {
            case 'denda':
                return Validator::make($request->all(), [
                    'value' => 'numeric|gte:0'   
                ], [
                    'value.numeric' => 'Isi harus berupa angka',
                    'value.gte' => 'Isi harus lebih/ sama dengan 0'
                ]);
            break;
        }

        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
